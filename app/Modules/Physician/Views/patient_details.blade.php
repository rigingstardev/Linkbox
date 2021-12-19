@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
     <h1>Patient Details</h1>
    </section>

      
      
    <!-- Main content -->
    <section class="content">

          <section class="content-sub-header">
     
         
          <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 pull-right">
           <div class="row">   <?php /*  onclick="location.href='{{ url('physician/listPatients') }}'"*/ ?>
          <button type="button" class="btn btn-third btn-block  mrgn-btm-15"  onclick="window.history.go(-1);" >Back</button>
              </div></div>
    </section>
        
     <div class="content-sub mrgn-btm-20 pdng-0">
           
            <div class="content-area-sub patient-detaols-main"> 
                <div class="inner_cont_det col-sm-4 col-md-3 col-lg-2">                
                <img src="{{asset('assets/physician/images/user-patient-pic.png')}}" class="dr_profile_pic">
                    
                    </div> 
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10 patiant-details-data">
                        <p class="mrgn-btm-20"><strong>Tom Peter</strong></p>
                        
                        <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Age</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: 24</b></div></div>
                        <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Gender</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: Male</b></div></div>
                        <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Contact Number</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: (541) 754-3010</b></div></div>
                        <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Email</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue"> : tompeter@gmail.com</b></div></div>
                        
                        <div class="btn-wrap"><button type="button" class="btn btn-third" onclick="location.href='{{ url('physician/viewMedicalRecord') }}'" >View Full Medical Records</button></div>
                       </div>
              
                
                
                <div class="clearfix"></div>
              
                </div>
            </div>
       
        <div class="clearfix"></div>
       <h4 class="mrgn-btm-20">Question Set History</h4>
        
        <div class="table-responsive"> 
        <table class="table">
            <thead>
                <tr>
                    <th>Question Set Name<i class="fa fa-angle-up pdng-lft-10" aria-hidden="true"></i></th>
                    <th>Sent On<i class="fa fa-angle-up pdng-lft-10" aria-hidden="true"></i></th>
                    <th>Response</th>
                    <th>Actions</th>
                    <th>Reports</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="{{url('physician/patientQuestionSetDetail')}}" class="txt-blue">Back Pain Question Set</a></td>
                    <td>10/20/2016</td>
                    <td><span class="txt-blue">Completed</span></td>
                    <td></td>
                    <td><a href="{{url('physician/summaryReport')}}" class="txt-blue">Summary Report</a> <a href="{{url('physician/evaluationReport')}}" class="txt-blue  mrgn-lft-25 ">Full Evaluation Report</a></td>
                </tr>
               
                
               <tr>
                   <td><a href="{{url('physician/patientQuestionSetDetail')}}" class="txt-blue">Urinary Retention Question Set</a></td>
                    <td>10/18/2016</td>
                    <td><span class="txt-orange">Pending</span></td>
                   <td><span class="txt-orange">Resend</span> <!--<a href="#" class="txt-orange mrgn-lft-25 txt-blue">Answer</a>--></td>
                    <td></td>
                </tr>
                
               <tr>
                   <td><a href="{{url('physician/patientQuestionSetDetail')}}" class="txt-blue">Bladder Pain Question Set</a></td>
                    <td>10/25/2016</td>
                    <td><span class="txt-blue">Completed</span></td>
                    <td></td>
                    <td><a href="{{url('physician/summaryReport')}}" class="txt-blue">Summary Report</a> <a href="{{url('physician/evaluationReport')}}" class="txt-blue  mrgn-lft-25 ">Full Evaluation Report</a></td>
                </tr>
               
                
                <tr>
                    <td><a href="{{url('physician/patientQuestionSetDetail')}}" class="txt-blue">Flank Pain Question Set</a></td>
                    <td>10/20/2016</td>
                    <td><span class="txt-orange">Pending</span></td>
                   <td><span class="txt-orange">Resend</span> <!--<a href="#" class="txt-orange mrgn-lft-25 txt-blue">Answer</a>--></td>
                    <td></td>
                </tr>
                
               
                
            </tbody>
        </table>
    </div>
     

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection