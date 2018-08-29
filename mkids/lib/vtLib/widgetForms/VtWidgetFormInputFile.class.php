<?php

/**
 * Class xu ly render ra input file (co anh thumb kem theo)
 * @author NamDT5
 * @created on 22/01/2013
 */
class VtWidgetFormInputFile extends sfWidgetFormInputFile
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $i18n = sfContext::getInstance()->getI18N();
    
    parent::configure($options, $attributes);

    $this->setOption('type', 'file');
    $this->setOption('needs_multipart', true);

    $this->addRequiredOption('file_src');
    $this->addOption('is_image', false);
    $this->addOption('edit_mode', true);
    
    $template = '
      <table class="input-file-tbl" width="">
        <tr>
          <td align="left" style="overflow: hidden;">%file%</td>
        </tr>
        <tr>
          <td>%input%</td>
        </tr>
      </table>
    ';
    $this->addOption('template', $template);
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $input = parent::render($name, $value, $attributes, $errors);

    return strtr($this->getOption('template'), array('%input%' => $input, '%file%' => $this->getFileAsTag($attributes)));
  }
  
  protected function getFileAsTag($attributes)
  {
    if ($this->getOption('is_image'))
    {
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      @$mimeType   = finfo_file($finfo, sfConfig::get('sf_web_dir'). $this->getOption('file_src'));

    	if ($mimeType != 'application/x-shockwave-flash')
    	{
	    	/**
	       * Chi hien thi anh thumb kich thuoc 100x100
	       * @author NamDT5
	       */
	      return ($this->getOption('file_src')) ? $this->renderTag('img', array_merge(array(
	        'src' => VtHelper::getThumbUrl($this->getOption('file_src'), 100, 100), 
	        
	      ), $attributes)) : '';
    	} else 
    	{
    		return '
    		  <object height="100" width="" 
                classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" 
                codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0">
                  <param value="link='.$this->getOption('file_src').'" name="flashvars">
                  <param name="movie" value="<?php echo $slideshow->getFilePath(); ?>">
                  <param name="wmode" value="opaque">
                  
                  <embed height="100" width="" flashvars="link=<?php echo $slideshow->getUrl(); ?>" 
                    type="application/x-shockwave-flash" 
                    pluginspage="http://www.macromedia.com/go/getflashplayer" 
                    src="'. $this->getOption('file_src').'" wmode="opaque" />
              
          </object>
    		';
    	}
    }
    else
    {
      return $this->getOption('file_src');
    }
  }
}
