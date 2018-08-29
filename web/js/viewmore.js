/**
 * Created with JetBrains PhpStorm.
 * User: anhbhv
 * Date: 08/1/2013
 * Time: 10:35 AM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function() {
    var showChar = 120;
    var ellipsestext = "...";
    var moretext = "Xem thêm";
    var lesstext = "Rút gọn";
    $('.sf_admin_list_td_description').each(function() {
        var content = $(this).html();

        if(content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});

