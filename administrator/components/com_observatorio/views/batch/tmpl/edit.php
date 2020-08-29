<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

?>
<form action="<?php echo JRoute::_('index.php?option=com_observatorio&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="adminForm"  enctype="multipart/form-data">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo "Datos de la carga"; ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php
                    foreach($this->form->getFieldset() as $field) {
                        echo $field->renderField();
                    }
                    ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="batch.edit" />
    <input type="hidden" id="host" name="host" value="<?php echo JURI::base(); ?>" />
    <?php echo JHtml::_('form.token'); ?>
</form>