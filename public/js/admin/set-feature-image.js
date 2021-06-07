function preview_image(event, id) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(id);
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
    $('#' + id).parent().show();
}

function delete_feature_image(image_slug) {
    var baseUrl = $('body').data('baseurl');
}

function reset_feature_image(image_slug) {
    var baseUrl = $('body').data('baseurl');
    var newBaseUrl = baseUrl.replace('/myadmin', '/');
    $('#preview_feature_img').attr('src', newBaseUrl + image_slug);
}

(function ($) {
    'use strict';

    var baseUrl = $('body').data('baseurl');

    $('#set_feature_image').click(function(){
        // alert('boo!');
        $('#upload_feature_image').trigger('click');
    })

    $('#delete_feature_image').click(function () {
        swal.fire({
            text: 'Are you sure want to delete permanently current featured image?',
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            cancelButtonText: 'No!',
            confirmButtonText: 'Yes',
            closeOnCancel: true,
            customClass: {
                confirmButton: 'btn font-weight-bold btn-light-primary',
                cancelButton: 'btn font-weight-bold btn-danger'
            }
        }).then((result) => {
            if (result.isConfirmed == true) {
                var table = $('.form-input').attr('id');
                var value = $('#upload_feature_image').val();
                $.ajax({
                    url: baseUrl + 'ajax/delete-file',
                    type: 'POST',
                    data: '_token=' + cToken + '&value=' + value + '&table=' + table,
                    success: function (res) {
                        $('#preview_feature_img').attr('src', '../media/admin/layout/default-featured-img.png');
                        $('#delete_feature_image').hide();
                        swal.fire({
                            text: 'Image deleted',
                            icon: 'success',
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    error: function (res) {
                        var obj = $.parseJSON(res);
                        console.log(obj);
                    }
                });
            } else if (result.isDismissed == true) {
                // Swal.fire('Changes are not saved', '', 'info')
            }
        });
    })
})(jQuery);
