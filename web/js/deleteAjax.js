/**
 * Thuc thi xoa du lieu cho tung ban ghi
 * @author: os_hatt12
 * @created_at: 2/1/13
 * Time: 1:51 PM
 * To change this template use File | Settings | File Templates.
 */
(function($)
{
  $(document).ready(function(){
    // toggle booleans
    $(".delete_button").live('click',function() {
      var ok= confirm('Bạn có chắc chắn muốn xóa?');
      var url =$(".link").attr('id');
      var id = $(this).attr("id");
      var themeId= $(".link").attr('themeId');  //id cua theme gan voi ban ghi bi xoa
      var currPage=$('#page').attr('value'); //trang hien tai cua ban ghi bi xoa
      var keyword=$("#itext").val();
      var dataString ={id: id, themeId: themeId,currPage:currPage,keyword: keyword};
      var parent = $(this).parent();
      if(ok==true)
      {
        $.ajax({
          type: "POST",
          url: url,
          data: dataString,
          success: function(data)
          {
            if (data != 'error')
              jQuery("#data").html(data);
            else
              alert('Phiên làm việc không hợp lệ');
          }
        });
      }else return false;
    });
  });
})(jQuery);