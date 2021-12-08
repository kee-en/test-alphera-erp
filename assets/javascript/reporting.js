$(function () {
	formAllPosition("r_position");
	formVessel("r_tentative_vessel");
});

function getCrewReporting(crew_code, fullname) {
	$.ajax({
		url: base_url + "get-crew-information",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			var disembark = getCrewDisembark(data.monitor_code);
			var embark = data.embark;
			
			let total_year = 0,
				total_months = 0,
				total_days = 0;
				em = moment(embark);
				dm = moment(disembark);
				date_duration = moment.duration(dm.diff(em));

				total_months += Number(date_duration.months());
				total_year += Number(date_duration.years());
				total_days += Number(date_duration.days());

				total = moment().add({
					days: total_days,
					months: total_months,
					years: total_year,
				});
			
				total_duration = moment.duration(total.diff(moment()));
			
				display =
					total_duration.years() +
					(total_duration.years() === 1 ? " Year " : " Years ") +
					total_duration.months() +
					(total_duration.months() === 1 ? " Month " : " Months ") +
					total_duration.days() +
					(total_duration.days() === 1 ? " Day " : " Days ");

			$("#r_crew_name").html(fullname);
			$("#r_position").val(data.position);
			$('#r_sea_service').val(display);
			$("#report_crew_code").val(crew_code);
			$("#r_tentative_vessel").val(data.vessel_assign);

			$("#a_reporting_modal").modal("show");
		},
	});
}

$("#add_reporting_form").submit(function () {
	$.ajax({
		url: base_url + "create-on-vacation-crew",
		type: "POST",
		data: $("#add_reporting_form").serialize(),
		dataType: "JSON",
		success: function (data) { 
			validationInput(data.r_date_availability, "r_date_availability");
			validationInput(data.r_position, "r_position");
			validationInput(data.r_crew_evaluation, "r_crew_evaluation");
			validationInput(data.r_tentative_vessel, "r_tentative_vessel");

			Swal.fire({
				icon: data.type,
				title: data.title,
				text: data.text,
				confirmButtonText: "Close",
				allowOutsideClick: false,
				allowEscapeKey: false,
			}).then(function () {
				if (data.type === "success") {
					location.reload();
				}
			});
		},
	});
});
