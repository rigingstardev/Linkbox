// clcik continue button on Add patient pop up 
// validates inputs, if pass, initialize and shows modal pop up to enter text message
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



function hideModal(modalDiv, field) {
   $('#' + modalDiv).modal('hide');
   if (field != '')
      $('#' + field).val('');
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