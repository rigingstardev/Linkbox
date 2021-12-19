if (formType == 'listOnly') {
    var columns = [
        {data: 'id', name: 'id', searchable: false, orderable: false, printable: false},
        {data: 'type', name: 'name', orderable: true, 'sWidth': '31%'},
        {data: 'description', name: 'email', orderable: true, 'sWidth': '60%'},
    ];
} else {
    var columns = [
        {data: 'id', name: 'id', searchable: false, orderable: false, printable: false},
        {data: 'type', name: 'name', orderable: true, 'sWidth': '31%'},
        {data: 'description', name: 'email', orderable: true, 'sWidth': '60%'},
        {data: 'action', name: 'action', orderable: false, 'sWidth': '9%'}
    ];
}
medications['isSmall'] = true;
medications['tabId'] = 'medications';
medications['columns'] = columns;
medications['aoColumnDefs'] = [{"aTargets": [0], "bVisible": false, "bSearchable": false}];

$(document).ready(function () {
    listingTables(medications);
});
$(document).on('click', '.delete_medications', function (e) {
    e.preventDefault();
    if (confirm('Are you sure to delete this record?')) {
//      location.href = $(this).attr('href');
        $.get($(this).attr('href'), function (data) {
            listingTables(medications);
        });
    }
})
$('body').on('hidden.bs.modal', '#medicationsModal', function () {
    $(this).removeData('bs.modal');
});