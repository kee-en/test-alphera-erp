$(function () {
	formAllPosition("e_first_position");
	formAllPosition("e_second_position");
	formSource("e_source_location");
	formVessel("e_tentative_vessel");
	formCivilStatus("e_civil_status");
	formReligion("e_religion");
	formNationality("e_nationality");
	formProvince("e_province");
	formAllCity("e_city");
	formLicenses("licenses_list");
	disableBtn();
});

// function totalservice(number) {
// 	var embark = $('#s_embarked' + number).val();
// 	var disembark = $('#s_disembarked' + number).val();

// 	if (embark && disembark) {
// 		$("#s_total_service" + number).val(
// 			getDateDuration(embark, disembark)
// 		);
// 	}
// }

function totalserviceembarke() {
	var nums = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
	setTimeout(() => {
		for (let i = 0; i < nums.length; i++) {
			$.ajax({
				url: base_url + "get-total-sea-service",
				type: "POST",
				data: $("#edit_shipboard_application_form").serialize(),
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

$("#edit_shipboard_application_form").submit(function () {
	$.ajax({
		url: base_url + "edit-shipboard-aplication",
		type: "POST",
		data: new FormData(this),
		cache: false,
		contentType: false,
		processData: false,
		dataType: "JSON",
		beforeSend: function () {
			$("#BtnEditShipboard").html(
				'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
			);
			$("#BtnEditShipboard").prop("disabled", true);
		},
		success: function (data) {
			validationInput(data.e_first_position, "e_first_position");
			validationInput(data.e_source_location, "e_source_location");
			validationInput(data.e_tentative_vessel, "e_tentative_vessel");
			validationInput(data.e_recommended_name, "e_recommended_name");
			validationInput(data.s_type_of_crew, "s_type_of_crew");
			validationInput(data.e_first_name, "e_first_name");
			validationInput(data.e_last_name, "e_last_name");
			validationInput(data.e_birth_date, "e_birth_date");
			validationInput(data.e_birth_place, "e_birth_place");
			validationInput(data.e_date_available, "e_date_available");
			validationInput(data.e_civil_status, "e_civil_status");
			validationInput(data.e_email_address, "e_email_address");
			validationInput(data.e_mobile_number, "e_mobile_number");
			// validationInput(data.e_religion, "e_religion");
			validationInput(data.e_nationality, "e_nationality");
			// validationInput(data.e_sss_no, "e_sss_no");
			// validationInput(data.e_tin_no, "e_tin_no");
			// validationInput(data.e_philhealth_no, "e_philhealth_no");
			// validationInput(data.e_pag_ibig_no, "e_pag_ibig_no");
			validationInput(data.e_height, "e_height");
			validationInput(data.e_weight, "e_weight");
			validationInput(data.e_home_address, "e_home_address");
			validationInput(data.e_province, "e_province");
			validationInput(data.e_city, "e_city");
			validationInput(data.e_country, "e_country");
			// validationInput(data.e_father_name, "e_father_name");
			// validationInput(data.e_mother_name, "e_mother_name");
			validationInput(data.e_kin_address, "e_kin_address");
			validationInput(data.e_course, "e_course");
			validationInput(data.e_school_name, "e_school_name");
			validationInput(data.e_inclusive_years_from, "e_inclusive_years_from");
			validationInput(data.e_inclusive_years_to, "e_inclusive_years_to");
			// validationInput(data.e_school_address, "e_school_address");

			if (data.type === "success") {
				Swal.fire({
					icon: data.type,
					title: data.title,
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
			}
			$("#BtnEditShipboard").html("Save Changes");
			$("#BtnEditShipboard").prop("disabled", false);
		},
	});
});

function addSeaService() {
	formSeaService("sea_service_record_fields");
	totalservice();
}

$("#closeModalBtn").click(function () {
	location.reload();
});

function showShipboardApp(code) {
	shipboardApplicationApplicant(code);
	shipboardApplicationPersonalInfo(code);
	shipboardApplicationNextKin(code);
	shipboardApplicationEducation(code);
	shipboardApplicationWorkingGears(code);
	shipboardApplicationLicenses(code);
	shipboardApplicationTrainingCertificates(code);
	shipboardEditApplicationSeaService(code);
	getApplicantPhoto(code);
	$("#e_shipboard_application_modal").modal("show");
}

function shipboardApplicationApplicant(code) {
	$.ajax({
		url: base_url + "get-applicants",
		type: "POST",
		data: {
			applicant_code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#es_date_of_application").html(
				data.date_created ? formatDate(data.date_created) : "-"
			);
			$("#es_date_of_availability").html(
				data.date_available ? formatDate(data.date_available) : "-"
			);
			$("#es_first_position").html(
				data.position_first ? formatPosition(data.position_first) : ""
			);
			$("#es_second_position").html(
				data.position_second ? formatPosition(data.position_second) : ""
			);
			$("#es_tentative_vessel").html(
				!data.assign_vessel ? "-" : formatVessel(data.assign_vessel)
			);
			$("#es_nat_result").html(!data.nat_result ? "-" : data.nat_result + "%");

			$("#e_applicant_code").val(data.applicant_code);
			$("#e_crew_code").val(data.crew_code);
			$("#e_first_position").val(data.position_first);

			formByPosition("e_second_position", data.position_first);

			// TRIGGER CHANGE IN VALUE
			setSelectValueAfterElementChange(
				"e_second_position",
				data.position_second
			);

			formTrainingCertificate(
				data.position_first,
				data.position_second,
				"training_certificate_list"
			);

			formLicensesPerPosition(
				data.position_first,
				data.position_second,
				"licenses_list"
			);

			$("#e_first_position").change(function () {
				formByPosition("e_second_position", this.value);
				setSelectValueAfterElementChange("e_second_position", 0);

				formLicensesPerPosition(
					this.value,
					$("#e_second_position").val(),
					"licenses_list"
				);

				formTrainingCertificate(
					this.value,
					$("#e_second_position").val(),
					"training_certificate_list"
				);
			});

			$("#e_second_position").change(function () {
				formLicensesPerPosition(
					$("#e_first_position").val(),
					this.value,
					"licenses_list"
				);

				formTrainingCertificate(
					$("#e_first_position").val(),
					this.value,
					"training_certificate_list"
				);
			});

			$("#e_date_available").val(data.date_available);
			$("#e_tentative_vessel").val(data.assign_vessel);
			$("#e_source_location").val(data.source);
			if (data.source == "1") {
				$("#recommend").show();
				$("#e_recommended_name").val(data.recommend_by);
			}

			$("#s_type_of_crew").val(data.type_applicant);
		},
	});
}

function shipboardApplicationPersonalInfo(code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_applicant_photo").attr("src", data.photo_path);

			$("#e_first_name").val(data.first_name);
			$("#e_middle_name").val(data.middle_name);
			$("#e_last_name").val(data.last_name);
			$("#e_suffix").val(data.suffix);
			$("#es_applicant_full_name").text(
				data.first_name +
					" " +
					data.middle_name +
					" " +
					data.last_name +
					" " +
					data.suffix
			);
			$("#e_birth_date").val(data.birth_date);
			$("#e_birth_place").val(data.birth_place);
			$("#e_civil_status").val(data.civil_status);
			$("#e_email_address").val(data.email_address);
			$("#e_telephone_number").val(data.telephone_number);
			$("#e_mobile_number").val(data.mobile_number);
			$("#e_religion").val(data.religion);
			$("#e_nationality").val(data.nationality);
			$("#e_sss_no").val(data.sss_no);
			$("#e_tin_no").val(data.tin_number);
			$("#e_philhealth_no").val(data.philhealth_no);
			$("#e_pag_ibig_no").val(data.pag_ibig_no);
			$("#e_height").val(data.height);
			$("#e_weight").val(data.weight);
			$("#e_bmi").val(formatBMI(data.height, data.weight).toFixed(2));
			$("#e_home_address").val(data.street_address);
			$("#e_barangay").val(data.barangay);
			$("#e_province").val(data.region);
			$("#e_city").val(data.city);
			$("#e_country").val(data.country);
			$("#e_zip_code").val(data.zip_code);
			$("#e_provincial").val(data.provincial);

			formCity(data.region, "e_city");

			setSelectValueAfterElementChange("e_city", data.city);
		},
	});
}

function shipboardApplicationNextKin(code) {
	$.ajax({
		url: base_url + "get-next-of-kin",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			let child_full_name = JSON.parse(data.name_of_children);
			let child_birth_date = JSON.parse(data.birthday_of_children);
			let child_mobile_number = JSON.parse(data.contact_of_children);

			$("#e_spouse_name").val(data.spouse_name);
			$("#e_occupation").val(data.occupation);
			$("#e_no_of_children").val(data.no_of_children);

			for (let i = 0; i < data.no_of_children; i++) {
				var index = i + 1;
				$("#rs" + index).show();
				$("#e_full_name_child_" + i).val(child_full_name[i]);
				$("#e_birth_date_child_" + i).val(child_birth_date[i]);
				$("#e_mobile_no_child_" + i).val(child_mobile_number[i]);
			}
			// for (let index = 0; index < child_full_name.length; index++) {
			// 	$("#e_full_name");
			// }

			$("#e_father_name").val(data.father_name);
			$("#e_mother_name").val(data.mother_name);
			$("#e_kin_address").val(data.address);
		},
	});
}

function shipboardApplicationEducation(code) {
	$.ajax({
		url: base_url + "get-educational-attainment",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			var inclusive_year = JSON.parse(data.inclusive_years);
			$("#e_course").val(data.course);
			$("#e_school_name").val(data.school);
			$("#e_inclusive_years_from").val(inclusive_year[0]);
			$("#e_inclusive_years_to").val(inclusive_year[1]);
			$("#e_school_address").val(data.school_address);
		},
	});
}

function shipboardApplicationWorkingGears(code) {
	$.ajax({
		url: base_url + "get-working-gears",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_cover_all").val(data.cover_all);
			$("#e_winter_jacket").val(data.winter_jacket);
			$("#e_shoes").val(data.shoes);
			$("#e_winter_boots").val(data.winter_boots);
		},
	});
}

function shipboardApplicationLicenses(code) {
	var target = document.getElementById("licenses_list");

	var observer = new MutationObserver(function (mutations) {
		$.ajax({
			url: base_url + "get-licenses",
			type: "POST",
			data: {
				code: code,
			},
			dataType: "JSON",
			success: function (data) {
				let lebi = JSON.parse(data.lebi);
				let grade = JSON.parse(data.grade);
				let number = JSON.parse(data.number);
				let date_issued = JSON.parse(data.date_issued);
				let expiry_date = JSON.parse(data.expiry_date);

				for (let index = 0; index < lebi.length; index++) {
					$("#l_grade_" + lebi[index]).val(grade[index]);
					$("#l_number_" + lebi[index]).val(number[index]);
					$("#l_date_issued_" + lebi[index]).val(date_issued[index]);
					$("#l_expiry_date_" + lebi[index]).val(expiry_date[index]);
				}
			},
		});
	});

	// configuration of the observer:
	var config = { attributes: true, childList: true, characterData: true };
	// pass in the target node, as well as the observer options
	observer.observe(target, config);
}

function shipboardApplicationTrainingCertificates(code) {
	var target = document.getElementById("licenses_list");

	var observer = new MutationObserver(function (mutations) {
		$.ajax({
			url: base_url + "get-certificates",
			type: "POST",
			data: {
				code: code,
			},
			dataType: "JSON",
			success: function (data) {
				if (data) {
					let certificates = JSON.parse(data.certificates);
					let number = JSON.parse(data.number);
					let date_issued = JSON.parse(data.date_issued);
					let date_expired = JSON.parse(data.expiration_date);
					let issued_by = JSON.parse(data.issued_by);
					let cop_number = JSON.parse(data.with_cop_number);

					for (let index = 0; index < certificates.length; index++) {
						$("#t_number_" + certificates[index]).val(number[index]);
						$("#t_date_issued_" + certificates[index]).val(date_issued[index]);
						$("#t_date_expired_" + certificates[index]).val(
							date_expired[index]
						);
						$("#t_issued_by_" + certificates[index]).val(issued_by[index]);
						$("#t_cop_number_" + certificates[index]).val(cop_number[index]);
					}
				}
			},
		});
	});

	// configuration of the observer:
	var config = { attributes: true, childList: true, characterData: true };
	// pass in the target node, as well as the observer options
	observer.observe(target, config);
}

function shipboardEditApplicationSeaService(code) {
	$.ajax({
		url: base_url + "get-sea-service-record",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data.array_of_sea_services !== undefined) {
				formSeaServices(
					data.array_of_sea_services.length,
					"sea_service_record_fields"
				);

				setTimeout(() => {
					let count = 1;
					data.array_of_sea_services.forEach((arr_of_sea_service) => {
						var total_service = getDateDuration(
							arr_of_sea_service.embarked,
							arr_of_sea_service.disembarked
						);

						total_service = total_service !== undefined ? total_service : "";

						$("#s_vessel_name_" + count).val(arr_of_sea_service.vessel);
						$("#s_flag_" + count).val(arr_of_sea_service.flag);
						$("#s_salary_" + count).val(arr_of_sea_service.salary);
						$("#s_rank_" + count).val(arr_of_sea_service.rank);
						$("#s_vsl_engn_" + count).val(arr_of_sea_service.type_vessel);
						$("#s_grt_power" + count).val(arr_of_sea_service.grt_power);
						$("#s_embarked" + count).val(arr_of_sea_service.embarked);
						$("#s_disembarked" + count).val(arr_of_sea_service.disembarked);
						$("#s_total_service" + count).val(total_service);
						$("#s_agency" + count).val(arr_of_sea_service.agency);
						$("#s_remarks" + count).val(arr_of_sea_service.remarks);
						count++;
					});
				}, 1000);
			} else {
				setTimeout(() => {
					formSeaService("sea_service_record_fields");
				}, 1000);
			}
		},
	});
}

function getApplicantPhoto(code) {
	$.ajax({
		url: base_url + "get-applicant-photo",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data != false) {
				// $("#my_camera").css("display", "none");
				$("#edit_shipboard_application_form")
					.find("#my_camera")
					.removeAttr("style");
				$("#edit_shipboard_application_form")
					.find("#image-tag")
					.attr("src", data);
				// $("#image-tag").attr("src", data);
			} else {
				$("#edit_shipboard_application_form")
					.find("#my_camera")
					.removeAttr("style");
				// $("#image-tag").css("display", "none");
			}
		},
	});
}
//WebCAM Config
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

$("#e_source_location").on("change", function () {
	$("#recommend").css("display", "none");
	if ($(this).val() === "1") {
		$("#recommend").css("display", "block");
	}
});

//

//Input Validation
$("#e_recommended_name").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_recommended_name, "e_recommended_name");
		},
	});
});
$("#e_first_name").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_first_name, "e_first_name");
		},
	});
});
$("#e_last_name").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_last_name, "e_last_name");
		},
	});
});
$("#e_birth_date").blur(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_birth_date, "e_birth_date");
		},
	});
});
$("#e_date_available").blur(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_date_available, "e_date_available");
		},
	});
});
$("#e_birth_place").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_birth_place, "e_birth_place");
		},
	});
});

$("#e_tentative_vessel").change(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_tentative_vessel, "e_tentative_vessel");
		},
	});
});

$("#s_type_of_crew").change(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.s_type_of_crew, "s_type_of_crew");
		},
	});
});

$("#e_civil_status").change(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_civil_status, "e_civil_status");
		},
	});
});
$("#e_email_address").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_email_address, "e_email_address");
		},
	});
});
$("#e_mobile_number").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_mobile_number, "e_mobile_number");
		},
	});
});
// $("#e_religion").change(function () {
// 	$.ajax({
// 		url: base_url + "e-shipboard-application",
// 		type: "POST",
// 		data: $("#edit_shipboard_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.e_religion, "e_religion");
// 		},
// 	});
// });
$("#e_nationality").change(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_nationality, "e_nationality");
		},
	});
});
// $("#e_sss_no").keyup(function () {
// 	$.ajax({
// 		url: base_url + "e-shipboard-application",
// 		type: "POST",
// 		data: $("#edit_shipboard_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.e_sss_no, "s_sss_no");
// 		},
// 	});
// });
// $("#e_tin_no").keyup(function () {
// 	$.ajax({
// 		url: base_url + "e-shipboard-application",
// 		type: "POST",
// 		data: $("#edit_shipboard_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.e_tin_no, "e_tin_no");
// 		},
// 	});
// });
// $("#e_philhealth_no").keyup(function () {
// 	$.ajax({
// 		url: base_url + "e-shipboard-application",
// 		type: "POST",
// 		data: $("#edit_shipboard_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.e_philhealth_no, "e_philhealth_no");
// 		},
// 	});
// });
// $("#e_pag_ibig_no").keyup(function () {
// 	$.ajax({
// 		url: base_url + "e-shipboard-application",
// 		type: "POST",
// 		data: $("#edit_shipboard_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.e_pag_ibig_no, "e_pag_ibig_no");
// 		},
// 	});
// });
$("#e_height").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_height, "e_height");
		},
	});
});
$("#e_weight").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_weight, "e_weight");
		},
	});
});
$("#e_home_address").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_home_address, "e_home_address");
		},
	});
});
$("#e_barangay").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_barangay, "e_barangay");
		},
	});
});
$("#e_province").change(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_province, "e_province");
		},
	});
});
$("#e_city").change(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_city, "e_city");
		},
	});
});
$("#e_country").change(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_country, "e_country");
		},
	});
});
// $("#e_father_name").keyup(function () {
// 	$.ajax({
// 		url: base_url + "e-shipboard-application",
// 		type: "POST",
// 		data: $("#edit_shipboard_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.e_father_name, "e_father_name");
// 		},
// 	});
// });
// $("#e_mother_name").keyup(function () {
// 	$.ajax({
// 		url: base_url + "e-shipboard-application",
// 		type: "POST",
// 		data: $("#edit_shipboard_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.e_mother_name, "e_mother_name");
// 		},
// 	});
// });
$("#e_kin_address").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_kin_address, "e_kin_address");
		},
	});
});
$("#e_course").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_course, "e_course");
		},
	});
});
$("#e_school_name").keyup(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_school_name, "e_school_name");
		},
	});
});

$("#e_inclusive_years_from").blur(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_inclusive_years_from, "e_inclusive_years_from");
		},
	});
});
$("#e_inclusive_years_to").blur(function () {
	$.ajax({
		url: base_url + "e-shipboard-application",
		type: "POST",
		data: $("#edit_shipboard_application_form").serialize(),
		success: function (data) {
			validationInput(data.e_inclusive_years_to, "e_inclusive_years_to");
		},
	});
});
// $("#e_school_address").keyup(function () {
// 	$.ajax({
// 		url: base_url + "e-shipboard-application",
// 		type: "POST",
// 		data: $("#edit_shipboard_application_form").serialize(),
// 		success: function (data) {
// 			validationInput(data.e_school_address, "e_school_address");
// 		},
// 	});
// });
