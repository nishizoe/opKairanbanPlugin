<?php use_helper('I18N') ?>
<?php use_helper('Date') ?>
<form name="editKairanbanForm" id="editKairanbanForm">
  <input type="hidden" id="editKairanbanType" name="editKairanbanType" value="">
  <input type="hidden" id="apiKeyEditKairanban" name="apiKey" value="">
  <table id="kairanban_edit_form" class="table table-striped table-bordered">
    <tbody>
      <?php if($member->id == $kairanban->getMember()->getId()): ?>
        <?php echo $form ?>
      <?php else: ?>
        <tr>
          <th><?php echo $form['title']->renderLabel() ?></th>
          <td><?php echo $kairanbanForm->get('title') ?></td>
        </tr>
        <tr>
          <th><?php echo $form['body']->renderLabel() ?></th>
          <td><?php echo $kairanbanForm->get('body') ?></td>
        </tr>
        <tr>
          <th><?php echo $form['community_id']->renderLabel() ?></th>
          <td><?php echo $kairanbanForm->getCommunity()->getName() ?></td>
        </tr>
        <tr>
          <th><?php echo $form['due_date']->renderLabel() ?></th>
          <td><?php echo $kairanbanForm->get('due_date') ?></td>
        </tr>
        <?php $kairanbanLinks = $kairanbanForm->getKairanbanLink() ?>
        <?php foreach ($kairanbanLinks as $kairanbanLink): ?>
          <tr>
            <th><?php echo __('url'); ?></th>
            <td><?php echo $kairanbanLink['url'] ?></td>
          </tr>
        <?php endforeach; ?>
        <?php $kairanbanReviewers = $kairanbanForm->getKairanbanReviewer() ?>
        <?php foreach ($kairanbanReviewers as $kairanbanReviewer): ?>
          <tr>
            <th><?php echo __('reviewer'); ?></th>
            <td><?php echo $kairanbanReviewer->getMember()->getName() ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
    <tfoot>
    <?php if($member->id == $kairanban->getMember()->getId()): ?>
    <tr>
      <td colspan="2" class="control-button">
        <input type="button" class="btn btn-primary" id="editKairanbanTrigger" value="<?php echo __('Edit') ?>" />
      </td>
    </tr>
    <?php endif; ?>
    </tfoot>
  </table>
</form>
<?php if ($member->id == $kairanbanReviewerForm->getMemberId()): ?>
<h2><?php echo __('Confirmation'); ?></h2>
<form name="editKairanbanReviewerForm" id="editKairanbanReviewerForm">
  <input type="hidden" id="apiKeyEditKairanbanReviewer" name="apiKey" value="">
  <table id="kairanban_reviewer_edit_form" class="table table-striped table-bordered">
    <tbody>
      <?php echo $formReviewer ?>
    </tbody>
  </table>
</form>
<?php endif; ?>
<h2><?php echo __('Activity'); ?></h2>
<form name="addKairanbanActivityForm" id="addKairanbanActivityForm">
  <input type="hidden" id="addKairanbanActivityKairanbanId" name="kairanban_activity_kairanban_id" value="">
  <input type="hidden" id="apiKeyAddKairanbanActivity" name="apiKey" value="">
  <table id="kairanban_activity_add_form" class="table table-striped table-bordered">
    <tbody>
      <?php echo $formActivity ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2" class="control-button">
          <input type="button" class="btn btn-primary" id="addKairanbanActivityTrigger" value="<?php echo __('Add') ?>" />
        </td>
      </tr>
    </tfoot>
  </table>
</form>
<table id="kairanban-activities" class="table table-bordered">
  <tbody>
<?php foreach ($kairanbanActivities as $kairanbanActivity): ?>
    <tr>
      <?php if (null != $kairanbanActivity->getMember()->getName()): ?>
      <th><?php echo $kairanbanActivity->getMember()->getName() ?></th>
      <?php else: ?>
      <th><?php echo __('System Message'); ?></th>
      <?php endif; ?>
      <td rowspan="2"><?php echo $kairanbanActivity->body ?></td>
    </tr>
    <tr>
      <td><?php echo format_date($kairanbanActivity->created_at, 'yyyy/MM/dd<br />HH:mm') ?></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
