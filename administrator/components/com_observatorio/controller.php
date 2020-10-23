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
 * General Controller of HelloWorld component
 *
 * @package     Joomla.Administrator
 * @subpackage  com_observatorio
 * @since       0.0.7
 */
class ObservatorioController extends JControllerLegacy
{
    /**
     * The default view for the display method.
     *
     * @var string
     * @since 12.2
     */
    protected $default_view = 'batches';

    function checkIfTrimesterExists(){

        $year = $_GET['year'];
        $trimester = $_GET['trimester'];

        $model = $this->getModel('batch');
        $result = $model->checkIfTrimesterExists($trimester, $year);

        if($result){
            $response = array(
                "status" => true
            );

        }else{
            $response = array(
                "status" => false
            );
        }

        echo json_encode($response);
        die;
    }

    function checkIfProgramsTrimesterExists(){

        $year = $_GET['year'];
        $trimester = $_GET['trimester'];

        $model = $this->getModel('programsbatch');
        $result = $model->checkIfTrimesterExists($trimester, $year);

        if($result){
            $response = array(
                "status" => true
            );

        }else{
            $response = array(
                "status" => false
            );
        }

        echo json_encode($response);
        die;
    }
}