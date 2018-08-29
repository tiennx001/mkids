<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Huynt74
 * Date: 29/01/2013
 * Time: 9:22 AM
 * To change this template use File | Settings | File Templates.
 */
class defaultActions extends sfActions
{
  /**
   * Action xu ly cho trang 404
   * @author Huynt74
   * @creted on 29/01/2013
   * @param sfWebRequest $request
   */
  public function executeError404(sfWebRequest $request)
  {
    sfContext::getInstance()->getResponse()->setTitle('404');
  }

  /**
   * Action secure
   * @author Huynt74
   * @created on 29/01/2013
   */
  public function executeSecure()
  {
    $this->getResponse()->setStatusCode(403);
  }
}