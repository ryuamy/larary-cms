(function ($) {
    'use strict';

    $('.select2').select2({
        placeholder: 'Please select',
        allowClear: true
    });

    $('.select2_infinity').select2({
        placeholder: 'Please select',
        minimumResultsForSearch: Infinity
    });

    // // nested
    // $('#kt_select2_2, #kt_select2_2_validate').select2({
    //     placeholder: 'Select a state'
    // });

    // // multi select
    // $('#kt_select2_3, #kt_select2_3_validate').select2({
    //     placeholder: 'Select a state',
    // });

    // // basic
    // $('#kt_select2_4').select2({
    //     placeholder: 'Select a state',
    //     allowClear: true
    // });
})(jQuery);
