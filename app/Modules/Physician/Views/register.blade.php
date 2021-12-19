@extends('layouts.default')

@section('content')
<!--Banner-->
<div class="register-main">
   <div class="container">
      {!! Form::open(['url' => 'register', 'id' => 'formRegister', 'method' => 'post']) !!}
      <div class="register-form-main">
         <h3><i class="fa fa-user" aria-hidden="true"></i> New physician</h3>
         <div class="clearfix"></div>

         @include('includes.alerts')

         <a href="{!! url('doximity') !!}" class="doxi-login" > <div class="navbar-header"> <img src="{{asset('assets/physician/images/doximity.jpg')}}"/> </div>  <p class="navbar-text">Continue with Doximity</p>  </a>

         <span class="or">OR</span>
         <a href="{!! route('administarator-staff-register-form-show') !!}">
         {!! Form::button('Administrator Staff', ['class' => 'btn btn-primary btn-block', 'title'=>'Continue As Administartor Staff']) !!}
         </a>


         <div style="margin-top: 5%;" class="clearfix"></div>
         {!! Form::text('physician_name', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Physician Name','autofocus'=>""]) !!}
         <!-- {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Email Address']) !!} -->
         {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25 emailcheck','placeholder' => 'Email Address', 'id' => 'emailId', 'autocomplete'=>'off']) !!}
         {!! Form::password('password', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password','maxlength'=>20]) !!}
         {!! Form::password('password_confirmation', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password Confirmation','maxlength'=>20]) !!}
         {!! Form::select('speciality', $data['speciality_list'], 'null', ['id' => 'basic', 'class' => 'selectpicker show-tick form-control mrgn-btm-25','placeholder' => 'Select Speciality']) !!}

         {!! Form::select('practice', $data['practice_list'], 'null', ['id' => 'basic', 'class' => 'selectpicker show-tick form-control mrgn-btm-25','placeholder' => 'Select Practice']) !!}
         
         {!! Form::text('hospital_name', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Clinic/Hospital Name']) !!}
         {!! Form::text('npi_number', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'NPI Number']) !!}
         {!! Form::text('city', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'City']) !!}
        <!--  {!! Form::text('country_code', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Country Code','maxlength'=>5]) !!}
         {!! Form::text('contact_number', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Contact Number','maxlength'=>15]) !!} -->
         <div class="row">
               <div class="col-md-3 country-code input-group">
                  <span class="input-group-addon">+</span>
                  {!! Form::text('country_code', '1', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Code','maxlength'=>5]) !!}
               </div>
                <div class="col-md-9">
                   {!! Form::text('contact_number', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Contact Number','maxlength'=>15]) !!}
               </div>
         </div>
         {!! Form::submit('Complete Registration', ['class' => 'btn btn-primary btn-block', 'title'=>'Complete Registration']) !!}
      </div>
      <span data-user_role="Physician" class="user_role"></span>
      {!! Form::close() !!}

   </div>
</div>
<!--Banner End-->
@endsection