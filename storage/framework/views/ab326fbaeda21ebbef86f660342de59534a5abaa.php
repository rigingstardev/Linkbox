<?php echo e(Form::open(['role' => 'form', 'name' => 'frmEditQuestion'.$rid, 'url'=>'physician/frmEditQuestion', 'id' => 'frmEditQuestion'.$rid,'autocomplete' => 'off'])); ?>

<?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="content-sub mrgn-btm-20 pdng-0" id="category-edit-<?php echo e($rid); ?>">

   <div class="content-sub-heading">
      <div class="col-sm-12">
         <b><?php echo e($data->category->category); ?></b>
         <a href="#" class="edit pull-right" id="not-done" onclick="setQuestionFlags('delete',<?php echo e($rid); ?>,<?php echo e($cid); ?>,<?php echo e($qid); ?>)"><i class="fa fa-trash-o" ></i></a>
      </div>
      <div class="clearfix"></div>
   </div>
   <div class="content-area-sub" >

      <div class="col-sm-12" id="div-header">
         <div id="show_answer_option_<?php echo e($rid); ?>"></div>
         <!--      end date and time option list   -->
         <div class="clearfix"></div>
         <div class="col-sm-4 mrgn-btm-5 pdng-lft-0 mrgn-tp-5">
            <b>Extra Comments</b>
            <input class="form-control" id="txtComments" name="txtComments" value="<?php echo e($data->comments); ?>" >
         </div>
         <div class="clearfix"></div>
         <div class="col-sm-12 mrgn-btm-5 pdng-lft-0 mrgn-tp-5">
            <b class="">Narrative Output</b></div>
         <?php
         $narrativeOutput = '';
         $narrativeOutput = explode('[CC]', $data->narrative_output);
         ?>
         <div class="row mrgn-btm-25">
            <div class="col-sm-4">
               <input class="form-control" id="txtNarrativeOutput1" name="txtNarrativeOutput1" value="<?php echo e($narrativeOutput[0]); ?>"></div>
            <div class="col-sm-4"><select class="form-control" id="txtNarrativeOutput2" name="txtNarrativeOutput2">
                  <option value=""></option>
                  <option value="[CC]"  <?php if(strpos($data->narrative_output, '[CC]') !== false): ?><?php echo e('selected=""'); ?><?php endif; ?>><?php echo e($data->title); ?></option>
               </select></div>
            <div class="col-sm-4"><input class="form-control" id="txtNarrativeOutput3" name="txtNarrativeOutput3" value="<?php if(count((array)$narrativeOutput)>1): ?><?php echo e($narrativeOutput[1]); ?><?php endif; ?>" ></div>
         </div>
      </div>

      <div class="btn-wrap">
         <button type="button" class="btn btn-primary mrgn-lft-15" id="done-btn" onclick="updateQuestionSettings(<?php echo e($rid); ?>,<?php echo e($cid); ?>,<?php echo e($qid); ?>,<?php echo e($serialNo); ?>)" title="Done">Done</button>
         <button type="button" class="btn btn-default" id="cancel-btn" onclick="resetQuestionSettingsWindow(<?php echo e($rid); ?>)" title="Cancel">Cancel</button>
      </div>
   </div>
</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<input type="hidden" name="serial<?php echo e($rid); ?>" id="serial<?php echo e($rid); ?>" value="<?php echo e($serialNo); ?>." >
<input type="hidden" name="cid" id="cid" value="<?php echo e($cid); ?>" >
<input type="hidden" name="qid" id="qid" value="<?php echo e($qid); ?>" >
<input type="hidden" name="rid" id="rid" value="<?php echo e($rid); ?>" >
<?php echo e(Form::close()); ?>