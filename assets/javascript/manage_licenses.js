$(document).ready(function () {
	formAllPosition("position_list");
	getLicenses();

	$("#position_licenses_form").submit(function () {
		$.ajax({
			url: base_url + "save-licenses-by-position",
			type: "POST",
			data: $(this).serialize(),
			dataType: "JSON",
			success: function (data) {
				switch (data.type) {
					case "warning":
						validationInputGroup(data.position_list, "position_list");
						break;
					case "error":
					case "success":
						Swal.fire({
							icon: data.type,
							title: data.title,
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							location.reload();
						});
						break;
				}
			},
		});
	});

	$("#position_list").on("change", function () {
		$.ajax({
			url: base_url + "position-licenses-validation",
			type: "POST",
			data: $("#position_licenses_form").serialize(),
			dataType: "JSON",
			success: function (data) {
				$(".licenses_position").prop("checked", false);
				validationInputGroup(data.position_list, "position_list");

				if (data.type != "warning") {
					$.ajax({
						url: base_url + "get-selected-licenses-per-position",
						type: "GET",
						data: $("#position_licenses_form").serialize(),
						dataType: "JSON",
						success: function (data) {
							if (data.positions) {
								$(".licenses_position").val(data.positions);
							}
						},
					});
				}
			},
		});
	});
});

function getLicenses() {
	$.ajax({
		url: base_url + "get-all-licenses-docs",
		type: "GET",
		success: function (data) {
			if (data) {
				$("#licenses_list").append(data);
			} else {
				$("#licenses_list").append(
					'<div class="col-md-12 text-center"><h4 class="text-muted">There is no licenses data to display</h4></div>'
				);
			}
		},
	});
}
