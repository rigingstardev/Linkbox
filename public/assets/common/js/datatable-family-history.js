if (formType == 'listOnly') {
   var family_columns = [
    {data: 'id', name: 'id', searchable: false, orderable: false, printable: false},
    {data: 'illness', name: 'illness', orderable: true, 'sWidth': '31%'},
    {data: 'relation', name: 'relation', orderable: true, 'sWidth': '60%'},
 ];
}else{
 var family_columns = [
    {data: 'id', name: 'id', searchable: false, orderable: false, printable: false},
    {data: 'illness', name: 'illness', orderable: true, 'sWidth': '31%'},
    {data: 'relation', name: 'relation', orderable: true, 'sWidth': '60%'},
    {data: 'action', name: 'action', orderable: false, 'sWidth': '9%'}
];
}

family_history['isSmall'] = true;
family_history['tabId'] = 'family_history';
family_history['columns'] = family_columns;
family_history['aoColumnDefs'] = [{"aTargets": [0], "bVisible": false, "bSearchable": false}];

$(document).ready(function () {
    listingTables(family_history);
});
$(document).on('click', '.delete_family_history', function (e) {
    e.preventDefault();
    if(confirm('Are you sure to delete this record?')){
        $.get( $(this).attr('href'), function( data ) {
  listingTables(family_history);
});
    }
})
$('body').on('hidden.bs.modal', '#familyHistoryModal', function () {
    $(this).removeData('bs.modal');
});