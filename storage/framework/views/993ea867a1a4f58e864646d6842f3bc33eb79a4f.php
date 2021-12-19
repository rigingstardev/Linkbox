<?php
$i                = 0;
$prevRowId        = 0;
$prevMainQuestion = '';
?>
<!--    start  foreach ( $selectedCategories as $row)       -->
<?php $__currentLoopData = $selectedCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
<!--// checking for the question is subquestion for yes / no type question-->
<?php
$i++;
$isMainQuestion   = $row->ans_question_category_id;
$isMainQuestionDisabled   ='';
// getting the question status. checking whether parent the question is disabled or not
if(is_null($isMainQuestion))
$isMainQuestionDisabled   = $row->quest_status;
?>

<div class="content-sub mrgn-btm-15 pdng-0  <?php if($row->created_via=='C'): ?> <?php echo e('unread'); ?> <?php endif; ?>" id="view-question-settings-<?php echo e($row->id); ?>" >
   <div class="content-sub-heading <?php if(!is_null($isMainQuestion)): ?><?php echo e('unread'); ?><?php endif; ?> ">
      <div class="col-sm-12">
         <!--   start if(is_null($isMainQuestion))   show category for the main questions only.-->
         <?php if(is_null($isMainQuestion)): ?> 
         <?php $prevMainQuestion = $i; //replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc'); ?>
         <b><?php echo e($row->category); ?></b>
         <?php else: ?>
         <b ><?php echo e('Next Question to ask if the answer of "Question '.$prevMainQuestion.'"  is '.$row->ans_option.':'); ?></b>
         <?php endif; ?>
         <!--   end if(is_null($isMainQuestion))   show category for the main questions only.-->

         <!--    start  if(Request::segment(1) != 'admin')        -->
         <?php if(Request::segment(1) != 'admin'): ?> 

         <!--    start  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->
         <?php if(!in_array($row->id, $yesNoSubQuestions)): ?>
         <a href="javascript:void(0)" id="delete-<?php echo e($row->id); ?>" class="edit pull-right delete-question remove-tooltip" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete" onclick="setQuestionFlags('delete',<?php echo e($row->id); ?>,<?php echo e($row->category_id); ?>,<?php echo e($row->question_id); ?>)"><i class="fa fa-trash-o" ></i></a> 
         <?php endif; ?>
         <!--    end  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->

         <?php endif; ?>
         <!--    end  if(Request::segment(1) != 'admin')        -->
         <!--if(is_null($isMainQuestion))-->
      </div>
      <div class="clearfix"></div>
   </div>
   <!--endif-->
   <div class="content-area-sub">
      <div class="col-sm-12 mrgn-btm-15">
         <!-- checking for login type-->
         <!--    start  if(Request::segment(1) != 'admin')        -->

         <?php if(Request::segment(1) != 'admin'): ?>
         <div class="btn-group question-options">
            <!--    start  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->
            <?php if(!in_array($row->id, $yesNoSubQuestions)): ?>
            <div class="btn clinical-q">
               <div class="checkbox">
                  <input type="checkbox" class="<?php if($row->clinical_question==1): ?><?php echo e('checked clinical-question'); ?><?php endif; ?>" id="clinicalQuestion<?php echo e($row->id); ?>" name="clinicalQuestion<?php echo e($row->id); ?>" value="<?php echo e($row->category_id); ?>" onclick="setQuestionFlags('clinicalQuestion',<?php echo e($row->id); ?>,<?php echo e($row->category_id); ?>,<?php echo e($row->question_id); ?>)" <?php if($row->clinical_question==1): ?> <?php echo e('checked'); ?><?php endif; ?> ><label for="clinicalQuestion<?php echo e($row->id); ?>">Clinical Question</label>
               </div>
            </div>
            <?php endif; ?>
            <!--    end  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->
           
            <button type="button" class="btn remove-tooltip" data-toggle="tooltip" data-placement="top" title="Edit" id="edit-question-<?php echo e($row->category_id); ?>" onclick="editQuestionSettings(<?php echo e($row->id); ?>,<?php echo e($row->category_id); ?>,<?php echo e($row->question_id); ?>, <?php echo e($i); ?>,'<?php echo e($row->answer_method); ?>')"><i class="fa fa-pencil-square-o" ></i></button>
            <!--    start  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->
            <?php if(!in_array($row->id, $yesNoSubQuestions)): ?>
            <button type="button" class="btn remove-tooltip"   data-toggle="tooltip" data-placement="top" <?php if($row->quest_status==1): ?> <?php echo e('title=Enabled'); ?><?php else: ?>  <?php echo e('title=Disabled'); ?> <?php endif; ?>  onclick="setQuestionFlags('disable',<?php echo e($row->id); ?>,<?php echo e($row->category_id); ?>,<?php echo e($row->question_id); ?>)" id="question-status-<?php echo e($row->id); ?>"><i class="fa fa-ban" id="disabled-<?php echo e($row->id); ?>" <?php if($row->quest_status != 1): ?> <?php echo e('style=color:#ccc;'); ?> <?php endif; ?>   ></i></button>
            <button type="button" class="btn remove-tooltip" data-toggle="tooltip" data-placement="top" title="Copy" onclick="setQuestionFlags('copy',<?php echo e($row->id); ?>,<?php echo e($row->category_id); ?>,<?php echo e($row->question_id); ?>)"><i class="fa fa-files-o"></i></button>
            <?php endif; ?>
            <!--    end  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->

         </div>
         <?php endif; ?>
         <!--    end  if(Request::segment(1) != 'admin')        -->

         <?php echo $__env->make('layouts.answer_options', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

         <!--    start  if($row->answer_method !='mcq')        -->
         <?php if($row->answer_method !='mcq'): ?>
      </div>
      <?php endif; ?>
      <!--    end  if($row->answer_method !='mcq')        -->
      <div class="clearfix"></div>
      <div class="col-sm-12">
         <b class="mrgn-btm-10 display-block">Narrative Output</b>
         <p><?php echo str_replace('[CC]', $questionSet->title, $row->narrative_output_p1); ?></p>
      </div> 
   </div> 
   <!--if(is_null($isMainQuestion))-->
</div>
<!--endif-->
<div class="content-sub mrgn-btm-15 pdng-0 hidden" id="edit-question-settings-<?php echo e($row->id); ?>" >edit-question-settings-<?php echo e($row->id); ?></div>
<input type="hidden" id="prevAnsMethod<?php echo e($row->id); ?>" name="prevAnsMethod<?php echo e($row->id); ?>" value="<?php echo e($row->answer_method); ?>" >
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 