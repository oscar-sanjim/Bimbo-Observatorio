<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * HelloWorld Model
 *
 * @since  0.0.1
 */
class ObservatorioModelDashboard extends JModelItem
{


    /**
     * Retireves all the distinct organizations.
     * @return mixed
     */
    public function getOrganizations(){

        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('DISTINCT(r.organizacion)');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return $results;

    }

    /**
     * Retrieves the different options of years
     * @return mixed
     */
    public function getDatesData(){

        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('year');
        $query->from($db->quoteName('#__com_observatorio_batch'));
        $query->group(array($db->quoteName('year'), $db->quoteName('trimester')));
        $query->order('year ASC');


        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return $results;

    }


    public function getLastRecordsDates(){

        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('year, trimester');
        $query->from($db->quoteName('#__com_observatorio_batch'));
        $query->group(array($db->quoteName('year'), $db->quoteName('trimester')));
        $query->order('year DESC, trimester DESC');


        // Reset the query using our newly populated query object.
        $db->setQuery($query, 0, 1);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObject();

        return $results;
    }


    /**
     * Groups the general data of collaborators
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @return mixed
     */
    public function groupGenericNumericValues($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations)
    {
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('SUM(r.total_poblacion) as total, SUM(r.poblacion_en_riesgo) as total_risk');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObject();

        return $results;

    }


    /**
     * Groups the general data by Morbility. Beacuse the name of the morbility might me present in multiple columns, we need to iterate once per column.
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @return mixed
     */
    public function groupByMorbility($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations)
    {
        $data = array();
        for ($counter = 1; $counter <= 5; $counter++) {
            switch ($counter) {
                case  1:
                    $number_name = "uno";
                    break;

                case  2:
                    $number_name = "dos";
                    break;

                case  3:
                    $number_name = "tres";
                    break;

                case  4:
                    $number_name = "cuatro";
                    break;

                case  5:
                    $number_name = "cinco";
                    break;

                default:
                    continue;
            }

            // Get a db connection.
            $db = JFactory::getDbo();

            // Create a new query object.
            $query = $db->getQuery(true);


            // Select all records from the user profile table where key begins with "custom.".
            // Order it by the ordering field.
            $query->select(
                array(
                    'morbilidad_' . $number_name . '_alias as morbilidad_alias', 'SUM(r.morbilidad_' . $number_name . '_colaboradores) as morbilidad_total',

                )
            );
            $query->from($db->quoteName('#__com_observatorio_records', 'r'));
            $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
            $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
            $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

            $query->group($db->quoteName('morbilidad_uno_alias'));

            if($organizations != ""){
                $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
            }

            // Reset the query using our newly populated query object.
            $db->setQuery($query);

            // Load the results as a list of stdClass objects (see later for more options on retrieving data).
            $results = $db->loadObjectList();

            array_push($data, $results);
        }


        return $data;

    }


    /**
     * Retrieves data of the collaborators grouped by medical attention type.
     */
    public function getCollaboratorsUnderMedicalAttention($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){

        //echo $organizations; die;
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('SUM(r.total_poblacion) as total_collaborators, SUM(r.poblacion_en_riesgo) as total_risk, SUM(r.atencion_con_red_colaboradores) as red_coaboradores, SUM(atencion_programas_generales_colaboradores) as programas_generales_colaboradores');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        //echo($query->__toString());die;

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObject();

        return $results;

    }


    /**
     * Retrieves the compliance level by organization and by period of time
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @param $organizations
     * @return mixed
     */
    public function getComplianceLevelsByOrganization($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('r.organizacion, r.nivel_cumplimiento, b.year, b. trimester');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        $query->order('year ASC, trimester ASC');

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return $results;
    }




    /**
     * Retrieves the compliance level by organization and by period of time
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @param $organizations
     * @return mixed
     */
    public function getLeadersAndCollaboratorsTraining($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);

        // Order it by the ordering field.
        $query->select('r.organizacion, r.pais, r.capacitacion_lideres_terminado, r.capacitacion_colaboradores_terminado, b.year, b. trimester');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        $query->order('year ASC, trimester ASC');

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return $results;
    }


    /**
     * Retrieves the compliance level by organization and by period of time
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @param $organizations
     * @return mixed
     */
    public function getLeadersAndCollaboratorsTrainingByCountry($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);

        // Order it by the ordering field.
        $query->select('r.pais, SUM(r.capacitacion_lideres_terminado) as capacitacion_lideres_terminado, SUM(r.capacitacion_colaboradores_terminado) as capacitacion_colaboradores_terminado, b.year, b. trimester');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        $query->group(array($db->quoteName('r.pais'), $db->quoteName('b.year'), $db->quoteName('b.trimester')));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        $query->order('year ASC, trimester ASC');

        //echo($query->__toString());die;


        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return $results;
    }


    /**
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @param $organizations
     * @return mixed
     */
    public function getLeadersTrainingPercentage($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('SUM(r.capacitacion_lideres_terminado) as lideres_terminados, SUM(r.capacitacion_lideres_objetivo) as lideres_objetivo');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        $query->order('year ASC, trimester ASC');

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObject();

        return $results;
    }


    /**
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @param $organizations
     * @return mixed
     */
    public function getCollaboratorsTrainingPercentage($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('SUM(r.capacitacion_colaboradores_terminado) as colaboradores_terminados, SUM(r.capacitacion_colaboradores_objetivo) as colaboradores_objetivo');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        $query->order('year ASC, trimester ASC');

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObject();

        return $results;
    }



    /**
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @param $organizations
     * @return mixed
     */
    public function getSurveysData($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('r.encuesta_salud, r.encuesta_gestion_energia, r.encuesta_bienestar, r.encuesta_programas_empresa,  r.organizacion, b.year, b. trimester');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        $query->order('year ASC, trimester ASC');

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return $results;
    }


    /**
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @param $organizations
     * @return mixed
     */
    public function getSurveysDataByCountry($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('r.pais, b.year, b.trimester, SUM(r.encuesta_salud) as encuesta_salud, SUM(r.encuesta_gestion_energia) as encuesta_gestion_energia,  SUM(r.encuesta_bienestar) as encuesta_bienestar, SUM(r.encuesta_programas_empresa) as encuesta_programas_empresa');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        $query->group(array($db->quoteName('r.pais'), $db->quoteName('b.year'), $db->quoteName('b.trimester')));

        $query->order('year ASC, trimester ASC');

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        //echo($query->__toString()); die;

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return $results;
    }



    /**
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @param $organizations
     * @return mixed
     */
    public function getAbsentsByOrganizationAndDate($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('r.dias_ausentismo, r.organizacion, b.year, b. trimester');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        $query->order('year ASC, trimester ASC');

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return $results;
    }


    /**
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @param $organizations
     * @return mixed
     */
    public function getAbsentsByCountryAndDate($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('SUM(r.dias_ausentismo) as dias_ausentismo, r.pais, b.year, b. trimester');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        $query->group(array($db->quoteName('r.pais'), $db->quoteName('b.year'), $db->quoteName('b.trimester')));

        $query->order('year ASC, trimester ASC');

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return $results;
    }


    /**
     * @param $intialTrim
     * @param $finalTrim
     * @param $intialYear
     * @param $finalYear
     * @param $organizations
     * @return mixed
     */
    public function getPercentageByAbsentType($intialTrim, $finalTrim, $intialYear, $finalYear, $organizations){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('SUM(r.dias_ausentismo_enfermedades_generales) as type_general, SUM(r.dias_ausentismo_enfermedades_prevenibles) as type_preventable, SUM(r.dias_ausentismo_enfermedades_mentales) as type_mental');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) . ' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) . ' AND ' . 'b.year <= ' . $db->quote($finalYear));

        if($organizations != ""){
            $query->where($db->quoteName('r.organizacion') . ' IN (' . $organizations . ')');
        }

        $query->order('year ASC, trimester ASC');

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObject();

        return $results;
    }
}