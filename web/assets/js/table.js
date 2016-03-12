var AppTable = function() {
    return {
        init: function(tableName, params) {
            var settings = AppTable.prepareData(params);
            var oTable = $('#' + tableName).dataTable(settings);

            AppTable.applyCustomSettings(oTable, tableName);

            return oTable;
        },
        prepareData: function(params) {
            var defaultSettings = {
                "aoColumnDefs": [
                    {
                        "bSortable": false,
                        "bSearchable": false,
                        "aTargets": [ 0 ]
                    }
                ],
                "aaSorting": [[1, 'ASC']],
                "aLengthMenu": [
                    [5, 10, 20, 50, 100],
                    [5, 10, 20, 50, 100]
                ],
                "iDisplayLength": 10,
                "bProcessing": true,
            	"bServerSide": true,
                "bFilter": false,
                "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                    nRow.setAttribute('data-id', aData.id);
                },
                "fnDrawCallback": function(oSettings) {
                    //initTableTooltips();
                },
                "fnServerData": function(sSource, aoData, fnCallback) {
                    $.ajax({
                        "dataType": "json",
                        "type": "POST",
                        "url": sSource,
                        "data": aoData,
                        "success": fnCallback,
                        "beforeSend": function() {
                           // AppTable.blockUI(".portlet:not(.filtrare)");
                        },
                        "complete": function() {
                            //$('#dataTables_processing').hide();
                            //AppTable.unblockUI(".portlet:not(.filtrare)");
                        },
                        "error": function() {
                            //AppTable.unblockUI(".portlet:not(.filtrare)");
                        }
                    });
                },
                "oLanguage": {
                    "sLengthMenu": "Afiseaza _MENU_ randuri pe pagina",
                    "sZeroRecords": "Nici un rezultat gasit",
                    "sInfo": "Se afiseaza: _START_ - _END_ din _TOTAL_ rezultate",
                    "sInfoEmpty": "Se afiseaza: 0 - 0 din 0 randuri",
                    "sInfoFiltered": "(filtrat dintr-un total de _MAX_ rezultate)",
                    "sSearch": "Filtrare:",
                    "sProcessing": "Se incarca...",
                    "sLoadingRecords": "Se incarca...",
                    "oPaginate": {
                        "sPrevious": "Pagina anterioara",
                        "sNext": "Pagina urmatoare",
                        "sFirst": "Prima pagina",
                        "sLast": "Ultima pagina"
                    }
                }
            };
            return $.extend(defaultSettings, params);
        },
        applyCustomSettings: function(oTable, tableName) {
            jQuery('#' + tableName + '_wrapper .dataTables_paginate').addClass('pull-right'); // pull pagination to the right
            //jQuery('#' + tableName + '_wrapper .table-scrollable').removeClass('table-scrollable'); // pull pagination to the right

            $('#' + tableName + '_column_toggler input[type="checkbox"]').change(function(){
                /* Get the DataTables object again - this is not a recreation, just a get of the object */
                $(this).is(":checked") ? $(this).parent('span').addClass("checked") : $(this).parent('span').removeClass("checked");

                var iCol = parseInt($(this).attr("data-column"));
                var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
                oTable.fnSetColumnVis(iCol, (bVis ? false : true));
            });

            return oTable;
        },
        blockUI: function (el) {
            $(el).block({
                centerY: true,
                css: {
                    top: '10%',
                    border: 'none',
                    padding: '2px',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: '#000',
                    opacity: 0.05,
                    cursor: 'wait'
                }
            });
        },
        unblockUI: function (el) {
            $(el).unblock({
                onUnblock: function () {
                    $(el).removeAttr("style");
                }
            });
        }
    };
}();