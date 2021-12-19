<?php use Vinkla\Hashids\Facades\Hashids; ?>


<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<?php //dd($questionSets) ?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <?php $__currentLoopData = $questionSets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questionSet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
   <?php $status                                                 = $questionSet->status; ?>
   <section class="content-header">
      <h1><?php echo e($questionSet->title); ?> Question Set</h1>
   </section>

   <!-- Main content -->
   <section class="content content-library"  <?php if($questionSet->bg_image): ?> style="background-image: url(<?php echo e(asset('uploads/question_set/' . $questionSet->question->bg_image)); ?>)" <?php endif; ?>>

            <?php echo $__env->make('includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php echo Form::open(['route' => ['physician.question.set_preview_answers', Hashids::encode($questionSet->id)],'id'=>'patientAnswerFrm','name'=>'patientAnswerFrm']); ?>


            <div class="content-library-bg"></div>

      <?php //$total                                                  = count($questionSet->questionSetWithoutCQ) - ($questionSet->questionSetsWoCQyesNoCount->count()); ?>
      <?php //$answered                                               = count($questionSet->answers);  ?>      

      <h4 class="pull-left">Questions <span class="txt-blue">  </span></h4>
      <section class="content-sub-header">

         <div class="col-xs-12 col-sm-5 col-md-4 col-lg-2 pull-right">
            <div class="row">   

            </div></div>
      </section>

      <div class="content-sub mrgn-btm-20 pdng-0">
         <div class="content-sub-heading"> 
            <div class="col-sm-12">
               <b><?php echo e($questionSet->title); ?></b>

            </div>
            <div class="clearfix"></div>
         </div>

         <div class="content-area-sub">
            <div class="col-sm-12">
               <p><?php echo e($questionSet->description); ?></p>
            </div>
         </div>
      </div>
      <?php
      $pos                                                    = 1;
      $yesnoquestions                                         = [];
      $questions                                              = [];
      ?> 
      
      <?php $__currentLoopData = $questionSet->questionSetWithoutCQ; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $masterqSets): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>            
        <?php if('yesNo' == $masterqSets->answer_method ): ?>              
          <?php $__currentLoopData = $masterqSets->yesNoQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yesno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                 
          <?php $yesnoquestions[$yesno->ans_question_category_id] = ['option' => $yesno->ans_option, 'qcatId' => $yesno->question_category_id]; ?>  
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
        <?php endif; ?> 
        <?php $CurAnswer[$masterqSets->id][$masterqSets->category_id] = ""; ?>                                        
        <?php $CurDesc[$masterqSets->id][$masterqSets->category_id]   = ""; ?> 
        <?php if($questionSet->answers): ?>
         <?php $__currentLoopData = $questionSet->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answerdet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            <?php if($answerdet->question_category_id == $masterqSets->id): ?>
               <?php $CurAnswer[$masterqSets->id][$masterqSets->category_id] = ''; ?>                  
               <?php $CurDesc[$masterqSets->id][$masterqSets->category_id]   = ''; ?>                  
            <?php endif; ?>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
        <?php endif; ?>
        <?php $template                                               = 'Patient::question.partials.' . $masterqSets->answer_method; ?>           
      <!--  To List main questions -->
      <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cKey => $cValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
      <?php if($masterqSets->category_id == $cKey && !in_array($masterqSets->id,$questions)): ?>
      <?php $questions[]                                            = $masterqSets->id; ?>            
      <div class="content-sub mrgn-btm-20 pdng-0"  id="<?php echo 'blk_'.$masterqSets->id; ?>">
               <div class="content-sub-heading">
                  <div class="col-sm-12">
                     <b><?php echo $cValue; ?></b>
                  </div>
                  <div class="clearfix"></div>
               </div>
               <div class="content-area-sub questions">                   
                  <div class="col-md-12 mrgn-btm-25">
                     <?php $clinicalCls                           = ''; ?>
                     <?php if('1' == $masterqSets->clinical_question): ?>
                     <?php $clinicalCls                            = 'clinical'; ?>
                     <label class="lbl-clinic">Clinical Question</label>
                     <?php endif; ?>
                     <p class="mrgn-btm-15"><span class="slnumber"><?php echo $pos++; ?> </span> . <?php echo strReplaceCC($masterqSets->question,$questionSet->title); ?>

                        <?php if($masterqSets->comments != ""): ?>
                        <a class="txt-large mrgn-lft-15" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="<?php echo $masterqSets->comments; ?>" data-original-title="<?php echo $masterqSets->comments; ?>">
                           <i class="fa fa-info-circle"></i>
                        </a>
                        <?php endif; ?>
                     </p>

                     <?php echo $__env->make($template,['qSets' => $masterqSets], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
                  </div>
               </div>
            </div> 
            <!-- To list YesNo questions -->
            <?php if('yesNo' == $masterqSets->answer_method ): ?> 
            <?php $__currentLoopData = $masterqSets->yesNoQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yesno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            <?php 
               $templateYesno                                          = ''; 
            ?>
            <?php 
               $hiddenCls                                              = $yesnoCls = $yesnoQuesId = '';
               $subCnt                                                 = '';
               ?>
            <?php $__currentLoopData = $questionSet->questionSets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qSetsYesNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php //echo $qSetsYesNo->question; ?>
               <?php if($yesno->ans_question_category_id == $qSetsYesNo->id && !in_array($qSetsYesNo->id,$questions)): ?>
               <?php $CurAnswer[$qSetsYesNo->id][$qSetsYesNo->category_id]   = ""; ?>                                        
               <?php $CurDesc[$qSetsYesNo->id][$qSetsYesNo->category_id]     = ""; ?> 
               <?php if($questionSet->answers): ?>
                  <?php $__currentLoopData = $questionSet->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answerdet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                     <?php if($answerdet->question_category_id == $qSetsYesNo->id): ?>
                        <?php $CurAnswer[$qSetsYesNo->id][$qSetsYesNo->category_id]   = $answerdet->answer; ?>                  
                        <?php $CurDesc[$qSetsYesNo->id][$qSetsYesNo->category_id]     = $answerdet->description; ?>                  
                     <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
               <?php endif; ?>
               <?php $questions[]                                            = $qSetsYesNo->id; ?>                  
               <?php
                  if (array_key_exists($qSetsYesNo->id, $yesnoquestions)) {
                     if (array_values($CurAnswer[$yesnoquestions[$qSetsYesNo->id]['qcatId']])[0] != strtolower($yesnoquestions[$qSetsYesNo->id]['option'])) {
                           $hiddenCls = 'hidden';
                     } else
                           $subCnt = $pos++;

                     $yesnoCls = "yesno_" . $yesnoquestions[$qSetsYesNo->id]['qcatId'];
                  }
               ?> 
               <?php $templateYesno = 'Patient::question.partials.' . $qSetsYesNo->answer_method; ?>           
               <div class="content-sub mrgn-btm-20 pdng-0 questions <?php echo $hiddenCls; ?> <?php echo $yesnoCls; ?>"  id="<?php echo 'blk_'.$qSetsYesNo->id; ?>">
                  <div class="content-sub-heading">
                     <div class="col-sm-12">
                     <b><?php echo $qSetsYesNo->category->category; ?></b>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <div class="content-area-sub">                   
                     <div class="col-md-12 mrgn-btm-25">
                     <?php $clinicalCls   = ''; ?>
                     <?php if('1' == $qSetsYesNo->clinical_question): ?>
                        <?php $clinicalCls   = 'clinical'; ?>
                        <label class="lbl-clinic">Clinical Question</label>
                     <?php endif; ?>
                        <p class="mrgn-btm-15"><span class="slnumber"><?php echo $subCnt; ?> </span>. <?php echo strReplaceCC($qSetsYesNo->question,$questionSet->title); ?>

                           <?php if($qSetsYesNo->comments != ""): ?>
                           <a class="txt-large mrgn-lft-15" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="<?php echo $qSetsYesNo ->comments; ?>" data-original-title="<?php echo $qSetsYesNo->comments; ?>">
                              <i class="fa fa-info-circle"></i>
                           </a>
                           <?php endif; ?>
                        </p>
                     <?php echo $__env->make($templateYesno,['qSets' => $qSetsYesNo], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                  </div>
                  </div>
               </div>  
               <?php endif; ?>    
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
               <?php endif; ?>  <!-- End of Yes No Listing -->                                  
               <?php endif; ?> <!-- End of Master Listing -->
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <!-- End of Category Iteration -->
               <?php //exit; ?>     
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  <!-- End of Question Set Iteration -->      
            <div class="clearfix"></div>
         <div class="btn-wrap">            
            <button type="submit" class="btn btn-primary mrgn-lft-15">Save & Preview</button>
         </div>
         <?php if($sessionValue): ?>
            <input type="hidden" name="age" value="<?php echo e($sessionValue['age']); ?>">
            <input type="hidden" name="gender" value="<?php echo e($sessionValue['gender']); ?>">
            <input type="hidden" name="id" value="<?php echo e($sessionValue['id']); ?>">
            <?php endif; ?>
         <?php echo Form::close(); ?>

         </section>
         <!-- /.content -->   
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <!-- /.content-wrapper -->
      <?php $__env->stopSection(); ?>
      <?php $__env->startSection('page_scripts'); ?>
      <script>
         //  <?php if('completed' == $status): ?>
         //          $('#patientAnswerFrm input, #patientAnswerFrm select').prop('disabled', true);
         //          <?php endif; ?>
         //          $('.clinical').prop('disabled', true);
         //  $(document).on('click', '.submitButton', function (event) {
         //     event.preventDefault();
         //     removeWithClass(params.errorClass);
         //     if ('2' == $(this).data('action')) {
         //        if (!(confirm("<?php echo trans('Patient::messages.confirm_submit'); ?>"))) {
         //           return false;
         //        }
         //     }
         //     $('.submitButton').attr('disabled', true);
         //     $.ajax({
         //        type: "POST",
         //        url: $('#patientAnswerFrm').attr('action'),
         //        data: 'saved=' + $(this).data('action') + '&' + $('#patientAnswerFrm').serialize(),
         //        success: function (response) {
         //           var respArray = JSON.parse(response);
         //           $('.submitButton').attr('disabled', false);
         //           //if (respArray.success) {
         //           if (respArray.redirectUrl) {
         //              setTimeout(function () {
         //                 $(location).attr("href", respArray.redirectUrl);
         //              }, 500);
         //           }
         //           // } else {
         //           //showDBChangeAlert('error', params.dbChangeError);
         //           //}
         //        },
         //        error: function (response) {
         //           $('.submitButton').attr('disabled', false);
         //           showValidation(response, params.errorClass);
         //        }
         //     });
         //  })
          $(document).on('click', '.yesnoqtn', function () {
             $('.yesno_' + $(this).data('qid')).addClass('hidden');
             $('.yesno_' + $(this).data('qid') + ' input').val('');
             $('#' + $(this).data('showid')).removeClass('hidden')
             cnt = 1;
             $('div .questions').each(function (i, elem) {
                if (!$(this).hasClass('hidden')) {
                   $(this).find('span.slnumber').html(cnt);
                   cnt++;
                }
             });
             //$('div .total span').html($('div .questions').not('.hidden').length)           
          });
          $(document).ready(function () {
              $('.yesnodiv').each(function (index, value){                
                if($(this).find('.yesnoqtn:hidden').length == 0)
                  $(this).find('.yesnoqtn:first').trigger('click');               
              });     
             // $('div .total span').html($('div .questions').not('.hidden').length)        
          })
      </script>
      <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout2', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>