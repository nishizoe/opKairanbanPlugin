<?php

/**
 * PluginKairanbanLink form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Kaoru Nishizoe <nishizoe@tejimaya.com>
 */
abstract class PluginKairanbanLinkForm extends BaseKairanbanLinkForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    $this->useFields(array('url'));
    $options = array(
      'label'        => false,
    );

    $this->setWidget('url', new sfWidgetFormInput($options));

    $this->setValidator('url', new opValidatorString(array('rtrim' => true)));
  }
}
