$(function () {
	formWarningStatuses('w_type_of_nre');
});

$(document).ready(function () {
	crewWarningLetterTable();

	formAllCrewName("w_crew_name");
	var $eventSelect = $("#w_crew_name").select2();
	$eventSelect.on("change", function (e) {
		var app_code = this.value;
		$.ajax({
			url: base_url + "search-warningletter-id",
			type: "POST",
			data: { app_code: app_code },
			success: function (data) {
				if (data) {
					$("#w_rank").empty();
					$("#w_department").empty();
					$("#w_vessel").empty();
					$("#w_applicant_code").empty();
					$("#w_cname").empty();
					$("#w_remarks").empty();
					$.each(data, function (key, value) {
						$("#w_rank").append(
							"<option value=" +
								value.position +
								">" +
								value.position_name +
								"</option>"
						);
						$("#w_department").append(
							"<option value=" +
								value.type_of_department +
								">" +
								value.department_name +
								"</option>"
						);
						$("#w_vessel").append(
							"<option value=" +
								value.vessel_assign +
								">" +
								value.vsl_name +
								"</option>"
						);
						$("#w_applicant_code").val(value.applicant_code);
						$("#w_cname").val(value.full_name);

						if (value.status === "3") {
							var choices = new Array();
							choices[0] = { Text: "Choose option", Value: "" };
							choices[1] = { Text: "Not For Rehire (NRE)", Value: "1" };
							choices[2] = { Text: "Early Disembarkation", Value: "2" };
							for (let index = 0; index < choices.length; index++) {
								$("#w_remarks").append(
									'<option value="' +
										choices[index].Value +
										'">' +
										choices[index].Text +
										"</option>"
								);
							}
						} else {
							var choices = new Array();
							choices[0] = { Text: "Choose option", Value: "" };
							choices[1] = { Text: "Not For Rehire (NRE)", Value: "1" };
							for (let index = 0; index < choices.length; index++) {
								$("#w_remarks").append(
									'<option value="' +
										choices[index].Value +
										'">' +
										choices[index].Text +
										"</option>"
								);
							}
						}
					});
				}
			},
		});
	});
});

function crewWarningLetterTable() {
	$("#crew_warning_letter_table").DataTable({
		ajax: {
			url: base_url + "get-warningletter-crew",
			type: "GET",
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
}

$("#crew_warning_letter_table").on("search.dt", function () {
	//how to get dataTable search value
	var value = $(".dataTables_filter input").val();
	$("#search").val(value);
});

$("#crew_warning_letter_form").submit(function () {
	$.ajax({
		url: base_url + "insert-warningletter-crew",
		type: "POST",
		data: $("#crew_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.w_crew_name, "w_crew_name");
			validationInput(data.w_rank, "w_rank");
			validationInput(data.w_department, "w_department");
			validationInput(data.w_vessel, "w_vessel");
			validationInput(data.w_remarks, "w_remarks");

			if (data.type) {
				Swal.fire({
					icon: data.type,
					title: data.title,
					text: data.text,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					if (data.type === "success") {
						$("#crew_warning_letter_form")[0].reset();
						location.reload(true);
					}
				});
			}
		},
	});
});

function deleteWatchlistedCrew(id) {
	Swal.fire({
		title: "Are you sure you want to remove this?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, remove it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "delete-warningletter-crew",
				type: "POST",
				data: { id: id },
				success: function (data) {
					if (data.type) {
						Swal.fire({
							icon: data.type,
							title: data.title,
							text: data.text,
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							if (data.type === "success") {
								location.reload(true);
							}
						});
					}
				},
			});
		}
	});
}

$("#cwl_export_as").change(function () {
	window.open(base_url + "print-warning-letter" + "/" + this.value);
});

$("#btnResetWarningLetter").click(function () {
	validationInput("", "w_crew_name");
	validationInput("", "w_rank");
	validationInput("", "w_department");
	validationInput("", "w_vessel");
	validationInput("", "w_remarks");

	$("#w_rank")
		.find("option")
		.remove()
		.end()
		.append('<option value="">Choose option</option>')
		.val("0");
	$("#w_department")
		.find("option")
		.remove()
		.end()
		.append('<option value="">Choose option</option>')
		.val("0");
	$("#w_vessel")
		.find("option")
		.remove()
		.end()
		.append('<option value="">Choose option</option>')
		.val("0");
	$("#w_crew_name")
		.find("option")
		.remove()
		.end()
		.append('<option value="">Select Crew Name</option>')
		.val("0");
	formAllCrewName("w_crew_name");

	document.getElementById("crew_warning_letter_form").reset();
});

$("#w_crew_name").change(function () {
	$.ajax({
		url: base_url + "add-warning-letter-validation",
		type: "POST",
		data: $("#crew_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.w_crew_name, "w_crew_name");
		},
	});
});

$("#w_rank").change(function () {
	$.ajax({
		url: base_url + "add-warning-letter-validation",
		type: "POST",
		data: $("#crew_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.w_rank, "w_rank");
		},
	});
});

$("#w_department").change(function () {
	$.ajax({
		url: base_url + "add-warning-letter-validation",
		type: "POST",
		data: $("#crew_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.w_department, "w_department");
		},
	});
});

$("#w_vessel").change(function () {
	$.ajax({
		url: base_url + "add-warning-letter-validation",
		type: "POST",
		data: $("#crew_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.w_vessel, "w_vessel");
		},
	});
});

$("#w_remarks").change(function () {
	$.ajax({
		url: base_url + "add-warning-letter-validation",
		type: "POST",
		data: $("#crew_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.w_remarks, "w_remarks");
		},
	});
});
