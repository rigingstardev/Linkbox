<!doctype html>

<html lang="en">

   <head>
      <meta charset="utf-8">

      <title>LinkBox</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


      <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/reset.css')); ?>">
      <!--<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">-->


      <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
      <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/bootstrap.min.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/bootstrap-select.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/font-awesome.css')); ?>">

      <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/AdminLTE.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/skin-blue.min.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('assets/patient/css/datepicker.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/bootstrap-datetimepicker.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/custom.css')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/jquery.auto-complete.css')); ?>">

      <!-- DataTable Css -->      
      <link rel="stylesheet" href="<?php echo e(asset('assets/physician/css/jquery.dataTables.css')); ?>" >
      <!--[if lt IE 9]>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
   </head>
   <!-- Page Loader Starts Here -->
   <style>
      .loader {
         position: fixed;
         top:0px;
         left:0px;
         width:100%;
         height:100%;
         z-index: 9999;
         background: url('<?php echo e(asset("assets/common/loader.gif")); ?>') 50% 50% no-repeat rgba(0, 0, 0, 0.7);
         background-size:4%;
         opacity: 1;        
      }
   </style>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
   <script type="text/javascript">
      $(window).load(function() {
         $(".loader").fadeOut("slow");
      });
   </script>
   <!-- Page Loader End Here -->
   <body class="hold-transition skin-blue sidebar-mini roboto <?php if(Auth::User()->left_menu_display_type == 1): ?> <?php echo e('sidebar-collapse'); ?> <?php endif; ?>" onload="clearScript();">
      <div class="loader"></div>
      <div class="wrapper">

         <!-- Main Header -->
         <header class="main-header">           
            <!-- Logo -->
               <?php if(hasPermission('questionset_list')): ?>
                  <?php if(subscribed()): ?>          
                  <a href="<?php echo e(url('/physician/home')); ?>" class="logo">
                  <?php else: ?> 
                  <a href="<?php echo e(url('/physician/questionSet')); ?>" class="logo">
                  <?php endif; ?>
               <?php else: ?> 
                  <a href="<?php echo e(url('/physician')); ?>" class="logo">    
               <?php endif; ?>

                  <!-- mini logo for sidebar mini 50x50 pixels -->
                  <span class="logo-mini"><img src="<?php echo e(asset('assets/physician/images/Logo-min.png')); ?>"/></span>
                  <!-- logo for regular state and mobile devices -->
                  <span class="logo-lg"><img src="<?php echo e(asset('assets/physician/images/logo2.png')); ?>"/></span>
               </a>

               <!-- Header Navbar -->
               <nav class="navbar navbar-static-top" role="navigation">
                  <!-- Sidebar toggle button-->
                  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" onclick="setMenuDisplayType(this.id)" id="physician_menu_toggle">
                     <span class="sr-only">Toggle navigation</span>
                  </a>
                  <!-- Navbar Right Menu -->
                  <div class="navbar-custom-menu">
                     <ul class="navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <!-- Tasks Menu -->
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                           <!-- Menu Toggle Button -->
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              <!-- The user image in the navbar-->
                              <?php if(Auth::user()->profile_image != ''): ?>
                              <img src="<?php echo e(asset('uploads/physician/'.config('settings.icon_prefix').Auth::user()->profile_image)); ?>" class="user-image" alt="User Image">
                              <?php else: ?>
                              <img src="<?php echo e(asset('assets/dummy-profile-pic.png')); ?>" class="user-image" alt="User Image" height='41'>
                              <?php endif; ?>

<!--<img src="<?php echo e(asset('assets/physician/images/user-pic.png')); ?>" class="user-image" alt="User Image">-->
                              <!-- hidden-xs hides the username on small devices so only the image appears. -->
                              <span class="hidden-xs"><?php echo e(Auth::user()->name); ?> <i class="fa fa-angle-down usr-down-arrow"></i></span>
                           </a>
                           <ul class="dropdown-menu">
                              <!-- The user image in the menu -->
                              <i class="fa fa-caret-up" aria-hidden="true"></i>
                              <li>


                                 <a href="<?php echo e(url('/logout')); ?>" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
                                 <form id="logout-form" action="<?php echo e(url('/logout')); ?>" method="POST" style="display: none;">
                                    <?php echo e(csrf_field()); ?>

                                 </form>

                              </li>
                           </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                     </ul>
                  </div>
               </nav>
               <input type="hidden" val="<?php echo e(url('/physician/home')); ?>" id="home_page_urls" name="home_page_url">
    
         </header>
         <!-- Left side column. contains the logo and sidebar -->