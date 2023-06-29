$("#isnew").change(function (e) {
    let submitbtn = $("#submitbtn");
    if ($(this).val() == "1") {
        submitbtn
            .removeClass("btn-success btn-warning")
            .addClass("btn-success")
            .val("Submit");
    } else {
        submitbtn
            .removeClass("btn-success btn-warning")
            .addClass("btn-warning")
            .val("Update");
    }
});

$("#resetbtn").click(function (e) {
    e.preventDefault();
    $("#" + $(this).attr("form")).trigger("reset");
    $("#isnew").val("1").trigger("change");
    $(".textarea").html("");
    $(".readonly").removeAttr("readonly");
    $(".permissions").bootstrapToggle("off");
    $(".select2reset").val(null).trigger("change");
});

function refreshTable() {
    listTable.search("");
    listTable.ajax.reload();
}

function showAlertWithCancel(message, func, funcCancel) {
    $.confirm({
        title: "Confirmation",
        content: '<p style="font-size: 14px;">' + message + "</p>",
        buttons: {
            cancel: funcCancel,
            confirm: {
                btnClass: "btn-primary",
                text: "OK",
                action: func,
            },
        },
    });
}

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    beforeSend: function () {
        Notiflix.Loading.standard();
    },
    complete: function () {
        Notiflix.Loading.remove();
    },
});

function showWarning(message) {
    $.alert({
        title: "OoPs !",
        content: message,
    });
}

function showSuccess(message) {
    $.alert({
        title: "Successfull",
        content: message,
    });
}

function showMessage(message) {
    $.alert({
        title: "Feedback",
        content: message,
    });
}

function showAlert(message, func) {
    $.confirm({
        title: "Confirmation",
        content: '<p style="font-size: 14px;">' + message + "</p>",
        buttons: {
            cancel: function () {},
            confirm: {
                btnClass: "btn-primary",
                text: "OK",
                action: func,
            },
        },
    });
}

$("#image").on("change", function (e) {
    var output = document.getElementById("imageview");
    output.src = URL.createObjectURL(e.target.files[0]);
    output.onload = function () {
        URL.revokeObjectURL(output.src);
    };
});

$("#excel_file").on("change", function (e) {
    if (e.target.files[0]) {
        $("#excel_file_chooser").html(e.target.files[0].name);
        $("#excel_file_chooser")
            .removeClass("btn-primary")
            .addClass("btn-success");
        $("#upload_excel_btn").removeClass("d-none");
    }
});
