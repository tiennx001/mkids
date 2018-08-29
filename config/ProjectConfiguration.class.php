<?php

require_once dirname(__FILE__) . '/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins(array(
      'sfThumbnailPlugin',
//            'sfRedisPlugin',
      'sfDoctrinePlugin',
      'sfDoctrineGuardPlugin',
      'sfCKEditorPlugin',
      'sfPhpExcelPlugin',
      'sfFormExtraPlugin',
      'sfDatePickerTimePlugin',
      'tmcTwitterBootstrapPlugin',
      'sfCaptchaGDPlugin'));
    $this->setWebDir(sfConfig::get('sf_root_dir') . '/web');
    //$this->registerZend();

    //$this->enablePlugins('sfCaptchaGDPlugin');
  }

  public function configure()
  {
  }

  public function configureDoctrine(Doctrine_Manager $manager)
  {
//    $cacheDriver = new Doctrine_Cache_Redis(array('redis' => sfRedis::getClient('default'), 'prefix' => 'dql:'));
//    $manager->setAttribute(Doctrine::ATTR_QUERY_CACHE, $cacheDriver);
//    $manager->setAttribute(Doctrine_Core::ATTR_RESULT_CACHE, $cacheDriver);
  }
}
