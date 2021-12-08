$(function () {
	formAllUserType('user_type');
	display_user_responsibility();
});

$("#add_user_type_form").submit(function () {
	$.ajax({
		url: base_url + "save-user-type",
		type: "POST",
		data: $("#add_user_type_form").serialize(),
		success: function (data) {
			validationInput(data.full_name, "full_name");
			validationInput(data.username, "username");
			validationInput(data.email_address, "email_address");
			validationInput(data.phone_number, "phone_number");
			validationInput(data.password, "password");
			validationInput(data.confirm_password, "confirm_password");
			validationInput(data.user_type, "user_type");

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
});

function display_user_responsibility() {
	$.ajax({
		url: base_url + "get-user-responsibility-list",
		type: "AJAX",
		success: function (data) {
			if (data != "") {
				$('#responsibility_list').html(data);
			} else {
				$('#responsibility_list').html('<div class="col-md-12 text-center"><h4 class="text-muted">There is no user responsibility to display</h4></div>');
			}
		},
	});
}

$("#BtnReset").click(function () {
	$('#add_user_type_form')[0].reset();
	validationInput("", "full_name");
	validationInput("", "username");
	validationInput("", "email_address");
	validationInput("", "phone_number");
	validationInput("", "password");
	validationInput("", "confirm_password");
	validationInput("", "user_type");
});

//VALIDATIONS
$("#full_name").keyup(function () {
	$.ajax({
		url: base_url + "add-user-type-validation",
		type: "POST",
		data: $("#add_user_type_form").serialize(),
		success: function (data) {
			validationInput(data.full_name, "full_name");
		},
	});
});
$("#username").keyup(function () {
	$.ajax({
		url: base_url + "add-user-type-validation",
		type: "POST",
		data: $("#add_user_type_form").serialize(),
		success: function (data) {
			validationInput(data.username, "username");
		},
	});
});
$("#email_address").keyup(function () {
	$.ajax({
		url: base_url + "add-user-type-validation",
		type: "POST",
		data: $("#add_user_type_form").serialize(),
		success: function (data) {
			validationInput(data.email_address, "email_address");
		},
	});
});
$("#phone_number").keyup(function () {
	$.ajax({
		url: base_url + "add-user-type-validation",
		type: "POST",
		data: $("#add_user_type_form").serialize(),
		success: function (data) {
			validationInput(data.phone_number, "phone_number");
		},
	});
});
$("#phone_number").keyup(function () {
	$.ajax({
		url: base_url + "add-user-type-validation",
		type: "POST",
		data: $("#add_user_type_form").serialize(),
		success: function (data) {
			validationInput(data.phone_number, "phone_number");
		},
	});
});
$("#password").keyup(function () {
	$.ajax({
		url: base_url + "add-user-type-validation",
		type: "POST",
		data: $("#add_user_type_form").serialize(),
		success: function (data) {
			validationInput(data.password, "password");
		},
	});
});
$("#confirm_password").keyup(function () {
	$.ajax({
		url: base_url + "add-user-type-validation",
		type: "POST",
		data: $("#add_user_type_form").serialize(),
		success: function (data) {
			validationInput(data.confirm_password, "confirm_password");
		},
	});
});
$("#user_type").change(function () {
	$.ajax({
		url: base_url + "add-user-type-validation",
		type: "POST",
		data: $("#add_user_type_form").serialize(),
		success: function (data) {
			validationInput(data.user_type, "user_type");
		},
	});
});

$("#p_password").keyup(function () {
	$.ajax({
		url: base_url + "update-user-password-validation",
		type: "POST",
		data: $("#update_user_password_form").serialize(),
		success: function (data) {
			validationInput(data.p_password, "p_password");
		},
	});
});
$("#p_confirm_password").keyup(function () {
	$.ajax({
		url: base_url + "update-user-password-validation",
		type: "POST",
		data: $("#update_user_password_form").serialize(),
		success: function (data) {
			validationInput(data.p_confirm_password, "p_confirm_password");
		},
	});
});