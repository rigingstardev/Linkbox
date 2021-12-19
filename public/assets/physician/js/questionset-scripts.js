$(document).on('click', '.post-question-set', function () {
   // showing loader in form
   showLoader();
   // disable the click button
   disableButton('.post-question-set');
   // reset form validation with error class
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
   // submitting data
   insertQuestion(params, errorClass);
});
$("#editImage").on("hidden.bs.modal", function () {
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
});
$("#myModal2").on("hidden.bs.modal", function () {
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
   if ($('#profile-div').length > 0)
      $('#profile-div input:text').val('');
   else
      $('input:text').val('');
   clearAlertMessages();
   // reseting the display page number to first page
   var oTable = $('#patients').dataTable();
   oTable.fnPageChange('first');
});
$("#myModal").on("hidden.bs.modal", function () {
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
   $('#frmCategory')[0].reset();
   $('#other_question').addClass('hidden');
});

// show edit fields for question title and description
$("#questionset-edit-btn").click(function () {
   $("#questionset-edit").removeClass('hidden');
   $("#chiefComplaint").focus();
   $("#questionset-view").addClass('hidden');
});
// edit question title and description
$("#questionset-done-btn").click(function () {
   disableButton('#questionset-done-btn');
   // reset form validation with error class
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
   // submitting data
   insertQuestion(params, errorClass);
});
// show edit fields for question title and description
$("#defaultoutput-edit-btn").click(function () {
   $("#defaultoutput-edit").removeClass('hidden');
   $("#chiefComplaint").focus();
   $("#defaultoutput-view").addClass('hidden');
});
// edit question title and description
$("#defaultoutput-done-btn").click(function () {
   disableButton('#defaultoutput-done-btn');
   // reset form validation with error class
   var errorClass = params.errorClass;
   removeWithClass(errorClass);  
   // submitting data
   //insertQuestion(params, errorClass);
   $.ajax({
      type: "POST",
      url: $('#frmQuestionSetNarrativeOutput').attr('action'),
      data: $('#frmQuestionSetNarrativeOutput').serialize(),
      success: function (response) {         
         enableButton('#defaultoutput-done-btn');
         var respArray = JSON.parse(response);         
         $.each(respArray, function (key, value) {
            if (value == true) {
//               showDBChangeAlert('success', params.dbChangeSuccess);
               setTimeout(function () {
                  $(location).attr("href", params.site_url_path + respArray['redirectUrl']);
               }, 100);
            }
         });
      },
      error: function (response) {        
         enableButton('#defaultoutput-done-btn');
         showValidation(response, errorClass);
      }
   });
});
// cancel edit window and show labels
$("#defaultoutput-cancel-btn").click(function () {
   $("#defaultoutput-edit").addClass('hidden');
   $("#defaultoutput-view").removeClass('hidden');
});
function insertQuestion(params, errorClass) {
   $.ajax({
      type: "POST",
      url: $('#frmQuestionSet').attr('action'),
      data: $('#frmQuestionSet').serialize(),
      success: function (response) {
         enableButton('.post-question-set');
         enableButton('#questionset-done-btn');
         var respArray = JSON.parse(response);
         $.each(respArray, function (key, value) {
            if (value == true) {
//               showDBChangeAlert('success', params.dbChangeSuccess);
               setTimeout(function () {
                  $(location).attr("href", params.site_url_path + respArray['redirectUrl']);
               }, 100);
            }
         });
      },
      error: function (response) {
         enableButton('.post-question-set');
         enableButton('#questionset-done-btn');
         showValidation(response, errorClass);
      }
   });
}
// edit already set category and add new category
function editCategory(params, errorClass) {
   if ($('#categoryCount').val() == $('#totalSelectedCategoryCount').val()) {
      $('#myModal').modal('toggle');
   } else {
      $('#checkFormatType').val('edit');
      $.ajax({
         type: "POST",
         url: $('#frmCategory').attr('action'),
         data: $('#frmCategory').serialize(),
         success: function (response) {
            var respArray = JSON.parse(response);
            $.each(respArray, function (key, value) {
               if (value == true) {
                  showDBChangeAlert('success', params.dbChangeSuccess);
                  $(location).attr("href", params.site_url_path + respArray['redirectUrl']);
               } else {
                  showDBChangeAlert('error', params.dbChangeError);
                  $('#myModal').modal('toggle');
               }
            });
         },
         error: function (response) {
            showValidation(response, errorClass);
         }
      });
   }
}
// cancel edit window and show labels
$("#questionset-cancel-btn").click(function () {
   hideQuestionSetEdit();
});
function hideQuestionSetEdit() {
   $("#questionset-edit").addClass('hidden');
   $("#questionset-view").removeClass('hidden');
}

//   edit category list
$(".update-category-list").click(function () {
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
   editCategory(params, errorClass);
});

function setQuestionFlags(flagType, rid, cid, qid) {
   var flag = 1;
   var timeOut = 500;
   var timeOutAlert = 3000;
   var alertMsg = '', title;
   if (flagType == 'clinicalQuestion') {
      if ($('#clinicalQuestion' + rid).attr('checked') && $('#clinicalQuestion' + rid).hasClass('checked')) {
         flag = 0;
         $('#clinicalQuestion' + rid).removeAttr('class');
         $('#clinicalQuestion' + rid).removeAttr('checked');
         alertMsg = params.unset_clinical_question;
      } else {
         if ((parseInt($('.clinical-question').length) + 1) == $('.question-options').length) {
            alert(params.must_have_clinical_question);
            $('#clinicalQuestion' + rid).removeAttr('class');
            $('#clinicalQuestion' + rid).removeAttr('checked');
            return false;
         }
         $('#clinicalQuestion' + rid).attr('checked', 'checked');
         $('#clinicalQuestion' + rid).attr('class', 'checked clinical-question');
         alertMsg = params.set_as_clinical_question;
      }
   } else if (flagType == 'disable') {
      var currentFlag = $('#question-status-' + rid).attr("data-original-title");
      var changeFlag = 'Enabled';
      if (currentFlag == 'Enabled') {
         flag = 0;
         changeFlag = 'Disabled';
         $('#disabled-' + rid).attr('style', 'color:#ccc');
      } else
         $('#disabled-' + rid).removeAttr('style');
      $('#question-status-' + rid).attr("title", changeFlag);
      $('#question-status-' + rid).attr("data-original-title", changeFlag).tooltip('show');
   } else if (flagType == 'delete') {
      timeOut = 300;
      var quesCount;
      if ($('a.delete-question').length == 1) {
         alert(params.question_set_cannot_be_empty);
         return false;
      } // there should be at least one question which is not clinical question

      if ($('#clinicalQuestion' + rid).hasClass('clinical-question'))
         quesCount = $('.clinical-question').length;
      else
         quesCount = parseInt($('.clinical-question').length) + 1;
      if (quesCount == $('.question-options').length) {
         alert(params.must_have_clinical_question);
         return false;
      }
      var confm = confirm(params.delete_question_category);
      if (!confm)
         return false;
   } else if (flagType == 'copy') {
      var confm = confirm(params.copy_question_category);
      if (!confm)
         return false;

   } else if (flagType == 'visibility') {
      var newType = rid;
      var confm = confirm(params.change_question_visibility + newType + '?');
      if (!confm)
         return false;
   } else if (flagType == 'duplicate') {
      var errorClass = params.errorClass;
      removeWithClass(errorClass);
      if ($.trim($('#title' + qid).val()) == '') {
         $('#title' + qid).after('<div class="' + errorClass + '">' + params.specify_title + '</div>');
         return false;
      }
      title = $.trim($('#title' + qid).val());
      $('#send_qsqt_btn_popup').attr('disabled');
   }
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/set-flags',
      data: {"flagType": flagType, "rid": rid, "cid": cid, "qid": qid, "flag": flag, "title": title, '_token': $('input[name=_token]').val()},
      success: function (response) {
         $('.auto_fade').removeClass('hidden');
         if (changeFlag == 'Disabled')
            $('#div-alert').html(response);
         else if (changeFlag == 'Enabled')
            $('#div-alert').html(params.enabled_question_category_success);
         else if (flagType == 'copy')
            $('#div-alert').html(params.copy_question_category_success);
         else if (flagType == 'delete') {
            $('#div-alert').html(params.delete_question_category_success);
            $('#view-question-settings-' + rid).remove();
            $('#edit-question-settings-' + rid).remove();
         } else if (flagType == 'clinicalQuestion') {
            $('#div-alert').html(alertMsg);
         } else if (flagType == 'visibility') {
            if (response.error_code == 401) {
               $('#div-alert').html('Unauthorized').parent().css({'background-color': '#ff0000', 'color': '#ffffff'});
            } else {
               $('#div-alert').html(response + newType + '.');
            }
         } else if (flagType == 'duplicate') {
            if (response.flag == 'success') {
               $('#duplicateQSet' + qid).modal('hide');
               $('#div-alert').html(params.copy_question_success);
               setTimeout(function () {
                  window.location.href = params.site_url_path + response.url;
               }, timeOutAlert);
            }
         }
         // resetting alert div
         setTimeout(function () {
            $('#div-alert').html('');
            $('.auto_fade').addClass('hidden');
         }, timeOutAlert);
         if (flagType == 'visibility') {
            if (response.error_code != 401) {
               // set options
               setStatusToQuestionSet(rid, qid);
            }
         }
         if (flagType == 'copy' || flagType == 'delete') {
            setTimeout(function () {
               window.location.reload();
            }, timeOut);
         }
         var flag = 1;
      }
   });
}
function setStatusToQuestionSet(rid, qid) {

   var setType = 'Public';
   if (rid == 'Public')
      setType = 'Private';

   if ($('#make-question').length > 0) {
      $('#question-set-status').html('Question Set Status: <b>' + rid + '</b>');

      $('#make-question').html('Make ' + setType).attr('onclick', "setQuestionFlags('visibility', '" + setType + "', 0, " + qid + ")");
   } else {
      var setClass = 'label-private', rmClass = 'label-public';
      if (rid == 'Public') {
         setClass = 'label-public';
         rmClass = 'label-private';
      }
      $('#changeQestion' + qid).html(rid).addClass(setClass).removeClass(rmClass).attr('onclick', "setQuestionFlags('visibility', '" + setType + "', 0, " + qid + ")");
   }
}

$(document).on('keypress', '#description', function () {
   $(this).siblings('div.' + params.errorClass).remove();
   if ($(this).val().length > params.description_max) {
      $(this).after('<div class="' + params.errorClass + '">' + params.description_max_length + '</div>');
      return false;
   }
});
function countChars(field, maxCount) {
   console.log($(field).val());
}

var optionChangedFlag = 0;
var currentRow = 0;
function editQuestionSettings(rid, cid, qid, i, ansType) {

   if ($('#checkAndSetEditQusetion').val() != '') {
      alert(params.alert_another_question_open_for_edit);
      $('#question_opt_1').focus();
      return;
   }
   $('#checkAndSetEditQusetion').val(rid);
   optionChangedFlag = 1;
   currentRow = rid;
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/edit-question-settings',
      data: {"i": i, "rid": rid, "cid": cid, "qid": qid, '_token': $('input[name=_token]').val()},
      success: function (response) {
         $('#view-question-settings-' + rid).hide();
         $('#edit-question-settings-' + rid).removeClass('hidden');
         $('#edit-question-settings-' + rid).html(response);
         $(".selectpicker").selectpicker();
         showAnswerOption(ansType, rid, qid, cid);
      }
   });

}
function resetQuestionSettingsWindow(rid) {
   $('#checkAndSetEditQusetion').val('');
   $('#view-question-settings-' + rid).show();
   $('#clinicalQuestion' + rid).focus();
   $('#edit-question-settings-' + rid).addClass('hidden');
}
function updateQuestionSettings(rid, cid, qid, i) {
   var errorClass = params.errorClass;
   removeWithClass(errorClass);
   disableButton('#done-btn');
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/update-question-settings',
      data: $('#frmEditQuestion' + rid).serialize(),
      success: function (response) { 
         enableButton('#done-btn');
         $('#checkAndSetEditQusetion').val('');
         window.location.reload();
      },
      error: function (response) {
         enableButton('#done-btn');
         showValidation(response, errorClass);
      }
   });
}
function updateQuestionSegments() {
   var question = '';
   var rid = currentRow;
   $('.seg-' + rid).each(function () {
      question = question;
      if ($.trim($(this).val()) == '?')
         question = question + $.trim($(this).val());
      else
         question = question + ' ' + $.trim($(this).val());
   });
   $('#span-question-segment-' + rid).html($.trim(question));
   question = '';
}
$(document).on('keyup', '.question-segment', function () {
   updateQuestionSegments();
});
$(document).on('mousedown ', '.question-segment', function () {
   updateQuestionSegments();
});
// reseting the edit field on page refresh
if (window.performance) {
   if (performance.navigation.type == 1) {
      $('#checkAndSetEditQusetion').val('');
   }
}

function getNarrativeOutput(rid) {
   var nop = '';
   for (var k = 1; k <= 11; k++) {
      if (!($('#narrativeOut-' + rid + '-' + k).hasClass('hidden')))
         nop += $('#narrativeOut-' + rid + '-' + k).val();
   }
   return nop;
}
function showAnswerOption(val, rid, qid, cid) {
   var valueSet, labelQuestionPart1, labelQuestionPart3;
   // checking if the question field is present.
   if ($('#labelQuestionPart1').length == 1) {
      valueSet = 1;
      labelQuestionPart1 = $('#labelQuestionPart1').val();
      labelQuestionPart3 = $('#labelQuestionPart3').val();
   } else
      valueSet = 0;
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/show-answer-option',
      data: {'option': val, 'rid': rid, 'qid': qid, 'cid': cid, 'prev': $('#prevAnsMethod' + rid).val(), 'optionChangedFlag': optionChangedFlag, '_token': $('input[name=_token]').val()},
      success: function (response) {
         $('#show_answer_option_' + rid).html(response);
         $(".selectpicker").selectpicker();
         $('.date-picker').datepicker();
         $('#prevAnsweringMethod' + rid).val($('#prevAnsMethod' + rid).val());
         $('#serialNo' + rid).html($('#serial' + rid).val());
         // checking if the value is present in question field
         if (valueSet == 1) {
            // setting question entered before changing the answer type
            $('#labelQuestionPart1').val(labelQuestionPart1);
            $('#labelQuestionPart3').val(labelQuestionPart3);
            //updating new text in label
            updateQuestionSegments();
         }
         optionChangedFlag = 0;
      }
   });
}
function manageCheckbox(type, rid, currentVal) {
   if (type == 'add') {
      var lastID = parseInt($('#dropDownOptionCount' + rid).val());
      var nextID = lastID + 1;
      var next = nextID;
      $('#dropDownOptionCount' + rid).val(nextID)
      nextID = '-' + rid + '-' + nextID;
      var nextOption = ' <div class="clearfix"></div><div class="checkbox radio-info q-edit-check  mrgn-btm-25" id="dropDownOption' + nextID + '">' +
              '   <input id="dropDownOptionCheck' + nextID + '" name="dropDownOptionCheck' + nextID + '"  value="1" type="checkbox" checked="">' +
              '   <label for="dropDownOptionCheck' + nextID + '" class="col-xs-12 col-sm-8 col-md-6 col-lg-5">' +
              '   <div class="col-xs-11 pdng-lft-0 check-edit-input">' +
              '      <input type="text" class="form-control" name="txtOption' + nextID + '" id="txtOption' + nextID + '" placeholder="">' +
              '   </div>' +
              '   <div class="col-xs-1 pdng-0">' +
              '    <a href="javascript:void(0)" class="txt-red delete-icon" onclick="manageCheckbox(\'delete\', ' + rid + ', ' + next + ')"><i class="fa fa-times"></i></a> ' +
              '   </div>' +
              '</label><div class="clearfix"></div>' +
              '</div>';
      $('#dropDownOptionCount' + rid).before(nextOption);
      $('#txtOption' + nextID).focus();

   } else if (type == 'delete') {
      $('#dropDownOption-' + rid + '-' + currentVal).remove();
   } else if (type == 'dbdelete') {
      var removeId = $('#hiddenID-' + rid + '-' + currentVal).val()
      $('#dropDownOptionCount' + rid).after('<input type="hidden" name="removeOption-' + rid + '-' + currentVal + '" id="removeOption-' + rid + '-' + currentVal + '" value="' + removeId + '" >');
      $('#dropDownOption-' + rid + '-' + currentVal).remove();
   }
}
function buildQuestionSet(qid) {
   var conf = confirm(params.build_question_confirm);
   if (!conf)
      return false;

   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/buiild-this-question-set',
      data: {'qid': qid, '_token': $('input[name=_token]').val()},
      success: function (response) {
         var respArray = JSON.parse(response);
         $.each(respArray, function (key, value) {
            if (value == true) {
               showDBChangeAlert('success', params.dbChangeSuccess);
               setTimeout(function () {
                  $(location).attr("href", params.site_url_path + respArray['redirectUrl']);
               }, 500);
            } else {
               showDBChangeAlert('error', params.dbChangeError);
            }
         });
      }
   });
}
function alertNotImplemented() {
   alert('Not implemented');
}
function selectOrDeselectQuestions(categoryId, field, questionId) {
   if (field == 'masterQuestion') {
      if ($('#masterQuestion' + questionId).prop('checked')) {
         $('#masterQuestion' + questionId).addClass('checked-box');
         $('#category' + categoryId).prop('checked', $('#masterQuestion' + questionId).is(':checked'));
         $('#category' + categoryId).removeAttr('disabled');
      } else {
         $('#masterQuestion' + questionId).removeClass('checked-box');
         if ($('.question-' + categoryId + '.checked-box').length == 0 && $.trim($('#selectedQuestionsCount-' + categoryId).val()) == 0)
            $('#category' + categoryId).prop('checked', $('.question-' + categoryId + '.checked-box').is(':checked'));
      }
   } else if (field == 'category') {
      var checkDisabled = 0;
      if (!$('#category' + categoryId).prop('checked')) {
         $('.question-' + categoryId).each(function () {
            if ($(this).is(':enabled')) {
               if (!$(this).attr('disabled')) {
                  $(this).addClass('checked-box');
                  $(this).prop('checked', $('#category' + categoryId).is(':checked'));
               }
            } else
               checkDisabled = 1; // checking if any question is disabled
         });
         if (checkDisabled == 1) {
            $('#category' + categoryId).prop('checked', true);
            $('#category' + categoryId).prop('disabled', true);
         }
      } else {
         $('.question-' + categoryId).removeClass('checked-box');
         $('.question-' + categoryId).prop('checked', $('#category' + categoryId).is(':checked'));
      }
   }
}
function getNextQuestionToAsk(ansType, val, rid, qid, cid) {
   var response = '';
   if (val != '') {
      $.ajax({
         type: 'GET',
         url: params.site_url_path + '/physician/get-next-question-on-yesno',
         data: {'_token': $('input[name=_token]').val(), 'ansType': ansType, 'val': val, 'rid': rid, 'qid': qid, 'cid': cid},
         success: function (response) {
            $('#ansYesNo' + ansType + 'Question').html(response).selectpicker('refresh');
         },
         error: function (response) {
         }
      });
   } else
      $('#ansYesNo' + ansType + 'Question').html('<option value=""> </option>').selectpicker('refresh');
}
function deleteQS(qid) {
   if (qid > 0) {
      var errorClass = params.errorClass;
      removeWithClass(errorClass);

      var conf = confirm(params.delete_question_confirm);
      if (!conf)
         return false;
      disableButton('#delete_btn_qs' + qid);
      $.ajax({
         type: 'POST',
         url: params.site_url_path + '/physician/delete-question-set',
         data: {'_token': $('input[name=_token]').val(), 'qid': qid},
         success: function (response) {
            enableButton('#delete_btn_qs' + qid);
            var respArray = JSON.parse(response);
            alert(respArray['message']);
            setTimeout(function () {
               window.location.reload();
            }, 500);
         },
         error: function (response) {
            enableButton('#delete_btn_qs' + qid);
            var respArray = JSON.parse(response.responseText);
            $.each(respArray, function (k, v) {
               alert(v);
            });
         }
      });
   }
}
function duplicateQuestion() {

}

/**
 *------------------------------ To handle Physician Test Preview Starts ------------------------------
 */ 
$(document).on('click', '#sendDataValue', function() {
   var f          = 1;
   var age        = $('#testPreviewAge').val();
   var gender     = $('#testPreviewGender').val();
   var questionId = $('#questionId').val();
   var _token     = $("input[name=_token]").val();
   var error      =  msg =   errors      =  msgs = '';
   if (age == '') {
      msg   = 'Please fill the age field';
      error += '<div class="alert alert-danger">\
                 <strong>Error : </strong> ' + msg + '.\
               </div>';
      $('#errAge').show();
      $('#errAge').html(error);
      f = 0;
   }
   if (gender === '' ) {
      msgs   = 'Please select gender!';
      errors += '<div class="alert alert-danger">\
                 <strong>Error : </strong> ' + msgs + '.\
               </div>';
      $('#errGender').show();
      $('#errGender').html(errors);
      f     = 0;
   }

   if (f != 0) {
      $.ajax({
          url: params.site_url_path + '/physician/question-set-preview-detail',
          type: 'POST',
          data: { age : age, gender : gender, questionId : questionId, _token : _token },
          success: function(response) {
            $('.testPreviewModal').modal('hide');
            window.location.href = params.site_url_path + '/physician/question-set-test-preview-detail/' + questionId + '/show';
         }            
      });
   }

});

// Allow only Numbers
 $("#testPreviewAge").on("keypress keyup blur",function (event) {
   //this.value = this.value.replace(/[^0-9\.]/g,'');
   $(this).val($(this).val().replace(/[^0-9\.]/g,''));
   if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
       event.preventDefault();
   }
});

$(document).on('change', '#testPreviewAge, #testPreviewGender', function() {
   var age        = $('#testPreviewAge').val();
   var gender     = $('#testPreviewGender').val();
   if (age != '') {
      $('#errAge').hide();
   }
   if (gender != '' ) {
      $('#errGender').hide();
   }
});

$(document).on('click', '.testPreviewModal', function() {
   $('#errAge').hide();
   $('#errGender').hide();
   $('#testPreviewAge').val('');
   $('#testPreviewGender').val('');
   var question_id = $(this).data('question_set_id');
   $('#questionId').val(question_id);
});

/**
 *------------------------------ To handle Physician Test Preview Ends ------------------------------
 *
 */ 