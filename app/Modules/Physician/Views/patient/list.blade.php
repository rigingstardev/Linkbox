@extends('layouts.layout2')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>Patients</h1>
   </section>
   <!-- Main content -->
   <section class="content">
      <section class="content-sub-header mrgn-btm-15">
         <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3 search-heading">
            <div class="row">
               <div id="imaginary_container">
                  <div class="input-group stylish-input-group">
                     <input type="text" class="form-control"  placeholder="Search Name" name="search" id="search" >
                     <span class="input-group-addon">
                        <button id="searchlist">
                           <span class="glyphicon glyphicon-search"></span>
                        </button>
                     </span>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 pull-right">
            <!-- <div class="row">
                <a href="{!! route('physician.adminstaff.new') !!}" ><button type="button" class="btn btn-third btn-block"><i class="fa fa-plus-square-o"></i> Add New</button></a>
            </div> -->
         </div>
         <div class="clearfix"></div>
      </section>
      <div class="clearfix"></div>

      <div class="table-responsive">
         <table class="table  dt-table-min-height" id="patients">
            <thead>
               <tr>
                  <th class="none">Id</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Date of Birth</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th>Contact Number</th>
               </tr>
            </thead>
         </table>
      </div>
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('page_scripts')
<script type="text/javascript">
    var columns = [
       {data: 'id', name: 'id', searchable: false, orderable: false, printable: false},
       {data: 'first_name', name: 'first_name', orderable: true, "width": "30%"},
       {data: 'last_name', name: 'last_name', orderable: true, "width": "30%"},
       {data: 'email', name: 'email', orderable: true, "width": "25%"},
       {data: 'dob', name: 'dob', orderable: true, "width": "15%"},
       {data: 'age', name: 'dob', orderable: true, "width": "7%"},
       {data: 'gender', name: 'gender', orderable: true, "width": "8%"},
       {data: 'contact_no', name: 'contact_number', orderable: true, "width": "15%"}
    ];
    var parameters = [];
    parameters['tabId'] = 'patients';
    parameters['columns'] = columns;
    parameters['ajaxUrl'] = "{!! route('physician.patient.list') !!}";
    parameters['aoColumnDefs'] = [{"aTargets": [0], "bVisible": false, "bSearchable": false}];

    $(document).ready(function () {
       listingTables(parameters);
    });
    $(document).on('click', '#searchlist', function () {
       if (($("#search")).val() == '') {
          alert('Please enter a search string');
       } else {
          listingTables(parameters);
       }
    })
    $("#search").on("keydown", function (event) {
       if (event.which == 13) {
          listingTables(parameters);
          //$('#patients').dataTable().search( this.value ).draw();
          event.preventDefault();
       }
    });
    $("#search").on("keyup", function (event) {
       if ($.trim($(this).val()) == '')
          listingTables(parameters);
    });

</script>
@endsection