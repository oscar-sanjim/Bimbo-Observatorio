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

require_once __DIR__ . '/libs/graphs.php';
/**
 * Hello World Component Controller
 *
 * @since  0.0.1
 */
class ObservatorioController extends JControllerLegacy
{

    /**
     * Creates an user session.
     */
    public function loginUser()
    {
        $username = $_POST["email"];
        $password = $_POST["password"];

        $app = JFactory::getApplication();
        $credentials = array();
        $credentials['username'] = $username;
        $credentials['password'] = $password;

        if ($app->login($credentials) == false) {
            // Login failed !
            $app->redirect(JRoute::_('index.php?result=false', false));

        }else{
            $app->redirect(JRoute::_('index.php?result=true', false));

        }
    }



    /**
     * Destroys the user session.
     */
    public function logOutUser()
    {
        // Check if the user is logged in already.
        $app = JFactory::getApplication();
        $user = JFactory::getUser();

        if($user->id) {
            $app = JFactory::getApplication();
            $app->logout($user->id, array());

        }

        $app->redirect(JURI::base());
        die;
    }



    /**
     * Main entry point to get the data.
     */
    public function getGraphData(){
        $graphName = $_GET['graph'];
        $intialTrim = $_GET['intialTrimester'];
        $finalTrim = $_GET['finalTrimester'];
        $intialYear = $_GET['intialYear'];
        $finalYear = $_GET['finalYear'];

        $model = $this->getModel('Dashboard');

        $graphManager = new Graphs($model, $intialTrim, $finalTrim, $intialYear, $finalYear);

        $data = array();
        switch ($graphName){
            case 'total_colaborators_in_risk':
                $data = $graphManager->getColaboratorsInRisk();
                break;
        }

        echo json_encode($data);
        die;
    }
}


