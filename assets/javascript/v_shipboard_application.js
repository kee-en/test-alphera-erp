function getApplicantDetails(applicant_code) {
	getApplicants(applicant_code);
	getApplicantInformation(applicant_code);
	getNextOfKin(applicant_code);
	getEducationalAttainment(applicant_code);
	getWorkingGears(applicant_code);
	getLicenses(applicant_code);
	getCertificates(applicant_code);
	getSeaServiceRecord(applicant_code);
	getSeaserviceRecordTotal(applicant_code);
	$("#shipboard_application_modal").modal("show");
}

$("#recruitment_filter_form").submit(function () {
	$.ajax({
		url: base_url + "search-approved",
		type: "POST",
		data: $("#recruitment_filter_form").serialize(),
		success: function (data) {
			location.reload(true);
		},
	});
});
$("#BtnResetSearch").click(function () {
	$.ajax({
		url: base_url + "unset-search-approval",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
});

function getApplicants(applicant_code) {
	$.ajax({
		url: base_url + "get-applicants",
		type: "POST",
		data: {
			applicant_code: applicant_code,
		},
		dataType: "JSON",
		success: function (data) {
			$("#v_date_of_application").html(
				data.date_created ? formatDate(data.date_created) : "-"
			);
			$("#v_date_of_availability").html(
				data.date_available
					? formatDate(data.date_available)
					: "<span class='text-alphera'>No Specific Date</span>"
			);
			$("#v_first_position").html(
				data.position_first ? formatPosition(data.position_first) : "-"
			);
			$("#v_second_position").html(
				data.position_second ? formatPosition(data.position_second) : "-"
			);
			$("#v_tentative_vessel").text(
				!data.assign_vessel ? "-" : formatVessel(data.assign_vessel)
			);
			$("#v_nat_result").html(!data.nat_result ? "-" : data.nat_result + "%");
		},
	});
}

function getApplicantInformation(applicant_code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: applicant_code,
		},
		dataType: "JSON",
		success: function (data) {
			var full_name =
				data.first_name + " " + data.middle_name + " " + data.last_name;

			$("#v_applicant_photo").attr("src", data.photo_path);
			$("#v_applicant_full_name").html(full_name);
			$("#v_first_name").html(data.first_name);
			$("#v_middle_name").html(!data.middle_name ? "-" : data.middle_name);
			$("#v_last_name").html(data.last_name);
			$("#v_suffix").html(!data.suffix ? "-" : data.suffix);
			$("#v_birth_date").html(formatDate(data.birth_date));
			$("#v_birth_place").html(!data.birth_place ? "-" : data.birth_place);
			$("#v_civil_status").html(formatCivilStatus(data.civil_status));
			$("#v_email_address").html(
				!data.email_address ? "-" : data.email_address
			);
			$("#v_telephone_number").html(
				!data.telephone_number ? "-" : data.telephone_number
			);
			$("#v_mobile_number").html(
				!data.mobile_number ? "-" : data.mobile_number
			);
			$("#v_religion").html(
				formatReligion(data.religion) ? formatReligion(data.religion) : "-"
			);
			$("#v_nationality").html(
				!data.nationality_description ? "-" : data.nationality_description
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

			$("#v_spouse_name").html(!data.spouse_name ? "-" : data.spouse_name);
			$("#v_no_of_occupation").html(!data.occupation ? "-" : data.occupation);
			$("#v_no_of_children").html(
				data.no_of_children == "none" ? "-" : data.no_of_children
			);
			if (data.no_of_children == "none") {
				$("#child_name_d").hide();
				$("#child_birthdate_d").hide();
				$("#child_mobile_d").hide();
			}
			for (let index = 0; index < data.no_of_children; index++) {
				$("#child_name_div").append(
					child_full_name[index]
						? '<p class="text-dark font-18 mt-0 mb-2">' +
								child_full_name[index] +
								"</p>"
						: '<p class="text-dark font-18 mt-0 mb-2" >-</p>'
				);
				$("#child_birth_date_div").append(
					child_birth_date[index]
						? '<p class="text-dark font-18 mt-0 mb-2">' +
								formatDate(child_birth_date[index]) +
								"</p>"
						: '<p class="text-dark font-18 mt-0 mb-2">-</p>'
				);
				$("#child_mobile_div").append(
					child_mobile_number[index]
						? '<p class="text-dark font-18 mt-0 mb-2" id="on_mobile_no_children">' +
								child_mobile_number[index] +
								"</p>"
						: '<p class="text-dark font-18 mt-0 mb-2">-</p>'
				);
			}

			$("#v_father_name").html(!data.father_name ? "-" : data.father_name);
			$("#v_mother_name").html(!data.mother_name ? "-" : data.mother_name);
			$("#v_address").html(!data.address ? "-" : data.address);
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

function getWorkingGears(applicant_code) {
	$.ajax({
		url: base_url + "get-working-gears",
		type: "POST",
		data: {
			code: applicant_code,
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
		url: base_url + "get-vessel-history",
		type: "POST",
		data: {
			code: applicant_code,
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
			if (data) {
				let embarked = JSON.parse(data.embarked);
				let disembarked = JSON.parse(data.disembarked);

				if (embarked != null || disembarked != null) {
					$("#total_service_one").html(
						getTotalServiceDuration(embarked, disembarked)
					);
				}
			}
		},
	});
}
