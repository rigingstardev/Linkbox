@extends('layouts.default')
@section('content')
<!--Banner-->
<div class="register-main">
   <div class="container">
      {!! Form::open(['url' => 'patient/login', 'id' => 'formLogin', 'method' => 'post']) !!}
      <div class="register-form-main">
         <h3><i class="fa fa-user" aria-hidden="true"></i> Patient Login</h3>
         <div class="clearfix"></div>
         @include('includes.alerts')
         {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Email', 'autocomplete' => 'off']) !!}
         {!! Form::password('password', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password', 'autocomplete' => 'off']) !!}

         {!! Form::submit('Login', array('class' => 'btn btn-primary btn-block')) !!}
         <div style="margin-top: 5%;" class="clearfix"></div>
      </div>
      {!! Form::close() !!}
   </div>
</div>
<!--Banner End-->
@endsection