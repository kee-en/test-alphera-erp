$(function () {
	$("#training_certificate_table").DataTable({
		ajax: {
			url: base_url + "get-training-certificate-table",
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

$("#certificate_form").submit(function (data) {
	$.ajax({
		url: base_url + "add-training-certificate",
		type: "POST",
		data: $("#certificate_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.cert_code, "cert_code");
			validationInput(data.cert_name, "cert_name");
			if (data.type === "success") {
				Swal.fire({
					icon: data.type,
					title: data.title
				});
				$("#certificate_form").trigger("reset");
				$("#training_certificate_table")
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

function removeTrainingCertificates(id) {
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
				url: base_url + "remove-training-certificates",
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

function editTrainingcertificate(id) {
	$.ajax({
		url: base_url + "get-training-certificate",
		type: "POST",
		data: {
			id: id
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_certificate_id").val(data.id);
			$("#e_cert_code").val(data.cert_code);
			$("#e_cert_name").val(data.cert_name);
			if (data.with_cop === "1") {
				$("#e_with_cop").attr("checked", true);
			}
			if (data.required === "1") {
				$("#e_required").attr("checked", true);
			}
		}
	});
}

$("#e_certificate_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-training-certificate",
		type: "POST",
		data: $("#e_certificate_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.e_cert_code, "e_cert_code");
			validationInput(data.e_cert_name, "e_cert_name");

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

$("#BtnReset").click(function () {
	validationInput("", "cert_code");
	validationInput("", "cert_name");
});

function btnClose() {
	location.reload(true);
}

$("#cert_code").keyup(function () {
	$.ajax({
		url: base_url + "add-training-certificate-validation",
		type: "POST",
		data: $("#certificate_form").serialize(),
		success: function (data) {
			validationInput(data.cert_code, "cert_code");
		},
	});
});
$("#cert_name").keyup(function () {
	$.ajax({
		url: base_url + "add-training-certificate-validation",
		type: "POST",
		data: $("#certificate_form").serialize(),
		success: function (data) {
			validationInput(data.cert_name, "cert_name");
		},
	});
});
$("#e_cert_code").keyup(function () {
	$.ajax({
		url: base_url + "edit-training-certificate-validation",
		type: "POST",
		data: $("#e_certificate_form").serialize(),
		success: function (data) {
			validationInput(data.e_cert_code, "e_cert_code");
		},
	});
});
$("#e_cert_name").keyup(function () {
	$.ajax({
		url: base_url + "edit-training-certificate-validation",
		type: "POST",
		data: $("#e_certificate_form").serialize(),
		success: function (data) {
			validationInput(data.e_cert_name, "e_cert_name");
		},
	});
});
