</body>
<script src="{{asset('assets/admin/js/jquery-2.1.4.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap-select.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap-datepicker.js')}}"></script>
<script>
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
    $('.date-picker').datepicker();

</script>

</html>