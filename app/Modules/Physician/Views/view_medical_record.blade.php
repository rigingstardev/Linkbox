@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Medical Records</h1>
    </section> 

    <input type="hidden" name="pid" id="pid" value="{{Request::segment(3)}}">

    <!-- Main content -->
    <section class="content">

        <section class="content-sub-header">
            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 pull-right">
                <div class="row">
                    <button type="button" class="btn btn-third btn-block  mrgn-btm-15"  onclick="location.href ='{{ URL::previous() }}'" >Back</button>
                </div>
            </div>
        </section>

        <div class="content-sub mrgn-btm-20 pdng-0">

            <div class="content-area-sub patient-detaols-main">
                <div class="inner_cont_det col-sm-4 col-md-3 col-lg-2">
                    <img src="{{ ('' != $patientDetails->profile_image) ? asset('uploads/patient/'.config('settings.thumb_prefix').$patientDetails->profile_image) : asset('assets/dummy-profile-pic.png') }}" class="dr_profile_pic">

                </div>
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10 patiant-details-data">
                    <p class="mrgn-btm-20"><strong>{!! $patientDetails->first_name ." ". $patientDetails->last_name !!}</strong></p>

                    <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Age</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: {!! Carbon\Carbon::parse($patientDetails->dob)->diff(Carbon\Carbon::now())->format('%y')  !!}</b></div></div>
                    <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Gender</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: {!! ('M' == $patientDetails->gender)?'Male':'Female' !!}</b></div></div>
                    <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Contact Number</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: {!! $patientDetails->contact_number !!}</b></div></div>
                    <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Email</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue"> : {!! $patientDetails->email !!}</b></div></div> 
                </div> 
                <div class="clearfix"></div>

            </div>
        </div>

        <div class="clearfix"></div>
        <h4 class="mrgn-btm-20">Allergies</h4>

        <div class="table-responsive mrgn-btm-20">
            <table class="table" id="allergies">
                <thead>
                    <tr>
                        <th class="none">Id</th>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                </thead>             
            </table>
        </div>

<div class="clearfix"></div>
        <h4 class="mrgn-btm-20">Medications</h4>

        <div class="table-responsive mrgn-btm-20">
            <table class="table" id="medications">
                <thead>
                    <tr>
                        <th class="none">Id</th>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                </thead>             
            </table>
        </div>

        <div class="clearfix"></div>
        <h4 class="mrgn-btm-20">Past Medical History</h4>

        <div class="table-responsive mrgn-btm-20">
            <table class="table" id="past_medical_history">
                <thead>
                    <tr>
                        <th class="none">Id</th>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                </thead>             
            </table>
        </div>



        <div class="clearfix"></div>

        <h4 class="mrgn-btm-20">Surgical History</h4>

        <div class="table-responsive mrgn-btm-20">
            <table class="table" id="surgical_history">
                <thead>
                    <tr>
                        <th class="none">Id</th>
                        <th>Surgery</th>
                        <th>Date</th>
                    </tr>
                </thead>             
            </table>
   <!--         <table class="table">
            <thead>
               <tr>
                  <th width="250">Surgery</th>
                  <th>Date<i class="fa fa-angle-up pdng-lft-10" aria-hidden="true"></i></th>
   
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>Appendectomy</td>
                  <td>10/22/2015</td>
   
               </tr>
   
               <tr>
                  <td>TURP</td>
                  <td>10/02/2016</td>
   
               </tr>
            </tbody>
         </table>-->
        </div>


        <div class="clearfix"></div>

        <h4 class="mrgn-btm-20">Family History</h4>

        <div class="table-responsive mrgn-btm-20">
            <table class="table" id="family_history">
                <thead>
                    <tr>
                        <th class="none">Id</th>
                        <th>Illness</th>
                        <th>Relation</th>
                    </tr>
                </thead>             
            </table>
   <!--         <table class="table">
            <thead>
               <tr>
            <th width="250">Illness</th>
                  <th width="250">Date<i class="fa fa-angle-up pdng-lft-10" aria-hidden="true"></i></th>
                  <th>Relation</th>
   
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>Hypertension</td>
                  <td>10/22/2015</td>
                  <td>Father</td>
   
               </tr>
   
               <tr>
                  <td>GERD</td>
                  <td>10/02/2016</td>
                  <td>Mother</td>
   
               </tr>
            </tbody>
         </table>-->
        </div>


        <div class="content-sub mrgn-btm-20 pdng-0">
            <div class="content-sub-heading">
                <div class="col-sm-12">
                    <b>Social History</b>

                </div>
                <div class="clearfix"></div>
            </div>

            <div class="content-area-sub">
                <div class="col-sm-12">
                    <div class="row mrgn-btm-15">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><p>Do you smoke?</p></div><div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">@if(count((array)$socialHistory)>0 ) {{setYesOrNo($socialHistory->smoke)}} @else{{'-'}} @endif</div>
                    </div>

                    <div class="row mrgn-btm-15">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><p>Do you drink alcohol?</p></div><div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">@if(count((array)$socialHistory)>0) {{setYesOrNo($socialHistory->drink)}} @else{{'-'}} @endif</div>
                    </div>

                    <div class="row mrgn-btm-15">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><p>Do you take drugs?</p></div><div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">@if(count((array)$socialHistory)>0) {{setYesOrNo($socialHistory->drug)}} @else{{'-'}} @endif</div>
                    </div>

                </div>
            </div>
        </div>
        
        
        
        <div class="content-sub mrgn-btm-20 pdng-0">
            <div class="content-sub-heading">
                <div class="col-sm-12">
                    <b>Other Comments</b>

                </div>
                <div class="clearfix"></div>
            </div>

            <div class="content-area-sub">
                <div class="col-sm-12">
                    @if(count((array)$socialHistory)>0) {{$socialHistory->comments}}  @endif
                </div>
            </div>
        </div>

        <section class="content-sub-header">
            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 pull-right">
                <div class="row">
                    <button type="button" class="btn btn-third btn-block  mrgn-btm-15"  onclick="location.href ='{{ URL::previous() }}'" >Back</button>
                </div></div>
        </section>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('page_scripts')
<script type="text/javascript">

    var allergy = [];
    var pid = $('#pid').val();
    var formType = 'listOnly';
    allergy['pid'] = pid;
    allergy['ajaxUrl'] = "{!! url('physician/allergyList') !!}";

    var medications = [];
    medications['pid'] = pid;
    medications['ajaxUrl'] = "{!! url('physician/medicationsList') !!}";
    
    var med_history = [];
    med_history['pid'] = pid;
    med_history['ajaxUrl'] = "{!! url('physician/getPastMedHistory') !!}";

    var surgical_history = [];
    surgical_history['pid'] = pid;
    surgical_history['ajaxUrl'] = "{!! url('physician/getSurgicalHistory') !!}";

    var family_history = [];
    family_history['pid'] = pid;
    family_history['ajaxUrl'] = "{!! url('physician/getFamilyHistory') !!}";
    
</script>
<script type="text/javascript" src="{{asset('assets/common/js/datatable-allergies.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/datatable-medications.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/datatable-med-history.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/datatable-surgical-history.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/datatable-family-history.js')}}"></script>
@endsection