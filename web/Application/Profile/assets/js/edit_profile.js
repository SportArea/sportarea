$(document).ready(function () {
    ProfileInfoEdit.initValidation();
    ProfilePassEdit.initPassValidation();

    $('.save-profile').on('click', function (event) {
        if (!$('#edit_profile_info').valid()) {
            return false;
        }

        $('#edit_profile_info').submit();
    });

    $('.save-change-password').on('click', function (event) {
        ProfilePassEdit.initPassValidation();

        if (!$('#edit_profile_pass').valid()) {
            return false;
        }
        ProfilePassEdit.changePassword();
    });
});

var ProfileInfoEdit = (function () {

    return {
        initValidation: function () {

            $("#edit_profile_pass").validate({
                errorPlacement: function (error, element) {

                    $(element).closest('.form-group').addClass('has-error');
                    error.insertAfter(element);
                },
                errorElement: "span",
                errorClass: "help-inline",
                success: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                    $(element).closest('.help-inline').remove();
                },
                onsubmit: false
            });
        }
    };
}());

var ProfilePassEdit = (function () {

    return {
        initPassValidation: function () {

            $('form[name="change_password"]').validate({
                errorPlacement: function (error, element) {
                    $(element).closest('.form-group').addClass('has-error');
                    error.insertAfter(element);
                },
                errorElement: "span",
                errorClass: "help-inline",
                success: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                    $(element).closest('.help-inline').remove();
                },
                onsubmit: false
            });
        },
        changePassword: function () {
            ProfilePassEdit.resetPageError();
            ProfilePassEdit.resetPageSuccess();

            var oldPassword = $('#oldPassword').val();
            var newPassword = $('#newPassword').val();
            var confirmPassword = $('#confirmPassword').val();

            if (newPassword !== confirmPassword) {
                ProfilePassEdit.setPageError('Parolele nu se potrivesc.');
                return false;
            }

            $.ajax({
                type: "POST",
                url: BASE_URL + "/profile/change_password",
                dataType: "json",
                data: {
                    old_password: oldPassword,
                    new_password: newPassword,
                    confirm_password: confirmPassword

                },
                beforeSend: function () {
                    Metronic.blockUI({message: "Se salveaza datele. Va rugam sa asteptati..."});
                },
                success: function (response) {
                    if (response.status == 1) {
                        ProfilePassEdit.setPageSuccess('Modificarile au fost salvate cu succes.');
                        ProfilePassEdit.resetPasswordFields();
                        window.location.href = BASE_URL + "/profile/index";
                    } else {
                        ProfilePassEdit.setPageError(response.message);
                    }
                },
                complete: function () {
                    Metronic.unblockUI();
                }
            });
        },
        resetPasswordFields: function () {
            $('#oldPassword').val('');
            $('#newPassword').val('');
            $('#confirmPassword').val('');
        },
        setPageSuccess: function (success) {
            var alertDiv =
                    '<div class="alert alert-success alert-dismissable">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>' +
                    '<strong>Succes!</strong> <span class="alert-msg">' + success + '</span>' +
                    '</div>';

            $(alertDiv).insertAfter('.page-bar');
        },
        resetPageSuccess: function () {
            $('.alert').remove();
        },
        setPageError: function (error) {
            var alertDiv =
                    '<div class="alert alert-danger alert-dismissable page-error">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>' +
                    '<strong>Eroare!</strong> <span class="alert-msg">' + error + '</span>' +
                    '</div>';

            $(alertDiv).insertAfter('.page-bar');
        },
        resetPageError: function () {
            $(".alert").remove();
        }
    };
}());
