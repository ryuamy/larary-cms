(function ($) {
    'use strict';

    $('.modules_rules').on('click', function (e) {
        var modules_key = $(this).data('key');
        if (
            $('.modules_'+modules_key+'_read').is(':checked') ||
            $('.modules_'+modules_key+'_add').is(':checked') ||
            $('.modules_'+modules_key+'_edit').is(':checked') ||
            $('.modules_'+modules_key+'_delete').is(':checked')
        ) {
            $('#modules_'+modules_key).prop('checked', true);
            $('#modules_'+modules_key+'_id').prop('checked', true);
        } else {
            $('#modules_'+modules_key).prop('checked', false);
            $('#modules_'+modules_key+'_id').prop('checked', false);
        }
    });

    $('.modules_rules_read').on('click', function (e) {
        var modules_key = $(this).data('key');
        if ( this.checked ) {
            $('.label_modules_'+modules_key+'_add').removeClass('checkbox-disabled');
            $('.modules_'+modules_key+'_add').prop('disabled', false);

            $('.label_modules_'+modules_key+'_edit').removeClass('checkbox-disabled');
            $('.modules_'+modules_key+'_edit').prop('disabled', false);

            $('.label_modules_'+modules_key+'_delete').removeClass('checkbox-disabled');
            $('.modules_'+modules_key+'_delete').prop('disabled', false);
        } else {
            $('.label_modules_'+modules_key+'_add').addClass('checkbox-disabled');
            $('.modules_'+modules_key+'_add').prop('disabled', true).prop('checked', false);

            $('.label_modules_'+modules_key+'_edit').addClass('checkbox-disabled');
            $('.modules_'+modules_key+'_edit').prop('disabled', true).prop('checked', false);

            $('.label_modules_'+modules_key+'_delete').addClass('checkbox-disabled');
            $('.modules_'+modules_key+'_delete').prop('disabled', true).prop('checked', false);
        }
    });
})(jQuery);
