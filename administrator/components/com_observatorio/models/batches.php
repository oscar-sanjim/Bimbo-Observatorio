<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_observatorio
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * BatchesList Model
 *
 * @since  0.0.1
 */
class ObservatorioModelBatches extends JModelList
{
    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  An SQL query
     */
    protected function getListQuery()
    {
        // Initialize variables.
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Create the base select statement.
        $query->select('*')
            ->from($db->quoteName('#__com_observatorio_batch'))
            ->order('year, trimester ASC');

        return $query;
    }
}