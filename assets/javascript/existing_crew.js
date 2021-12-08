let add_input;
let sub_input;

$(function () {
	// totalservice();
	disableBtn();
	formAllPosition("s_current_position");
	formVessel("s_current_vessel");
	formCivilStatus("s_civil_status");
	formReligion("s_religion");
	formNationality("s_nationality");
	formProvince("s_province");
	// formLicenses("licenses_list");
	formSeaService("sea_service_record_fields");
});

$(document).ready(function () {
	// getGeneralInterviewForm();
	$("#flight_table").DataTable({
		ajax: {
			url: base_url + "flight-monitoring-table",
			type: "GET",
		},
		language: {
			paginate: {
				previous: "<i class='mdi mdi-chevron-left'>",
				next: "<i class='mdi mdi-chevron-right'>",
			},
		},
		drawCallback: function () {
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		},
	});
});

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

// function totalservice() {
// 	var nums = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
// 	setTimeout(() => {
// 		for (let i = 0; i < nums.length; i++) {
// 			$("#s_disembarked" + i).change(function () {
// 				$.ajax({
// 					url: base_url + "get-total-sea-service",
// 					type: "POST",
// 					data: $("#existing_application_form").serialize(),
// 					success: function (data) {
// 						$("#s_total_service" + i).val(
// 							getDateDuration(data.embarked, data.disembarked)
// 						);
// 					},
// 				});
// 			});
// 		}
// 	}, 3000);
// }

function totalserviceembarke() {
	var nums = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
	setTimeout(() => {
		for (let i = 0; i < nums.length; i++) {
			$.ajax({
				url: base_url + "get-total-sea-service",
				type: "POST",
				data: $("#existing_application_form").serialize(),
				success: function (data) {
					$("#s_total_service" + i).val(
						getDateDuration(data.embarked, data.disembarked)
					);
				},
			});
		}
	}, 1000);
}

function disableBtn() {
	setTimeout(() => {
		$("#r_sea_service_btn" + 1).prop("disabled", true);
	}, 1000);
}

$("#s_current_crew_status").change(function () {
	if (this.value === "3") {
		$("#embark_span").show();
		$("#disembark_span").show();
	} else if (this.value === "4") {
		$("#embark_span").show();
		$("#disembark_span").show();
	} else {
		$("#embark_span").hide();
		$("#disembark_span").hide();
	}
});

$("#s_current_position").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_current_position, "s_current_position");
		},
	});
	formLicensesPerPosition(this.value, "", "licenses_list");
	formTrainingCertificate(
		this.value,
		$("#s_second_position").val(),
		"training_certificate_list"
	);
});

$("#s_current_crew_status").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_current_crew_status, "s_current_crew_status");
		},
	});
});

$("#s_current_vessel").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_current_vessel, "s_current_vessel");
		},
	});
});

$("#s_source_location").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_source_location, "s_source_location");
		},
	});
});

$("#s_source_location").change(function () {
	if (this.value == 1) {
		$("#recommend").show();
	}
});

$("#s_height").keyup(function () {
	$("#s_bmi").val(formatBMI(this.value, $("#s_weight").val()).toFixed(2));
});

$("#s_weight").keyup(function () {
	$("#s_bmi").val(formatBMI($("#s_height").val(), this.value).toFixed(2));
});

$("#s_province").change(function () {
	formCity(this.value, "s_city");
});

function addSeaService() {
	formSeaService("sea_service_record_fields");
	// totalservice();
}

$("#s_recommended_name").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_recommended_name, "s_recommended_name");
		},
	});
});
$("#s_first_name").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_first_name, "s_first_name");
		},
	});
});
$("#s_last_name").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_last_name, "s_last_name");
		},
	});
});
$("#s_birth_date").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_birth_date, "s_birth_date");
		},
	});
});
$("#s_date_available").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_date_available, "s_date_available");
		},
	});
});
$("#s_birth_place").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_birth_place, "s_birth_place");
		},
	});
});
$("#s_civil_status").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_civil_status, "s_civil_status");
		},
	});
});
$("#s_email_address").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_email_address, "s_email_address");
		},
	});
});
$("#s_mobile_number").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_mobile_number, "s_mobile_number");
		},
	});
});
$("#s_embark_onsigner_date").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_embark_onsigner_date, "s_embark_onsigner_date");
		},
	});
});
$("#s_disembark_onsigner_date").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(
				data.s_disembark_onsigner_date,
				"s_disembark_onsigner_date"
			);
		},
	});
});
// $("#s_religion").change(function () {
// 	$.ajax({
// 		url: base_url + "add-existing-crew-validation",
// 		type: "POST",
// 		data: $("#existing_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.s_religion, "s_religion");
// 		},
// 	});
// });
$("#s_nationality").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_nationality, "s_nationality");
		},
	});
});
$("#r_type_crew").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.r_type_crew, "r_type_crew");
		},
	});
});
// $("#s_sss_no").keyup(function () {
// 	$.ajax({
// 		url: base_url + "add-existing-crew-validation",
// 		type: "POST",
// 		data: $("#existing_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.s_sss_no, "s_sss_no");
// 		},
// 	});
// });
// $("#s_tin_no").keyup(function () {
// 	$.ajax({
// 		url: base_url + "add-existing-crew-validation",
// 		type: "POST",
// 		data: $("#existing_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.s_tin_no, "s_tin_no");
// 		},
// 	});
// });
// $("#s_philhealth_no").keyup(function () {
// 	$.ajax({
// 		url: base_url + "add-existing-crew-validation",
// 		type: "POST",
// 		data: $("#existing_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.s_philhealth_no, "s_philhealth_no");
// 		},
// 	});
// });
// $("#s_pag_ibig_no").keyup(function () {
// 	$.ajax({
// 		url: base_url + "add-existing-crew-validation",
// 		type: "POST",
// 		data: $("#existing_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.s_pag_ibig_no, "s_pag_ibig_no");
// 		},
// 	});
// });
$("#s_height").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_height, "s_height");
		},
	});
});
$("#s_weight").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_weight, "s_weight");
		},
	});
});
$("#s_home_address").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_home_address, "s_home_address");
		},
	});
});
$("#s_barangay").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_barangay, "s_barangay");
		},
	});
});
$("#s_province").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_province, "s_province");
		},
	});
});
$("#s_city").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_city, "s_city");
		},
	});
});
$("#s_country").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_country, "s_country");
		},
	});
});
// $("#s_father_name").keyup(function () {
// 	$.ajax({
// 		url: base_url + "add-existing-crew-validation",
// 		type: "POST",
// 		data: $("#existing_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.s_father_name, "s_father_name");
// 		},
// 	});
// });
// $("#s_mother_name").keyup(function () {
// 	$.ajax({
// 		url: base_url + "add-existing-crew-validation",
// 		type: "POST",
// 		data: $("#existing_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.s_mother_name, "s_mother_name");
// 		},
// 	});
// });
$("#s_kin_address").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_kin_address, "s_kin_address");
		},
	});
});
$("#s_course").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_course, "s_course");
		},
	});
});
$("#s_school_name").keyup(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_school_name, "s_school_name");
		},
	});
});
$("#s_inclusive_years_from").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_inclusive_years_from, "s_inclusive_years_from");
		},
	});
});
$("#s_inclusive_years_to").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_inclusive_years_to, "s_inclusive_years_to");
		},
	});
});
// $("#s_school_address").keyup(function () {
// 	$.ajax({
// 		url: base_url + "add-existing-crew-validation",
// 		type: "POST",
// 		data: $("#existing_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.s_school_address, "s_school_address");
// 		},
// 	});
// });
$("#s_type_crew").change(function () {
	$.ajax({
		url: base_url + "add-existing-crew-validation",
		type: "POST",
		data: $("#existing_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_type_crew, "s_type_crew");
		},
	});
});

$("#btnAddFD").click(function () {
	$("#show_flight_list").hide();
	$("#btnAddFD").hide();
	$("#hide_flight_form").show();
	$("#btnBackFD").show();
	$("#BtnAddFlight").show();
});

$("#btnBackFD").click(function () {
	$("#show_flight_list").show();
	$("#btnAddFD").show();
	$("#hide_flight_form").hide();
	$("#btnBackFD").hide();
	$("#BtnAddFlight").hide();
});

$("input[data-type='currency']").on({
	keyup: function () {
		formatCurrency($(this));
	},
	blur: function () {
		formatCurrency($(this), "blur");
	},
});

function formatNumber(n) {
	// format number 1000000 to 1,234,567
	return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function formatCurrency(input, blur) {
	// appends $ to value, validates decimal side
	// and puts cursor back in right position.

	// get input value
	var input_val = input.val();

	// don't validate empty input
	if (input_val === "") {
		return;
	}

	// original length
	var original_len = input_val.length;

	// initial caret position
	var caret_pos = input.prop("selectionStart");

	// check for decimal
	if (input_val.indexOf(".") >= 0) {
		// get position of first decimal
		// this prevents multiple decimals from
		// being entered
		var decimal_pos = input_val.indexOf(".");

		// split number by decimal point
		var left_side = input_val.substring(0, decimal_pos);
		var right_side = input_val.substring(decimal_pos);

		// add commas to left side of number
		left_side = formatNumber(left_side);

		// validate right side
		right_side = formatNumber(right_side);

		// On blur make sure 2 numbers after decimal
		if (blur === "blur") {
			right_side += "00";
		}

		// Limit decimal to only 2 digits
		right_side = right_side.substring(0, 2);

		// join number by .
		input_val = left_side + "." + right_side;
	} else {
		// no decimal entered
		// add commas to number
		// remove all non-digits
		input_val = formatNumber(input_val);
		input_val = input_val;

		// final formatting
		if (blur === "blur") {
			input_val += ".00";
		}
	}

	// send updated string to input
	input.val(input_val);

	// put caret back in the right position
	var updated_len = input_val.length;
	caret_pos = updated_len - original_len + caret_pos;
	input[0].setSelectionRange(caret_pos, caret_pos);
}
