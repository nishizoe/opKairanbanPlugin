<ul id="kairanban-menu" class="nav pull-right" style="display: none">
  <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" onclick="$('#kairanban-modal-list').modal('show')" title="<?php echo __('Circular Notice'); ?>">
      <i class="fa fa-pencil-square-o"></i>
    </a>
  </li>
</ul>

<div id="kairanban-modal-list" class="modal kairan-modal" tabindex="-1" style="display: none;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3><?php echo __('Circular Notice'); ?></h3>
  </div>
  <div class="tabbable">
    <ul id="myTab" class="nav nav-tabs">
      <li class="active"><a href="#tabSent" data-toggle="tab"><?php echo __('Sent'); ?></a></li>
      <li><a href="#tabReceived" data-toggle="tab"><?php echo __('Received'); ?></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tabSent">
        <?php foreach ($sentKairanbanList as $sentKairanban): ?>
          <div class="progress progress-info progress-striped">
            <span class="bar" style="width: <?php echo $sentKairanban['rate'] ?>%;"></span>
            <a href="#<?php echo $sentKairanban['kairanban_id'] ?>" class="pull-left">
              <?php echo $sentKairanban['title'] ?> [ <?php echo $sentKairanban['rate'] ?>% ]
            </a>
            <span class="alert alert-<?php echo $sentKairanban['css_class'] ?> pull-right"><?php echo $sentKairanban['due_date_caption'] ?><br />( <?php echo $sentKairanban['due_date'] ?> )</span>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="tab-pane" id="tabReceived">
        <?php foreach ($receivedKairanbanList as $receivedKairanban): ?>
          <div class="progress progress-info progress-striped">
            <span class="bar" style="width: <?php echo $receivedKairanban['rate'] ?>%;"></span>
            <a href="#<?php echo $receivedKairanban['kairanban_id'] ?>" class="pull-left">
              <?php echo $receivedKairanban['title'] ?> [ <?php echo $receivedKairanban['rate'] ?>% ]
            </a>
            <span class="alert alert-<?php echo $receivedKairanban['css_class'] ?> pull-right"><?php echo $receivedKairanban['due_date_caption'] ?><br />( <?php echo $receivedKairanban['due_date'] ?> )</span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary">
      <span onclick="$('#kairanban-modal-list').modal('hide');$('#kairanban-modal-add').modal('show');showEmptyKairanban();"><?php echo __('Add'); ?></span>
    </button>
  </div>
</div>
<div id="kairanban-modal-add" class="modal kairan-modal" tabindex="-1" style="display: none;">
  <div class="modal-header">
    <button class="close">
      <span onclick="$('#kairanban-modal-add').modal('hide');$('#kairanban-modal-list').modal('show');">&times;</span>
    </button>
    <h3><?php echo __('Circular Notice'); ?></h3>
  </div>
  <div class="modal-body">
    <form name="addKairanbanForm" id="addKairanbanForm">
      <input type="hidden" id="apiKey" name="apiKey" value="">
      <table id="kairanban_add_form">
        <tbody id="addDetailBody">
        </tbody>
        <tfoot>
        <tr>
          <td colspan="2">
            <input type="button" id="addKairanbanTrigger" value="add" />
          </td>
        </tr>
        </tfoot>
      </table>
    </form>
  </div>
</div>

<div id="kairanban-modal-get" class="modal kairan-modal" tabindex="-1" style="display: none;">
  <div class="modal-header">
    <button class="close">
      <span onclick="$('#kairanban-modal-get').modal('hide');$('#kairanban-modal-list').modal('show');">&times;</span>
    </button>
    <h3><?php echo __('Circular Notice'); ?></h3>
  </div>
  <div class="modal-body" id="getDetailBody">
  </div>
</div>
