"use strict";

var KTDatatableLog = function () {
    var adminLog = function () {
        var uuidAdmin = $('#kt_datatable').data('uuid');

        $('#kt_datatable').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: baseUrl + 'ajax/detail-admin-log/' + uuidAdmin,
                        // sample custom headers
                        // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        map: function (raw) {
                            var dataSet = raw;
                            // console.log(dataSet);
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },
            layout: {
                scroll: false,
                footer: false,
            },
            sortable: true,
            pagination: true,
            columns: [{
                field: 'action',
                title: 'Action',
                width: 60,
            }, {
                field: 'actionDetail',
                title: 'Action Detail',
            }, {
                field: 'ipAddress',
                title: 'IP Address',
                width: 90,
            }, {
                field: 'date',
                title: 'Date',
                type: 'date',
                format: 'DD/MM/YYYY',
                sortable: 'asc',
                width: 135,
            }],
        });
    };

    return {
        init: function () {
            adminLog();
        },
    };
}();

jQuery(document).ready(function () {
    console.log(baseUrl);
    KTDatatableLog.init();
});
