<?php

require_once dirname(__FILE__).'/../lib/sfGuardGroupGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/sfGuardGroupGeneratorHelper.class.php';

/**
 * sfGuardGroup actions.
 *
 * @package    mobiletv
 * @subpackage sfGuardGroup
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardGroupActions extends autoSfGuardGroupActions
{
  /**
   * Bo sung them ghi log hanh dong xoa
   * @author NamDT5
   * @created on 19/04/2013
   * @param sfWebRequest $request
   */
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $object = $this->getRoute()->getObject();
    $objectName = $object->getName();
    if ($object->delete())
    {
      $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
      // Ghi log hanh dong xoa
      VtIpCameraHelper::logUserAction($this->getUser()->getId(), sfConfig::get('app_user_action_delete'), 1, 'Delete group: '. $objectName);
    } else {
      // Xoa khong thanh cong
      // Ghi log hanh dong xoa
      VtIpCameraHelper::logUserAction($this->getUser()->getId(), sfConfig::get('app_user_action_delete'), 0, 'Delete group: '. $objectName);
    }

    $this->redirect('@sf_guard_group');
  }

  /**
   * Bo sung them ghi log hanh dong xoa
   * @author NamDT5
   * @created on 19/04/2013
   * @param sfWebRequest $request
   */
  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    $userId = $this->getUser()->getId();
    $records = Doctrine_Query::create()
      ->from('sfGuardGroup')
      ->whereIn('id', $ids)
      ->execute();

    $deleteSuccessArr = array();  // Mang luu tru ten cac item xoa thanh cong
    $deleteFailArr    = array();  // Mang luu tru ten cac item xoa that bai

    foreach ($records as $record)
    {
      $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $record)));
      $recordName = $record->getName();

      if ($record->delete()) {
        $deleteSuccessArr[] = $recordName;
      } else {
        $deleteFailArr[]    = $recordName;
      }
    }

    if (!empty($deleteFailArr)) {
      // Ghi log xoa that bai
      VtIpCameraHelper::logUserAction($userId, sfConfig::get('app_user_action_delete'), 0, 'Delete group: '. implode(', ', $deleteFailArr));
    }

    if (!empty($deleteSuccessArr)) {
      // Ghi log xoa thanh cong
      VtIpCameraHelper::logUserAction($userId, sfConfig::get('app_user_action_delete'), 1, 'Delete group: '. implode(', ', $deleteSuccessArr));
    }
    $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');

    //start - thongnq1 - 03/05/2013 - fix loi xoa trong trang danh sach (su dung them bien current_page)
    $current_page = $this->getPager()->getPage();
    $this->redirect('sf_guard_group', array('current_page' => $current_page));
    //end -thongnq1
  }
}
