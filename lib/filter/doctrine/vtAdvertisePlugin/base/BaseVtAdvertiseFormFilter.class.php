<?php

/**
 * VtAdvertise filter form base class.
 *
 * @package    IpCamera
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseVtAdvertiseFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'media_path'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'url'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_flash'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'start_time'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'end_time'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'priority'      => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'location_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'VtAdvertiseLocation')),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'media_path'    => new sfValidatorPass(array('required' => false)),
      'url'           => new sfValidatorPass(array('required' => false)),
      'is_active'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_flash'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'start_time'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'end_time'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'priority'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'location_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'VtAdvertiseLocation', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vt_advertise_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /home/namdt5/projects/QT01_13064_VAS_Upro/06.SOURCE/Draft/cms/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /home/namdt5/projects/QT01_13064_VAS_Upro/06.SOURCE/Draft/cms/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362
LocationListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.VtAdvertiseLocationItem VtAdvertiseLocationItem')
      ->andWhereIn('VtAdvertiseLocationItem.location_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'VtAdvertise';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'name'          => 'Text',
      'media_path'    => 'Text',
      'url'           => 'Text',
      'is_active'     => 'Boolean',
      'is_flash'      => 'Boolean',
      'start_time'    => 'Date',
      'end_time'      => 'Date',
      'priority'      => 'Number',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
      'location_list' => 'ManyKey',
    );
  }
}
