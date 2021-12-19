<?php
$defaultOption         = '';
$quid                  = $row->id;
$rid                   = $quid;
?>
<!--    start  if($row->answer_method =='dateT')        -->
<?php if($row->answer_method =='dateT'): ?>

<!--    start if(count($defaultOptions) > 0)       -->
<?php if(count($defaultOptions) > 0): ?>

<!--    start foreach($defaultOptions as $opt)      -->
<?php $__currentLoopData = $defaultOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<!--    start if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)     -->
<?php if($opt->question_category_id == $quid && $opt->category_id == $row->category_id): ?>

<!--start   if($opt->option_status ==1)-->
<?php if($opt->option_status ==1): ?>
<?php $defaultOption         = $opt->default_option ?>
<?php endif; ?>
<!--end   if($opt->option_status ==1)-->

<?php endif; ?>
<!--    end   if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)         -->

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--    end foreach($defaultOptions as $opt)      -->

<?php endif; ?>
<!--    end if(count($defaultOptions) > 0)       -->

<p><?php echo e($i); ?>. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>

<!--    start if($defaultOption =='date' || $defaultOption =='time' ||$defaultOption =='both' )       -->
 <!--   if($defaultOption =='dateT' || $defaultOption =='time' ||$defaultOption =='both' )-->

<!--    start if(Request::segment(1) == 'admin')     -->
<?php if(Request::segment(1) == 'admin'): ?>
<div class=" mrgn-tp-15 col-xs-12 col-sm-6 col-md-6 col-lg-3 pdng-0">
   <div class=" input-group datepicker-control">
      <input type="text" required="" class="date-picker form-control" disabled="">
      <span class="input-group-addon calendar-icn-bg" disabled=""><i class="fa fa-calendar icon-calendar"></i></span>
   </div>
</div>

<?php else: ?>
<!--    else of  if(Request::segment(1) == 'admin')      -->

<div class=" mrgn-tp-15 col-xs-12 col-sm-6 col-md-6 col-lg-3 pdng-0">
   <div class="input-group datepicker-control">
      <input type="text" required="" class="date-picker form-control" disabled="">
      <span class="input-group-addon calendar-icn-bg" disabled=""><i class="fa fa-calendar icon-calendar"></i></span>
   </div>
</div>
<?php endif; ?>
<!--    end if(Request::segment(1) == 'admin')      -->

 <!--   endif-->
<!--    end  if($row->answer_method =='dateT')        -->

<span class="ago pull-left pdng-lft-15 pdng-tp-3"></span>
<div class="clearfix"></div>

<?php endif; ?>
<!--    end if($defaultOption =='date' || $defaultOption =='time' ||$defaultOption =='both' )       -->

<!--    start  if($row->answer_method =='textBox')        -->
<?php if($row->answer_method =='textBox'): ?>
<p class="mrgn-btm-15"><?php echo e($i); ?>. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>
<div class="col-sm-3 pdng-0">
   <input disabled="" class="form-control">
</div>
<?php endif; ?>
<!--    end  if($row->answer_method =='textBox')        -->

<!--    start  if($row->answer_method =='rating')        -->
<?php if($row->answer_method =='rating'): ?>
<p class="mrgn-btm-15"><?php echo e($i); ?>. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>

<div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 pdng-0 ">
   <select id="basic" class="selectpicker show-tick form-control">
      <?php for($i=10; $i>=5;$i--): ?>
      <option><?php echo e($i); ?></option>
      <?php endfor; ?>
   </select>
</div>
<?php endif; ?>
<!--    end  if($row->answer_method =='rating')        -->

<!--    start  if($row->answer_method =='dropDown')        -->
<?php if($row->answer_method =='dropDown'): ?>
<p class="mrgn-btm-10"><?php echo e($i); ?>. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>
<?php $hasOption             = 0; ?>
<!--    start  if(count($defaultOptions) > 0)       -->
<?php if(count($defaultOptions) > 0): ?>

<?php $__currentLoopData = $defaultOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<!--    start if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)    -->
<?php if($opt->question_category_id == $quid && $opt->category_id == $row->category_id): ?>

<!--    start if($opt->option_status ==1)    -->
<?php if($opt->option_status ==1): ?>
<?php $hasOption++; ?>
<?php endif; ?>
<!--    end if($opt->option_status ==1)    -->

<?php endif; ?>
<!--    end if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)    -->

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="col-sm-3 pdng-0">
   <select id="basic" <?php if($hasOption==0): ?><?php echo e('disabled'); ?> <?php endif; ?> class="selectpicker show-tick form-control  mrgn-btm-10">

           <!--    start  if(count($defaultOptions) > 0)       -->
           <?php if(count($defaultOptions) > 0): ?>

           <!--    start  foreach($defaultOptions as $opt)      -->
           <?php $__currentLoopData = $defaultOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

           <!--    start if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)    -->
           <?php if($opt->question_category_id == $quid && $opt->category_id == $row->category_id): ?>

           <!--    start if($opt->option_status ==1)    -->
           <?php if($opt->option_status ==1): ?>
           <option> <?php echo e($opt->default_option); ?></option>
      <?php endif; ?>
      <!--    end if($opt->option_status ==1)    -->

      <?php endif; ?>
      <!--    end if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)    -->

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <!--    end  foreach($defaultOptions as $opt)      -->

      <?php endif; ?>
      <!--    end  if(count($defaultOptions) > 0)       -->
   </select>
</div>
<!--end foreach-->
<?php endif; ?>
<!--    end  if(count($defaultOptions) > 0)       -->
<!--end count checking-->
<div class="clearfix"></div>
<?php endif; ?>
<!--    end  if($row->answer_method =='dropDown')        -->

<!--    start  if($row->answer_method =='mcq')        -->
<?php if($row->answer_method =='mcq'): ?>
<p><?php echo e($i); ?>. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>

</div>
<?php $countOption           = 0 ?>
<!--    start  if(count($defaultOptions) > 0)        -->
<?php if(count($defaultOptions) > 0): ?>

<!--    start  foreach($defaultOptions as $opt)        -->
<?php $__currentLoopData = $defaultOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<!--    start if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)     -->
<?php if($opt->question_category_id == $quid && $opt->category_id == $row->category_id): ?>

<!--    start if($opt->option_status ==1)     -->
<?php if($opt->option_status ==1): ?>
<div class="col-sm-12 mrgn-btm-10">
   <div class="checkbox">
      <input id="checkbox22-<?php echo e($opt->id); ?>" type="checkbox" disabled="" >
      <label for="checkbox22-<?php echo e($opt->id); ?>">
         <?php echo e($opt->default_option); ?>

      </label>
   </div>
</div>
<?php $countOption++ ?>
<?php endif; ?>
<!--    end if($opt->option_status ==1)     -->

<?php endif; ?>
<!--    end if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)     -->

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--    end  foreach($defaultOptions as $opt)        -->

<!--    start if( $countOption ==0)     -->
<?php if( $countOption ==0): ?>
<div class="col-sm-12 ">
   <div class="checkbox">
      Options not specified.
   </div>
</div>
<?php endif; ?>
<!--    end if( $countOption ==0)     -->

<?php endif; ?>
<!--    end  if(count($defaultOptions) > 0)        -->

<?php $allow_multiple_answer = $row->allow_multiple_answer; ?>
<?php endif; ?>
<!--    end  if($row->answer_method =='mcq')        -->

<!--    start  if($row->answer_method =='3Combo')        -->
<?php if($row->answer_method =='3Combo'): ?>
<p class="mrgn-btm-15"><?php echo e($i); ?>. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?>
</p>
<div class="col-sm-12 mrgn-btm-5 pdng-lft-0 mrgn-tp-5">
   <div class="col-sm-2">
      <select id="basic" class="selectpicker show-tick form-control">
         <?php for($i=1; $i<=100;$i++): ?>
         <option><?php echo e($i); ?></option>
         <?php endfor; ?>
      </select>
   </div>
   <div class="col-sm-2">
      <select id="basic" class="selectpicker show-tick form-control">
         <option>Year(s)</option>
         <option>Month(s)</option>
         <option>Week(s)</option>
         <option>Day(s)</option>
         <option>Hour(s)</option>
      </select>
   </div>
   <div class="col-sm-3">

      <!--    start  if(count($defaultOptions) > 0)        -->
      <?php if(count($defaultOptions) > 0): ?>

      <!--    start  foreach($defaultOptions as $opt)        -->
      <?php $__currentLoopData = $defaultOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

      <!--    start if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)     -->
      <?php if($opt->question_category_id == $quid && $opt->category_id == $row->category_id): ?>

      <!--    start if($opt->option_status ==1)     -->
      <?php if($opt->option_status ==1): ?>
      <input type="text" name="txt3ComboAnswer" id="txt3ComboAnswer" value="<?php echo e($opt->default_option); ?>" class="form-control" >

      <?php endif; ?>
      <!--    end if($opt->option_status ==1)     -->

      <?php endif; ?>
      <!--    end if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)     -->

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <!--    end  foreach($defaultOptions as $opt)        -->

      <?php endif; ?>
      <!--    end  if(count($defaultOptions) > 0)        -->
   </div>
</div>
<?php endif; ?>
<!--    end  if($row->answer_method =='3Combo')        -->


<!--    start  if($row->answer_method =='yesNo')        -->
<?php if($row->answer_method =='yesNo'): ?>
<p class="mrgn-btm-15"><?php echo e($i); ?>. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>
<div class="col-sm-3 pdng-0">
   <select id="basic" class="selectpicker show-tick form-control">
      <option>Yes</option>
      <option>No</option>
   </select>
</div>

<?php endif; ?>
<!--    end  if($row->answer_method =='yesNo')        -->