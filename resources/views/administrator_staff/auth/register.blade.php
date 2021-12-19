@extends('layouts.default')

@section('content')
<!--Banner-->
<div class="register-main">
   <div class="container">
      {!! Form::open(['url' => 'administrator-staff/register', 'id' => 'formRegister', 'method' => 'post']) !!}
      <div class="register-form-main">
         <h3><i class="fa fa-user" aria-hidden="true"></i> New administrator staff</h3>
         <div class="clearfix"></div>

         @include('includes.alerts')

         <div style="margin-top: 5%;" class="clearfix"></div>
         {!! Form::text('name', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Full Name','autofocus'=>""]) !!}
         <!-- {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Email Address']) !!} -->
         {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25 emailcheck','placeholder' => 'Email Address', 'id' => 'emailId', 'autocomplete' => 'off']) !!}
         {!! Form::password('password', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password','maxlength'=>20]) !!}
         {!! Form::password('password_confirmation', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password Confirmation','maxlength'=>20]) !!}
         {!! Form::select('practice', $data['practice_list'], 'null', ['id' => 'basic', 'class' => 'selectpicker show-tick form-control mrgn-btm-25','placeholder' => 'Select Practice']) !!}
         
         <!-- {{ Form::radio('gender', 'M' , false) }}&nbsp;&nbsp;Male &nbsp;&nbsp;&nbsp;
         {{ Form::radio('gender', 'F' , false) }}&nbsp;&nbsp;Female -->

         <!-- <input type="date" max="{{date('Y-m-d')}}" name="dob" placeholder="Date Of Birth" class="form-control mrgn-btm-25"> -->
         <!-- {!! Form::text('dob', '', ['class' => 'form-control mrgn-btm-25 datepicker','placeholder' => 'Date Of Birth']) !!} -->
         {!! Form::text('city', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'City']) !!}
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
      <span data-user_role="AdminStaff" class="user_role"></span>
      {!! Form::close() !!}

   </div>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.js
"></script>
<script type="text/javascript">
$( ".datepicker" ).datepicker({
format: "mm/dd/yy",
weekStart: 0,
calendarWeeks: true,
autoclose: true,
todayHighlight: true,
rtl: true,
orientation: "auto"
});
</script>
<!--Banner End-->
@endsection