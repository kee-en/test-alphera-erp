$(document).ready(function () {
	formAllPosition('position_list');
	get_points();
});

$("#position_points_form").submit(function () {
	Swal.fire({
		title: "Are you sure you want to save this?",
		icon: "warning",
		showCancelButton: true,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, save it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "update-position-points",
				type: "POST",
				data: $("#position_points_form").serialize(),
				dataType: "JSON",
				success: function (data) {
					validationInputGroup(data.position_list, "position_list");
					if (data.type === "success") {
						Swal.fire({
							icon: data.type,
							title: data.title,
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							location.reload(true);
						});
					}
				}
			});
		}
	});
});

function get_points() {
	$.ajax({
		url: base_url + "get-all-points",
		type: "GET",
		success: function (data) {
			if (data != "") {
				$('#points_list').append(data);
			} else {
				$('#points_list').append('<div class="col-md-12 text-center"><h4 class="text-muted">There is no data to display</h4></div>');
			}
		},
	});
}

$("#position_list").change(function () {
	var id = this.value;
	$.ajax({
		url: base_url + "get-position-scores",
		type: "POST",
		data: $("#position_points_form").serialize(),
		success: function (data) {
			if (data != null) {
				let points = JSON.parse(data.interview_form);
				$('input:checkbox').prop('checked', false);
				$.each(points, function (i, item) {
					if ($('#points_interview' + points[i]).val() == points[i]) {
						$('#points_interview' + points[i]).prop('checked', true);
					}
				});
			} else {
				$('input:checkbox').prop('checked', false);
			}

		},
	});
});

$("#position_list").change(function () {
	$.ajax({
		url: base_url + "update-position-points-validation",
		type: "POST",
		data: $("#position_points_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInputGroup(data.position_list, "position_list");
		}
	});
});
