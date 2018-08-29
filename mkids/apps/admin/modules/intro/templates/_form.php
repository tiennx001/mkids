<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form">
  <form method="post" action="<?php echo url_for('intro/index'); ?>" class="form-horizontal form-inline">
    <div class="actions">
      <?php include_partial('intro/form_actions', array('tld_introduction' => $tld_introduction, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
    </div>
    <div style="clear:both">
      <?php echo $form->renderHiddenFields(false) ?>

      <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
      <?php endif; ?>

      <?php echo $form['body']->render(array('width' => 600, 'height' => 800));?>

    </div>
  </form>
</div>

