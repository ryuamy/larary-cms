"use strict";
var KTDatatableHtmlTableDemo = function () {
    var demo = function () {
        $('#kt_datatable').KTDatatable({
            sortable: true,
            pagination: true,
            columns: [{
                field: 'Action',
                title: 'Action',
                width: 60,
            }, {
                field: 'Action Detail',
                title: 'Action Detail',
            }, {
                field: 'IP Address',
                title: 'IP Address',
                width: 90,
            }, {
                field: 'Date',
                title: 'Date',
                width: 125,
            }],
        });
    };
    return {
        init: function () {
            demo();
        },
    };
}();
jQuery(document).ready(function () {
    KTDatatableHtmlTableDemo.init();
});
