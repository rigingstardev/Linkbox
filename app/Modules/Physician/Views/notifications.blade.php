@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1>Notifications</h1>
   </section>

   <!-- Main content -->
   <section class="content">

      <div>

         <!-- Nav tabs -->
         <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active clinical-notification"><a href="#clinical" aria-controls="home" role="tab" data-toggle="tab">Clinical <span id="notifCount1"></span></a></li>
            <li role="presentation" class="admin-notification"><a href="#adminstrative " aria-controls="profile" role="tab" data-toggle="tab">Administrative <span id="notifCount2"></span></a></li>
         </ul>

         <!-- Tab panes -->
         <div class="tab-content mrgn-tp-25">
            <div role="tabpanel" class="tab-pane  active" id="clinical">

               <div class="notification-main administrative">
                  <table class="table notifications" id="clinical_notifications">
                     <thead><tr class="hidden"> <th>Name</th></tr></thead>                           
                  </table>  
               </div> 
            </div>
            <div role="tabpanel" class="tab-pane" id="adminstrative">
               <div class="panel-group notification-main" id="accordion">
                  <table class="table notifications" id="admin_notifications">
                     <thead><tr class="hidden"> <th>Name</th></tr></thead>                           
                  </table>                  
               </div>
            </div>
         </div>
      </div>

   </section>
   <!-- /.content -->


</div>
<!-- /.content-wrapper -->
@endsection
@section('page_scripts')
<script type="text/javascript">
    var prevType;
    function getNotifications(notType) {
       if (prevType != notType) {
          var columns = [
             {data: 'name', name: 'name', orderable: false},
          ];
          var parameters = [];
          parameters['columns'] = columns;
          parameters['ajaxUrl'] = "{!! url('physician/notifications') !!}";
          if (notType == 'admin')
             parameters['tabId'] = 'admin_notifications';
          else if (notType == 'clinical')
             parameters['tabId'] = 'clinical_notifications';
          listingTables(parameters);
          prevType = notType;
          notifCount();
          
       }
    }
    $('.admin-notification').click(function (parameters) {
       getNotifications('admin');
    });
    $('.clinical-notification').click(function (parameters) {
       getNotifications('clinical');
    });
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
                dTable = $('#'+ notType + '_notifications');                 
                dTable.DataTable().ajax.reload(false);   
                var rowCnt = dTable.dataTable().fnSettings().fnRecordsTotal()-1;
                if('clinical' == notType)
                  $('span#notifCount1').html('('+ rowCnt + ')'); 
                else if('admin' == notType)  
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
    $(document).ready(function () {
       getNotifications('clinical');
     }); 
</script>
@endsection