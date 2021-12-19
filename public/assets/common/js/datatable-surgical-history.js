if (formType == 'listOnly') {
   var surgical_columns = [
      {data: 'id', name: 'id', searchable: false, orderable: false, printable: false},
      {data: 'surgery', name: 'surgery', orderable: true, 'sWidth': '31%'},
      {data: 'surgery_date', name: 'surgery_date', orderable: true, 'sWidth': '60%'},
   ];
} else {
   var surgical_columns = [
      {data: 'id', name: 'id', searchable: false, orderable: false, printable: false},
      {data: 'surgery', name: 'surgery', orderable: true, 'sWidth': '31%'},
      {data: 'surgery_date', name: 'surgery_date', orderable: true, 'sWidth': '60%'},
      {data: 'action', name: 'action', orderable: false, 'sWidth': '9%'}
   ];
}

surgical_history['isSmall'] = true;
surgical_history['tabId'] = 'surgical_history';
surgical_history['columns'] = surgical_columns;
surgical_history['aoColumnDefs'] = [{"aTargets": [0], "bVisible": false, "bSearchable": false}];

$(document).ready(function () {
   listingTables(surgical_history);
});
$(document).on('click', '.delete_surgical_history', function (e) {
   e.preventDefault();
   if (confirm('Are you sure to delete this record?')) {
      $.get( $(this).attr('href'), function( data ) {
  listingTables(surgical_history);
});
   }
})
$('body').on('hidden.bs.modal', '#surgicalHistoryModal', function () {
   $(this).removeData('bs.modal');
});