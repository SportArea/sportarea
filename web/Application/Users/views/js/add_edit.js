$(document).ready(function() {
    UsersAddEdit.initValidation();

    $('.save-user').on('click', function(event) {
        if (!$('#add_edit_user').valid()) {
            return false;
        }
        $('#add_edit_user').submit();
    });

});

var UsersAddEdit = (function() {

    return {

        initValidation : function() {

            $("#add_edit_user").validate({
                errorPlacement : function(error, element) {

                    $(element).closest('.form-group').addClass('has-error');
                    error.insertAfter(element);
                },
                errorElement : "span",
                errorClass : "help-inline",
                success: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                    $(element).closest('.help-inline').remove();
                },
                onsubmit: false
            });
        }
    };
}());
