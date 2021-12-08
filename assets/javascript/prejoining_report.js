$("#crew_filter_form").submit(function () {
	$("#crew_filter_form").submit(function () {
		$.ajax({
			url: base_url + "pre-joining-search",
			type: "POST",
			data: $("#crew_filter_form").serialize(),
			success: function (data) {
				location.reload(true);
			},
		});
	});
});

$("#BtnResetSearch").click(function () {
	$.ajax({
		url: base_url + "prejoining-search-reset",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
});

function PrintReport(c_type) {
	window.open(base_url + "print-prejoining-visa" + "/" + c_type);
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

	$("#vepjv_crew_name").html(name);
	$("#btn_edit_license_edit").val(crew_code);
	$("#btn_view_license").val(crew_code);
	$("#btn_edit_certificates").val(crew_code);
	$("#btn_view_certificates_edit").val(crew_code);

	$("#v_e_pre_joining_visa_modal").modal("show");
}
