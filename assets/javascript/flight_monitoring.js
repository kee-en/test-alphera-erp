$(function () {
	formVessel("flight_vessel");
});

$(document).ready(function () {
	$("#flight_information_table").DataTable({
		ajax: {
			url: base_url + "flight-monitoring-table",
			type: "POST"
		},
		language: {
			paginate: {
				previous: "<i class='mdi mdi-chevron-left'>",
				next: "<i class='mdi mdi-chevron-right'>"
			}
		},
		drawCallback: function () {
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		}
	});
});

$("#flight_information_form").submit(function () {
	$.ajax({
		url: base_url + "save-flight-information",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.flight_vessel, "flight_vessel");
			validationInput(data.f_flight_number, "f_flight_number");
			validationInput(data.f_departure_country, "f_departure_country");
			validationInput(data.f_departure_date, "f_departure_date");
			validationInput(data.f_departure_time, "f_departure_time");
			validationInput(data.f_destination_country, "f_destination_country");
			validationInput(data.f_destination_date, "f_destination_date");
			validationInput(data.f_destination_time, "f_destination_time");
			validationInput(data.f_airfare, "f_airfare");
			validationInput(data.f_airline, "f_airline");

			if (data.type) {
				Swal.fire({
					icon: data.type,
					title: data.title,
					text: data.text,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					if (data.type === 'success') {
						$("#flight_information_form").trigger("reset");
						$("#flight_information_table")
							.DataTable()
							.ajax.reload();
					}
				});
			}
		}
	});
});

function removeFlightInfo(id) {
	Swal.fire({
		title: "Are you sure you want to remove this?",
		icon: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
		allowEscapeKey: false,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, remove it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "remove-flight-information",
				type: "POST",
				data: { id: id },
				success: function (data) {
					if (data.type) {
						Swal.fire({
							icon: data.type,
							title: data.title,
							text: data.text,
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							if (data.type === 'success') {
								location.reload(true);
							}
						});
					}
				}
			});
		}
	});
}

$("#btnResetFlightInfo").click(function () {
	$("#flight_information_form").trigger("reset");
	validationInput("", "flight_vessel");
	validationInput("", "f_flight_number");
	validationInput("", "f_departure_country");
	validationInput("", "f_departure_date");
	validationInput("", "f_departure_time");
	validationInput("", "f_destination_country");
	validationInput("", "f_destination_date");
	validationInput("", "f_destination_time");
	validationInput("", "f_airfare");
	validationInput("", "f_airline");
})

$("#flight_vessel").keyup(function () {
	$.ajax({
		url: base_url + "add-flight-information-validation",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.flight_vessel, "flight_vessel");
		},
	});
});

$("#f_flight_number").keyup(function () {
	$.ajax({
		url: base_url + "add-flight-information-validation",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.f_flight_number, "f_flight_number");
		},
	});
});

$("#f_departure_country").keyup(function () {
	$.ajax({
		url: base_url + "add-flight-information-validation",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.f_departure_country, "f_departure_country");
		},
	});
});

$("#f_departure_date").keyup(function () {
	$.ajax({
		url: base_url + "add-flight-information-validation",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.f_departure_date, "f_departure_date");
		},
	});
});

$("#f_departure_time").keyup(function () {
	$.ajax({
		url: base_url + "add-flight-information-validation",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.f_departure_time, "f_departure_time");
		},
	});
});

$("#f_destination_country").keyup(function () {
	$.ajax({
		url: base_url + "add-flight-information-validation",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.f_destination_country, "f_destination_country");
		},
	});
});

$("#f_destination_date").keyup(function () {
	$.ajax({
		url: base_url + "add-flight-information-validation",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.f_destination_date, "f_destination_date");
		},
	});
});

$("#f_destination_time").keyup(function () {
	$.ajax({
		url: base_url + "add-flight-information-validation",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.f_destination_time, "f_destination_time");
		},
	});
});

$("#f_airfare").keyup(function () {
	$.ajax({
		url: base_url + "add-flight-information-validation",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.f_airfare, "f_airfare");
		},
	});
});

$("#f_airline").keyup(function () {
	$.ajax({
		url: base_url + "add-flight-information-validation",
		type: "POST",
		data: $("#flight_information_form").serialize(),
		success: function (data) {
			validationInput(data.f_airline, "f_airline");
		},
	});
});

$("#fm_export_as").change(function () {
    window.open(base_url + "print-flight-monitoring" + "/" + this.value);
});