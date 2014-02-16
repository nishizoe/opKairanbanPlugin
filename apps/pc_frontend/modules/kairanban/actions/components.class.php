<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * kairanban components.
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Kaoru Nishizoe <nishizoe@tejimaya.com>
 */
class kairanbanComponents extends sfComponents
{
  public function executeMenu()
  {
    $this->form = new KairanbanForm();
    $this->member = $this->getUser()->getMember();
    $kairanban = new opKairanbanPluginKairanban();
    $this->sentKairanbanList = $kairanban->getSentKairanbanListByMemberId($this->member->id);
    $this->receivedKairanbanList = $kairanban->getReceivedKairanbanListByMemberId($this->member->id);
  }
}
