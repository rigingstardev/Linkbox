@extends('layouts.default')

@section('content')
<!--Banner-->
<div class="register-main">
    <div class="container">
        {!! Form::open(['url' => '/admin/password/reset', 'id' => 'formResetPassword', 'method' => 'post']) !!}
        <div class="register-form-main">
            <h3><i class="fa fa-user" aria-hidden="true"></i> Reset Password</h3>
            <div class="clearfix"></div>

            @include('includes.alerts')
            {!! Form::hidden('token', $token) !!}
            {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'E-Mail Address']) !!}
            {!! Form::password('password', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password']) !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password Confirmation']) !!}
            {!! Form::submit('Reset Password', ['class' => 'btn btn-primary btn-block']) !!}

        </div>
        {!! Form::close() !!}

    </div>

</div>

<!--Banner End-->
@endsection
@section('page_scripts')
<script>
    $(document).ready(function () {
        $("#formResetPassword").height($(document).height());
    });
</script>
@endsection