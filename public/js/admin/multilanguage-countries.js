"use strict";
var KTDatatableHtmlTableDemo = function () {
    var demo = function () {
        $('#multilanguage_countries').KTDatatable({
            sortable: true,
            pagination: true,
            columns: [{
                field: 'Name',
                title: 'Name',
                width: 125,
            }, {
                field: 'ISO Alpha 2 Code',
                title: 'ISO Alpha 2 Code',
                width: 100,
            }, {
                field: 'ISO Alpha 3 Code',
                title: 'ISO Alpha 3 Code',
                width: 100,
            }, {
                field: 'Enable/Disable',
                title: 'Enable/Disable',
                width: 75,
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
