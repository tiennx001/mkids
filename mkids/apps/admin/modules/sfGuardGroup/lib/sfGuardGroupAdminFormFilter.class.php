<?php

/**
 * sfGuardGroup filter form.
 *
 * @package    mobiletv
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardGroupAdminFormFilter extends PluginsfGuardGroupFormFilter
{

  public function configure()
  {
    $this->getWidget('name')->setOption('with_empty', false);
    $this->getWidget('name')->setAttribute('maxlength', 50);
    $this->validatorSchema['name'] = new sfValidatorSchemaFilter('text',
      new sfValidatorString(array(
        'required'    => false,
        'max_length'  => 50
      ))
    );
  }

  /**
   * ham them dieu kiem truy van theo tem nhom nguoi dung
   * @author: thongnq1
   * @created at: 03/05/2013
   * @param $query
   * @param $field
   * @param $value
   */
  public function addNameColumnQuery($query, $field, $value)
  {
    Doctrine::getTable('sfGuardUserGroup')->applyNameFilter($query, $value);
  }

}
