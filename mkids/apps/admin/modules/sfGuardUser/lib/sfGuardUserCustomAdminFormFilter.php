<?php

/**
 * sfGuardUser filter form.
 *
 * @package    radio_ivr
 * @subpackage filter
 * @author     loilv4
 * @version    SVN: $Id: sfDoctrinePluginFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserCustomAdminFormFilter extends PluginsfGuardUserFormFilter
{

  public function configure()
  {

    //widget & validator truong username
    $this->widgetSchema['username'] = new sfWidgetFormInputText(array(), array('maxlength' => 255));
     $this->widgetSchema['is_active']= new sfWidgetFormChoice(array('choices' => array('' => 'Tất cả', 1 => 'Đang hoạt động', 0 => 'Đang ngừng hoạt động')));
    $this->validatorSchema['username'] = new sfValidatorString(array(
      'required' => false,
      'max_length' => 255,
      'trim' => true,
    ));
     $this->validatorSchema['is_active'] =new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0)));
  }

  /**
   * Loc theo ten dang nhap
   * @author Huynt74
   * @created on 22/01/2013
   * @param $query
   * @param $value
   */
  public function addUsernameColumnQuery($query, $field, $value)
  {
    Doctrine::getTable('sfGuardUser')->applyUsernameFilter($query, $value);
  }
  /**
   * Loc theo trang thai
   * @author loilv4
   * @created on 22/04/2013
   * @param $query, $value
   * @param $value
   */
  public function addIsActiveColumnQuery($query, $field, $value)
  {
    Doctrine::getTable('sfGuardUser')->applyIsActiveFilter($query, $value);
  }
}
