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
 * Hello World Component Controller
 *
 * @since  0.0.1
 */
class ObservatorioController extends JControllerLegacy
{

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
}


