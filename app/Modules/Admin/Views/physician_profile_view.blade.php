@extends('layouts.layout5')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1>Profile Details</h1>
   </section>
   @include('includes.alerts')

   <!-- Main content -->
   <section class="content">

      <div class="clearfix"></div>
      <div class="content-sub mrgn-btm-20 pdng-0">
         <div class="content-sub-heading">
            <div class="col-sm-12"><b>Physician Profile</b></div>
            <div class="clearfix"></div>
         </div>
         <div class="content-area-sub">
            <div class="inner_cont_det">
               <div class="col-md-2  col-xs-12"> <img src="{{ isset($data['physician']->profile_image)? $data['physician']->profile_image :""}}" class="dr_profile_pic"></div>
               <div class="col-md-10 phy-detail-label">
                  <p><label>Full Name :</label><span>{{ isset($data['physician']->name)?$data['physician']->name:"" }}</span></p>
                  <p><label>Specialty :</label><span>{{ isset($data['physician']->speciality_id)?$data['speciality_list'][$data['physician']->speciality_id]:""}}</span></p>
                  <p><label>Clinic Name :</label><span>{{ isset($data['physician']->hospital_name)? $data['physician']->hospital_name:""}}</span></p>
                  <p><label>NPI Number :</label><span>{{ isset($data['physician']->npi_number)?$data['physician']->npi_number:""  }}</span></p>
                  <p><label>City :</label><span>{{ isset($data['physician']->city)?$data['physician']->city:"" }}</span></p>
                  <p><label>Contact number :</label><span>{{ isset($data['physician']->contact_number)?$data['physician']->contact_number:"" }}</span></p>
                  <p><label>Email :</label><span>{{ isset($data['physician']->email)?$data['physician']->email:""}}</span></p>
               </div>
            </div> <div class="clearfix"></div>
         </div>
      </div>
      @include('Admin::_partials.subscription')
      <div class="col-md-12 pdng-lft-0">
         @if ($userActivePlan)
             <a href="{!! route('admin.subscription.cancel',[$data['physician']->id,$userActivePlan->plan->plan_id]) !!}" onclick="return confirm('Are you sure to cancel Subscription?')">
               <button type="button" class="btn btn-third btn-block btn-subscribe mrgn-btm-15 "> Cancel Subscription</button>
            </a>
         @endif
         <button type="button" class="btn btn-third btn-block btn-back mrgn-btm-15 btn-back"  onclick="window.history.go(-1);" > Back</button></div>
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection