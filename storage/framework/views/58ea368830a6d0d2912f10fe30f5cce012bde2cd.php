<?php use Vinkla\Hashids\Facades\Hashids; ?>


<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1>Summary Report</h1>
   </section>

   <!-- Main content -->
   <section class="content">
      <div class="content-sub mrgn-btm-20 pdng-0">
         <div class="content-sub-heading">
            <div class="col-sm-12">
               <b><?php echo $summaryDet['question']['title']; ?> </b>
            </div>
            <div class="clearfix"></div>
         </div>

         <div class="content-area-sub">
            <?php echo $__env->make('Physician::patient.partials._narrative_output', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         </div>
      </div>
      <section class="content-sub-header">
         <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 pull-right">
            <div class="row">
               <a href="<?php echo URL::to('home'); ?>"><button type="button" class="btn btn-third btn-block  mrgn-btm-15">Back</button></a>
            </div>
         </div>
      </section>
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page_scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/patients.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout2', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>