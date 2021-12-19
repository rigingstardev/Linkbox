
@php use Vinkla\Hashids\Facades\Hashids; @endphp
@extends('layouts.layout3')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
     <h1>Question Set Details</h1>
    </section>
    @include('includes.alerts')  
    <!-- Main content -->
    <section class="content">
<div class="content-sub mrgn-btm-20 pdng-0">
            <div class="content-sub-heading"> 
               <div class="col-sm-12"><b>Physician Profile</b></div>
                <div class="clearfix"></div>
            </div>
    
            <div class="content-area-sub"> 
                <div class="inner_cont_det col-md-12">  

                <img src="{{ $questiondetails->profile_image ? asset('uploads/physician/'.config('settings.thumb_prefix').$questiondetails->profile_image) : asset('assets/dummy-profile-pic.png') }}" class="dr_profile_pic">
                    <p class="Dr_name_big">Dr. {!! $questiondetails->physician !!}</p> <span>{!! $questiondetails->clinic !!}<br>{!! $questiondetails->city !!}</span>
                                 
                </div> <div class="clearfix"></div>
               <div class="col-sm-12">
                <p>{!! $questiondetails->profile_description !!}</p>
                   </div>
                </div>
            </div>
        <div class="content-sub mrgn-btm-20 pdng-0">
            <div class="content-sub-heading"> 
               <div class="col-sm-12"><b>{!! $questiondetails->title !!}</b></div>
                <div class="clearfix"></div>
            </div>
            <div class="content-area-sub">                 
               <div class="col-sm-12">
                <p>{!! $questiondetails->description !!}</p>
                </div>
                </div>
             
            </div>
        <div class="col-md-2 pdng-lft-0">
          <a href="{!! route('patient.question.show',Hashids::encode($questiondetails->qResId)) !!}"><button type="button" class="btn btn-third btn-block"  mrgn-btm-15 > View Question Set</button></a></div>
     </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection