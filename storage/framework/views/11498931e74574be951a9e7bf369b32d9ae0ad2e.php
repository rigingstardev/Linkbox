<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<style>
.test {
  background-image: url('<?php echo e(URL::to("uploads/physician/phy-docu-1.jpg")); ?>');
  background-size: cover;
}
.welcome-title {
    font-size : 190%;
    color : none !important;
    text-align: center;
}
.text-style {
    text-align: center;
}
</style>
<div class="content-wrapper test">
    <div class="container">
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h1 class='welcome-title'>Welcome to LinkBox <?php echo e(Auth::user()->name); ?></h1>
            <div class="text-style">
                <h4>Please use the menu to your left to access</h4>
                <!-- <h4>your Physician functionality.</h4> -->
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout2', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>