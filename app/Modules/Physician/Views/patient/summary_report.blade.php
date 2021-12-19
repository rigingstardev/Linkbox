@php use Vinkla\Hashids\Facades\Hashids; @endphp
@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1>Summary Report</h1>
   </section>

   <!-- Main content -->
   <section class="content">


      <div class="content-sub mrgn-btm-20 pdng-0">
         <div class="content-sub-heading">
            <div class="col-sm-12">

               <b>{!! $summaryDet['question']['title'] !!} </b>
               @if (hasPermission('patient_summaryReportList')) 
               <a href="{{route('physician.summary.pdf', $qRecId)}}" target="_blank" class="edit pull-right txt-blue" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Print">
                  <i class="fa fa-print" ></i></a>
               @endif
               @if (hasPermission('patient_summaryReportList')) 
               <ul class="navbar-right mrgn-rgt-15">
                  <li class="dropdown email-option">
                     <a class="dropdown-toggle edit txt-blue" href="javascript:void(0)" data-toggle="dropdown" id="navLogin" data-placement="top" title="Email">
                        <i class="fa fa-envelope-o" ></i></a>
                     <div class="dropdown-menu summary-email">
                        <i class="arrow-point" aria-hidden="true"></i>
                        <form class="form" id="formLogin">
                           <input type="text" class="form-control autoComplete" id="email"  name="email" placeholder="Enter Physician’s Email" data-suggest="physicianEmail">
                           <div class="button-wrap"> <button type="button" onclick="sendSummaryReport({{$summaryDet['patient_id']}}, {{$summaryDet['question_id']}}, {{Request::segment(3)}}, 'S')" id="btnSendReport" class="btn btn-primary mrgn-tp-20">Send</button>
                           </div>

                        </form>
                     </div>
                  </li>
               </ul>
               @endif
            </div>
            <div class="clearfix"></div>
         </div>

         <div class="content-area-sub">
            @include('Physician::patient.partials._narrative_output')
         </div>
      </div>
      <section class="content-sub-header">
         <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 pull-right">
            <div class="row">
               <a href="{!! route('physician.patient.details',Hashids::encode($summaryDet['patient']['id'])) !!}"><button type="button" class="btn btn-third btn-block  mrgn-btm-15">Back</button></a>
            </div>
         </div>
      </section>
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('page_scripts')
<script type="text/javascript" src="{{asset('assets/physician/js/patients.js')}}"></script>
@endsection