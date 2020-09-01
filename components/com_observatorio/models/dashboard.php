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

/**
 * HelloWorld Model
 *
 * @since  0.0.1
 */
class ObservatorioModelDashboard extends JModelItem
{
    public function groupGenericNumericValues($intialTrim, $finalTrim, $intialYear, $finalYear){
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);

        $columns = array(
            'SUM(r.total_poblacion)'
        );

        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select('SUM(r.total_poblacion) as total, SUM(r.poblacion_en_riesgo) as total_risk');
        $query->from($db->quoteName('#__com_observatorio_records', 'r'));
        $query->join('INNER', $db->quoteName('#__com_observatorio_batch', 'b') . ' ON ' . $db->quoteName('r.batch') . ' = ' . $db->quoteName('b.id'));
        $query->where($db->quoteName('b.trimester') . ' >= ' . $db->quote($intialTrim) .' AND ' . 'b.year >= ' . $db->quote($intialYear));
        $query->where($db->quoteName('b.trimester') . ' <= ' . $db->quote($finalTrim) .' AND ' . 'b.year <= ' . $db->quote($finalYear));

        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObject();

        return $results;

    }
}