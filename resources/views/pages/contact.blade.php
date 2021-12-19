@extends('layouts.default')

@section('content')
<!--Content Area-->
<div class="register-main">
    <div class="container">
        {!! Form::open(['url' => 'contact_us', 'class' => 'cu-bootstrap-modal-form', 'id' => 'formContact', 'method' => 'post']) !!}
        <div class="register-form-main">
            <h3><i class="fa fa-user" aria-hidden="true"></i>Contact Us</h3>
            @include('includes.alerts')
            {!! Form::text('name', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Your Name']) !!}
            {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Email Address']) !!}
            {!! Form::textarea('message', old('message'), ['id' => 'message', 'class' => 'form-control', 'placeholder' => 'Message','size' => '50x3','maxlength' => '1000']) !!}
            <br>
            {!! Form::submit('Send', ['class' => 'btn btn-primary btn-block']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
<!--Content Area End-->
@endsection