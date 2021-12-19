</div>
<!-- ./wrapper -->
@include('pages.terms_and_privacy')
<style>
   .modal {
      text-align: center;
      padding: 0!important;
   }
   .modal:before {
      content: '';
      display: inline-block;
      height: 100%;
      vertical-align: middle;
      margin-right: -4px;
   }

   .modal-dialog {
      display: inline-block;
      text-align: left;
      vertical-align: middle;
   }
</style>
</body>
<script type="text/javascript" src="{{asset('assets/patient/js/jquery-2.1.4.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/patient/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/physician/js/moment-with-locales.js') }}"></script>
<script type="text/javascript" src="{{asset('assets/physician/js/bootstrap-datetimepicker.js')}}"></script>
<!-- <script type="text/javascript" src="{{asset('assets/common/js/bootstrap-datetimepicker.min.js')}}"></script> -->
<script type="text/javascript" src="{{ asset('assets/patient/js/bootstrap-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/patient/js/app.js') }}"></script>
<!-- <script type="text/javascript" src="{{asset('assets/patient/js/bootstrap-datepicker.js')}}"></script> -->
<script type="text/javascript" src="{{asset('assets/common/js/common.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/physician/js/jquery.dataTables.js?v=1.0')}}"></script>
<script>
$(document).ready(function() {
   var agreed     = '{{ Auth::user()->agreed }}';
   var user_role  = 'P';
   var user_id    = '{{ Auth::user()->id }}';

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
$('.form_date').datetimepicker({
   autoclose: 1,
   todayHighlight: 1,
   minView: 2,
   pickerPosition: "bottom-left",
   endDate: '+0d'
});

$(function () {
    $(".datetimepicker9").keypress(function(event) {event.preventDefault();});
    $('.datetimepicker9').datetimepicker({
      viewMode: 'years',
      format:'DD/MM/YYYY',
    });
});

</script>
<script>

    $("#administrative, #notification, #account, #not-done, .not-done").click(function () {
       alert("Not implemented");
    });
    /* <![CDATA[ */
    var params = {
       "site_url_path": "{{ URL::to('/') }}",
       "errorClass": "error",
       "dbChangeError": "{{ trans('custom.dnInsertFailed') }}",
       "dbChangeSuccess": "{{ trans('custom.dnInsertSuccess') }}",
       "delete_question_category": "{{ trans('custom.delete_question_category') }}",
       "copy_question_category": "{{ trans('custom.copy_question_category') }}",
       "copy_question_category_success": "{{ trans('custom.copy_question_category_success') }}",
       "delete_question_category_success": "{{ trans('custom.delete_question_category_success') }}",
       "build_question_confirm": "{{ trans('custom.build_question_confirm') }}",
       "question_set_cannot_be_empty": "{{ trans('custom.question_set_cannot_be_empty') }}",
       "disabled_question_category_success": "{{ trans('custom.disabled_question_category_success') }}",
       "enabled_question_category_success": "{{ trans('custom.enabled_question_category_success') }}",
       "set_as_clinical_question": "{{ trans('custom.set_as_clinical_question') }}",
       "unset_clinical_question": "{{ trans('custom.unset_clinical_question') }}",
       "question_visibility_changed": "{{ trans('custom.question_visibility_changed') }}",
       "change_question_visibility": "{{ trans('custom.change_question_visibility') }}",
       "description_max_length": "{{ trans('custom.description_max_length') }}",
       "description_max": "{{ trans('custom.description_max') }}",
       "alert_another_question_open_for_edit": "{{ trans('custom.alert_another_question_open_for_edit') }}",
       "paginationCount": 20,
       "notificationPaginationCount": 10,
       "smallPaginationCount": 5,
       "no_data": "{{ trans('custom.no_data') }}",
       "confirm_change_request_status": "{{ trans('Patient::messages.confirm_change_request_status') }}",
       "no_notifications_found": "{{ trans('custom.no_notifications_found') }}",
    };
    /* ]]> */
</script>
<script type="text/javascript" src="{{asset('assets/patient/js/common-scripts.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/ajax_validator.js')}}"></script>
<script type="text/javascript">
    notifCount();
    setInterval(notifCount, 1000 * 60 * 10);
</script>
@yield('page_scripts')
</html>