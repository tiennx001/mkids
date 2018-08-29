/**
 * Created with JetBrains PhpStorm.
 * User: pmdv_namdt5
 * hatt12 modify
 * Date: 1/4/13
 * Time: 2:26 PM
 * To change this template use File | Settings | File Templates.
 */
(function ($) {
  $(document).ready(function () {

    // toggle booleans
    $('td.sf_admin_text a').click(function () {
      // $(this).toggleClass('s16_tick s16_cross');
      var url = $(this).attr('vt_href');
      var self = $(this);
      if (self.hasClass('clicked'))
        return false;
      // Danh dau la da click
      self.addClass('clicked');

      $.post(
        url,
        {
          field:self.parent().attr('field'),
          pk:self.parent().parent().attr('rel'),
          _csrf_token:$('input[id="vt_theme_filters__csrf_token"]').val()
        },
        function (data) {
          if (data != 'csrf') {
            $('td.sf_admin_text a#show').removeClass();
            $('td.sf_admin_text a#show').addClass('icon-remove _cross');
            self.toggleClass('icon-ok', '1' == data).toggleClass('icon-remove', '0' == data);
          } else {
            // revert
//            self.toggleClass('icon-ok icon-remove');
          }
          // Bo danh dau click --> luc nay co the click tiep
          self.removeClass('clicked');
          return false;
        }
      );
    });
  });
})(jQuery);
