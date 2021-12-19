@extends('layouts.landing')

@section('header')
<!--Header-->
    <nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="{{asset('images/physician/Logo.png')}}"/></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="#home">Home</a></li>
          <li><a href="#about-us">About Us</a></li>
          <li><a href="#contact">Contact Us</a></li>
           <li><a href="#" class="signup"  onclick="location.href='figure-6-phys-regis.html'">sign up</a></li>
       
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    <!--Header End-->
@endsection

@section('banner')
<!--Banner-->
    <div class="banner-main" id="home">
    
        <div class="container">
            
           
        
            
            <div class="flex-container">
            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8  login-options">
                <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6  physician-login">
            
                <ul class="nav">
          <li class="dropdown" id="menuLogin">
            <a class="dropdown-toggle bnr-drop" href="#" data-toggle="dropdown" id="navLogin"><i class="fa fa-user-md" aria-hidden="true"></i> Physician Login</a>
            <div class="dropdown-menu">
              <form class="form" id="formLogin"> 
                <input class="form-control mrgn-btm-25" placeholder="Email">
                <input class="form-control mrgn-btm-25" placeholder="Password" type="password">
                <button type="button" class="btn btn-primary btn-block" onclick="location.href='Figure-8-adminHome.html'">Login</button>
                  
                  <span class="or">OR</span>
                  
                  <a href="#" class="doxi-login not-done" title="Continue with Doximity"> <div class="navbar-header"> <img src="{{asset('images/physician/doximity.jpg')}}"/> </div>  <p class="navbar-text">Continue with Doximity</p>  </a>
                  
                  <div class="clearfix"></div>
                  
                  <button type="button" class="btn-link not-done">Forgot Password?</button>
                  <button type="button" class="btn-link pull-right" onclick="location.href='figure-6-phys-regis.html'">Sign Up</button>
                  
              </form>
            </div>
          </li>
        </ul>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 patient-login">
           
                
                <ul class="nav">
          <li class="dropdown" id="menuLogin">
            <a class="dropdown-toggle bnr-drop" href="#" data-toggle="dropdown" id="navLogin"><i class="fa fa-user" aria-hidden="true"></i> patient Login</a>
            <div class="dropdown-menu">
              <a href="#" class="health-login not-done"> <div class="navbar-header"> <img src="{{asset('images/physician/health-tap.jpg')}}"/> </div>  <p class="navbar-text">Continue with Health Tap</p>  </a>
            </div>
          </li>
        </ul>
                
               
            </div>
            </div>
        </div>
                
                    
        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 banner-text">The world's first mobile <span>HPI</span> solution - Automate your documentation</div>
                
                
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 request-demo">
           
                <h2 class="mrgn-btm-25">Request a Demo</h2>
                <div class="form-group">
    <label for="exampleInputEmail1">First Name</label>
    <input class="form-control" >
  </div>
                
                <div class="form-group">
    <label for="exampleInputEmail1">Last Name</label>
    <input class="form-control" >
  </div>
                
                <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input class="form-control" >
  </div>
                
                <div class="form-group mrgn-btm-25">
    <label for="exampleInputEmail1">Phone Number</label>
    <input class="form-control" >
  </div>
                
                <button type="button" class="btn btn-second btn-block not-done">send request</button>
                
                <button type="button" class="btn-link btn-block white-text" onclick="location.href='figure-6-phys-regis.html'">SIGN UP</button>
                
               
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
            
             <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 about-img pull-right"><div class="row"><img src="{{asset('images/physician/about-img.jpg')}}"/></div></div>
            
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 about-text">
        <h1>OUR STORY</h1>
            <p>After two back to back 12 hour days on call during Father's Day weekend, and subsequently missing all the festivities in his honor, Dr. Littlejohn was determined to create a solution to help Doctors more efficiently see their patients while also increasing quality of care. As a result, LinkBox was born - a mobile software system that removes barriers between the physician and their patients, while automating the HPI documentation process. </p>
        
            <button type="button" class="btn btn-default read-more mrgn-tp-20"  onclick="location.href='About.html'">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></button>
            
        </div>
        
       
            
            
        <div class="clearfix"></div>
        </div>
        
        </div>
    </div>
    <!--Content Area End-->
@endsection

@section('contact')
<!--Contact Main-->
    <div class="home-contact-main" id="contact">
    
        <div class="container">
            <h1>CONTACT US</h1>
                <br>
            <div class="row">
            <div class="col-sm-6">
            
        <div class="col-sm-12 col-md-6 form-group pdng-lft-0">
        <input class="form-control"  placeholder="Your Name">
        </div>
                
        <div class="col-sm-12 col-md-6 form-group pdng-lft-0">
        <input class="form-control"  placeholder="Email">
        </div>
                
                <div class="col-sm-12 form-group pdng-lft-0 ">
       
                    <textarea class="form-control" rows="3" placeholder="Message"></textarea>
        </div>
              
                <button type="button" class="btn btn-primary send-btn mrgn-tp-70 not-done">Send</button>
                
                
            </div>
        
            
            <div class="col-sm-6 address-main">
            <div class="col-sm-12 address">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <p>360, King Street<br>
                Feasterville, PA, 123456</p>
                </div>
                
                <div class="col-sm-12 address">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <p>(800) 900-200-300</p>
                </div>
                
                <div class="social-media">
                <a href="#" class="not-done"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="#" class="not-done"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="#" class="not-done"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </div>
                
            </div>
                </div>
            
            <div class="col-sm-12">
            <div class="row"><footer>© Copyright 2016 LinkBox. All rights reserved.</footer></div>
            </div>
            
        </div>
        
    </div>
    <!--Contact Main-->
@endsection