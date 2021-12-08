$(document).ready(function () {
	formAllPosition('position_list');
	$("#position_table").DataTable({
		ajax: {
			url: base_url + "get-position-table",
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

$("#position_form").submit(function () {
	$.ajax({
		url: base_url + "add-position",
		type: "POST",
		data: $("#position_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.position_code, "position_code");
			validationInput(data.position_name, "position_name");
			validationInput(data.department, "department");
			validationInput(data.maximum_age_new, "maximum_age_new");
			validationInput(data.maximum_age_ex, "maximum_age_ex");
			validationInput(data.minimum_exp, "minimum_exp");
			validationInput(data.maximum_exp, "maximum_exp");

			if (data.type === "success") {
				$("#position_form").trigger("reset");
				$("#position_table")
					.DataTable()
					.ajax.reload();
				Swal.fire({
					icon: data.type,
					title: data.title
				});
			}
		}
	});
});

function editPosition(id) {
	$.ajax({
		url: base_url + "get-position-details",
		type: "POST",
		data: {
			id: id
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_position_id").val(data.id);
			$("#e_position_code").val(data.position_code);
			$("#e_position_name").val(data.position_name);
			$("#e_department").val(data.type_of_department);
			$("#e_maximum_age_new").val(data.nc_max_age);
			$("#e_maximum_age_ex").val(data.ec_max_age);
			$("#e_minimum_exp").val(data.min_experience);
			$("#e_maximum_exp").val(data.max_experience);
		}
	});
}

$("#e_position_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-position",
		type: "POST",
		data: $("#e_position_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.e_position_code, "e_position_code");
			validationInput(data.e_position_name, "e_position_name");
			validationInput(data.e_department, "e_department");
			validationInput(data.e_maximum_age_new, "e_maximum_age_new");
			validationInput(data.e_maximum_age_ex, "e_maximum_age_ex");
			validationInput(data.e_minimum_exp, "e_minimum_exp");
			validationInput(data.e_maximum_exp, "e_maximum_exp");

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
			} else {
				Swal.fire({
					icon: data.type,
					title: data.title
				});
			}
		}
	});
});

function removePosition(id) {
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
				url: base_url + "remove-position",
				type: "POST",
				data: {
					id: id
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

$("#ResetBtn").click(function () {
	validationInput("", "position_code");
	validationInput("", "position_name");
	validationInput("", "department");
	validationInput("", "maximum_age_new");
	validationInput("", "maximum_age_ex");
	validationInput("", "minimum_exp");
	validationInput("", "maximum_exp");
});

function btnClose() {
	location.reload(true);
}

//VALIDATION

$("#position_code").keyup(function () {
	$.ajax({
		url: base_url + "add-position-validation",
		type: "POST",
		data: $("#position_form").serialize(),
		success: function (data) {
			validationInput(data.position_code, "position_code");
		},
	});
});
$("#position_name").keyup(function () {
	$.ajax({
		url: base_url + "add-position-validation",
		type: "POST",
		data: $("#position_form").serialize(),
		success: function (data) {
			validationInput(data.position_name, "position_name");
		},
	});
});
$("#department").change(function () {
	$.ajax({
		url: base_url + "edit-training-certificate-validation",
		type: "POST",
		data: $("#position_form").serialize(),
		success: function (data) {
			validationInput(data.department, "department");
		},
	});
});
$("#maximum_age_new").keyup(function () {
	$.ajax({
		url: base_url + "edit-training-certificate-validation",
		type: "POST",
		data: $("#position_form").serialize(),
		success: function (data) {
			validationInput(data.maximum_age_new, "maximum_age_new");
		},
	});
});
$("#maximum_age_ex").keyup(function () {
	$.ajax({
		url: base_url + "add-position-validation",
		type: "POST",
		data: $("#position_form").serialize(),
		success: function (data) {
			validationInput(data.maximum_age_ex, "maximum_age_ex");
		},
	});
});
$("#minimum_exp").keyup(function () {
	$.ajax({
		url: base_url + "add-position-validation",
		type: "POST",
		data: $("#position_form").serialize(),
		success: function (data) {
			validationInput(data.minimum_exp, "minimum_exp");
		},
	});
});
$("#maximum_exp").keyup(function () {
	$.ajax({
		url: base_url + "add-position-validation",
		type: "POST",
		data: $("#position_form").serialize(),
		success: function (data) {
			validationInput(data.maximum_exp, "maximum_exp");
		},
	});
});

//EDIT
$("#e_position_code").keyup(function () {
	$.ajax({
		url: base_url + "edit-position-validation",
		type: "POST",
		data: $("#e_position_form").serialize(),
		success: function (data) {
			validationInput(data.e_position_code, "e_position_code");
		},
	});
});
$("#e_position_name").keyup(function () {
	$.ajax({
		url: base_url + "edit-position-validation",
		type: "POST",
		data: $("#e_position_form").serialize(),
		success: function (data) {
			validationInput(data.e_position_name, "e_position_name");
		},
	});
});
$("#e_department").change(function () {
	$.ajax({
		url: base_url + "edit-training-certificate-validation",
		type: "POST",
		data: $("#e_position_form").serialize(),
		success: function (data) {
			validationInput(data.e_department, "e_department");
		},
	});
});
$("#e_maximum_age_new").keyup(function () {
	$.ajax({
		url: base_url + "edit-training-certificate-validation",
		type: "POST",
		data: $("#e_position_form").serialize(),
		success: function (data) {
			validationInput(data.e_maximum_age_new, "e_maximum_age_new");
		},
	});
});
$("#e_maximum_age_ex").keyup(function () {
	$.ajax({
		url: base_url + "edit-position-validation",
		type: "POST",
		data: $("#e_position_form").serialize(),
		success: function (data) {
			validationInput(data.e_maximum_age_ex, "e_maximum_age_ex");
		},
	});
});
$("#e_minimum_exp").keyup(function () {
	$.ajax({
		url: base_url + "edit-position-validation",
		type: "POST",
		data: $("#e_position_form").serialize(),
		success: function (data) {
			validationInput(data.e_minimum_exp, "e_minimum_exp");
		},
	});
});
$("#e_maximum_exp").keyup(function () {
	$.ajax({
		url: base_url + "edit-position-validation",
		type: "POST",
		data: $("#e_position_form").serialize(),
		success: function (data) {
			validationInput(data.e_maximum_exp, "e_maximum_exp");
		},
	});
});
