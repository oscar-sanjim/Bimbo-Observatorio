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
 * HelloWorld View
 *
 * @since  0.0.1
 */
class ObservatorioViewProgramsBatch extends JViewLegacy
{
    /**
     * Batch form
     *
     * @var         form
     */
    protected $form = null;

    /**
     * Display the Batch view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        // Get the Data
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');


        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));

            return false;
        }


        // Set the toolbar
        $this->addToolBar();

        // Display the template
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolBar()
    {
        $input = JFactory::getApplication()->input;

        // Hide Joomla Administrator Main menu
        $input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);

        if ($isNew)
        {
            $title = "Nueva carga";
        }
        else
        {
            $title = "Editar carga";
        }

        JToolbarHelper::title($title, 'programsbatch');
        JToolbarHelper::save('programsbatch.save');
        JToolbarHelper::cancel(
            'programsbatch.cancel',
            $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE'
        );

        // Set the document
        $this->setDocument();
    }

    protected function setDocument()
    {

        JHtml::_('behavior.framework');
        JHtml::_('behavior.formvalidator');


        $document = JFactory::getDocument();
        $document->addScript(JURI::root() . "/administrator/components/com_observatorio"
            . "/views/programsbatch/programsbatch.js");
        JText::script('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE');
    }
}