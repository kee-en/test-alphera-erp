$(document).ready(function () {
	formAllPosition("position_list");
	get_trainings();
});

$("#position_requirements_form").submit(function () {
	Swal.fire({
		title: "Are you sure you want to save this?",
		icon: "warning",
		allowOutsideClick: false,
		allowEscapeKey: false,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, save it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "update-position-certificates",
				type: "POST",
				data: $("#position_requirements_form").serialize(),
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

function get_trainings() {
	$.ajax({
		url: base_url + "get-all-training-certificates",
		type: "GET",
		success: function (data) {
			if (data != "") {
				$('#requirement_list').append(data);
			} else {
				$('#requirement_list').append('<div class="col-md-12 text-center"><h4 class="text-muted">There is no data to display</h4></div>');
			}
		},
	});
}

$("#position_list").change(function () {
	var id = this.value;
	$.ajax({
		url: base_url + "get-position-scores",
		type: "POST",
		data: $("#position_requirements_form").serialize(),
		success: function (data) {
			if (data != null) {
				let positions = JSON.parse(data.position_requirements);
				$('input:checkbox').prop('checked', false);
				$.each(positions, function (i, item) {
					if ($('#req_position' + positions[i]).val() == positions[i]) {
						$('#req_position' + positions[i]).prop('checked', true);
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
		url: base_url + "update-position-certificates-validation",
		type: "POST",
		data: $("#position_requirements_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInputGroup(data.position_list, "position_list");
		}
	});
});
