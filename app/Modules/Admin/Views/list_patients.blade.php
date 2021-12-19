@extends('layouts.layout5')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1>Patients</h1>
   </section>

   <section class="content section-class hidden">
      @include('layouts.show_alert_message')
   </section> 

   <!-- Main content -->
   <section class="content">

      <section class="content-sub-header">

         <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3 mrgn-btm-20 search-heading">
            <div class="row">   
               <div id="imaginary_container"> 
                  <div class="input-group stylish-input-group">
                     <input type="text" class="form-control" id="searchlist" name="searchlist"  placeholder="Search Name" >
                     <span class="input-group-addon">
                        <button id="btnSearch">
                           <span class="glyphicon glyphicon-search"></span>
                        </button>  
                     </span>
                  </div>
               </div>
            </div>   
         </div>

      </section>
      <div class="clearfix"></div>

      <div class="table-responsive"> 
         <table class="table dt-table-min-height" id="patients-list">
            <thead>
               <tr>
                  <!--<th>S. No.</th>-->
                  <th>Name</th>
                   <th>Email</th>
                  <th>Date of Birth</th>
                  <th>Contact Number</th>
                  <th>Status</th>
                  <th>Access</th>
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
//       {data: 'slNo', name: 'slNo', orderable: false, sortable: false, "width": "10%"},
       {data: 'first_name', name: 'first_name', orderable: true, sortable: true, "width": "35%"},
        {data: 'email', name: 'email', orderable: true, sortable: true, "width": "25%"},
       {data: 'dob', name: 'dob', orderable: true, sortable: true, "width": "15%"},
       {data: 'contact_number', name: 'contact_number', true: false, true: false, "width": "23%"},
       {data: '', name: '', orderable: false, sortable: false, "width": "12%"},
       {data: 'isLocked', name: 'isLocked', orderable: false, sortable: false, "width": "15%"},
    ];
    var parameters = [];
    parameters['tabId'] = 'patients-list';
    parameters['columns'] = columns;
    parameters['ajaxUrl'] = "{!! url('admin/patients-list') !!}";
    parameters['isPopup'] = true;
    $(document).ready(function () {
       listingTables(parameters);
    });
    $('#btnSearch').on('click', function () {
       if ($.trim($('#searchlist').val()) != '')
          listingTables(parameters);
    });
    $('#searchlist').on('keyup', function () {
       if ($.trim($(this).val()) == '')
          listingTables(parameters);
    });
    $('#patients-list').DataTable({
       stateSave: true
    });
    $("#searchlist").on("keyup", function (event) {
       if (event.which == 13) {
          listingTables(parameters);
          event.preventDefault();
       }
    });
</script>
@endsection