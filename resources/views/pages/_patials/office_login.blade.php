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