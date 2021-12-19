@extends('layouts.layout3')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>Medical Records</h1> </section>
   <!-- Main content -->
   <section class="content">
      {!! Form::open(['url' => route('patient.post.social_history'),'class' => 'bootstrap-modal-form', 'id' => 'postAllergies', 'method' => 'post']) !!}
      <!--- ------ ------>
      <div class="row">
         <div class="col-md-9"><h4>Allergies</h4></div>
         <div class="col-md-3"><button type="button" class="btn btn-third mrgn-btm-15 pull-right" data-toggle="modal" data-target="#allergyModal" data-remote="{{route('patient.add.allergies')}}"><i class="fa fa-plus-square-o"></i> Add New</button></div>
      </div>
      <div class="table-responsive mrgn-btm-20"> 
         <table class="table tab-medical-records" id="allergies">
            <thead>
               <tr>
                  <th class="none">Id</th>
                  <th>Type</th>
                  <th>Description</th>
                  <th style="text-align: right;">Action</th>
               </tr>
            </thead>             
         </table>
      </div>
      <!--- ------ ------>


        <!--- ------ ------>
        <div class="row">
            <div class="col-md-9"><h4>Medications</h4></div>
            <div class="col-md-3"><button type="button" class="btn btn-third mrgn-btm-15 pull-right" data-toggle="modal" data-target="#medicationsModal" data-remote="{{route('patient.add.medications')}}"><i class="fa fa-plus-square-o"></i> Add New</button></div>
        </div>
        <div class="table-responsive mrgn-btm-20"> 
            <table class="table tab-medical-records" id="medications">
                <thead>
                    <tr>
                        <th class="none">Id</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>             
            </table>
        </div>
        <!--- ------ ------>



      <!--- ------ --------- ---------- ------->
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-9"><h4>Past Medical History</h4></div>
         <div class="col-md-3"><button type="button" class="btn btn-third mrgn-btm-15 pull-right" data-toggle="modal" data-target="#medHistoryModal" data-remote="{{route('patient.add.med_history')}}"><i class="fa fa-plus-square-o"></i> Add New</button></div>
      </div>
      <div class="table-responsive mrgn-btm-20"> 
         <table class="table tab-medical-records" id="past_medical_history">
            <thead>
               <tr>
                  <th class="none">Id</th>
                  <th>Type</th>
                  <th>Description</th>
                  <th style="text-align: right;">Action</th>
               </tr>
            </thead>             
         </table>
      </div>
      <!-- ------------- -->
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-9"><h4>Surgical History</h4></div>
         <div class="col-md-3"><button type="button" class="btn btn-third mrgn-btm-15 pull-right" data-toggle="modal" data-target="#surgicalHistoryModal" data-remote="{{route('patient.add.surgical_history')}}"><i class="fa fa-plus-square-o"></i> Add New</button></div>
      </div>
      <div class="table-responsive mrgn-btm-20"> 
         <table class="table tab-medical-records" id="surgical_history">
            <thead>
               <tr>
                  <th class="none">Id</th>
                  <th>Surgery</th>
                  <th>Date of surgery</th>
                  <th style="text-align: right;">Action</th>
               </tr>
            </thead>             
         </table>
      </div>
      <!-- ------------- -->

      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-9"><h4>Family History</h4></div>
         <div class="col-md-3"><button type="button" class="btn btn-third mrgn-btm-15 pull-right" data-toggle="modal" data-target="#familyHistoryModal" data-remote="{{route('patient.add.family_history')}}"><i class="fa fa-plus-square-o"></i> Add New</button></div>
      </div>
      <div class="table-responsive mrgn-btm-20"> 
         <table class="table tab-medical-records" id="family_history">
            <thead>
               <tr>
                  <th class="none">Id</th>
                  <th>Illness</th>
                  <th>Relation</th>
                  <th style="text-align: right;">Action</th>
               </tr>
            </thead>             
         </table>
      </div>
      <!-- ---   --->
      <div class="content-sub mrgn-btm-20 pdng-0">
         <div class="content-sub-heading"> 
            <div class="col-sm-12"><b>Social History</b></div>
            <div class="clearfix"></div>
         </div>


         <div class="content-area-sub">
            <div class="row mrgn-btm-20 mrgn-0">
               <div class="col-md-3 col-xs-12"><p class="gender">Do you smoke?</p></div>
               <div class="col-md-1 radio radio-info radio-inline">
                  {{ Form::radio('patient_smoke', 1, (isset($socialHistoryData->smoke) && ($socialHistoryData->smoke == 1)) ? true : false, ['id' => 'inlineRadio1']) }}
                  <label for="inlineRadio1"> Yes </label>
               </div>
               <div class="col-md-1 radio radio-inline">
                  {{ Form::radio('patient_smoke', 0, (isset($socialHistoryData->smoke) && ($socialHistoryData->smoke == 0)) ? true : false, ['id' => 'inlineRadio2']) }}
                  <label for="inlineRadio2"> No </label>
               </div>
               <div class="error error_patient_smoke"></div>
            </div>
            <div class="row mrgn-btm-20 mrgn-0">

               <div class="col-md-3 col-xs-12"><p class="gender">Do you drink alcohol?</p></div>
               <div class="col-md-1 radio radio-info radio-inline">
                  {{ Form::radio('patient_drink', 1, (isset($socialHistoryData->drink) && ($socialHistoryData->drink == 1)) ? true : false, ['id' => 'inlineRadio3']) }}
                  <label for="inlineRadio3"> Yes </label>
               </div>
               <div class="col-md-1 radio radio-inline">
                  {{ Form::radio('patient_drink', 0, (isset($socialHistoryData->drink) && ($socialHistoryData->drink == 0)) ? true : false, ['id' => 'inlineRadio4']) }}
                  <label for="inlineRadio4"> No </label>
               </div>
               <div class="error error_patient_drink"></div>
            </div>
            <div class="row mrgn-btm-20 mrgn-0">

               <div class="col-md-3 col-xs-12"><p class="gender">Do you take drugs?</p></div>
               <div class="col-md-1 radio radio-info radio-inline">
                  {{ Form::radio('patient_drug', 1, (isset($socialHistoryData->drug) && ($socialHistoryData->drug == 1)) ? true : false, ['id' => 'inlineRadio5']) }}
                  <label for="inlineRadio5"> Yes </label>
               </div>
               <div class="col-md-1 radio radio-inline">
                  {{ Form::radio('patient_drug', 0, (isset($socialHistoryData->drug) && ($socialHistoryData->drug == 0)) ? true : false, ['id' => 'inlineRadio6']) }}
                  <label for="inlineRadio6"> No </label>
               </div>
               <div class="error error_patient_drug"></div>
            </div>

            <div class="col-sm-12 mrgn-btm-20">
               {!! Form::textarea('comments', isset($socialHistoryData->comments) ? $socialHistoryData->comments : old('comments'), ['id' => 'social_comments', 'class' => 'form-control', 'placeholder' => 'Other Comments','size' => '50x3','maxlength' => '1000']) !!}

            </div>
         </div>

      </div>
      <div class="btn-wrap">
         <!--<button type="button" class="btn btn-primary mrgn-lft-15">Save</button>-->
         {!! Form::submit('Save', ['class' => 'btn btn-primary  mrgn-lft-15', 'title' => 'Save']) !!}
      </div>

   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- /.allergy-modal -->
<div class="modal fade" id="allergyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">

      </div>
   </div>
</div>
<!-- /.allergy-modal-ends -->
<!-- /.medications-modal -->
<div class="modal fade" id="medicationsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- /.medications-modal-ends -->
<!-- /.med-history-modal -->
<div class="modal fade" id="medHistoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">

      </div>
   </div>
</div>
<!-- /.med-history-modal-ends -->
<!-- /.surgical-history-modal -->
<div class="modal fade" id="surgicalHistoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">

      </div>
   </div>
</div>
<!-- /.surgical-history-modal-ends -->
<!-- /.family-history-modal -->
<div class="modal fade" id="familyHistoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">

      </div>
   </div>
</div>
<!-- /.family-history-modal-ends -->


@endsection
@section('page_scripts')
<script type="text/javascript">
    var formType = 'manage';
    var allergy = [];
    allergy['ajaxUrl'] = "{!! route('patient.allergies.list') !!}";
    var medications = [];
    medications['ajaxUrl'] = "{!! route('patient.medications.list') !!}";
    var med_history = [];
    med_history['ajaxUrl'] = "{!! route('patient.med_history.list') !!}";
    var surgical_history = [];
    surgical_history['ajaxUrl'] = "{!! route('patient.surgical_history.list') !!}";
    var family_history = [];
    family_history['ajaxUrl'] = "{!! route('patient.family_history.list') !!}";
</script>
<script type="text/javascript" src="{{asset('assets/common/js/datatable-allergies.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/datatable-medications.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/datatable-med-history.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/datatable-surgical-history.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/datatable-family-history.js')}}"></script>
@endsection