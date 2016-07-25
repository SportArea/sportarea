$(document).ready(function () {
    SportTypeAddEdit.initValidation();

    $('.save-sport-type').on('click', function () {
        var $add_edit_sport_type = $('#add_edit_sport_type');
        if (!$add_edit_sport_type.valid()) {
            return false;
        }
        $add_edit_sport_type.submit();
    });

});

var SportTypeAddEdit = (function () {
    return {
        initValidation: function () {
            $("#add_edit_sport_type").validate({
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
