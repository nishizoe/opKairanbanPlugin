<?php

/**
 * PluginKairanbanReviewer form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Kaoru Nishizoe <nishizoe@tejimaya.com>
 */
abstract class PluginKairanbanReviewerForm extends BaseKairanbanReviewerForm
{
  public function setup()
  {
    parent::setup();
    $this->setWidget('id', new sfWidgetFormInputHidden());
    $this->setWidget('kairanban_id', new sfWidgetFormInputHidden());
    $this->setWidget('member_id', new sfWidgetFormInputHidden());

//    unset($this['id']);
    $this->useFields(array('is_allow'));

    $this->setWidget('is_allow', new sfWidgetFormInputCheckbox());
    $this->setValidator('is_allow', new sfValidatorBoolean(array('required' => false)));
  }
}
