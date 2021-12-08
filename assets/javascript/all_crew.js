$(function () {
	formAllPosition("epp_position");
	formVessel("epp_tentative_vessel");
	formVessel("e_vessel_name");
	formAllPosition("e_position");
	formTypeVessel("e_vessel_type");

	formVessel("edit_mlc_vessel_name");
	formTypeVessel("edit_mlc_vessel_type");
	formNationality("edit_mlc_farer_nationality");
	formAllPosition("edit_mlc_farer_duty");

	formVessel("promotion_vessel_name");
	formTypeVessel("promotion_vessel_type");
	formAllPosition("promotion_position");
	formVessel("promotion_mlc_vessel_name");
	formTypeVessel("promotion_mlc_vessel_type");
	formNationality("promotion_mlc_farer_nationality");
	formAllPosition("promotion_mlc_farer_duty");
});

$("#crew_filter_form").submit(function () {
	$.ajax({
		url: base_url + "all-crew-search",
		type: "POST",
		data: $("#crew_filter_form").serialize(),
		success: function (data) {
			window.location.replace(base_url + 'all-crew');
		},
	});
});

$("#BtnResetSearch").click(function () {
	$.ajax({
		url: base_url + "unset-crew-search",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
});

function PrintReport(type, c_type) {
	if (type === "csv") {
		window.open(base_url + "print-crew-csv" + "/" + c_type);
	} else if (type === "excel") {
		window.open(base_url + "print-crew-xl" + "/" + c_type);
	} else {
		window.open(base_url + "print-all-crew-pdf" + "/" + c_type);
	}
}

function getViewEditPrejoining(crew_code, name) {
	$.ajax({
		url: base_url + "get-list-licenses",
		type: "POST",
		data: { code: crew_code },
		success: function (data) {
			$("#v_e_pre_joining_visa_modal")
				.find("#crew_list_licenses_edit")
				.append(data);
		},
	});

	$.ajax({
		url: base_url + "get-list-certificates",
		type: "POST",
		data: { code: crew_code },
		success: function (data) {
			$("#v_e_pre_joining_visa_modal")
				.find("#crew_list_certificates_edit")
				.append(data);
		},
	});

	$("#btn_edit_license_edit").val(crew_code);
	$("#btn_view_license").val(crew_code);
	$("#btn_edit_certificates").val(crew_code);
	$("#btn_view_certificates_edit").val(crew_code);
	$("#vepjv_crew_name").html(name);
	$("#v_e_pre_joining_visa_modal").modal("show");
}

//view edit info
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

$("#e_no_of_children").on("change", function () {
	for (let index = 0; index < this.value; index++) {
		var i = index + 1;
		$("#rs" + i).show();
	}
});

$(function () {
	formCivilStatus("e_civil_status");
	formReligion("e_religion");
	formNationality("e_nationality");
	formProvince("e_province");
	formAllCity("e_city");
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
			$("#v_approved_position").text(
				data.position ? formatPosition(data.position) : "-"
			);
			$("#v_assign_vessel").text(
				data.vessel_assign ? formatVessel(data.vessel_assign) : "-"
			);
			$("#v_date_available").text(
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

			$("#v_applicant_photo").attr("src", data.photo_path);
			$("#v_e_crew_information_modal")
				.find("#image-tag")
				.attr("src", data.photo_path);

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
			$("#v_religion").html(
				data.religion ? formatReligion(data.religion) : "-"
			);
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

$("#e_province").change(function () {
	formCity(this.value, "e_city");
});

$("#e_crew_info_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-crew-information",
		type: "POST",
		data: $("#e_crew_info_form").serialize(),
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

$("#e_height").keyup(function () {
	$("#e_bmi").val(formatBMI(this.value, $("#e_weight").val()).toFixed(2));
});

$("#e_weight").keyup(function () {
	$("#e_bmi").val(formatBMI($("#e_height").val(), this.value).toFixed(2));
});

$("#export_withdraw").change(function () {
	var c_type = "withdrawal";
	if (this.value == 1) {
		window.open(base_url + "print-crew-csv" + "/" + c_type);
	} else if (this.value == 2) {
		window.open(base_url + "print-crew-xl" + "/" + c_type);
	} else {
		window.open(base_url + "print-withdraw-crew-pdf");
	}
});

// $("#edit_poea_contract_form").submit(function () {
// 	Swal.fire({
// 		title: "POEA Contract",
// 		text: "Are you sure you want to update crew's POEA contract?",
// 		icon: "warning",
// 		allowOutsideClick: !1,
// 		allowEscapeKey: !1,
// 		showCancelButton: !0,
// 		confirmButtonColor: "#004aad",
// 		cancelButtonColor: "#d33",
// 		confirmButtonText: "Yes",
// 	}).then((result) => {
// 		result.isConfirmed &&
// 			$.ajax({
// 				url: base_url + "update-poea",
// 				type: "POST",
// 				data: $("#edit_poea_contract_form").serialize(),
// 				beforeSend: function () {
// 					$("#btnSaveChanges_poea").html(
// 						'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
// 					);
// 					$("#btnSaveChanges_poea").prop("disabled", true);
// 				},
// 				success: function (data) {
// 					validationInput(data.e_license_no, "e_license_no");
// 					validationInput(data.e_sirb_no, "e_sirb_no");
// 					validationInput(data.e_src_no, "e_src_no");
// 					validationInput(data.e_name_of_agent, "e_name_of_agent");
// 					validationInput(data.e_name_of_principal, "e_name_of_principal");
// 					validationInput(
// 						data.e_address_of_principal,
// 						"e_address_of_principal"
// 					);
// 					validationInput(data.e_duration_contract, "e_duration_contract");
// 					validationInput(data.e_position, "e_position");
// 					validationInput(data.e_monthly_salary, "e_monthly_salary");
// 					validationInput(data.e_year_built, "e_year_built");
// 					validationInput(data.e_flag, "e_flag");
// 					validationInput(data.e_vessel_type, "e_vessel_type");
// 					validationInput(
// 						data.e_classification_society,
// 						"e_classification_society"
// 					);
// 					validationInput(data.e_hours_of_work, "e_hours_of_work");
// 					validationInput(data.e_vessel_name, "e_vessel_name");
// 					validationInput(data.e_imo_number, "e_imo_number");
// 					validationInput(data.e_gross_tonnage, "e_gross_tonnage");
// 					validationInput(data.e_overtime, "e_overtime");
// 					validationInput(
// 						data.e_vacation_leave_with_pay,
// 						"e_vacation_leave_with_pay"
// 					);
// 					validationInput(data.e_others, "e_others");
// 					validationInput(data.e_total_salary, "e_total_salary");
// 					validationInput(data.e_point_of_hire, "e_point_of_hire");
// 					validationInput(
// 						data.e_collective_agreement,
// 						"e_collective_agreement"
// 					);

// 					if (data.type) {
// 						Swal.fire({
// 							icon: data.type,
// 							title: data.title,
// 							text: data.text,
// 							confirmButtonText: "Close",
// 							allowOutsideClick: false,
// 							allowEscapeKey: false,
// 						}).then(function () {
// 							if (data.type === "success") {
// 								$("#edit_poea_contracts_modal").modal("hide");
// 								$("#view_promotion_checklist").modal("hide");
// 							}
// 						});
// 					}
// 					$("#btnSaveChanges_poea").html("Save Changes");
// 					$("#btnSaveChanges_poea").prop("disabled", false);
// 				},
// 			});
// 	});
// });
// function editMedical(id, crew_code) {
// 	$("#view_medical_modal").modal("hide");

// 	$.ajax({
// 		url: base_url + "get-medical-record",
// 		type: "POST",
// 		data: {
// 			id: id,
// 			crew_code: crew_code
// 		},
// 		dataType: "JSON",
// 		success: function (data) {
// 			$("#btnEditCloseMedical").val(data.crew_code);
// 			$("#e_m_crew_code").val(data.crew_code);
// 			$("#e_m_medical_code").val(data.medical_code);
// 			$("#e_m_date_med_exam").val(data.date_med_exam);
// 			$("#e_m_medical_expiry_date").val(data.e_m_medical_expiry_date);
// 			$("#e_m_status").val(data.medical_status);
// 			$("#e_m_add_remarks").val(data.remarks);
// 		}
// 	});

// 	$.ajax({
// 		url: base_url + "get-crew-information",
// 		type: "POST",
// 		data: {
// 			code: crew_code
// 		},
// 		dataType: "JSON",
// 		success: function (data) {
// 			$("#e_m_position").val(data.position);
// 		}
// 	});

// 	$.ajax({
// 		url: base_url + "get-applicant-information",
// 		type: "POST",
// 		data: {
// 			code: crew_code
// 		},
// 		dataType: "JSON",
// 		success: function (data) {
// 			var full_name =
// 				data.first_name + " " + data.middle_name + " " + data.last_name;

// 			$("#e_m_full_name").val(full_name);
// 			$("#e_m_height").val(data.height);
// 			$("#e_m_weight").val(data.weight);
// 			$("#e_m_age").val(getAge(data.birth_date));
// 			$("#e_m_bmi").val(formatBMI(data.height, data.weight).toFixed(2));
// 		}
// 	});

// 	$("#edit_medical_modal").modal("show");
// }
