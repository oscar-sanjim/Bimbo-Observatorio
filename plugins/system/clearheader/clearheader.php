<?php
class plgSystemClearHeader extends JPlugin
{
    public function onBeforeCompileHead()
    {

        // Application Object
        $app = JFactory::getApplication();

        // Front only
        if( $app instanceof JApplicationSite )
        {
            $document            = JFactory::getDocument();
            // Remove default bootstrap
            // Excluding Joomla out of the box scripts to include newer versions.
            $dontInclude = array(
                //JURI::root(true).'/media/jui/js/jquery.js',
                JURI::root(true).'/media/jui/js/jquery.min.js',
                JURI::root(true).'/media/jui/js/jquery-noconflict.js',
                JURI::root(true).'/media/system/js/core.js',
                JURI::root(true).'/media/jui/js/jquery-migrate.js',
                JURI::root(true).'/media/jui/js/jquery-migrate.min.js',
                JURI::root(true).'/media/jui/js/bootstrap.min.js',
                JURI::root(true).'/media/system/js/core-uncompressed.js',
                JURI::root(true).'/media/system/js/tabs-state.js',
                JURI::root(true).'/media/system/js/mootools-core.js',
                JURI::root(true).'/media/system/js/mootools-core-uncompressed.js',
                JURI::root(true).'/media/jui/js/chosen.jquery.min.js',
                JURI::root(true).'/media/system/js/caption.js'
            );
            


            foreach($document->_scripts as $key => $script){
                if(in_array($key, $dontInclude)){
                    unset($document->_scripts[$key]);
                }
            }

        }
    }
}
?>