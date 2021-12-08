//Submits
$("#existing_application_form").submit(function () {

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
				url: base_url + "save-existing-crew-application",
				type: "POST",
				data: $("#existing_application_form").serialize(),
				dataType: "JSON",
				beforeSend: function () {
					$("#btnSubmitApplication").html(
						'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
					);
					$("#btnSubmitApplication").prop("disabled", true);
				},
				success: function (data) {
					validationInput(data.s_current_position, "s_current_position");
					validationInput(data.s_current_crew_status, "s_current_crew_status");
					validationInput(data.s_source_location, "s_source_location");
					validationInput(data.s_recommended_name, "s_recommended_name");
					validationInput(data.s_current_vessel, "s_current_vessel");
					validationInput(data.s_type_crew, "s_type_crew");
					validationInput(
						data.s_embark_onsigner_date,
						"s_embark_onsigner_date"
					);
					validationInput(
						data.s_disembark_onsigner_date,
						"s_disembark_onsigner_date"
					);

					validationInput(data.s_first_name, "s_first_name");
					validationInput(data.s_last_name, "s_last_name");
					validationInput(data.s_birth_date, "s_birth_date");
					validationInput(data.s_birth_place, "s_birth_place");
					validationInput(data.s_date_available, "s_date_available");
					validationInput(data.s_civil_status, "s_civil_status");
					validationInput(data.s_email_address, "s_email_address");
					validationInput(data.s_mobile_number, "s_mobile_number");
					validationInput(data.s_nationality, "s_nationality");
					validationInput(data.s_height, "s_height");
					validationInput(data.s_weight, "s_weight");
					validationInput(data.s_home_address, "s_home_address");
					validationInput(data.s_province, "s_province");
					validationInput(data.s_city, "s_city");
					validationInput(data.s_country, "s_country");
					validationInput(data.s_kin_address, "s_kin_address");
					validationInput(data.s_course, "s_course");
					validationInput(data.s_school_name, "s_school_name");
					validationInput(
						data.s_inclusive_years_from,
						"s_inclusive_years_from"
					);
					validationInput(data.s_inclusive_years_to, "s_inclusive_years_to");

					if (data.type === "success") {
						Swal.fire({
							icon: data.type,
							title: data.title,
							text: data.text,
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
							onClose: () => {
								location.reload(true);
							},
						});
					} else {
						Swal.fire({
							icon: data.type,
							title: data.title,
						});

						$('[href="#tab1"]').tab("show");

						// for (let i = 0; i < num_of_kids; i++) {
						// 	validationInput(data.r_full_name[i], "r_full_name_" + i);
						// 	validationInput(data.r_birth_date[i], "r_birth_date_" + i);
						// 	validationInput(data.r_mobile_no[i], "r_mobile_no_" + i);
						// }

						// Swal.fire({
						// 	icon: data.type,
						// 	title: data.title,
						// 	text: data.text,
						// 	confirmButtonText: "Close",
						// 	allowOutsideClick: false,
						// 	allowEscapeKey: false,
						// }).then(function () {
						// 	if (data.type === "success") {
						// 		location.reload();
						// 	}
						// });
					}

					$("#btnSubmitApplication").html("Submit Your Application");
					$("#btnSubmitApplication").prop("disabled", false);
				},
				complete: function () {
					$("#btnSubmitApplication").html("Submit Your Application");
					$("#btnSubmitApplication").prop("disabled", false);
				},
			});
		}
	});
});
