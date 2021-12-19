<div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
      <?php echo Form::open(['role' => 'form', 'name' => 'frmCategory', 'url'=>'physician/editCategory', 'id' => 'frmCategory','autocomplete' => 'off']); ?>

      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" <span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="myModalLabel">Add Question categories to the Question Set.</h4>
      </div>
      <div class="modal-body">
         <?php
         $selectedList                         = array();
         $selectedQuestions                    = array();
         $newQuestion                          = array();
         $cId                                  = '';
         ?>
         <!--------- start selected questions and category list ------------>
         <?php if(count($selectedCategories)>0): ?>
         <?php $__currentLoopData = $selectedCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <?php
         $cId                                  = $row->category_id;
         $masterID                             = $row->master_question_id;
         // selected categories
         $selectedList[]                       = $cId;
         // selected quetsion id
         $selectedQuestions[]                  = $row->master_question_id;
         $selectedQuestions['question'][$cId]  = $row->question;
         $newQuestion[$cId . '--' . $masterID] = $row->question;
         // selected quetsion by category
         $selectedQuestions['cID'][$cId][]     = $row->master_question_id;
         ?>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php endif; ?>


         <!--------- end selected questions and category list ------------>
         <!--************-->
         <!--------- start master questions and category list ------------>
         <?php $qcount                               = 0; ?>
         <?php if(count($masterQuestions)>0): ?>
         <?php $__currentLoopData = $masterQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

         <?php
         // master quetsion details
         $cId                                  = $row->category_id;
         // master quetsion id by category
         $masterQuestionsList['qid'][$cId][]   = $row->id;
         // master quetsion by category
         $masterQuestionsList[$cId][]          = $row->question;
         // mapping question with its master id
         $questionWithId[$cId][$row->question] = $row->id;
         // $masterQuestionsList[]         = $row->question;
         $qcount++;
         ?>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php endif; ?>
         <!--------- end master questions and category list ------------>
         <!--------- start master   category list and selected questions ------------>
 
         <?php if(count($categories)>0): ?>
         <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="col-sm-12 mrgn-btm-20">
            <div class="checkbox <?php if(in_array($category->id, $selectedList)): ?> <?php echo e('disable-check'); ?><?php endif; ?> " >
               <input id="category<?php echo e($category->id); ?>" onclick="selectOrDeselectQuestions(<?php echo e($category->id); ?>, 'category', 0)"  name="category<?php echo e($category->id); ?>"  <?php if(in_array($category->id, $selectedList)): ?> <?php echo e('checked'); ?> <?php echo e('disabled'); ?> <?php endif; ?> type="checkbox" value="<?php echo e($category->id); ?>" <?php if($category->id == 10): ?> <?php echo e('class=other-catgy'); ?><?php endif; ?>>
                      <label for="category<?php echo e($category->id); ?>"> <?php echo e($category->category); ?></label></div>
         </div>

         <!--------- start selected category list and selected questions ------------>
         <?php if(count($masterQuestionsList[$category->id])>0): ?>
         <?php for($k=0;$k<count($masterQuestionsList[$category->id]); $k++): ?>
            <?php
            $masterQuesId                         = $masterQuestionsList['qid'][$category->id][$k];
            $masterQuestion                       = $masterQuestionsList[$category->id][$k];
            $masterQID                            = $questionWithId[$category->id][$masterQuestion];
            // checking if the question is in selected category. if so it will show the selected question else default question
            if (key_exists($category->id . '--' . $masterQID, $newQuestion))
                $displayQuestion                      = $newQuestion[$category->id . '--' . $masterQID];
            else
                $displayQuestion                      = $masterQuestion;
            ?>

            <div class="col-sm-12 mrgn-btm-20 mrgn-lft-25 ">
               <!--div with chcking if the category is selected, if so disabling the chckbox inside-->
               <div class="checkbox <?php if(in_array($category->id, $selectedList)): ?> <?php echo e('disable-check'); ?><?php endif; ?> ">
                  <input class="question-<?php echo e($category->id); ?> <?php if( $category->id ==10): ?> <?php echo e('other-catgy'); ?> <?php endif; ?>"  onclick="selectOrDeselectQuestions(<?php echo e($category->id); ?>, 'masterQuestion', <?php echo e($masterQuesId); ?>)" id="masterQuestion<?php echo e($masterQuesId); ?>"   name="masterQuestion<?php echo e($masterQuesId); ?>"
                         <?php if(in_array($masterQuesId, $selectedQuestions)): ?> <?php echo e('checked'); ?> <?php echo e('disabled'); ?> <?php endif; ?> type="checkbox" value="<?php echo e($masterQuesId); ?>" >
                         <?php if( $category->id ==10): ?>
                         <div class="col-sm-12 col-lg-6" id="div_other_question">
                     <input type='text' class="form-control div_other_question <?php if(!key_exists($category->id . '--' . $masterQID, $newQuestion)): ?> <?php echo e('hidden'); ?> <?php endif; ?>" id="other_question" name="other_question" maxlength="255" placeholder="<?php echo e($displayQuestion); ?>" value="<?php echo e($displayQuestion); ?>" <?php if(key_exists($category->id . '--' . $masterQID, $newQuestion)): ?> <?php echo e('disabled'); ?> <?php endif; ?>>
                  </div>
                  <!--else of the category >id == 10-->
                  <?php else: ?>
                  <label for="masterQuestion<?php echo e($masterQuesId); ?>"> <?php echo e($displayQuestion); ?></label>
                  <!--end if ------ checking the category >id == 10-->
                  <?php endif; ?>
               </div>
            </div>
            <?php endfor; ?>
            <?php endif; ?>

            <!--------- end selected category list and selected questions ------------>
            <input type="hidden" id="masterQuestionsCount-<?php echo e($category->id); ?>" name="masterQuestionsCount-<?php echo e($category->id); ?>" value="<?php echo e(count($masterQuestionsList[$category->id])); ?>" >
            <?php
            $selQuesCount                         = 0;

            if (key_exists('cID', $selectedQuestions) && key_exists($category->id, $selectedQuestions['cID']))
                $selQuesCount = count($selectedQuestions['cID'][$category->id]);
            else
                $selQuesCount = 0;
            ?>
            <input type="hidden" id="selectedQuestionsCount-<?php echo e($category->id); ?>" name="masterQuestionsCount-<?php echo e($category->id); ?>" value="<?php echo e($selQuesCount); ?>" >


            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <!--------- end master   category list and selected questions ------------>
            <div class="clearfix"></div>
<!--                           <input type="hidden" id="chiefComplaint" name="chiefComplaint" value="1" >
            <input type="hidden" id="description" name="description" value="1" >-->
            <input type="hidden" id="requestType" name="requestType" value="category" >
            <input type="hidden" id="qid" name="qid" value="<?php echo e($id); ?>" >
            <input type="hidden" id="category" name="category" value="" >
            <input type="hidden" id="checkFormatType" name="checkFormatType" value="" >
            <input type="hidden" id="categoryCount" name="categoryCount" value="<?php echo e(($qcount)); ?>" >
            <input type="hidden" id="totalSelectedCategoryCount" name="totalSelectedCategoryCount" value="<?php echo e(count($selectedQuestions)); ?>" >
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary update-category-list" title="Done">Done</button>
            </div>
            <?php echo Form::close(); ?>

      </div>
   </div>