/**
 * ------------------------------------------------
 * Redirect the URL based on the USER Selction
 * ------------------------------------------------
 */
$(document).ready(function() {
    $('#redirectRegistrationPage').attr('disabled', 'disabled');
    $('#redirectRegistrationPage').on('click', function(){
        var url;
        var selected      = $("input[name='register']:checked").val();
        if (selected) {
            switch (selected) {
                case 'Physician':
                        url = '/physician/register';
                        break;
                    case 'Staff':
                        url = '/administrator-staff/register';
                        break;
                    case 'Patient':
                        url = '/patient/register';
                    break;
                default:
                    break;
            }
            window.location.href = params.site_url_path + url;
        }
    });

    // Enable the button after the User selects the Redirect option
    $('input[type=radio][name=register]').on('change', function() {
        if ($('#redirectRegistrationPage').is(':disabled')) {
            $('#redirectRegistrationPage').removeAttr('disabled');
        }
    });

    // Clear the registration input field when clicked cancel button
    $('.redirectClose1').on('click', function() {
        $('input[name="register"]').prop('checked', false);
        $('#myModalUserRedirect').modal('hide');
    });

    /**
     *  To update the terms & condition Status to the perticular User
     *  @param $user_id
     *  @return json_array
     */
    $('#acceptAgreement').on('click', function() {
        var userRole         = $('#userRoleAgreement').val();   
        var termsAgreement   = $('#termsAgreement').val();
        var userId           = $('#userIdAgree').val();   
        console.log(userId);
        if (userRole==='D' || userRole==='S') {
        url = '/physician/changeStatus';
        } else {
        url = '/patient/changeStatus';
        }
        $.ajax({
        type: "POST", 
        url: params.site_url_path + url,
        data: {'_token': $('input[name=_token]').val(), 'user_role': userRole, agree: termsAgreement, userId : userId},
        success: function (response) {
            if (response) {
                location.reload();
            }
        }
        });
    });
    
    // To disable the Agree button before accept and check the Checkbox
    $('#acceptAgreement').attr('disabled', 'disabled');
    
    /**
     *  Based on the user selection will do the Agreement Operation
     */
    $('#termsAgreement').click(function() {
        if ($(this).is(":checked")) {
        $('#acceptAgreement').attr('disabled', false);      
        } else if ($(this).is(":not(:checked)")) {
        $('#acceptAgreement').attr('disabled', 'disabled'); 
        }
    });
 
});