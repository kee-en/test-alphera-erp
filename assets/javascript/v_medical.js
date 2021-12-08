// function getMedicalRecords(crew_code, name) {
// 	$("#medical_table").DataTable({
// 		ajax: {
// 			url: base_url + "get-medical-records-table",
// 			type: "POST",
// 			data: { crew_code: crew_code },
// 		},
// 		language: {
// 			paginate: {
// 				previous: "<i class='mdi mdi-chevron-left'>",
// 				next: "<i class='mdi mdi-chevron-right'>",
// 			},
// 		},
// 		drawCallback: function () {
// 			$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
// 		},
// 	});
// 	$("#m_crew_name").html(name);
// }

$("#MedicalBtnClose").click(function () {
	$("#medical_table").DataTable().clear().draw();
	location.reload(true);
});

function removeMedical(id, medical_code) {
	Swal.fire({
		title: "Are you sure you want to remove this?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, remove it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "remove-medical-record",
				type: "POST",
				data: {
					id: id,
					medical_code: medical_code,
				},
				dataType: "JSON",
				success: function (data) {
					if (data.type) {
						Swal.fire({
							icon: data.type,
							title: data.title,
							text: data.text,
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							if (data.type === "success") {
								location.reload(true);
							}
						});
					}
				},
			});
		}
	});
}

//view shipboard
function viewOffsignerDetails(code) {
	evaluationFormApplicant(code);
	$("#v_crew_off_signer_modal").modal("show");
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
			shipboardApplicationPersonalInfoV(data.applicant_code);
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

function shipboardApplicationPersonalInfoV(code) {
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
			$("#on_suffix").text(data.suffix);
			$("#off_registered_name").text(full_name);
			$("#on_birth_date").text(data.birth_date);
			$("#on_birth_place").text(data.birth_place);
			$("#on_civil_status").text(data.civil_status);
			$("#on_email_address").text(data.email_address);
			$("#on_telephone_number").text(data.telephone_number);
			$("#on_mobile_number").text(data.mobile_number);
			$("#on_religion").text(data.religion);
			$("#on_nationality").text(data.nationality);
			$("#on_sss_no").text(data.sss_no);
			$("#on_tin_no").text(data.tin_number);
			$("#on_philhealth_no").text(data.philhealth_no);
			$("#on_pag_ibig_no").text(data.pag_ibig_no);
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

			$("#on_spouse_name").text(data.spouse_name);
			$("#on_occupation").text(data.occupation);
			$("#on_no_of_children").text(data.no_of_children);

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

			$("#on_father_name").text(data.father_name);
			$("#on_mother_name").text(data.mother_name);
			$("#on_kin_address").text(data.address);
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
			$("#on_course").text(data.course);
			$("#on_school").text(data.school);
			$("#on_inclusive_years").text(data.inclusive_years);
			$("#on_school_address").text(data.school_address);
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
			$("#on_cover_all").text(data.cover_all);
			$("#on_winter_jacket").text(data.winter_jacket);
			$("#on_shoes").text(data.shoes);
			$("#on_winter_boots").text(data.winter_boots);
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
//end

function getViewOffSignerApplication(monitor_code) {
	getCrewInformation(monitor_code);
	$("#v_e_crew_information_modal").modal("show");
}

function getCrewInformation(monitor_code) {
	$.ajax({
		url: base_url + "get-crew-details",
		type: "POST",
		data: {
			monitor_code: monitor_code,
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
			getApplicantInformation(data.crew_code);
			getNextOfKin(data.crew_code);
			getEducationalAttainment(data.crew_code);
			getWorkingGears(data.crew_code);
		},
	});
}

function getApplicantInformation(crew_code) {
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

function editMedical(medical_code, crew_code) {
	$("#view_medical_modal").modal("hide");

	$.ajax({
		url: base_url + "get-medical-record",
		type: "POST",
		data: {
			medical_code: medical_code,
			crew_code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			for (let index = 0; index < data.length; index++) {
				$("#e_m_crew_code").val(data[index].crew_code);
				$("#e_m_medical_code").val(medical_code);
				$("#e_m_date_med_exam").val(data[index].date_med_exam);
				$("#e_m_medical_expiry_date").val(data[index].medical_expiry_date);
				$("#e_m_status").val(data[index].medical_status);
				$("#e_m_add_remarks").val(data[index].remarks);
				$("#e_m_position").val(data[index].position_name);
				$("#e_m_full_name").val(data[index].full_name);
				$("#e_m_height").val(data[index].medical_height);
				$("#e_m_weight").val(data[index].medical_weight);
				$("#e_m_age").val(getAge(data[index].birth_date));
				$("#e_m_bmi").val(
					formatBMI(
						data[index].medical_height,
						data[index].medical_weight
					).toFixed(2)
				);

				if (data[index].details) {
					var details = JSON.parse(data[index].details);
					$("#e_m_waistline").val(details.waist_line);
					$("#e_m_cholesterol").val(details.cholosterol);
					$("#e_m_triglycerides").val(details.triglycerides);
					$("#e_m_fbs").val(details.fbs);
					$("#e_m_sgpt").val(details.sgpt);
					$("#e_m_sgot").val(details.sgot);
					$("#e_m_ldl").val(details.ldl);
					$("#e_m_hdl").val(details.hdl);
					$("#e_m_bp").val(details.bp);
					$("#e_m_specific_ailment").val(details.specific_ailment);
				}

				if (data[index].medical_status == "1") {
					$(".e-pending").show();
				}
			}
		},
	});

	$("#edit_medical_modal").modal("show");
}

function viewMedical(medical_code, crew_code) {
	$("#view_medical_modal").modal("hide");

	$.ajax({
		url: base_url + "get-medical-record",
		type: "POST",
		data: {
			medical_code: medical_code,
			crew_code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			for (let index = 0; index < data.length; index++) {
				$("#e_m_crew_code").val(data[index].crew_code);
				$("#e_m_medical_code").val(medical_code);
				$("#e_m_date_med_exam").val(data[index].date_med_exam);
				$("#e_m_medical_expiry_date").val(data[index].medical_expiry_date);
				$("#e_m_status").val(data[index].medical_status);
				$("#e_m_add_remarks").val(data[index].remarks);
				$("#e_m_position").val(data[index].position_name);
				$("#e_m_full_name").val(data[index].full_name);
				$("#e_m_height").val(data[index].medical_height);
				$("#e_m_weight").val(data[index].medical_weight);
				$("#e_m_age").val(getAge(data[index].birth_date));
				$("#e_m_bmi").val(
					formatBMI(
						data[index].medical_height,
						data[index].medical_weight
					).toFixed(2)
				);

				if (data[index].details) {
					var details = JSON.parse(data[index].details);
					$("#e_m_waistline").val(details.waist_line);
					$("#e_m_cholesterol").val(details.cholosterol);
					$("#e_m_triglycerides").val(details.triglycerides);
					$("#e_m_fbs").val(details.fbs);
					$("#e_m_sgpt").val(details.sgpt);
					$("#e_m_sgot").val(details.sgot);
					$("#e_m_ldl").val(details.ldl);
					$("#e_m_hdl").val(details.hdl);
					$("#e_m_bp").val(details.bp);
					$("#e_m_specific_ailment").val(details.specific_ailment);
				}

				if (data[index].medical_status == "1") {
					$(".e-pending").show();
				}
			}
		},
	});

	$("#edit_medical_modal").find("input,select,textarea").prop("disabled", true);
	$("#edit_medical_modal").find("#BtnEditMedical").prop("hidden", true);
	$("#edit_medical_modal").modal("show");
}

$("#e_m_status").on("change", function () {
	if ($(this).val() === "1") {
		$(".e-pending").show();
	} else {
		$(".e-pending").hide();
		$("#e_waistline").val("");
		$("#e_cholesterol").val("");
		$("#e_triglycerides").val("");
		$("#e_fbs").val("");
		$("#e_sgpt").val("");
		$("#e_sgot").val("");
		$("#e_ldl").val("");
		$("#e_hdl").val("");
		$("#e_bp").val("");
		$("#e_specimen_ailment").val();
	}
});
