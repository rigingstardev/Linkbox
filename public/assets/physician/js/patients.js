function sendSummaryReport(pid, qid, rid, rType) {
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
   disableButton('#btnSendReport');
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/send-summary-report',
      data: {"email": $('#email').val(), "pid": pid, "qid": qid, "rid": rid,"rType": rType, "_token": $('input[name=_token]').val()},
      success: function (response) {
         enableButton('#btnSendReport');
         var respData = JSON.parse(response);
         if (respData.status == false)
            $('#email').after('<div class="' + errorClass + '">' + respData.message + '</div>');
         else {
            $('li.email-option').removeClass('open');
            alert(respData.message);
         }
      },
      error: function (response) {
         enableButton('#btnSendReport');
         showValidation(response, errorClass);
      }
   });
}