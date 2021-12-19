<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1>Build a New Question Set</h1>
   </section>

   <!-- Main content -->
   <section class="content">

      <div class="tab-heading">
         <div class="checkbox">
            <input type="checkbox"  id="checkbox1" class=""/>
            <label for="checkbox1" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
               Build a Question Set from Scratch
            </label>
         </div>
      </div>
      <div id="collapseOne" aria-expanded="false" class="collapse" style="">
         <?php echo Form::open(['role' => 'form', 'name' => 'frmQuestionSet', 'url'=>'physician/postQuestionSet', 'id' => 'frmQuestionSet','autocomplete' => 'off']); ?>

         <input type="hidden" id="requestType" name="requestType" value="all" >

         <div class="content-sub  mrgn-btm-20">
            <div class="col-sm-12 mrgn-btm-20">
               <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 pdng-0 pdng-tp-7">Chief Complaint:</div>
               <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4  input-main"><input class="form-control autoComplete" type="text" autofocus="" maxlength="100" id="chiefComplaint" name="chiefComplaint" data-suggest="chiefComplaint"></div>
               <div class="clearfix"></div>
            </div>

            <div class="col-sm-12 mrgn-btm-20">
               <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 pdng-0 pdng-tp-7">Description:</div>
               <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 input-main"><textarea class="form-control count-chars" rows="4" maxlength="1500" id="description" name="description"  ></textarea></div>
               <div class="clearfix"></div>
            </div>
         </div>

         <div class="content-sub mrgn-btm-15 pdng-0">
            <div class="content-sub-heading">
               <div class="col-sm-12"><b>Select Question categories to be added in the question set</b></div>
               <div class="clearfix"></div>
            </div>

            <div class="content-area-sub">
               <?php if(count((array)$categories)>0): ?>
               <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <div class="col-sm-12 mrgn-btm-15">
                  <div class="checkbox">
                     <input id="category<?php echo e($category->id); ?>" name="category<?php echo e($category->id); ?>" type="checkbox" value="<?php echo e($category->id); ?>" <?php if($category->id == 10): ?> <?php echo e('class=other-catgy'); ?><?php endif; ?>>
                            <label for="category<?php echo e($category->id); ?>">
                        <?php echo e($category->category); ?>

                     </label>
                  </div>
                  <?php if($category->id == 10): ?>
                  <div class="col-sm-12 col-lg-6 mrgn-lft-15 mrgn-tp-20  hidden div_other_question" >
                     <input type='text' class="form-control " id="other_question" name="other_question" maxlength="255" placeholder="<?php echo e(trans('custom.other_question')); ?>" value="<?php echo e(trans('custom.other_question')); ?>">
                  </div>
                  <?php endif; ?>
               </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php endif; ?>
               <div class="col-sm-12 mrgn-btm-15">
                  <div id="category"></div>
               </div>

               <input type="hidden" id="category" name="category" value="" >
               <input type="hidden" id="categoryCount" name="categoryCount" value="<?php echo e(count((array)$categories)); ?>" >
            </div>
         </div>
         <?php echo Form::close(); ?>

      </div>
      <div class="clearfix"></div>
      <div class="tab-heading">
         <div class="checkbox">
            <input type="checkbox"  id="checkbox22"/>
            <label for="checkbox22" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
               Select a Question Set from Library
            </label>
         </div>
      </div>
      <!---------------------      Question Set from Library  ---------------------------------->
      <div id="collapseTwo" aria-expanded="true" class="collapse">
         <div class="published-question-sets">
            <table id="select-from-library">
               <thead>
                  <tr class="hidden">
                     <th></th>
                  </tr>
               </thead>
            </table>
         </div> 
      </div>
      <div class="clearfix"></div>
      <div class="alertMessage"></div>
      <div class="btn-wrap hidden" id="div-submit-next-on-create-question">
         <!--<button type="button" class="btn btn-primary mrgn-lft-15" onclick="location.href ='<?php echo e(url('physician/createQuestionSetNext')); ?>'">Next</button>-->
         <button type="button" class="btn btn-primary mrgn-lft-15 post-question-set "  title="Next" id="btn-create-question-next" style="display: none" >Next</button>
         <button type="button" class="btn btn-default" style="display: none"  onclick="location.href = '<?php echo e(url('physician/home')); ?>'" title="Cancel" id="btn-create-question-cancel">Cancel</button>
      </div>
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_scripts'); ?>
<script type="text/javascript">
    $('#checkbox1').attr('checked', false); // Checks it
    $('#checkbox22').attr('checked', false); // Unchecks it
    function showButtons() {
       $("#btn-create-question-cancel").show();
       $("#btn-create-question-next").show();
    }
    function hideButtons() {
       $("#div-submit-next-on-create-question").removeClass('hidden');
       $("#btn-create-question-cancel").hide();
       $("#btn-create-question-next").hide();
    }
// checking first checkbox
    $("#checkbox1").click(function () {
       $('.error').remove();
       if ($(this).is(':checked')) {
          $('#collapseTwo').collapse('hide');
          $('#checkbox22').attr('checked', false);
          $('#chiefComplaint').focus();
       }
       if ($('#collapseOne').attr('aria-expanded') == 'true')
          showButtons();
       else
          hideButtons();
    });
    hideButtons();
    $("#checkbox2").click(function () {
       if ($(this).is(":checked"))
          $(".send-as-email").removeAttr('readonly').focus();
       else
          $(".send-as-email").prop('readonly', true).val('');
    });
    $("#checkbox22").click(function () {
       $('.error').remove();
       if ($(this).is(':checked')) {
//       ----- start getting the latest published set ----------
          var columns = [
             {data: 'title', name: 'title', orderable: false, sortable: false, "class": "border-none"},
          ];
          var parameters = [];
          parameters['tabId'] = 'select-from-library';
          parameters['columns'] = columns;
          parameters['ajaxUrl'] = "<?php echo url('physician/get-question-sets'); ?>";
          parameters['isPopup'] = true;
          // getting list
          listingTables(parameters);
//      ----- end getting the latest published set ----------

          $('#collapseOne').collapse('hide');
          $('#checkbox1').attr('checked', false);
       }
       hideButtons();
       if ($('#collapseTwo').attr('aria-expanded') == 'false' && $('#collapseOne').attr('aria-expanded') == 'true')
          showButtons();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout2', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>