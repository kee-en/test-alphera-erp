$(function () {
	formVessel("awlm_vessel");
	formAllPosition("awlm_rank");
	formDepartment("awlm_department");
});

function getCrewDetails(cmp_code) {
	$.ajax({
		url: base_url + "get-cmp-details",
		type: "POST",
		data: { code: cmp_code },
		dataType: "JSON",
		success: function (data) {
			$("#awlm_crew_name").html(data.full_name);
			$("#awl_crew_name").val(data.full_name);
			$("#awlm_rank").val(data.position);
			$("#awlm_department").val(data.type_of_department);
			$("#awlm_vessel").val(data.vessel_code);
			$("#awl_crew_code").val(data.crew_code);
			$("#awl_monitor_code").val(data.offsigner);
			$("#awl_applicant_code").val(data.applicant_code);
		},
	});
}

$("#add_warning_letter_form").submit(function () {
	$("#awlm_rank").attr("disabled", false);
	$("#awlm_vessel").attr("disabled", false);
	$("#awlm_department").attr("disabled", false);

	$.ajax({
		url: base_url + "insert-dis-warningletter-crew",
		type: "POST",
		data: $("#add_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.awlm_rank, "awlm_rank");
			validationInput(data.awlm_department, "awlm_department");
			validationInput(data.awlm_vessel, "awlm_vessel");
			validationInput(data.awlm_remarks, "awlm_remarks");
			validationInput(data.awlm_type_of_nre, "awlm_type_of_nre");

			if (data.type) {
				$("#awlm_rank").attr("disabled", true);
				$("#awlm_vessel").attr("disabled", true);
				$("#awlm_department").attr("disabled", true);

				Swal.fire({
					icon: data.type,
					title: data.title,
					text: data.text,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					if (data.type === "success") {
						$("#add_warning_letter_form")[0].reset();
						location.reload(true);
					} else if (data.type === "early_disembark") {
						$("#add_warning_letter_form")[0].reset();
						location.reload(true);
					}
				});
			}
		},
	});
});

$("#awlm_rank").change(function () {
	$.ajax({
		url: base_url + "add-early-dis-warning-letter-validation",
		type: "POST",
		data: $("#add_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.awlm_rank, "awlm_rank");
		},
	});
});

$("#awlm_department").change(function () {
	$.ajax({
		url: base_url + "add-early-dis-warning-letter-validation",
		type: "POST",
		data: $("#add_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.awlm_department, "awlm_department");
		},
	});
});

$("#awlm_vessel").change(function () {
	$.ajax({
		url: base_url + "add-early-dis-warning-letter-validation",
		type: "POST",
		data: $("#add_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.awlm_vessel, "awlm_vessel");
		},
	});
});

$("#awlm_remarks").change(function () {
	$.ajax({
		url: base_url + "add-early-dis-warning-letter-validation",
		type: "POST",
		data: $("#add_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.awlm_remarks, "awlm_remarks");
		},
	});
});

$("#awlm_type_of_nre").change(function () {
	$.ajax({
		url: base_url + "add-early-dis-warning-letter-validation",
		type: "POST",
		data: $("#add_warning_letter_form").serialize(),
		success: function (data) {
			validationInput(data.awlm_type_of_nre, "awlm_type_of_nre");
		},
	});
});
