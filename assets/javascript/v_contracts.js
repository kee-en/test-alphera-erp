$(function () {
	formVessel("e_vessel_name");
	formVessel("edit_mlc_vessel_name");

	formAllPosition("e_position");
	formAllPosition("edit_mlc_farer_duty");

	formTypeVessel("edit_mlc_vessel_type");
	formTypeVessel("e_vessel_type");

	formCivilStatus("e_civil_status");
	formReligion("e_religion");

	formNationality("e_nationality");
	formNationality("edit_mlc_farer_nationality");

	formProvince("e_province");
	formAllCity("e_city");
});

$("#crew_filter_form").submit(function () {
	$.ajax({
		url: base_url + "contract-crew-search",
		type: "POST",
		data: $("#crew_filter_form").serialize(),
		success: function (data) {
			location.reload(true);
		},
	});
});
$("#BtnResetSearch").click(function () {
	$.ajax({
		url: base_url + "contract-search-reset",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
});

// function viewCrewContracts(crew_code, name) {
// 	$("#contract_table_body").DataTable({
// 		ajax: {
// 			url: base_url + "get-crew-contract-table",
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

// 	$("#mlc_table_body").DataTable({
// 		ajax: {
// 			url: base_url + "get-crew-mlc-table",
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
// 	$("#c_crew_name").html(name);
// 	$("#v_contracts_modal").modal("show");
// }

function downloadCrewContract() {
	var crew_code = $("#c_crew_code").val();
	window.open(base_url + "template" + "/" + crew_code);
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
			shipboardApplicationPersonalInfoC(data.applicant_code);
			shipboardApplicationNextKin(data.applicant_code);
			shipboardApplicationEducation(data.applicant_code);
			shipboardApplicationWorkingGears(data.applicant_code);
			getLicenses(data.applicant_code);
			getCertificates(data.applicant_code);
			getSeaServiceRecord(data.applicant_code);
			getSeaserviceRecordTotal(data.applicant_code);
		},
	});
}

function shipboardApplicationPersonalInfoC(code) {
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

function removeContract(contract_code, monitor_code, crew_code) {
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
				url: base_url + "remove-poe-contract",
				type: "POST",
				data: {
					contract_code: contract_code,
					monitor_code: monitor_code,
					crew_code: crew_code,
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

function removeMlcContract(mlc_code) {
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
				url: base_url + "remove-mlc-contract",
				type: "POST",
				data: {
					mlc_code: mlc_code,
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

//Print
function printContract(contract_code) {
	window.open(base_url + "print-contract-poea" + "/" + contract_code);
}

function printContractMlc(monitor_code, mlc_type) {
	if (mlc_type === "1") {
		window.open(base_url + "print-contract-mlc-korean" + "/" + monitor_code);
	} else if (mlc_type === "2") {
		window.open(base_url + "print-contract-mlc-panama" + "/" + monitor_code);
	} else if (mlc_type === "3") {
		window.open(base_url + "print-contract-mlc-marshall" + "/" + monitor_code);
	}
}

function PrintReport(c_type) {
	window.open(base_url + "print-contract" + "/" + c_type);
}

function updateMLCv2(crew_code) {
	$.ajax({
		url: base_url + "get-mlc-details",
		type: "POST",
		dataType: "JSON",
		data: {
			code: crew_code,
		},
		success: function (data) {
			if (data) {
				for (let index = 0; index < data.length; index++) {
					var details = JSON.parse(data[index].agreement_details);
					var wage = JSON.parse(data[index].wage);
					var emp_period = JSON.parse(data[index].employment_period);

					if (data[index].mlc_type == "1") {
						$("#col_form_details").show();
						$("#col_form_mlc").show();

						$("#six_k_header").show();
						$("#seven_k_header").show();
						$("#eight_k_header").show();
						$("#nine_k_header").show();

						$("#six_korean_flag").show();
						$("#seven_korean_flag").show();
						$("#eight_korean_flag").show();
						$("#nine_korean_flag").show();
						$("#etc_korean_flag").show();

						$("#six_mp_header").hide();
						$("#seven_mp_header").hide();
						$("#eight_mp_header").hide();
						$("#nine_mp_header").hide();

						$("#six_panama_flag").hide();
						$("#seven_panama_flag").hide();
						$("#eight_panama_flag").hide();
						$("#nine_panama_flag").hide();
						$("#etc_panama_flag").hide();

						$("#six_marshall_flag").hide();
						$("#seven_marshall_flag").hide();
						$("#eight_marshall_flag").hide();
						$("#nine_marshall_flag").hide();
						$("#etc_marshall_flag").hide();
					} else if (data[index].mlc_type == "2") {
						$("#col_form_details").show();
						$("#col_form_mlc").show();

						$("#six_mp_header").show();
						$("#seven_mp_header").show();
						$("#eight_mp_header").show();
						$("#nine_mp_header").show();

						$("#six_k_header").hide();
						$("#seven_k_header").hide();
						$("#eight_k_header").hide();
						$("#nine_k_header").hide();

						$("#six_panama_flag").show();
						$("#seven_panama_flag").show();
						$("#eight_panama_flag").show();
						$("#nine_panama_flag").show();
						$("#etc_panama_flag").show();

						$("#six_marshall_flag").hide();
						$("#seven_marshall_flag").hide();
						$("#eight_marshall_flag").hide();
						$("#nine_marshall_flag").hide();
						$("#etc_marshall_flag").hide();

						$("#six_korean_flag").hide();
						$("#seven_korean_flag").hide();
						$("#eight_korean_flag").hide();
						$("#nine_korean_flag").hide();
						$("#etc_korean_flag").hide();
					} else if (data[index].mlc_type == "3") {
						$("#col_form_details").show();
						$("#col_form_mlc").show();

						$("#six_mp_header").show();
						$("#seven_mp_header").show();
						$("#eight_mp_header").show();
						$("#nine_mp_header").show();

						$("#six_k_header").hide();
						$("#seven_k_header").hide();
						$("#eight_k_header").hide();
						$("#nine_k_header").hide();

						$("#six_marshall_flag").show();
						$("#seven_marshall_flag").show();
						$("#eight_marshall_flag").show();
						$("#nine_marshall_flag").show();
						$("#etc_marshall_flag").show();

						$("#six_korean_flag").hide();
						$("#seven_korean_flag").hide();
						$("#eight_korean_flag").hide();
						$("#nine_korean_flag").hide();
						$("#etc_korean_flag").hide();

						$("#six_panama_flag").hide();
						$("#seven_panama_flag").hide();
						$("#eight_panama_flag").hide();
						$("#nine_panama_flag").hide();
						$("#etc_panama_flag").hide();
					}

					$("#edit_mlc_contract_modal").find("#crew_code").val(crew_code);
					$("#form_number").text(data[index].form_no);
					$("#revision_number").text(data[index].revision_no);
					$("#revision_date").text("2019-07-19");

					$("#edit_mlc_crew_name").html(data[index].crew_name);
					$("#c_edit_mlc_contract").val(data[index].mlc_type);
					$("#edit_mlc_form_number").val(data[index].form_no);
					$("#vc_revision_number").val(data[index].revision_no);
					$("#vc_revision_date").val(data[index].date_created);
					$("#edit_mlc_vessel_name").val(data[index].vessel_name);
					$("#edit_mlc_vessel_type").val(data[index].vessel_type);
					$("#edit_mlc_farer_name").val(data[index].crew_name);
					$("#edit_mlc_farer_duty").val(data[index].position);

					$("#edit_mlc_farer_passport").val(data[index].passport_no);
					$("#edit_mlc_farer_book").val(data[index].seamans_book);
					$("#edit_mlc_farer_license").val(data[index].license_no);

					$("#edit_mlc_farer_sex").val(data[index].gender);
					$("#edit_mlc_farer_sex").attr("readonly", true);
					$("#edit_mlc_farer_nationality").val(data[index].nationality);
					$("#edit_mlc_farer_birthdate").val(data[index].birth_date);
					$("#edit_mlc_sign_place").val(details ? details[0] : "");
					$("#edit_mlc_sign_date").val(details ? details[1] : "");

					$("#edit_mlc_bw").val(wage ? wage[0] : "");
					$("#edit_mlc_ot").val(wage ? wage[1] : "");
					$("#edit_mlc_pl").val(wage ? wage[2] : "");
					$("#edit_mlc_sa").val(wage ? wage[3] : "");
					$("#edit_mlc_rb").val(wage ? wage[4] : "");
					$("#edit_mlc_mts").val(wage ? wage[5] : "");
					$("#edit_mlc_fksu").val(wage ? wage[6] : "");
					$("#edit_mlc_mt").val(wage ? wage[7] : "");

					$("#edit_mlc_employment_period_from").val(
						emp_period ? emp_period[0] : ""
					);
					$("#edit_mlc_employment_period_to").val(
						emp_period ? emp_period[1] : ""
					);
					$("#edit_mlc_name_of_seafared").val(data[index].full_name);
					$("#edit_mlc_shipowner_vessel").val(data[index].shipowner_vessel);
					$("#edit_mlc_vp_alphera").val(data[index].name_of_vp);
				}
			}
		},
	});
	$("#edit_mlc_contract_modal").modal("show");

	$("#edit_mlc_contract_form").submit(function () {
		Swal.fire({
			title: "MLC Contract",
			text: "Are you sure you want to update crew's MLC contract?",
			icon: "warning",
			allowOutsideClick: !1,
			allowEscapeKey: !1,
			showCancelButton: !0,
			confirmButtonColor: "#004aad",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes",
		}).then((result) => {
			result.isConfirmed &&
				$.ajax({
					url: base_url + "update-mlc",
					type: "POST",
					data: $("#edit_mlc_contract_modal")
						.find("#edit_mlc_contract_form")
						.serialize(),
					beforeSend: function () {
						$("#btnSaveChanges_mlc").html(
							'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
						);
						$("#BtnAddContractMLC").prop("disabled", true);
					},
					success: function (data) {
						validationInput(data.edit_mlc_sign_place, "edit_mlc_sign_place");
						validationInput(data.edit_mlc_sign_date, "edit_mlc_sign_date");
						validationInput(data.edit_mlc_bw, "edit_mlc_bw");
						validationInput(data.edit_mlc_ot, "edit_mlc_ot");
						validationInput(data.edit_mlc_pl, "edit_mlc_pl");
						validationInput(data.edit_mlc_sa, "edit_mlc_sa");
						validationInput(data.edit_mlc_rb, "edit_mlc_rb");
						validationInput(data.edit_mlc_mts, "edit_mlc_mts");
						validationInput(data.edit_mlc_fksu, "edit_mlc_fksu");
						validationInput(data.edit_mlc_mt, "edit_mlc_mt");
						validationInput(
							data.edit_mlc_employment_period_from,
							"edit_mlc_employment_period_from"
						);
						validationInput(
							data.edit_mlc_employment_period_to,
							"edit_mlc_employment_period_to"
						);

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
									$("#edit_mlc_contract_modal").modal("hide");
									$("#view_promotion_checklist").modal("hide");
									location.reload();
								}
							});
						}
						$("#btnSaveChanges_mlc").html("Save Changes");
						$("#BtnAddContractMLC").prop("disabled", false);
					},
				});
		});
	});
}

function viewMLCv2(crew_code) {
	$.ajax({
		url: base_url + "get-mlc-details",
		type: "POST",
		dataType: "JSON",
		data: {
			code: crew_code,
		},
		success: function (data) {
			if (data) {
				for (let index = 0; index < data.length; index++) {
					var details = JSON.parse(data[index].agreement_details);
					var wage = JSON.parse(data[index].wage);
					var emp_period = JSON.parse(data[index].employment_period);

					if (data[index].mlc_type == "1") {
						$("#col_form_details").show();
						$("#col_form_mlc").show();

						$("#six_k_header").show();
						$("#seven_k_header").show();
						$("#eight_k_header").show();
						$("#nine_k_header").show();

						$("#six_korean_flag").show();
						$("#seven_korean_flag").show();
						$("#eight_korean_flag").show();
						$("#nine_korean_flag").show();
						$("#etc_korean_flag").show();

						$("#six_mp_header").hide();
						$("#seven_mp_header").hide();
						$("#eight_mp_header").hide();
						$("#nine_mp_header").hide();

						$("#six_panama_flag").hide();
						$("#seven_panama_flag").hide();
						$("#eight_panama_flag").hide();
						$("#nine_panama_flag").hide();
						$("#etc_panama_flag").hide();

						$("#six_marshall_flag").hide();
						$("#seven_marshall_flag").hide();
						$("#eight_marshall_flag").hide();
						$("#nine_marshall_flag").hide();
						$("#etc_marshall_flag").hide();
					} else if (data[index].mlc_type == "2") {
						$("#col_form_details").show();
						$("#col_form_mlc").show();

						$("#six_mp_header").show();
						$("#seven_mp_header").show();
						$("#eight_mp_header").show();
						$("#nine_mp_header").show();

						$("#six_k_header").hide();
						$("#seven_k_header").hide();
						$("#eight_k_header").hide();
						$("#nine_k_header").hide();

						$("#six_panama_flag").show();
						$("#seven_panama_flag").show();
						$("#eight_panama_flag").show();
						$("#nine_panama_flag").show();
						$("#etc_panama_flag").show();

						$("#six_marshall_flag").hide();
						$("#seven_marshall_flag").hide();
						$("#eight_marshall_flag").hide();
						$("#nine_marshall_flag").hide();
						$("#etc_marshall_flag").hide();

						$("#six_korean_flag").hide();
						$("#seven_korean_flag").hide();
						$("#eight_korean_flag").hide();
						$("#nine_korean_flag").hide();
						$("#etc_korean_flag").hide();
					} else if (data[index].mlc_type == "3") {
						$("#col_form_details").show();
						$("#col_form_mlc").show();

						$("#six_mp_header").show();
						$("#seven_mp_header").show();
						$("#eight_mp_header").show();
						$("#nine_mp_header").show();

						$("#six_k_header").hide();
						$("#seven_k_header").hide();
						$("#eight_k_header").hide();
						$("#nine_k_header").hide();

						$("#six_marshall_flag").show();
						$("#seven_marshall_flag").show();
						$("#eight_marshall_flag").show();
						$("#nine_marshall_flag").show();
						$("#etc_marshall_flag").show();

						$("#six_korean_flag").hide();
						$("#seven_korean_flag").hide();
						$("#eight_korean_flag").hide();
						$("#nine_korean_flag").hide();
						$("#etc_korean_flag").hide();

						$("#six_panama_flag").hide();
						$("#seven_panama_flag").hide();
						$("#eight_panama_flag").hide();
						$("#nine_panama_flag").hide();
						$("#etc_panama_flag").hide();
					}

					$("#edit_mlc_contract_modal").find("#crew_code").val(crew_code);
					$("#form_number").text(data[index].form_no);
					$("#revision_number").text(data[index].revision_no);
					$("#revision_date").text("2019-07-19");

					$("#edit_mlc_crew_name").html(data[index].crew_name);
					$("#c_edit_mlc_contract").val(data[index].mlc_type);
					$("#edit_mlc_form_number").val(data[index].form_no);
					$("#vc_revision_number").val(data[index].revision_no);
					$("#vc_revision_date").val(data[index].date_created);
					$("#edit_mlc_vessel_name").val(data[index].vessel_name);
					$("#edit_mlc_vessel_type").val(data[index].vessel_type);
					$("#edit_mlc_farer_name").val(data[index].crew_name);
					$("#edit_mlc_farer_duty").val(data[index].position);

					$("#edit_mlc_farer_passport").val(data[index].passport_no);
					$("#edit_mlc_farer_book").val(data[index].seamans_book);
					$("#edit_mlc_farer_license").val(data[index].license_no);

					$("#edit_mlc_farer_sex").val(data[index].gender);
					$("#edit_mlc_farer_sex").attr("readonly", true);
					$("#edit_mlc_farer_nationality").val(data[index].nationality);
					$("#edit_mlc_farer_birthdate").val(data[index].birth_date);
					$("#edit_mlc_sign_place").val(details ? details[0] : "");
					$("#edit_mlc_sign_date").val(details ? details[1] : "");

					$("#edit_mlc_bw").val(wage ? wage[0] : "");
					$("#edit_mlc_ot").val(wage ? wage[1] : "");
					$("#edit_mlc_pl").val(wage ? wage[2] : "");
					$("#edit_mlc_sa").val(wage ? wage[3] : "");
					$("#edit_mlc_rb").val(wage ? wage[4] : "");
					$("#edit_mlc_mts").val(wage ? wage[5] : "");
					$("#edit_mlc_fksu").val(wage ? wage[6] : "");
					$("#edit_mlc_mt").val(wage ? wage[7] : "");

					$("#edit_mlc_employment_period_from").val(
						emp_period ? emp_period[0] : ""
					);
					$("#edit_mlc_employment_period_to").val(
						emp_period ? emp_period[1] : ""
					);
					$("#edit_mlc_name_of_seafared").val(data[index].full_name);
					$("#edit_mlc_shipowner_vessel").val(data[index].shipowner_vessel);
					$("#edit_mlc_vp_alphera").val(data[index].name_of_vp);
				}
			}
		},
	});
	$("#hid_crew_code").val(crew_code);
	$("#edit_mlc_contract_modal")
		.find("input,select,textarea")
		.prop("disabled", true);
	$("#btnSaveChanges_mlc").prop("hidden", true);
	$("#edit_mlc_contract_modal").modal("show");
}

function updatePOEAv2(crew_code) {
	$.ajax({
		url: base_url + "get-poea-details",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			for (let index = 0; index < data.length; index++) {
				$("#e_poea_crew_name").html(data[index].full_name);
				$("#e_sirb_no").val(data[index].sirb_no);
				$("#e_src_no").val(data[index].src_no);
				$("#e_license_no").val(data[index].license);
				$("#e_name_of_agent").val(data[index].agent_name);
				$("#e_name_of_principal").val(data[index].ps_name);
				$("#e_address_of_principal").val(data[index].ps_address);
				$("#e_vessel_name").val(data[index].vessel_name);
				$("#e_imo_number").val(data[index].imo_no);
				$("#e_gross_tonnage").val(data[index].grt);
				$("#e_year_built").val(data[index].year_build);
				$("#e_flag").val(data[index].flag);
				$("#e_vessel_type").val(
					formatVesselTypeIdByVessel(data[index].vessel_type)
				);
				$("#e_classification_society").val(data[index].society_classification);
				$("#e_duration_contract").val(data[index].contract_duration);
				$("#e_position").val(data[index].position);
				$("#e_monthly_salary").val(data[index].monthly_salary);
				$("#e_hours_of_work").val(data[index].work_hours);
				$("#e_overtime").val(data[index].ot);
				$("#e_vacation_leave_with_pay").val(data[index].vl_pay);
				$("#e_others").val(data[index].others);
				$("#e_total_salary").val(data[index].total_salary);
				$("#e_point_of_hire").val(data[index].hire_point);
				$("#e_collective_agreement").val(data[index].collective_agreement);
			}
			$("#hid_crew_code").val(crew_code);
		},
	});

	$("#edit_poea_contracts_modal").modal("show");

	$("#edit_poea_contract_form").submit(function () {
		Swal.fire({
			title: "POEA Contract",
			text: "Are you sure you want to update crew's POEA contract?",
			icon: "warning",
			allowOutsideClick: !1,
			allowEscapeKey: !1,
			showCancelButton: !0,
			confirmButtonColor: "#004aad",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes",
		}).then((result) => {
			result.isConfirmed &&
				$.ajax({
					url: base_url + "update-poea",
					type: "POST",
					data: $("#edit_poea_contract_form").serialize(),
					beforeSend: function () {
						$("#btnSaveChanges_poea").html(
							'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
						);
						$("#btnSaveChanges_poea").prop("disabled", true);
					},
					success: function (data) {
						validationInput(data.e_license_no, "e_license_no");
						validationInput(data.e_sirb_no, "e_sirb_no");
						validationInput(data.e_src_no, "e_src_no");
						validationInput(data.e_name_of_agent, "e_name_of_agent");
						validationInput(data.e_name_of_principal, "e_name_of_principal");
						validationInput(
							data.e_address_of_principal,
							"e_address_of_principal"
						);
						validationInput(data.e_duration_contract, "e_duration_contract");
						validationInput(data.e_position, "e_position");
						validationInput(data.e_monthly_salary, "e_monthly_salary");
						validationInput(data.e_year_built, "e_year_built");
						validationInput(data.e_flag, "e_flag");
						validationInput(data.e_vessel_type, "e_vessel_type");
						validationInput(
							data.e_classification_society,
							"e_classification_society"
						);
						validationInput(data.e_hours_of_work, "e_hours_of_work");
						validationInput(data.e_vessel_name, "e_vessel_name");
						validationInput(data.e_imo_number, "e_imo_number");
						validationInput(data.e_gross_tonnage, "e_gross_tonnage");
						validationInput(data.e_overtime, "e_overtime");
						validationInput(
							data.e_vacation_leave_with_pay,
							"e_vacation_leave_with_pay"
						);
						validationInput(data.e_others, "e_others");
						validationInput(data.e_total_salary, "e_total_salary");
						validationInput(data.e_point_of_hire, "e_point_of_hire");
						validationInput(
							data.e_collective_agreement,
							"e_collective_agreement"
						);
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
									$("#edit_poea_contracts_modal").modal("hide");
									$("#view_promotion_checklist").modal("hide");
									location.reload();
								}
							});
						}
						$("#btnSaveChanges_poea").html("Save Changes");
						$("#btnSaveChanges_poea").prop("disabled", false);
					},
				});
		});
	});
}

function viewPOEAv2(crew_code, contract_code) {
	$.ajax({
		url: base_url + "get-view-poea-details",
		type: "POST",
		data: {
			code: crew_code,
			contract_code: contract_code,
		},
		dataType: "JSON",
		success: function (data) {
			for (let index = 0; index < data.length; index++) {
				$("#e_poea_crew_name").html(data[index].full_name);
				$("#e_sirb_no").val(data[index].sirb_no);
				$("#e_src_no").val(data[index].src_no);
				$("#e_license_no").val(data[index].license);
				$("#e_name_of_agent").val(data[index].agent_name);
				$("#e_name_of_principal").val(data[index].ps_name);
				$("#e_address_of_principal").val(data[index].ps_address);
				$("#e_vessel_name").val(data[index].vessel_name);
				$("#e_imo_number").val(data[index].imo_no);
				$("#e_gross_tonnage").val(data[index].grt);
				$("#e_year_built").val(data[index].year_build);
				$("#e_flag").val(data[index].flag);
				$("#e_vessel_type").val(
					formatVesselTypeIdByVessel(data[index].vessel_type)
				);
				$("#e_classification_society").val(data[index].society_classification);
				$("#e_duration_contract").val(data[index].contract_duration);
				$("#e_position").val(data[index].position);
				$("#e_monthly_salary").val(data[index].monthly_salary);
				$("#e_hours_of_work").val(data[index].work_hours);
				$("#e_overtime").val(data[index].ot);
				$("#e_vacation_leave_with_pay").val(data[index].vl_pay);
				$("#e_others").val(data[index].others);
				$("#e_total_salary").val(data[index].total_salary);
				$("#e_point_of_hire").val(data[index].hire_point);
				$("#e_collective_agreement").val(data[index].collective_agreement);
			}
			$("#hid_crew_code").val(crew_code);
			$("#edit_poea_contracts_modal")
				.find("input,select,textarea")
				.prop("disabled", true);
			$("#btnSaveChanges_poea").prop("hidden", true);
		},
	});

	$("#edit_poea_contracts_modal").modal("show");
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
