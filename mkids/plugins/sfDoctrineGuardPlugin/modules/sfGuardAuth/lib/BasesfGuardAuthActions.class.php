<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardAuthActions.class.php 23800 2009-11-11 23:30:50Z Kris.Wallsmith $
 */
class BasesfGuardAuthActions extends sfActions
{
    public function executeSignin($request)
    {
        $user = $this->getUser();
        if ($user->isAuthenticated()) {
            return $this->redirect('@homepage');
        }

        $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
        $this->form = new $class();
        $this->change_password = $change_password = $request->getParameter('change_password', 0);
        if ($change_password == 1) {
            $this->form = new VtSignInChangePasswordForm();
        }
        $form = $this->form;

        if ($request->isMethod(sfRequest::POST)) {
            $i18n = sfContext::getInstance()->getI18N();
            $aFormPost=$request->getParameter($form->getName());
            $aFormPostTrim=array();
            foreach($aFormPost as $key =>$value){
                $aFormPostTrim[$key]=trim($value);
            }
            $form->bind($aFormPostTrim);
            if ($change_password == 0) {
                $username = $form['username']->getValue();
                if ($username && $sf_user = sfGuardUserTable::getInstance()->getUserByUsername($username)) {
                    $is_lock = $sf_user->getIsLockSignin();
                    if ($is_lock == 1) {
                        $time_lock = time() - 600;
                        if ($sf_user->getLockedTime() >= $time_lock) {
                            $this->getUser()->setFlash('error', $i18n->__('Your account has been locked out for 10 minutes.'));

                            return;
                        } else {
                            sfGuardUserTable::getInstance()->setUnLockUser($username);
                            TblUserSigninLogTable::getInstance()->resetUserSigninLock($username);
                        }
                    }
                    if ($form->isValid()) {
                        $user->setIpAddress($this->getRequest()->getHttpHeader('addr', 'remote'));
                        $user->setUserAgent($this->getRequest()->getHttpHeader('User-Agent'));

                        if (!$sf_user->getPassUpdateAt() || (time() - strtotime($sf_user->getPassUpdateAt()) > sfConfig::get('app_passuser_lifetime', 7776000))) {
                            $this->form = new VtSignInChangePasswordForm();
                            $this->form->setUserName($username);
                            $this->change_password = 1;
                            $this->getUser()->setFlash('notice', $i18n->__('Your password has expired and must be changed.'));

                            return;
                        }
                        $this->getUser()->signin($form->getValue('user'), $form->getValue('remember'));
                        TblUserSigninLogTable::getInstance()->resetUserSigninLock($username);
                        // always redirect to a URL set in app.yml
                        // or to the referer
                        // or to the homepage
                        $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer($request->getReferer()));

                        return $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');
                    } else {
                        $time_now = time();
                        $time_log = $time_now - 3600;
                        $failed_times = TblUserSigninLogTable::getInstance()->getCountUserSig($username, $time_log);
                        if ($failed_times >= 4) {
                            // check du 5 lan hay chua
                            // du 5 lan thong bao loi va insert vao
                            sfGuardUserTable::getInstance()->updateUserLog($username, $time_now);
                            $this->getUser()->setFlash('error', $i18n->__('Your account has been locked out for 10 minutes.'));

                            return;
                        }
                        if ($form['username']->hasError()) {
                            // insert vao vt-user-log
                            $vt_user_log = new VtUserSigninLock();
                            $vt_user_log->setUserName($username);
                            $vt_user_log->setCreatedTime($time_now);
                            $vt_user_log->save();
                        }
                    }
                }
            } else {
                if ($form->isValid()) {
                    $user->setIpAddress($this->getRequest()->getHttpHeader('addr', 'remote'));
                    $user->setUserAgent($this->getRequest()->getHttpHeader('User-Agent'));
                    $username = $form['username']->getValue();
                    if ($username && $sf_user = sfGuardUserTable::getInstance()->getUserByUsername($username)) {
                        if ((time() - strtotime($sf_user->getPassUpdateAt()) > sfConfig::get('app_passuser_lifetime', 7776000))) {
                            $sf_user->setPassUpdateAt(date('Y-m-d H:i:s', time()));
                            $sf_user->setPassword($form['new_password']->getValue());
                            $sf_user->save();
                            $this->getUser()->setFlash('info', $i18n->__('Password successfully changed.'));
                        }
                    }
                    $this->getUser()->signin($form->getValue('user'), $form->getValue('remember'));

                    // always redirect to a URL set in app.yml
                    // or to the referer
                    // or to the homepage
                    $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer($request->getReferer()));
	                
	                  //hoangbh1 add sau khi user change pass lan dau thi xoa log neu truoc do dang nhap sai
	                  TblUserSigninLogTable::getInstance()->resetUserSigninLock($username);

                    return $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');
                }
            }
        } else {
            if ($request->isXmlHttpRequest()) {
                $this->getResponse()->setHeaderOnly(true);
                $this->getResponse()->setStatusCode(401);

                return sfView::NONE;
            }

            // if we have been forwarded, then the referer is the current URL
            // if not, this is the referer of the current request
            $user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

            $module = sfConfig::get('sf_login_module');
            if ($this->getModuleName() != $module) {
                return $this->redirect($module . '/' . sfConfig::get('sf_login_action'));
            }

            $this->getResponse()->setStatusCode(401);
        }
    }

    public function executeSignout($request)
    {
        $this->getUser()->signOut();

        $signoutUrl = sfConfig::get('app_sf_guard_plugin_success_signout_url', $request->getReferer());

        $this->redirect('' != $signoutUrl ? $signoutUrl : '@homepage');
    }

    public function executeSecure($request)
    {
        $this->getResponse()->setStatusCode(403);
    }

    public function executePassword($request)
    {
        throw new sfException('This method is not yet implemented.');
    }

    public function executeChangePassword($request)
    {
        $this->form = new VtGuardChangePasswordForm();

        if ($request->isMethod(sfRequest::POST)) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $username = $this->form->getValue('username');
                if ($username && $sf_user = sfGuardUserTable::getInstance()->getUserByUsername($username)) {
                    $sf_user->setPassUpdateAt(date('Y-m-d H:i:s', time()));
                    $sf_user->setPassword($this->form->getValue('new_password'));
                    $sf_user->save();
                    $this->getUser()->setFlash('info', sfContext::getInstance()->getI18N()->__('Password successfully changed.'));
                }
            }
        }
      $this->getResponse()->setTitle('Thay đổi mật khẩu');
    }
}
