var ModalHelper = function() {
    return {
        confirmDelete: function(title, confirmMessage, callback, id) {
            bootbox.dialog({
                message: confirmMessage,
                title: title,
                buttons: {
                    success: {
                        label: '<i class="fa fa-trash"></i> ȘTERGE',
                        className: "btn green-meadow",
                        callback: function() {
                            callback(id);
                        }
                    },
                    donothing: {
                        label: '<i class="fa fa-times"></i> RENUNȚĂ',
                        className: "btn grey-cascade"
                    }
                }
            });
        },
        confirm: function(title, confirmMessage, callback, id) {
            bootbox.dialog({
                message: confirmMessage,
                title: title,
                buttons: {
                    success: {
                        label: '<i class="fa fa-trash"></i> CONFIRMA',
                        className: "btn green-meadow",
                        callback: function() {
                            callback(id);
                        }
                    },
                    donothing: {
                        label: '<i class="fa fa-times"></i> RENUNȚĂ',
                        className: "btn grey-cascade"
                    }
                }
            });
        },
        alert: function(message) {
            bootbox.alert(message);
        }
    };
}();

var DateHelper = function () {
    var dt = new Date();
    var d = dt.getDate();
    var m = dt.getMonth() + 1;
    var Y = dt.getFullYear();

    if (d < 10) {
        d = '0' + d;
    }

    if (m < 10) {
        m = '0' + m;
    }

    return {
        startDate: function() {
            var date = Y + '-' + m + '-' + '01';

            return date;
        },

        currentDate: function() {
            var date = Y + '-' + m + '-' + d;

            return date;
        }
    };
}();