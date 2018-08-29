/**
 * Ham thuc hien chuc nang search giao dien dung trong phan list trong edit module VtManageTheme phan he admin
 * User: os_hatt12
 * Date: 1/4/13
 * Time: 1:36 PM
 * To change this template use File | Settings | File Templates.
 */
(function($)
{
  $(document).ready(function(){
    // toggle booleans
      $("a#search").click(function(){
        var value=$("#itext").val();
        var url=$("#texturl").val();
        var id= $(".idhidden").attr('id');
        var dataString={id: id,value: value}
        $.ajax({
          type: "POST",
          url: url,
          data: dataString,
          dataType: 'html',
          success:function(data)
          {
             jQuery("#data").html(data);
          }
        });

      });
  });
})(jQuery);