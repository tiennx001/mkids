function encodeOutput(s){
  result = $('<div/>').text(s).html();
  return result;
//    if(s != null && s.length>0){
//        en = false;
//        // do we convert to numerical or html entity?
//        if(en){
//            s = s.replace(/\'/g,"&#39;"); //no HTML equivalent as &apos is not cross browser supported
//            s = s.replace(/\"/g,"&quot;");
//            s = s.replace(/</g,"&lt;");
//            s = s.replace(/>/g,"&gt;");
//        }else{
//            s = s.replace(/\'/g,"&#39;"); //no HTML equivalent as &apos is not cross browser supported
//            s = s.replace(/\"/g,"&#34;");
//            s = s.replace(/</g,"&#60;");
//            s = s.replace(/>/g,"&#62;");
//        }
//        return s;
//    }else{
//        return "";
//    }
}

function ToggleAllByClassName(className) {
  var position = className.indexOf("_");	
  var field = className.substr(position + 1, className.length);
  var typeRelationType = $("#vtModal_Relation_Type_" + field).val(); //type Relate: ONE2ONE, ONE2MANY, FIELD

  var statusCheckAllbox = $(".vtTableCheckbox_" + field + "_main").is(':checked');
  //check if main checkbox (check all) is checked or not

  if(typeRelationType=="ONE2MANY"){
      $("#"+field + " option").each(function () {
          this.selected = statusCheckAllbox;
      });
  }else if(typeRelationType=="FIELD"){
      var ids = "";
      if(statusCheckAllbox==true){
          $(".vtTableCheckbox_" + field).each( function() {
                  ids = ids + this.value + ",";
          })
          if(ids.length>0){
              ids = ids.substring(0, ids.length-1)
          }
      }
      $("#"+field).val(ids);
  }

  $(".vtTableCheckbox_" + field).each( function() {
     $(this).attr("checked", statusCheckAllbox);
  })

}

function ToggleByClassName(className) {
  var position = className.lastIndexOf("_");
  var length = className.length;
  var field = className.substr(0, position);
  var id = className.substr(position + 1, length - position - 1);
  var typeRelationType = $("#vtModal_Relation_Type_" + field).val(); //type Relate: ONE2ONE, ONE2MANY, FIELD

  var statusCheckbox = $("#" + className).is(':checked');
  //var options =  $("#"+field + " options");

  if(typeRelationType=="ONE2MANY"){
      //xu ly code dam bao khi 1 checkBox duoc check thi hidden <Select Option se thay doi theo (Truong hop ONE2MANY)
      $("#"+field + " option").each(function () {
          if(this.value==id){
              this.selected = statusCheckbox;
              if(statusCheckbox==false){
                  $(".vtTableCheckbox_" + field + "_main").attr("checked", false);
                  return;
              }
          }
      });
  }else if(typeRelationType=="FIELD"){
      var ids = "";
      //vtTableCheckbox_vt_user_upload_song_singer_ids
      $(".vtTableCheckbox_" + field).each( function() {
            if(this.checked==true){
                ids = ids + this.value + ",";
            }
      })
      if(ids.length>0){
          ids = ids.substring(0, ids.length-1)
      }
      $("#"+field).val(ids);
  }


  if(statusCheckbox==false){
      $(".vtTableCheckbox_" + field + "_main").attr("checked", false);
  }else{
      //truong hop nguoi dung selected 1 checkbox thi chay tiep
      $(".vtTableCheckbox_" + field + "_main").attr("checked", true);
      $(".vtTableCheckbox_" + field).each( function() {
          if(this.checked==false){
              $(".vtTableCheckbox_" + field + "_main").attr("checked", false);
              return;
          }
      })
  }

}

var allowProcessDataCustom=true;
function ProcessDataCustom(field, searchFunction, pageIndex){
    var keywords = [];

    var errorEmpty = true;
    var keywordArray = $("#vtModal_" + field + "  .vtModalFormSearch input[type=text]").each( function() {
//        keywords[this.id] = this.value;
        var exitsValue = $.trim(this.value);
        if(exitsValue.length>0){
            errorEmpty = false;//co it nhat 1 truong duoc nhap du lieu.
        }
        keywords[keywords.length] = [this.id, $.trim(this.value)];
    });

    if(errorEmpty==true){
        alert("Bạn phải nhập ít nhất một trong các trường tìm kiếm");
        return;
    }

    if(pageIndex==1){
	$("#" + field + "_modal_current_page").val(1);  
        //$("#vtModal_Keyword_"+field).val(keywords);//luu key word truoc khi search, sau phan trang thi se lay keyword nay de phan trang
        $("#vtModal_" + field + "  .vtModalFormSearch input[type=text]").each( function() {
            $("#vtModal_" + field + "  .vtModalFormSearch #"+ this.id +"_hidden").val($.trim(this.value));
        });

    }if(pageIndex>1){
        keywords = [];
        $("#vtModal_" + field + "  .vtModalFormSearch input[type=hidden]").each( function() {
            keywords[keywords.length] = [this.id, $.trim(this.value)];
            $("#vtModal_" + field + "  .vtModalFormSearch #"+ this.id).val($.trim(this.value));
        });
    }


//    $("#vtModal_loading").show();
    $.post("/admin.php/ajax/" + searchFunction,{
        keywords:keywords,
        pageIndex:pageIndex
    },function(result){
        ProcessResults(result,field);
    });
}

function ProcessData(field, searchFunction, pageIndex){
  var keyword = $.trim($("#vtModalInput_" + field).val());
  //tat cac cac chuc nang tim kiem 1 tham so, deu phai nhap du lieu truoc khi tim kiem
  if(keyword==""){
      alert("Bạn phải nhập dữ liệu trước khi tìm kiếm");
      return;
  }
    if(keyword.length >255)
    {
        alert("Từ khóa tìm kiếm  vượt quá maxleght(255) quy định");
        return;
    }
//  vtModal_vt_article_inner_related_article
  if(pageIndex==1){
    $("#" + field + "_modal_current_page").val(1);  
    $("#vtModal_Keyword_"+field).val(keyword);//luu key word truoc khi search, sau phan trang thi se lay keyword nay de phan trang
  }if(pageIndex>1){
    keyword = $("#vtModal_Keyword_"+field).val();
    $("#vtModalInput_" + field).val(keyword);
  }
  $("#vtModal_loading").show();
  $.post("/admin.php/ajax/" + searchFunction,{
    keyword:keyword,
    pageIndex:pageIndex
  },function(result){
      ProcessResults(result,field);
  });
}
function ProcessResults(result,field){
    $("#vtModal_loading").hide();
    //check if result is blank or not
    if(result.length == 2){
        //blank
        //show textbox
        $("#vtModalText_" + field).show();
        //hide table
        $("#vtModalTable_" + field).hide();
    }
    else{
        //not blank
        //hide textbox
        $("#vtModalText_" + field).hide();
        var typeRelationType = $("#vtModal_Relation_Type_" + field).val();
        var htmlTable = "Result";
        if(typeRelationType=="ONE2MANY"||typeRelationType=="FIELD"){
            //show table & format data
            htmlTable = CreateCheckBoxTable(result, field, "love", true);
        }else if(typeRelationType=="ONE2ONE"){
            htmlTable = CreateTableForSelectOne(result, field, "love", true);
        }
      var array = typeof result != 'object' ? JSON.parse(result) : result;
      if(array[array.length-1]["paging"]==true){
        //co paging
        maxPage =  array[array.length-1]["maxPage"];
        if(maxPage==0){
          $("#vtModalText_" + field).show();
          $("#vtModalTable_"+ field).hide();
          //$("#vtModalTable_"+ field + "  ul.pager li").hide();
          //$("#vtModalTable_"+ field + "  .description-page").hide();
          return;
        }
      }
      $("#vtModalTable_" + field).find('tbody').html("");
      $("#vtModalTable_" + field).find('tbody').html(htmlTable);
      $("#vtModalTable_" + field).find('thead').find('input').attr("checked", false);
      $("#vtModalTable_" + field).show();
    }
}

function CreateTableForSelectOne(objArray, field, theme, enableHeader) {
    //make list ids from all checkbox
    var currentValue = $("#"+field).val();

    // If the returned data is an object do nothing, else try to parse
    var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;

    var str = '';
    var buttonSelectedName = $("#vtModal_choice_button_"+field).val();

    if(array[array.length-1]["paging"]==true){
        //co paging
        pageIndex =  array[array.length-1]["pageIndex"];
        pageSize =  array[array.length-1]["pageSize"];
        maxPage =  array[array.length-1]["maxPage"];

        if(maxPage==0){
            $("#vtModalTable_"+ field + "  ul.pager li").hide();
            $("#vtModalTable_"+ field + "  .description-page").hide();
            return;
        }
        var htmlPage = "<a href='javascript:void(0)'>"+pageIndex+"</a>";
        $("#vtModalTable_"+ field + "  .Button-Paging").html(htmlPage);
        $("#vtModalTable_"+ field + "  .description-page").show();
        $("#vtModalTable_"+ field + "  .description-page span").html(pageIndex+"/"+maxPage);
        $("#vtModalTable_"+ field + "  .Button-Paging").show();
        $("#vtModalTable_"+ field ).html()
        if(pageIndex<maxPage){
            $("#vtModalTable_"+ field + "  .Button-Next").show();
        }else if(pageIndex==maxPage){
            $("#vtModalTable_"+ field + "  .Button-Next").hide();
        }
        if(pageIndex>1){
            $("#vtModalTable_"+ field + "  .Button-Previous").show();
        }else{
            $("#vtModalTable_"+ field + "  .Button-Previous").hide();
        }
    }

    var maxShowOnPopup = array.length;
    if(array[array.length-1]["paging"]==true){
        maxShowOnPopup = maxShowOnPopup -1;
    }

    for (var i = 0; i < maxShowOnPopup; i++) {
        var columnsShow = "";
        for (var index in array[i]) {
            if(index != "id")
                columnsShow += '<td>' + encodeOutput(array[i][index]) + '</td>';
        }
        if(array[i]["id"]==currentValue){
            str += '<tr id="vtTable_'+field+'_row_'+rowId+'"><td></td>'; //da duoc chon ra man hinh roi
        }else{
            var rowId = array[i]["id"];
            str += '<tr id="vtTable_'+field+'_row_'+rowId+'"><td style="width:10px;"><input type="button" class="btn" data-dismiss="modal" value="'+buttonSelectedName
                +'" onclick="vtSelectDataFromModal(' + "'" + field + "'," + rowId + ')"></td>';
        }
        str += columnsShow;
        str += '</tr>';
    }
    return str;
}
function vtSelectDataFromModal(field,rowId){
    //hien thi button cu len truoc khi set lai rowId
    currentId =  $("#"+field).val();
    if(currentId>0){
        //hien thi lai Button tren thanh Search
        var buttonSelectedName = $("#vtModal_choice_button_"+field).val();
        $("#vtTable_" + field + "_row_"+currentId+" td").first().html('<input type="button" class="btn" data-dismiss="modal" value="'+buttonSelectedName
            +'" onclick="vtSelectDataFromModal(' + "'" + field + "'," + currentId + ')">');
    }
    var rowHtml = $("#vtTable_" + field + "_row_"+rowId).html();//lay ra table
    $("#vtTable_" + field + " tbody tr").html(rowHtml);//chen vao page
    $("#vtTable_" + field).show();//hien thi bang
    $("#"+field).val(rowId);//set hidden de submit
    $("#vtTable_" + field + "_row_"+rowId+" td").first().html("&nbsp;");//hidden nut tren popup
    $("#vtTable_" + field + " tbody tr td").first().html('<input type="button" class="btn" value="Xoá" onclick="vtRemoveDataFromModal(' + "'" + field + "'," + rowId + ')">');//chen vao page
}
function vtRemoveDataFromModal(field,rowId){
    $("#"+field).val("");//set lai hidden = null
    $("#vtTable_" + field).hide(); //hidden table
    var buttonSelectedName = $("#vtModal_choice_button_"+field).val();
    $("#vtTable_" + field + "_row_"+rowId+" td").first().html('<input type="button" class="btn" data-dismiss="modal" value="'+buttonSelectedName
        +'" onclick="vtSelectDataFromModal(' + "'" + field + "'," + rowId + ')">');
}

function CreateCheckBoxTable(objArray, field, theme, enableHeader) {
  var typeRelationType = $("#vtModal_Relation_Type_" + field).val(); //type Relate: ONE2ONE, ONE2MANY, FIELD
  var typeOrderColumnName = $("#vtModal_OrderColumnName_" + field).val();
  //make list ids from all checkbox
  var ids = "";

  if(typeRelationType=="ONE2MANY"){
      $(".vtTableCheckbox_" + field).each( function() {
          var subClass = $(this).attr("id");
          var subPosition = subClass.lastIndexOf("_");
          var length = subClass.length;
          var id = subClass.substr(subPosition + 1, length - subPosition - 1);
          ids += id + ",";
      })
      ids = ids.substr(0, ids.length - 1);
      ids = "," + ids + ",";
  }else if(typeRelationType=="FIELD"){
      ids =  $("#"+field).val();
      if(ids.length>0){
        ids = "," + ids + ",";
      }
      
  }

  // If the returned data is an object do nothing, else try to parse
  var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
 
  //  var str = '<table class="' + theme + '">';
  var str = '';

  // table body
  //  str += '<tbody>';
  if(array[array.length-1]["paging"]==true){
     //co paging
     pageIndex =  array[array.length-1]["pageIndex"];
     pageSize =  array[array.length-1]["pageSize"];
     maxPage =  array[array.length-1]["maxPage"];

     if(maxPage==0){
        $("#vtModalTable_"+ field + "  ul.pager li").hide();
        $("#vtModalTable_"+ field + "  .description-page").hide();
        return;
     }
     var htmlPage = "<a href='javascript:void(0)'>"+pageIndex+"</a>";
     $("#vtModalTable_"+ field + "  .Button-Paging").html(htmlPage);
     $("#vtModalTable_"+ field + "  .description-page").show();
     $("#vtModalTable_"+ field + "  .description-page span").html(pageIndex+"/"+maxPage);
     $("#vtModalTable_"+ field + "  .Button-Paging").show();
     $("#vtModalTable_"+ field ).html()
     if(pageIndex<maxPage){
        $("#vtModalTable_"+ field + "  .Button-Next").show();
     }else if(pageIndex==maxPage){
        $("#vtModalTable_"+ field + "  .Button-Next").hide();
     }
     if(pageIndex>1){
         $("#vtModalTable_"+ field + "  .Button-Previous").show();
     }else{
         $("#vtModalTable_"+ field + "  .Button-Previous").hide();
     }
  }

  var maxShowOnPopup = array.length;
  if(array[array.length-1]["paging"]==true){
      maxShowOnPopup = maxShowOnPopup -1;
  }

  for (var i = 0; i < maxShowOnPopup; i++) {
    if(IsInList(array[i]["id"], ids))
      str += '<tr class="info"><td><input type="checkbox" value="'+ array[i]["id"] +'" id="' + field + '_' + array[i]["id"] + '" class="vtModalTableCheckbox_' + field + '" onchange="ModalToggleByClassName(' + "'" + field + '_' + array[i]["id"] + "'" + ')" disabled="true" checked="checked"></td>';
    else
      str += '<tr class="info"><td><input type="checkbox" value="'+ array[i]["id"] +'" id="' + field + '_' + array[i]["id"] + '" class="vtModalTableCheckbox_' + field + '" onchange="ModalToggleByClassName(' + "'" + field + '_' + array[i]["id"] + "'" + ')"></td>';
    for (var index in array[i]) {
      if(index!="Translation"){
          if(index != "id")
              str += '<td>' + encodeOutput(array[i][index]) + '</td>';
          else
              str += '';
      }
    }
    str += '</tr>';
  }
  //  str += '</tbody>'
  //  str += '</table>';
  return str;
}

function ModalToggleAllByClassName(className) {
//  var position = className.indexOf("_");
  $("." + className).each( function() {
    if($(this).is(':disabled') == false)
      $(this).attr("checked", $("." + className + "_main").is(':checked'));
  })
}

function ModalToggleByClassName(checkboxId){
    //vtModalTableCheckbox_vt_article_inner_related_article_main
    //vtModalTableCheckbox_vt_article_inner_related_article
    var classCss =  $("#"+checkboxId).attr("class");
    var classCssMain =  classCss + "_main";
    var status = true;
    $("."+classCss).each( function() {
        if(this.checked==false){
            status = false;
        }
    })
    $("."+classCssMain).attr("checked",status);
}

function MovePrevious(field, searchFunction){
  var modalCurrentPage = parseInt($("#" + field + "_modal_current_page").val());
  if(modalCurrentPage > 0){
    $("#" + field + "_modal_current_page").val(modalCurrentPage - 1);
    if((modalCurrentPage - 1)<=0){
      return;//ko cho back nua
    }

    if($("#vtModal_" + field + " #multiple_search_keys").val()==1){
      ProcessDataCustom(field, searchFunction, modalCurrentPage - 1);
    }else{
      ProcessData(field, searchFunction, modalCurrentPage - 1);
    }
    
  }
  
}

function MoveNext(field, searchFunction){

  var modalCurrentPage = parseInt($("#" + field + "_modal_current_page").val());

  if((modalCurrentPage+1)>1){
      //$("#vtModalTable_"+ field + "  .description-page span").html(pageIndex+"/"+maxPage);
      var sPage =   $("#vtModalTable_"+ field + "  .description-page span").html();
      var pageArray = sPage.split("/");
      if(pageArray.length==2){
        var maxPage =  pageArray[1];
        if((modalCurrentPage+1)>maxPage){
           return;
        }
      }
  }


  $("#" + field + "_modal_current_page").val(modalCurrentPage + 1);
  
  if($("#vtModal_" + field + " #multiple_search_keys").val()==1){
      ProcessDataCustom(field, searchFunction, modalCurrentPage + 1);
  }else{
      ProcessData(field, searchFunction, modalCurrentPage + 1);
  }
}
function MovePage(field, searchFunction,modalCurrentPage){
    $("#" + field + "_modal_current_page").val(modalCurrentPage + 1);
    ProcessData(field, searchFunction, modalCurrentPage + 1);
}

function UpdateData(field, type){
  var ids = $("#" + field).val();
  var typeOrderColumnName = $("#vtModal_OrderColumnName_" + field).val();
    
  //update tables & merge values
  var trs = "";
  var options = "";
  $("#vtModalTable_" + field).find('tbody tr').each( function() {
    if($(this).find('input').is(':disabled') == false){
      if($(this).find('input').is(':checked') == true){
        var htmlId = $(this).find('input').attr("id");
        var subPosition = htmlId.lastIndexOf("_");
        var length = htmlId.length;
        var id = htmlId.substr(subPosition + 1, length - subPosition - 1);

        if(typeOrderColumnName=="" || typeOrderColumnName==undefined){
          var tr = "<tr>" + $(this).html() + "</tr>";      
        }else{
            var textEdit = "<input class='checkValidateOrderNumber' type='text' name='"+field+"_ordernumber["+id+"]' " +
                " value='1' style='width:30px' maxlength='2'> <span style='color: red;display:none;'> Phải là số từ 1->99</span>";
            var tr = "<tr>" + $(this).html() + "<td>"+textEdit+"</td></tr>";
        }
        
        tr = tr.replace("vtModalTableCheckbox","vtTableCheckbox");
        tr = tr.replace("ModalToggleByClassName","ToggleByClassName");
        tr = tr.replace('<input','<input checked="checked"');		  
        trs += tr;                
        
        $(this).find('input').attr("disabled", "true");

        ids += "," + id;
        
        var option = '<option value="' + id + '" selected="selected"></option>';
        options += option;
      }
    }
  })	
  $("#vtTable_" + field).find('tbody').append(trs);	
  //update values
  if(ids.charAt(0) == ",")
	ids = ids.substr(1, ids.length -1);
  switch(type){
    case "FIELD":
      $("#" + field).val(ids);	
      break;
    case "ONE2MANY":
      $("#" + field).append(options);
      break;
  }  

  if(ids.length > 0)
    $("#vtTable_" + field).show();
	
  return false;
}

function IsInList(id, ids){
  var isExist = false;
	
  //check if exist in middle
  if (ids.indexOf("," + id + ",", 0) >= 0)
    isExist = true;
     
  //check if exist in first
//  if (ids.indexOf(id + ",", 0) == 0)
//    isExist = true;

//  if (ids.indexOf(","+id, 0) == 0)
//    isExist = true;

  //check if exist in last
  //if  (ids.lastIndexOf("," + id) == ids.length - id.length -1)
  //isExist = true;
	  
  return isExist;
}