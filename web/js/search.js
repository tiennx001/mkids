/**
 * Created with JetBrains PhpStorm.
 * User: pmdv_namdt5
 * Date: 1/4/13
 * Time: 2:26 PM
 * To change this template use File | Settings | File Templates.
 */
(function($)
{
  $(document).ready(function(){
    // toggle booleans
    $('#search-pagging a').click(function() {
      $('#search_current_page').val($(this).attr('page'));
      $('#search-form').submit();

    });
  });
})(jQuery);
