$(document).ready(function () {
	$("#type_of_vessel_table").DataTable({
		ajax: {
			url: base_url + "get-vessel-type-table",
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

$("#vessel_type_form").submit(function () {
	$.ajax({
		url: base_url + "add-vessel-type",
		type: "POST",
		data: $("#vessel_type_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.vessel_code, "vessel_code");
			validationInput(data.vessel_name, "vessel_name");
			if (data.type === "success") {
				$("#vessel_type_form").trigger("reset");
				$("#type_of_vessel_table")
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
					title: data.title
				});
			}
		}
	});
});

function editVesselType(id) {
	$.ajax({
		url: base_url + "get-vessel-type",
		type: "POST",
		data: { id: id },
		dataType: "JSON",
		success: function (data) {
			$("#e_vessel_id").val(data.id);
			$("#e_vessel_code").val(data.tv_code);
			$("#e_vessel_name").val(data.tv_name);
		}
	});
}

$("#e_vessel_type_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-vessel-type",
		type: "POST",
		data: $("#e_vessel_type_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.e_vessel_code, "e_vessel_code");
			validationInput(data.e_vessel_name, "e_vessel_name");

			if (data.type === "success") {
				$("#edit_vessel_type_modal").modal("toggle");
				$("#type_of_vessel_table")
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

function removeVesselType(id) {
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
				url: base_url + "remove-vessel-type",
				type: "POST",
				data: {
					id: id
				},
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
						$("#type_of_vessel_table")
							.DataTable()
							.ajax.reload();
					}
				}
			});
		}
	});
}

$("#btnReset").click(function(){
	validationInput("", "vessel_code");
	validationInput("", "vessel_name");
});

function btnClose() {
	location.reload(true);
}

//VALIDATIONS
$("#vessel_code").keyup(function () {
	$.ajax({
		url: base_url + "add-vessel-type-validation",
		type: "POST",
		data: $("#vessel_type_form").serialize(),
		success: function (data) {
			validationInput(data.vessel_code, "vessel_code");
		},
	});
});
$("#vessel_name").keyup(function () {
	$.ajax({
		url: base_url + "add-vessel-type-validation",
		type: "POST",
		data: $("#vessel_type_form").serialize(),
		success: function (data) {
			validationInput(data.vessel_name, "vessel_name");
		},
	});
});

$("#e_vessel_code").keyup(function () {
	$.ajax({
		url: base_url + "edit-vessel-type-validation",
		type: "POST",
		data: $("#e_vessel_type_form").serialize(),
		success: function (data) {
			validationInput(data.e_vessel_code, "e_vessel_code");
		},
	});
});
$("#e_vessel_name").keyup(function () {
	$.ajax({
		url: base_url + "edit-vessel-type-validation",
		type: "POST",
		data: $("#e_vessel_type_form").serialize(),
		success: function (data) {
			validationInput(data.e_vessel_name, "e_vessel_name");
		},
	});
});