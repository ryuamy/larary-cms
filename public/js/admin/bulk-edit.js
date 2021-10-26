(function ($) {
    'use strict';

    var baseUrl = $('body').data('baseurl');
    var cToken = $('body').data('ctoken');

    function BulkConfirmDialog(message, bulkType) {
        swal.fire({
            text: message,
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            cancelButtonText: 'Cancel!',
            confirmButtonText: 'Ok!',
            // closeOnCancel: true,
            customClass: {
                confirmButton: 'btn font-weight-bold btn-light-primary',
                cancelButton: 'btn font-weight-bold btn-danger'
            }
        }).then((result) => {
            if (result.isConfirmed == true) {
                var table = $('.table-list').attr('id');
                let bulkCheckbox = '';
                $('.bulk_action_list:checked').each(function () {
                    bulkCheckbox += $(this).val() + ',';
                });

                swal.fire({
                    html: '<div style="text-align:center;max-height:100%;overflow:hidden;margin-bottom:20px;"><i class="fa fa-spinner icon-8x fa-pulse"></i><h4 class="mt-5">Please wait</h4></div>',
                    showConfirmButton: false,
                    showCancelButton: false,
                })

                if (bulkCheckbox != '') {
                    $.ajax({
                        url: baseUrl + 'ajax/bulk-edit',
                        type: 'POST',
                        data: '_token=' + cToken + '&bulk=' + bulkCheckbox + '&table=' + table + '&type=' + bulkType,
                        success: function (res) {
                            location.reload();
                        },
                        error: function (res) {
                            swal.fire({
                                html: '<h4 class="text-danger">Error!</h4>'+JSON.stringify(res.responseJSON),
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'Close',
                                customClass: {
                                    confirmButton: 'btn font-weight-bold btn-light-primary',
                                }
                            })
                        }
                    });
                } else {
                    swal.fire({
                        text: 'No data selected!',
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Close',
                        customClass: {
                            confirmButton: 'btn font-weight-bold btn-light-primary',
                        }
                    })
                }
            } else if (result.isDismissed == true) {
                // Swal.fire('Changes are not saved', '', 'info')
            }
        });
    };

    $('#bulk-action-checkbox').on('click', function (e) {
        if (this.checked) {
            $('#bulk-action-checkbox-footer').prop('checked', true);
        } else {
            $('#bulk-action-checkbox-footer').prop('checked', false);
        }
    });

    $('#bulk-action-checkbox-footer').on('click', function (e) {
        if (this.checked) {
            $('#bulk-action-checkbox').prop('checked', true);
        } else {
            $('#bulk-action-checkbox').prop('checked', false);
        }
    });

    $('#bulk-action-checkbox, #bulk-action-checkbox-footer').on('click', function (e) {
        if (this.checked) {
            $('.bulk_action_list').each(function () {
                this.checked = true;
            });
        } else {
            $('.bulk_action_list').each(function () {
                this.checked = false;
            });
        }
    });

    $('#bulk-action-select').on('change', function (e) {
        let bulkActionType = $(this).val();
        var actionName = '',
            alertMessage = '';
        if (bulkActionType != '') {
            if (bulkActionType == 0) {
                actionName = 'Inactive';
            }
            if (bulkActionType == 1) {
                actionName = 'Active';
            }
            if (bulkActionType == 2) {
                actionName = 'Delete';
            }
            alertMessage = 'Are you sure to ' + actionName + ' selected data?';
            BulkConfirmDialog(alertMessage, bulkActionType);
        }
    });
})(jQuery);
