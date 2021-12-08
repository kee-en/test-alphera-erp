$(function () {
	formVessel("c_vessel_name");
	formTypeVessel("c_vessel_type");
	formAllPosition("c_position");
});

function addCrewPOEAContract(code, name) {
	$.ajax({
		url: base_url + "get-crew-information",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			var date_created = moment(data.date_created).format("YYYY-MM-DD");

			$("#c_vessel_name").val(data.vessel_assign);
			$("#c_vessel_type").val(formatVesselTypeIdByVessel(data.vessel_assign));

			if (getApplicantType(data.crew_code) === "OLD") {
				$("#c_duration_contract").val(getCrewDisembark(data.monitor_code));
			}

			$("#c_applicant_type").val(getApplicantType(data.crew_code));
			$("#c_position").val(data.position);
			// $("#c_point_of_hire").val(date_created);
			$("#c_crew_code").val(code);
			$("#c_monitor_code").val(data.monitor_code);
			getApplicantInformation(data.crew_code);
			$("#a_poea_crew_name").html(name);
			$("#add_poea_contracts_modal").modal("show");
		},
	});
}

$("#poea_contract_form").submit(function () {
	var type = $("#c_applicant_type").val();

	if (type === "OLD") {
		Swal.fire({
			title: "POEA Contract",
			text: "Are you sure you want to add / update Crew POEA Contract?",
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
					url: base_url + "create-poea-contract",
					type: "POST",
					data: $("#poea_contract_form").serialize(),
					beforeSend: function () {
						$("#BtnAddContractPOEA").html(
							'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
						);
						$("#BtnAddContractPOEA").prop("disabled", true);
					},
					success: function (data) {
						validationInput(data.c_license_no, "c_license_no");
						validationInput(data.c_sirb_no, "c_sirb_no");
						validationInput(data.c_src_no, "c_src_no");
						validationInput(data.c_name_of_agent, "c_name_of_agent");
						validationInput(data.c_name_of_principal, "c_name_of_principal");
						validationInput(
							data.c_address_of_principal,
							"c_address_of_principal"
						);
						validationInput(data.c_duration_contract, "c_duration_contract");
						validationInput(data.c_position, "c_position");
						validationInput(data.c_monthly_salary, "c_monthly_salary");
						validationInput(data.c_year_built, "c_year_built");
						validationInput(data.c_flag, "c_flag");
						validationInput(data.c_vessel_type, "c_vessel_type");
						validationInput(
							data.c_classification_society,
							"c_classification_society"
						);
						validationInput(data.c_hours_of_work, "c_hours_of_work");
						validationInput(data.c_vessel_name, "c_vessel_name");
						validationInput(data.c_imo_number, "c_imo_number");
						validationInput(data.c_gross_tonnage, "c_gross_tonnage");
						validationInput(data.c_overtime, "c_overtime");
						validationInput(
							data.c_vacation_leave_with_pay,
							"c_vacation_leave_with_pay"
						);
						validationInput(data.c_others, "c_others");
						validationInput(data.c_total_salary, "c_total_salary");
						validationInput(data.c_point_of_hire, "c_point_of_hire");
						validationInput(
							data.c_collective_agreement,
							"c_collective_agreement"
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
									location.reload(true);
								}
							});
						}
						$("#BtnAddContractPOEA").html("Add");
						$("#BtnAddContractPOEA").prop("disabled", false);
					},
				});
		});
	} else {
		$.ajax({
			url: base_url + "create-poea-contract",
			type: "POST",
			data: $("#poea_contract_form").serialize(),
			beforeSend: function () {
				$("#BtnAddContractPOEA").html(
					'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
				);
				$("#BtnAddContractPOEA").prop("disabled", true);
			},
			success: function (data) {
				validationInput(data.c_license_no, "c_license_no");
				validationInput(data.c_sirb_no, "c_sirb_no");
				validationInput(data.c_src_no, "c_src_no");
				validationInput(data.c_name_of_agent, "c_name_of_agent");
				validationInput(data.c_name_of_principal, "c_name_of_principal");
				validationInput(data.c_address_of_principal, "c_address_of_principal");
				validationInput(data.c_duration_contract, "c_duration_contract");
				validationInput(data.c_position, "c_position");
				validationInput(data.c_monthly_salary, "c_monthly_salary");
				validationInput(data.c_year_built, "c_year_built");
				validationInput(data.c_flag, "c_flag");
				validationInput(data.c_vessel_type, "c_vessel_type");
				validationInput(
					data.c_classification_society,
					"c_classification_society"
				);
				validationInput(data.c_hours_of_work, "c_hours_of_work");
				validationInput(data.c_vessel_name, "c_vessel_name");
				validationInput(data.c_imo_number, "c_imo_number");
				validationInput(data.c_gross_tonnage, "c_gross_tonnage");
				validationInput(data.c_overtime, "c_overtime");
				validationInput(
					data.c_vacation_leave_with_pay,
					"c_vacation_leave_with_pay"
				);
				validationInput(data.c_others, "c_others");
				validationInput(data.c_total_salary, "c_total_salary");
				validationInput(data.c_point_of_hire, "c_point_of_hire");
				validationInput(data.c_collective_agreement, "c_collective_agreement");

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
				$("#BtnAddContractPOEA").html("Add");
				$("#BtnAddContractPOEA").prop("disabled", false);
			},
		});
	}
});

$("#c_others").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_others, "c_others");
		},
	});
});

$("#c_license_no").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_license_no, "c_license_no");
		},
	});
});

$("#c_sirb_no").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_sirb_no, "c_sirb_no");
		},
	});
});

$("#c_src_no").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_src_no, "c_src_no");
		},
	});
});

$("#c_name_of_agent").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_name_of_agent, "c_name_of_agent");
		},
	});
});

$("#c_name_of_principal").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_name_of_principal, "c_name_of_principal");
		},
	});
});

$("#c_address_of_principal").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_address_of_principal, "c_address_of_principal");
		},
	});
});

$("#c_vessel_name").change(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_vessel_name, "c_vessel_name");
		},
	});
});

$("#c_monthly_salary").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_monthly_salary, "c_monthly_salary");
		},
	});
});

$("#c_hours_of_work").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_hours_of_work, "c_hours_of_work");
		},
	});
});

$("#c_overtime").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_overtime, "c_overtime");
		},
	});
});

$("#c_imo_number").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_imo_number, "c_imo_number");
		},
	});
});

$("#c_gross_tonnage").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_gross_tonnage, "c_gross_tonnage");
		},
	});
});

$("#c_year_built").change(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_year_built, "c_year_built");
		},
	});
});

$("#c_flag").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_flag, "c_flag");
		},
	});
});

$("#c_duration_contract").change(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_duration_contract, "c_duration_contract");
		},
	});
});

$("#c_vacation_leave_with_pay").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(
				data.c_vacation_leave_with_pay,
				"c_vacation_leave_with_pay"
			);
		},
	});
});

$("#c_classification_society").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(
				data.c_classification_society,
				"c_classification_society"
			);
		},
	});
});

$("#c_total_salary").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_total_salary, "c_total_salary");
		},
	});
});

$("#c_collective_agreement").keyup(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_collective_agreement, "c_collective_agreement");
		},
	});
});

$("#c_vessel_type").change(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_vessel_type, "c_vessel_type");
		},
	});
});

$("#c_position").change(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_position, "c_position");
		},
	});
});

$("#c_point_of_hire").change(function () {
	$.ajax({
		url: base_url + "add-poea-contract-validation",
		type: "POST",
		data: $("#poea_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_point_of_hire, "c_point_of_hire");
		},
	});
});
