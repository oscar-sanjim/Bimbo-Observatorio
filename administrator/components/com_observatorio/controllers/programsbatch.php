<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../libs/constants.php";
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HelloWorld Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @since       0.0.9
 */
class ObservatorioControllerProgramsBatch extends JControllerForm
{

    /**
     * Process the provided file.
     * @param $filepPath
     * @return stdClass
     */
    private function processCSVFile($filepPath)
    {

        $db = JFactory::getDbo();       // DB Object.

        try {
            $db->transactionStart();
            $query = $db->getQuery(true);
            $uuid = uniqid();

            $columns = array();
            $values = array();
            foreach (Constants::CSVCOLUMNS_PROGRAMS as $key => $value) {
                //$temporalObject->{$key} = $data[Constants::CSVCOLUMNS['total_poblacion']];
                array_push($columns, $key);

            }
            array_push($columns, 'temporal_group_uuid');

            $row = 0;
            if (($handle = fopen($filepPath, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                    $row++;

                    $totalFieldsInRow = count($data);

                    for ($c = 0; $c < $totalFieldsInRow; $c++) {

                        // TODO: Check if row is empty to ignore it.

                    }

                    // Creating temporal object with the definitions of the columns
                    //$temporalObject = new stdClass();

                    $rowsValues = array();
                    foreach (Constants::CSVCOLUMNS_PROGRAMS as $key => $value) {
                        array_push($rowsValues, $db->quote($data[Constants::CSVCOLUMNS_PROGRAMS[$key]]));

                    }
                    array_push($rowsValues, $db->quote($uuid));
                    $values[] = implode(',', $rowsValues);


                }
                fclose($handle);
            }


            $query->insert($db->quoteName('#__com_observatorio_program_records'));
            $query->columns($db->quoteName($columns));
            $query->values($values);


            $db->setQuery($query);
            $result = $db->execute();

            $db->transactionCommit();

            $response = new stdClass();
            $response->result = true;
            $response->totalRows = $row;
            $response->batchUuid = $uuid;


        } catch (Exception $e) {
            // catch any database errors.
            $db->transactionRollback();
            JErrorPage::render($e);

            $response = new stdClass();
            $response->result = false;

        }

        return $response;
    }


    private function updateRecordsBatchId($batchUUID){
        // Getting the if of the batch record.
        $db = JFactory::getDbo();
        $query = $db
            ->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__com_observatorio_program_batch'))
            ->where($db->quoteName('uuid') . " = " . $db->quote($batchUUID));

        $db->setQuery($query);
        $batch = $db->loadObject();


        // Updating the new records foreign key value.
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        // Fields to update.
        $fields = array(
            $db->quoteName('batch') . ' = ' . $db->quote($batch->id)

        );

        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('temporal_group_uuid') . ' = ' . $db->quote($batchUUID)

        );

        $query->update($db->quoteName('#__com_observatorio_program_records'))->set($fields)->where($conditions);

        $db->setQuery($query);

        $result = $db->execute();

        return;

    }

    /**
     * Deletes previous versions of the matching batch.
     * @param $trimester
     * @param $year
     */
    private function deletePreviousBatches($trimester, $year)
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        // delete all custom keys for user 1001.
        $conditions = array(
            $db->quoteName('trimester') . ' = ' . $db->quote($trimester),
            $db->quoteName('year') . ' = ' . $db->quote($year)
        );

        $query->delete($db->quoteName('#__com_observatorio_program_batch'));
        $query->where($conditions);

        $db->setQuery($query);

        $result = $db->execute();
    }


    /**
     * Overriding the function ob object save.
     * @param null $key
     * @param null $urlVar
     * @return bool
     */
    function save($key = NULL, $urlVar = NULL)
    {
        // Get a handle to the Joomla! application object
        $application = JFactory::getApplication();
        $formData = JFactory::getApplication()->input->get('jform', array(), 'ARRAY');

        $file = JFactory::getApplication()->input->files->get('jform');

        $filename = time();
        $ext = JFile::getExt($file['file_upload']['name']);
        $src = $file['file_upload']['tmp_name'];
        $dest = JPath::clean(JPATH_COMPONENT . "/uploads/" . $filename . "." . $ext);


        if (JFile::upload($src, $dest) == false) {
            // The file couldn't be uploaded.
            $application->enqueueMessage('El archivo no pudo ser cargado. Verifique permisos de folder.', 'error');
            return false;

        }


        $formData['file_path'] = $dest;

        // Processing the file.
        $response = $this->processCSVFile($formData['file_path']);

        if ($response->result == true) {

            $this->deletePreviousBatches($formData['trimester'], $formData['year']);

            // Assigning the file path value and updating the POST data.
            $formData['total_records'] = (int)$response->totalRows;
            $formData['uuid'] = $response->batchUuid;

            date_default_timezone_set("America/Mexico_City");
            $formData['register_datetime'] = date('Y-m-d H:i:s');



            JFactory::getApplication()->input->post->set('jform', $formData);

            $saveResult = parent::save($formData);

            $this->updateRecordsBatchId($response->batchUuid);


        } else {
            return false;

        }
    }
}