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

            <th class="center">Organización</th>

            <th class="center">País</th>

            <th class="center">Población</th>

            <th class="center">Población en Riesgo</th>

            <th class="center">Morbilidad 1</th>

            <th class="center">Morbilidad 1 Colaboradores</th>

            <th class="center">Morbilidad 2</th>

            <th class="center">Morbilidad 2 Colaboradores</th>

            <th class="center">Morbilidad 3</th>

            <th class="center">Morbilidad 3 Colaboradores</th>

            <th class="center">Morbilidad 4</th>

            <th class="center">Morbilidad 4 Colaboradores</th>

            <th class="center">Morbilidad 5</th>

            <th class="center">Morbilidad 5 Colaboradores</th>

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

                    <td class="left">
                        <?php echo $row->organizacion; ?>
                    </td>

                    <td class="left">
                        <?php echo $row->pais; ?>
                    </td>

                    <td class="center">
                        <?php echo $row->total_poblacion; ?>
                    </td>
                    <td class="center">
                        <?php echo $row->poblacion_en_riesgo; ?>
                    </td>

                    <!-- Morbilidades -->
                    <td class="">
                        <?php echo $row->morbilidad_uno_alias; ?>
                    </td>
                    <td class="center">
                        <?php echo $row->morbilidad_uno_colaboradores; ?>
                    </td>

                    <td class="">
                        <?php echo $row->morbilidad_dos_alias; ?>
                    </td>
                    <td class="center">
                        <?php echo $row->morbilidad_dos_colaboradores; ?>
                    </td>

                    <td class="">
                        <?php echo $row->morbilidad_tres_alias; ?>
                    </td>
                    <td class="center">
                        <?php echo $row->morbilidad_tres_colaboradores; ?>
                    </td>


                    <td class="">
                        <?php echo $row->morbilidad_cuatro_alias; ?>
                    </td>
                    <td class="center">
                        <?php echo $row->morbilidad_cuatro_colaboradores; ?>
                    </td>

                    <td class="">
                        <?php echo $row->morbilidad_cinco_alias; ?>
                    </td>
                    <td class="center">
                        <?php echo $row->morbilidad_cinco_colaboradores; ?>
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