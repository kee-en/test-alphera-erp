function dynamicBtnRemove() {
	setTimeout(() => {
		$("#r_sea_service_btn1").prop("disabled", !0);
	}, 1e3);
}
function addSeaService() {
	formSeaService("sea_service_record_fields"), totalservice();
}
function init_webcam() {
	$("#image-tag").hide(),
		Webcam.set({
			width: 300,
			height: 300,
			crop_width: 300,
			crop_height: 300,
			image_format: "jpeg",
			jpeg_quality: 90,
		}),
		Webcam.attach("#my_camera"),
		$("#my_camera").show(),
		$("#capture_container").show(),
		$("#init_container").hide();
}
function take_snapshot() {
	Webcam.snap(function (data_uri) {
		$("#my_camera").css("display", "none"),
			$("#image-tag").removeAttr("style"),
			$("#image-tag").attr("src", data_uri),
			$("#web_image").val(data_uri),
			checkInputHasImage();
	});
}
function retake_snapshot() {
	$("#capture_container").show(),
		$("#retake_container").hide(),
		$("#my_camera").removeAttr("style"),
		$("#image-tag").css("display", "none");
}
function checkInputHasImage() {
	let has_an_image;
	$("#web_image").val()
		? ($("#retake_container").removeClass("col-md-6"),
		  $("#retake_container").addClass("col-md-12"),
		  $("#retake_container").show(),
		  $("#capture_container").hide())
		: $("#capture_container").show();
}
$(function () {
	dynamicBtnRemove(),
		formAllPosition("s_first_position"),
		formCivilStatus("s_civil_status"),
		formReligion("s_religion"),
		formNationality("s_nationality"),
		formProvince("s_province"),
		// formLicenses("licenses_list"),
		formSeaService("sea_service_record_fields");
}),
	$("#s_first_position").change(function () {
		formByPosition("s_second_position", this.value),
			formLicensesPerPosition(
				this.value,
				$("#s_second_position").val(),
				"licenses_list"
			),
			formTrainingCertificate(
				this.value,
				$("#s_second_position").val(),
				"training_certificate_list"
			);
	}),
	$("#s_second_position").change(function () {
		formLicensesPerPosition(
			$("#s_first_position").val(),
			this.value,
			"licenses_list"
		),
			formTrainingCertificate(
				$("#s_first_position").val(),
				this.value,
				"training_certificate_list"
			);
	}),
	$("#s_height").keyup(function () {
		$("#s_bmi").val(formatBMI(this.value, $("#s_weight").val()).toFixed(2));
	}),
	$("#s_weight").keyup(function () {
		$("#s_bmi").val(formatBMI($("#s_height").val(), this.value).toFixed(2));
	}),
	$("#s_province").change(function () {
		formCity(this.value, "s_city");
	}),
	$("#application_form").submit(function () {
		Swal.fire({
			title: "Are you sure you want to save?",
			icon: "warning",
			allowOutsideClick: !1,
			allowEscapeKey: !1,
			showCancelButton: !0,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, save it!",
		}).then((result) => {
			result.value &&
				$.ajax({
					url: base_url + "save-new-applicant",
					type: "POST",
					data: $("#application_form").serialize(),
					beforeSend: function () {
						$("#btn_submit").html(
							'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
						);
					},
					success: function (data) {
						validationInput(data.s_first_position, "s_first_position"),
							validationInput(data.s_second_position, "s_second_position"),
							validationInput(data.s_source_location, "s_source_location"),
							validationInput(data.r_type_crew, "r_type_crew"),
							validationInput(data.s_first_name, "s_first_name"),
							validationInput(data.s_first_name, "s_first_name"),
							validationInput(data.s_last_name, "s_last_name"),
							validationInput(data.s_birth_date, "s_birth_date"),
							validationInput(data.s_birth_place, "s_birth_place"),
							validationInput(data.s_date_available, "s_date_available"),
							validationInput(data.s_civil_status, "s_civil_status"),
							validationInput(data.s_email_address, "s_email_address"),
							validationInput(data.s_mobile_number, "s_mobile_number"),
							validationInput(data.s_nationality, "s_nationality"),
							validationInput(data.s_height, "s_height"),
							validationInput(data.s_weight, "s_weight"),
							validationInput(data.s_home_address, "s_home_address"),
							validationInput(data.s_province, "s_province"),
							validationInput(data.s_city, "s_city"),
							validationInput(data.s_country, "s_country"),
							validationInput(data.s_kin_address, "s_kin_address"),
							validationInput(data.s_course, "s_course"),
							validationInput(data.s_school_name, "s_school_name"),
							validationInput(
								data.s_inclusive_years_from,
								"s_inclusive_years_from"
							),
							validationInput(
								data.s_inclusive_years_to,
								"s_inclusive_years_to"
							),
							validationInput(data.s_no_of_children, "s_no_of_children"),
							"success" === data.type
								? Swal.fire({
										icon: data.type,
										title: data.title,
										text: data.text,
										confirmButtonText: "Close",
										allowOutsideClick: !1,
										allowEscapeKey: !1,
								  }).then(function () {
										location.replace("registered-applicants");
								  })
								: (Swal.fire({ icon: data.type, title: data.title }),
								  $('[href="#tab1"]').tab("show")),
							$("#btn_submit").html("Submit Your Application");
					},
				});
		});
	}),
	$("#s_first_position").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_first_position, "s_first_position");
			},
		});
	}),
	$("#r_type_crew").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.r_type_crew, "r_type_crew");
			},
		});
	}),
	$("#s_second_position").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_second_position, "s_second_position");
			},
		});
	}),
	$("#s_source_location").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_source_location, "s_source_location");
			},
		});
	}),
	$("#s_recommended_name").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_recommended_name, "s_recommended_name");
			},
		});
	}),
	$("#s_first_name").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_first_name, "s_first_name");
			},
		});
	}),
	$("#s_last_name").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_last_name, "s_last_name");
			},
		});
	}),
	$("#s_birth_date").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_birth_date, "s_birth_date");
			},
		});
	}),
	$("#s_date_available").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_date_available, "s_date_available");
			},
		});
	}),
	$("#s_birth_place").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_birth_place, "s_birth_place");
			},
		});
	}),
	$("#s_civil_status").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_civil_status, "s_civil_status");
			},
		});
	}),
	$("#s_email_address").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_email_address, "s_email_address");
			},
		});
	}),
	$("#s_mobile_number").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_mobile_number, "s_mobile_number");
			},
		});
	}),
	$("#s_nationality").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_nationality, "s_nationality");
			},
		});
	}),
	$("#s_height").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_height, "s_height");
			},
		});
	}),
	$("#s_weight").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_weight, "s_weight");
			},
		});
	}),
	$("#s_home_address").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_home_address, "s_home_address");
			},
		});
	}),
	$("#s_barangay").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_barangay, "s_barangay");
			},
		});
	}),
	$("#s_province").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_province, "s_province");
			},
		});
	}),
	$("#s_city").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_city, "s_city");
			},
		});
	}),
	$("#s_country").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_country, "s_country");
			},
		});
	}),
	$("#s_kin_address").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_kin_address, "s_kin_address");
			},
		});
	}),
	$("#s_course").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_course, "s_course");
			},
		});
	}),
	$("#s_school_name").keyup(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_school_name, "s_school_name");
			},
		});
	}),
	$("#s_inclusive_years_from").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_inclusive_years_from, "s_inclusive_years_from");
			},
		});
	}),
	$("#s_inclusive_years_to").change(function () {
		$.ajax({
			url: base_url + "shipboard-application-validation",
			type: "POST",
			data: $("#application_form").serialize(),
			success: function (data) {
				validationInput(data.s_inclusive_years_to, "s_inclusive_years_to");
			},
		});
	});
