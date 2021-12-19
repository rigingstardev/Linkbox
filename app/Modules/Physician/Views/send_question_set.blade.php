@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1>Make Question Set link of the {{$questionSets->title}} to:</h1>
   </section>

   <!-- Main content -->
   <section class="content">
      @include('includes.alerts') 
      <div class="alertMessage"></div>
      <section class="content-sub-header">

         <div class="col-xs-12 col-sm-5 col-md-4 col-lg-2 pull-right">
            <div class="row">
               <button type="button" class="btn btn-third btn-block  mrgn-btm-15"   data-toggle="modal" onclick="showPatientsPopup()"><i class="fa fa-plus-square-o"></i> Add Patient</button>

               <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title" id="myModalLabel">Pick a Recipient</h4>
                        </div>
                        {!! Form::open(['url' => 'physician/sendQuestionSet','class' => '', 'id' => 'postSendQuestionSetPopup','name' => 'postSendQuestionSetPopup', 'method' => 'post']) !!}
                        <div class="modal-body  min-height-504">
                           <div class="pop-search-nav row">

                              <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 mrgn-btm-15">
                                 <input type="text" class="form-control"  placeholder="Search Name" name="search" id="search" >
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
                           </div>


                           <div class="clearfix"></div>

                           <div class="table-responsive" >
                              {{ Form::hidden('question_id', $question_id) }}
                              {{ Form::hidden('selectType', 'list') }}
                              <table class="table" id="patients">
                                 <thead>
                                    <tr>
                                       <th><input type="checkbox" name="select_all" id="select_all"></th>
                                       <th>Name</th>
                                       <th>Email</th>
                                       <th>Date of Birth</th>
                                       <th>Contact Number</th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                           {{ Form::hidden('totalRows', '0', array('id' => 'totalRows')) }}
                           {{ Form::hidden('validatePatient', '', array('id' => 'validatePatient')) }}

                           <div class="clearfix"></div>
                        </div>

                        <div class="modal fade" id="modalPopUpSendQS" tabindex="-1" role="dialog" aria-labelledby="modalPopUpSendQSLabel">
                           <div class="modal-dialog" role="document" id="modalPopUpSendQSDoc">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <button type="button" class="close" onclick="hideModal('modalPopUpSendQS', 'customMessagePopUp')" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="modalPopUpSendQSLabel">Enter message</h4>
                                 </div>
                                 <div class="modal-body">  
                                    <textarea class="form-control" name="customMessagePopUp" id="customMessagePopUp"></textarea>
                                    <div class="clearfix"></div>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="send_qsqt_btn_popup">Send</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                           <button type="button" class="btn btn-primary" data-toggle="modal" id="continue_qsqt_btn_popup">Continue</button>
                        </div>
                        {!! Form::close() !!}
                     </div>
                  </div>
               </div>
            </div></div>

      </section>
      <div class="clearfix"></div>
      {!! Form::open(['url' => 'physician/postSendQuestionSet','class' => 'bootstrap-modal-form', 'id' => 'postSendQuestionSet', 'method' => 'post']) !!}
      <div class="content-sub mrgn-btm-20">
         {{ Form::hidden('question_id', $question_id) }}
         {{ Form::hidden('selectType', 'single') }}

         <div class="col-sm-12 mrgn-btm-20">
            <div class="checkbox"><input id="chkBxEmail" name="chkBxEmail" type="checkbox" value="email" onclick="enableSendBtn('email', this)"><label for="chkBxEmail">Send as Email</label></div>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
               <div  class="pdng-10-15">
                  <input class="form-control autoComplete send-as-email send-qs" disabled="" data-suggest="patientEmail" name="email" id="email">
               </div>
            </div>
         </div>
         @if(subscribed())
         <div class="col-sm-12 mrgn-btm-20">
            <div class="checkbox"><input id="chkBxText" name="chkBxText" type="checkbox"  value="text" onclick="enableSendBtn('phone', this)" ><label for="chkBxText">Send as Text</label></div>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
               <div  class="pdng-10-15">
                  <!-- <input class="form-control send-as-text send-qs mrgn-btm-10" disabled="" data-suggest="patientPhone"  name="country_code" id="country_code">
                  <input class="form-control autoComplete send-as-text send-qs" disabled="" data-suggest="patientPhone"  name="phone" id="phone"> -->

                  <div class="col-md-3 country-code input-group">
                     <span class="input-group-addon">+</span>
                     {!! Form::text('country_code', '', ['class' => 'form-control send-as-text send-qs mrgn-btm-25','placeholder' => 'Code','maxlength'=>5,'disabled'=>"",'id'=>"country_code"]) !!}
                  </div>
                  <div class="col-md-9 custom_error">
                     {!! Form::text('phone', '', ['class' => 'form-control autoComplete send-as-text send-qs mrgn-btm-25','placeholder' => 'Contact Number','data-suggest'=>'patientPhone','maxlength'=>15,'disabled'=>"",'id'=>'phone']) !!}
                  </div>                  
                  <!-- <span class="num_format">{{ trans('custom.phone_num_format_text') }}</span> -->
               </div>
            </div>
         </div>
         @endif
      </div>
      <div class="modal fade" id="modalPopUpBtnSendQS" tabindex="-1" role="dialog" aria-labelledby="modalPopUpBtnSendQSLabel">
         <div class="modal-dialog" role="document" id="modalPopUpBtnSendQSDoc">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" onclick="hideModal('modalPopUpBtnSendQS', 'customMessage')"  aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="modalPopUpBtnSendQSLabel">Enter message</h4>
               </div>
               <div class="modal-body"> 
                  <textarea class="form-control" name="customMessage" id="customMessage" maxlength="255"></textarea>
                  <div class="clearfix"></div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"  id="btnSend">Send</button>
               </div>
            </div>
         </div>
      </div>
      <div class="btn-wrap">
         <button type="button" class="btn btn-primary" disabled="" id="btnContinue"  data-toggle="modal" >Continue</button>
      </div>
      {!! Form::close() !!}
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('page_scripts')
<script type="text/javascript" src="{{asset('assets/physician/js/send-questionset.js')}}"></script>
<script type="text/javascript">
   $('#email').attr('disabled', 'disabled');
   $('#phone').attr('disabled', 'disabled');
   window.onbeforeunload = function (event) {
      $('#customMessagePopUp').val('');
   };
   var columns = [
      {data: 'id', name: 'id', orderable: false, sortable: false, searchable: false, "width": "5%"},
      {data: 'name', name: 'name', orderable: true, "width": "30%"},
      {data: 'email', name: 'email', orderable: true, "width": "30%"},
      {data: 'dob', name: 'dob', orderable: true, "width": "15%"},
      {data: 'contact_no', name: 'contact_number', orderable: true, "width": "20%"}
   ];
   var parameters = [];
   parameters['tabId'] = 'patients';
   parameters['columns'] = columns;
   parameters['ajaxUrl'] = "{!! route('physician.patient.popupList') !!}";
   parameters['isPopup'] = true;
   $(document).ready(function () {
      listingTables(parameters);
   });
   function showPatientsPopup() {
      initializeAndShowModalPopUp('myModal2');
   }
   $(document).on('click', '#searchlist', function () {
      listingTables(parameters);
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
   $('#patients').on('draw.dt', function () {
      var inc = 1;
      $(".check-list-box").each(function () {
         $(this).attr('id', 'checkPatient' + inc).attr('name', 'checkPatient' + inc);
         // checking the rows if the check all box is already checked
         if ($("#select_all").is(":checked"))
            $("#select_all").prop('checked', false);
         inc = parseInt(inc) + 1;
      });
      var currentRows = $('#patients tbody tr').length;
      $("#totalRows").val(currentRows);
   });
</script>
@endsection