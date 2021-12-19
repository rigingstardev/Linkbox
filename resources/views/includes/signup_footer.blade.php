</body>
<script src="{{asset('assets/physician/js/jquery-2.1.4.js')}}"></script>
<script src="{{asset('assets/physician/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/physician/js/bootstrap-select.js')}}"></script>
<script src="{{asset('assets/physician/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/common/js/bootstrap-datetimepicker.min.js')}}"></script>
<script>
var nowTemp = new Date();
// var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
var checkin = $('.date-picker1').datepicker({
  onRender: function(date) {
    return date.valueOf() > now.valueOf() ? 'disabled' : '';
  }
})
$('.form_date').datetimepicker({  
        autoclose: 1,
        todayHighlight: 1,        
        minView: 2, 
        pickerPosition: "bottom-left",
        endDate: '+0d'
});
$("#patients, #administrative, #notification, #account, #not-done").click(function () {
    alert("Not implemented");
});
</script>
</html>