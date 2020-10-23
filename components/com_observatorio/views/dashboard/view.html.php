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
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class ObservatorioViewDashboard extends JViewLegacy
{
    /**
     * Display the Hello World view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    function display($tpl = null)
    {
        // Check if the user is logged in already.
        $user = JFactory::getUser();

        if(!$user->id) {
            $app = JFactory::getApplication();
            $app->redirect(JRoute::_(JURI::base(), false));
        }

        // Getting the user data.
        $customFields = FieldsHelper::getFields('com_users.user', JFactory::getUser(), false);
        $this->userCountry = "";
        foreach ($customFields as $field) {
            if ($field->name == "country") {
                $this->userCountry = $field->value;

            }
        }


        $model = $this->getModel();

        $this->organizations = $model->getOrganizations($this->userCountry);
        $this->datesData = $this->get('DatesData');
        $this->lastRecordDate = $this->get('LastRecordsDates');



        // Display the view
        parent::display($tpl);
    }
}