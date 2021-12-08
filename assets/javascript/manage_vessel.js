$(document).ready(function () {
	$("#manage_vessel_table").DataTable({
		ajax: {
			url: base_url + "get-vessel-table",
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
});

$("#add_vessel_form").submit(function () {
	$.ajax({
		url: base_url + "add-vessel",
		type: "POST",
		data: $("#add_vessel_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.vsl_code, "vsl_code");
			validationInput(data.vsl_name, "vsl_name");
			validationInput(data.type_of_vessel, "type_of_vessel");
			validationInput(data.type_of_engine, "type_of_engine");
			if (data.type === "success") {
				$("#add_vessel_form").trigger("reset");
				$("#manage_vessel_table")
					.DataTable()
					.ajax.reload();
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			} else if (data.type === "error") {
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			}
		}
	});
});

function editVessel(id) {
	$.ajax({
		url: base_url + "get-vessel",
		type: "POST",
		data: {
			id: id
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_vsl_id").val(data.id);
			$("#e_vsl_code").val(data.vsl_code);
			$("#e_vsl_name").val(data.vsl_name);
			$("#e_type_of_vessel").val(data.vsl_type);
			$("#e_type_of_engine").val(data.vsl_engine);
			$("#type_acquisition_status").val(data.acquisition_status);
		}
	});
}

$("#edit_vessel_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-vessel",
		type: "POST",
		data: $("#edit_vessel_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.e_vsl_code, "e_vsl_code");
			validationInput(data.e_vsl_name, "e_vsl_name");
			validationInput(data.e_type_of_vessel, "e_type_of_vessel");
			validationInput(data.e_type_of_engine, "e_type_of_engine");

			if (data.type === "success") {
				$("#edit_vessel_modal").modal("toggle");
				$("#manage_vessel_table")
					.DataTable()
					.ajax.reload();
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			} else if (data.type === "warning") {
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			}
		}
	});
});

function removeVessel(id) {
	$('#remove_vessel_modal').modal('show');
	$('#vsl_rmv_id').val(id);
}

$("#remove_vessel_form").submit(function () {
	Swal.fire({
		title: "Are you sure you want to remove this ?",
		icon: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
		allowEscapeKey: false,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, remove it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "remove-vessel",
				type: "POST",
				data: $("#remove_vessel_form").serialize(),
				dataType: "JSON",
				success: function (data) {
					Swal.fire({
						icon: data.type,
						title: data.title,
						confirmButtonText: "Close",
						allowOutsideClick: false,
						allowEscapeKey: false,
					});
	
					if (data.type === "success") {
						$("#manage_vessel_table")
							.DataTable()
							.ajax.reload();
					}
				}
			});
		}
	});
});

$("#BtnReset").click(function () {
	validationInput("", "vsl_code");
	validationInput("", "vsl_name");
	validationInput("", "type_of_vessel");
	validationInput("", "type_of_engine");
});

function btnClose() {
	location.reload(true);
}

//VALIDATIONS
$("#vsl_code").keyup(function () {
	$.ajax({
		url: base_url + "add-vessel-validation",
		type: "POST",
		data: $("#add_vessel_form").serialize(),
		success: function (data) {
			validationInput(data.vsl_code, "vsl_code");
		},
	});
});
$("#vsl_name").keyup(function () {
	$.ajax({
		url: base_url + "add-vessel-validation",
		type: "POST",
		data: $("#add_vessel_form").serialize(),
		success: function (data) {
			validationInput(data.vsl_name, "vsl_name");
		},
	});
});
$("#type_of_vessel").change(function () {
	$.ajax({
		url: base_url + "add-vessel-validation",
		type: "POST",
		data: $("#add_vessel_form").serialize(),
		success: function (data) {
			validationInput(data.type_of_vessel, "type_of_vessel");
		},
	});
});
$("#type_of_engine").change(function () {
	$.ajax({
		url: base_url + "add-vessel-validation",
		type: "POST",
		data: $("#add_vessel_form").serialize(),
		success: function (data) {
			validationInput(data.type_of_engine, "type_of_engine");
		},
	});
});
//EDIT
$("#e_vsl_code").keyup(function () {
	$.ajax({
		url: base_url + "edit-vessel-validation",
		type: "POST",
		data: $("#edit_vessel_form").serialize(),
		success: function (data) {
			validationInput(data.e_vsl_code, "e_vsl_code");
		},
	});
});
$("#e_vsl_name").keyup(function () {
	$.ajax({
		url: base_url + "edit-vessel-validation",
		type: "POST",
		data: $("#edit_vessel_form").serialize(),
		success: function (data) {
			validationInput(data.e_vsl_name, "e_vsl_name");
		},
	});
});
$("#e_type_of_vessel").change(function () {
	$.ajax({
		url: base_url + "edit-vessel-validation",
		type: "POST",
		data: $("#edit_vessel_form").serialize(),
		success: function (data) {
			validationInput(data.e_type_of_vessel, "e_type_of_vessel");
		},
	});
});
$("#e_type_of_engine").change(function () {
	$.ajax({
		url: base_url + "edit-vessel-validation",
		type: "POST",
		data: $("#edit_vessel_form").serialize(),
		success: function (data) {
			validationInput(data.e_type_of_engine, "e_type_of_engine");
		},
	});
});