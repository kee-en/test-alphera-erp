// $(document).ready(function () {
// 	$(".modal").modal({
// 		backdrop: "static",
// 		keyboard: false,
// 		show: false, // added property here
// 	});

// 	$(document).on("show.bs.modal", ".modal", function (event) {
// 		var zIndex = 1040 + 10 * $(".modal:visible").length;
// 		$(this).css("z-index", zIndex);
// 		setTimeout(function () {
// 			$(".modal-backdrop")
// 				.not(".modal-stack")
// 				.css("z-index", zIndex - 1)
// 				.addClass("modal-stack");
// 		}, 0);
// 	});

// 	$(document).on("hidden.bs.modal", function () {
// 		if ($(".modal:visible").length) {
// 			$("body").addClass("modal-open");
// 		}
// 	});
// });

$("#edit_medical_modal").on("hidden.bs.modal", function () {
	jQuery.removeData(div, "#modal_body");
});

$("#edit_medical_form").submit(function () {
	$.ajax({
		url: base_url + "edit-medical-record-form",
		type: "POST",
		data: $("#edit_medical_form").serialize(),
		beforeSend: function () {
			$("#BtnEditMedical").html(
				'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
			);
			$("#BtnEditMedical").prop("disabled", true);
		},
		success: function (data) {
			validationInput(data.e_m_date_med_exam, "e_m_date_med_exam");
			validationInput(data.e_m_medical_expiry_date, "e_m_medical_expiry_date");
			validationInput(data.e_m_status, "e_m_status");
			validationInput(data.e_m_height, "e_m_height");
			validationInput(data.e_m_weight, "e_m_weight");

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
						$("#edit_medical_modal").modal("hide");
						$("#medical_table").DataTable().ajax.reload();
						location.reload();
					}
				});
			}
			$("#BtnEditMedical").html("Save Changes");
			$("#BtnEditMedical").prop("disabled", false);
		},
	});
});

$("#e_m_height").keyup(function () {
	$("#e_m_bmi").val(formatBMI(this.value, $("#e_m_weight").val()).toFixed(2));
});

$("#e_m_weight").keyup(function () {
	$("#e_m_bmi").val(formatBMI($("#e_m_height").val(), this.value).toFixed(2));
});

function closeEditMedical() {
	$("#edit_medical_form")[0].reset();
	validationInput("", "e_m_date_med_exam");
	validationInput("", "e_m_medical_expiry_date");
	validationInput("", "e_m_status");
	validationInput("", "e_m_height");
	validationInput("", "e_m_weight");
}

$("#e_m_date_med_exam").keyup(function () {
	$.ajax({
		url: base_url + "edit-medical-validation",
		type: "POST",
		data: $("#edit_medical_form").serialize(),
		success: function (data) {
			validationInput(data.e_m_date_med_exam, "e_m_date_med_exam");
		},
	});
});

$("#e_m_medical_expiry_date").keyup(function () {
	$.ajax({
		url: base_url + "edit-medical-validation",
		type: "POST",
		data: $("#edit_medical_form").serialize(),
		success: function (data) {
			validationInput(data.e_m_medical_expiry_date, "e_m_medical_expiry_date");
		},
	});
});

$("#e_m_status").change(function () {
	$.ajax({
		url: base_url + "edit-medical-validation",
		type: "POST",
		data: $("#edit_medical_form").serialize(),
		success: function (data) {
			validationInput(data.e_m_status, "e_m_status");
		},
	});
});

$("#e_m_height").keyup(function () {
	$.ajax({
		url: base_url + "edit-medical-validation",
		type: "POST",
		data: $("#edit_medical_form").serialize(),
		success: function (data) {
			validationInput(data.e_m_height, "e_m_height");
		},
	});
});

$("#e_m_weight").keyup(function () {
	$.ajax({
		url: base_url + "edit-medical-validation",
		type: "POST",
		data: $("#edit_medical_form").serialize(),
		success: function (data) {
			validationInput(data.e_m_weight, "e_m_weight");
		},
	});
});

$("#e_m_status").on("change", function () {
	if ($(this).val() === "1") {
		$(".e-pending").show();
	} else {
		$(".e-pending").hide();
		$("#e_m_waistline").val("");
		$("#e_m_cholesterol").val("");
		$("#e_m_triglycerides").val("");
		$("#e_m_fbs").val("");
		$("#e_m_sgpt").val("");
		$("#e_m_sgot").val("");
		$("#e_m_ldl").val("");
		$("#e_m_hdl").val("");
		$("#e_m_bp").val("");
		$("#e_m_specific_ailment").val();
	}
});
