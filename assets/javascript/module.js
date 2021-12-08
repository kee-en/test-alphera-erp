$(document).ready(function () {
	$("#module_table").DataTable({
		ajax: {
			url: base_url + "get-module-table",
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

$("#add_module_form").submit(function () {
	$.ajax({
		url: base_url + "add-module",
		type: "POST",
		data: $("#add_module_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.module_name, "module_name");
			validationInput(data.url, "url");
			validationInput(data.icon, "icon");

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
	validationInput("", "module_name");
	validationInput("", "url");
	validationInput("", "icon");
});

function editModule(id) {
	$.ajax({
		url: base_url + "get-module",
		type: "POST",
		data: {
			id: id,
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_module_id").val(data.id);
			$("#e_module_name").val(data.description);
			$("#e_module_url").val(data.url);
			$("#e_module_icon").val(data.icon);
		},
	});
}

$("#edit_module_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-module",
		type: "POST",
		data: $("#edit_module_form").serialize(),
		dataType: "JSON",
		beforeSend: function () {
			$("#btnEditModule").html(
				'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
			);
		},
		success: function (data) {
			validationInput(data.e_module_name, "e_module_name");
			validationInput(data.e_module_url, "e_module_url");
			validationInput(data.e_module_icon, "e_module_icon");

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

			$("#btnEditModule").html("Save Changes");
		},
	});
});

$("#btnCloseEditModule").click(function () {
	validationInput("", "e_module_name");
	validationInput("", "e_module_url");
	validationInput("", "e_module_icon");
});

$("#btnEditIconModule").click(function () {
	validationInput("", "e_module_name");
	validationInput("", "e_module_url");
	validationInput("", "e_module_icon");
});

function removeModule(id) {
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
				url: base_url + "remove-module",
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

$("#module_name").keyup(function () {
	$.ajax({
		url: base_url + "add-module-form-validation",
		type: "POST",
		data: $("#add_module_form").serialize(),
		success: function (data) {
			validationInput(data.module_name, "module_name");
		},
	});
});

$("#url").keyup(function () {
	$.ajax({
		url: base_url + "add-module-form-validation",
		type: "POST",
		data: $("#add_module_form").serialize(),
		success: function (data) {
			validationInput(data.url, "url");
		},
	});
});

$("#icon").keyup(function () {
	$.ajax({
		url: base_url + "add-module-form-validation",
		type: "POST",
		data: $("#add_module_form").serialize(),
		success: function (data) {
			validationInput(data.icon, "icon");
		},
	});
});

$("#e_module_name").keyup(function () {
	$.ajax({
		url: base_url + "edit-module-form-validation",
		type: "POST",
		data: $("#edit_module_form").serialize(),
		success: function (data) {
			validationInput(data.e_module_name, "e_module_name");
		},
	});
});

$("#e_module_url").keyup(function () {
	$.ajax({
		url: base_url + "edit-module-form-validation",
		type: "POST",
		data: $("#edit_module_form").serialize(),
		success: function (data) {
			validationInput(data.e_module_url, "e_module_url");
		},
	});
});

$("#e_module_icon").keyup(function () {
	$.ajax({
		url: base_url + "edit-module-form-validation",
		type: "POST",
		data: $("#edit_module_form").serialize(),
		success: function (data) {
			validationInput(data.e_module_icon, "e_module_icon");
		},
	});
});
