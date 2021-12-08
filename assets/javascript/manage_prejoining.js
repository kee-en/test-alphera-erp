
$("#crew_filter_form").submit(function () {
	$.ajax({
		url: base_url + "pre-joining-search",
		type: "POST",
		data: $("#crew_filter_form").serialize(),
		success: function (data) {
			window.location.replace(base_url + 'manage-prejoining');
		},
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
	window.open(base_url + "print-prejoining" + "/" + c_type);
}