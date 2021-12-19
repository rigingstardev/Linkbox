@extends('layouts.default')

@section('content')
<!--Banner-->
<div class="register-main">
    <div class="container">
        {!! Form::open(['url' => $action, 'id' => 'formResetPassword', 'method' => 'post']) !!}
        <div class="register-form-main">
            <h3><i class="fa fa-user" aria-hidden="true"></i> Reset Password</h3>
            <div class="clearfix"></div>

            @include('includes.alerts')

            {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'E-Mail Address']) !!}
            {!! Form::submit('Send Password Reset Link', ['class' => 'btn btn-primary btn-block']) !!}

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