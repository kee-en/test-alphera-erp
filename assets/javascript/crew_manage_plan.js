$(function () {
	formCivilStatus("e_civil_status");
	formReligion("e_religion");
	formNationality("e_nationality");
	formProvince("e_province");
	formAllCity("e_city");

	$("#btn_grid").click(function () {
		$("#view_grid").show();
		$("#view_list").hide();
	});

	$("#btn_list").click(function () {
		$("#view_grid").hide();
		$("#view_list").show();
	});

	$("#crew_filter_form").submit(function () {
		$.ajax({
			url: base_url + "cmp-search",
			type: "POST",
			data: $("#crew_filter_form").serialize(),
			success: function (data) {
				window.location.replace(base_url + "crew-management-plan");
			},
		});
	});

	$("#BtnResetSearch").click(function () {
		$.ajax({
			url: base_url + "cmp-search-reset",
			type: "POST",
			success: function (data) {
				location.reload(true);
			},
		});
	});
});

function PrintCMPReport(c_type) {
	window.open(base_url + "print-cmp" + "/" + c_type);
}

function selectOnSigner(cmp_code, input_number) {
	var monitor_code = $(
		"#on_signer_crew_" + cmp_code + "_" + input_number
	).val();

	Swal.fire({
		title: "Are you sure you want to select this as On Signer?",
		icon: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
		allowEscapeKey: false,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: base_url + "select-on-signer",
				type: "POST",
				data: {
					cmp_code: cmp_code,
					monitor_code: monitor_code,
				},
				dataType: "JSON",
				success: function (data) {
					if (data.type === "success") {
						Swal.fire({
							icon: data.type,
							title: data.title,
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							$("#on_signer_crew_" + cmp_code).attr("disabled", true);
							$("#onsigner_menu_" + cmp_code).removeAttr("style");
							location.reload(true);
						});
					}
				},
			});
		} else {
			$("#on_signer_crew_" + cmp_code + "_" + input_number).val("");
		}
	});
}

function test(cmp_code) {
	alert("here" + cmp_code);
}

function removeOnSigner(cmp_code) {
	Swal.fire({
		title: "Are you sure you want to remove this as On Signer?",
		icon: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
		allowEscapeKey: false,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, remove it!",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: base_url + "remove-on-signer",
				type: "POST",
				data: {
					cmp_code: cmp_code,
				},
				dataType: "JSON",
				success: function (data) {
					if (data.type === "success") {
						Swal.fire({
							icon: data.type,
							title: data.title,
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							$("#on_signer_crew_" + cmp_code).removeAttr("disabled");
							$("#onsigner_menu_" + cmp_code).css("display", "none");
							$("#on_signer_crew_" + cmp_code).val("");

							location.reload(true);
						});
					}
				},
			});
		}
	});
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
	$("#view_license").val(crew_code);
	$("#btn_edit_certificates").val(crew_code);
	$("#btn_view_certificates_edit").val(crew_code);
	$("#vepjv_crew_name").html(name);
	$("#v_e_pre_joining_visa_modal_licenses").modal("show");
}

function getViewPrejoiningVisa(crew_code, name) {
	$.ajax({
		url: base_url + "get-list-licenses",
		type: "POST",
		data: { code: crew_code },
		success: function (data) {
			$("#crew_list_licenses").empty();
			$("#crew_list_licenses").html(data);
		},
	});

	$.ajax({
		url: base_url + "get-list-certificates",
		type: "POST",
		data: { code: crew_code },
		success: function (data) {
			$("#crew_list_certificates").empty();
			$("#crew_list_certificates").html(data);
		},
	});

	$("#btn_edit_license").hide();
	$("#btn_edit_certificates").hide();
	$("#cert_crew_name").html(name);
	$("#pre_joining_visa_modal").modal("show");
}

// function viewCrewContracts(crew_code, name) {
// 	var current_date = new Date();
// 	$.ajax({
// 		url: base_url + "get-crew-contract-table",
// 		type: "POST",
// 		dataType: "JSON",
// 		data: { crew_code: crew_code },
// 		success: function (data) {
// 			var crew_arr = data.crew;
// 			if (Array.isArray(crew_arr) && crew_arr.length) {
// 				var count = 1;
// 				$.each(crew_arr, function (i, item) {
// 					$("#contract_table_body").append(
// 						'<tr><td class="text-center">' +
// 							count +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							crew_arr[i].contract_type +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							crew_arr[i].request_type +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							formatDate(crew_arr[i].date_created) +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							(crew_arr[i].contract_duration > current_date
// 								? "EXPIRED"
// 								: "VALID") +
// 							"</td>" +
// 							'<td><button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#" onclick="editContract(\'' +
// 							crew_arr[i].id +
// 							'\')">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeContract(\'' +
// 							crew_arr[i].id +
// 							"')\">Remove</button></td>" +
// 							+"</tr>"
// 					);
// 					count++;
// 				});
// 			} else {
// 				$("#contract_table_body").append(
// 					'<tr><td class="text-center" colspan="6">No data available in table</td></tr>'
// 				);
// 			}
// 			$("#pagination").append(data.showing_entries);
// 		},
// 	});
// 	$("#c_crew_name").html(name);
// 	$("#v_contracts_modal").modal("show");
// }

function OnviewCrewContracts(code) {
	var current_date = new Date();
	OnviewCrewMlcContract(code);
	$.ajax({
		url: base_url + "get-cmpcrew-contract-table",
		type: "POST",
		dataType: "JSON",
		data: { code: code },
		success: function (data) {
			var crew_arr = data.data;
			if (Array.isArray(crew_arr) && crew_arr.length) {
				var count = 1;
				$.each(crew_arr, function (i, item) {
					$("#contract_table_body").append(
						"<tr><td>" +
							count +
							"</td>" +
							"<td>" +
							crew_arr[i].contract_type +
							"</td>" +
							"<td>" +
							(crew_arr[i].contract_duration > current_date
								? "EXPIRED"
								: crew_arr[i].contract_duration) +
							"</td>" +
							"<td>" +
							crew_arr[i].issued_by +
							"</td>" +
							"<td>" +
							formatDate(crew_arr[i].date_created) +
							"</td>" +
							"<td>" +
							crew_arr[i].action +
							"</td>" +
							+"</tr>"
					);
					count++;
				});
			} else {
				$("#contract_table_body").append(
					'<tr><td class="text-center" colspan="6">No data available in table</td></tr>'
				);
			}
			$("#pagination").append(data.showing_entries);
		},
	});
	$("#c_crew_name").html(getNameByCmpcode(code));
	$("#v_contracts_modal").modal("show");
}
function OnviewCrewMlcContract(code) {
	var current_date = new Date();
	$.ajax({
		url: base_url + "get-cmpcrew-mlc-table",
		type: "POST",
		dataType: "JSON",
		data: { code: code },
		success: function (data) {
			var crew_arr = data.data;
			if (Array.isArray(crew_arr) && crew_arr.length) {
				var count = 1;
				$.each(crew_arr, function (i, item) {
					$("#mlc_table_body").append(
						'<tr><td class="text-center">' +
							crew_arr[i].count +
							"</td>" +
							'<td class="text-center">' +
							crew_arr[i].contract_type +
							"</td>" +
							'<td class="text-center">' +
							crew_arr[i].issued_by +
							"</td>" +
							'<td class="text-center">' +
							crew_arr[i].mlc_type +
							"</td>" +
							'<td class="text-center">' +
							formatDate(crew_arr[i].date_created) +
							"</td>" +
							"<td> " +
							crew_arr[i].action +
							"</td>" +
							+"</tr>"
					);
					count++;
				});
			} else {
				$("#mlc_table_body").append(
					'<tr><td class="text-center" colspan="6">No data available in table</td></tr>'
				);
			}
			$("#pagination").append(data.showing_entries);
		},
	});
	$("#c_crew_name").html(getNameByCmpcode(code));
	$("#v_contracts_modal").modal("show");
}

// function getMedicalRecords(crew_code, name) {
// 	$.ajax({
// 		url: base_url + "get-medical-records-table",
// 		type: "POST",
// 		dataType: "JSON",
// 		data: { crew_code: crew_code },
// 		success: function (data) {
// 			var crew_arr = data.crew;

// 			if (Array.isArray(crew_arr) && crew_arr.length) {
// 				var count = 1;
// 				$.each(crew_arr, function (i, item) {
// 					var status = "";
// 					if (crew_arr[i].medical_status === "1") {
// 						status = "PENDING";
// 					} else if (crew_arr[i].medical_status === "2") {
// 						status = "FIT FOR SEA DUTY";
// 					} else {
// 						status = "WITH APPROVAL";
// 					}

// 					$("#medical_table").append(
// 						'<tr><td class="text-center">' +
// 							count +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							formatDate(crew_arr[i].date_med_exam) +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							formatDate(crew_arr[i].date_follow_up) +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							getUserPosition(crew_arr[i].crew_code) +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							status +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							formatDate(crew_arr[i].date_created) +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							crew_arr[i].remarks +
// 							"</td>" +
// 							'<td class="text-center">' +
// 							crew_arr[i].medical_bmi +
// 							"</td>" +
// 							"<td>" +
// 							(crew_arr[i].medical_status === "3"
// 								? ""
// 								: '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#" onclick="editMedical(\'' +
// 								  crew_arr[i].id +
// 								  "','" +
// 								  crew_arr[i].crew_code +
// 								  "')\">Edit</button>") +
// 							'<button type="button" class="btn btn-outline-danger btn-xs" onclick="removeMedical(\'' +
// 							crew_arr[i].id +
// 							"')\">Remove</button></td>" +
// 							+"</tr>"
// 					);
// 					count++;
// 				});
// 			} else {
// 				$("#medical_table").append(
// 					'<tr><td class="text-center" colspan="9">No data available in table</td></tr>'
// 				);
// 			}
// 			$("#pagination").append(data.showing_entries);
// 		},
// 	});
// 	$("#m_crew_name").html(name);
// }

function getOnMedicalRecords(code) {
	$.ajax({
		url: base_url + "get-cmp-medical-records-table",
		type: "POST",
		dataType: "JSON",
		data: { code: code },
		success: function (data) {
			var crew_arr = data.crew;

			if (Array.isArray(crew_arr) && crew_arr.length) {
				var count = 1;
				$.each(crew_arr, function (i, item) {
					var status = "";
					if (crew_arr[i].medical_status === "1") {
						status = "PENDING";
					} else if (crew_arr[i].medical_status === "2") {
						status = "FIT FOR SEA DUTY";
					} else {
						status = "WITH APPROVAL";
					}

					$("#cmp_medical_table").append(
						'<tr><td class="text-center">' +
							count +
							"</td>" +
							'<td class="text-center">' +
							formatDate(crew_arr[i].date_med_exam) +
							"</td>" +
							'<td class="text-center">' +
							formatDate(crew_arr[i].date_follow_up) +
							"</td>" +
							'<td class="text-center">' +
							getUserPosition(crew_arr[i].crew_code) +
							"</td>" +
							'<td class="text-center">' +
							status +
							"</td>" +
							'<td class="text-center">' +
							formatDate(crew_arr[i].date_created) +
							"</td>" +
							'<td class="text-center">' +
							crew_arr[i].remarks +
							"</td>" +
							'<td class="text-center">' +
							crew_arr[i].medical_bmi +
							"</td>" +
							"<td>" +
							(crew_arr[i].medical_status === "3"
								? ""
								: '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#" onclick="editMedical(\'' +
								  crew_arr[i].id +
								  "','" +
								  crew_arr[i].crew_code +
								  "')\">Edit</button>") +
							'<button type="button" class="btn btn-outline-danger btn-xs" onclick="removeMedical(\'' +
							crew_arr[i].id +
							"')\">Remove</button></td>" +
							+"</tr>"
					);
					count++;
				});
			} else {
				$("#cmp_medical_table").append(
					'<tr><td class="text-center" colspan="9">No data available in table</td></tr>'
				);
			}
			$("#pagination").append(data.showing_entries);
		},
	});
	$("#cmp_m_crew_name").html(getNameByCmpcode(code));
	$("#cmp_medical_modal").modal("show");
}

$("#MedicalBtnClose").click(function () {
	location.reload(true);
});
$("#BtnCloseVisaCertificate").click(function () {
	location.reload(true);
});

//ONSIGNER
function showShipboardAppOnsigner(code) {
	$.ajax({
		url: base_url + "get-cmp-information",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#on_date_of_availability").html(formatDate(data.disembark));
			$("#on_tentative_vessel").html(formatVessel(data.vessel_assign));
			$("#on_second_position").html(formatPosition(data.position));

			$("#on_first_name").text(data.first_name);
			$("#on_middle_name").text(data.middle_name);
			$("#on_last_name").text(data.last_name);
			$("#on_suffix").text(!data.suffix ? "-" : data.suffix);
			$("#off_registered_name").text(
				data.first_name +
					" " +
					data.middle_name +
					" " +
					data.last_name +
					" " +
					data.suffix
			);
			$("#epvm_crew_name").text(
				data.first_name +
					" " +
					data.middle_name +
					" " +
					data.last_name +
					" " +
					data.suffix
			);
			$("#on_birth_date").text(formatDate(data.birth_date));
			$("#on_birth_place").text(!data.birth_place ? "-" : data.birth_place);
			$("#on_civil_status").text(formatCivilStatus(data.civil_status));
			$("#on_email_address").text(
				!data.email_address ? "-" : data.email_address
			);
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
			$("#on_height").text(!data.height ? "-" : data.height);
			$("#on_weight").text(!data.weight ? "-" : data.weight);
			$("#on_bmi").text(formatBMI(data.height, data.weight).toFixed(2));
			$("#on_home_address").text(
				data.street_address +
					" " +
					data.barangay +
					" " +
					formatCity(data.city) +
					", " +
					formatProvince(data.region)
			);
			$("#on_zip_code").text(!data.zip_code ? "-" : data.zip_code);
			$("#on_provincial").text(!data.provincial ? "-" : data.provincial);

			let child_full_name = JSON.parse(data.name_of_children);
			let child_birth_date = JSON.parse(data.birthday_of_children);
			let child_mobile_number = JSON.parse(data.contact_of_children);

			$("#on_spouse_name").text(!data.spouse_name ? "-" : data.spouse_name);
			$("#on_occupation").text(!data.occupation ? "-" : data.occupation);
			$("#on_no_of_children").html(
				data.no_of_children == "none" ? "-" : data.no_of_children
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

			$("#on_course").text(!data.course ? "-" : data.course);
			$("#on_school").text(!data.school ? "-" : data.school);
			$("#on_inclusive_years").text(data.inclusive_years);
			$("#on_school_address").text(
				!data.school_address ? "-" : data.school_address
			);

			$("#on_cover_all").text(!data.cover_all ? "-" : data.cover_all);
			$("#on_winter_jacket").text(
				!data.winter_jacket ? "-" : data.winter_jacket
			);
			$("#on_shoes").text(!data.shoes ? "-" : data.shoes);
			$("#on_winter_boots").text(!data.winter_boots ? "-" : data.winter_boots);

			getLicenses(data.applicant_code);
			getCertificates(data.applicant_code);
			getSeaServiceRecord(data.applicant_code);
			getSeaserviceRecordTotalEx(data.applicant_code);
		},
	});
	$("#v_crew_off_signer_modal").modal("show");
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
function getSeaserviceRecordTotalEx(applicant_code) {
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

function getCMPMedicalRecords(crew_code) {
	$.ajax({
		url: base_url + "get-medical-records-table",
		type: "POST",
		dataType: "JSON",
		data: { crew_code: crew_code },
		success: function (data) {
			var crew_arr = data.crew;

			if (Array.isArray(crew_arr) && crew_arr.length) {
				var count = 1;
				$.each(crew_arr, function (i, item) {
					var status = "";
					if (crew_arr[i].medical_status === "1") {
						status = "PENDING";
					} else if (crew_arr[i].medical_status === "2") {
						status = "FIT FOR SEA DUTY";
					} else {
						status = "WITH APPROVAL";
					}

					$("#medical_record_table_sm").append(
						'<tr><td class="text-center">' +
							count +
							"</td>" +
							'<td class="text-center">' +
							formatDate(crew_arr[i].date_med_exam) +
							"</td>" +
							'<td class="text-center">' +
							formatDate(crew_arr[i].date_follow_up) +
							"</td>" +
							'<td class="text-center">' +
							getUserPosition(crew_arr[i].crew_code) +
							"</td>" +
							'<td class="text-center">' +
							status +
							"</td>" +
							'<td class="text-center">' +
							formatDate(crew_arr[i].date_created) +
							"</td>" +
							'<td class="text-center">' +
							crew_arr[i].remarks +
							"</td>" +
							'<td class="text-center">' +
							crew_arr[i].medical_bmi +
							"</td>" +
							"<td>" +
							(crew_arr[i].medical_status === "3"
								? ""
								: '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#" onclick="editMedical(\'' +
								  crew_arr[i].id +
								  "','" +
								  crew_arr[i].crew_code +
								  "')\">Edit</button>") +
							'<button type="button" class="btn btn-outline-danger btn-xs" onclick="removeMedical(\'' +
							crew_arr[i].id +
							"')\">Remove</button></td>" +
							+"</tr>"
					);
					count++;
				});
			} else {
				$("#medical_record_table_sm").append(
					'<tr><td class="text-center" colspan="9">No data available in table</td></tr>'
				);
			}
			$("#pagination").append(data.showing_entries);
		},
	});
}

function getInsignerVesselHistory(cmp_code, app_code) {
	$.ajax({
		url: base_url + "get-vessel-history",
		type: "POST",
		data: {
			code: cmp_code,
		},
		success: function (data) {
			if (data) {
				if (typeof data == "string") {
					$("#vessel_history_table").html(data);
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

					$("#vessel_history_table").html(table);
					$("#vh_applicant_code").val(cmp_code);
				}
			}
		},
	});

	$.ajax({
		url: base_url + "get-cmp-sea-service",
		type: "POST",
		data: {
			code: cmp_code,
		},
		success: function (data) {
			let embarked = JSON.parse(data.embarked);
			let disembarked = JSON.parse(data.disembarked);
			$("#history_total_service").html(
				getTotalServiceDuration(embarked, disembarked)
			);
		},
	});
	$("#gvh_applicant_name").html(getNameByCmpcode(cmp_code));
	$("#vh_applicant_code").val(app_code);
	$("#vessel_history_modal").modal("show");
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

function viewOnCrewContracts(crew_code) {
	$.ajax({
		url: base_url + "get-crew-contract",
		type: "POST",
		dataType: "JSON",
		data: { crew_code: crew_code },
		success: function (data) {
			$("#on_contract_list").empty();
			$("#on_contract_list").html(data);
		},
	});
}
//
function editMedical(id, crew_code) {
	$("#view_medical_modal").modal("hide");

	$.ajax({
		url: base_url + "get-medical-record",
		type: "POST",
		data: {
			id: id,
			crew_code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#btnEditCloseMedical").val(data.crew_code);
			$("#e_m_crew_code").val(data.crew_code);
			$("#e_m_medical_code").val(data.medical_code);
			$("#e_m_date_med_exam").val(data.date_med_exam);
			$("#e_m_medical_expiry_date").val(data.e_m_medical_expiry_date);
			$("#e_m_status").val(data.medical_status);
			$("#e_m_add_remarks").val(data.remarks);
			if (data.details) {
				var details = JSON.parse(data.details);
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
		},
	});

	$.ajax({
		url: base_url + "get-crew-information",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_m_position").val(data.position);
		},
	});

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

			$("#e_m_full_name").val(full_name);
			$("#e_m_height").val(data.height);
			$("#e_m_weight").val(data.weight);
			$("#e_m_age").val(getAge(data.birth_date));
			$("#e_m_bmi").val(formatBMI(data.height, data.weight).toFixed(2));
		},
	});

	$("#edit_medical_modal").modal("show");
}

//view edit info

function getViewEditApplicationCMP(crew_code) {
	getNextOfKin(crew_code);
	getCMCrewInformation(crew_code);
	getCMApplicantInformation(crew_code);
	getEducationalAttainment(crew_code);
	getWorkingGears(crew_code);

	$("#v_e_crew_information_modal").modal("show");
}

function getCMCrewInformation(crew_code) {
	$.ajax({
		url: base_url + "get-crew-information",
		data: {
			code: crew_code,
		},
		type: "POST",
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
			$("#e_insigner").val(data.insigner);
			$("#epvm_tentative_vessel").val(data.vessel_assign);
			$("#hid_code_pos_update").val(data.crew_code);
		},
	});
}

function getCMApplicantInformation(crew_code) {
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
				$("#rs" + id).show();

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

$("#e_height").keyup(function () {
	$("#e_bmi").val(formatBMI(this.value, $("#e_weight").val()).toFixed(2));
});

$("#e_weight").keyup(function () {
	$("#e_bmi").val(formatBMI($("#e_height").val(), this.value).toFixed(2));
});

//Edit CMPLAM
function editCMPlan(cmp_code, status) {
	$.ajax({
		url: base_url + "get-cmp-details",
		type: "POST",
		data: {
			code: cmp_code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data) {
				var d = "";
				if (status === "7") {
					$("#line_up_div").show();
					$("#vessel_div").hide();
				}
				if (data.date_available) {
					d = data.date_available.split(" ")[0];
					$("#c_available").prop("readonly", true);
				} else {
					$("#c_available").prop("readonly", false);
				}

				$("#cmp_crew_name").html(data.full_name);
				$("#cmp_code").val(cmp_code);
				$("#status").val(status);
				$("#crew_code").val(data.crew_code);
				$("#c_full_name").val(data.full_name);
				$("#c_rank").val(data.position_name);
				$("#c_vessel").val(data.vsl_name);
				$("#c_available").val(d);
				$("#c_disembark").val(data.disembark);
				$("#c_end_contract").val(getCrewDisembark(data.offsigner));
				$("#c_x_port").val(data.x_port);
				$("#c_line_up").val(data.line_up);
				$("#c_onboard").val(data.months_onboard);
				$("#c_x_date").val(data.date_x);
				$("#c_sign_on").val(data.embark);
				$("#c_remarks").val(data.remarks);

				$("#c_disembark").on("keyup", function () {
					var disembark_date = $("#c_disembark").val();

					$("#c_end_contract").val(disembark_date);
				});
				$("#c_end_contract").on("keyup", function () {
					var end_contract_date = $("#c_end_contract").val();

					$("#c_disembark").val(end_contract_date);
				});
			}
		},
	});

	$("#a_crew_management_plan").modal("show");
}
function viewCMPlan(cmp_code, status) {
	$.ajax({
		url: base_url + "get-cmp-details",
		type: "POST",
		data: {
			code: cmp_code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data) {
				var d = "";
				if (status === "7") {
					$("#line_up_div").show();
					$("#vessel_div").hide();
				}
				if (data.date_available) {
					d = data.date_available.split(" ")[0];
					$("#c_available").prop("readonly", true);
				} else {
					$("#c_available").prop("readonly", false);
				}

				$("#cmp_crew_name").html(data.full_name);
				$("#cmp_code").val(cmp_code);
				$("#status").val(status);
				$("#crew_code").val(data.crew_code);
				$("#c_full_name").val(data.full_name);
				$("#c_rank").val(data.position_name);
				$("#c_vessel").val(data.vsl_name);
				$("#c_available").val(d);
				$("#c_disembark").val(data.disembark);
				$("#c_end_contract").val(
					data.contract_duration ? data.contract_duration : data.disembark
				);
				$("#c_x_port").val(data.x_port);
				$("#c_line_up").val(data.line_up);
				$("#c_onboard").val(data.months_onboard);
				$("#c_x_date").val(data.date_x);
				$("#c_sign_on").val(data.embark);
				$("#c_remarks").val(data.remarks);

				$("#c_disembark").on("keyup", function () {
					var disembark_date = $("#c_disembark").val();

					$("#c_end_contract").val(disembark_date);
				});
				$("#c_end_contract").on("keyup", function () {
					var end_contract_date = $("#c_end_contract").val();

					$("#c_disembark").val(end_contract_date);
				});
			}
		},
	});

	$("#a_crew_management_plan")
		.find("input,select,textarea")
		.prop("disabled", true);
	$("#a_crew_management_plan").find("#BtnUpdateCMP").prop("hidden", true);
	$("#a_crew_management_plan")
		.find("#modal-body-title")
		.text("View Crew Management Plan");
	$("#a_crew_management_plan")
		.find("#view-note")
		.html(
			"<span class='text-danger font-17'><i>*Note: You cannot Edit CM PLAN Data, Contract is now ON-GOING! </i></span>"
		);

	$("#a_crew_management_plan").modal("show");
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
