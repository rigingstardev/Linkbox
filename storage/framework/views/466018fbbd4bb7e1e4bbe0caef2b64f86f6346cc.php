<?php if(count($result) > 0): ?>
<?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ques): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$questionSegs = explode('[CC]', $ques->question);
?>
<div class="">

   <p for="question_opt_1">
      <?php $question     = ''; ?>
      <span id="serialNo<?php echo e($rid); ?>"></span>

      <?php
      $strCC        = '[CC]';
      $ccClass      = '';
      if ($ques->category_id == 11) {
          $strCC   = '';
          $ccClass = 'hidden';
      }
      ?>
      <span id="span-question-segment-<?php echo e($rid); ?>"><?php echo e($questionSegs[0]); ?><?php echo replaceTextWithActualValue('', $strCC, $questionSet->title, $strCC, 'cc') ?><?php if(count($questionSegs)>1): ?><?php echo e($questionSegs[1]); ?><?php endif; ?></span>


      <?php echo showQusetionCategoryComments($ques->comments, '') ?>
   </p><div class="clearfix"></div>
   <input type="hidden" name="question" id="question" value="<?php echo e($ques->question); ?>" >

</div> <div class="clearfix"></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<div class=" question-calendar mrgn-tp-15 mrgn-btm-15">
   <!--radio radio-info-->
   <!--<input type="radio" id="question_opt_2" value="2" name="rdbQuestion" onclick="enableDisableTextbox('enable')">-->
   <p for="question_opt_2" class="col-sm-4">
   <div class="col-sm-12 time-set pdng-0 ">

      <div class="col-sm-3 pdng-lft-0">
         <input class="form-control question-segment seg-<?php echo e($rid); ?>" placeholder="<?php echo e(trim($questionSegs[0])); ?>" value="<?php echo e(trim($questionSegs[0])); ?>" id="labelQuestionPart1" name="labelQuestionPart1" >
      </div>

      <input id="currentRowId" name="currentRowId" type="hidden" value="<?php echo e($rid); ?>" >
      <input id="labelQuestionPart2" name="labelQuestionPart2" type="hidden" value="<?php echo e($strCC); ?>" >
      <span class="ago pull-left pdng-tp-7 pdng-rgt-15" ><?php echo replaceTextWithActualValue('', $strCC, $questionSet->title, $strCC, 'cc') ?></span>
      <input class="question-segment seg-<?php echo e($rid); ?>" type="hidden" value="<?php echo replaceTextWithActualValue('', $strCC, $questionSet->title, $strCC, 'cc') ?>" >

      <div class="col-sm-3 pdng-lft-0">
         <input class="form-control question-segment seg-<?php echo e($rid); ?> <?php echo e($ccClass); ?>" placeholder="<?php if(count($questionSegs)>1): ?><?php echo e(trim($questionSegs[1])); ?><?php endif; ?>"  value="<?php if(count($questionSegs)>1): ?><?php echo e(trim($questionSegs[1])); ?><?php endif; ?>" id="labelQuestionPart3" name="labelQuestionPart3"  >
      </div>
   </div>
</p>
<div class="clearfix"></div>
</div> 
<!--end displaying quetion section-->
<p><b>Answering Method</b></p>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 time-set pdng-0 mrgn-tp-15 <?php if($answer_method == 'mcq' || $answer_method == 'dropDown'): ?> <?php echo e('mrgn-btm-25'); ?> <?php else: ?> <?php echo e('mrgn-btm-10'); ?> <?php endif; ?> min-w" >
   <select id="answeringMethod<?php echo e($rid); ?>" name="answeringMethod<?php echo e($rid); ?>" class="selectpicker show-tick " onchange="showAnswerOption(this.value, <?php echo e($rid); ?>, <?php echo e($qid); ?>, <?php echo e($cid); ?>)">
      <option value="dateT" <?php if($answer_method == 'dateT'): ?> <?php echo e('selected=selected'); ?> <?php endif; ?>>Date & Time</option>
      <option value="dropDown"  <?php if($answer_method == 'dropDown'): ?> <?php echo e('selected=selected'); ?> <?php endif; ?>>Dropdown</option>
      <option value="mcq"  <?php if($answer_method == 'mcq'): ?> <?php echo e('selected=selected'); ?> <?php endif; ?>>Multiple choice</option>
      <option value="rating"  <?php if($answer_method == 'rating'): ?> <?php echo e('selected=selected'); ?> <?php endif; ?>>Rating</option>
      <option value="textBox"  <?php if($answer_method == 'textBox'): ?> <?php echo e('selected=selected'); ?> <?php endif; ?>>Textbox</option>
      <option value="3Combo"  <?php if($answer_method == '3Combo'): ?> <?php echo e('selected=selected'); ?> <?php endif; ?>>Duration</option>
      <!-- start checking sub question of yes no type question.-->
      <!-- used to add or remove Yes/No option in answer method-->
      <?php if(!in_array($rid, $yesNoSubQuestions)): ?>
      <option value="yesNo"  <?php if($answer_method == 'yesNo'): ?> <?php echo e('selected=selected'); ?> <?php endif; ?>>Yes / No</option>
      <?php endif; ?>
      <!-- end checking sub question of yes no type question.-->
      <!-- used to add or remove Yes/No option in answer method-->
   </select>
</div>
<input type="hidden" id="prevAnsweringMethod<?php echo e($rid); ?>" name="prevAnsweringMethod<?php echo e($rid); ?>" value="<?php echo e($answer_method); ?>" >
<div class="clearfix"></div>