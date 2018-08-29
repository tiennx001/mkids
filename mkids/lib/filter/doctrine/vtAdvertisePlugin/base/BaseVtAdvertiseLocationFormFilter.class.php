<?php

/**
 * VtAdvertiseLocation filter form base class.
 *
 * @package    IpCamera
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseVtAdvertiseLocationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'template'                => new sfWidgetFormFilterInput(),
      'advertise_location_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'VtAdvertise')),
    ));

    $this->setValidators(array(
      'name'                    => new sfValidatorPass(array('required' => false)),
      'template'                => new sfValidatorPass(array('required' => false)),
      'advertise_location_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'VtAdvertise', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vt_advertise_location_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /home/namdt5/projects/QT01_13064_VAS_Upro/06.SOURCE/Draft/cms/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /home/namdt5/projects/QT01_13064_VAS_Upro/06.SOURCE/Draft/cms/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362
AdvertiseLocationListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('VtAdvertiseLocationItem.advertise_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'VtAdvertiseLocation';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'name'                    => 'Text',
      'template'                => 'Text',
      'advertise_location_list' => 'ManyKey',
    );
  }
}
