<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pmdv_namdt5
 * Date: 4/19/13
 * Time: 8:33 AM
 * To change this template use File | Settings | File Templates.
 */

?>
<div class="control-group sf_admin_form_row sf_admin_text sf_admin_form_field_name">

  <label class="control-label" for="sf_guard_group_name" style="height: 20px;"><?php echo __('Tên nhóm người dùng');?> *</label>
  <div class="controls">
    <div class="field-content" style="margin-top: 3px;">
      <?php echo $sf_guard_group->getName(); ?>
    </div>
  </div>
</div>