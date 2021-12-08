$(function () {
	formAllPosition("m_position");
});

function getMedicalDetails(crew_code) {
	getCrewInfo(crew_code);
	getPersonalInformation(crew_code);

	$("#add_medical_modal").modal("show");
}

function getCrewInfo(crew_code) {
	$.ajax({
		url: base_url + "get-crew-information",
		type: "POST",
		data: {
			code: crew_code
		},
		dataType: "JSON",
		success: function (data) {
			$("#m_crew_code").val(data.crew_code);
			$("#m_position").val(data.position);
		},
	});
}

function getPersonalInformation(crew_code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			var full_name =
				data.first_name + " " + data.middle_name + " " + data.last_name;

			$("#am_crew_name").html(full_name);
			$("#m_full_name").val(full_name);
			$("#m_height").val(data.height);
			$("#m_weight").val(data.weight);
			$("#m_age").val(getAge(data.birth_date));
			$("#m_bmi").val(formatBMI(data.height, data.weight).toFixed(2));
		},
	});
}

$("#m_height").keyup(function () {
	$("#m_bmi").val(formatBMI(this.value, $("#m_weight").val()).toFixed(2));
});

$("#m_weight").keyup(function () {
	$("#m_bmi").val(formatBMI($("#m_height").val(), this.value).toFixed(2));
});

$("#medical_form").submit(function () {
	$.ajax({
		url: base_url + "save-medical-record-form",
		type: "POST",
		data: $("#medical_form").serialize(),
		beforeSend: function () {
			$("#BtnAddMedical").html(
				'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
			);
			$("#BtnAddMedical").prop("disabled", true);
		},
		success: function (data) {
			validationInput(data.m_date_med_exam, "m_date_med_exam");
			validationInput(data.m_medical_expiry_date, "m_medical_expiry_date");
			validationInput(data.m_status, "m_status");
			validationInput(data.m_height, "m_height");
			validationInput(data.m_weight, "m_weight");

			if (data.type) {
				Swal.fire({
					icon: data.type,
					title: data.title,
					text: data.text,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					if (data.type === 'success') {
						location.reload(true);
					}
				});
			}
			$("#BtnAddMedical").html(
				'Save'
			);
			$("#BtnAddMedical").prop("disabled", false);
		},
	});
});

$("#m_date_med_exam").change(function () {
	$.ajax({
		url: base_url + "add-medical-validation",
		type: "POST",
		data: $("#medical_form").serialize(),
		success: function (data) {
			validationInput(data.m_date_med_exam, "m_date_med_exam");
		},
	});
});

$("#m_medical_expiry_date").change(function () {
	$.ajax({
		url: base_url + "add-medical-validation",
		type: "POST",
		data: $("#medical_form").serialize(),
		success: function (data) {
			validationInput(data.m_medical_expiry_date, "m_medical_expiry_date");
		},
	});
});

$("#m_status").change(function () {
	$.ajax({
		url: base_url + "add-medical-validation",
		type: "POST",
		data: $("#medical_form").serialize(),
		success: function (data) {
			validationInput(data.m_status, "m_status");
		},
	});
});

$("#m_height").keyup(function () {
	$.ajax({
		url: base_url + "add-medical-validation",
		type: "POST",
		data: $("#medical_form").serialize(),
		success: function (data) {
			validationInput(data.m_height, "m_height");
		},
	});
});

$("#m_weight").keyup(function () {
	$.ajax({
		url: base_url + "add-medical-validation",
		type: "POST",
		data: $("#medical_form").serialize(),
		success: function (data) {
			validationInput(data.m_weight, "m_weight");
		},
	});
});

$("#m_status").on("change", function () {
	if ($(this).val() === "1") {
		$(".r-pending").show();
	} else {
		$(".r-pending").hide();
		$("#m_waistline").val("");
		$("#m_cholesterol").val("");
		$("#m_triglycerides").val("");
		$("#m_fbs").val("");
		$("#m_sgpt").val("");
		$("#m_sgot").val("");
		$("#m_ldl").val("");
		$("#m_hdl").val("");
		$("#m_bp").val("");
		$("#m_specimen_ailment").val();
	}
});