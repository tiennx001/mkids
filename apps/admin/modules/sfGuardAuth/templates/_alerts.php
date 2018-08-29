<?php if ($sf_user->hasFlash('error')): ?>
    <div class="alert alert-error fade in">
      <button class="close" data-dismiss="alert" type="button">×</button>
      <?php echo __($sf_user->getFlash('error'), null, 'tmcTwitterBootstrapPlugin') ?>
    </div>
<?php endif; ?>
<?php if ($sf_user->hasFlash('notice')): ?>
    <div class="alert alert-info fade in">
      <button class="close" data-dismiss="alert" type="button">×</button>
      <?php echo __($sf_user->getFlash('notice'), null, 'tmcTwitterBootstrapPlugin') ?>
    </div>
<?php endif; ?>