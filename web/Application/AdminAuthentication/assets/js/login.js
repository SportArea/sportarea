$(document).ready(function () {
    Login.initValidation();

    $('button[type="submit"]').on('click', function (event) {
        if (!$('#login-form').valid()) {
            return false;
        }
        $('#login-form').submit();
    });

});

var Login = (function () {

    return {
        initValidation: function () {

            $("#login-form").validate({
                errorPlacement: function (error, element) {

                    $(element).closest('.form-group').addClass('has-error');
                    if (element.is('input')) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
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
