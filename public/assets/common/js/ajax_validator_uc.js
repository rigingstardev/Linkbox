$(document).ready(function () {
    // Prepare reset.
    function resetModalFormErrors() {
        $('.form-group').removeClass('has-error');
        $('.errors').find('.error').remove();
        $('.alert').hide();
    }

    // Intercept submit.
    $(document).on('submit', 'form.bootstrap-modal-form', function (submission) {
        submitHandler(submission, this);
    });
    $("#myModal2").on("hidden.bs.modal", function () {
        $('#myModal2').find('form')[0].reset();
        resetModalFormErrors();
    });
    $('#category_submit_bttn').on('click', function (submission) {
        $('form.bootstrap-modal-form').submit();
    });

    var submitHandler = function (submission, thisVar) {

        submission.preventDefault();
//      alert('test');
        // Set vars.
        var form = $(thisVar),
                url = form.attr('action'),
                submit = form.find('[type=submit]');
        // Check for file inputs.
        if (form.find('[type=file]').length) {
            // If found, prepare submission via FormData object.
            var input = form.serializeArray(),
                    data = new FormData(),
                    contentType = false;
            // Append input to FormData object.
            $.each(input, function (index, input) {
                data.append(input.name, input.value);
            });

            // Append files to FormData object.
            $.each(form.find('[type=file]'), function (index, input) {
                if (input.files.length == 1) {
                    data.append(input.name, input.files[0]);
                } else if (input.files.length > 1) {
                    data.append(input.name, input.files);
                }
            });
        }
        // If no file input found, do not use FormData object (better browser compatibility).
        else {
            var data = form.serialize(),
                    contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
        }
        // Please wait.
        if (submit.is('button')) {
            var submitOriginal = submit.html();
            submit.html('Please wait...').attr('disabled', true);
        } else if (submit.is('input')) {
            var submitOriginal = submit.val();
            submit.val('Please wait...').attr('disabled', true);
        }
        // Request.
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            cache: false,
            contentType: contentType,
            processData: false
                    // Response.
        }).always(function (response, status) {
            // Reset errors.
            resetModalFormErrors();
            // Check for errors.
            if (response != null && response.status == 422) {
                var errors = $.parseJSON(response.responseText);
                // Iterate through errors object.
                var j = 0;
                $.each(errors, function (field, message) {
                    // var formGroup = $('[name='+field+']', form).closest('.form-group');
                    // formGroup.addClass('has-error').append('<p class="help-block">'+message+'</p>');
                    if (field == 'country_code' || field == 'contact_number') {
                        $('.custom_error').html(message);
                        /* var formGroup = $('[name=' + field + ']', form);
                         formGroup.wrap("<div class='errors'></div>");
                         formGroup.parent('.errors').append('<div class="error">' + message + '</div>');*/
                    } else if (field == 'patient_smoke' || field == 'patient_drink' || field == 'patient_drug' || field == 'surgery_date') {
                        showCustomError(field, message);
                    } else {
                        var formGroup = $('[name=' + field + ']', form);
                        formGroup.wrap("<div class='errors'></div>");
                        formGroup.removeClass('mrgn-btm-20');
                        formGroup.removeClass('mrgn-btm-25');
                        formGroup.parent('.errors').append('<div class="error">' + message + '</div>').addClass('mrgn-btm-20');
                        j = parseInt(j) + 1;
                        if (j == 1)
                            formGroup.focus();
                    }
                });
                // Reset submit.
                if (submit.is('button')) {
                    submit.html(submitOriginal).attr('disabled', false);
                } else if (submit.is('input')) {
                    submit.val(submitOriginal).attr('disabled', false);
                }
                // If successful, reload.
            } else if (response != null && response.status == 401) {
                $('.modal-header').after('<div class="alert alert-danger">' + response.message + '</div>');
                if (submit.is('button')) {
                    submit.html(submitOriginal).attr('disabled', false);
                } else if (submit.is('input')) {
                    submit.val(submitOriginal).attr('disabled', false);
                }
            } else if (response != null && response.action == 'reloadDatatable') {
                reloadDatatable(response.table);
            } else {
                if (submit.is('button')) {
                    if ($('#modalPopUpBtnSendQS').length > 0) {
                        $('#modalPopUpBtnSendQS').modal('hide');
                    } else
                        submit.html(submitOriginal).attr('disabled', false);
                } else if (submit.is('input')) {
                    submit.val(submitOriginal).attr('disabled', false);
                }
                resetModalFormErrors();
                location.reload();
            }
        });
    }
});

function showCustomError(field, message) {
    var msg = 'Specify an option';
    if (field == 'surgery_date') {
        msg = message;
    }
    $(".error_" + field).html(msg).css('margin-top', '6px');
}

function reloadDatatable(table) {
    if (table == 'surgical_history') {
        listingTables(surgical_history);
        $('#surgicalHistoryModal').modal('toggle');
    }
    if (table == 'past_medical_history') {
        listingTables(med_history);
        $('#medHistoryModal').modal('toggle');
    }
    if (table == 'family_history') {
        listingTables(family_history);
        $('#familyHistoryModal').modal('toggle');
    }
    if (table == 'allergies') {
        listingTables(allergy);
        $('#allergyModal').modal('toggle');
    }
    if (table == 'medications') {
        listingTables(medications);
        $('#medicationsModal').modal('toggle');
    }
}

function changeOptions(val, rid) {

    $("#2_basic_" + rid + " > option").each(function () {
        var str = this.value;
        if (str != "") {
            if (val == 1) {
                $(this).text(str = str.substring(0, str.length - 1));
            } else
                $(this).text(str);
        }
    });
    $('#2_basic_' + rid).selectpicker('refresh');
}