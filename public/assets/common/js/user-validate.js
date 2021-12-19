/**
 * ------------------------------------------------
 *
 * Registation based on their EmailID (User Role's)
 * 
 * ------------------------------------------------
 */
$("#emailId").on('change', function() {
    var emailId     = $(this).val();
    var _token      = $("input[name='_token']").val();
    var userRole    = $('span.user_role').data('user_role');
    var data        = { emailId : emailId, role : userRole, _token : _token };
    var text, r, formRole, question;
    $(".error").remove(); //remove all error span elements
    $(".text-success").remove(); //remove all error span elements



    $.ajax({
        type: "POST",
        url: params.site_url_path + '/userexist',
        data: data,
        success: function (response) {
            if (response) {
                r            = $.parseJSON(response);

                // Check the user roles
                if ($.isArray(r.existRole)) {
                    userRole = r.existRole[0];
                } else {
                    userRole = r.existRole;
                }

                // Exist Validation
                $(".emailcheck.mrgn-btm-25").css('margin-bottom', '25px');
                if (r != '') {
                    if (r.formRole == r.roleType) {
                        $(".emailcheck").after('<div class="error" style="margin-top: -20px; margin-bottom: 20px;">This EmailID already registered as '+ r.roleType +'!</div>');
                        $(".emailcheck.mrgn-btm-25").css('margin-bottom', '20px');
                        $('.emailcheck').focus();
                        return false;
                    } else if (r.roleType === 'Physician & Patient') {
                        $(".emailcheck").after('<div class="error" style="margin-top: -20px; margin-bottom: 20px;">This EmailID already registered as '+ r.roleType +'!</div>');
                        $(".emailcheck .mrgn-btm-25").css('margin-bottom', '20px');
                        $('.emailcheck').focus();
                        return false;
                    } else if ((r.roleType=='Physician') && (r.formRole=='AdminStaff')) {
                        $(".emailcheck").after("<div class='error' style='margin-top: -20px; margin-bottom: 20px;'>This EmailID already registered as "+ r.roleType +". Can't create as a "+ r.formRole +"!</div>");
                        $(".emailcheck.mrgn-btm-25").css('margin-bottom', '20px');
                        $('.emailcheck').focus();
                        return false;
                    } else if ((r.formRole=='Physician') && (r.roleType=='AdminStaff')) {
                        $(".emailcheck").after("<div class='error' style='margin-top: -20px; margin-bottom: 20px;'>This EmailID already registered as "+ r.roleType +". Can't create as a "+ r.formRole +"!</div>");
                        $(".emailcheck.mrgn-btm-25").css('margin-bottom', '20px');
                        $('.emailcheck').focus();
                        return false;
                    } else { 
                        // Role based do the action
                        switch (userRole) {
                            case 'user-doctor-exist':
                                question = msg(r);
                                promptAction(r, emailId, question);
                                break;
                            case 'user-admin-exist':
                                question = msg(r);
                                promptAction(r, emailId, question);
                                break;
                            case 'user-patient-exist':
                                question = msg(r);
                                promptAction(r, emailId, question);
                                break;
                            case 'user-staff-exist':
                                question = msg(r);
                                promptAction(r, emailId, question);
                                break;
                            case 'admin-exist':
                                question = msg(r);
                                promptAction(r, emailId, question);
                                break;
                            case 'patient-exist':
                                question = msg(r);
                                promptAction(r, emailId, question);
                                break;
                            default: 
                                return true;
                        }
                    }
                } else {
                    $(".emailcheck").after("<div  id='emailcheck' class='text-success' style='margin-top: -20px; margin-bottom: 20px;'>This EmailID is available!</div>");
                    return true;
                }   
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
});

/**
 * To trigger common message
 */
function msg(r)
{
    question = 'This EmailID already register as a ' + r.roleType + '. Also would you like to register as a ' + r.formRole + '?';
    return question;
}
/**
 * To trigger the Prompt functionality
 */
function promptAction(r, emailId, question) {
    
    $('#displayRedirectMsg').text(question);
    // Trigger the Modal to show
    $('#myModalVerifiyUser').modal({backdrop: 'static', keyboard: false});
    $('#myModalVerifiyUser').modal('show');
    
    // Pass the inputs to the form when the user click on continue button
    $('#redirectContinue').click(function() {
        var csrf_token = $('#redirect-csrf-roken').val();
        $.ajax({
            url : params.site_url_path + '/loginRedirectUser',
            method : 'POST',
            data : {data:r, _token : csrf_token, email: emailId},
            success: function(response) {
                if (response === 'saved') {
                    window.location.href = params.site_url_path + '/register-login';
                }
            }
        });
    });
    
    // Clear the Email input field when clicked on Cancel Button
    $('#redirectCancel').click(function() {
        $('#emailId').val('');
    });
}