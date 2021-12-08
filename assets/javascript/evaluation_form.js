let add_input;
let sub_input;

$(function () {
	formVessel("ef_vessel");
});

$("#evaluation_form").submit(function () {
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
				url: base_url + "save-evaluation-form",
				type: "POST",
				data: $("#evaluation_form").serialize(),
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

function printEvaluationFormPdf() {
	code = $("#applicant-code-hidden").val();
	window.open(base_url + "print-evaluation-applicant-pdf" + "/" + code);
}

function printEvaluationFormXl() {
	code = $("#applicant-code-hidden").val();
	window.open(base_url + "print-evaluation-applicant-xl" + "/" + code);
}

function showEvaluationForm(code) {
	evaluationFormApplicant(code);
	evaluationFormPersonalInfo(code);
	evaluationFormSheet(code);
}

function evaluationFormApplicant(code) {
	$.ajax({
		url: base_url + "get-applicants",
		type: "POST",
		data: {
			applicant_code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#ef_applicant_code").val(data.applicant_code);
			$("#ef_crew_code").val(data.crew_code);
			$("#ef_vessel").val(data.assign_vessel);

			if (data.position_first) {
				$("#ef_rank").append(
					new Option(formatPosition(data.position_first), data.position_first)
				);
			}

			if (data.position_second != 0) {
				$("#ef_rank").append(
					new Option(formatPosition(data.position_second), data.position_second)
				);
			}

			$("#ef_rank").change(function () {
				var table = $("#evaluation_form_modal").find(".table-responsive");

				if (this.value) {
					$.ajax({
						url: base_url + "get-evaluation-value",
						type: "POST",
						data: {
							id: this.value,
						},
						success: function (data) {
							if (data) {
								var evaluations = JSON.parse(data.evaluations);

								if (evaluations) {
									table.find(".min_age").text(evaluations.min_age);
									table.find(".tob_period").text(evaluations.tob_period);
									table.find(".sks_skr").text(evaluations.sks_skr);
									table.find(".skor_standard").text(evaluations.skor_standard);
									table.find(".age_standard").text(evaluations.age_standard);
								}
							}
						},
					});

					getEvaluationSheet(this.value);
				} else {
					table.find(".min_age").text("18-45");
					table.find(".tob_period").text("EXCESS 1 YEAR");
					table
						.find(".sks_skr")
						.html("MORE THAN 6 MONTHS PER 1 TIME <br>/ MORE THAN 6 MONTHS");
					table.find(".skor_standard").text("EXCESS 1 YEAR");
					table.find(".age_standard").text("40");

					table.find(".add_point").html("");
					table.find(".sub_point").html("");
					table.find(".detail_input").html("");
					table.find(".score_input input").remove();
				}
			});

			if (data.approved_position) {
				$("#ef_rank").val(data.approved_position);
				$("#ef_rank").change();
			}

			getEvaluationSheet(data.approved_position);
		},
	});
}

function evaluationFormPersonalInfo(code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#ef_name").val(data.first_name + " " + data.last_name);
			$("#ef_nationality").val(
				formatNationality(data.nationality).toUpperCase()
			);
			$("#eval_applicant_name").html(
				data.first_name + " " + data.middle_name + " " + data.last_name
			);

			$("#ef_age").val(getAge(data.birth_date));
			$("#ef_bmi").val(formatBMI(data.height, data.weight).toFixed(2));
		},
	});
}

function evaluationFormSheet(code) {
	$.ajax({
		url: base_url + "get-evaluation-sheet",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data) {
				let details = JSON.parse(data.details);
				let scores = JSON.parse(data.scores);

				$("#ef_total_board").val(data.total_board);
				$("#ef_same_ship").val(data.same_ship);
				$("#ef_short_board").val(data.short_board);
				$("#ef_mixed_crew").val(data.mixed_crew);
				$("#ef_interview").val(data.interview);
				$("#applicant-code-hidden").val(code);

				var input_details = document.getElementsByName("detail[]");
				var input_scores = document.getElementsByName("score[]");

				setTimeout(() => {
					for (let index = 0; index < input_details.length; index++) {
						input_details[index].value = details[index];
					}

					for (let index = 0; index < input_scores.length; index++) {
						input_scores[index].value = scores[index];
					}
				}, 1000);

				$("#addtional_point_score").val(data.additional_score);

				if (data.additional_detail === "PASSED") {
					$("#additional_point_detail")
						.val(data.additional_detail)
						.css({ color: "#23b397", "font-weight": "500" });
				} else {
					$("#additional_point_detail")
						.val(data.additional_detail)
						.css({ color: "#ed6d4b", "font-weight": "500" });
				}

				$("#substract_point_score").val(data.substract_score);

				if (data.substract_detail === "PASSED") {
					$("#substract_point_detail")
						.val(data.substract_detail)
						.css({ color: "#23b397", "font-weight": "500" });
				} else {
					$("#substract_point_detail")
						.val(data.substract_detail)
						.css({ color: "#ed6d4b", "font-weight": "500" });
				}

				$("#eval_score").val(
					Number(data.additional_score) + Number(data.substract_score)
				);

				if (data.final_evaluation === "PASSED") {
					$("#eval_final")
						.val(data.final_evaluation)
						.css({ color: "#23b397", "font-weight": "500" });
				} else {
					$("#eval_final")
						.val(data.final_evaluation)
						.css({ color: "	", "font-weight": "500" });
				}

				if (
					data.additional_detail != "" &&
					data.substract_detail != "" &&
					data.final_evaluation != ""
				) {
					$("#eval_form_icon").attr(
						"class",
						"mdi mdi-checkbox-marked-circle font-16 text-success"
					);
				} else if (
					data.additional_detail != null &&
					data.substract_detail != null &&
					data.final_evaluation != null
				) {
					$("#eval_form_icon").attr(
						"class",
						"mdi mdi-checkbox-marked-circle font-16 text-success"
					);
				}
			}
		},
	});
}

function getEvaluationSheet(position) {
	$.ajax({
		url: base_url + "get-position-details",
		type: "POST",
		data: {
			id: position,
		},
		dataType: "JSON",
		success: function (data) {
			if (data) {
				let additional_point = JSON.parse(data.additional_point);
				let subtract_point = JSON.parse(data.subtract_point);

				add_input = 1;
				sub_input = 1;

				for (let index = 0; index < additional_point.length; index++) {
					$("#add_point_" + (index + 1)).html(additional_point[index]);

					if (additional_point[index]) {
						$("#score_input_" + (index + 1)).html(
							'<input type="number" class="form-control text-center font-weight-medium text-uppercase" id="score_add_' +
								add_input +
								'" name="score[]" onkeyup="computeEvaluationSheet()" onchange="computeEvaluationSheet()" value="0">'
						);

						$("#detail_input_" + (index + 1)).html(
							'<input type="text" class="form-control text-center font-weight-medium text-uppercase" id="detail_add_' +
								add_input +
								'" name="detail[]">'
						);

						add_input++;
					}
				}

				for (let index = 0; index < subtract_point.length; index++) {
					$("#sub_point_" + (index + 1)).html(subtract_point[index]);

					if (subtract_point[index]) {
						$("#score_input_" + (index + 1)).html(
							'<input type="number" class="form-control text-center font-weight-medium text-uppercase" id="score_sub_' +
								sub_input +
								'" name="score[]" onkeyup="computeEvaluationSheet()" onchange="computeEvaluationSheet()" value="0">'
						);

						$("#detail_input_" + (index + 1)).html(
							'<input type="text" class="form-control text-center font-weight-medium text-uppercase" id="detail_sub_' +
								sub_input +
								'" name="detail[]">'
						);

						sub_input++;
					}
				}
			}
		},
	});
}

function computeEvaluationSheet() {
	var add_points = 0;
	var sub_points = 0;

	for (let index = 1; index < add_input; index++) {
		add_points += Number($("#score_add_" + index).val());
	}

	$("#addtional_point_score").val(add_points);

	for (let index = 1; index < sub_input; index++) {
		sub_points += Number($("#score_sub_" + index).val());
	}

	$("#substract_point_score").val(sub_points);

	if (Number(add_points) > 25) {
		$("#additional_point_detail")
			.val("PASSED")
			.css({ color: "#23b397", "font-weight": "500" });
	} else {
		$("#additional_point_detail")
			.val("FAILED")
			.css({ color: "#ed6d4b", "font-weight": "500" });
	}

	if (Number(sub_points) < -15) {
		$("#substract_point_detail").val("FAILED").css({
			color: "#ed6d4b",
			"font-weight": "500",
		});
	} else {
		$("#substract_point_detail").val("PASSED").css({
			color: "#23b397",
			"font-weight": "500",
		});
	}

	$("#eval_score").val(Number(add_points) + Number(sub_points));

	if (
		$("#additional_point_detail").val() == "PASSED" &&
		$("#substract_point_detail").val() == "PASSED"
	) {
		$("#eval_final").val("PASSED").css({
			color: "#23b397",
			"font-weight": "600",
		});
	} else {
		$("#eval_final").val("FAILED").css({
			color: "#ed6d4b",
			"font-weight": "600",
		});
	}
}

function printEvaluationForm() {
	$("#choosePrintModal").modal("show");
	$("#BtnEvaluation").show();
	$("#BtnEvaluationXl").show();
}
