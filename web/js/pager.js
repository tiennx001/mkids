/**
 * Created by JetBrains PhpStorm.
 * User: os_hatt12
 * Date: 1/17/13
 * Time: 1:09 PM
 * To change this template use File | Settings | File Templates.
 */
function loadPage(page) {
  var url =$('.idhidden').attr('actionUrl');
  var keyword=$("#itext").val();
  var id= $('.idhidden').attr('themeId');
  var dataString={id: id, keyword: keyword} ;
  $.ajax({
    url:url + "?page=" + page,
    type:'POST',
    dataType:'html',
    timeout:4000,
    data: dataString,
    error:function (xhr, textStatus, errorThrown) {
      msg = "Error " + errorThrown;
      alert(msg);
    },
    success:function (data) {
      jQuery("#data").html(data);
    }
  });
};


