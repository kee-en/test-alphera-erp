$("#recruitment_filter_form").submit(function (data) {
	$.ajax({
		url: base_url + "search-pending",
		type: "POST",
		data: $("#recruitment_filter_form").serialize(),
		success: function (data) {
			location.reload(true);
		},
	});
});
$("#BtnResetSearch").click(function () {
	$.ajax({
		url: base_url + "unset-search-pending",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
});
