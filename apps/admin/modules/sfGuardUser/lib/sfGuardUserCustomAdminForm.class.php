  <?php

/**
 * sfGuardUser form.
 *
 * @package    radio_ivr
 * @subpackage form
 * @author     loilv4
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserCustomAdminForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();

    //Unset cac truong
    unset($this['created_at'], $this['updated_at'], $this['last_login'], $this['salt'], $this['algorithm'], $this['is_super_admin']);

    //widget cho truong username, password & email_address
    $this->setWidget('username', new sfWidgetFormInputText(array(), array('maxlength' => 255)));
    $this->setWidget('password', new sfWidgetFormInputPassword(array(), array('maxlength' => 30)));
    $this->setWidget('email_address', new sfWidgetFormInputText(array(), array('maxlength' => 100)));

    //Set default cho truong is_active = false
    $this->setDefault('is_active', false);

    //validator cho truong username, password, email_address
	  if($this->isNew()){
		  $this->setValidator('username', new sfValidatorRegex(
			  array('pattern' => '/^[A-Za-z0-9_]{5,255}$/', 'trim' => true,'max_length'=>255),
			  array('invalid' => $i18n->__('Định dạng không hợp lệ. Độ dài từ 5 -> 255 ký tự, không chứa ký tự đặc biệt, chỉ gồm chữ cái, số và gạch dưới'))
		  ));
	  }else{
		  $this->setValidator('username', new sfValidatorPass());
	  }

//    $this->setValidator('email_address', new sfValidatorEmail(array('required' => true, 'max_length' => 100, 'trim' => true)));
    //loilv4 thay doi validator email
    $this->validatorSchema['email_address'] = new sfValidatorRegex(array(
      'pattern'    => '/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/',
      'required'   => true,
      'max_length' => 100,
      'trim'       => true
    ));
    $this->validatorSchema['password'] = new sfValidatorString(array('required' => ($this->isNew()) ? true : false, 'max_length' => 30));
    $this->validatorSchema['password'] = new sfValidatorRegex(
        array('pattern' => '/^.*(?=.{8,})(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[a-zA-Z]).*$/', 'required' => ($this->isNew()) ? true : false, 'max_length' => 30),
        array('invalid' => $i18n->__('Your password must have at least 8 characters, include number and special characters.'))
    );
    $this->widgetSchema['groups_list'] = new sfWidgetFormViettelTable(array(
      'label' => 'Chọn nhóm người dùng',
      'model' => 'sfGuardGroup',
      'table_method' => 'getGuardGroupNameArrayId',
      'relation_type' => 'ONE2MANY',
      'search_method' => 'searchGuardGroupName',
      'visible_columns' => array('name'),
      'button_text' => $i18n->__('Thêm nhóm người dùng'),
      'modal_header'=>$i18n->__('Chọn nhóm người dùng'),
      'visible_column_text' => array($i18n->__('Tên nhóm người dùng')),
      'no_result_text' => $i18n->__('không có tên nhóm người dùng phù hợp')
    ));

    //Set label cho truong password
    $this->widgetSchema->setLabels(array(
        'password' => $i18n->__('Mật khẩu'),
    ));
  }

  /**
   * Bind lại username khi vao trang chinh sua
   * @author Huynt74
   * @created on 2/5/2013
   * @param array $values
   */
  protected function doBind(array $values)
  {
    if(!$this->isNew())
    {
      $values['username'] = $this->getObject()->getUsername();
    }
    parent::doBind($values);
  }
  /**
   * Custom lai ham processValues de cap nhat lai 2 truong pass_update_at & is_super_admin
   * @author loilv4
   * @Modified on 04/02/2013
   * @param array $values
   * @return array
   */
  public function processValues($values)
  {
    $values = parent::processValues($values);

    // chinh sua pass thi yeu cau nguoi dung phai thay doi lai
    $values['pass_update_at'] = null;
//    $values['is_super_admin'] = 1;
    if(!$this->isNew())
    {
      $values['username'] = $this->getObject()->getUsername();
    }
    return $values;
  }
}
