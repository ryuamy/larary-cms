(function ($) {
    'use strict';

    $('#btn-filter').on('click', function (e) {
        let wrap_filter = $('#filter');
        if (wrap_filter.hasClass('d-none')) {
            $(this).addClass('btn-light-success').removeClass('btn-success');
            wrap_filter.removeClass('d-none').addClass('d-flex');
        } else {
            $(this).removeClass('btn-light-success').addClass('btn-success');
            wrap_filter.addClass('d-none').removeClass('d-flex');
        }
    });
})(jQuery);
