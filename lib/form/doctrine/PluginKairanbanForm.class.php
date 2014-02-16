<?php

/**
 * PluginKairanban form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Kaoru Nishizoe <nishizoe@tejimaya.com>
 */
abstract class PluginKairanbanForm extends BaseKairanbanForm
{
  public function setup()
  {
    parent::setup();

    $this->setWidget('id', new sfWidgetFormInputHidden());
    $this->setWidget('member_id', new sfWidgetFormInputHidden());
    $this->useFields(array('title', 'body', 'community_id', 'due_date'));

    $dateParam = array(
      'culture'      => sfContext::getInstance()->getUser()->getCulture(),
      'month_format' => 'number',
      'can_be_empty' => true,
    );

    $this->setWidget('title', new sfWidgetFormInput());
    $this->setWidget('body', new sfWidgetFormTextarea());
    $this->setWidget('due_date', new opWidgetFormDate($dateParam));

    $this->setValidator('title', new opValidatorString(array('rtrim' => true)));
    $this->setValidator('body', new opValidatorString(array('rtrim' => true)));

    $validatorDueDate = new sfValidatorCallback(array('callback' => array($this, 'validateDueDate')));
    $this->mergePostValidator($validatorDueDate);

    $links = array();
    if (!$this->isNew())
    {
      $links = $this->getObject()->getKairanbanLink();
    }

    $max = 3;
    for ($i = 0; $i < $max; $i++)
    {
      $key = 'link_'.($i+1);

      if (isset($links[$i]))
      {
        $link = $links[$i];
      }
      else
      {
        $link = new KairanbanLink();
        $link->setKairanban($this->getObject());
      }
      $linkForm = new KairanbanLinkForm($link);
      $linkForm->getWidgetSchema()->setFormFormatterName('list');
      $this->embedForm($key, $linkForm, '<ul id="kairanban_'.$key.'">%content%</ul>');
    }

    $reviewers = array();
    if (!$this->isNew())
    {
      $reviewers = $this->getObject()->getKairanbanReviewer();
    }

    $max = 3;
    for ($i = 0; $i < $max; $i++)
    {
      $key = 'reviewer_'.($i+1);

      if (isset($reviewers[$i]))
      {
        $reviewer = $reviewers[$i];
      }
      else
      {
        $reviewer = new KairanbanReviewer();
        $reviewer->setKairanban($this->getObject());
      }
      $reviewerForm = new opKairanbanPluginReviewerForm($reviewer);
      $reviewerForm->getWidgetSchema()->setFormFormatterName('list');
      $this->embedForm($key, $reviewerForm, '<ul id="kairanban_'.$key.'">%content%</ul>');
    }
  }

  public function validateDueDate($validator, $value)
  {
    if ($this->isNew())
    {
      $dateValidator = new sfValidatorDate(array('min' => strtotime(date('Y-m-d')), 'required' => false), array('min' => 'The due date must be after now.'));

      try
      {
        $value['due_date'] = $dateValidator->clean($value['due_date']);
      }
      catch (sfValidatorError $e)
      {
        throw new sfValidatorErrorSchema($validator, array('due_date' => $e));
      }
    }

    return $value;
  }
}
