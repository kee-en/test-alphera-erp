$(function () {
	formAllPosition("is_position_final");
	formVessel("is_type_vessel_final");
});
function showInterviewSheet(code) {
	interviewSheetApplicant(code);
	interviewSheetPersonalInfo(code);
	interviewSheetSeaService(code);
	interviewSheetGeneral(code);
	interviewSheetTechnical(code);
	interviewSheet(code);
	$("#interview_sheet_form")[0].reset();
}

$("#interview_sheet_form").submit(function () {
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
			$.ajax({
				url: base_url + "save-interview-sheet",
				type: "POST",
				data: $("#interview_sheet_form").serialize(),
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
					} else if (data.type === "warning") {
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

function interviewSheet(code) {
	$.ajax({
		url: base_url + "get-interview-sheet",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data) {
				$("#is_required_no_of_crew").val(data.req_no_crew);
				$("#is_present_no_of_crew").val(data.present_no_crew);
				$("#is_crew_excess_or_shortage").val(data.excess_shortage);
				$("#is_applicant_name_one").val(data.korean_name);
				$("#is_applicant_name_two").val(data.chinese_name);
				$("#is_kind_of_coc").val(data.kind_coc);

				switch (data.exp_analysis_vt) {
					case "1":
						$("#is_one_eavt").prop("checked", true);
						break;

					case "2":
						$("#is_one_eavt").prop("checked", true);
						break;

					case "3":
						$("#is_three_eavt").prop("checked", true);
						break;
				}

				switch (data.age_limit) {
					case "1":
						$("#is_one_age_limitation").prop("checked", true);
						break;

					case "2":
						$("#is_two_age_limitation").prop("checked", true);
						break;
				}

				switch (data.license_certification) {
					case "1":
						$("#is_one_license_cert").prop("checked", true);
						break;

					case "2":
						$("#is_two_license_cert").prop("checked", true);
						break;
				}

				switch (data.physical_exam) {
					case "1":
						$("#is_one_physical_exam").prop("checked", true);
						break;

					case "2":
						$("#is_two_physical_exam").prop("checked", true);
						break;
				}

				switch (data.ability_eng) {
					case "1":
						$("#is_one_ability_english").prop("checked", true);
						break;

					case "2":
						$("#is_two_ability_english").prop("checked", true);
						break;
				}

				$("#is_previous_company").val(data.assess_prev_company);
				$("#is_related_seniority").val(data.seniority);
				if (data.first_decision) {
					$(".first_name_assessor").html(
						getUserDetails(data.first_assessor).full_name
					);
					switch (data.first_decision) {
						case "1":
							$("#is_first_assessor_app").prop("checked", true);
							break;

						case "2":
							$("#is_first_assessor_dis").prop("checked", true);
							break;
					}

					$("#is_first_remark").val(data.first_remarks).prop("disabled", true);

					$("#is_first_assessor_app").prop("disabled", true);
					$("#is_first_assessor_dis").prop("disabled", true);

					$("#second_assessor_fields").removeAttr("style");
				}

				if (data.second_decision) {
					$(".second_name_assessor").html(
						getUserDetails(data.second_assessor).full_name
					);

					switch (data.second_decision) {
						case "1":
							$("#is_second_assessor_app").prop("checked", true);
							break;

						case "2":
							$("#is_second_assessor_dis").prop("checked", true);
							break;
					}

					$("#is_second_remark")
						.val(data.second_remarks)
						.prop("disabled", true);

					$("#is_second_assessor_app").prop("disabled", true);
					$("#is_second_assessor_dis").prop("disabled", true);
				}

				if (data.final_decision) {
					$("#is_final_name_assessor").val(data.final_assessor);

					switch (data.final_decision) {
						case "1":
							$("#is_final_assessor_app").prop("checked", true);
							break;

						case "2":
							$("#is_final_assessor_dis").prop("checked", true);
							break;
					}

					$("#is_final_remark").val(data.final_remarks).prop("disabled", true);

					$("#is_final_assessor_app").prop("disabled", true);
					$("#is_final_assessor_dis").prop("disabled", true);
				}
			}
		},
	});
}

function interviewSheetApplicant(code) {
	$.ajax({
		url: base_url + "get-applicants",
		type: "POST",
		data: {
			applicant_code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#is_applicant_code").val(data.applicant_code);
			$("#is_crew_code").val(data.crew_code);
			$("#is_status").val(data.status);

			$("#type_of_vsl_1").val(data.assign_vessel);
			$("#type_of_vsl_1_name").html(
				formatVessel(data.assign_vessel),
				$("#type_of_vsl_1").prop("checked", true)
			);
			$("#type_of_vsl_label").html(
				formatVesselTypeByVessel(data.assign_vessel)
			);

			if (data.position_first === data.approved_position) {
				$("#first_choice_position").prop("checked", true);
				$("#first_choice_position").val(data.position_first);
				$("#first_choice_position_name").html(
					formatPosition(data.position_first)
				);
			} else {
				$("#first_choice_position").hide();
				$("#first_choice_position_name").html();
				$("#first_choice_position_name").hide();
				$("#first_choice_position").val("");
			}

			if (data.position_second === data.approved_position) {
				$("#second_choice_position").prop("checked", true);
				$("#second_choice_position").val(data.position_second);
				$("#second_choice_position_name").html(
					formatPosition(data.position_second)
				);
			} else {
				$("#second_choice_position").hide();
				$("#second_choice_position_name").html();
				$("#second_choice_position_name").hide();
				$("#second_choice_position").val("");
			}

			if (data.status === "4") {
				$("#final_assessor_fields").show();
			}

			$("#is_position_final").val(data.approved_position);
			$("#is_type_vessel_final").val(data.assign_vessel);
		},
	});
}

function interviewSheetPersonalInfo(code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#is_applicant_name_three").val(data.first_name + " " + data.last_name);
			$("#is_birth_date").val(data.birth_date);
			$("#interview_applicant_name").html(
				data.first_name + " " + data.middle_name + " " + data.last_name
			);
		},
	});
}

function interviewSheetSeaService(code) {
	$.ajax({
		url: base_url + "get-sea-service-record",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			let rank = JSON.parse(data.rank);
			let type_eng = JSON.parse(data.type_of_vsl_eng);
			let embarked = JSON.parse(data.embarked);
			let disembarked = JSON.parse(data.disembarked);

			$("#is_position_last_vessel").val(formatPosition(rank[rank.length - 1]));

			if (type_eng[type_eng.length - 1]) {
				$("#bulk_vessel_1").val(type_eng[type_eng.length - 1]);
			}
			if (type_eng[type_eng.length - 2]) {
				$("#bulk_vessel_2").val(type_eng[type_eng.length - 2]);
			}
			if (type_eng[type_eng.length - 3]) {
				$("#bulk_vessel_3").val(type_eng[type_eng.length - 3]);
			}
			if (type_eng[type_eng.length - 4]) {
				$("#bulk_vessel_4").val(type_eng[type_eng.length - 4]);
			}

			if (rank[rank.length - 1]) {
				$("#bulk_position_1").val(formatPosition(rank[rank.length - 1]));
			}
			if (rank[rank.length - 2]) {
				$("#bulk_position_2").val(formatPosition(rank[rank.length - 2]));
			}
			if (rank[rank.length - 3]) {
				$("#bulk_position_3").val(formatPosition(rank[rank.length - 3]));
			}
			if (rank[rank.length - 4]) {
				$("#bulk_position_4").val(formatPosition(rank[rank.length - 4]));
			}

			$("#bulk_record_1").val(
				getDateDuration(
					embarked[embarked.length - 1],
					disembarked[disembarked.length - 1]
				)
			);

			$("#bulk_record_2").val(
				getDateDuration(
					embarked[embarked.length - 2],
					disembarked[disembarked.length - 2]
				)
			);
			$("#bulk_record_3").val(
				getDateDuration(
					embarked[embarked.length - 3],
					disembarked[disembarked.length - 3]
				)
			);

			$("#bulk_record_4").val(
				getDateDuration(
					embarked[embarked.length - 4],
					disembarked[disembarked.length - 4]
				)
			);

			$("#total_service_one1").val(
				getTotalServiceDuration(embarked, disembarked)
			);

			if ($("#na_one").val() === 1) {
				$("#total_service_one").prop("readonly", false);
				$("#total_service_one").val("N/A");
			}
		},
	});
}

function interviewSheetGeneral(code) {
	$.ajax({
		url: base_url + "get-general-interviews",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#is_score_general").val(data.total_score);

			if (data.final_result == "PASSED") {
				$("#is_decision_general_1").prop("checked", true);
			} else if (data.final_result == "FAILED") {
				$("#is_decision_general_0").prop("checked", false);
			}

			$("#is_remark_general").val(data.final_remark);

			$("#is_evaluator_general").val(
				getUserDetails(data.assessed_by).full_name
			);
		},
	});
}

function interviewSheetTechnical(code) {
	$.ajax({
		url: base_url + "get-technical-interview",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data) {
				$("#is_score_technical").val(data.total_score);

				if (data.final_result == "PASSED") {
					$("#is_decision_technical_1").prop("checked", true);
				} else if (data.final_result == "FAILED") {
					$("#is_decision_technical_0").prop("checked", true);
				}

				$("#is_remark_technical").val(data.final_remark);
				$("#is_evaluator_technical").val(
					getUserDetails(data.assessed_by).full_name
				);
			}
		},
	});
}

$("#is_first_assessor_app").on("click", function () {
	var assessor = $("#is_assessor_code").val();
	$(".first_name_assessor").html(getUserDetails(assessor).full_name);
});
$("#is_first_assessor_dis").on("click", function () {
	var assessor = $("#is_assessor_code").val();
	$(".first_name_assessor").html(getUserDetails(assessor).full_name);
});

$("#is_second_assessor_app").on("click", function () {
	var assessor = $("#is_assessor_code").val();
	$(".second_name_assessor").html(getUserDetails(assessor).full_name);
});
$("#is_second_assessor_dis").on("click", function () {
	var assessor = $("#is_assessor_code").val();
	$(".second_name_assessor").html(getUserDetails(assessor).full_name);
});

// $("#is_final_assessor_app").on("click", function () {
// 	var assessor = $('#is_assessor_code').val();
// 	$("#is_final_name_assessor").val(
// 		getUserDetails(assessor).full_name
// 	);
// });

function printInterviewForm() {
	$("#choosePrintModal").modal("show");
	$("#BtnInterview").show();
	$("#BtnInterviewXl").show();
}
function printInterviewFormPdf(applicant_code) {
	var applicant_code = $("#is_applicant_code").val();
	window.open(
		base_url + "print-interview-form" + "/" + applicant_code + "/" + "pdf"
	);
}
function printInterviewFormXl(applicant_code) {
	var applicant_code = $("#is_applicant_code").val();
	window.open(
		base_url + "print-interview-form" + "/" + applicant_code + "/" + "xl"
	);
}
