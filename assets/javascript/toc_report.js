$(function () {
	formAllPosition('toc_rank_filter');
});

$("#toc_report_form").submit(function () {
	$.ajax({
		url: base_url + "set-toc-report",
		type: "POST",
		data: $("#toc_report_form").serialize(),
		success: function (data) {
			window.location.replace(base_url + 'toc-report');
		},
	});
});

function resetForm() {
    $.ajax({
		url: base_url + "reset-toc-report",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
}