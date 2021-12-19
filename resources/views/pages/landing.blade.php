@extends('layouts.default')

@section('banner')
<!--Banner-->
<div class="banner-main" id="home">
    <div class="container">
        @if ($message = Session::get('custom_message'))
        <div class="custom-alert auto_fade">
            <div class="alert alert-success alert-dismissable alert-fade">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ $message }}
            </div>
        </div>
        @endif 
        @if ($message = Session::get('custom_error'))
        <div class="custom-alert auto_fade">
            <div class="alert alert-danger alert-dismissable alert-fade">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ $message }}
            </div>
        </div>
        @endif 
        <div class="flex-container">
            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8  login-options">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6  physician-login">

                        <ul class="nav">
                            <li class="dropdown" id="menuLogin">
                                <a class="dropdown-toggle bnr-drop" href="#" data-toggle="dropdown" id="navLogin"><i class="fa fa-user-md" aria-hidden="true"></i> Office Login</a>
                                <div class="dropdown-menu physician_dd" @if (old('user_type1') == 'physician' && count($errors->all()) > 0) style="display: block;" @endif>
                                     @if(old('user_type1') == 'physician' && (count($errors) > 0))
                                     @include('includes.alerts')
                                     @endif
                                     {!! Form::open(['url' => 'login', 'id' => 'formLogin', 'method' => 'post']) !!}
                                     {!! Form::hidden('user_type1', 'physician') !!}
                                     {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Email Address']) !!}
                                     <!--@if (old('user_type1') == 'physician' && $errors->has('email'))<div class='error'>{{$errors->first('email')}}</div>@endif-->

                                     {!! Form::password('password', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password']) !!}
                                     <!--@if (old('user_type1') == 'physician' && $errors->has('password'))<div class='error'>{{$errors->first('password')}}</div>@endif-->

                                     {!! Form::submit('Login', array('class' => 'btn btn-primary btn-block', 'title'=>'Login' )) !!}

                                     <span class="or">OR</span>

                                    <a href="{!! url('doximity') !!}" class="doxi-login" title="Continue with Doximity"> <div class="navbar-header"> <img src="{{asset('assets/physician/images/doximity.jpg')}}"/> </div>  <p class="navbar-text">Continue with Doximity</p>  </a>

                                    <div class="clearfix"></div>

                                    <button type="button" class="btn-link" onclick="location.href = '{{ url('/password/reset') }}'">Forgot Password?</button>
                                    <button type="button" class="btn-link pull-right" onclick="location.href = '{{ url('/physician/register') }}'">Sign Up</button>
                                    {!! Form::close() !!}
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 patient-login">


                        <ul class="nav">
                            <li class="dropdown" id="menuLogin">
                                <a class="dropdown-toggle bnr-drop" href="#" data-toggle="dropdown" id="navLogin"><i class="fa fa-user" aria-hidden="true"></i> patient Login</a>

                                <!--<div class="dropdown-menu" @if ((old('user_type2') == 'patient') && ($errors->has('email') || $errors->has('password')))style="display: block;" @endif>-->
                                <div class="dropdown-menu patient_dd" @if (old('user_type2') == 'patient' && count($errors->all()) > 0) style="display: block;" @endif>
                                     @if(old('user_type2') == 'patient' && (count($errors) > 0))
                                     @include('includes.alerts')
                                     @endif
                                     {!! Form::open(['url' => 'patient/login', 'id' => 'formLogin', 'method' => 'post']) !!}
                                     {!! Form::hidden('user_type2', 'patient') !!}
                                     {!! Form::text('email', '', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Email']) !!}
                                     <!--@if (old('user_type2') == 'patient' && $errors->has('email'))<div class='error'>{{$errors->first('email')}}</div>@endif-->

                                     {!! Form::password('password', ['class' => 'form-control mrgn-btm-25','placeholder' => 'Password']) !!}
                                     <!--@if (old('user_type2') == 'patient' && $errors->has('password'))<div class='error'>{{$errors->first('password')}}</div>@endif-->

                                     {!! Form::submit('Login', array('class' => 'btn btn-primary btn-block')) !!}

                                     <div class="clearfix"></div>

                                    <button type="button" class="btn-link" onclick="location.href = '{{ url('/patient/password/reset') }}'">Forgot Password?</button>
                                    <button type="button" class="btn-link pull-right" onclick="location.href = '{{ url('/patient/register') }}'">Sign Up</button>

                                    {!! Form::close() !!}
                                </div>
                            </li>
                        </ul>


                    </div>
                </div>
            </div>


            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 banner-text">The world's first mobile <span>HPI</span> solution - Automate your documentation</div>


            <!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 request-demo">
                {!! Form::open(['url' => 'requestDemo', 'id' => 'formLogin', 'method' => 'post']) !!}
                <h2 class="mrgn-btm-25">Request a Demo</h2>
                <div class="loader"></div> -->
                
                <!--[if lte IE 8]>

<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>

<![endif]-->

                <!-- <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script> -->

                <!-- <script>

                                        hbspt.forms.create({

                                        portalId: '2784252',
                                                formId: 'bc7f51ad-6936-4d91-8f52-1f09cbce32dc'

                                        });
                </script> -->


            <!-- </div> -->
            
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 request-demo" style="
            text-align: center; 
            ">

            <h2 class="mrgn-btm-25">Request a Demo</h2>

            <button type="button" class="btn btn-default read-more mrgn-tp-20" onclick="location.href = 'https://email.marketing360.com/t/ViewEmail/d/A438A84BEDE81F6D2540EF23F30FEDED'" style="
            margin-top: 30%;
            color: #fff;
            "><i class="fa fa-phone" aria-hidden="true"> </i>  Schedule a Call</button>
            <br>
            <button type="button" class="btn btn-default read-more mrgn-tp-20" data-toggle="modal" data-target="#myModalUserRedirect" style="
            margin-top: 50px;
            color: #fff;
            "><i class="fa fa-sign-in" aria-hidden="true"></i>  Sign Up</button>
            <style> 
                .btn-default:hover {
                    background: #169ed9 !important;
                }
                .btn-default:focus {
                    background-color: none: 
                }
            </style>
            </div>
        </div>
    </div>

</div>

<!--Banner End-->
@endsection   

@section('content')
<!--Content Area-->
<div class="content-area">
    <div class="about-hidden" id="about-us"></div>
    <div class="container">

        <div class="about-text-main">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 about-img pull-right"><div class="row"><img src="{{asset('assets/physician/images/about-img.jpg')}}"/></div></div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 about-text">
                <h1>OUR STORY</h1>
                <p>After two back to back 12 hour days on call during Father's Day weekend, and subsequently missing all the festivities in his honor, our founder was determined to create a solution to help Doctors more efficiently see their patients while also increasing quality of care. As a result, LinkBox was born - a mobile software system that removes barriers between the physician and their patients, while automating the HPI documentation process. </p>

                <button type="button" class="btn btn-default read-more mrgn-tp-20"  onclick="location.href = '{{ url('/about/') }}'">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></button>

            </div>




            <div class="clearfix"></div>
        </div>

    </div>
</div>
<!--Content Area End-->
@endsection

@section('contact')
@include('includes.contact')
@endsection
@section('page-script')
<script type="text/javascript">
    $(window).load(function() {
    $(".loader").hide();
    });
    $(".physician-login #navLogin").on('click', function(){
    $(".patient_dd").css('display', 'none');
    })
            $(".patient-login #navLogin").on('click', function(){
    $(".physician_dd").css('display', 'none');
    })
</script>
@if ($errors-> has('email') || $errors-> has('password'))
<script type="text/javascript">
            $(function(){
            $('html, body').animate({
            scrollTop: $("#navLogin").offset().top - 80
            }, 1);
            })
</script>
@endif
@if (null !== Session::get('custom_message'))
@if (str_contains(URL::previous(), 'patient/verify'))
<script type="text/javascript">
            $(function(){
            $('html, body').animate({
            scrollTop: $("#navLogin").offset().top - 80
            }, 1);
            $(".patient_dd").css('display', 'block');
            })
</script>
@else
<script type="text/javascript">
            $(function(){
            $('html, body').animate({
            scrollTop: $("#navLogin").offset().top - 80
            }, 1);
            $(".physician_dd").css('display', 'block');
            })
</script>
@endif
@endif
@endsection