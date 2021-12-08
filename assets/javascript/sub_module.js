$(document).ready(function () {
	$("#sub_module_table").DataTable({
		ajax: {
			url: base_url + "get-sub-module-table",
			type: "POST",
		},
		language: {
			paginate: {
				previous: "<i class='mdi mdi-chevron-left'>",
				next: "<i class='mdi mdi-chevron-right'>",
			},
		},
		drawCallback: function () {
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		},
	});
});

$("#add_sub_module_form").submit(function () {
	$.ajax({
		url: base_url + "add-sub-module",
		type: "POST",
		data: $("#add_sub_module_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.module, "module");
			validationInput(data.sub_module, "sub_module");
			validationInput(data.target_link, "target_link");
			validationInput(data.sub_module_url, "sub_module_url");

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
		},
	});
});

$("#btnReset").click(function () {
	validationInput("", "module");
	validationInput("", "sub_module");
	validationInput("", "target_link");
	validationInput("", "sub_module_url");

	$("#sub_module_url").prop("readonly", true);
});

function editSubModule(id) {
	$.ajax({
		url: base_url + "get-sub-module",
		type: "POST",
		data: {
			id: id,
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_sub_module_id").val(data.id);
			$("#e_module").val(data.form_module_id);
			$("#e_sub_module").val(data.description);
			$("#e_sub_module_url").val(data.url);
		},
	});
}

$("#edit_sub_module_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-sub-module",
		type: "POST",
		data: $("#edit_sub_module_form").serialize(),
		dataType: "JSON",
		beforeSend: function () {
			$("#btnEditSubModule").html(
				'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
			);
		},
		success: function (data) {
			validationInput(data.e_module, "e_module");
			validationInput(data.e_sub_module, "e_sub_module");
			validationInput(data.e_target_link, "e_target_link");
			validationInput(data.e_sub_module_url, "e_sub_module_url");

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

			$("#btnEditSubModule").html("Save Changes");
		},
	});
});

$("#btnCloseEditSubModule").click(function () {
	validationInput("", "e_module");
	validationInput("", "e_sub_module");
	validationInput("", "e_target_link");
	validationInput("", "e_sub_module_url");
});

$("#btnEditIconSubModule").click(function () {
	validationInput("", "e_module");
	validationInput("", "e_sub_module");
	validationInput("", "e_target_link");
	validationInput("", "e_sub_module_url");
});

function removeSubModule(id) {
	Swal.fire({
		title: "Are you sure you want to remove this?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, remove it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "remove-sub-module",
				type: "POST",
				data: {
					id: id,
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
				},
			});
		}
	});
}

$("#module").change(function () {
	$.ajax({
		url: base_url + "add-sub-module-form-validation",
		type: "POST",
		data: $("#add_sub_module_form").serialize(),
		success: function (data) {
			validationInput(data.module, "module");
		},
	});
});

$("#sub_module").keyup(function () {
	$.ajax({
		url: base_url + "add-sub-module-form-validation",
		type: "POST",
		data: $("#add_sub_module_form").serialize(),
		success: function (data) {
			validationInput(data.sub_module, "sub_module");
		},
	});
});

$("#sub_module_url").keyup(function () {
	$.ajax({
		url: base_url + "add-sub-module-form-validation",
		type: "POST",
		data: $("#add_sub_module_form").serialize(),
		success: function (data) {
			validationInput(data.sub_module_url, "sub_module_url");
		},
	});
});

$("#e_module").change(function () {
	$.ajax({
		url: base_url + "edit-sub-module-form-validation",
		type: "POST",
		data: $("#edit_sub_module_form").serialize(),
		success: function (data) {
			validationInput(data.e_module, "e_module");
		},
	});
});

$("#e_sub_module").keyup(function () {
	$.ajax({
		url: base_url + "edit-sub-module-form-validation",
		type: "POST",
		data: $("#edit_sub_module_form").serialize(),
		success: function (data) {
			validationInput(data.e_sub_module, "e_sub_module");
		},
	});
});

$("#e_sub_module_url").keyup(function () {
	$.ajax({
		url: base_url + "edit-sub-module-form-validation",
		type: "POST",
		data: $("#edit_sub_module_form").serialize(),
		success: function (data) {
			validationInput(data.e_sub_module_url, "e_sub_module_url");
		},
	});
});

$("#target_link").on("change", function () {
	if ($(this).val() === "1") {
		$("#sub_module_url").prop("readonly", false);
		$("#sub_module_url").val("");
	} else {
		$("#sub_module_url").prop("readonly", true);
		$("#sub_module_url").val("#");

		validationInput("", "sub_module_url");
	}
});
$("#e_target_link").on("change", function () {
	if ($(this).val() === "1") {
		$("#e_sub_module_url").prop("readonly", false);
		$("#e_sub_module_url").val("");
	} else {
		$("#e_sub_module_url").prop("readonly", true);
		$("#e_sub_module_url").val("#");

		validationInput("", "e_sub_module_url");
	}
});
