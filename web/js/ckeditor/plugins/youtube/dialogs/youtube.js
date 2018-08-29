(function(){CKEDITOR.dialog.add('youtube',
	function(editor)
	{return{title:editor.lang.youtube.title,minWidth:CKEDITOR.env.ie&&CKEDITOR.env.quirks?368:350,minHeight:240,
	onShow:function(){
    this.getContentElement('general','content').getInputElement().setValue('');
    this.getContentElement('general','optionWidth').getInputElement().setValue('460');
    this.getContentElement('general','optionHeight').getInputElement().setValue('315');
  },
	onOk:function(){


    var val = this.getContentElement('general','content').getInputElement().getValue();
    // Lay ra ID cua video youtube
    // http://www.youtube.com/watch?v=QkNrSpqUr-E
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = val.match(regExp);
    if (match&&match[7].length==11){
      val = 'http://www.youtube.com/embed/' + match[7];
    }else{
      alert("URL không hợp lệ");
      return false;
    }
    //Lay ra chieu cao, chieu rong
    var width = this.getContentElement('general','optionWidth').getInputElement().getValue();
    var height = this.getContentElement('general','optionHeight').getInputElement().getValue();

    if(!width || !height)
      var text='[youtube]'+ val +'[/youtube]';
    else
      var text='[youtube '+width+'x'+height+']'+ val +'[/youtube]';
	this.getParentEditor().insertHtml(text)},
	contents:[{label:editor.lang.common.generalTab,id:'general',elements:
																		[{type:'html',id:'pasteMsg',html:'<div style="white-space:normal;width:500px;"><img style="margin:5px auto;" src="'
																		+CKEDITOR.getUrl(CKEDITOR.plugins.getPath('youtube')
																		+'images/youtube_large.png')
																		+'"><br />'+editor.lang.youtube.pasteMsg
																		+'</div>'},{type:'html',id:'content',style:'width:340px;height:90px',html:'<input size="100" style="'+'border:1px solid black;'+'background:white">',focus:function(){this.getElement().focus()}}
                                    ,{type:'html',id:'optionWidth',html:'<div style ="white-space: normal; width: 90px;">'
                                    +editor.lang.youtube.optionWidth
                                    +'</div>'},{type:'html',id:'optionWidth',style:'width:340px;height:90px',html:'<input size="20" value="460" style="'+'border:1px solid black;'+'background:white">',focus:function(){this.getElement().focus()}}
                                    ,{type:'html',id:'optionHeight',html:'<div style ="white-space: normal; width: 90px;">'
                                    +editor.lang.youtube.optionHeight
                                    +'</div>'},{type:'html',id:'optionHeight',style:'width:340px;height:90px',html:'<input size="20" value="315" style="'+'border:1px solid black;'+'background:white">',focus:function(){this.getElement().focus()}}]}]}})})();
