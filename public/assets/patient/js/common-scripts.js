function showLoader() {
}
// removing elements with the given class
function removeWithClass(errClass) {
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
      if ("" == k)
      {
         $('.dberror').after('<div class="' + errClass + '">' + v + '</div>');
      } else if ('menu' == k) {
         $('.checkbox:last').after('<div class="' + errClass + '">' + v + '</div>');
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
   isSmall = (parameters.isSmall) ? parameters.isSmall : false;
   order = (parameters.order) ? parameters.order : [0, 'asc'];
   aoColumnDefs = (parameters.aoColumnDefs) ? parameters.aoColumnDefs : [];
   var recCount = 0;
   datatab = $('#' + tabId);
   datatab.dataTable().fnDestroy();
   $('#' + tabId + ' tbody').empty();
   if (tabId == 'patient_notifications' || tabId == 'patient_approvals')
      var paginationCount = params.notificationPaginationCount;
   else
      var paginationCount = (!isSmall) ? params.paginationCount : params.smallPaginationCount;
   var datatable = datatab.DataTable({
      "processing": false,
      "serverSide": true,
      "ajax": {
         url: ajaxUrl,
         data: function (d) {
            d.search = $('input[name=search]').val();
            d.dobSearch = $('input[name=dobSearch]').val();
            d.queryType = 'list';
            if (tabId == 'patient_notifications')
               d.listType = 'Notifications';
            if (tabId == 'patient_approvals')
               d.listType = 'Approvals';
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
         sZeroRecords: ((tabId == 'patient_notifications' || tabId == 'patient_approvals') ? params.no_notifications_found : params.no_data),
         sEmptyTable: ((tabId == 'patient_notifications' || tabId == 'patient_approvals') ? params.no_notifications_found : params.no_data),
//         sZeroRecords: params.no_data,
//         sEmptyTable: params.no_data,
      }, fnDrawCallback: function (oSettings, tab) {
         if (tabId == 'patient_approvals')
            $('#pendingApprovals').html($('.btn-approve').length);
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
      },
      "fnRowCallback": function (row, data, index) {
      },
      errMode: "none"
   });
}
function setMenuDisplayType(type) {
   var ajax_url;
   if (type === 'physician_menu_toggle') {
      ajax_url = params.site_url_path + '/patient/set-menu-settings';
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
      url: params.site_url_path + '/patient/update-notification',
      data: {'_token': $('input[name=_token]').val(), 'nid': nid},
      success: function (response) {
         $('#divPanel' + nid).removeClass('unread');
      }
   });
}

// update notificatin
function updateApprovals(nid, type) {
   var conf = confirm(params.confirm_change_request_status + type + ' the request?')
   if (!conf)
      return;
   $.ajax({
      type: "POST",
      url: params.site_url_path + '/patient/update-notification',
      data: {'_token': $('input[name=_token]').val(), 'nid': nid, 'type': type, 'user': 'patient'},
      success: function (response) {
         getNotifications('');
         notifCount();
         getNotifications('approvals');

      }
   });
}

//   notificatin count
function notifCount() {
   $.ajax({
      type: "POST", url: params.site_url_path + '/patient/get-notification-count',
      data: {'_token': $('input[name=_token]').val(), 'queryType': 'count', 'listType': 'Notifications'},
      success: function (response) {
         if (response != '') {
            var respARr = response.split('###');
             if (respARr[0]>= 0)
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
