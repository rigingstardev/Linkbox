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

/**
 * Listing Data Using DataTable
 * @param {type} tabId - id of the table
 * @param {type} columns - columns listing
 * @param {type} ajaxUrl - ajax action url
 * @param {type} isPopup - table view in popup or not
 * @returns {undefined}
 */

var listingTables = function (parameters) {
   tabId = parameters.tabId;
   ajaxUrl = parameters.ajaxUrl;
   columns = parameters.columns;
   isPopup = (parameters.isPopup) ? parameters.isPopup : false;
   order = (parameters.order) ? parameters.order : [0, 'asc'];
   aoColumnDefs = (parameters.aoColumnDefs) ? parameters.aoColumnDefs : [];
   var recCount = 0;
   datatab = $('#' + tabId);
   datatab.dataTable().fnDestroy();
   $('#' + tabId + ' tbody').empty();
   if (tabId == 'patients-list' || tabId == 'list-physicians')
      var paginationCount = (!isPopup) ? params.paginationCount : params.listPaginationCount;
   else
      var paginationCount = (!isPopup) ? params.paginationCount : params.popupPaginationCount;
   var datatable = datatab.DataTable({
      "processing": false,
      "serverSide": true,
      "ajax": {
         url: ajaxUrl,
         data: function (d) {
            if (tabId == 'patients-list' || tabId == 'list-physicians') {
               d.searchlist = $('#searchlist').val();
            }
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
         sZeroRecords: params.no_data,
         sEmptyTable: params.no_data,
      }, fnDrawCallback: function (oSettings, tab) {
         //          var pagess = Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength) + 1; 
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
      "fnRowCallback": function (oSettings, row, data, index) {
//         if (tabId == 'patients-list') {
//            $("td:first", row).html(index + 1);
//            return row;
//         }
      },
      'createdRow': function (oSettings, row, data, index) {
//         $("td:first", row).html(index + 1);// $(row).attr('id', 'row-' + dataIndex);
      },
      errMode: "none"
   }); console.log(datatable);
}
//datatable.on('order.dt search.dt', function () {
//   t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
//      cell.innerHTML = i + 1;
//   });
//}).draw();
function setMenuDisplayType(type) {
   var ajax_url;
   if (type === 'admin_menu_toggle') {
      ajax_url = params.site_url_path + '/admin/set-menu-settings';
   }
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