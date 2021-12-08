$(function () {
	var num_of_kids = this.value;

	for (let i = 0; i < num_of_kids; i++) {
		$("#r_full_name_" + i).keyup(function () {
			$.ajax({
				url: base_url + "v-e-crew-info-validation",
				type: "POST",
				dataType: "JSON",
				data: $("#e_crew_info_form").serialize(),
				success: function (data) {
					validationInput(data.r_full_name, "r_full_name_" + i);
				},
			});
		});

		$("#r_birth_date_" + i).blur(function () {
			$.ajax({
				url: base_url + "v-e-crew-info-validation",
				type: "POST",
				dataType: "JSON",
				data: $("#e_crew_info_form").serialize(),
				success: function (data) {
					validationInput(data.r_birth_date, "r_birth_date_" + i);
				},
			});
		});

		$("#r_mobile_no_" + i).keyup(function () {
			$.ajax({
				url: base_url + "v-e-crew-info-validation",
				type: "POST",
				dataType: "JSON",
				data: $("#e_crew_info_form").serialize(),
				success: function (data) {
					validationInput(data.r_mobile_no, "r_mobile_no_" + i);
				},
			});
		});
	}
});

function btn_edit_crew_info() {
	$("#v_row_info").hide();
	$(".btn-edit").hide();
	$("#e_row_info").show();
	$(".btn-view").show();

	for (let index = 0; index < $("#e_no_of_children").val(); index++) {
		var id = index + 1;
		$("#rs" + id).show();
	}
}

function btn_view_crew_info() {
	$("#e_row_info").hide();
	$(".btn-view").hide();
	$("#v_row_info").show();
	$(".btn-edit").show();
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

$("#e_crew_info_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-crew-information",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_first_position, "e_first_position");
			validationInput(data.e_source_location1, "e_source_location1");
			validationInput(data.e_recommended_name, "e_recommended_name");

			validationInput(data.e_first_name, "e_first_name");
			validationInput(data.e_last_name, "e_last_name");
			validationInput(data.e_birth_date, "e_birth_date");
			validationInput(data.e_birth_place, "e_birth_place");
			validationInput(data.e_date_available, "e_date_available");
			validationInput(data.e_civil_status, "e_civil_status");
			validationInput(data.e_email_address, "e_email_address");
			validationInput(data.e_mobile_number, "e_mobile_number");
			validationInput(data.e_religion, "e_religion");
			validationInput(data.e_nationality, "e_nationality");
			validationInput(data.e_sss_no, "e_sss_no");
			validationInput(data.e_tin_no, "e_tin_no");
			validationInput(data.e_philhealth_no, "e_philhealth_no");
			validationInput(data.e_pag_ibig_no, "e_pag_ibig_no");
			validationInput(data.e_height, "e_height");
			validationInput(data.e_weight, "e_weight");
			validationInput(data.e_home_address, "e_home_address");
			validationInput(data.e_province, "e_province");
			validationInput(data.e_city, "e_city");
			validationInput(data.e_country, "e_country");
			validationInput(data.e_father_name, "e_father_name");
			validationInput(data.e_mother_name, "e_mother_name");
			validationInput(data.e_kin_address, "e_kin_address");
			validationInput(data.e_course, "e_course");
			validationInput(data.e_school_name, "e_school_name");
			validationInput(data.e_inclusive_years_from, "e_inclusive_years_from");
			validationInput(data.e_inclusive_years_to, "e_inclusive_years_to");
			validationInput(data.e_school_address, "e_school_address");

			Swal.fire({
				icon: data.type,
				title: data.title,
				confirmButtonText: "Close",
				allowOutsideClick: false,
				allowEscapeKey: false,
			}).then(function () {
				if (data.type === "success") {
					location.reload(true);
				}
			});
		},
	});
});

$("#e_no_of_children").on("change", function () {
	for (let index = 0; index < this.value; index++) {
		var i = index + 1;
		$("#rs" + i).show();
	}
});

//Input Validation
$("#e_recommended_name").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_recommended_name, "e_recommended_name");
		},
	});
});
$("#e_first_name").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_first_name, "e_first_name");
		},
	});
});
$("#e_last_name").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_last_name, "e_last_name");
		},
	});
});
$("#e_birth_date").blur(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_birth_date, "e_birth_date");
		},
	});
});

$("#e_birth_place").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_birth_place, "e_birth_place");
		},
	});
});
$("#e_civil_status").change(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_civil_status, "e_civil_status");
		},
	});
});
$("#e_email_address").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_email_address, "e_email_address");
		},
	});
});
$("#e_mobile_number").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_mobile_number, "e_mobile_number");
		},
	});
});
$("#e_religion").change(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_religion, "e_religion");
		},
	});
});
$("#e_nationality").change(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_nationality, "e_nationality");
		},
	});
});
$("#e_sss_no").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_sss_no, "s_sss_no");
		},
	});
});
$("#e_tin_no").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_tin_no, "e_tin_no");
		},
	});
});
$("#e_philhealth_no").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_philhealth_no, "e_philhealth_no");
		},
	});
});
$("#e_pag_ibig_no").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_pag_ibig_no, "e_pag_ibig_no");
		},
	});
});
$("#e_height").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_height, "e_height");
		},
	});
});
$("#e_weight").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_weight, "e_weight");
		},
	});
});
$("#e_home_address").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_home_address, "e_home_address");
		},
	});
});
$("#e_barangay").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_barangay, "e_barangay");
		},
	});
});
$("#e_province").change(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_province, "e_province");
		},
	});
});
$("#e_city").change(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_city, "e_city");
		},
	});
});
$("#e_country").change(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_country, "e_country");
		},
	});
});
$("#e_father_name").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_father_name, "e_father_name");
		},
	});
});
$("#e_mother_name").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_mother_name, "e_mother_name");
		},
	});
});
$("#e_kin_address").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_kin_address, "e_kin_address");
		},
	});
});
$("#e_course").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_course, "e_course");
		},
	});
});
$("#e_school_name").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_school_name, "e_school_name");
		},
	});
});

$("#e_inclusive_years_from").blur(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_inclusive_years_from, "e_inclusive_years_from");
		},
	});
});
$("#e_inclusive_years_to").blur(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_inclusive_years_to, "e_inclusive_years_to");
		},
	});
});

$("#e_school_address").keyup(function () {
	$.ajax({
		url: base_url + "v-e-crew-info-validation",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
		success: function (data) {
			validationInput(data.e_school_address, "e_school_address");
		},
	});
});
