<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1> <?php echo e($questionSets->title); ?> Question Set</h1>
   </section>

   <!-- Main content -->
   <section class="content" <?php if($questionSets->bg_image): ?> style="background-image: url(<?php echo e(asset('uploads/question_set/' . $questionSets->bg_image)); ?>)" <?php endif; ?>>

            <section class="content-sub-header">
         <h4 class="pull-left">
            <!--<?php echo e($questionSets->title); ?>--> 
            Questions <span class="txt-blue"><?php echo e(count((array)$questionCategories)); ?></span></h4>
      </section>

      <div class="content-sub mrgn-btm-20 mrgn-tp-10 pdng-0">
         <div class="content-sub-heading"> 
            <div class="col-sm-12">
               <b><?php echo e($questionSets->title); ?></b>
            </div>
            <div class="clearfix"></div>
         </div>

         <div class="content-area-sub">
            <div class="col-sm-12">
               <p><?php echo e($questionSets->description); ?></p>
            </div>
         </div>
      </div>
      <?php $i = 0 ?>
      <?php $__currentLoopData = $questionCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php
      $i++;

      $isMainQuestion   = $row->ans_question_category_id;
      ?>
      <div class="content-sub mrgn-btm-20 pdng-0" id="view-question-settings-<?php echo e($row->id); ?>">
         <div class="content-sub-heading <?php if(!is_null($isMainQuestion)): ?><?php echo e('unread'); ?><?php endif; ?> ">
            <div class="col-sm-12"> 
               <!--   start if(is_null($isMainQuestion))   show category for the main questions only.-->
               <?php if(is_null($isMainQuestion)): ?> 
               <?php $prevMainQuestion = $i; ?>
               <b><?php /* @if (Request::segment(2) =='questionSetPreview') {{$row->category->category}} @else {{$row->category}}@endif */ ?>
                  <?php echo e($row->category); ?> 
               </b> 
               <?php else: ?>
               <b><?php echo e('Next Question to ask if the answer of "Question '.$prevMainQuestion.'"  is '.$row->ans_option.':'); ?></b>
               <?php endif; ?>
               <!--   end if(is_null($isMainQuestion))   show category for the main questions only.-->


            </div>
            <div class="clearfix"></div>
         </div>
         <div class="content-area-sub">
            <div class="col-sm-12 mrgn-btm-25">

               <?php echo $__env->make('layouts.answer_options', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
               <?php if($row->answer_method !='mcq'): ?>
            </div>
            <?php endif; ?>
            <div class="clearfix"></div> 
         </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php
      $back             = '/questionSet';
      if (collect(request()->segments())->last() == 'create-set')
          $back             = '/createQuestionSet';
      else if (collect(request()->segments())->last() == 'published-list')
          $back             = '/questionSet';
      else if (!is_numeric(collect(request()->segments())->last()))
          $back             = '/question-set-detail/' . $questionSets->id;
      ?>
      <div class = "btn-wrap"><button type = "button" class = "btn btn-third mrgn-lft-15" title = "Back" onclick = "location.href ='<?php echo e(url('physician'.$back)); ?>'">Back</button></div>


   </section>
   <!--/.content -->
</div>
<!--/.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout2', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>