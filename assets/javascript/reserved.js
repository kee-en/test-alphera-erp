$(function () {
	formVessel('reserved_vessel');
	if ($('#res_hid_vessel').val() != "") {
		$("#res_vessel_search").html(formatVessel($('#res_hid_vessel').val()));
	}
});
$("#f_search_reserved_form").submit(function () {
	$.ajax({
		url: base_url + "search-reserved",
		type: "POST",
		data: $("#f_search_reserved_form").serialize(),
		success: function (data) {
			location.reload(true);
		},
	});
});

$("#BtnResetSearchReserve").click(function () {
	$.ajax({
		url: base_url + "unset-search-reserve",
		type: "POST",
		success: function (data) {
			location.reload(true);
		}
	});
});

$("#export_reserved").change(function () {
	if (this.value == 1) {
		window.open(base_url + "print-reserved-applicant-csv");
		$("#export_reserved").prop("selectedIndex", 0);
	} else if (this.value == 2) {
		window.open(base_url + "print-reserved-applicant-xl");
		$("#export_reserved").prop("selectedIndex", 0);
	} else {
		window.open(base_url + "print-reserved-applicant-pdf");
		$("#export_reserved").prop("selectedIndex", 0);
	}
});

function revertApplicantStatus(code) {
	$.ajax({
		url: base_url + "revert-applicant-status",
		type: "POST",
		data: { applicant_code: code },
		success: function (data) {
			updateApplicantStatus(data.applicant_status, code);
		}
	});
}
