/**
 * Created by JetBrains PhpStorm.
 * User: os_hatt12
 * Date: 1/4/13
 * Time: 1:36 PM
 * To change this template use File | Settings | File Templates.
 */
function Delete() {
  $(".delete_button").click(function() {
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
          container.html(data);
        }
      });
    }else return false;
    return false;
  });
};
(function Search(data){
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
        container.html(data);
      }
    });

  });
});