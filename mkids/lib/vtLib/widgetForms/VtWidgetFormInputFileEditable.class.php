<?php

/**
 * Class xu ly render ra input file (co anh thumb kem theo)
 * @author NamDT5
 * @created on 22/01/2013
 */
class VtWidgetFormInputFileEditable extends sfWidgetFormInputFileEditable
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $i18n = sfContext::getInstance()->getI18N();
    
    $this->addOption('delete_label', $i18n->__('Remove the current file'));
    $template = '
      <table width="">
        <tr>
          <td><br /><br />%input%<br />%delete% %delete_label%</td>
          <td style="padding-left: 10px;">%file%</td>
        </tr>
      </table>
    ';
    $this->addOption('template', $template);
  }
  protected function getFileAsTag($attributes)
  {
    if ($this->getOption('is_image'))
    {
    	/**
       * Chi hien thi anh thumb kich thuoc 100x100
       * @author NamDT5
       */
      return false !== $this->getOption('file_src') ? $this->renderTag('img', array_merge(array(
        'src' => VtHelper::getThumbUrl($this->getOption('file_src'), 100, 100), 
        
      ), $attributes)) : '';
    }
    else
    {
      return $this->getOption('file_src');
    }
  }
}
