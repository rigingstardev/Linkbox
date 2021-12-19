@extends('layouts.layout3')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
     <h1>Question Set Details</h1>
    </section>
      
    <!-- Main content -->
    <section class="content">
<div class="content-sub mrgn-btm-20 pdng-0">
            <div class="content-sub-heading"> 
               <div class="col-sm-12"><b>Physician Profile</b></div>
                <div class="clearfix"></div>
            </div>
    
            <div class="content-area-sub"> 
                <div class="inner_cont_det col-md-12">                
                <img src="{{asset('assets/patient/images/user-pic.png')}}" class="dr_profile_pic">
                    <p class="Dr_name_big">Dr. Fedrick Peter</p> <span>Center for Medical Science<br>New York</span>
                                 
                </div> <div class="clearfix"></div>
               <div class="col-sm-12">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam volutpat massa eros, vitae elementum elit mattis eget. Sed egestas nibh risus, quis viverra nunc pellentesque id. Donec ornare sit amet urna ac luctus. Nunc non sapien quis nisi ultricies lobortis. Nullam nec lorem ut elit tristique fringilla at et massa. Aenean ornare, orci id malesuada lacinia, mi tortor cursus felis, at tristique erat ligula sit amet magna. Integer condimentum augue id velit fermentum, quis fringilla leo tincidunt. 
Lorem ipsum dolor sit amet, tristique erat ligula sit amet magna.</p>
                   </div>
                </div>
            </div>
        <div class="content-sub mrgn-btm-20 pdng-0">
            <div class="content-sub-heading"> 
               <div class="col-sm-12"><b>Flank Pain Question Set</b></div>
                <div class="clearfix"></div>
            </div>
            <div class="content-area-sub">                 
               <div class="col-sm-12">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam volutpat massa eros, vitae elementum elit mattis eget. Sed egestas nibh risus, quis viverra nunc pellentesque id. Donec ornare sit amet urna ac luctus. Nunc non sapien quis nisi ultricies lobortis. Nullam nec lorem ut elit tristique fringilla at et massa. Aenean ornare, orci id malesuada lacinia, mi tortor cursus felis, at tristique erat ligula sit amet magna. Integer condimentum augue id velit fermentum, quis fringilla leo tincidunt. 
Lorem ipsum dolor sit amet, tristique erat ligula sit amet magna.</p>
                </div>
                </div>
             
            </div>
        <div class="col-md-2 pdng-lft-0"><button type="button" class="btn btn-third btn-block"  mrgn-btm-15 onclick="location.href='{{ url('patient/questionSetDetail') }}'"> View Question Set</button></div>
     </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection