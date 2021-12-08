function showNatResult(code, full_name) {
	$.ajax({
		url: base_url + "get-applicants",
		type: "POST",
		data: {
			applicant_code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#n_app_code").val(data.applicant_code);
			$("#n_aptitude_test_score").val(data.nat_result);
			$("#nat_applicant_name").html(full_name);
		},
	});
}

$("#nat_result_form").submit(function () {
	$.ajax({
		url: base_url + "add-nat-result",
		type: "POST",
		data: $("#nat_result_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			if (data.type === 'success') {
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					location.reload(true);
				});
			} else if (data.type === 'warning') {
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			}
			validationInput(data.n_aptitude_test_score, "n_aptitude_test_score");

		},
	});
});

$("#n_aptitude_test_score").keyup(function () {
	$.ajax({
		url: base_url + "nat-score-validation",
		type: "POST",
		data: $("#nat_result_form").serialize(),
		success: function (data) {
			validationInput(data.n_aptitude_test_score, "n_aptitude_test_score");
		},
	});
});