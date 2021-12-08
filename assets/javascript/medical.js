$("#crew_filter_form").submit(function () {
	$.ajax({
		url: base_url + "medical-search",
		type: "POST",
		data: $("#crew_filter_form").serialize(),
		success: function (data) {
			location.reload(true);
		},
	});
});
$("#BtnResetSearch").click(function () {
	$.ajax({
		url: base_url + "medical-search-reset",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
});
//shipboard application
function showShipboardApplication(code) {
	shipboardApplicationPersonalInfoM(code);
	getApplicantsM(code);
	$("#v_crew_off_signer_modal").modal("show");
}

function getApplicantsM(crew_code) {
	$.ajax({
		url: base_url + "get-crew-information",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data != null) {
				$("#on_date_of_availability").html(
					!data.date_available ? "-" : formatDate(data.date_available)
				);
				$("#on_tentative_vessel").html(formatVessel(data.vessel_assign));
				$("#on_second_position").html(
					!data.position ? "-" : formatPosition(data.position)
				);
			}
		},
	});
}

function shipboardApplicationPersonalInfoM(code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#on_first_name").text(data.first_name);
			$("#on_middle_name").text(data.middle_name);
			$("#on_last_name").text(data.last_name);
			$("#on_suffix").text(data.suffix);
			$("#off_registered_name").text(
				data.first_name +
					" " +
					data.middle_name +
					" " +
					data.last_name +
					" " +
					data.suffix
			);
			$("#on_birth_date").text(formatDate(data.birth_date));
			$("#on_birth_place").text(data.birth_place);
			$("#on_civil_status").text(formatCivilStatus(data.civil_status));
			$("#on_email_address").text(data.email_address);
			$("#on_telephone_number").text(data.telephone_number);
			$("#on_mobile_number").text(data.mobile_number);
			$("#on_religion").text(formatReligion(data.religion));
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
			$("#on_city").text(formatCity(data.city));
			$("#on_country").text(data.country);
			$("#on_zip_code").text(data.zip_code);
			$("#on_provincial").text(data.provincial);

			getNextOfKin(data.applicant_code);
			getEducationalAttainment(data.applicant_code);
			getWorkingGears(data.applicant_code);
			getLicenses(data.applicant_code);
			getCertificates(data.applicant_code);
			getSeaServiceRecord(data.applicant_code);
		},
	});
}
function getNextOfKin(applicant_code) {
	$.ajax({
		url: base_url + "get-next-of-kin",
		type: "POST",
		data: {
			code: applicant_code,
		},
		dataType: "JSON",
		success: function (data) {
			let child_full_name = JSON.parse(data.name_of_children);
			let child_birth_date = JSON.parse(data.birthday_of_children);
			let child_mobile_number = JSON.parse(data.contact_of_children);

			$("#on_spouse_name").html(!data.spouse_name ? "-" : data.spouse_name);
			$("#on_no_of_occupation").html(!data.occupation ? "-" : data.occupation);
			$("#on_no_of_children").html(
				data.no_of_children == "none" ? "N/A" : data.no_of_children
			);
			if (data.no_of_children == "none") {
				$("#child_name_d").hide();
				$("#child_birthdate_d").hide();
				$("#child_mobile_d").hide();
			}
			for (let index = 0; index < data.no_of_children; index++) {
				$("#child_name_div").append(
					child_full_name[index]
						? '<p class="text-dark font-16 mt-0 mb-2" id="on_full_name_children">' +
								child_full_name[index] +
								"</p>"
						: '<p class="text-dark font-16 mt-0 mb-2" >-</p>'
				);
				$("#child_birth_date_div").append(
					child_birth_date[index]
						? '<p class="text-dark font-16 mt-0 mb-2" id="on_full_name_children">' +
								formatDate(child_birth_date[index]) +
								"</p>"
						: '<p class="text-dark font-16 mt-0 mb-2" >-</p>'
				);
				$("#child_mobile_div").append(
					child_mobile_number[index]
						? '<p class="text-dark font-16 mt-0 mb-2" id="on_mobile_no_children">' +
								child_mobile_number[index] +
								"</p>"
						: '<p class="text-dark font-16 mt-0 mb-2" >-</p>'
				);
			}

			$("#on_father_name").html(!data.father_name ? "-" : data.father_name);
			$("#on_mother_name").html(!data.mother_name ? "-" : data.mother_name);
			$("#on_address").html(!data.address ? "-" : data.address);
		},
	});
}

function getEducationalAttainment(applicant_code) {
	$.ajax({
		url: base_url + "get-educational-attainment",
		type: "POST",
		data: {
			code: applicant_code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#on_course").html(!data.course ? "-" : data.course);
			$("#on_school").html(!data.school ? "-" : data.school);
			$("#on_inclusive_years").html(
				!data.inclusive_years ? "-" : data.inclusive_years
			);
			$("#on_school_address").html(
				!data.school_address ? "-" : data.school_address
			);
		},
	});
}

function getWorkingGears(applicant_code) {
	$.ajax({
		url: base_url + "get-working-gears",
		type: "POST",
		data: {
			code: applicant_code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#on_cover_all").html(!data.cover_all ? "-" : data.cover_all);
			$("#on_winter_jacket").html(
				!data.winter_jacket ? "-" : data.winter_jacket
			);
			$("#on_shoes").html(!data.shoes ? "-" : data.shoes + " cm");
			$("#on_winter_boots").html(
				!data.winter_boots ? "-" : data.winter_boots + " bms"
			);
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

//edit shipboard
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
	getApplicantInformation(crew_code);
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

function PrintReport(c_type) {
	window.open(base_url + "print-medical" + "/" + c_type);
}

// function getViewPrejoiningRoutingSlip(monitor_code) {
// 	$.ajax({
// 		url: base_url + "get-routing-slip",
// 		type: "POST",
// 		data: {
// 			monitor_code: monitor_code,
// 		},
// 		dataType: "JSON",
// 		success: function (data) {
// 			if (data) {
// 				$(".crew_name").html(data.full_name);
// 				$(".crew_pos").html(
// 					data.position_name + "(" + data.position_code + ")"
// 				);
// 				$(".crew_vsl").html(data.vsl_name + "(" + data.vsl_code + ")");

// 				if (data.type_applicant === "CBA") {
// 					$("#with_cba").prop("checked", true);
// 					$("#with_cba").val(1);
// 				} else if (data.with_cba === "1") {
// 					$("#with_cba").prop("checked", true);
// 					$("#with_cba").val(1);
// 				} else {
// 					$("#with_cba").val(0);
// 				}

// 				$("#mntr_code").val(data.monitor_code);
// 				$("#crw_code").val(data.crew_code);

// 				if (data.routing_details) {
// 					var routing_details = JSON.parse(data.routing_details);
// 					for (let index = 0; index < routing_details.length; index++) {
// 						if (routing_details[index] == "1") {
// 							$("#mrsm_csd_" + index).prop("checked", true);
// 						} else if (routing_details[index] == "0") {
// 							$("#mrsm_cs_" + index).prop("checked", true);
// 						}
// 					}
// 				}

// 				if (data.remarks != null) {
// 					var r_remarks = JSON.parse(data.remarks);
// 					for (let i = 0; i < r_remarks.length; i++) {
// 						var index = i + 1;
// 						$("#mrsm_remarks_" + index).val(r_remarks[i]);
// 					}
// 				}

// 				if (data.dates != null) {
// 					var r_dates = JSON.parse(data.dates);
// 					for (let i = 0; i < r_dates.length; i++) {
// 						var index = i + 2;
// 						$("#mrsm_date_0").val(
// 							r_dates[0] ? r_dates[0] : formatDateForDate(data.actc_date)
// 						);
// 						$("#mrsm_date_1").val(
// 							r_dates[1] ? r_dates[1] : formatDateForDate(data.acis_date)
// 						);
// 						$("#mrsm_date_" + index).val(r_dates[index]);
// 					}
// 				} else {
// 					$("#mrsm_date_0").val(
// 						data.actc_date ? formatDateForDate(data.actc_date) : ""
// 					);
// 					$("#mrsm_date_1").val(
// 						data.acis_date ? formatDateForDate(data.acis_date) : ""
// 					);
// 				}
// 			}
// 		},
// 	});

// 	$("#manage_routing_slip_modal").modal("show");
// }
