function moveCMPlan(code) {
	Swal.fire({
		title: "Are you sure you want to proceed this applicant to CM Plan as Crew?",
		icon: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
		allowEscapeKey: false,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, proceed it!",
	}).then((result) => {
		if (result.value) {
			$("#not_qualified_modal").modal("hide");
			$.ajax({
				url: base_url + "move-cm-plan",
				type: "POST",
				data: {
					applicant_code: code,
				},
				dataType: "JSON",
				success: function (data) {
					Swal.fire({
						title: "Success",
						text:
							"You successfully add the Applicant to the Alphera as New Crew. Go to the Crew List > All Crew to view the crew information and process the requirements before the onboarding.",
						icon: "success",
						confirmButtonText: "Close",
						allowOutsideClick: false,
						allowEscapeKey: false,
					}).then(function () {
						location.reload(true);
					});
				},
			});
		}
	});
}

$("#recruitment_filter_form").submit(function (data) {
	$.ajax({
		url: base_url + "search-passed",
		type: "POST",
		data: $("#recruitment_filter_form").serialize(),
		success: function (data) {
			location.reload(true);
		},
	});
});
$("#BtnResetSearchPassed").click(function () {
	$.ajax({
		url: base_url + "unset-search-passed",
		type: "POST",
		success: function (data) {
			location.reload(true);
		}
	});
});