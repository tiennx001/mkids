<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="row-fluid">
    <div class="span9" style="width: 134%;">

        <div class="control-group">
          <?php if ($form->hasGlobalErrors()): ?>
          <?php echo $form->renderGlobalErrors() ?>
          <?php endif; ?>

            <form action="<?php echo url_for('sf_guard_user_collection', array('action' => 'filter')) ?>" method="post">
                <div class="span11" style="margin-left:0px ! important; ">
                  <?php echo $form->renderHiddenFields() ?>
                  <?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?>
                  <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
                  <?php include_partial('sfGuardUser/filters_field', array(
                    'name' => $name,
                    'attributes' => $field->getConfig('attributes', array()),
                    'label' => $field->getConfig('label'),
                    'help' => $field->getConfig('help'),
                    'form' => $form,
                    'field' => $field,
                    'class' => 'sf_admin_form_row sf_admin_' . strtolower($field->getType()) . ' sf_admin_filter_field_' . $name, 'filter_text'
                  )) ?>
                  <?php endforeach; ?>
                </div>
                <div style="width: 100%; float: right; text-align: right;">
                    <input class="btn" type="submit"
                           value="<?php echo __('Filter', array(), 'tmcTwitterBootstrapPlugin') ?>"/>
                  <?php echo link_to('<i class="icon-remove icon-black"></i> ' . __('Reset filter', array(), 'tmcTwitterBootstrapPlugin'), 'sf_guard_user_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post', 'class' => 'btn')) ?></li>
                </div>

            </form>
        </div>
    </div>
</div>
