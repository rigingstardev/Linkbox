 $("#physicianlist").change(function()
 {  
   if($(this).val() > 0)
   {
    var phid = $(this).val();
   }
   else
   {
    var phid = 0;
   }
   $.ajax({
         type: "GET",
         url: params.site_url_path + '/physician/'+phid+'/sidebar',
         data: {},
         success: function (response) {          
            var respArray = response;
            console.log(respArray);
            if(respArray.success)
            {
                $("#sidebarHtml").html(respArray.html);
                window.location.href ='/physician/staff-dashboard';
            }
            else 
            {            
                console.log(respArray);
                showDBChangeAlert('error', params.dbChangeError);            
            }        
         },
         error: function (response) {
            enableButton(btn);
            showValidation(response, errorClass);
         }
    });
 });

if($("#physicianlist").length > 0)
{
  if($("#physicianlist").val() > 0)
  {
    $.ajax({
          type: "GET",
          url: params.site_url_path + '/physician/'+$("#physicianlist").val()+'/sidebar',
          data: {},
          success: function (response) {
              console.log(response);
              
              var respArray = response;
              if(respArray.success)
              {
                  $("#sidebarHtml").html(respArray.html);
              }
              else 
              {            
                  console.log(respArray);
                  showDBChangeAlert('error', params.dbChangeError);            
              }        
          },
          error: function (response) {
              enableButton(btn);
              showValidation(response, errorClass);
          }
    });
  }
  else
  {
    $("#sidebarHtml").html('');
  }
}

function showLoader() {
}
// removing elements with the given class
function removeWithClass(errClass) {
//   alert(errClass);
   $('.' + errClass).remove();
}
function disableButton(fieldVar) {
   $(fieldVar).attr('disabled', 'disabled');
}
function enableButton(fieldVar) {
   $(fieldVar).removeAttr('disabled');
}
function showValidation(response, errClass)
{
   var respArray = JSON.parse(response.responseText);
   var j = 0;
   $.each(respArray, function (k, v) {
      j = parseInt(j) + 1;
      if ("" == k) {
         $('.dberror').after('<div class="' + errClass + '">' + v + '</div>');
      } else if ('permission' == k) {
         $('.checkbox:last').after('<div class="' + errClass + '">' + v + '</div>');
      } else if ('country_code' == k || 'phone' == k) {
         $('.custom_error').after('<div class="' + errClass + '">' + v + '</div>');
      } else {
         $('#' + k).after('<div class="' + errClass + '">' + v + '</div>');
      }
      if (j == 1)
         $('#' + k).focus();
   });
}
function showDBChangeAlert(type, message) {
   if (type == 'error') {
      $('.alertMessage').show();
      $('.alertMessage').html(message);
      return false;
   } else if (type == 'success') {
      $('.alertMessage').show();
      $('.alertMessage').addClass('alert').addClass('alert-success');
      $('.alertMessage').html(message).delay(1000);
   }
}

function sendAndShowDBChangeAlert(type, message) {
   if (type == 'error') {
      $('.alertMessage').show();
      $('.alertMessage').html(message);
      return false;
   } else if (type == 'success') {
      $('.alertMessage').show();
      $('.alertMessage').addClass('alert').addClass('alert-success');
      $('.alertMessage').html(message);
   }
}
function clearAlertMessages() {
   $('.alertMessage ').html('');
   $('.alertMessage').removeClass('alert').removeClass('alert-success');
}

/**
 * Listing Data Using DataTable
 * @param {type} tabId - id of the table
 * @param {type} columns - columns listing
 * @param {type} ajaxUrl - ajax action url
 * @param {type} isPopup - table view in popup or not
 * @returns {undefined}
 */

var listingTables = function (parameters) {

   var tabId = parameters.tabId;
   ajaxUrl = parameters.ajaxUrl;
   columns = parameters.columns;
   isPopup = (parameters.isPopup) ? parameters.isPopup : false;
   isSmall = (parameters.isSmall) ? parameters.isSmall : false;
   order = (parameters.order) ? parameters.order : [0, 'asc'];
   aoColumnDefs = (parameters.aoColumnDefs) ? parameters.aoColumnDefs : [];
   var recCount = 0;
   datatab = $('#' + tabId);
   datatab.dataTable().fnDestroy();
   $('#' + tabId + ' tbody').empty();
   if (tabId == 'admin_notifications' || tabId == 'clinical_notifications')
      var paginationCount = params.notificationPaginationCount;
   else if(isSmall)
      var paginationCount = params.smallPaginationCount;      
   else
      var paginationCount = (!isPopup) ? params.paginationCount : params.popupPaginationCount;
   
   var datatable = datatab.DataTable({
      "processing": false,
      "serverSide": true,
      "ajax": {
         url: ajaxUrl,
         data: function (d) {
            d.search = $('input[name=search]').val();
            d.dobSearch = $('input[name=dobSearch]').val();
            if (tabId == 'receipientsList') {
               d.qid = $('#hidQid').val();
               d.searchlist = $('#searchlist').val();
            }
            if (parameters.pid != undefined)
               d.pid = parameters.pid;
            if (tabId == 'published-question-sets' || tabId == 'select-from-library')
               d.setType = 'public';
            if (tabId == 'select-from-library')
               d.showUseButton = '1';
            if (tabId == 'admin_notifications')
               d.listType = 'Admin';
            if (tabId == 'clinical_notifications')
               d.listType = 'Clinical';
         }
      },
      columns: columns,
      autoWidth: false,
      //bFilter: false,
      bInfo: false,
      bSort: true,
      order: [order],
      sDom: 't<"text-center"ip>',
      pageLength: paginationCount,
      bLengthChange: false,
      aoColumnDefs: aoColumnDefs,      
      oLanguage: {
         oPaginate: {
            "sNext": '»',
            "sLast": 'l',
            "sFirst": 'f',
            "sPrevious": '«'
         },
         sZeroRecords: ((tabId == 'admin_notifications' || tabId == 'clinical_notifications') ? params.no_notifications_found : params.no_data),
         sEmptyTable: ((tabId == 'admin_notifications' || tabId == 'clinical_notifications') ? params.no_notifications_found : params.no_data),
      }, fnDrawCallback: function (oSettings, tab) {
         //if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
         if (oSettings.fnRecordsDisplay() == 0) {
            $('.sorting,.sorting_desc,.sorting_disabled,.sorting_asc').css('background', 'none');
         }
         if (oSettings.fnRecordsDisplay() <= paginationCount)
            $('#' + tabId + '_paginate').hide();
         else
            $('#' + tabId + '_paginate').show();
         $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
         });
         if (tabId == 'receipientsList') {
            var str = parseInt(($("#receipientsList tr > td:contains('Responded')").length))
                    + parseInt(($("#receipientsList tr > td:contains('Completed')").length));
            $('#recipients-count').html('Recipients: ' + this.fnGetData().length);
            $('#responded-count').html('Responded: ' + str);
         }
      },
      "fnRowCallback": function (row, data, index) {
//         if (tabId == 'receipientsList') {
//         }
      },
      errMode: "none"
   });
}
function setMenuDisplayType(type) {
   var ajax_url;
   if (type === 'physician_menu_toggle') {
      ajax_url = params.site_url_path + '/physician/set-menu-settings';
   }
   if (type === 'patient_menu_toggle') {
      ajax_url = params.site_url_path + '/patient/set-menu-settings';
   }
   $.ajax({
      type: "POST",
      url: ajax_url,
      data: {'_token': $('input[name=_token]').val(), 'type': type},
      success: function (response) {

      }
   });
}
$('#myModal').on('show.bs.modal', function (e) {
   $('#myModal div.error').remove();
})
$('input.autoComplete').each(function (i, el) {
   el = $(el);
   var option = el.attr('data-suggest');
   console.log(option);
   var xhr;
   el.autoComplete({
      minChars: 1,
      source: function (term, response) {
         try {
            xhr.abort();
         } catch (e) {
         }
         xhr = $.getJSON(params.autoSuggestionRoute, {q: term, type: option}, function (data) {
            response(data);
         });
      }
   });
});
$('#select_all').click(function (e) {
   if ($(this).hasClass('checkedAll')) {
      $('.check_boxes').prop('checked', false);
      $(this).removeClass('checkedAll');
   } else {
      $('.check_boxes').prop('checked', true);
      $(this).addClass('checkedAll');
   }
});
$('.other-catgy').click(function () {
   if ($(this).prop('checked')) {
      $('.div_other_question').removeClass('hidden');
      $('#other_question').focus();
   } else {
      $('#other_question').val('Is there anything else you would like to add about the [CC]?');
      $('.div_other_question').addClass('hidden');
      $('#other_question').siblings('div.' + params.errorClass).remove();
   }
});
$('#other_question').click(function () {
   if ($.trim($(this).val()) == 'Is there anything else you would like to add about the [CC]?')
      $('#other_question').val('');
});
$('#other_question').keypress(function () {
   if ($.trim($(this).val()) == 'Is there anything else you would like to add about the [CC]?')
      $('#other_question').val('');
});
$('.form_date').datetimepicker({
   //autoclose: 1,
   todayHighlight: 1,
   minView: 2,
   pickerPosition: "bottom-left",
   endDate: '+0d'
});
// update notificatin
function markAsRead(nid) {
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/physician/update-notification',
      data: {'_token': $('input[name=_token]').val(), 'nid': nid},
      success: function (response) {
         $('#divPanel' + nid).removeClass('unread');
         notifCount();
      }
   });
}
//   notificatin count
function notifCount() {
   $.ajax({
      type: "POST", url: params.site_url_path + '/physician/get-notification-count',
      data: {'_token': $('input[name=_token]').val(), 'queryType': 'count', 'listType': 'Clinical'},
      success: function (response) {
         if (response != '') {
            var respARr = response.split('###');
            if (respARr[0] >= 0)
               $('#notifCount').removeClass('hidden').html(respARr[0]);

            setNotifCount(1, respARr[1]);
            setNotifCount(2, respARr[2]);

            if (respARr[0] == 0)
               $('#notifCount').addClass('hidden').html('');
         }
      }
   });
}
function setNotifCount(i, nCount) {
   if (nCount > 0)
      $('#notifCount' + i).html(' (' + nCount + ') ');
   if (nCount == 0)
      $('#notifCount' + i).html('');

}

