<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// Requiring the constants file.
require_once __DIR__ . "/../../../libs/constants.php";
?>
<form action="index.php?option=com_observatorio&view=batches" method="post" id="adminForm" name="adminForm">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th width="1%"><?php echo 'No.'; ?></th>

            <th width="2%">
                <?php echo JHtml::_('grid.checkall'); ?>
            </th>

            <th width="14%" class="center">
                <?php echo 'Año'; ?>
            </th>
            <th width="14%" class="center">
                <?php echo 'Trimestre'; ?>
            </th>
            <th width="16%" class="center">
                <?php echo 'Registros Totales'; ?>
            </th>
            <th width="16%" class="center">
                <?php echo 'Fecha de Registro'; ?>
            </th>
            <th width="16%">
                <?php echo 'Archivo'; ?>
            </th>
            <th width="16%">
                <?php echo 'Registros'; ?>
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="5">
                <?php echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php if (!empty($this->items)) : ?>
            <?php foreach ($this->items as $i => $row) :
                $link = JRoute::_('index.php?option=com_observatorio&task=batch.edit&id=' . $row->id);
                ?>

                <tr>
                    <td>
                        <?php echo $this->pagination->getRowOffset($i); ?>
                    </td>

                    <td>
                        <?php echo JHtml::_('grid.id', $i, $row->id); ?>
                    </td>

                    <td class="center">
                        <?php echo $row->year; ?>
                    </td>
                    <td class="center">
                        <?php echo Constants::TRIMESTERS_DICTIONARY[$row->trimester]; ?>
                    </td>
                    <td class="center">
                        <?php echo $row->total_records; ?>
                    </td>
                    <td class="center">
                        <?php echo $row->register_datetime; ?>
                    </td>
                    <td>
                        <?php
                        $exploded = explode("/administrator/", $row->file_path);
                        $plublicLink = $exploded[1];

                        ?>
                        <a href="<?php echo JURI::base() . $plublicLink;?>">
                            Descargar
                        </a>
                    </td>

                    <td>
                        <?php
                        $linkToRecords = JURI::base() . "?option=com_observatorio&view=records&batch=".$row->id;

                        ?>
                        <a href="<?php echo $linkToRecords;?>">
                            Registros
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>


    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <?php echo JHtml::_('form.token'); ?>
</form>