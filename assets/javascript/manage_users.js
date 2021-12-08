$(function () {
    $("#accounts_table").DataTable({
        ajax: {
            url: base_url + "get-all-users",
            type: "POST"
        },
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    formAllUserType('user_type');
});

$("#update_user_access_form").submit(function () {
    $.ajax({
        url: base_url + "update-user-type",
        type: "POST",
        data: $("#update_user_access_form").serialize(),
        success: function (data) {

            if (data.type === "success") {
                Swal.fire({
                    icon: data.type,
                    title: data.title,
                    text: data.text,
                    confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
                    onClose: () => {
                        location.reload(true);
                    },
                });

            } else {
                Swal.fire({
                    icon: data.type,
                    title: data.title
                });
            }
        }
    });
});

$("#update_user_password_form").submit(function () {
    $.ajax({
        url: base_url + "update-user-password",
        type: "POST",
        data: $("#update_user_password_form").serialize(),
        success: function (data) {
            validationInput(data.p_password, "p_password");
            validationInput(data.p_confirm_password, "p_confirm_password");

            if (data.type === "success") {
                Swal.fire({
                    icon: data.type,
                    title: data.title,
                    text: data.text,
                    confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
                    onClose: () => {
                        location.reload(true);
                    },
                });

            } else {
                Swal.fire({
                    icon: data.type,
                    title: data.title
                });
            }
        }
    });
});

function change_user_access(code) {
    formAllUserType('e_user_type');
    $.ajax({
        url: base_url + "get-user-details",
        type: "POST",
        data: { code: code },
        success: function (data) {

            $('#e_user_type').val(data.user_type_id);
            $('#user_name').html(data.full_name);
            $('#e_full_name').val(data.full_name);
            $('#e_user_code').val(data.user_code);
            $('#e_username').val(data.username);
            $('#e_email_address').val(data.email_address);
            $('#e_phone_number').val(data.phone_number);
            $('#e_Password').val(data.password);
        }
    });
}

function change_user_password(code) {
    $.ajax({
        url: base_url + "get-user-details",
        type: "POST",
        data: { code: code },
        success: function (data) {

            $('#p_user_type').val(data.user_type_id);
            $('#user_name').html(data.full_name);
            $('#p_full_name').val(data.full_name);
            $('#p_user_code').val(data.user_code);
            $('#p_username').val(data.username);
            $('#p_email_address').val(data.email_address);
            $('#p_phone_number').val(data.phone_number);
            // $('#p_password').val(data.password);
        }
    });
    $('#change_user_password_modal').modal('show');
}

function deactivate_account(code) {
    Swal.fire({
        title: "Are you sure you want to deactivate this account?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        allowOutsideClick: false,
        allowEscapeKey: false,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "deactivate-user-account",
                type: "POST",
                data: {
                    code: code
                },
                dataType: "JSON",
                success: function (data) {
                    if (data.type === "success") {
                        Swal.fire({
                            icon: data.type,
                            title: data.title,
                            confirmButtonText: "Close",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(function () {
                            location.reload(true);
                        });
                    }
                }
            });
        }
    });
}

$("#modalClose").click(function () {
    location.reload();
});
$("#CloseChangePass").click(function () {
    location.reload();
});