(function ($) {
    'use strict';

    $('#edit_permalink_slug').on('click', function (e) {
        let field_permalink_slug = $('#field_permalink_slug');
        let permalink_slug = $('#permalink_slug');
        if (field_permalink_slug.hasClass('d-none')) {
            $(this).html('cancel');
            field_permalink_slug.removeClass('d-none').addClass('d-inline-block');
            permalink_slug.addClass('d-none').removeClass('d-inline-block');
        } else {
            $(this).html('edit');
            field_permalink_slug.addClass('d-none').removeClass('d-inline-block');
            permalink_slug.removeClass('d-none').addClass('d-inline-block');
        }
    });
})(jQuery);
