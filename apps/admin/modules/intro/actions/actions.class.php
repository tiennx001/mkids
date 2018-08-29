<?php

require_once dirname(__FILE__).'/../lib/introGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/introGeneratorHelper.class.php';

/**
 * intro actions.
 *
 * @package    IpCamera
 * @subpackage intro
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class introActions extends autoIntroActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();

    if ($request->getMethod() == 'POST')
    {

      if ($this->form->bindAndValid($request))
      {

        $yamlFile = dirname(__FILE__). '/../config/introData.yml';
        $dumper = new sfYamlDumper();
        $yaml = $dumper->dump($this->form->getValues(), 1);
        try {
          file_put_contents($yamlFile, $yaml);
        } catch (Exception $e) {
          echo $e->getMessage(); die();
        }


        $this->getUser()->setFlash('notice', 'The item was updated successfully.');
        $this->redirectBack();
      }
    }
    foreach($request->getParameter('defaults', array()) as $key => $value)
    {
      $this->form->setDefault($key, $value);
    }

    $this->tld_introduction = null;
    $this->nearRecords = null;
    $this->setTemplate('new');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();

    if ($request->getMethod() == 'POST')
    {
      $values = $request->getParameter('intro', array());

      $this->form->bind($values);
      if ($this->form->isValid())
      {

        $yamlFile = dirname(__FILE__). '/../config/introData.yml';
        $dumper = new sfYamlDumper();
        $yaml = $dumper->dump($this->form->getValues(), 1);
        try {
          file_put_contents($yamlFile, $yaml);
        } catch (Exception $e) {
          echo $e->getMessage(); die();
        }


        $this->getUser()->setFlash('notice', 'The item was updated successfully.');
        $this->redirect('@tld_introduction_intro');
      }
    }

    $this->tld_introduction = null;
    $this->nearRecords = null;

    $this->setTemplate('new');
  }

}
