function showGeneralForm(code) {
	$("#gi_applicant_code").val(code);
	getGeneralInterviewForm();

	setTimeout(() => {
		getGeneralInterview(code);
	}, 1000);
	PersonalInfo(code);
}
function printGeneralForm() {
	$("#choosePrintModal").modal("show");
	$("#BtnGeneral").show();
	$("#BtnGeneralXl").show();
}
function printGeneralFormPdf(applicant_code) {
	var applicant_code = $("#gi_applicant_code").val();
	window.open(
		base_url + "print-general-applicant" + "/" + applicant_code + "/" + "pdf"
	);
}
function printGeneralFormXl(applicant_code) {
	var applicant_code = $("#gi_applicant_code").val();
	window.open(
		base_url + "print-general-applicant" + "/" + applicant_code + "/" + "xl"
	);
}
function getGeneralInterviewForm() {
	$.ajax({
		url: base_url + "get-general-interview-form",
		type: "GET",
		dataType: "HTML",
		success: function (data) {
			$("#list_of_general_form").html(data);
		},
	});
}

function getGeneralInterview(code) {
	$.ajax({
		url: base_url + "get-general-interviews",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data) {
				let scores = JSON.parse(data.scores);
				let remarks = JSON.parse(data.remarks);

				for (let index = 0; index < scores.length; index++) {
					$("#score_general_" + index).val(scores[index]);

					switch (scores[index]) {
						case "10":
							$("#radio_one_" + index).prop("checked", true);
							break;

						case "8.5":
							$("#radio_two_" + index).prop("checked", true);
							break;

						case "7":
							$("#radio_three_" + index).prop("checked", true);
							break;

						case "5":
							$("#radio_four_" + index).prop("checked", true);
							break;
					}
				}

				for (let index = 0; index < remarks.length; index++) {
					$("#remarks_general_" + index).val(remarks[index]);
				}

				$("#total_interview_general").val(data.total_score);
				$("#final_interview_general").val(data.final_result);

				if (data.final_result === "PASSED") {
					$("#final_interview_general").val(data.final_result).css({
						color: "#23b397",
						"font-weight": "500",
					});
				} else {
					$("#final_interview_general").val(data.final_result).css({
						color: "#ed6d4b",
						"font-weight": "500",
					});
				}

				$("#final_remark_general").val(data.final_remark);

				if (data.final_result != null && data.total_score != null) {
					$("#gen_form_icon").attr(
						"class",
						"mdi mdi-checkbox-marked-circle font-16 text-success"
					);
				} else {
					$("#gen_form_icon").attr(
						"class",
						"mdi mdi-checkbox-marked-circle font-16 text-success"
					);
				}
			}
		},
	});
}

function computeGeneralInterview() {
	let general_interview;
	let gen_score = [];
	let score_int_gen = 0;

	$.ajax({
		url: base_url + "get-general-interview",
		type: "GET",
		async: false,
		dataType: "JSON",
		success: function (data) {
			general_interview = data;
		},
	});

	for (let index = 0; index < general_interview.length; index++) {
		gen_score[index] = Number(
			$("input[name='radio_" + index + "']:checked").val()
		);
	}

	for (let index = 0; index < general_interview.length; index++) {
		if ($("input[name='radio_" + index + "']").is(":checked")) {
			$("#score_general_" + index).val(gen_score[index]);
		} else {
			$("#score_general_" + index).val("0");
		}
	}

	for (let index = 0; index < gen_score.length; index++) {
		if ($("input[name='radio_" + index + "']").is(":checked")) {
			score_int_gen += Number(gen_score[index]);
		}
	}

	$("#total_interview_general").val(score_int_gen);
	var total_gen_int = (score_int_gen / (gen_score.length * 10)) * 100;

	if (total_gen_int > 74) {
		$("#final_interview_general").val("PASSED").css({
			color: "#23b397",
			"font-weight": "500",
		});
	} else {
		$("#final_interview_general").val("FAILED").css({
			color: "#ed6d4b",
			"font-weight": "500",
		});
	}
}

$("#general_interview_form").submit(function () {
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
				url: base_url + "save-general-interview",
				type: "POST",
				data: $("#general_interview_form").serialize(),
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
					} else {
						Swal.fire({
							icon: data.type,
							title: data.title,
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

function PersonalInfo(code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#general_applicant_name").html(
				data.first_name + " " + data.middle_name + " " + data.last_name
			);
		},
	});
}
