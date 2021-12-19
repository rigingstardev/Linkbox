@extends('layouts.layout3')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>Notifications</h1> </section>
   <!-- Main content -->
   <section class="content">

      <div class="noti_tab">
         <ul class="nav nav-tabs mrgn-btm-20" role="tablist">
            <li role="presentation" class="active patient_notifications"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Notifications <span id="notifCount1"></span></a></a></li>
            <li role="presentation" class="patient_approvals"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Approvals <span id="notifCount2"></span></a></li>
         </ul>
         <div id="myTabContent" class="tab-content">
            <div class="tab-pane active in" id="home">
               <table class="table notifications" id="patient_notifications">
                  <thead><tr class="hidden"><th>Name</th></tr></thead>
               </table>
            </div>
            <!--- ------ ------>
            <div class="tab-pane fade" id="profile">
               <p class="text-blue">Pending Approvals: <span id="pendingApprovals"></span></p>
               <table class="table notifications" id="patient_approvals">
                  <thead><tr class="hidden"><th>Name</th></tr></thead>
               </table>  
            </div>
         </div>
         <!--- ------ ------>
      </div>
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('page_scripts')
<script type="text/javascript">
    var prevType = '';
    
    function getNotifications(notifType) {
       if (prevType != notifType) {
          var columns = [
             {data: 'name', name: 'name', orderable: false},
          ];
          var parameters = [];
          parameters['columns'] = columns;
          parameters['ajaxUrl'] = "{!! url('patient/list-notifications') !!}";
          if (notifType == 'notifications')
             parameters['tabId'] = 'patient_notifications';
          else if (notifType == 'approvals')
             parameters['tabId'] = 'patient_approvals';
          if (notifType != '')
             listingTables(parameters);
          prevType = notifType;
           notifCount();
       }
    }
    $('.patient_notifications').click(function (parameters) {
       getNotifications('notifications');
    });
    $('.patient_approvals').click(function (parameters) {
       getNotifications('approvals');
    });
    getNotifications('notifications');
    $(document).on('click','.deleteNotification',function() {  
      if(!(confirm("{{trans('Physician::messages.delete_notification')}}"))) 
        return false;
      var notType = $(this).data('nottype');
      $.ajax({
          type: "GET",
          url: $(this).data('url'),          
          success: function (response) {        
             var respArray = JSON.parse(response);  
             if(respArray){ 
                dTable = $('#'+ 'patient_'+notType);                 
                dTable.DataTable().ajax.reload(false);   
                var rowCnt = dTable.dataTable().fnSettings().fnRecordsTotal()-1;
                if('notifications' == notType)
                  $('span#notifCount1').html('('+ rowCnt + ')'); 
                else if('approvals' == notType)  
                  $('span#notifCount2').html('('+ rowCnt + ')');              
             }else {            
                showDBChangeAlert('error', params.dbChangeError);            
             }        
          },
          error: function (response) {             
            showValidation(response, params.errorClass);
          }
       });  
    });
</script>
@endsection