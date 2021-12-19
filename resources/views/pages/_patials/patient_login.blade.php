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