@extends('layouts.layout4')

@section('content')
<!--Banner-->
<div class="register-main register-bg">    
    <div class="container">            
        <div class="register-form-main">
            <h3>Login</h3>
            @include('includes.alerts')
            {!! Form::open(['url' => '/admin/login', 'id' => 'formLogin', 'method' => 'post']) !!}
            {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Email']) !!}
            {!! Form::password('password', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password']) !!}
            {!! Form::submit('Login', ['class' => 'btn btn-primary btn-block']) !!}
            <button type="button" class="btn-link" onclick="location.href = '{{ url('/admin/password/reset') }}'">Forgot Password?</button>
            {!! Form::close() !!}
        </div>
    </div>

</div>

<!--Banner End-->
@endsection