<?php

/**
 * sfGuardGroup form.
 *
 * @package    mobiletv
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardGroupAdminForm extends PluginsfGuardGroupForm
{

  public function configure()
  {
    unset($this['users_list']);
    
    $this->widgetSchema['name'] = new sfWidgetFormInputText(array(), array('maxlength' => 255));
    $this->widgetSchema['description'] = new sfWidgetFormTextarea(array(), array(
      'style' => 'margin: 0px; width: 500px; height: 130px;',
      'maxlength' => 500,
    ));
    $this->widgetSchema['permissions_list'] = new sfWidgetFormDoctrineChoice(array(
        'multiple' => true,
        'expanded' => true,
        'model'    => 'sfGuardPermission',
        'order_by' => array('name', 'asc')
    ));

    $this->validatorSchema['name'] = new sfValidatorString(array('max_length' => 255, 'required' => true, 'trim' => true));
    $this->validatorSchema['description'] = new sfValidatorString(array('max_length' => 500, 'required' => false));
    $this->validatorSchema['permissions_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorDoctrineUnique(array('model' => 'sfGuardGroup', 'column' => 'name')),
    )));
  }

  /**
   * Xu ly bind du lieu truong name vao form de dam bao user khong hack qua firebug
   * @author NamDT5
   * @created on 19/04/2013
   * @param array $values
   */
  protected function doBind(array $values)
  {
    if (!$this->isNew())
    {
      $values['name'] = $this->getObject()->getName();
    }

    $this->values = $this->validatorSchema->clean($values);
  }
}
