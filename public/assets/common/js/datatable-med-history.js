if (formType == 'listOnly') {
   var med_columns = [
      {data: 'id', name: 'id', searchable: false, orderable: false, printable: false},
      {data: 'type', name: 'name', orderable: true, 'sWidth': '31%'},
      {data: 'description', name: 'email', orderable: true, 'sWidth': '60%'},
   ];
} else {
   var med_columns = [
      {data: 'id', name: 'id', searchable: false, orderable: false, printable: false},
      {data: 'type', name: 'name', orderable: true, 'sWidth': '31%'},
      {data: 'description', name: 'email', orderable: true, 'sWidth': '60%'},
      {data: 'action', name: 'action', orderable: false, 'sWidth': '9%'}
   ];
}
med_history['isSmall'] = true;
med_history['tabId'] = 'past_medical_history';
med_history['columns'] = med_columns;
med_history['aoColumnDefs'] = [{"aTargets": [0], "bVisible": false, "bSearchable": false}];

$(document).ready(function () {
   listingTables(med_history);
});
$(document).on('click', '.delete_med_history', function (e) {
   e.preventDefault();
   if (confirm('Are you sure to delete this record?')) {
      $.get( $(this).attr('href'), function( data ) {
  listingTables(med_history);
});
   }
})
$('body').on('hidden.bs.modal', '#medHistoryModal', function () {
   $(this).removeData('bs.modal');
});