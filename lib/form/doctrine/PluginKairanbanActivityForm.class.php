<?php

/**
 * PluginKairanbanActivity form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Kaoru Nishizoe <nishizoe@tejimaya.com>
 */
abstract class PluginKairanbanActivityForm extends BaseKairanbanActivityForm
{
  public function setup()
  {
    parent::setup();
    $this->setWidget('kairanban_id', new sfWidgetFormInputHidden());
    $this->setWidget('member_id', new sfWidgetFormInputHidden());

    unset($this['id']);
    $this->useFields(array('body'));
    $options = array(
      'label'        => false,
    );
  }
}
