<?php

/**
 * sfGuardUser form.
 *
 * @package    radio_ivr
 * @subpackage form
 * @author     loilv4
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardPermissionForm extends PluginsfGuardPermissionForm
{
  public function configure()
  {
    //Unset cac truong
    unset($this['created_at'], $this['updated_at'], $this['last_login'], $this['salt'], $this['algorithm'], $this['is_super_admin']);
  }
}
