/**
 * JS xu ly mutil upload image
 * @author HUNT74
 * @created on 21/08/2012
 */
(function ($) {
  $(document).ready(function () {

    var url = $('#screenshot_upload').attr('vt_href');

    $('#screenshot_upload').uploadifive({
      'auto'             : true,
      'uploadScript':       url,
      'queueID'          : 'queue',
      'formData'         : {},
      buttonText:     'Upload ảnh album',
      fileObjName:    'Filedata',
      fileSizeLimit:  5120,         // KB
      fileTypeExts:   '*.jpg;*.jpeg;*.bmp;*.gif;*.png',
      fileTypeDesc:   'Upload Files (JPG, GIF, PNG, JPEG, BMP)',
      width:          125,
      height:         18,
      removeCompleted: true,
      onUploadComplete:function (file, data) {
        var dataJson = $.parseJSON(data);

        if (dataJson.error_code == '1')
        {
          // Upload thanh cong
          $('#screenshot-list').append(dataJson.html);

        } else {
          file.queueItem.find('.fileinfo').html(' - ' + dataJson.error);
          file.queueItem.find('.fileinfo').addClass('red')
          //$('#screenshot_upload').uploadifive('cancel', file);
        }
      }
    });
  });
})(jQuery);