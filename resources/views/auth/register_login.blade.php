@extends('layouts.default')

@section('content')

@php  
   $session    = Session::get('registerDetails');
   $formRole   = $session[0]['formRole'];
   $existRole  = $session[0]['existRole'];
   $roleType   = $session[0]['roleType'];
@endphp
<!--Banner-->
<div class="register-main">
   <div class="container">
      {!! Form::open(['url' => 'register-login', 'id' => 'formRegister', 'method' => 'post']) !!}
      <div class="register-form-main">
         <h3><i class="fa fa-user" aria-hidden="true"></i> {{ @$roleType }} Login </h3>
         <div class="alert alert-info">
            Please login with your existing credentials!
         </div>
         <div class="clearfix"></div>
         @include('includes.alerts')
         <div style="margin-top: 5%;" class="clearfix"></div>
         {!! Form::text('email', @$session[0]['email'], ['class' => 'form-control mrgn-btm-25', 'readonly' => 'readonly', 'placeholder' => 'Email Address']) !!}
         {!! Form::password('password', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password','maxlength'=>20]) !!}
         {!! Form::hidden('form_role', @$formRole, ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password','maxlength'=>20]) !!}
         {!! Form::hidden('exist_role', @$existRole, ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password','maxlength'=>20]) !!}
         {!! Form::hidden('role_type', @$roleType, ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password','maxlength'=>20]) !!}
         {!! Form::submit('Login', ['class' => 'btn btn-primary btn-block', 'title'=>'Login']) !!}
      </div>
      {!! Form::close() !!}

   </div>
</div>
<!--Banner End-->
@endsection