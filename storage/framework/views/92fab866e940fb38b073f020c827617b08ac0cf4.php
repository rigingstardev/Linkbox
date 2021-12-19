</div>
<?php echo $__env->make('pages.terms_and_privacy', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- ./wrapper -->
</body>
<input type="hidden" name="checkAndSetEditQusetion" id="checkAndSetEditQusetion" value="">
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/jquery-2.1.4.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/bootstrap.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/bootstrap-select.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/app.js?v=1')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/bootstrap-datepicker.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/common/js/bootstrap-datetimepicker.min.js')); ?>"></script>
<!-- <script type="text/javascript" src="<?php echo e(asset('assets/physician/js/jquery.dataTables.min.js')); ?>"></script> -->
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/jquery.dataTables.js?v=1.0')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/common/js/jquery.auto-complete.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/common/js/common.js')); ?>"></script>
<script>
$(document).ready(function() {
   // To check the User Agreement
   var agreed     = '<?php echo e(Auth::user()->agreed); ?>';
   var user_role  = '<?php echo e(Auth::user()->user_role); ?>';
   var user_id    = '<?php echo e(Auth::user()->id); ?>';

   if (agreed === 'N') {
      $('#userRoleAgreement').val(user_role);
      $('#userIdAgree').val(user_id);
      $('#myModalTermsAgreement').modal({backdrop: 'static', keyboard: false});
      $('#myModalTermsAgreement').modal('show');
   } else {
      $('#myModalTermsAgreement').modal('hide');      
   }
});
$('.selectpicker1').selectpicker();
$('[data-toggle="tooltip"]').on('click', function () {
   $(this).tooltip('hide');
});
$("#menu-toggle").click(function (e) {
   e.preventDefault();
   $("#wrapper").toggleClass("toggled");
});

$('#myModal').on('shown.bs.modal', function () {
   $('#myInput').focus()
})
$('#myModal1').on('shown.bs.modal', function () {
   $('#myInput').focus()
})
$('.date-picker').datepicker();
$("#onset-edit").hide();
$("#onset-edit-btn").click(function () {
   $("#onset-edit").show();
   $("#onset-view").hide();
});
$("#done-btn, #cancel-btn").click(function () {
   $("#onset-edit").hide();
   $("#onset-view").show();
});

$('.nopermission').click(function (e) {
   e.preventDefault();
   alert('No Permission');
   return false;
})

$("#agg-edit").hide();
$("#agg-edit-btn").click(function () {
   $("#agg-edit").show();
   $("#agg-view").hide();
});
$("#agg-done-btn, #agg-cancel-btn").click(function () {
   $("#agg-edit").hide();
   $("#agg-view").show();
});
$(".not-done").click(function () {
   alert("Not implemented");
});
//Input text auto width//

$.fn.textWidth = function (text, font) {

   if (!$.fn.textWidth.fakeEl)
      $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);

   $.fn.textWidth.fakeEl.text(text || this.val() || this.text() || this.attr('placeholder')).css('font', font || this.css('font'));

   return $.fn.textWidth.fakeEl.width();
};

$('.width-dynamic').on('input', function () {
   var inputWidth = $(this).textWidth();
   $(this).css({
      width: inputWidth
   })
}).trigger('input');


function inputWidth(elem, minW, maxW) {
   elem = $(this);
   console.log(elem)
}

var targetElem = $('.width-dynamic');

inputWidth(targetElem);

$(document).on('click', '.notdone', function (e) {
   e.preventDefault();
   alert('Not Implemented');
   return false;
});
if ($(window).width() < 1025) {
   $('.remove-tooltip').removeAttr('data-toggle');
}
function clearScript() {
   console.Clear();
}

</script>
<script>

    $("#administrative, #notification, #account, #not-done, .not-done").click(function () {
       alert("Not implemented");
    });
    /* <![CDATA[ */
    var params = {
       "site_url_path": "<?php echo e(URL::to('/')); ?>",
       "errorClass": "error",
       "dbChangeError": "<?php echo e(trans('custom.dnInsertFailed')); ?>",
       "dbChangeSuccess": "<?php echo e(trans('custom.dnInsertSuccess')); ?>",
       "delete_question_category": "<?php echo e(trans('custom.delete_question_category')); ?>",
       "copy_question_category": "<?php echo e(trans('custom.copy_question_category')); ?>",
       "copy_question_category_success": "<?php echo e(trans('custom.copy_question_category_success')); ?>",
       "delete_question_category_success": "<?php echo e(trans('custom.delete_question_category_success')); ?>",
       "build_question_confirm": "<?php echo e(trans('custom.build_question_confirm')); ?>",
       "question_set_cannot_be_empty": "<?php echo e(trans('custom.question_set_cannot_be_empty')); ?>",
//       "disabled_question_category_success": "<?php echo e(trans('custom.disabled_question_category_success')); ?>",
       "enabled_question_category_success": "<?php echo e(trans('custom.enabled_question_category_success')); ?>",
       "set_as_clinical_question": "<?php echo e(trans('custom.set_as_clinical_question')); ?>",
       "unset_clinical_question": "<?php echo e(trans('custom.unset_clinical_question')); ?>",
//       "question_visibility_changed": "<?php echo e(trans('custom.question_visibility_changed')); ?>",
       "change_question_visibility": "<?php echo e(trans('custom.change_question_visibility')); ?>",
       "description_max_length": "<?php echo e(trans('custom.description_max_length')); ?>",
       "description_max": "<?php echo e(trans('custom.description_max')); ?>",
       "alert_another_question_open_for_edit": "<?php echo e(trans('custom.alert_another_question_open_for_edit')); ?>",
       "paginationCount": 15,
       "notificationPaginationCount": 10,
       "popupPaginationCount": 8,
       "smallPaginationCount": 5,
       "no_data": "<?php echo e(trans('custom.no_data')); ?>",
       "autoSuggestionRoute": "<?php echo e(url('autoComplete')); ?>",
       "no_notifications_found": "<?php echo e(trans('custom.no_notifications_found')); ?>",
       "specify_title": "<?php echo e(trans('Physician::messages.specify_title')); ?>",
       "copy_question_success": "<?php echo e(trans('Physician::messages.copy_question_success')); ?>",
       "must_have_clinical_question": "<?php echo e(trans('Physician::messages.must_have_clinical_question')); ?>",
       "delete_question_confirm": "<?php echo e(trans('Physician::messages.delete_question_confirm')); ?>",
    };
    /* ]]> */

</script>
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/common-scripts.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/common/js/ajax_validator.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/questionset-scripts.js')); ?>"></script>
<script type="text/javascript">
    function clearScript() {
       console.clear();
    }// getting notification count
    notifCount();
    setInterval(notifCount, 1000 * 60 * 10);
</script>
<!-- To Manage Stript client validation and Token Generation -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
</html>