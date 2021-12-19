// clcik continue button on Add patient pop up 
// validates inputs, if pass, initialize and shows modal pop up to enter text message
$('#continue_qsqt_btn_popup').on('click', function () {
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/checkSendQuestionSet',
      data: $('#postSendQuestionSetPopup').find('input[name!=customMessagePopUp]').serialize(),
      success: function (response) {
         initializeAndShowModalPopUp('modalPopUpSendQS');
      },
      error: function (response) {
         showValidation(response, errorClass);
      }
   });
});
function initializeAndShowModalPopUp(modalDiv) {
   $("#" + modalDiv).modal({
      backdrop: 'static',
      keyboard: false
   });
   $('#' + modalDiv + ' textarea').val('');
   setTimeout(function () {
      $('#' + modalDiv + ' textarea').focus();
   }, 800);
   $('#' + modalDiv).modal('show');
}
$('#send_qsqt_btn_popup').on('click', function () {
   sendQS('#send_qsqt_btn_popup');
});
$('#btnSend').on('click', function () {
   sendQS('#btnSend');
});
$('#btnContinue').on('click', function () {
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
   var dataArray = $('#postSendQuestionSet').find('input[name!=customMessage]').serialize();
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/checkSendQuestionSet',
      data: dataArray,
      success: function (response) {
         initializeAndShowModalPopUp('modalPopUpBtnSendQS');
      },
      error: function (response) {
         showValidation(response, errorClass);
      }
   });
});

function hideModal(modalDiv, field) {
   $('#' + modalDiv).modal('hide');
   if (field != '')
      $('#' + field).val('');
}
function sendQS(btn) {
   disableButton(btn);
   var errorClass = params.errorClass, frmSrlz;
   removeWithClass(errorClass);
   if (btn == '#send_qsqt_btn_popup')
      frmSrlz = '#postSendQuestionSetPopup';
   else if (btn == '#btnSend')
      frmSrlz = '#postSendQuestionSet';
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/postSendQuestionSet',
      data: $(frmSrlz).serialize(),
      success: function (response) {
         hideModal('modalPopUpSendQS', 'customMessagePopUp');
         var respArray = JSON.parse(response);
         if (respArray.success == 'true') {
            $('.check_boxes').prop('checked', false);
            hideModal('modalPopUpBtnSendQS', '');
            hideModal('myModal2', '');
            location.reload();
            sendAndShowDBChangeAlert('success', respArray.message);
         }
         enableButton(btn);
      },
      error: function (response) {
         enableButton(btn);
         showValidation(response, errorClass);
      }
   });
}
// update notificatin
function checkClinicalQuestions(qid, qrid, types) {
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/checkClinicalQuestion',
      data: {"qid": qid, "qrid": qrid, "types": types, '_token': $('input[name=_token]').val()},
      success: function (response) {
         if (response.c > 0) {
            var confrm = confirm('Would you like to answer the remaining clinical questions?');
            if (confrm) {
               window.location.href = response.t;
               return false;
            } else {
               window.location.href = response.f;
            }
         } else {
            window.location.href = response.f;
         }
      }
   });
   return false;
}
var prevBox = '';
function enableSendBtn(type, f) {
   if ($(f).prop('checked')) {
      $('#' + type).removeAttr('disabled').focus();
      if (type == 'phone') {
         $('#country_code').removeAttr('disabled').focus();
      }
   }
   else {
      $('#' + type).attr('disabled', 'disabled').val('');
   }
   if (type == 'phone') {
      $('#country_code').prop('disabled', false);
      $('#chkBxEmail').prop('checked', false)
      $('#email').attr('disabled', 'disabled').val('');
   }
   if (type == 'email') {
      $('#country_code').prop('disabled', true);
      $('#chkBxText').prop('checked', false);
      $('#phone').attr('disabled', 'disabled').val('');
      $('#country_code').attr('disabled', 'disabled').val('');
   }
   if ($('#chkBxEmail').prop('checked') || $('#chkBxText').prop('checked'))
      $('#btnContinue').removeAttr('disabled');
   else
      $('#btnContinue').attr('disabled', 'disabled');
}
$(".send-qs").val('');
$('#chkBxEmail').prop('checked', false);
$('#chkBxText').prop('checked', false);

function resendQuestionSet(pid, qid, rid) {
   var conf = confirm('Do you really want to resend this Question set?')
   if (!conf)
      return false;
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/resendQuestionSet',
      data: {"pid": pid, "qid": qid, "rid": rid, '_token': $('input[name=_token]').val()},
      success: function (response) {
         var respArray = JSON.parse(response);
         if (respArray.success == 'true') {
            showDBChangeAlert('success', respArray.message);
         }
      },
      error: function (response) {
      }
   });
}