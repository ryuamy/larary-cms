(function ($) {
    'use strict';

    var summernoteGlobalEditor = function () {
        // Private functions
        var demos = function () {
            $('.summernote').summernote({
                height: 400,
                tabsize: 2
            });
        }

        return {
            // public functions
            init: function () {
                demos();
            }
        };
    }();

    summernoteGlobalEditor.init();
})(jQuery);
