$(document).on('click', '.post-question-set', function () {
   // showing loader in form
   showLoader();
   // disable the click button 
   disableButton('.post-question-set');
   // reset form validation with error class
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
   // submitting data
   $.ajax({
      type: "POST",
      url: $('#frmQuestionSet').attr('action'),
      data: $('#frmQuestionSet').serialize(),
      success: function (response) {
         var respArray = JSON.parse(response);
           $.each(respArray, function (key, value) {
            if (value == true) {
             showDBChangeAlert('success', params.dbChangeSuccess);
               setTimeout(function () {
                  $(location).attr("href", params.site_url_path + respArray['redirectUrl']);
               }, 750);               
            } else {
            showDBChangeAlert('error', params.dbChangeError);
            }
         });
      },
      error: function (response) {
         showValidation(response, errorClass);
      }
   });
});