<div class=" pull-left margin-right">

  <div class="btn-group">
<!--	  --><?php //if ($sf_user->hasCredential('adminUser')||($sf_user->hasCredential('admin'))) :?>
<!--	    <button onclick="$(this).addClass('clicked')" type="submit" class="btn btn-danger" name="batch_action" value="batchDelete"-->
<!--	            id="batchDelete">--><?php //echo __('Xóa', array(), 'messages') ?><!--</button>-->
<!---->
<!--	  --><?php //endif;?>
        <button onclick="$(this).addClass('clicked')" type="submit" class="btn btn-success" name="batch_action"
                value="batchDeactive"><?php echo __('Khóa', array(), 'messages') ?></button>
        <button onclick="$(this).addClass('clicked')" type="submit" class="btn btn-success" name="batch_action"
                value="batchActive"><?php echo __('Mở khóa', array(), 'messages') ?></button>
    </div>
  <?php $form = new BaseForm(); if ($form->isCSRFProtected()): ?>
    <input type="hidden" name="<?php echo $form->getCSRFFieldName() ?>" value="<?php echo $form->getCSRFToken() ?>"/>
  <?php endif; ?>
</div>
<?php $message = __('Bạn có chắc muốn xóa không?') ?>
<script type="text/javascript">
  $(document).ready(function () {

    $('form#list-form').submit(function (e) {
      var input = $(".clicked[type=submit]", $(this));
      input.removeClass('clicked');

      if (input.size())
      {
        if ($('.sf_admin_batch_checkbox:checked').size()) {
          if (input.attr('id') == "batchDelete") {
            var ok = confirm('<?php echo $message ?>');
            if (ok) {
              return true;
            }
            else {
              e.preventDefault();
              return false;
            }
          }
        } else {
          alert('<?php echo __('You must at least select one item.');?>');
          e.preventDefault();
          return false;
        }
      }

    });
    return;
  });
</script>
