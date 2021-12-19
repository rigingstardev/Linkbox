<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Administrative Staff</h1>
    </section>
    <?php echo $__env->make('includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                <div class="row">                 
                <?php if(hasPermission()): ?>    
                    <button type="button" class="btn btn-third btn-block  mrgn-btm-15"   data-toggle="modal" onclick="showExistingStaffAddPopup()"><i class="fa fa-plus-square-o"></i> Add Existing Staff</button>
                <?php endif; ?>
                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Pick a Administrator Staff</h4>
                                </div>
                                <?php echo Form::open(['url' => 'physician/addExistingAdministrators','class' => '', 'id' => 'postAddExistingAdminiStratorStaffPopup','name' => 'postAddExistingAdminiStratorStaffPopup', 'method' => 'post']); ?>

                                <div class="modal-body  min-height-504">
                                    <!-- <div class="pop-search-nav row">
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 mrgn-btm-15">
                                            <input type="text" class="form-control" placeholder="Search Name" name="search" id="search">
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 pdng-0">
                                            <div class="input-group datepicker-control">
                                                <input type="text" required="" readonly="" class="date-picker form-control" placeholder="Date of Birth" id="dobSearch" name="dobSearch">
                                                <span class="input-group-addon calendar-icn-bg"><i class="fa fa-calendar icon-calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-primary" id="searchlist">Search</button>
                                        </div>
                                    </div> -->
                                    <div class="clearfix"></div>
                                    <div class="table-responsive">
                                        <table class="table" id="administratorstaff">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <!-- <input type="checkbox" name="select_all" id="select_all"> -->
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <!-- <th>Date of Birth</th> -->
                                                    <th>Contact Number</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <?php echo e(Form::hidden('totalRows', '0', array('id' => 'totalRows'))); ?> <?php echo e(Form::hidden('validatePatient', '', array('id' => 'validatePatient'))); ?>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" id="continue_qsqt_btn_popup">Continue</button>
                                </div>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                    <?php if(hasPermission()): ?>                   
                    <a href="<?php echo route('physician.adminstaff.new'); ?>"><button type="button" class="btn btn-third btn-block"><i class="fa fa-plus-square-o"></i> Add New</button></a>
                    <?php endif; ?>
                </div></div>
            <div class="clearfix"></div>
        </section>
        <div class="clearfix"></div>

        <div class="table-responsive"> 
            <table class="table" id="adminStaff">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th></th>                        
                    </tr>
                </thead>               
            </table>
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page_scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/add_existing_administrator_staff.js')); ?>"></script>

<script type="text/javascript">
    var columns = [
        {data: 'name', name: 'name', orderable: true},
        {data: 'email', name: 'email', orderable: true},
        {data: '', name: '', orderable: false}
    ];
    var parameters = [];
    parameters['tabId'] = 'adminStaff';
    parameters['columns'] = columns;
    parameters['ajaxUrl'] = "<?php echo route('physician.adminstaff.list'); ?>";
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
    $("#search").on("keyup", function (event) {
        if (event.which == 13) {
            listingTables(parameters);
            event.preventDefault();
        }else{
            listingTables(parameters);
        }
    });

    //START MODEL POPUP LIST  CODE
      var columns_popup = [
         {data: 'id', name: 'id', orderable: false, sortable: false, searchable: false, "width": "5%"},
         {data: 'name', name: 'name', orderable: true, "width": "30%"},
         {data: 'email', name: 'email', orderable: true, "width": "30%"},
        //  {data: 'dob', name: 'dob', orderable: true, "width": "15%"},
         {data: 'contact_no', name: 'contact_number', orderable: true, "width": "20%"}
      ];
      var parameters_popup = [];
      parameters_popup['tabId'] = 'administratorstaff';
      parameters_popup['columns'] = columns_popup;
      parameters_popup['ajaxUrl'] = "<?php echo route('physician.administratorstaff.popupList'); ?>";
      parameters_popup['isPopup'] = true;
      $(document).ready(function () {
         listingTables(parameters_popup);
      });
      function showExistingStaffAddPopup () {
         initializeAndShowModalPopUp('myModal2');
      }
      $(document).on('click', '#searchlist', function () {
         listingTables(parameters_popup);
      })
      $("#search").on("keydown", function (event) {
         if (event.which == 13) {
            listingTables(parameters);
            event.preventDefault();
         }
      });
      $("#search").on("keyup", function (event) {
         if ($.trim($(this).val()) == '' && $.trim($('#dobSearch').val()) == '') {
            listingTables(parameters);
         }
      });
      $("#dobSearch").on("keyup", function (event) {
         if (event.which == 46 || event.which == 32 || event.which == 8) {
            $('#dobSearch').val('');
            listingTables(parameters);
         }
      });
      $('#administratorstaff').on('draw.dt', function () {
         var inc = 1;
         $(".check-list-box").each(function () {
            $(this).attr('id', 'checkPatient' + inc).attr('name', 'adminstaffid');
            // checking the rows if the check all box is already checked
            if ($("#select_all").is(":checked"))
               $("#select_all").prop('checked', false);
            inc = parseInt(inc) + 1;
         });
         var currentRows = $('#administratorstaff tbody tr').length;
         $("#totalRows").val(currentRows);
      });
    //END MODEL POPUP LIST CODE


    $('#continue_qsqt_btn_popup').on('click', function () 
    {   
       if($('input[name="adminstaffid"]:checked'))
       {
          var errorClass = params.errorClass;
          removeWithClass(errorClass);
          $.ajax({
             type: "POST",
             url: params.site_url_path + '/physician/adminstaff/addExistingAdministrators',
             data: $('#postAddExistingAdminiStratorStaffPopup').serialize(),
             success: function (response) {
                var respArray = JSON.parse(response);
                if(respArray.success)
                {
                    if(respArray.redirectUrl) 
                    {
                        setTimeout(function () {
                              $(location).attr("href", respArray.redirectUrl);
                        }, 500);
                    }
                }else {            
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
          alert("Please select at least one administrator staff id");
          sendAndShowDBChangeAlert('error','Please select at least one administrator staff id');

       }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout2', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>