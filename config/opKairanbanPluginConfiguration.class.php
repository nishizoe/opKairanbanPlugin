<?php

class opKairanbanPluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    $this->dispatcher->connect('op_action.pre_execute', array($this, 'appendJavascripts'));
  }

  public function appendJavascripts(sfEvent $event)
  {
    $context = sfContext::getInstance();
    if ('pc_frontend' == $context->getConfiguration()->getApplication())
    {
      $event['actionInstance']->getResponse()->addStyleSheet('/opKairanbanPlugin/css/kairanban.css');
      $event['actionInstance']->getResponse()->addJavascript('/opKairanbanPlugin/js/bootstrap.js', 'last');
      $event['actionInstance']->getResponse()->addJavascript('/opKairanbanPlugin/js/kairanban.js', 'last');
    }
  }
}
