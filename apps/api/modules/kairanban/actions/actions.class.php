<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * kairanban actions.
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     kaoru nishizoe <nishizoe@tejimaya.com>
 */
class kairanbanActions extends opJsonApiActions
{
  /**
   * preExecute
   */
  public function preExecute()
  {
    $this->memberId = $this->getUser()->getMemberId();
  }

  public function executeEmptyKairanban(sfWebRequest $request)
  {
    $this->form = new KairanbanForm();
    $this->form->setDefault('member_id', $this->memberId);
    return $this->renderPartial('kairanban/formAdd', array('form' => $this->form));
  }

  public function executeAddKairanban(sfWebRequest $request)
  {
    $kairanban = $request->getParameter('kairanban');

    $form = new KairanbanForm();
    $form->bind($kairanban);

    if ($form->isValid())
    {
      $form->save();
    }else{
      $valierr = $form->getErrorSchema()->getErrors();
      foreach($valierr as $key => $value){
        sfContext::getInstance()->getLogger()->info('['.$key.']:['.$value.']');
      }
    }

    return $this->renderText(json_encode(array('status' => 'success')));
  }

  public function executeGetKairanban(sfWebRequest $request)
  {
    $params = $request->getGetParameters();
    $id = $params['id'];
    $type = $params['type'];

    $this->member = $this->getUser()->getMember();
    $this->kairanban = Doctrine::getTable('Kairanban')->find($id);
    $this->form = new KairanbanForm($this->kairanban);
    $this->kairanbanForm = $this->form->getObject();

    $kairanbanReviewer = Doctrine::getTable('KairanbanReviewer')->getKairanbanReviewrByKairanbanIdAndMemberId($id, $this->memberId);
    $this->formReviewer = new KairanbanReviewerForm($kairanbanReviewer);
    $this->kairanbanReviewerForm = $this->formReviewer->getObject();

    $kairanbanActivities = Doctrine::getTable('KairanbanActivity')->findBy('kairanban_id', $id);
    $this->formActivity = new KairanbanActivityForm();

    return $this->renderPartial(
      'kairanban/formGet'
      , array('member' => $this->member
        , 'kairanban' => $this->kairanban
        , 'kairanbanForm' => $this->kairanbanForm
        , 'form' => $this->form
        , 'formReviewer' => $this->formReviewer
        , 'kairanbanReviewer' => $kairanbanReviewer
        , 'kairanbanReviewerForm' => $this->kairanbanReviewerForm
        , 'formActivity' => $this->formActivity
        , 'kairanbanActivities' => $kairanbanActivities
      )
    );
  }

  public function executeEditKairanbanReviewer(sfWebRequest $request)
  {
    $kairanbanReviewer = $request->getParameter('kairanban_reviewer');
    if (isset($kairanbanReviewer['is_allow']))
    {
      $kairanbanReviewer['is_allow'] = 'on';
    }
    else{
      $kairanbanReviewer['is_allow'] = 'off';
    }

    $kairanbanReviewerData = Doctrine::getTable('KairanbanReviewer')->find($kairanbanReviewer['id']);
    $form = new KairanbanReviewerForm($kairanbanReviewerData);
    $form->bind($kairanbanReviewer);

    if ($form->isValid())
    {
      $form->save();
    }
    else
    {
      $valierr = $form->getErrorSchema()->getErrors();
      foreach($valierr as $key => $value){
        sfContext::getInstance()->getLogger()->err('['.$key.']:['.$value.']');
      }
    }

    return $this->renderText(json_encode(array('status' => 'success')));
  }

  public function executeAddKairanbanActivity(sfWebRequest $request)
  {
    $kairanbanActivity = $request->getParameter('kairanban_activity');
    $kairanbanActivity['kairanban_id'] = $request->getParameter('kairanban_activity_kairanban_id');
    $kairanbanActivity['member_id'] = $this->memberId;

    $form = new KairanbanActivityForm();
    $form->bind($kairanbanActivity);

    if ($form->isValid())
    {
      $form->save();
    }else{
      $valierr = $form->getErrorSchema()->getErrors();
      foreach($valierr as $key => $value){
        sfContext::getInstance()->getLogger()->info('['.$key.']:['.$value.']');
      }
    }

    return $this->renderText(json_encode(array('status' => 'success')));
  }

  public function executeEditKairanban(sfWebRequest $request)
  {
    $kairanban = $request->getParameter('kairanban');

    $kairanbanData = Doctrine::getTable('Kairanban')->find($kairanban['id']);
    $form = new KairanbanForm($kairanbanData);
    $form->bind($kairanban);

    if ($form->isValid())
    {
      $form->save();
    }else{
      $valierr = $form->getErrorSchema()->getErrors();
      foreach($valierr as $key => $value){
        sfContext::getInstance()->getLogger()->info('['.$key.']:['.$value.']');
      }
    }

    return $this->renderText(json_encode(array('status' => 'success')));
  }
}
