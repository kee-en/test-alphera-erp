$(function () {
	$("#is_first_assessor_app").prop("disabled", true);
	$("#is_first_assessor_dis").attr("disabled", true);
	$("#is_second_assessor_app").attr("disabled", true);
	$("#is_second_assessor_dis").attr("disabled", true);
	$("#is_final_assessor_app").attr("disabled", true);
	$("#is_final_assessor_dis").attr("disabled", true);
});

function sortBy(id) {
	window.location.replace(base_url + "admin-approval?sort=" + id + "");
}

$(function () {
	var path = window.location.href;
	$("ul li a").each(function () {
		if (this.href === path) {
			$(this).addClass("active");
		} else if (path === "http://localhost/alphera_erp/admin-approval") {
			$("#approved_li").addClass("active");
		}
	});
});

function viewMedicalRequest(approve_code) {
	$.ajax({
		url: base_url + "get-approval-details",
		type: "POST",
		data: { code: approve_code },
		success: function (data) {
			var details = JSON.parse(data.details);

			var decisions = data.decision != "" ? JSON.parse(data.decision) : null;
			var approvers = data.approvers != "" ? JSON.parse(data.approvers) : null;
			var apv_remarks =
				data.decision_remarks != "" ? JSON.parse(data.decision_remarks) : null;

			if (decisions) {
				switch (decisions.decision_1) {
					case 1:
						$("#is_first_assessor_app").prop("checked", true);
						break;

					case 0:
						$("#is_first_assessor_dis").prop("checked", true);
						break;
				}
				switch (decisions.decision_2) {
					case 1:
						$("#is_second_assessor_app").prop("checked", true);
						break;

					case 0:
						$("#is_second_assessor_dis").prop("checked", true);
						break;
				}
				switch (decisions.decision_3) {
					case 1:
						$("#is_final_assessor_app").prop("checked", true);
						break;

					case 0:
						$("#is_final_assessor_dis").prop("checked", true);
						break;
				}
			}
			if (approvers) {
				$(".first_name_assessor").html(
					approvers.approver_1
						? getUserDetails(approvers.approver_1).full_name
						: ""
				);
				$(".second_name_assessor").html(
					approvers.approver_2
						? getUserDetails(approvers.approver_2).full_name
						: ""
				);
				$(".is_final_name_assessor").html(
					approvers.approver_3
						? getUserDetails(approvers.approver_3).full_name
						: ""
				);

				$("#first_assessor_id").val(approvers.approver_1);
				$("#second_assessor_id").val(approvers.approver_2);
				$("#final_assessor_id").val(approvers.approver_3);
			}
			if (apv_remarks) {
				$("#is_first_remark").val(apv_remarks.remarks_1);
				$("#is_second_remark").val(apv_remarks.remarks_2);
				$("#is_final_remark").val(apv_remarks.remarks_3);
			}

			$("#apvm_crew_name").html(data.full_name);
			$("#vpmm_full_name").html(data.full_name);
			$("#vpmm_rank").html(data.position_name);
			$("#is_approval_code").val(data.approval_code);

			$("#vpmm_date_of_med").html(details.date_med_exam);
			$("#vpmm_date_of_expiry").html(details.medical_expiry_date);
			$("#vpmm_age").html(getAge(data.birth_date));

			var approval_status = "";

			switch (details.medical_status) {
				case "0":
					approval_status = "<span class='text-danger'>REJECTED</span>";
					break;
				case "1":
					approval_status =
						"<span class='text-alphera text-underline'>PENDING</span>";
					break;
				case "3":
					approval_status = "<span class='text-success'>APPROVED</span>";
					break;
			}

			$("#vpmm_medical_status").html(approval_status);
			$("#vpmm_height").html(details.medical_height);
			$("#vpmm_weight").html(details.medical_weight);
			$("#vpmm_bmi").html(details.bmi);
			$("#vpmm_waist_line").html(details.waist_line);
			$("#vpmm_cholesterol").html(details.cholosterol);
			$("#vpmm_triglycerides").html(details.triglycerides);
			$("#vpmm_fbs").html(details.fbs);
			$("#vpmm_sgpt").html(details.sgpt);
			$("#vpmm_sgot").html(details.sgot);
			$("#vpmm_ldl").html(details.ldl);
			$("#vpmm_hdl").html(details.hdl);
			$("#vpmm_bp").html(details.bp);
			$("#vpmm_specimen_ailment").html(details.specific_ailment);
			$("#vpmm_remarks").html(details.remarks);
		},
	});

	$("#view_pending_medical_modal").modal("show");
}

function approveMedicalRequest(approval_code) {
	$("#is_approval_code").val(approval_code);

	Swal.fire({
		title: "Are you sure you want to approve this request?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "approve-medical-request",
				type: "POST",
				data: $("#apvm_medical_form").serialize(),
				beforeSend: function () {
					$("#btnApproveMedical").html(
						'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
					);
					$("#btnApproveMedical").prop("disabled", true);
				},
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
								$("#view_pending_medical_modal").modal("hide");
								window.location.replace(base_url + "admin-approval");
							} else {
								window.location.replace(base_url + "admin-approval");
							}
						});
					}

					$("#btnApproveMedical").html("Save Changes");
					$("#btnApproveMedical").prop("disabled", false);
				},
			});
		}
	});
}

function rejectMedicalRequest(approval_code, crew_code) {
	Swal.fire({
		title: "Are you sure you want to reject this request?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "reject-medical-request",
				type: "POST",
				data: { code: approval_code, crew_code: crew_code },
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
								window.location.replace(base_url + "admin-approval");
							}
						});
					}
				},
			});
		}
	});
}

function approveTocRequest(approval_code, crew_code, request_type) {
	Swal.fire({
		title: "Are you sure you want to approve this request?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "approve-toc-request",
				type: "POST",
				data: {
					code: approval_code,
					crew_code: crew_code,
					request_type: request_type,
				},
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
								window.location.replace(base_url + "admin-approval");
							}
						});
					}
				},
			});
		}
	});
}

function rejectTocRequest(approval_code, crew_code, request_type) {
	Swal.fire({
		title: "Are you sure you want to reject this request?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "reject-toc-request",
				type: "POST",
				data: {
					code: approval_code,
					crew_code: crew_code,
					request_type: request_type,
				},
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
								window.location.replace(base_url + "admin-approval");
							} else {
								window.location.replace(base_url + "admin-approval");
							}
						});
					}
				},
			});
		}
	});
}

function approvePromotion(approval_code, crew_code) {
	Swal.fire({
		title: "Are you sure you want to approve this request?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "approve-promotion-request",
				type: "POST",
				data: { approval_code: approval_code, crew_code: crew_code },
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
								window.location.replace(base_url + "admin-approval");
							} else {
								window.location.replace(base_url + "admin-approval");
							}
						});
					}
				},
			});
		}
	});
}

function rejectPromotion(approval_code) {
	Swal.fire({
		title: "Are you sure you want to reject this request?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "reject-promotion-request",
				type: "POST",
				data: { approval_code: approval_code },
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
								window.location.replace(base_url + "admin-approval");
							} else {
								window.location.replace(base_url + "admin-approval");
							}
						});
					}
				},
			});
		}
	});
}

$("#is_first_assessor_app").on("click", function () {
	var assessor = $("#is_assessor_code").val();
	$(".first_name_assessor").html(getUserDetails(assessor).full_name);
	$("#first_assessor_id").val(assessor);
});
$("#is_first_assessor_dis").on("click", function () {
	var assessor = $("#is_assessor_code").val();
	$(".first_name_assessor").html(getUserDetails(assessor).full_name);
	$("#first_assessor_id").val(assessor);
});

$("#is_second_assessor_app").on("click", function () {
	var assessor = $("#is_assessor_code").val();
	$(".second_name_assessor").html(getUserDetails(assessor).full_name);
	$("#second_assessor_id").val(assessor);
});
$("#is_second_assessor_dis").on("click", function () {
	var assessor = $("#is_assessor_code").val();
	$(".second_name_assessor").html(getUserDetails(assessor).full_name);
	$("#second_assessor_id").val(assessor);
});

$("#is_final_assessor_app").on("click", function () {
	var assessor = $("#is_assessor_code").val();
	$(".is_final_name_assessor").html(getUserDetails(assessor).full_name);
	$("#final_assessor_id").val(assessor);
});
$("#is_final_assessor_app").on("click", function () {
	var assessor = $("#is_assessor_code").val();
	$(".is_final_name_assessor").html(getUserDetails(assessor).full_name);
	$("#final_assessor_id").val(assessor);
});

function viewPromotionRequest(approval_code, crew_code) {
	$.ajax({
		url: base_url + "view-promotion-request",
		type: "POST",
		data: { approval_code: approval_code, crew_code: crew_code },
		success: function (data) {
			var details = JSON.parse(data.details);

			$("#vcpm_grade").html(data.grade ? data.grade : "-");
			$("#vcpm_school").html(data.school ? data.school : "-");
			$("#vcpm_crew_name").html(data.full_name ? data.full_name : "-");
			$("#vcpm_entry_date").html(
				data.crew_entry ? formatDate(data.crew_entry) : "-"
			);
			$("#vcpm_prev_rank").html(
				data.position ? formatPosition(data.position) : "-"
			);
			$("#vcpm_prev_vessel").html(
				data.vessel_assign ? formatVessel(data.vessel_assign) : "-"
			);

			$("#vcpm_new_rank").html(formatPosition(details.position));
			$("#vcpm_new_vessel").html(formatVessel(details.vessel_name));
			$("#vcpm_contract").html(formatDate(details.contract_duration));
		},
	});

	$("#view_crew_promotion_modal").modal("show");
}

function viewCrewLineupRequest(approval_code) {
	$('#view_crew_lineup').modal('show');
	$('#crew_lineup_table').show();
	$('#crew_lineup_table').DataTable().clear().destroy();

    $("#crew_lineup_table").DataTable({
        // processing: true,
        ajax: {
            url: base_url + "view-crewlineup-request",
            data(d){
                d.approval_code = approval_code;
            },
            type: "POST",
        },
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }

        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });
}
function approveCrewLineup(approval_code) {

	Swal.fire({
		title: "Are you sure you want to approve this request?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "approve-crew-lineup",
				type: "POST",
				data: { approval_code: approval_code},
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
								window.location.replace(base_url + "admin-approval");
							} else {
								window.location.replace(base_url + "admin-approval");
							}
						});
					}
				},
			});
		}
	});
}

function rejectCrewLineup(approval_code) {
	Swal.fire({
		title: "Are you sure you want to reject this request?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "reject-crew-lineup",
				type: "POST",
				data: { approval_code: approval_code},
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
								window.location.replace(base_url + "admin-approval");
							} else {
								window.location.replace(base_url + "admin-approval");
							}
						});
					}
				},
			});
		}
	});
}