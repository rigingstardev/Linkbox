@extends('layouts.layout3')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>Profile Details</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('includes.alerts')
        {!! Form::open(['url' => 'patient/postProfile','class' => 'bootstrap-modal-form', 'id' => 'profileUpdate', 'method' => 'post']) !!} 
        <div class="content-sub mrgn-btm-20 pdng-0">

            <div class="content-area-sub patient-detaols-main"> 
                <div class="inner_cont_det col-sm-4 col-md-3 col-lg-2">                
                    <img src="{{$data['patient']->profile_image}}" class="dr_profile_pic">
                    <a href="" class="display-block pdng-10-15" data-toggle="modal" data-target="#editImage">Edit Image<i class="fa fa-picture-o mrgn-lft-15" aria-hidden="true"></i></a>
                </div> 
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-5  input-main">

                    {!! Form::text('first_name', $data['patient']->first_name, ['class' => 'form-control mrgn-btm-20','autofocus'=>"",'placeholder' => 'First Name']) !!}
                    {!! Form::text('last_name', $data['patient']->last_name, ['class' => 'form-control mrgn-btm-20','autofocus'=>"",'placeholder' => 'Last Name']) !!}
                    {!! Form::text('email', $data['patient']->email, ['class' => 'form-control mrgn-btm-10','placeholder' => 'Email']) !!}
                    <a href="#" class="display-block mrgn-btm-10" data-toggle="modal" data-target="#myModal2">Change Password?</a>




                    <p class="gender line-height-28 ">Gender</p>
                    <div class="radio radio-info radio-inline">
                        {!! Form::radio('gender', 'M', ($data['patient']->gender == 'M') ? true : false, ['id' => 'inlineRadio1']) !!}
                        <label for="inlineRadio1"> Male </label>
                    </div>
                    <div class="radio radio-inline">
                        {!! Form::radio('gender', 'F', ($data['patient']->gender == 'F') ? true : false, ['id' => 'inlineRadio2']) !!}
                        <label for="inlineRadio2"> Female </label>
                    </div>
                    <div class="clearfix"></div>

                    <div class="input-group mrgn-tp-15 mrgn-btm-25 datetimepicker9" style="width:100%">
                        {!! Form::text('dob',Carbon\Carbon::parse($data['patient']->dob)->format('m/d/Y'), ['class' => 'form-control','placeholder' => 'Date of Birth', 'onClick' => 'this.blur()']) !!}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar">
                            </span>
                        </span>
                    </div>
                   <!--  {!! Form::text('country_code', splitContactNumber($data['patient']->contact_number,"code"), ['class' => 'form-control  mrgn-btm-20','placeholder' => 'Country Code']) !!}
                    {!! Form::text('contact_number', splitContactNumber($data['patient']->contact_number,"number"), ['class' => 'form-control','placeholder' => 'Contact Number']) !!} -->
                    <div class="row">
                             <div class="col-md-3 country-code input-group">
                                <span class="input-group-addon">+</span>
                                {!! Form::text('country_code', splitContactNumber($data['patient']->contact_number,"code"), ['class' => 'form-control','placeholder' => 'Code','maxlength'=>5]) !!}
                             </div>
                             <div class="col-md-9">
                                {!! Form::text('contact_number', splitContactNumber($data['patient']->contact_number,"number"), ['class' => 'form-control','placeholder' => 'Contact Number','maxlength'=>15]) !!}
                             </div>                            
                    </div>
                    <div class="error custom_error"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="btn-wrap">
            {!! Form::submit('Save', ['class' => 'btn btn-primary mrgn-lft-15', 'id' => 'agg-done-btn', 'title' => 'Save' ]) !!}
        </div>
        {!! Form::close() !!}
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['url' => 'patient/postChangePwd','class' => 'bootstrap-modal-form', 'id' => 'changePassword', 'method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Password</h4>
            </div>
            <div class="modal-body">



                <div class="col-sm-12 mrgn-btm-20">
                    <span class="display-block mrgn-btm-10"> Old Password</span>
                    {!! Form::password('old_password',['class' => 'form-control']) !!}
                </div>

                <div class="col-sm-12 mrgn-btm-20">
                    <span class="display-block mrgn-btm-10"> New Password</span>
                    {!! Form::password('password',['class' => 'form-control']) !!}
                </div>

                <div class="col-sm-12">
                    <span class="display-block mrgn-btm-10"> Confirm Password</span>
                    {!! Form::password('verify_password',['class' => 'form-control']) !!}
                </div>


                <div class="clearfix"></div>

            </div>
            <div class="modal-footer">

                {!! Form::submit('Save', ['class' => 'btn btn-primary', 'title' => 'Save']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal fade" id="editImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['url' => 'patient/editProfileImage','class' => 'bootstrap-modal-form', 'id' => 'editImage', 'method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Image</h4>
            </div>
            <div class="modal-body">



                <div class="col-sm-12 mrgn-btm-20">
                    <span class="display-block mrgn-btm-10"> Choose an image</span>
                    {!! Form::file('profile_image',['class' => 'form-control']) !!}
                </div>


                <div class="clearfix"></div>

            </div>
            <div class="modal-footer">

                {!! Form::submit('Save', ['class' => 'btn btn-primary', 'title' => 'Save']) !!}
            </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection