function clearconsole() {
    console.log(window.console);
    if (window.console) {
        console.clear();
    }
}

(function ($) {
    "use strict";

    var baseUrl = $("body").data("baseurl");
    var cToken = $("body").data("ctoken");

    function BulkConfirmDialog(message, bulkType) {
        swal.fire({
            text: message,
            icon: "warning",
            buttonsStyling: false,
            showCancelButton: true,
            cancelButtonText: "Batalkan!",
            confirmButtonText: "Ya!",
            closeOnCancel: true,
            customClass: {
                confirmButton: "btn font-weight-bold btn-light-primary",
                cancelButton: "btn font-weight-bold btn-danger"
            }
        }).then((result) => {
            if (result.isConfirmed == true) {
                var table = $(".table-list").attr("id");
                let bulkCheckbox = "";
                $(".bulk_action_list:checked").each(function () {
                    bulkCheckbox += $(this).val() + ",";
                });

                if (bulkCheckbox != "") {
                    $.ajax({
                        url: baseUrl + "/ajax/bulk-edit",
                        type: "POST",
                        data: "_token=" + cToken + "&bulk=" + bulkCheckbox + "&table=" + table + "&type=" + bulkType,
                        success: function (res) {
                            location.reload();
                        },
                        error: function (res) {
                            var obj = $.parseJSON(res);
                            console.log(obj);
                        }
                    });
                } else {
                    swal.fire({
                        text: "Tidak ada data yang dipilih!",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Close",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary",
                        }
                    })
                }
            } else if (result.isDismissed == true) {
                // Swal.fire('Changes are not saved', '', 'info')
            }
        });
    };

    $("#bulk-action-checkbox").on("click", function (e) {
        if (this.checked) {
            $("#bulk-action-checkbox-footer").prop("checked", true);
        } else {
            $("#bulk-action-checkbox-footer").prop("checked", false);
        }
    });

    $("#bulk-action-checkbox-footer").on("click", function (e) {
        if (this.checked) {
            $("#bulk-action-checkbox").prop("checked", true);
        } else {
            $("#bulk-action-checkbox").prop("checked", false);
        }
    });

    $("#bulk-action-checkbox, #bulk-action-checkbox-footer").on("click", function (e) {
        if (this.checked) {
            $(".bulk_action_list").each(function () {
                this.checked = true;
            });
        } else {
            $(".bulk_action_list").each(function () {
                this.checked = false;
            });
        }
    });

    $("#bulk-action-select").on("change", function (e) {
        let bulkActionType = $(this).val();
        var actionName = "",
            alertMessage = "";
        if (bulkActionType != "") {
            if (bulkActionType == 0) {
                actionName = "Menunggu Konfirmasi";
            }
            if (bulkActionType == 1) {
                actionName = "Dalam Proses";
            }
            if (bulkActionType == -1) {
                actionName = "Hapus Permanen";
            }
            if (bulkActionType != "") {
                if (bulkActionType == -1) {
                    alertMessage = "Anda ingin " + actionName + "?";
                } else {
                    alertMessage = "Anda ingin mengubah status data terpilih menjadi " + actionName + "?";
                }
                BulkConfirmDialog(alertMessage, bulkActionType);
            }
        }
    });
})(jQuery);
