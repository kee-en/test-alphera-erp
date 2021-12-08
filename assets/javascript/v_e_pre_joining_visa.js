$(function () {
	// formLicenses("licenses_list");
	formCivilStatus("e_civil_status");
	formReligion("e_religion");
	formNationality("e_nationality");
	formProvince("e_province");
	formAllCity("e_city");
});

$("#OffSignerBtnClose").click(function () {
	location.reload(true);
});

$("#btn_edit_license_edit").click(function () {
	$("#v_row_licenses").hide();
	$(".btn-edit-license").hide();
	$("#e_row_licenses").show();
	$(".btn-view-license").show();

	$("#l_crew_code").val(this.value);

	$.ajax({
		url: base_url + "get-list-positions",
		type: "GET",
		data: {
			crew_code: this.value,
		},
		success: function (data) {
			formLicensesPerPosition(
				data.first_position,
				data.second_position,
				"licenses_list"
			);
		},
	});

	getPreJoiningCrewLicenses(this.value);
});

$("#btn_view_license").click(function () {
	$("#e_row_licenses").hide();
	$(".btn-view-license").hide();
	$("#v_row_licenses").show();
	$(".btn-edit-license").show();

	// getViewEditPrejoining(this.value);
});

$("#btn_edit_certificates").click(function () {
	$("#v_row_certificates").hide();
	$(".btn-edit-cert").hide();
	$("#e_row_certificates").show();
	$(".btn-view-cert").show();

	getPreJoiningCrew(this.value);
	$("#t_crew_code").val(this.value);
	getPreJoiningCrewTraining(this.value);
});

$("#btn_view_certificates_edit").click(function () {
	$("#e_row_certificates").hide();
	$(".btn-view-cert").hide();
	$("#v_row_certificates").show();
	$(".btn-edit-cert").show();
});

$("#form_crew_license").submit(function () {
	$.ajax({
		url: base_url + "save-crew-licenses",
		type: "POST",
		data: $("#form_crew_license").serialize(),
		dataType: "JSON",
		success: function (data) {
			if (data.type) {
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
});

$("#form_crew_training").submit(function () {
	$.ajax({
		url: base_url + "save-crew-trainings",
		type: "POST",
		data: $("#form_crew_training").serialize(),
		dataType: "JSON",
		success: function (data) {
			if (data.type) {
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
});

// function getViewEditPrejoining(crew_code, full_name) {

// 	$.ajax({
// 		url: base_url + "get-list-licenses",
// 		type: "POST",
// 		data: { code: crew_code },
// 		success: function (data) {

// 			$("#crew_list_licenses").html(data);
// 		},
// 	});

// 	$.ajax({
// 		url: base_url + "get-list-certificates",
// 		type: "POST",
// 		data: { code: crew_code },
// 		success: function (data) {

// 			$("#crew_list_certificates").html(data);
// 		},
// 	});

// 	$("#btn_edit_license").val(crew_code);
// 	$("#btn_view_license").val(crew_code);
// 	$("#btn_edit_certificates").val(crew_code);
// 	$("#btn_view_certificates").val(crew_code);
// 	$("#vepjv_crew_name").html(full_name);

// 	$("#v_e_pre_joining_visa_modal").modal("show");
// }

function viewOffsignerDetails(code) {
	if (code != "") {
		evaluationFormApplicant(code);
		$("#v_crew_off_signer_modal").modal("show");
	}
}

function getPreJoiningCrew(code) {
	$.ajax({
		url: base_url + "get-crew-information",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			formTrainingCertificate(data.position, "", "training_certificate_list");
		},
	});
}

function evaluationFormApplicant(code) {
	$.ajax({
		url: base_url + "get-crew-details",
		type: "POST",
		data: {
			monitor_code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#on_date_of_availability").html(
				data.date_available
					? formatDate(data.date_available)
					: "No Specific Date"
			);
			$("#on_tentative_vessel").html(formatVessel(data.vessel_assign));
			$("#on_second_position").html(formatPosition(data.position));
			shipboardApplicationPersonalInfo(data.applicant_code);
			shipboardApplicationNextKin(data.applicant_code);
			shipboardApplicationEducation(data.applicant_code);
			shipboardApplicationWorkingGears(data.applicant_code);
			getLicenses(data.applicant_code);
			getCertificates(data.applicant_code);
			getSeaServiceRecord(data.applicant_code);
			viewOnCrewContracts(data.applicant_code);
			getSeaserviceRecordTotal(data.applicant_code);
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
			var full_name =
				data.first_name + " " + data.middle_name + " " + data.last_name;

			$("#on_first_name").text(data.first_name);
			$("#on_middle_name").text(data.middle_name);
			$("#on_last_name").text(data.last_name);
			$("#on_suffix").text(!data.suffix ? "-" : data.suffix);
			$("#off_registered_name").text(full_name);
			$("#on_birth_date").text(data.birth_date);
			$("#on_birth_place").text(data.birth_place);
			$("#on_civil_status").text(formatCivilStatus(data.civil_status));
			$("#on_email_address").text(data.email_address);
			$("#on_telephone_number").text(
				!data.telephone_number ? "-" : data.telephone_number
			);
			$("#on_mobile_number").text(
				!data.mobile_number ? "-" : data.mobile_number
			);
			$("#on_religion").text(formatReligion(data.religion));
			$("#on_nationality").text(!data.nationality ? "-" : data.nationality);
			$("#on_sss_no").text(!data.sss_no ? "-" : data.sss_no);
			$("#on_tin_no").text(!data.tin_number ? "-" : data.tin_number);
			$("#on_philhealth_no").text(
				!data.philhealth_no ? "-" : data.philhealth_no
			);
			$("#on_pag_ibig_no").text(!data.pag_ibig_no ? "-" : data.pag_ibig_no);
			$("#on_height").text(data.height);
			$("#on_weight").text(data.weight);
			$("#on_bmi").text(formatBMI(data.height, data.weight).toFixed(2));
			$("#on_home_address").text(data.street_address);
			$("#on_barangay").text(data.barangay);
			$("#on_province").text(data.region);
			$("#on_city").text(data.city);
			$("#on_country").text(data.country);
			$("#on_zip_code").text(data.zip_code);
			$("#on_provincial").text(data.provincial);
		},
	});
}

function getPreJoiningCrewLicenses(code) {
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
					$("#l_date_issued_" + lebi[index]).val(
						date_issued[index] ? date_issued[index] : ""
					);
					$("#l_expiry_date_" + lebi[index]).val(
						expiry_date[index] ? expiry_date[index] : ""
					);
				}
			},
		});
	});

	// configuration of the observer:
	var config = { attributes: true, childList: true, characterData: true };
	// pass in the target node, as well as the observer options
	observer.observe(target, config);
}

function getPreJoiningCrewTraining(code) {
	var target = document.getElementById("training_certificate_list");

	var observer = new MutationObserver(function (mutations) {
		$.ajax({
			url: base_url + "get-certificates",
			type: "POST",
			data: {
				code: code,
			},
			dataType: "JSON",
			success: function (data) {
				let certificates = JSON.parse(data.certificates);
				let number = JSON.parse(data.number);
				let date_issued = JSON.parse(data.date_issued);
				let date_expired = JSON.parse(data.expiration_date);
				let issued_by = JSON.parse(data.issued_by);
				let cop_number = JSON.parse(data.with_cop_number);

				for (let index = 0; index < certificates.length; index++) {
					$("#t_number_" + certificates[index]).val(number[index]);
					$("#t_date_issued_" + certificates[index]).val(date_issued[index]);
					$("#t_date_expired_" + certificates[index]).val(date_expired[index]);
					$("#t_issued_by_" + certificates[index]).val(issued_by[index]);
					$("#t_cop_number_" + certificates[index]).val(cop_number[index]);
				}
			},
		});
	});

	// configuration of the observer:
	var config = { attributes: true, childList: true, characterData: true };
	// pass in the target node, as well as the observer options
	observer.observe(target, config);
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

			$("#on_spouse_name").text(!data.spouse_name ? "-" : data.spouse_name);
			$("#on_occupation").text(!data.occupation ? "-" : data.occupation);
			$("#on_no_of_children").text(
				!data.no_of_children ? "-" : data.no_of_children
			);

			for (let i = 0; i < data.no_of_children; i++) {
				var id = i + 1;
				$("#rs" + id).show();

				$("#on_full_name_child_1").text(child_full_name[i]);
				$("#on_birth_date_child_1").text(child_birth_date[i]);
				$("#on_mobile_no_child_1").text(child_mobile_number[i]);
			}
			// for (let index = 0; index < child_full_name.length; index++) {
			// 	$("#e_full_name");
			// }

			$("#on_father_name").text(!data.father_name ? "-" : data.father_name);
			$("#on_mother_name").text(!data.mother_name ? "-" : data.mother_name);
			$("#on_kin_address").text(!data.address ? "-" : data.address);
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
			$("#on_course").text(!data.course ? "-" : data.course);
			$("#on_school").text(!data.school ? "-" : data.school);
			$("#on_inclusive_years").text(
				!data.inclusive_years ? "-" : data.inclusive_years
			);
			$("#on_school_address").text(
				!data.school_address ? "-" : data.school_address
			);
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
			$("#on_cover_all").text(!data.cover_all ? "-" : data.cover_all);
			$("#on_winter_jacket").text(
				!data.winter_jacket ? "-" : data.winter_jacket
			);
			$("#on_shoes").text(!data.shoes ? "-" : data.shoes);
			$("#on_winter_boots").text(!data.winter_boots ? "-" : data.winter_boots);
		},
	});
}

function getLicenses(applicant_code) {
	$.ajax({
		url: base_url + "get-list-licenses",
		type: "POST",
		data: {
			code: applicant_code,
		},
		success: function (data) {
			$("#list_licenses").html(data);
		},
	});
}

function getCertificates(applicant_code) {
	$.ajax({
		url: base_url + "get-list-certificates",
		type: "POST",
		data: {
			code: applicant_code,
		},
		success: function (data) {
			$("#list_certificates").html(data);
		},
	});
}
function getSeaServiceRecord(applicant_code) {
	$.ajax({
		url: base_url + "get-list-sea-service-record",
		type: "POST",
		data: {
			applicant_code: applicant_code,
		},
		success: function (data) {
			if (data) {
				if (typeof data == "string") {
					$("#sea_service_record_table").html(data);
				} else if (typeof data == "object") {
					var table = "";
					var count = 1;
					data.forEach((arr_of_sea_service) => {
						table += "<tr>";
						var total_service = getDateDuration(
							arr_of_sea_service.embarked,
							arr_of_sea_service.disembarked
						);

						total_service = total_service !== undefined ? total_service : "-";

						var vessel = arr_of_sea_service.vessel
								? arr_of_sea_service.vessel
								: "-",
							flag = arr_of_sea_service.flag ? arr_of_sea_service.flag : "-",
							salary = arr_of_sea_service.salary
								? arr_of_sea_service.salary
								: "-",
							position = arr_of_sea_service.position
								? arr_of_sea_service.position
								: "-",
							type_vessel = arr_of_sea_service.type_vessel
								? arr_of_sea_service.type_vessel
								: "-",
							grt_power = arr_of_sea_service.grt_power
								? arr_of_sea_service.grt_power
								: "-",
							embarked = arr_of_sea_service.embarked
								? arr_of_sea_service.embarked
								: "-",
							disembarked = arr_of_sea_service.disembarked
								? arr_of_sea_service.disembarked
								: "-",
							agency = arr_of_sea_service.agency
								? arr_of_sea_service.agency
								: "-",
							remarks = arr_of_sea_service.remarks
								? arr_of_sea_service.remarks
								: "-";

						table += "<td>" + count + "</td>";
						table += "<td>" + vessel + "</td>";
						table += "<td>" + flag + "</td>";
						table += "<td>" + salary + "</td>";
						table += '<td class="font-weight-medium">' + position + "</td>";
						table += "<td>" + type_vessel + "</td>";
						table += "<td>" + grt_power + "</td>";
						table += "<td>" + embarked + "</td>";
						table += "<td>" + disembarked + "</td>";
						table += "<td>" + total_service + "</td>";
						table += "<td>" + agency + "</td>";
						table += "<td>" + remarks + "</td>";
						table += "</tr>";

						count++;
					});

					$("#sea_service_record_table").html(table);
				}
			}
		},
	});
}
function getSeaserviceRecordTotal(applicant_code) {
	$.ajax({
		url: base_url + "get-sea-service-total",
		type: "POST",
		dataType: "JSON",
		data: {
			applicant_code: applicant_code,
		},
		success: function (data) {
			let embarked = JSON.parse(data.embarked);
			let disembarked = JSON.parse(data.disembarked);

			$("#total_service_one").html(
				getTotalServiceDuration(embarked, disembarked)
			);
		},
	});
}
function viewOnCrewContracts(crew_code) {
	$.ajax({
		url: base_url + "get-crew-contract",
		type: "POST",
		dataType: "JSON",
		data: { crew_code: crew_code },
		success: function (data) {
			$("#on_contract_list").empty();
			$("#on_contract_list").append(data);
		},
	});
}

//
function btn_edit_crew_info() {
	$("#v_row_info").hide();
	$(".btn-edit").hide();
	$("#e_row_info").show();
	$(".btn-view").show();
}

function btn_view_crew_info() {
	$("#e_row_info").hide();
	$(".btn-view").hide();
	$("#v_row_info").show();
	$(".btn-edit").show();
}
$("#e_province").change(function () {
	formCity(this.value, "e_city");
});

function getViewEditApplication(crew_code) {
	getCrewInformation(crew_code);
	getApplicantInformationAll(crew_code);
	getNextOfKin(crew_code);
	getEducationalAttainment(crew_code);
	getWorkingGears(crew_code);

	$("#v_e_crew_information_modal").modal("show");
}

function getCrewInformation(crew_code) {
	$.ajax({
		url: base_url + "get-crew-information",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#v_approved_position").html(formatPosition(data.position));
			$("#v_assign_vessel").html(formatVessel(data.vessel_assign));
			$("#v_date_available").html(
				data.date_available
					? formatDate(data.date_available)
					: "No Specific Date"
			);
			$("#epvm_position").val(data.position);
			$("#epvm_tentative_vessel").val(data.vessel_assign);
			$("#hid_code_pos_update").val(data.crew_code);
		},
	});
}

function getApplicantInformationAll(crew_code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			var full_name =
				data.first_name + " " + data.middle_name + " " + data.last_name;

			$("#m_crew_name").html(full_name);
			$("#epvm_crew_name").html(full_name);
			$("#v_applicant_full_name").html(full_name);
			$("#v_first_name").html(data.first_name);
			$("#v_middle_name").html(!data.middle_name ? "-" : data.middle_name);
			$("#v_last_name").html(data.last_name);
			$("#v_suffix").html(!data.suffix ? "-" : data.suffix);
			$("#v_birth_date").html(formatDate(data.birth_date));
			$("#v_birth_place").html(data.birth_place);
			$("#v_civil_status").html(formatCivilStatus(data.civil_status));
			$("#v_email_address").html(data.email_address);
			$("#v_telephone_number").html(
				!data.telephone_number ? "-" : data.telephone_number
			);
			$("#v_mobile_number").html(
				!data.mobile_number ? "-" : data.mobile_number
			);
			$("#v_religion").html(formatReligion(data.religion));
			$("#v_nationality").html(
				!data.nationality ? "-" : formatNationality(data.nationality)
			);
			$("#v_sss_no").html(!data.sss_no ? "-" : data.sss_no);
			$("#v_tin_no").html(!data.tin_number ? "-" : data.tin_number);
			$("#v_philhealth_no").html(
				!data.philhealth_no ? "-" : data.philhealth_no
			);
			$("#v_pag_ibig_no").html(!data.pag_ibig_no ? "-" : data.pag_ibig_no);
			$("#v_height").html(data.height + " cm");
			$("#v_weight").html(data.weight + " kg");
			$("#v_bmi").html(formatBMI(data.height, data.weight).toFixed(2));
			$("#v_home_address").html(
				data.street_address +
					" " +
					data.barangay +
					" " +
					formatCity(data.city) +
					", " +
					formatProvince(data.region)
			);
			$("#v_zip_code").html(!data.zip_code ? "-" : data.zip_code);
			$("#v_provincial_city").html(!data.provincial ? "-" : data.provincial);

			$("#e_crew_code").val(data.crew_code);
			$("#e_first_name").val(data.first_name);
			$("#e_middle_name").val(data.middle_name);
			$("#e_last_name").val(data.last_name);
			$("#e_suffix").val(data.suffix);
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
		},
	});
}

function getNextOfKin(crew_code) {
	$.ajax({
		url: base_url + "get-next-of-kin",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			var name_of_children = JSON.parse(data.name_of_children);
			var birthday_of_children = JSON.parse(data.birthday_of_children);
			var contact_of_children = JSON.parse(data.contact_of_children);

			$("#v_spouse_name").html(!data.spouse_name ? "-" : data.spouse_name);
			$("#v_no_of_occupation").html(!data.occupation ? "-" : data.occupation);
			$("#v_no_of_children").html(
				data.no_of_children == "none" ? "-" : data.no_of_children
			);
			$("#v_father_name").html(!data.father_name ? "-" : data.father_name);
			$("#v_mother_name").html(!data.mother_name ? "-" : data.mother_name);
			$("#v_address").html(!data.address ? "-" : data.address);

			$("#e_spouse_name").val(data.spouse_name);
			$("#e_occupation").val(data.occupation);
			$("#e_no_of_children").val(data.no_of_children);

			for (let index = 0; index < data.no_of_children; index++) {
				var id = index + 1;
				$("#children_row_" + id).show();

				$("#v_full_name_children_" + index).html(
					!name_of_children[index] ? "-" : name_of_children[index]
				);
				$("#v_birth_date_children_" + index).html(
					!birthday_of_children[index] ? "-" : birthday_of_children[index]
				);
				$("#v_mobile_no_" + index).html(
					!contact_of_children[index] ? "-" : contact_of_children[index]
				);

				$("#r_full_name_" + index).val(name_of_children[index]);
				$("#r_birth_date_" + index).val(birthday_of_children[index]);
				$("#r_mobile_no_" + index).val(contact_of_children[index]);
			}

			$("#e_father_name").val(data.father_name);
			$("#e_mother_name").val(data.mother_name);
			$("#e_kin_address").val(data.address);
		},
	});
}

function getEducationalAttainment(crew_code) {
	$.ajax({
		url: base_url + "get-educational-attainment",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			var inclusive_year = isJson(data.inclusive_years);

			if (inclusive_year != false) {
				var inc_from = inclusive_year[0] ? formatDate(inclusive_year[0]) : "-";
				var inc_to = inclusive_year[1] ? formatDate(inclusive_year[1]) : "-";

				$("#v_course").html(!data.course ? "-" : data.course);
				$("#v_school").html(!data.school ? "-" : data.school);
				$("#v_school_address").html(
					!data.school_address ? "-" : data.school_address
				);

				$("#v_inclusive_years").html(
					!data.inclusive_years ? "-" : inc_from + " - " + inc_to
				);

				$("#e_course").val(data.course);
				$("#e_school_name").val(data.school);
				$("#e_inclusive_years_from").val(inclusive_year[0]);
				$("#e_inclusive_years_to").val(inclusive_year[1]);
				$("#e_school_address").val(data.school_address);
			} else {
				$("#v_course").html(!data.course ? "-" : data.course);
				$("#v_school").html(!data.school ? "-" : data.school);
				$("#v_school_address").html(
					!data.school_address ? "-" : data.school_address
				);

				$("#e_course").val(data.course);
				$("#e_school_name").val(data.school);
				$("#e_school_address").val(data.school_address);
			}
		},
	});
}

function getWorkingGears(crew_code) {
	$.ajax({
		url: base_url + "get-working-gears",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#v_cover_all").html(!data.cover_all ? "-" : data.cover_all);
			$("#v_winter_jacket").html(
				!data.winter_jacket ? "-" : data.winter_jacket
			);
			$("#v_shoes").html(!data.shoes ? "-" : data.shoes + " cm");
			$("#v_winter_boots").html(
				!data.winter_boots ? "-" : data.winter_boots + " bms"
			);

			$("#e_cover_all").val(data.cover_all);
			$("#e_winter_jacket").val(data.winter_jacket);
			$("#e_shoes").val(data.shoes);
			$("#e_winter_boots").val(data.winter_boots);
		},
	});
}
