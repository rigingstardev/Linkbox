@extends('layouts.layout3')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
     <h1>Question Sets Received</h1>
    </section>
      
    <!-- Main content -->
    <section class="content">
        <div class="clearfix"></div>
                <div class="table-responsive"> 
        <table class="table" id="questions">
            <thead>
                <tr>
                    <th>Question Set Name</th>
                    <th>Received On</th>
                    <th>Physician</th>
                    <th>Clinic</th>
                    <th>Contact</th>
                </tr>
            </thead>
           <!--  <tbody>
                <tr>
                    <td>
                        <p class="txt-blue"><a href="{{ url('patient/questionSetBrief') }}">Flank Pain Question Set</a></p>
                    
                    </td>
                    <td>10/11/2016</td>
                    <td>Dr. Fedrick Peter</td>
                    <td>Center for Medical Science</td>
                    <td>+(541) 754-3010</td>
                </tr>
                
                <tr>
                    <td>
                        <p class="txt-blue"><a href=""></a>Scrotal Pain Question Se</p>
                    
                    </td>
                    <td>10/11/2016</td>
                    <td>Dr. Peter Sam</td>
                    <td>Center for Medical Science</td>
                    <td>+(541) 754-3010</td>
                </tr>
                
            </tbody> -->
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
         {data: 'name', name: 'name', orderable: true},
         {data: 'recieved_on', name: 'email', orderable: true},        
         {data: 'physician', name: 'physician', orderable: false}
         {data: 'clinic', name: 'clinic', orderable: false}
         {data: 'contact_no', name: 'contact_no', orderable: false}
      ];
var parameters = [];
    parameters['tabId'] = 'questions'; 
    parameters['columns'] = columns; 
    parameters['ajaxUrl'] = "{!! route('patient.question.lists') !!}";          
    parameters['order'] = [1,'desc'];          
    //parameters['aoColumnDefs'] = [{"aTargets": [ 0 ],"bVisible": false,"bSearchable": false }];
$(document).ready(function(){
    listingTables(parameters);
});
$(document).on('click','#searchlist',function(){  
   listingTables(parameters);   
})
$( "#search" ).on( "keydown", function(event) {     
      if(event.which == 13) {         
          listingTables(parameters);  
          event.preventDefault();
      }
});
</script>
@endsection