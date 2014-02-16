$(document).ready(function(){
  $('#kairanban-menu').detach().insertAfter('.nav.pull-right:first').show();

  $('#addKairanbanTrigger').on('click', function(event){
    addKairanban();
  });

  $('#tabSent a').click(function(event){
    getKairanban(this, event, 'sent');
  });

  $('#tabReceived a').click(function(event){
    getKairanban(this, event, 'received');
  });
});

function addKairanban(){
  var form = $('#addKairanbanForm');
  var url = 'kairanban/addkairanban.json';

  $('#apiKey').val(openpne.apiKey);
  $.ajax({
    type: 'POST',
    url: openpne.apiBase + url,
    data:  form.serialize(),
    dataType: 'json',
    success: function(data){
      $('#kairanban-modal-add').modal('hide');
      $('#kairanban-modal-list').modal('show');
    },
    error: function(data){
      alert('Failed to get data.');
    }
  });
};

function showEmptyKairanban(){
  var data = {};
  data['apiKey'] = openpne.apiKey;
  $.ajax({
    type: 'GET',
    url: openpne.apiBase + 'kairanban/emptykairanban.json',
    data:  data,
    dataType: 'html',
    success: function(data){
      $('#addDetailBody > *').remove();
      $('#addDetailBody').html(data);
    },
    error: function(data){
      alert('Failed to get data.');
    }
  });
};

function getKairanban(element, event, type){
  var id = '';
  if (element != 'undefined' && element.href != 'undefined'){
    var tmpUrl = element.href.split('#');
    id = tmpUrl[tmpUrl.length - 1];
  }
  getKairanbanData(id, type, event);
};

function getKairanbanData(id, type, event){
  var data = {};
  data['apiKey'] = openpne.apiKey;
  data['id'] = id;
  data['type'] = type;
  $.ajax({
    type: 'GET',
    url: openpne.apiBase + 'kairanban/getkairanban.json',
    data:  data,
    dataType: 'html',
    success: function(data){
      $('#getDetailBody > *').remove();
      $('#getDetailBody').html(data);
      $('#kairanban-modal-list').modal('hide');
      $('#kairanban-modal-get').modal('show');

      $('#kairanban_reviewer_is_allow').on('click', function(){
        editKairanbanReviewer();
      });
      $('#addKairanbanActivityTrigger').on('click', function(){
        addKairanbanActivity();
      });
      $('#editKairanbanTrigger').on('click', function(event){
        editKairanban();
      });
//      $('#kairanban_kairanban_id').val(id);
      $('#editKairanbanType').val(type);
    },
    error: function(data){
      alert('Failed to get data.');
    }
  });

  if (event){
    event.preventDefault();
  }
};

function addKairanbanActivity(){
  var form = $('#addKairanbanActivityForm');
  var url = 'kairanban/addkairanbanactivity.json';

  $('#addKairanbanActivityKairanbanId').val($('#kairanban_id').val());
  $('#apiKeyAddKairanbanActivity').val(openpne.apiKey);
  $.ajax({
    type: 'POST',
    url: openpne.apiBase + url,
    data:  form.serialize(),
    dataType: 'json',
    success: function(data){
      getKairanbanData($('#kairanban_id').val(), $('#editKairanbanType').val(), null);
    },
    error: function(data){
      alert('Failed to get data.');
    }
  });
};

function editKairanbanReviewer(){
  var form = $('#editKairanbanReviewerForm');
  var url = 'kairanban/editkairanbanreviewr.json';
//  $('#editKairanbanReviewerKairanbanId').val($('#kairanban_kairanban_id').val());
  $('#apiKeyEditKairanbanReviewer').val(openpne.apiKey);
  $.ajax({
    type: 'POST',
    url: openpne.apiBase + url,
    data:  form.serialize(),
    dataType: 'json',
    success: function(data){
//      getKairanbanData($('#kairanban_kairanban_id').val(), $('#editKairanbanType').val(), null);
    },
    error: function(data){
      alert('Failed to get data.');
    }
  });
};

function editKairanban(){
  var form = $('#editKairanbanForm');
  var url = 'kairanban/editkairanban.json';

  $('#apiKeyEditKairanban').val(openpne.apiKey);
  $.ajax({
    type: 'POST',
    url: openpne.apiBase + url,
    data:  form.serialize(),
    dataType: 'json',
    success: function(data){
      getKairanbanData($('#kairanban_id').val(), $('#editKairanbanType').val(), null);
    },
    error: function(data){
      alert('Failed to get data.');
    }
  });
};
