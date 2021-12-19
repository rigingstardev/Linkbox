function setOrResetAdminOptions(uType, uid, flagType) {
   $(".loader").fadeIn();   
   var setFlag = 'N', timeOutAlert = 3000, reason = '', confmMsg;
   if (flagType == 'sponsored') {
      if ($('#checkbox2').prop('checked'))
         setFlag = 'Y'
      else {
         var confrm = confirm(params.confirm_sponsored_settings);
         if (confrm)
            setFlag = 'N';
         else
            return false;
      }
   }
   if (flagType == 'unpublishMe') {
      $('.' + params.errorClass).remove();
      if ($('#reason-' + uid).val() == '') {
         $('#reason-' + uid).after('<div class="' + params.errorClass + '">' + params.specify_reason + "</div>")
         return false;
      } else {
         reason = $('#reason-' + uid).val();
      }
   }
   if (flagType == 'Active' || flagType == 'Inactive') {
      if (uType == 'patient')
         confmMsg = params.confrm_patient_to_inactivate;
      else if (uType == 'physician')
         confmMsg = params.confrm_physician_to_inactivate;

      if (flagType == 'Inactive')
         if (uType == 'patient')
            confmMsg = params.confrm_patient_to_activate;
         else if (uType == 'physician')
            confmMsg = params.confrm_physician_to_activate;
      var confrm = confirm(confmMsg);
      if (!confrm){
         $(".loader").fadeOut();
         return false;
      }
   }
   if (flagType == 'Unlock') {
      if (uType == 'patient')
         confmMsg = params.confrm_patient_to_open;
      else if (uType == 'physician')
         confmMsg = params.confrm_physician_to_open;
      var confrm = confirm(confmMsg);
      if (!confrm) {
         $(".loader").fadeOut();
         return false;
      }
   }
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/admin/setFlags',
      data: {'_token': $('input[name=_token]').val(), 'setFlag': setFlag, 'flagType': flagType, 'uid': uid, 'uType': uType, 'reason': reason},
      success: function (response) {
         $(".loader").fadeOut();
         var respData = JSON.parse(response);

         if (respData.success == 'true') {
            $('.auto_fade').removeClass('hidden');
            if (flagType == 'sponsored' || flagType == 'unpublishMe' || flagType == 'Active' || flagType == 'Inactive' || flagType == 'Unlock') {
               $('.section-class').removeClass('hidden');
               $('#div-alert').html(respData.message);
               $('#divUnpublish' + uid).modal('hide');
            }

            if (flagType == 'unpublishMe')
               $('#question-set-' + uid).fadeOut('slow');
            if (flagType == 'Active' || flagType == 'Inactive')
               makeStatusChanges(uType, flagType, uid);
               if (flagType == 'Unlock')
               makeAccessChanges(uType, flagType, uid);
            setTimeout(function () {
               $('.section-class').addClass('hidden');
               $('#div-alert').html('');
               $('.auto_fade').addClass('hidden');
            }, timeOutAlert);
         }
      },
      error: function (response) {
      }
   });
}
function resetUnpublishPopup(uid) {
   $('.' + params.errorClass).remove();
   $('#reason-' + uid).val('');
   setTimeout(function () {
      $('#reason-' + uid).focus();
   }, 800);
}
function  makeStatusChanges(uType, flagType, uid) {
   var newClass = 'label-active', newClassLabel = 'Active';
   if (flagType == 'Active') {
      newClass = 'label-inactive';
      newClassLabel = 'Inactive';
   }
   if (uType == 'patient')
      $('#patientStatus' + uid).attr('onclick', 'setOrResetAdminOptions(\'patient\',\'' + uid + '\', \'' + newClassLabel + '\')').html('<span class="label ' + newClass + '">' + newClassLabel + '</span>');
   else
      $('#physicianStatus' + uid).attr('onclick', 'setOrResetAdminOptions(\'physician\',\'' + uid + '\', \'' + newClassLabel + '\')').html('<span class="label ' + newClass + '">' + newClassLabel + '</span>');
}

function  makeAccessChanges(uType, flagType, uid) {
      var newClass = 'label-active', newClassLabel = 'Open';
      if (flagType == 'Open') {
         newClass = 'label-inactive';
         newClassLabel = 'Unlock';
      }
      if (uType == 'patient')
         $('#patientLocked' + uid).attr('onclick', 'setOrResetAdminOptions(\'patient\',\'' + uid + '\', \'' + newClassLabel + '\')').html('<span class="label ' + newClass + '">' + newClassLabel + '</span>');
      else
         $('#physicianLocked' + uid).attr('onclick', 'setOrResetAdminOptions(\'physician\',\'' + uid + '\', \'' + newClassLabel + '\')').html('<span class="label ' + newClass + '">' + newClassLabel + '</span>');
   }