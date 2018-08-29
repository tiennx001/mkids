<?php if($sf_user->hasCredential('adminUser') || ($sf_user->hasCredential('admin'))) : ?>
	<div class="btn-group">
		<?php echo $helper->linkToNew(array('label' => 'Thêm người dùng', 'params' => array(), 'class_suffix' => 'new',)) ?>
	</div>
<?php endif; ?>