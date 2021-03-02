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

    $('<div id="alert-confirm"></div>').appendTo('body')
        .html('<div><h6>Are you sure want to delete permanently current featured image?</h6></div>')
        .dialog({
            modal: true,
            title: 'Confirm Delete Featured Image',
            autoOpen: true,
            width: 'auto',
            resizable: false,
            buttons: {
                Yes: function () {
                    $.ajax({
                        url: baseUrl + '/ajax/delete-featured-image',
                        type: 'POST',
                        data: 'image_slug=' + image_slug,
                        success: function (res) {
                            $('#set_feature_image').html('Set featured image');
                            $('#preview_feature_img').attr('src', '');
                            $('#preview_feature_image').css('display', 'none');
                            $('#delete_feature_image').remove();
                        },
                        error: function (res) {
                            var obj = $.parseJSON(res);
                            console.log(obj);
                        }
                    });
                    $(this).dialog('close');
                },
                No: function () {
                    $(this).dialog('close');
                }
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
}

function reset_feature_image(image_slug) {
    var baseUrl = $('body').data('baseurl');
    var newBaseUrl = baseUrl.replace('/myadmin', '/');
    $('#preview_feature_img').attr('src', newBaseUrl + image_slug);
}

(function ($) {
    'use strict';

    $('#set_feature_image').click(function(){
        // alert('boo!');
        $('#upload_feature_image').trigger('click'); 
    })

    function set_feature_image() {
        alert('boo!');
        // let html_set_feature_image = $('#set_feature_image').html();
        // $('#upload_feature_image').click();
        // $('#upload_feature_image').change(function (e) {
        //     if (html_set_feature_image != 'Change featured image') {
        //         $('#set_feature_image').html('Change featured image');
        //     }
        //     $('#preview_feature_image').css('display', 'block');
        //     // var fileName = e.target.files[0].name;
        //     // $('#preview_feature_image span').html(fileName);
        // });
    }
})(jQuery);
