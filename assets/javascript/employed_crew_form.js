$(function () {
	formVessel("ec_vessel");
	formAllPosition("ec_rank");
});

function showEmployedCrewForm(code) {
	getEmployedCrewApplicant(code);
	getEmployedCrewPersonalInfo(code);
	getEmployedCrewNextKin(code);
	getEmployedCrewEducation(code);
	getEmployedCrew(code);
}

function getEmployedCrewApplicant(code) {
	$.ajax({
		url: base_url + "get-applicants",
		type: "POST",
		data: {
			applicant_code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#ec_applicant_code").val(data.applicant_code);
			$("#ec_crew_code").val(data.crew_code);
			$("#ec_vessel").val(data.assign_vessel);
			$("#ec_rank").val(data.approved_position);
			$("#ec_status").val(data.status);

			if (data.status === "2") {
				$("#second_assessor_tr").hide();
			} else {
				$("#ec_first_interview_result").prop("disabled", true);
			}
		},
	});
}

function getEmployedCrewPersonalInfo(code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#ecf_applicant_name").html(
				data.first_name + " " + data.middle_name + " " + data.last_name
			);
			$("#ec_name").val(data.first_name + " " + data.last_name);
			$("#ec_date_of_birth").val(data.birth_date);
			$("#ec_bmi").val(formatBMI(data.height, data.weight).toFixed(2));

			if (data.civil_status === "2") {
				$("#ec_married").val("Yes");
			} else {
				$("#ec_married").val("No");
			}
		},
	});
}

function getEmployedCrewNextKin(code) {
	$.ajax({
		url: base_url + "get-next-of-kin",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data.no_of_children === "") {
				$("#ec_no_of_children").val("0");
			} else {
				$("#ec_no_of_children").val(data.no_of_children);
			}
		},
	});
}

function getEmployedCrewEducation(code) {
	$.ajax({
		url: base_url + "get-educational-attainment",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#ec_school").val(data.school);
		},
	});
}

function getEmployedCrew(code) {
	$.ajax({
		url: base_url + "get-employed-crew",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#ec_check_point").val(data.check_point);
			$("#ec_service_record_ttl").val(data.service_record_ttl);
			$("#ec_service_record_rank").val(data.service_record_rank);
			$("#ec_previous_manning_company").val(data.previous_manning_company);
			$("#ec_reputation").val(data.reputation);
			$("#ec_transfer").val(data.transfer);
			$("#ec_carrier").val(data.carrier);
			$("#ec_exp_korean_crew").val(data.experience_with_korean_crew);
			$("#ec_past_injuries").val(data.history_of_past_injuries);
			$("#ec_past_disease").val(data.history_of_past_diseases);
			$("#ec_leave_of_absence").val(data.leave_of_absence);
			$("#ec_short_contract").val(data.short_contract);
			$("#ec_appearance").val(data.appearance);
			$("#ec_first_interview_result").val(data.first_interview_result);
			$("#ec_second_interview_result").val(data.second_interview_result);
		},
	});
}

$("#employed_crew_form").submit(function () {
	Swal.fire({
		title: "Are you sure you want to save?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, save it!",
	}).then((result) => {
		if (result.value) {
			$("#employed_crew_form")
				.find("input,select,textarea")
				.prop("disabled", false);

			$.ajax({
				url: base_url + "save-employed-crew-form",
				type: "POST",
				data: $("#employed_crew_form").serialize(),
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
});

function printEmployedForm() {
	$("#choosePrintModal").modal("show");
	$("#BtnEmployed").show();
	$("#BtnEmployedXl").show();
}
function printEmployedFormPdf(applicant_code) {
	var applicant_code = $("#ec_applicant_code").val();
	window.open(
		base_url + "print-employed-form" + "/" + applicant_code + "/" + "pdf"
	);
}
function printEmployedFormXl(applicant_code) {
	var applicant_code = $("#ec_applicant_code").val();
	window.open(
		base_url + "print-employed-form" + "/" + applicant_code + "/" + "xl"
	);
}
