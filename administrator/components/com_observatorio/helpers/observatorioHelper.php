<?php
class ObservatorioHelper extends JHelperContent
{
    public static function addSubMenu($vName)
    {
        JHtmlSidebar::addEntry(
            JText::_('Métricas'),
            'index.php?option=com_observatorio&view=batches',
            $vName == 'batches'
        );

        JHtmlSidebar::addEntry(
            JText::_('Programas Bienestar'),
            'index.php?option=com_observatorio&view=programsbatches',
            $vName == 'programsbatches'
        );

    }
}