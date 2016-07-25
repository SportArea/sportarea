$(document).ready(function() {
    SportType.initTable();

    $('.reset').on('click', function() {
        SportTypeFilter.reset();
    });

    $('#apply_filter').on('click', function() {
        $('#filter_sport_type').submit(false);
        SportType.reloadTable();
    });

    $('#reset_filter').on('click', function() {
        SportTypeFilter.reset();
        SportType.reloadTable();
    });

    $('.filter-submit').on('click', function() {
        $('#search').toggle(300);
    });

    $('.edit').live('click', function() {
        window.location = BASE_URL + '/sport_type/edit/' + $(this).closest('tr').data('id');
    });

    $('.delete').live('click', function() {
        var sportTypeId = $(this).closest('tr').data('id');
        ModalHelper.confirmDelete('Sterge tipul de sport', 'Sunteti sigur ca doriti sa stergeti sportul selectata ?', SportType.delete, sportTypeId);
    });
});

var SportType = (function() {

    return {
        table: null,

        initTable : function() {
            this.table = AppTable.init("sport_type", {
                "aoColumns" : [
                    {
                        "sDefaultContent" : '',
                        "sWidth": "50px"
                    },
                    {
                        "mData" : "name",
                        "sName" : "name",
                        "bSortable": true
                    },
                    {
                        "mData" : "status",
                        "sName" : "status",
                        "bSortable": false
                    }
                ],
                "bFilter": false,
                "sAjaxSource" : BASE_URL + '/sport_type/list_sport_type',
                "aaSorting": [[1, 'ASC']],
                "fnServerParams": function (aoData) {
                    aoData.push({
                        "name": "search", //to be changed if we filter
                        "value": SportTypeFilter.getFilterParams() //to be change if we filter
                    });
                },
                "createdRow": function(row, data) {
                    $('td:eq(0)', row).html(SportType.getActions(data));
                }
            });
        },

        getActions: function(data) {
            return '<span>' +
                '<a href="#" class="edit tooltips" data-placement="top" data-html="true" data-original-title="Modificã">' +
                '<i class="fa fa-pencil"></i>' +
                '</a>' +
                '</span>&nbsp;&nbsp;' +
                '<span>' +
                '<a href="#" class="delete tooltips red" data-placement="top" data-html="true" data-original-title="Sterge">' +
                '<i class="fa fa-trash-o"></i>' +
                '</a>' +
                '</span>';
        },

        reloadTable: function() {
            if (SportType.table == null) {
                return false;
            }

            SportType.table.fnDraw();
        },

        delete: function(sportTypeId)
        {

            $.ajax({
                type: "POST",
                url: BASE_URL + '/sport_type/delete',
                dataType: 'json',
                data: {
                    sport_type_id: sportTypeId
                },
                success: function (response) {
                    if (response.status == 0) {
                        ModalHelper.alert(response.message);
                    }
                }
            });

            SportType.table.fnDraw();
        }
    };

}());

var SportTypeFilter = (function() {
    return {
        reset: function() {
            $('form#filter_sport_type input[type="text"]').val('');
        },

        getFilterParams: function() {
            return $('#filter_sport_type').serialize();
        }
    };
}());
