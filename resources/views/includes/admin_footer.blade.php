</div>
<!-- ./wrapper -->

</body>
<!-- <script type="text/javascript" src="{{asset('assets/admin/js/jquery-2.1.4.js')}}"></script> -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/bootstrap-select.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/bootstrap-datepicker.js')}}"></script>
<!-- <script type="text/javascript" src="{{asset('assets/physician/js/jquery.dataTables.js?v=1.0')}}"></script> -->

<script type="text/javascript" src="{{asset('assets/admin/js/jquery.dataTables.min.js')}}"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" src="{{asset('assets/admin/js/common-scripts.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/admin-scripts.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/ajax_validator.js')}}"></script>
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
   "paginationCount": 20,
   "popupPaginationCount": 5,
   "listPaginationCount": 15,
   "no_data": "{{ trans('custom.no_data') }}",
   "confirm_sponsored_settings": "{{ trans('Admin::messages.confirm_sponsored_settings') }}",
   "confrm_patient_to_inactivate": "{{ trans('Admin::messages.confrm_patient_to_inactivate') }}",
   "confrm_physician_to_inactivate": "{{ trans('Admin::messages.confrm_physician_to_inactivate') }}",
   "confrm_patient_to_activate": "{{ trans('Admin::messages.confrm_patient_to_activate') }}",
   "confrm_physician_to_activate": "{{ trans('Admin::messages.confrm_physician_to_activate') }}",
   "specify_reason": "{{ trans('Admin::messages.specify_reason') }}",
   "autoSuggestionRoute": "{{url('autoComplete')}}",
};
/* ]]> */


</script>
</html>