	/**
	 *------------------------------ To handle Physician Test Preview Starts ------------------------------
	 */ 
	$(document).on('click', '#sendDataValue', function() {
        var f          = 1;
        var age        = $('#testPreviewAge').val();
        var gender     = $('#testPreviewGender').val();
        var questionId = $('#questionId').val();
        var _token     = $("input[name=_token]").val();
        var error      =  msg =   errors      =  msgs = '';
        if (age == '') {
           msg   = 'Please fill the age field';
           error += '<div class="alert alert-danger">\
                      <strong>Error : </strong> ' + msg + '.\
                    </div>';
           $('#errAge').html(error);
           f = 0;
        }
        if (gender === '' ) {
           msgs   = 'Please select gender!';
           errors += '<div class="alert alert-danger">\
                      <strong>Error : </strong> ' + msgs + '.\
                    </div>';
           $('#errGender').html(errors);
           f     = 0;
        }
 
        if (f != 0) {
           $.ajax({
               url: params.site_url_path + '/physician/question-set-preview-detail',
               type: 'POST',
               data: { age : age, gender : gender, questionId : questionId, _token : _token },
               success: function(response) {
                 $('.testPreviewModal').modal('hide');
                 window.location.href = params.site_url_path + '/physician/question-set-test-preview-detail/' + questionId + '/show';
              }            
           });
        }
 
     });
 
     // Allow only Numbers
      $("#testPreviewAge").on("keypress keyup blur",function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
     });
 
     $(document).on('change', '#testPreviewAge, #testPreviewGender', function() {
        var age        = $('#testPreviewAge').val();
        var gender     = $('#testPreviewGender').val();
        if (age != '') {
           $('#errAge').hide();
        }
        if (gender != '' ) {
           $('#errGender').hide();
        }
     });
 
     $(document).on('click', '.testPreviewModal', function() {
        $('#testPreviewAge').val('');
        $('#testPreviewGender').val('');
        var question_id = $(this).data('question_set_id');
        $('#questionId').val(question_id);
     });
 
     /**
      *------------------------------ To handle Physician Test Preview Ends ------------------------------
      *
      */ 