$(function () {
	// formAllPosition("epp_position");
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

	formTypeVessel("edit_mlc_vessel_type");
});

function PrintReport(c_type) {
	window.open(base_url + "print-promotion-report" + "/" + c_type);
}

$("#crew_filter_form").submit(function () {
	$.ajax({
		url: base_url + "crew-promotion-search",
		type: "POST",
		data: $("#crew_filter_form").serialize(),
		success: function (data) {
			location.reload(true);
		},
	});
});
$("#BtnResetSearch").click(function () {
	$.ajax({
		url: base_url + "unset-crew-promotion-search",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
});

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

function openPromotionChecklist(fullname, crew_code) {
	$("#vpc_crew_name").html(fullname);
	$("#promotion_chck_hid_crew").val(crew_code);

	$.ajax({
		url: base_url + "check-updated-promotion-req",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data === "completed") {
				$("#updated_mlc").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#updated_poea").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#updated_pos_vess").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#add_pos_ves").hide();
				$("#add_mlc").hide();
				$("#add_poea").hide();
			} else if (data === "no_vessel_rank") {
				$("#updated_mlc").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#updated_poea").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#add_mlc").hide();
				$("#add_poea").hide();
			} else if (data === "mlc") {
				$("#updated_poea").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#updated_pos_vess").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#add_pos_ves").hide();
				$("#add_poea").hide();
			} else if (data === "poea") {
				$("#updated_mlc").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#updated_pos_vess").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#add_pos_ves").hide();
				$("#add_mlc").hide();
			} else if (data === "incomplete") {
				$("#updated_mlc").attr(
					"src",
					base_url + "assets/alphera/icons/gray_check.png"
				);
				$("#updated_poea").attr(
					"src",
					base_url + "assets/alphera/icons/gray_check.png"
				);
				$("#updated_pos_vess").attr(
					"src",
					base_url + "assets/alphera/icons/gray_check.png"
				);
			} else if (data === "with_mlc") {
				$("#updated_mlc").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#add_mlc").hide();
			} else if (data === "with_poea") {
				$("#updated_poea").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#add_poea").hide();
			} else if (data === "with_pos_vess") {
				$("#updated_pos_vess").attr(
					"src",
					base_url + "assets/alphera/icons/red_check.png"
				);
				$("#add_pos_ves").hide();
			}
		},
	});

	$("#view_promotion_checklist").modal("show");
}

function updateMLC() {
	var code = $("#promotion_chck_hid_crew").val();

	$.ajax({
		url: base_url + "check-updated-promotion-req",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data === "no_vessel_rank" || data === "incomplete") {
				Swal.fire({
					icon: "warning",
					title: "Crew Promotion!",
					text: "Please select a new position and vessel to pomote crew to, before adding a new contract.",
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			} else {
				$.ajax({
					url: base_url + "get-data-for-promotion-details",
					type: "POST",
					data: {
						code: code,
					},
					dataType: "JSON",
					success: function (data) {
						if (data) {
							for (let index = 0; index < data.length; index++) {
								var licenses = JSON.parse(data[index].number);

								$("#promotion_crew_code").val(code);

								$("#promotion_revision_date").text("2019-07-19");

								$("#promotion_mlc_crew_name").html(data[index].full_name);
								$("#promotion_mlc_farer_duty").val(
									data[index].p_position
										? data[index].p_position
										: data[index].position
								);
								$("#promotion_mlc_vessel_name").val(
									data[index].p_vessel
										? data[index].p_vessel
										: data[index].vessel_assign
								);
								$("#promotion_mlc_vessel_type").val(
									data[index].p_vessel
										? formatVesselTypeIdByVessel(data[index].p_vessel)
										: formatVesselTypeIdByVessel(data[index].vessel_assign)
								);
								$("#promotion_mlc_farer_name").val(data[index].full_name);

								$("#promotion_mlc_farer_passport").val(licenses[5]);
								$("#promotion_mlc_farer_book").val(licenses[6]);
								$("#promotion_mlc_farer_license").val(licenses[0]);

								$("#promotion_mlc_farer_nationality").val(
									data[index].nationality
								);
								$("#promotion_mlc_farer_birthdate").val(data[index].birth_date);

								$("#promotion_mlc_name_of_seafared").val(data[index].full_name);
							}
						}
					},
				});
				$("#promotion_mlc_contract_modal").modal("show");
			}
		},
	});
}

$("#promotion_mlc_contract_form").submit(function () {
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
				url: base_url + "update-mlc-promotion",
				type: "POST",
				data: $("#promotion_mlc_contract_form").serialize(),
				beforeSend: function () {
					$("#btnSavePromotion_mlc").html(
						'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
					);
					$("#btnSavePromotion_mlc").prop("disabled", true);
				},
				success: function (data) {
					validationInput(
						data.promotion__mlc_sign_place,
						"promotion__mlc_sign_place"
					);
					validationInput(
						data.promotion__mlc_sign_date,
						"promotion__mlc_sign_date"
					);
					validationInput(data.promotion__mlc_bw, "promotion__mlc_bw");
					validationInput(data.promotion__mlc_ot, "promotion__mlc_ot");
					validationInput(data.promotion__mlc_pl, "promotion__mlc_pl");
					validationInput(data.promotion__mlc_sa, "promotion__mlc_sa");
					validationInput(data.promotion__mlc_rb, "promotion__mlc_rb");
					validationInput(data.promotion__mlc_mts, "promotion__mlc_mts");
					validationInput(data.promotion__mlc_fksu, "promotion__mlc_fksu");
					validationInput(data.promotion__mlc_mt, "promotion__mlc_mt");
					validationInput(
						data.promotion__mlc_employment_period_from,
						"promotion__mlc_employment_period_from"
					);
					validationInput(
						data.promotion__mlc_employment_period_to,
						"promotion__mlc_employment_period_to"
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
								$("#promotion__mlc_contract_modal").modal("hide");
								$("#view_promotion_checklist").modal("hide");
								location.reload();
							} else if (data.type === "info") {
								location.reload();
							}
						});
					}
					$("#btnSavePromotion_mlc").html("Save Changes");
					$("#btnSavePromotion_mlc").prop("disabled", false);
				},
			});
	});
});

function updatePOEA() {
	var code = $("#promotion_chck_hid_crew").val();

	$.ajax({
		url: base_url + "check-updated-promotion-req",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data === "no_vessel_rank" || data === "incomplete") {
				Swal.fire({
					icon: "warning",
					title: "Crew Promotion!",
					text: "Please select a new position and vessel to pomote crew to, before adding a new contract.",
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			} else {
				$.ajax({
					url: base_url + "get-data-for-promotion-details",
					type: "POST",
					data: {
						code: code,
					},
					dataType: "JSON",
					success: function (data) {
						for (let index = 0; index < data.length; index++) {
							var licenses = JSON.parse(data[index].number);

							$("#promotion_poea_crew_name").html(data[index].full_name);
							$("#promotion_vessel_name").val(
								data[index].p_vessel
									? data[index].p_vessel
									: data[index].vessel_assign
							);
							$("#promotion_vessel_type").val(
								data[index].p_vessel
									? formatVesselTypeIdByVessel(data[index].p_vessel)
									: formatVesselTypeIdByVessel(data[index].vessel_assign)
							);
							$("#promotion_position").val(
								data[index].p_position
									? data[index].p_position
									: data[index].position
							);
						}
						$("#promotion_hid_crew_code").val(code);
					},
				});

				$("#promotion_poea_contracts_modal").modal("show");
			}
		},
	});
}

$("#promotion_poea_contract_form").submit(function () {
	Swal.fire({
		title: "Update POEA Contract",
		text: "Are you sure you want to update Crew's POEA Contract?",
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
				url: base_url + "update-poea-promotion",
				type: "POST",
				data: $("#promotion_poea_contract_form").serialize(),
				beforeSend: function () {
					$("#btnSavePromotion_poea").html(
						'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
					);
					$("#btnSavePromotion_poea").prop("disabled", true);
				},
				success: function (data) {
					validationInput(data.promotion_license_no, "promotion_license_no");
					validationInput(data.promotion_sirb_no, "promotion_sirb_no");
					validationInput(data.promotion_src_no, "promotion_src_no");
					validationInput(
						data.promotion_name_of_agent,
						"promotion_name_of_agent"
					);
					validationInput(
						data.promotion_name_of_principal,
						"promotion_name_of_principal"
					);
					validationInput(
						data.promotion_address_of_principal,
						"promotion_address_of_principal"
					);
					validationInput(
						data.promotion_duration_contract,
						"promotion_duration_contract"
					);
					validationInput(data.promotion_position, "promotion_position");
					validationInput(
						data.promotion_monthly_salary,
						"promotion_monthly_salary"
					);
					validationInput(data.promotion_year_built, "promotion_year_built");
					validationInput(data.promotion_flag, "promotion_flag");
					validationInput(data.promotion_vessel_type, "promotion_vessel_type");
					validationInput(
						data.promotion_classification_society,
						"promotion_classification_society"
					);
					validationInput(
						data.promotion_hours_of_work,
						"promotion_hours_of_work"
					);
					validationInput(data.promotion_vessel_name, "promotion_vessel_name");
					validationInput(data.promotion_imo_number, "promotion_imo_number");
					validationInput(
						data.promotion_gross_tonnage,
						"promotion_gross_tonnage"
					);
					validationInput(data.promotion_overtime, "promotion_overtime");
					validationInput(
						data.promotion_vacation_leave_with_pay,
						"promotion_vacation_leave_with_pay"
					);
					validationInput(data.promotion_others, "promotion_others");
					validationInput(
						data.promotion_total_salary,
						"promotion_total_salary"
					);
					validationInput(
						data.promotion_point_of_hire,
						"promotion_point_of_hire"
					);
					validationInput(
						data.promotion_collective_agreement,
						"promotion_collective_agreement"
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
								$("#promotion_poea_contracts_modal").modal("hide");
								$("#view_promotion_checklist").modal("hide");
								location.reload();
							} else if (data.type === "info") {
								location.reload();
							}
						});
					}
					$("#btnSavePromotion_poea").html("Save Changes");
					$("#btnSavePromotion_poea").prop("disabled", false);
				},
			});
	});
});

function updatePosVessel() {
	var code = $("#promotion_chck_hid_crew").val();

	$.ajax({
		url: base_url + "get-crew-promotion-details",
		type: "POST",
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			for (let index = 0; index < data.length; index++) {
				var pos = parseInt(data[index].position);
				formPromotionPosition("epp_position", pos);
				$("#epp_crew_name").html(data[index].full_name);
				$("#epp_tentative_vessel").val(data[index].vessel_assign);
				$("#epp_position").val(data[index].position);
				$("#hidden_crew_code").val(data[index].crew_code);
				$("#hidden_crew_old_pos").val(data[index].position);
			}
		},
	});

	$("#e_position_promotion").modal("show");
	$("#view_promotion_checklist").modal("hide");
}

$("#edit_position_promotion").submit(function () {
	Swal.fire({
		title: "Request to Promote",
		text: "Are you sure you want to promote this crew?",
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
				url: base_url + "update-pos-vess-promotion",
				type: "POST",
				data: $("#edit_position_promotion").serialize(),
				beforeSend: function () {
					$("#BtnPromotion").html(
						'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
					);
					$("#BtnPromotion").prop("disabled", true);
				},
				success: function (data) {
					validationInput(data.epp_position, "epp_position");
					validationInput(data.epp_tentative_vessel, "epp_tentative_vessel");

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
								$("#e_position_promotion").modal("hide");
								$("#view_promotion_checklist").modal("show");
								location.reload();
							}
						});
					}
					$("#BtnPromotion").html("Save Changes");
					$("#BtnPromotion").prop("disabled", false);
				},
			});
	});
});
