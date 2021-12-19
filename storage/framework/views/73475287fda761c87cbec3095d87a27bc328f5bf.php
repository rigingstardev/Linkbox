<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>LinkBox</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/reset.css')); ?>">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/bootstrap.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/bootstrap-datetimepicker.css')); ?>">
        <!-- <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/bootstrap-datetimepicker.css')); ?>"> -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/bootstrap-select.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/font-awesome.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/custom.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/patient/css/custom_patient.css')); ?>">
        <!-- <link rel="stylesheet" href="<?php echo e(asset('assets/patient/css/datepicker.css')); ?>"> -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/scrolling-nav.css')); ?>">
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
      <![endif]-->
    </head>
    <body data-spy="scroll">
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
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('assets/physician/images/Logo.png')); ?>"/></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo e(env('BLOG_URL')); ?>" target="_blank" id="home_menu">Blog</a></li>
                        <!--<li><a href="#about-us" id="about_us">About Us</a></li>-->
                        <li <?php echo e((Request::is('about') ? 'class=active' : '')); ?>><a href="<?php echo e(url('/about')); ?>" id="about_us">About Us</a></li>
                        <li <?php echo e((Request::is('contact') ? 'class=active' : '')); ?>><a href="<?php echo e(url('/contact')); ?>" id="contact_us">Contact Us</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#myModalUserRedirect" class="signup">sign up</a></li>
                        <!-- <li><a href="<?php echo e(env('SIGNUP_URL')); ?>"  target="_blank" class="signup">sign up</a></li> -->

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!--Header End-->