$("#btnCloseFlightDetails").click(function () {
	location.reload(true);
});

function getAllListFlightDetails(monitor_code) {
	$("#flight_table").DataTable({
		ajax: {
			url: base_url + "get-list-flights",
			type: "POST",
			dataType: "JSON",
			data: {
				monitor_code: monitor_code,
			},
		},
		language: {
			paginate: {
				previous: "<i class='mdi mdi-chevron-left'>",
				next: "<i class='mdi mdi-chevron-right'>",
			},
		},
		drawCallback: function () {
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		},
	});
}

function getCrewFlightDetails(monitor_code, crew_code) {
	$("#flight_table").DataTable({
		ajax: {
			url: base_url + "get-crew-list-flights",
			type: "POST",
			dataType: "JSON",
			data: {
				monitor_code: monitor_code,
				crew_code: crew_code,
			},
		},
		language: {
			paginate: {
				previous: "<i class='mdi mdi-chevron-left'>",
				next: "<i class='mdi mdi-chevron-right'>",
			},
		},
		drawCallback: function () {
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		},
	});
	$("#a_flight_details_modal")
		.find("#header_title")
		.html("View Flight Details");
}

function addCrewFlight(flight_code, monitor_code) {
	$.ajax({
		url: base_url + "add-crew-flight",
		type: "POST",
		data: {
			flight_code: flight_code,
			monitor_code: monitor_code,
		},
		dataType: "JSON",
		success: function (data) {
			Swal.fire({
				icon: data.type,
				title: data.title,
				text: data.text,
				allowOutsideClick: false,
				allowEscapeKey: false,
			}).then(function () {
				if (data.type === "success") {
					$("#a_flight_details_modal").modal("hide");
					location.reload();
				}
			});
		},
	});
}
