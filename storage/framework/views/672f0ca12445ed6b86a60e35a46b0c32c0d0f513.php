</body>

<script src="<?php echo e(asset('assets/physician/js/jquery-2.1.4.js')); ?>"></script>
<!-- <script src="<?php echo e(asset('assets/physician/js/jquery-2.1.1.min.js')); ?>"></script> -->
<script src="<?php echo e(asset('assets/physician/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/physician/js/moment-with-locales.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/physician/js/bootstrap-datetimepicker.js')); ?>"></script>
<script src="<?php echo e(asset('assets/physician/js/bootstrap-datepicker.js')); ?>"></script>
<script src="<?php echo e(asset('assets/physician/js/bootstrap-select.js')); ?>"></script>
<script src="<?php echo e(asset('assets/physician/js/scrolling-nav.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/common/js/ajax_validator.js')); ?>"></script>
<!-- <script type="text/javascript" src="<?php echo e(asset('assets/common/js/bootstrap-datetimepicker.min.js')); ?>"></script> -->

<script>

$(function () {
    $(".datetimepicker9").keypress(function(event) {event.preventDefault();});
    $('.datetimepicker9').datetimepicker({
      format:'DD/MM/YYYY',
      viewMode: 'years'
    }).on('change', function(){
        $('.datetimepicker').hide();
    });
});

// Add slideDown animation to Bootstrap dropdown when expanding.
$('.dropdown').on('show.bs.dropdown', function () {
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
});

// Add slideUp animation to Bootstrap dropdown when collapsing.
$('.dropdown').on('hide.bs.dropdown', function () {
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
});


//$(document).on('click', 'a#about_us, a#contact_us', function (event) {
//    event.preventDefault();
//
//    $('html, body').animate({
//        scrollTop: $($.attr(this, 'href')).offset().top
//    }, 500);
//});
</script>

<script>
    $(".not-done").click(function (e) {
        e.preventDefault();
        alert("Not implemented");
    });
    $(".auto_fade").fadeTo(5000, 500).slideUp(500, function () {
        $(".auto_fade").slideUp(500);
    });
    
</script>
<script type="text/javascript" src="<?php echo e(asset('assets/common/js/user-validate.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/common/js/common.js')); ?>"></script>
<!-- Modal Template Starts -->
<div class="modal fade" id="myModalVerifiyUser" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="redirectCancel" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirmation</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="redirect-csrf-roken" value="<?php echo e(csrf_token()); ?>">
        <p id="displayRedirectMsg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="redirectCancel">Close</button>
        <button type="button" class="btn btn-primary" id="redirectContinue">Continue</button>
      </div>
    </div>
    
  </div>
</div>
<!-- Modal content End-->

<!-- Modal for redirect to registration page Starts here -->
<div class="modal fade" id="myModalUserRedirect" role="dialog">
  <div class="modal-dialog modal-sm">
  
    <!-- Modal content-->
    <div class="modal-content">
      <!-- Modal content Head -->
      <div class="modal-header">
        <button type="button" class="close redirectClose1" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Role Redirection</h4>
      </div>

      <!-- Modal content Body -->
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="form-group">
              <label class="radio-inline">
                <input type="radio" name="register" value="Physician">Physician
              </label>
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <label class="radio-inline">
                <input type="radio" name="register" value="Staff">Administrative Staff
              </label>
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <label class="radio-inline">
                <input type="radio" name="register" value="Patient">Patient
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal content Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default redirectClose1">Close</button>
        <button type="button" class="btn btn-primary" id="redirectRegistrationPage">Continue</button>
      </div>

    </div>
  </div>
</div>
<!-- Modal content End-->

<script>
/* <![CDATA[ */
  var params = {
    "site_url_path": "<?php echo e(URL::to('/')); ?>"
  };
</script>
</html>