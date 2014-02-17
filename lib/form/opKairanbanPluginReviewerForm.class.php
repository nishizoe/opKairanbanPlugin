<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opKairanbanPluginMemberForm.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Kaoru Nishizoe <nishizoe@tejimaya.com>
 */
class opKairanbanPluginReviewerForm extends KairanbanReviewerForm
{
  public function configure()
  {
    $members = Doctrine::getTable('Member')->createQuery('m')
      ->addWhere('m.is_active = ?', '1')
      ->execute();
    if (0 < count($members))
    {
      $choices = array();
      foreach ($members as $member)
      {
        $choices[$member->id] = $member->name;
      }
      $this->setWidget('member_id', new sfWidgetFormChoice(array('choices' => array('' => '') + $choices, 'label' => false)));
    }
  }
}