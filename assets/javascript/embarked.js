$(function () {
	formVessel("e_vessel_name");
	formTypeVessel("e_vessel_type");
	formAllPosition("e_position");
	formVessel("epp_tentative_vessel");
	formAllPosition("epp_position");

	formVessel("edit_mlc_vessel_name");
	formTypeVessel("edit_mlc_vessel_type");
	formNationality("edit_mlc_farer_nationality");
	formAllPosition("edit_mlc_farer_duty");
});

$("#crew_filter_form").submit(function () {
	$.ajax({
		url: base_url + "embarked-crew-search",
		type: "POST",
		data: $("#crew_filter_form").serialize(),
		success: function (data) {
			window.location.replace(base_url + "crew-embarked");
		},
	});
});
$("#BtnResetSearch").click(function () {
	$.ajax({
		url: base_url + "embarked-search-reset",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
});

$("#assign_as_on_signer").submit(function () {
	Swal.fire({
		title: "Are you sure you want to save?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, save it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "crew-embarked-assign-offsigner",
				type: "POST",
				data: $(this).serialize(),
				success: function (data) {
					if (data.type === "success") {
						Swal.fire({
							icon: data.type,
							title: data.title,
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							location.reload(true);
						});
					} else {
						validationInput(data.a_offsigner, "a_offsigner");
						validationInput(data.a_embarked_date, "a_embarked_date");
						validationInput(data.a_disembarked_date, "a_disembarked_date");
						Swal.fire({
							icon: data.type,
							title: data.title,
							allowOutsideClick: false,
							allowEscapeKey: false,
						});
					}
				},
			});
		}
	});
});

function getViewEditApplication(crew_code) {
	getCrewInformationEm(crew_code);
	getApplicantInformationEm(crew_code);
	getNextOfKinEm(crew_code);
	getEducationalAttainmentEm(crew_code);
	getWorkingGearsEm(crew_code);

	$("#v_e_crew_information_modal").modal("show");
}

function getCrewInformationEm(crew_code) {
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

function getApplicantInformationEm(crew_code) {
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

function getNextOfKinEm(crew_code) {
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

function getEducationalAttainmentEm(crew_code) {
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

function getWorkingGearsEm(crew_code) {
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

function PrintReport(c_type) {
	window.open(base_url + "print-embarked" + "/" + c_type);
}

function updateMLC() {
	var code = $("#hid_crew").val();

	$.ajax({
		url: base_url + "get-mlc-details",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data) {
				alert("here");
				for (let index = 0; index < data.length; index++) {
					var details = JSON.parse(data[index].agreement_details);
					var wage = JSON.parse(data[index].wage);
					var emp_period = JSON.parse(data[index].employment_period);

					if (data[index].mlc_type === 1) {
						$("#vc_form_number").html("SCRE-04B-02");
						$("#vc_revision_number").html("03");
						$("#vc_revision_date").html("2019-01-01");

						$("#mlc_form_number").val("SCRE-04B-02");
						$("#mlc_revision_number").val("03");
						$("#mlc_revision_date").val("2019-01-01");

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
					} else if (data[index].mlc_type === "2") {
						$("#vc_form_number").html("SCRE-04B-01-02");
						$("#vc_revision_number").html("04");
						$("#vc_revision_date").html("2019-07-19");

						$("#mlc_form_number").val("SCRE-04B-01-02");
						$("#mlc_revision_number").val("04");
						$("#mlc_revision_date").val("2019-07-19");

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
					} else if (data[index].mlc_type === "3") {
						$("#vc_form_number").html("SCRE-04B-01-01");
						$("#vc_revision_number").html("04");
						$("#vc_revision_date").html("2019-07-19");

						$("#mlc_form_number").val("SCRE-04B-01-01");
						$("#mlc_revision_number").val("04");
						$("#mlc_revision_date").val("2019-07-19");

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
					} else {
						$("#vc_form_number").html("-");
						$("#vc_revision_number").html("-");
						$("#vc_revision_date").html("-");
						$("#col_form_details").show();
						$("#col_form_mlc").show();
					}

					$("#crew_code").val(code);
					$("#edit_mlc_crew_name").html(data[index].crew_name);
					$("#c_edit_mlc_contract").val(data[index].mlc_type);
					$("#edit_mlc_form_number").val(data[index].form_no);
					$("#vc_revision_number").val(data[index].revision_no);
					$("#vc_revision_date").val(data[index].date_created);
					$("#edit_mlc_vessel_name").val(data[index].vessel_name);
					$("#edit_mlc_vessel_type").val(data[index].vessel_type);
					$("#edit_mlc_farer_name").val(data[index].crew_name);
					$("#edit_mlc_farer_duty").val(data[index].duty);

					$("#edit_mlc_farer_passport").val(data[index].passport_no);
					$("#edit_mlc_farer_book").val(data[index].seamans_book);
					$("#edit_mlc_farer_license").val(data[index].license_no);

					$("#edit_mlc_farer_sex").val(data[index].gender);
					$("#edit_mlc_farer_sex").attr("readonly", true);
					$("#edit_mlc_farer_nationality").val(data[index].nationality);
					$("#edit_mlc_farer_birthdate").val(data[index].birthdate);
					$("#edit_mlc_sign_place").val(details[0]);
					$("#edit_mlc_sign_date").val(details[1]);

					$("#edit_mlc_bw").val(wage[0]);
					$("#edit_mlc_ot").val(wage[1]);
					$("#edit_mlc_pl").val(wage[2]);
					$("#edit_mlc_sa").val(wage[3]);
					$("#edit_mlc_rb").val(wage[4]);
					$("#edit_mlc_mts").val(wage[5]);
					$("#edit_mlc_fksu").val(wage[6]);
					$("#edit_mlc_mt").val(wage[7]);

					$("#edit_mlc_employment_period_from").val(emp_period[0]);
					$("#edit_mlc_employment_period_to").val(emp_period[1]);
					$("#edit_mlc_name_of_seafared").val(data[index].crew_name);
					$("#edit_mlc_shipowner_vessel").val(data[index].shipowner_vessel);
					$("#edit_mlc_vp_alphera").val(data[index].name_of_vp);
				}
			}
		},
	});
	$("#edit_mlc_contract_modal").modal("show");
}

function getViewEditPrejoining(crew_code, full_name) {
	$.ajax({
		url: base_url + "get-list-licenses",
		type: "POST",
		data: { code: crew_code },
		success: function (data) {
			$("#v_e_pre_joining_visa_modal")
				.find("#crew_list_licenses_edit")
				.html(data);
		},
	});

	$.ajax({
		url: base_url + "get-list-certificates",
		type: "POST",
		data: { code: crew_code },
		success: function (data) {
			$("#v_e_pre_joining_visa_modal")
				.find("#crew_list_certificates_edit")
				.html(data);
		},
	});

	$("#btn_edit_license_edit").val(crew_code);
	$("#btn_view_license").val(crew_code);
	$("#btn_edit_certificates").val(crew_code);
	$("#btn_view_certificates_edit").val(crew_code);
	$("#vepjv_crew_name").html(full_name);

	$("#v_e_pre_joining_visa_modal").modal("show");
}

function assignAsOnSigner(status, monitor_code, full_name) {
	var modal = $("#a_assign_as_onsigner").modal("show");

	var $eventSelect = modal.find("#a_offsigner").select2({
		dropdownParent: $("#assign_as_on_signer"),
	});

	formOffSignerName("a_offsigner", monitor_code);
	$eventSelect.on("change", function (e) {
		var app_code = this.value;
		$.ajax({
			url: base_url + "crew-embarked-get-embark-disembark",
			type: "POST",
			data: {
				onsigner_code: monitor_code,
				offsigner_code: app_code,
			},
			success: function (data) {
				if (data) {
					modal.find("#a_embarked_date").val(data.offsigner_disembark_date);
					modal.find("#onsigner_mnt_code").val(monitor_code);
				}
			},
		});
	});
}

function validateAssignOnsigner() {
	setTimeout(() => {
		$.ajax({
			url: base_url + "assign-onsigner-validation",
			type: "POST",
			data: $("#a_assign_as_onsigner").find("#assign_as_on_signer").serialize(),
			success: function (data) {
				console.log(data);
				if (data.type == "warning") {
					validationInput(data.a_offsigner, "a_offsigner");
					validationInput(data.a_embarked_date, "a_embarked_date");
					validationInput(data.a_disembarked_date, "a_disembarked_date");
				} else {
					validationInput("", "a_offsigner");
					validationInput("", "a_embarked_date");
					validationInput("", "a_disembarked_date");
				}
			},
		});
	}, 1000);
}
