$(function () {
	formAllPosition('nre_rank_filter');
});

$("#nre_report_form").submit(function () {
	$.ajax({
		url: base_url + "set-nre-report",
		type: "POST",
		data: $("#nre_report_form").serialize(),
		success: function (data) {
			window.location.replace(base_url + 'nre-report');
		},
	});
});

function resetForm() {
    $.ajax({
		url: base_url + "reset-nre-report",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
}