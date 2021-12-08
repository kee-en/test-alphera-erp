function showTechnicalForm(code) {
	getTechnicalInterviewPersonalInfo(code);
	getTechnicalInterviewForm(code);

	setTimeout(() => {
		getTechnicalInterview(code);
	}, 1000);
}

function getTechnicalInterviewPersonalInfo(code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#ti_applicant_name").html(
				data.first_name + " " + data.middle_name + " " + data.last_name
			);
			$("#ti_applicant_code").val(data.applicant_code);
			$("#ti_crew_code").val(data.crew_code);
		},
	});
}

function getTechnicalInterviewForm(code) {
	$.ajax({
		url: base_url + "get-technical-interview-form",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "HTML",
		success: function (data) {
			$("#list_of_technical_form").html(data);
		},
	});
}

function getTechnicalInterview(code) {
	$.ajax({
		url: base_url + "get-technical-interview",
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
					$("#score_technical_" + index).val(scores[index]);

					switch (scores[index]) {
						case "5":
							$("#t_radio_one_" + index).prop("checked", true);
							break;

						case "4":
							$("#t_radio_two_" + index).prop("checked", true);
							break;

						case "3":
							$("#t_radio_three_" + index).prop("checked", true);
							break;

						case "2":
							$("#t_radio_four_" + index).prop("checked", true);
							break;
					}
				}

				for (let index = 0; index < remarks.length; index++) {
					$("#remarks_technical_" + index).val(remarks[index]);
				}

				$("#total_interview_technical").val(data.total_score);

				if (data.final_result === "PASSED") {
					$("#final_interview_technical").val(data.final_result).css({
						color: "#23b397",
						"font-weight": "500",
					});
				} else {
					$("#final_interview_technical").val(data.final_result).css({
						color: "#ed6d4b",
						"font-weight": "500",
					});
				}

				$("#final_remark_technical").val(data.final_remark);

				if (data.final_result != null && data.total_score != null) {
					$("#tech_form_icon").attr(
						"class",
						"mdi mdi-checkbox-marked-circle font-16 text-success"
					);
				} else {
					$("#tech_form_icon").attr(
						"class",
						"mdi mdi-checkbox-marked-circle font-16 text-success"
					);
				}
			}
		},
	});
}

function computeTechnicalInterview() {
	let tech_score = [];
	let score_tech_gen = 0;

	var total_input = $('input[name="t_score_technical[]"]').length;

	for (let index = 0; index < total_input; index++) {
		tech_score[index] = $("input[name='t_radio_" + index + "']:checked").val();
	}

	for (let index = 0; index < total_input; index++) {
		if ($("input[name='t_radio_" + index + "']").is(":checked")) {
			$("#score_technical_" + index).val(tech_score[index]);
		} else {
			$("#score_technical_" + index).val("0");
		}
	}

	for (let index = 0; index < tech_score.length; index++) {
		if ($("input[name='t_radio_" + index + "']").is(":checked")) {
			score_tech_gen += Number(tech_score[index]);
		}
	}

	var total_tech_int = (score_tech_gen / (tech_score.length * 5)) * 100;

	$("#total_interview_technical").val(total_tech_int.toFixed());
	if (total_tech_int > 75) {
		$("#final_interview_technical").val("PASSED").css({
			color: "#23b397",
			"font-weight": "500",
		});
	} else {
		$("#final_interview_technical").val("FAILED").css({
			color: "#ed6d4b",
			"font-weight": "500",
		});
	}
}

$("#technical_interview_form").submit(function () {
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
				url: base_url + "save-technical-interview",
				type: "POST",
				data: $("#technical_interview_form").serialize(),
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

function printTechnicalForm() {
	$("#choosePrintModal").modal("show");
	$("#BtnTechnical").show();
	$("#BtnTechnicalXl").show();
}

function printTechnicalFormPdf(applicant_code) {
	var applicant_code = $("#ti_applicant_code").val();
	window.open(
		base_url + "print-technical-form" + "/" + applicant_code + "/" + "pdf"
	);
}
function printTechnicalFormXl(applicant_code) {
	var applicant_code = $("#ti_applicant_code").val();
	window.open(
		base_url + "print-technical-form" + "/" + applicant_code + "/" + "xl"
	);
}
