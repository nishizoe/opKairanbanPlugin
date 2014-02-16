<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */


/**
 * opMemberCsvList
 *
 * @package    OpenPNE
 * @subpackage model
 * @author     Kaoru Nishizoe <nishizoe@tejimaya.com>
 */
class opKairanbanPluginKairanban extends Doctrine_Table
{
  public function __construct()
  {
  }

  public function getSentKairanbanListByMemberId($memberId)
  {
    $sql = "select";
    $sql .= " k.id as kairanban_id";
    $sql .= ", k.member_id as member_id";
    $sql .= ", k.title as title";
    $sql .= ", DATE_FORMAT(k.due_date,'%Y/%m/%d') as due_date";
    $sql .= ", kr.rate as rate";
    $sql .= ", DATEDIFF(k.due_date, now()) as delta";
    $sql .= " from kairanban k";
    $sql .= " left join";
    $sql .= " (select";
    $sql .= " kairanban_id";
    $sql .= ", round((sum(is_allow) / count(member_id)) * 100) as rate ";
    $sql .= " from kairanban_reviewer";
    $sql .= " group by kairanban_id";
    $sql .= ") kr";
    $sql .= " on k.id = kr.kairanban_id";
    $sql .= " where k.member_id = ?";

    $con = Doctrine_Manager::connection();
    $kairanbanList = $con->fetchAll($sql, array($memberId));

    $result = array();
    foreach ($kairanbanList as $kairanban)
    {
      if (0 > $kairanban['delta'])
      {
        $dueDateCaption = 'overdue';
        $cssClass = 'error';
      }
      else
      {
        $dueDateCaption = $kairanban['delta'].' days after';
        if (0 < $kairanban['delta'] && 7 > $kairanban['delta'])
        {
          $cssClass = 'info';
        }
        else
        {
          $cssClass = 'success';
        }
      }

      $kairanban['due_date_caption'] = $dueDateCaption;
      $kairanban['css_class'] = $cssClass;
      $kairanban = array_merge($kairanban, array('due_date_caption' => $dueDateCaption, 'css_class' => $cssClass));
      $result[] = $kairanban;
    }
    return $result;
  }

  public function getReceivedKairanbanListByMemberId($memberId)
  {
    $sql = "select";
    $sql .= " k.id as kairanban_id";
    $sql .= ", k.member_id as member_id";
    $sql .= ", k.title as title";
    $sql .= ", DATE_FORMAT(k.due_date,'%Y/%m/%d') as due_date";
    $sql .= ", krr.rate as rate";
    $sql .= ", DATEDIFF(k.due_date, now()) as delta";
    $sql .= " from kairanban k";
    $sql .= " inner join";
    $sql .= " (select";
    $sql .= " kr.kairanban_id";
    $sql .= ", round((sum(is_allow) / count(member_id)) * 100) as rate ";
    $sql .= " from kairanban_reviewer kr";
    $sql .= " inner join (select kairanban_id from kairanban_reviewer where member_id = ?) krm";
    $sql .= " on kr.kairanban_id = krm.kairanban_id";
    $sql .= " group by kr.kairanban_id) krr";
    $sql .= " on k.id = krr.kairanban_id";

    $con = Doctrine_Manager::connection();
    $kairanbanList = $con->fetchAll($sql, array($memberId));

    $result = array();
    foreach ($kairanbanList as $kairanban)
    {
      if (0 > $kairanban['delta'])
      {
        $dueDateCaption = 'overdue';
        $cssClass = 'error';
      }
      else
      {
        $dueDateCaption = 'after '.$kairanban['delta'].' days';
        if (0 < $kairanban['delta'] && 7 > $kairanban['delta'])
        {
          $cssClass = 'info';
        }
        else
        {
          $cssClass = 'success';
        }
      }

      $kairanban['due_date_caption'] = $dueDateCaption;
      $kairanban['css_class'] = $cssClass;
      $kairanban = array_merge($kairanban, array('due_date_caption' => $dueDateCaption, 'css_class' => $cssClass));
      $result[] = $kairanban;
    }
    return $result;
  }
}