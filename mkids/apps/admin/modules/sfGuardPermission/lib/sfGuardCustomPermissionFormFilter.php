<?php

/**
 * sfGuardUser filter form.
 *
 * @package    radio_ivr
 * @subpackage filter
 * @author     loilv4
 * @version    SVN: $Id: sfDoctrinePluginFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardCustomPermissionFormFilter extends PluginsfGuardPermissionFormFilter
{

  public function configure()
  {
    $this->getWidget('name')->setOption('with_empty', false);
  }

}
