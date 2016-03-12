$(document).ready(function() {
    Users.initTable();

    $('.reset').on('click', function() {
        UsersFilter.reset();
    });

    $('#apply_filter').on('click', function() {
        $('#filter_users').submit(false);
        Users.reloadTable();
    });

    $('#reset_filter').on('click', function() {
        UsersFilter.reset();
    });

    //show/hide invoice filter
    $('.filter-submit').on('click', function() {
        $('#search').toggle(300);
    });

    $('.edit').live('click', function() {
        window.location = BASE_URL + '/users/edit/' + $(this).closest('tr').data('id');
    });

    $('.delete').live('click', function() {
        var userId = $(this).closest('tr').data('id');
        ModalHelper.confirmDelete('Șterge utilizator', 'Sunteţi sigur că doriţi sa ştergeţi utilizatorul selectat ?', Users.deleteUser, userId);
    });
});

var Users = (function() {

    return {
        table: null,

        initTable : function() {
            this.table = AppTable.init("users", {
                "aoColumns" : [
                    {
                        "sDefaultContent" : '',
                        "sWidth": "50px"
                    },
                    {
                        "mData" : "name",
                        "sName" : "users.first_name",
                        "bSortable": true
                    },
                    {
                        "mData" : "email",
                        "sName" : "users.email",
                        "bSortable": false
                    }
                ],
                "bFilter": false,
                "sAjaxSource" : BASE_URL + '/users/list_users',
                "aaSorting": [[1, 'ASC']],
                "fnServerParams": function (aoData) {
                    aoData.push({
                        "name": "search", //to be changed if we filter
                        "value": UsersFilter.getFilterParams() //to be change if we filter
                    });
                },
                "createdRow": function(row, data) {
                    $('td:eq(0)', row).html(Users.getActions(data));
                }
            });
        },

        getActions: function(data) {
            var actionHtml ='<span>' +
                '<a href="#" class="edit tooltips" data-placement="top" data-html="true" data-original-title="Modifică">' +
                '<i class="fa fa-pencil"></i>' +
                '</a>' +
                '</span>&nbsp;&nbsp;' +
                '<span>' +
                '<a href="#" class="delete tooltips red" data-placement="top" data-html="true" data-original-title="Șterge">' +
                '<i class="fa fa-trash-o"></i>' +
                '</a>' +
                '</span>';

            return actionHtml;
        },

        initValidation : function() {
            jQuery.validator.setDefaults({
                debug: true,
                success: "valid"
            });
            $("#change_contact_status").validate({
                errorPlacement : function(error, element) {
                    $(element).closest('.form-group').addClass('has-error');
                    error.insertAfter(element);
                },
                errorElement : "span",
                errorClass : "help-inline",
                success: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                }
            });
        },

        reloadTable: function() {
            if (Users.table == null) {
                return false;
            }

            Users.table.fnDraw();
        },

        /**
         * Delete user by id
         * @param userId
         */
        deleteUser: function(userId)
        {

            $.ajax({
                type: "POST",
                url: BASE_URL + '/users/delete',
                dataType: 'json',
                data: {
                    user_id: userId
                },
                success: function (response) {
                    if (response.status == 0) {
                        ModalHelper.alert(response.message);
                    }
                }
            });

            Users.table.fnDraw();
        }
    };

}());

var UsersFilter = (function() {
    return {
        reset: function() {
            $('form#filter_users input[type="text"]').val('');
        },

        getFilterParams: function() {
            return $('#filter_users').serialize();
        }
    };
}());
