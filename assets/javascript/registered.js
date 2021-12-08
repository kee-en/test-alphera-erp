$(document).ready(function () {
	$("#recruitment_filter_form").submit(function () {
		$.ajax({
			url: base_url + "search-registered",
			type: "POST",
			data: $("#recruitment_filter_form").serialize(),
			success: function (data) {
				location.reload(true);
			},
		});
	});
	$("#BtnResetSearch").click(function () {
		$.ajax({
			url: base_url + "unset-search-data",
			type: "POST",
			success: function (data) {
				location.reload(true);
			},
		});
	});
});

function applicantImageError(image) {
	image.onerror = "";
	image.src = `${base_url}assets/images/avatar-placeholder.png`;
	return true;
}
