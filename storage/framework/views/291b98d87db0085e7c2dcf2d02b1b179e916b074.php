<?php $__env->startSection('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1><?php echo e($questionSet->title); ?> Question Set</h1>
   </section>

   <!-- Main content -->
   <section class="content">
      <?php echo $__env->make('layouts.show_alert_message', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
      <section class="content-sub-header">

         <h4 class="pull-left">Questions <span class="txt-blue"><?php echo e(count((array)$selectedCategories)); ?></span></h4>

         <div class="col-xs-12 col-sm-5 col-md-4 col-lg-2 pull-right">
            <div class="row">
               <button type="button" class="btn btn-third btn-block btn-min-width-235 mrgn-btm-15 " title="Add Question Categories"  data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square-o"></i> Add Question Categories</button>

               <!-- Modal -->
               <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <?php echo $__env->make('layouts.add_question_category', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>     
               </div>
            </div></div>
      </section>

      <div class="content-sub mrgn-btm-20 pdng-0" id="questionset-view">
         <div class="content-sub-heading">
            <div class="col-sm-12">
               <b><?php echo e($questionSet->title); ?></b>
               <a href="javascript:void(0)" class="edit pull-right" id="questionset-edit-btn" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" ></i></a>
            </div>
            <div class="clearfix"></div>
         </div>
         <div class="content-area-sub">
            <div class="col-sm-12">
               <p><?php echo nl2br($questionSet->description) ?></p>
            </div>
         </div>
      </div>
      <div class="content-sub mrgn-btm-20 pdng-0 hidden" id="questionset-edit">
         <?php echo Form::open(['role' => 'form', 'name' => 'frmQuestionSet', 'url'=>'physician/editQuestionSet', 'id' => 'frmQuestionSet','autocomplete' => 'off']); ?>

         <div class="content-sub  mrgn-btm-20">
            <div class="col-sm-12 mrgn-btm-20">
               <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 pdng-0 pdng-tp-7">Chief Complaint:</div>
               <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4  input-main">
                  <input class="form-control autoComplete" type="text" maxlength="100"  id="chiefComplaint" name="chiefComplaint" value="<?php echo e($questionSet->title); ?>" data-suggest="chiefComplaint"></div>
               <div class="clearfix"></div>
            </div>

            <div class="col-sm-12 mrgn-btm-20">
               <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 pdng-0 pdng-tp-7">Description:</div>
               <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 input-main">
                  <textarea class="form-control count-chars" rows="4" maxlength="1500" id="description" name="description"><?php echo e($questionSet->description); ?></textarea></div>
               <div class="clearfix"></div>
            </div>
            <input type="hidden" id="qid" name="qid" value="<?php echo e($id); ?>" >
            <input type="hidden" id="requestType" name="requestType" value="head" >

            <input type="hidden" id="categoryCount" name="categoryCount" value="1" >
            <input type="hidden" name="category1" id="category1" value="1">
            <div class="btn-wrap">
               <button type="button" class="btn btn-primary mrgn-lft-15" id="questionset-done-btn" title="Done">Done</button>
               <button type="button" class="btn btn-default" id="questionset-cancel-btn" title="Cancel">Cancel</button> </div>
         </div>
         <?php echo Form::close(); ?>

      </div>
      <?php if($defaultOutput): ?>
      <div class="content-sub mrgn-btm-20 pdng-0" id="defaultoutput-view">
         <div class="content-sub-heading">
            <div class="col-sm-12">
               <b>Narrative Output</b>
               <a href="javascript:void(0)" class="edit pull-right" id="defaultoutput-edit-btn" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" ></i></a>
            </div>
            <div class="clearfix"></div>
         </div> 
         <div class="content-area-sub">
            <div class="col-sm-12">
               <p><?php echo str_replace('[CC]', $questionSet->title, $defaultOutput->narrative_output); ?></p>
            </div>
         </div>       
      </div>
      <div class="content-sub mrgn-btm-20 pdng-0 hidden" id="defaultoutput-edit">
         <?php echo Form::open(['role' => 'form', 'name' => 'frmQuestionSetNarrativeOutput', 'url'=> route('question.defaultoutput.edit'), 'id' => 'frmQuestionSetNarrativeOutput','autocomplete' => 'off']); ?>         
            <div class="content-sub-heading">
               <div class="col-sm-12">
                  <b>Narrative Output</b>                  
               </div>
               <div class="clearfix"></div>
            </div> 
            <div class="content-sub  mrgn-btm-20">
            <div class="content-area-sub">  
               <div class="row">  
                  <div class="col-sm-4"><input class="form-control" id="defaultnarrativeoutput" name="defaultnarrativeoutput" maxlength="500" value="<?php echo e($defaultOutput->narrative_output); ?>" ></div>
               </div>
            </div>           
            <input type="hidden" id="noutput_id" name="noutput_id" value="<?php echo e($defaultOutput->id); ?>" >
            <input type="hidden" id="qid" name="qid" value="<?php echo e($id); ?>">          
            <div class="btn-wrap">
               <button type="button" class="btn btn-primary mrgn-lft-15" id="defaultoutput-done-btn" title="Done">Done</button>
               <button type="button" class="btn btn-default" id="defaultoutput-cancel-btn" title="Cancel">Cancel</button>
            </div>  
         </div>      
         <?php echo Form::close(); ?>

      </div>
      <?php endif; ?>
      <!------- listing question category's-------->
      <?php echo $__env->make('layouts.question_category', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>     

      <div class="btn-wrap">
         <button type="button" class="btn btn-primary mrgn-lft-15" onclick="buildQuestionSet(<?php echo e($qid); ?>)">Build Question Set</button>
         <button type="button" class="btn btn-primary mrgn-lft-15" onclick="location.href = '<?php echo e(url('physician/createQuestionSet')); ?>'">Back</button>
      </div>

      <input type="hidden" name="checkOrigin" id="checkOrigin" value="Edit" >
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout2', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>