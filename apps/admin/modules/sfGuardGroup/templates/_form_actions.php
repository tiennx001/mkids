<div class="btn-toolbar">
  <?php if ($form->isNew()): ?>


    <div class="btn-group">
      <?php echo $helper->linkToList(array('label' => 'Quay trở lại danh sách', 'params' => array(), 'class_suffix' => 'list',)) ?>
    </div>

    <div class="btn-group">
      <?php echo $helper->linkToSave($form->getObject(), array('label' => 'Lưu', 'params' => array(), 'class_suffix' => 'save',)) ?>
      <?php echo $helper->linkToSaveAndExit($form->getObject(), array('params' => array(), 'class_suffix' => 'save_and_exit', 'label' => 'Save and exit',)) ?>
    </div>


  <?php else: ?>
    <div class="btn-group">
      <?php echo $helper->linkToList(array('label' => 'Quay trở lại danh sách', 'params' => array(), 'class_suffix' => 'list',)) ?>
    </div>
    <div class="btn-group">
      <?php echo $helper->linkToDelete($form->getObject(), array('label' => 'Xóa', 'params' => array(), 'confirm' => 'Are you sure?', 'class_suffix' => 'delete',)) ?>
    </div>
    <div class="btn-group">
      <?php echo $helper->linkToSave($form->getObject(), array('label' => 'Lưu', 'params' => array(), 'class_suffix' => 'save',)) ?>
      <?php echo $helper->linkToSaveAndExit($form->getObject(), array('params' => array(), 'class_suffix' => 'save_and_exit', 'label' => 'Save and exit',)) ?>
    </div>
    <div class="btn-group">
      <?php echo $helper->linkToNew(array('params' => array(), 'class_suffix' => 'new', 'label' => __('Thêm nhóm mới'),)) ?>
    </div>

  <?php endif; ?>
</div>