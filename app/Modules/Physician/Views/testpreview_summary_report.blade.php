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
               <a href="{!! URL::to('home') !!}"><button type="button" class="btn btn-third btn-block  mrgn-btm-15">Back</button></a>
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