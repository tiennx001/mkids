<?php

require_once dirname(__FILE__).'/../lib/vtHomePageGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/vtHomePageGeneratorHelper.class.php';

/**
 * HomePage actions.
 *
 * @package    radio_ivr
 * @subpackage HomePage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class vtHomePageActions extends sfActions
{
  /**
   * action xu ly trang index
   * @author loilv4
   * @created on 04/02/2013
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->header = sfConfig::get('app_tmcTwitterBootstrapPlugin_header', array());
    $this->setVar('menus', array_key_exists('menu', $this->header) ? $this->header['menu'] : array('Home' => 'homepage'), true);
    $this->setVar('routes', $this->getContext()->getRouting()->getRoutes(), true);
    $this->current_route = $this->getContext()->getRouting()->getCurrentRouteName();
  }
}
