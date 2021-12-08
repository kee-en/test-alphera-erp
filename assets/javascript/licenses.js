$(function () {
	$("#license_table").DataTable({
		ajax: {
			url: base_url + "get-license-table",
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

$("#license_form").submit(function () {
	$.ajax({
		url: base_url + "add-license",
		type: "POST",
		data: $("#license_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.license_code, "license_code");
			validationInput(data.license_name, "license_name");

			if (data.type === "success") {
				Swal.fire({
					icon: data.type,
					title: data.title
				});
				$("#license_form").trigger("reset");
				$("#license_table")
					.DataTable()
					.ajax.reload();
			} else if (data.type === "error") {
				Swal.fire({
					icon: data.type,
					title: data.title
				});
			}
		}
	});
});

function editLicense(id) {
	$.ajax({
		url: base_url + "get-license",
		type: "POST",
		data: {
			id: id
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_license_id").val(data.id);
			$("#e_license_code").val(data.license_code);
			$("#e_license_name").val(data.license_name);
			if (data.required === "1") {
				$("#e_required").attr("checked", true);
			}
		}
	});
}

$("#e_license_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-license",
		type: "POST",
		data: $("#e_license_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.e_license_code, "e_license_code");
			validationInput(data.e_license_name, "e_license_name");

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

function removeLicense(id) {
	Swal.fire({
		title: "Are you sure you want to remove this ?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, remove it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "remove-license",
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

$("#BtnReset").click(function () {
	validationInput("", "license_code");
	validationInput("", "license_name");
});

function btnClose() {
	location.reload(true);
}

$("#license_code").keyup(function () {
	$.ajax({
		url: base_url + "add-license-validation",
		type: "POST",
		data: $("#license_form").serialize(),
		success: function (data) {
			validationInput(data.license_code, "license_code");
		},
	});
});
$("#license_name").keyup(function () {
	$.ajax({
		url: base_url + "add-license-validation",
		type: "POST",
		data: $("#license_form").serialize(),
		success: function (data) {
			validationInput(data.license_name, "license_name");
		},
	});
});
$("#e_license_code").keyup(function () {
	$.ajax({
		url: base_url + "edit-license-validation",
		type: "POST",
		data: $("#e_license_form").serialize(),
		success: function (data) {
			validationInput(data.e_license_code, "e_license_code");
		},
	});
});
$("#e_license_name").keyup(function () {
	$.ajax({
		url: base_url + "edit-license-validation",
		type: "POST",
		data: $("#e_license_form").serialize(),
		success: function (data) {
			validationInput(data.e_license_name, "e_license_name");
		},
	});
});
