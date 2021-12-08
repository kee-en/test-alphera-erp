var room = 0;

$(function () {
	$("#not_qualified_form").submit(function () {
		Swal.fire({
			title: "Are you sure you want to proceed this?",
			icon: "warning",
			showCancelButton: true,
			allowOutsideClick: false,
			allowEscapeKey: false,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, proceed it!",
		}).then((result) => {
			if (result.value) {
				$("#not_qualified_modal").modal("hide");
				$.ajax({
					url: base_url + "applicant-not-qualified",
					type: "POST",
					data: $("#not_qualified_form").serialize(),
					success: function (data) {
						if (data.type === "success") {
							Swal.fire({
								title: "Success",
								text: "You successfully add the applicant to Not Qualified. Go to the Recruiment>Not Qualified to view the list of not qualified applicants.",
								icon: "success",
								confirmButtonText: "Close",
								allowOutsideClick: false,
								allowEscapeKey: false,
							}).then(function () {
								location.replace("not-qualified");
							});
						}
					},
				});
			}
		});
	});
});

$(document).ready(function () {
	checkCrewMonthOnVacation();
	$("#gf_alphera_table").DataTable({
		ordering: true,
		paging: false,
		info: false,
		searching: false,
	});

	$(".modal").modal({
		backdrop: "static",
		keyboard: false,
		show: false, // added property here
	});

	$(document).on("show.bs.modal", ".modal", function (event) {
		var zIndex = 1040 + 10 * $(".modal:visible").length;
		$(this).css("z-index", zIndex);
		setTimeout(function () {
			$(".modal-backdrop")
				.not(".modal-stack")
				.css("z-index", zIndex - 1)
				.addClass("modal-stack");
		}, 0);
	});

	$(document).on("hidden.bs.modal", function () {
		if ($(".modal:visible").length) {
			$("body").addClass("modal-open");
		}
	});
});

const Toast = Swal.mixin({
	toast: true,
	position: "top",
	showConfirmButton: false,
	timer: 3000,
	timerProgressBar: false,
	onOpen: (toast) => {
		toast.addEventListener("mouseenter", Swal.stopTimer);
		toast.addEventListener("mouseleave", Swal.resumeTimer);
	},
});

const capitalizeFirstLetter = (input) => {
	if (typeof input !== "string") return "";
	return input.charAt(0).toUpperCase() + input.slice(1);
};

const isNumberKey = (event) => {
	// Only ASCII character in that range allowed
	var ASCIICode = event.which ? event.which : event.keyCode;
	if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) return false;
	return true;
};

const isAlphabet = (event) => {
	var ch = String.fromCharCode(event.keyCode);
	var filter = /[a-zA-Z ]/;
	if (!filter.test(ch)) {
		event.returnValue = false;
	}
};

function checkCrewMonthOnVacation() {
	$.ajax({
		url: base_url + "check-crew-on-vacation",
		type: "GET",
		success: function (data) {
			if (data) {
				$("#for_toc").html(data.one_month);
			}
		},
	});
}

function accountLogout() {
	Swal.fire({
		title: "Log out",
		text: "Are you sure you want to log out?",
		icon: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
		allowEscapeKey: false,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, log out!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "deAuth",
				type: "GET",
				success: function () {
					Swal.fire({
						icon: "success",
						title: "Log out Successful!",
						text: "You have successfully logged out to the Alphera ERP Web System.",
						confirmButtonText: "Close",
						allowOutsideClick: false,
						allowEscapeKey: false,
					}).then(function () {
						location.replace(base_url + "login");
					});
				},
			});
		}
	});
}

// function getDateDuration(date1, date2) {
// 	var date1 = moment(date1, "M/D/YYYY");
// 	var date2 = moment(date2, "M/D/YYYY");
// 	var date_duration = moment.duration(date2.diff(date1));
// 	var display = "";
// 	var years = date_duration.years();
// 	var months = date_duration.months();
// 	var days = date_duration.days();
// 	if (years != 0) {
// 		display += years + (years == 1 ? " Year " : " Years ");
// 	}
// 	if (months != 0) {
// 		display += months + (months == 1 ? " Month " : " Months ");
// 	}
// 	if (days != 0) {
// 		display += days + (days == 1 ? " Day " : " Days ");
// 	}
// 	return display;
// }

function getTotalServiceDuration(embark, disembark) {
	var moments = [];
	let total_year = 0,
		total_months = 0,
		total_days = 0,
		total_hours = 0;

	var display;
	for (let i = 0; i < embark.length; i++) {
		if (embark[i] && disembark[i]) {
			em = moment(embark[i]);
			dm = moment(disembark[i]);
			date_duration = moment.duration(dm.diff(em));
			moments.push(date_duration);
		}
	}

	for (let m = 0; m < moments.length; m++) {
		total_months += Number(moments[m].months());
		total_year += Number(moments[m].years());
		total_days += Number(moments[m].days());
		total_hours += Number(moments[m].hours());

		// total = moment().add(moments[m].months(), "months");
		// break;
	}

	total = moment().add({
		hours: total_hours,
		days: total_days,
		months: total_months,
		years: total_year,
	});

	total_duration = moment.duration(total.diff(moment()));

	return (display =
		total_duration.years() +
		(total_duration.years() === 1 ? " Year " : " Years ") +
		total_duration.months() +
		(total_duration.months() === 1 ? " Month " : " Months ") +
		total_duration.days() +
		(total_duration.days() === 1 ? " Day " : " Days ") +
		total_duration.hours() +
		(total_duration.hours() === 1 ? " Hour " : " Hours "));
}

function getCrewName(crew_code) {
	var crew_name;
	$.ajax({
		url: base_url + "get-cmp-details",
		type: "POST",
		data: { code: crew_code },
		dataType: "JSON",
		success: function (data) {
			crew_name = data.full_name;
		},
	});
	return crew_name;
}

function updateCrewStatus(status, monitor_code) {
	Swal.fire({
		title: "Are you sure you want to proceed this?",
		icon: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
		allowEscapeKey: false,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, proceed it!",
	}).then((result) => {
		if (result.value === true) {
			$.ajax({
				url: base_url + "update-crew-status",
				type: "POST",
				data: {
					monitor_code: monitor_code,
					status: status,
				},
				dataType: "JSON",
				success: function (data) {
					if (data.type != "early_disembark") {
						Swal.fire({
							icon: data.type,
							title: data.title,
						}).then(function () {
							location.reload(true);
						});
					} else {
						$("#awlm_remarks").empty();
						var choices = new Array();
						choices[0] = { Text: "Choose option", Value: "" };
						choices[1] = { Text: "Early Disembarkation", Value: "2" };

						getCrewDetails(data.cmp_code);
						$("#cmp_code").val(data.cmp_code);
						$("#awlm_remarks").val(2);
						for (let index = 0; index < choices.length; index++) {
							$("#awlm_remarks").append(
								'<option value="' +
									choices[index].Value +
									'">' +
									choices[index].Text +
									"</option>"
							);
						}
						$("#add_warning_letter_modal").modal("show");
					}
				},
			});
		}
	});
}

function updateApplicantStatus(status, applicant_code, $assessor_id) {
	Swal.fire({
		title: "Are you sure you want to proceed this?",
		icon: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
		allowEscapeKey: false,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, proceed it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "update-applicant-status",
				type: "POST",
				data: {
					applicant_code: applicant_code,
					status: status,
				},
				dataType: "JSON",
				success: function (data) {
					if (data.status === "1") {
						Swal.fire({
							title: "Success",
							text: "You successfully proceed the applicant to NAT Exam. Go to the Recruiment > Pending Applicants to view the list of pending applicants.",
							icon: "success",
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							location.reload(true);
						});
					} else if (data.status === "7") {
						Swal.fire({
							title: "Success",
							text: "You successfully transfered the application of applicant. Go to the Recruiment > Reserved Applicants to view the list of reserved applicants.",
							icon: "success",
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							location.replace("reserved-applicants");
						});
					} else if (data.status === "2") {
						Swal.fire({
							title: "Success",
							text: "You successfully proceed the applicant to For Interview. Go to the Recruiment > For Interview to view the list of for interview applicants.",
							icon: "success",
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							location.reload(true);
						});
					} else if (data.status === "4") {
						Swal.fire({
							title: "Success",
							text: "You successfully proceed the applicant to Principal Approval. Go to the Recruiment > Principal Approval to view the list of for principal approval applicants.",
							icon: "success",
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							location.reload(true);
						});
					} else if (data.status === "6") {
						Swal.fire({
							title: "Success",
							text: "You successfully proceed the applicant to Passed (as Applicant Pool). Go to the Recruiment > Passed to view the list of passed applicants.",
							icon: "success",
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							location.reload(true);
						});
					} else if (data.status === "0") {
						Swal.fire({
							title: "Success",
							text: "You successfully reverted the shipboard employment application. To View, Go to the Recruitment > Registered Applicants",
							icon: "success",
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							location.reload(true);
						});
					} else {
						Swal.fire({
							title: data.title,
							text: data.text,
							icon: data.type,
							confirmButtonText: "Close",
							allowOutsideClick: false,
							allowEscapeKey: false,
						}).then(function () {
							location.reload(true);
						});
					}
				},
			});
		}
	});
}

function getVesselHistory(crew_code, name, app_code) {
	$.ajax({
		url: base_url + "get-vessel-history",
		type: "POST",
		data: {
			code: crew_code,
		},
		success: function (data) {
			if (data) {
				if (typeof data == "string") {
					$("#vessel_history_table").html(data);
				} else if (typeof data == "object") {
					var table = "";
					var count = 1;
					data.forEach((arr_of_sea_service) => {
						table += "<tr>";
						var total_service = getDateDuration(
							arr_of_sea_service.embarked,
							arr_of_sea_service.disembarked
						);

						total_service = total_service !== undefined ? total_service : "-";

						var vessel = arr_of_sea_service.vessel
								? arr_of_sea_service.vessel
								: "-",
							flag = arr_of_sea_service.flag ? arr_of_sea_service.flag : "-",
							salary = arr_of_sea_service.salary
								? arr_of_sea_service.salary
								: "-",
							position = arr_of_sea_service.position
								? arr_of_sea_service.position
								: "-",
							type_vessel = arr_of_sea_service.type_vessel
								? arr_of_sea_service.type_vessel
								: "-",
							grt_power = arr_of_sea_service.grt_power
								? arr_of_sea_service.grt_power
								: "-",
							embarked = arr_of_sea_service.embarked
								? arr_of_sea_service.embarked
								: "-",
							disembarked = arr_of_sea_service.disembarked
								? arr_of_sea_service.disembarked
								: "-",
							agency = arr_of_sea_service.agency
								? arr_of_sea_service.agency
								: "-",
							remarks = arr_of_sea_service.remarks
								? arr_of_sea_service.remarks
								: "-";

						table += "<td>" + count + "</td>";
						table += "<td>" + vessel + "</td>";
						table += "<td>" + flag + "</td>";
						table += "<td>" + salary + "</td>";
						table += '<td class="font-weight-medium">' + position + "</td>";
						table += "<td>" + type_vessel + "</td>";
						table += "<td>" + grt_power + "</td>";
						table += "<td>" + embarked + "</td>";
						table += "<td>" + disembarked + "</td>";
						table += "<td>" + total_service + "</td>";
						table += "<td>" + agency + "</td>";
						table += "<td>" + remarks + "</td>";
						table += "</tr>";

						count++;
					});

					$("#vessel_history_table").html(table);
				}
			}
		},
	});

	$.ajax({
		url: base_url + "get-sea-service-record",
		type: "POST",
		data: {
			code: crew_code,
		},
		success: function (data) {
			if (data) {
				let embarked = JSON.parse(data.embarked);
				let disembarked = JSON.parse(data.disembarked);

				if (embarked != null || disembarked != null) {
					$("#history_total_service").html(
						getTotalServiceDuration(embarked, disembarked)
					);
				}
				$("#vh_applicant_code").val(data.applicant_code);
			}
		},
	});
	$("#gvh_applicant_name").html(name);
	$("#vessel_history_modal").modal("show");
}

function getOffSignerVesselHistory(cmp_code) {
	$.ajax({
		url: base_url + "get-vessel-history",
		type: "POST",
		data: {
			code: cmp_code,
		},
		success: function (data) {
			if (data) {
				if (typeof data == "string") {
					$("#vessel_history_table").html(data);
				} else if (typeof data == "object") {
					var table = "";
					var count = 1;
					data.forEach((arr_of_sea_service) => {
						table += "<tr>";
						var total_service = getDateDuration(
							arr_of_sea_service.embarked,
							arr_of_sea_service.disembarked
						);

						total_service = total_service !== undefined ? total_service : "-";

						var vessel = arr_of_sea_service.vessel
								? arr_of_sea_service.vessel
								: "-",
							flag = arr_of_sea_service.flag ? arr_of_sea_service.flag : "-",
							salary = arr_of_sea_service.salary
								? arr_of_sea_service.salary
								: "-",
							position = arr_of_sea_service.position
								? arr_of_sea_service.position
								: "-",
							type_vessel = arr_of_sea_service.type_vessel
								? arr_of_sea_service.type_vessel
								: "-",
							grt_power = arr_of_sea_service.grt_power
								? arr_of_sea_service.grt_power
								: "-",
							embarked = arr_of_sea_service.embarked
								? arr_of_sea_service.embarked
								: "-",
							disembarked = arr_of_sea_service.disembarked
								? arr_of_sea_service.disembarked
								: "-",
							agency = arr_of_sea_service.agency
								? arr_of_sea_service.agency
								: "-",
							remarks = arr_of_sea_service.remarks
								? arr_of_sea_service.remarks
								: "-";

						table += "<td>" + count + "</td>";
						table += "<td>" + vessel + "</td>";
						table += "<td>" + flag + "</td>";
						table += "<td>" + salary + "</td>";
						table += '<td class="font-weight-medium">' + position + "</td>";
						table += "<td>" + type_vessel + "</td>";
						table += "<td>" + grt_power + "</td>";
						table += "<td>" + embarked + "</td>";
						table += "<td>" + disembarked + "</td>";
						table += "<td>" + total_service + "</td>";
						table += "<td>" + agency + "</td>";
						table += "<td>" + remarks + "</td>";
						table += "</tr>";

						count++;
					});

					$("#vessel_history_table").html(table);
					$("#vh_applicant_code").val(cmp_code);
				}
			}
		},
	});

	$.ajax({
		url: base_url + "get-cmp-sea-service",
		type: "POST",
		data: {
			code: cmp_code,
		},
		success: function (data) {
			let embarked = JSON.parse(data.embarked);
			let disembarked = JSON.parse(data.disembarked);
			$("#history_total_service").html(
				getTotalServiceDuration(embarked, disembarked)
			);
		},
	});
	$("#gvh_applicant_name").html(getNameByCmpcode(cmp_code));
	$("#vh_applicant_code").val(cmp_code);
	$("#vessel_history_modal").modal("show");
}

function applicantNotQualifiedModal(applicant_code) {
	$("#r_app_code").val(applicant_code);
	$("#not_qualified_modal").modal("show");
}

function remove_sea_service_record(rid) {
	$(".removeclass" + rid).remove();
	room--;
}

function formWarningStatuses(id) {
	$.ajax({
		url: base_url + "get-warning-statuses",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formSeaService(id) {
	room++;

	$.ajax({
		url: base_url + "get-sea-service",
		type: "POST",
		data: {
			room: room,
		},
		success: function (data) {
			if (data) {
				$("#" + id).append(data);
			}
		},
	});
}

function formSeaServices(form_count, id) {
	$.ajax({
		url: base_url + "get-sea-services",
		type: "POST",
		data: {
			form_count: form_count,
		},
		success: function (data) {
			if (data) {
				$("#" + id).append(data);
			}
		},
	});
}

function formAllPosition(id) {
	$.ajax({
		url: base_url + "get-all-position",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text =
					data[index].position_code + " - " + data[index].position_name;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formPromotionPosition(id, pos) {
	$.ajax({
		url: base_url + "get-all-position",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				if (data[index].rank < pos) {
					var option = document.createElement("option");
					option.text =
						data[index].position_code + " - " + data[index].position_name;
					option.value = data[index].id;
					x.add(option);
				}
			}
		},
	});
}

function addSeaServiceForm(obj) {
	var obj_id = obj.id;

	var parent_container = $("#" + obj_id).closest(
		"div[id^='sea_service_record_field']"
	);
	let form_count = parent_container.find("div[data-service-form-num]").length;

	$.ajax({
		url: base_url + "get-sea-service",
		type: "POST",
		data: {
			room: form_count + 1,
		},
		success: function (data) {
			if (data) {
				parent_container.append(data);
			}
		},
	});
}

function formAllUserType(id) {
	$.ajax({
		url: base_url + "get-all-usertype",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formAllCrewName(id) {
	$.ajax({
		url: base_url + "search-crew-warningletter",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].text;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formOffSignerName(id, monitor_code) {
	$.ajax({
		url: base_url + "get-crew-offsigner",
		type: "GET",
		data: {
			monitor_code: monitor_code,
		},
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].text;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formByPosition(id, first_position) {
	$("#" + id).empty();

	if (first_position) {
		$.ajax({
			url: base_url + "get-position-by-position",
			type: "POST",
			data: {
				first_position: first_position,
			},
			dataType: "JSON",
			success: function (data) {
				var x = document.getElementById(id);

				var option = document.createElement("option");
				option.text = "Select Second Position";
				option.value = "";
				x.add(option);

				for (let index = 0; index < data.length; index++) {
					if (first_position < data[index].rank) {
						var option = document.createElement("option");
						option.text =
							data[index].position_code + " - " + data[index].position_name;
						option.value = data[index].id;
						x.add(option);
					}
				}
			},
		});
	} else {
		var x = document.getElementById(id);

		var option = document.createElement("option");
		option.text = "Select Second Position";
		option.value = "";
		x.add(option);
	}
}

function formSuffix(id) {
	$.ajax({
		url: base_url + "get-all-suffix",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formCivilStatus(id) {
	$.ajax({
		url: base_url + "get-all-civil-status",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formReligion(id) {
	$.ajax({
		url: base_url + "get-all-religion",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formNationality(id) {
	$.ajax({
		url: base_url + "get-all-nationality",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formProvince(id) {
	$.ajax({
		url: base_url + "get-all-province",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formCity(province, id) {
	$("#" + id).empty();

	$.ajax({
		url: base_url + "get-cities",
		type: "POST",
		data: {
			province: province,
		},
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			var option = document.createElement("option");
			option.text = "Choose option";
			option.value = "";
			x.add(option);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formAllCity(id) {
	$.ajax({
		url: base_url + "get-all-city",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formTrainingCertificate(first_position, second_position, id) {
	$.ajax({
		url: base_url + "get-training-certificates",
		type: "POST",
		data: {
			first_position: first_position,
			second_position: second_position,
		},
		success: function (data) {
			$("#" + id).html(data);
		},
	});
}

function formLicenses(id) {
	$.ajax({
		url: base_url + "get-all-licenses",
		type: "GET",
		success: function (data) {
			$("#" + id).html(data);
		},
	});
}

function formSource(id) {
	$.ajax({
		url: base_url + "get-all-source",
		type: "GET",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formVessel(id) {
	$.ajax({
		url: base_url + "get-all-vessels",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].vsl_code + " - " + data[index].vsl_name;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formTypeVessel(id) {
	$.ajax({
		url: base_url + "get-all-type-vessels",
		type: "GET",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].tv_name;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formDepartment(id) {
	$.ajax({
		url: base_url + "get-all-department",
		type: "GET",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].department_name;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formAllContracts(id) {
	$.ajax({
		url: base_url + "get-all-contracts",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].contract_name;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

function formAllTocReasons(id) {
	$.ajax({
		url: base_url + "get-all-toc-reasons",
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			var x = document.getElementById(id);

			for (let index = 0; index < data.length; index++) {
				var option = document.createElement("option");
				option.text = data[index].description;
				option.value = data[index].id;
				x.add(option);
			}
		},
	});
}

// Format

function formatBMI(height, weight) {
	var bmi;

	var new_height = height.replace(" ", "");
	var new_weight = weight.replace(" ", "");

	bmi = (new_weight / new_height / new_height) * 10000;

	return isNaN(bmi) ? 0.0 : bmi;
}

function formatCivilStatus(civil_status) {
	var civil_status_description;

	$.ajax({
		url: base_url + "get-civil-status",
		type: "POST",
		async: false,
		data: {
			civil_status: civil_status,
		},
		success: function (data) {
			civil_status_description = data.description;
		},
	});

	return civil_status_description;
}

function formatReligion(religion) {
	var religion_description;

	$.ajax({
		url: base_url + "get-religion",
		type: "POST",
		async: false,
		data: {
			religion: religion,
		},
		success: function (data) {
			religion_description = data ? data.description : "";
		},
	});

	return religion_description;
}

function formatNationality(nationality) {
	var nationality_description;

	$.ajax({
		url: base_url + "get-nationality",
		type: "POST",
		async: false,
		data: {
			nationality: nationality,
		},
		success: function (data) {
			nationality_description = data.description;
		},
	});

	return nationality_description;
}

function formatCity(city) {
	var city_description;

	$.ajax({
		url: base_url + "get-city",
		type: "POST",
		async: false,
		data: {
			city: city,
		},
		success: function (data) {
			city_description = data.description;
		},
	});

	return city_description;
}

function formatProvince(province) {
	var province_description;

	$.ajax({
		url: base_url + "get-province",
		type: "POST",
		async: false,
		data: {
			province: province,
		},
		success: function (data) {
			province_description = data.description;
		},
	});

	return province_description;
}

function formatPosition(id) {
	var position_description;

	$.ajax({
		url: base_url + "get-position-details",
		type: "POST",
		async: false,
		data: {
			id: id,
		},
		success: function (data) {
			position_description = data ? data.position_name : "-";
		},
	});

	return position_description;
}

function formatVessel(id) {
	var vessel_description;

	$.ajax({
		url: base_url + "get-vessel",
		type: "POST",
		async: false,
		data: {
			id: id,
		},
		success: function (data) {
			vessel_description = data.vsl_name;
		},
	});

	return vessel_description;
}

function formatVesselType(id) {
	var vessel_type_description;

	$.ajax({
		url: base_url + "get-vessel-type",
		type: "POST",
		async: false,
		data: {
			id: id,
		},
		success: function (data) {
			vessel_type_description = data.tv_name;
		},
	});

	return vessel_type_description;
}

function formatVesselTypeByVessel(id) {
	var vessel_type_description;

	$.ajax({
		url: base_url + "get-vessel-type-vessel",
		type: "POST",
		async: false,
		data: {
			id: id,
		},
		success: function (data) {
			vessel_type_description = data.tv_name;
		},
	});

	return vessel_type_description;
}

function formatVesselTypeIdByVessel(id) {
	var vessel_type_description;

	$.ajax({
		url: base_url + "get-vessel-type-vessel",
		type: "POST",
		async: false,
		data: {
			id: id,
		},
		success: function (data) {
			vessel_type_description = data.id;
		},
	});

	return vessel_type_description;
}

function formatDate(birth_date) {
	var monthNames = [
		"January",
		"February",
		"March",
		"April",
		"May",
		"June",
		"July",
		"August",
		"September",
		"October",
		"November",
		"December",
	];

	var day = new Date(birth_date).getDate();
	var monthIndex = new Date(birth_date).getMonth();
	var year = new Date(birth_date).getFullYear();

	return monthNames[monthIndex] + " " + day + ", " + year;
}

function formatDateForDate(date) {
	var now = new Date(date);

	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);

	var today = now.getFullYear() + "-" + month + "-" + day;

	return today;
}

function getDateDuration(date1, date2) {
	if (date1 && date2) {
		var date1 = moment(date1);
		var date2 = moment(date2);

		var date_duration = moment.duration(date2.diff(date1));

		var display = "";

		var years = date_duration.years();
		var months = date_duration.months();
		var days = date_duration.days();

		if (years != 0) {
			display += years + (years == 1 ? " Year " : " Years ");
		}

		if (months != 0) {
			display += months + (months == 1 ? " Month " : " Months ");
		}

		if (days != 0) {
			display += days + (days == 1 ? " Day " : " Days ");
		}

		return display;
	}
}

function getDateDuration2(date1, date2) {
	if (date1 && date2) {
		var date1 = moment(date1);
		var date2 = moment(date2);

		var date_duration = moment.duration(date2.diff(date1));

		var display = "";

		var years = date_duration.years();
		var months = date_duration.months();
		var days = date_duration.days();

		if (years != 0) {
			display += years + (years == 1 ? "" : "");
		}

		if (months != 0) {
			display += months + (months == 1 ? "" : "");
		}

		if (days != 0) {
			display += days + (days == 1 ? "" : "");
		}

		return display;
	}
}

function getAge(birth_date) {
	var today = new Date();
	var birthDate = new Date(birth_date);
	var age = today.getFullYear() - birthDate.getFullYear();
	var m = today.getMonth() - birthDate.getMonth();
	if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
		age = age - 1;
	}

	return age;
}

function getUserDetails(user_code) {
	var user_details;

	$.ajax({
		url: base_url + "get-account-details",
		type: "POST",
		async: false,
		data: {
			user_code: user_code,
		},
		dataType: "JSON",
		success: function (data) {
			user_details = data;
		},
	});

	return user_details;
}

function getNameByCmpcode(cmp_code) {
	var crew_name;
	$.ajax({
		url: base_url + "get-crew-name",
		type: "POST",
		async: false,
		data: {
			cmp_code: cmp_code,
		},
		dataType: "JSON",
		success: function (data) {
			crew_name = data.name;
		},
	});

	return crew_name;
}

function getApplicantType(code) {
	var applicant_type;
	$.ajax({
		url: base_url + "get-applicant-type",
		type: "POST",
		async: false,
		data: {
			code: code,
		},
		dataType: "JSON",
		success: function (data) {
			applicant_type = data.type_applicant;
		},
	});

	return applicant_type;
}

function getNameByMntrcode(mntr_code) {
	var crew_name;
	$.ajax({
		url: base_url + "get-crew-name-by-monitor",
		type: "POST",
		async: false,
		data: {
			mntr_code: mntr_code,
		},
		dataType: "JSON",
		success: function (data) {
			crew_name = data.fullname;
		},
	});

	return crew_name;
}

function getUserPosition(crew_code) {
	var crew_position;
	$.ajax({
		url: base_url + "get-crew-position",
		type: "POST",
		async: false,
		data: {
			crew_code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			crew_position = data;
		},
	});

	return crew_position;
}

function getCrewDisembark(monitor_code) {
	var disembark;
	$.ajax({
		url: base_url + "get-crew-disembark",
		type: "POST",
		async: false,
		data: {
			monitor_code: monitor_code,
		},
		dataType: "JSON",
		success: function (data) {
			disembark = !data.check_if_contract_ends ? data.disembark : "";
		},
	});

	return disembark;
}

function validationInput(validation, input_id) {
	if (validation) {
		$("#" + input_id + "_alert").remove();
		$("#" + input_id).addClass("parsley-error");
		$("#" + input_id).after(
			'<ul class="parsley-errors-list filled" id="' +
				input_id +
				'_alert"><li class="parsley-required"><p>' +
				validation +
				"</p></li></ul>"
		);
	} else {
		$("#" + input_id + "_alert").remove();
		$("#" + input_id).removeClass("parsley-error");
	}
}

function validationInputGroup(validation, input_id) {
	if (validation) {
		$("#" + input_id).addClass("parsley-error");
		$("#" + input_id + "_alert").html(
			'<li class="parsley-required"><p>' + validation + "</p></li>"
		);
	} else {
		$("#" + input_id + "_alert").html("");
		$("#" + input_id).removeClass("parsley-error");
	}
}

function validationRadioButton(validation, input_id) {
	if (validation) {
		$("#" + input_id).addClass("parsley-error");
		$("#" + input_id + "_alert").html(
			'<li class="parsley-required"><p>' + validation + "</p></li>"
		);
	} else {
		$("#" + input_id + "_alert").html("");
		$("#" + input_id).removeClass("parsley-error");
	}
}

function validationPassword(validation, input_id) {
	if (validation) {
		$("#" + input_id).addClass("parsley-error");
		$("#" + input_id + "_alert").html(
			'<li class="parsley-required"><p>' + validation + "</p></li>"
		);
	} else {
		$("#" + input_id + "_alert").html("");
		$("#" + input_id).removeClass("parsley-error");
	}
}

function reload() {
	location.reload();
}

function getWarningLetterDetails(crew_code) {
	$.ajax({
		url: base_url + "get-warning-letter-details",
		type: "POST",
		data: { crew_code: crew_code },
		dataType: "JSON",
		success: function (data) {
			if (data) {
				formWarningStatuses("w_type_of_nre");

				setSelectValueAfterElementChange("w_type_of_nre", data.reason);

				$("#awlm_department").val(data.department);

				$("#wlrm_crew_name").html(data.crew_name);
				$("#wlrm_remarks").val(data.remarks);

				$("#wlrm_additional_remarks").val(data.additional_remarks);
				$("#warning_letter_reason_modal").modal("show");
			}
		},
	});
}

function isJson(str) {
	try {
		return JSON.parse(str);
	} catch (e) {
		return false;
	}
}

function totalservice(obj) {
	var obj_id = obj.id;

	var row_num = $("#" + obj_id)
		.closest(".form-row")
		.attr("data-service-form-num");
	var embarked_date = $("#s_embarked" + row_num).val();
	var disembarked_date = $("#s_disembarked" + row_num).val();

	$("#s_total_service" + row_num).val(
		getDateDuration(embarked_date, disembarked_date)
	);
}

function addNATResult(applicant_code, nat_result, full_name) {
	$("#n_app_code").val(applicant_code);
	$("#n_aptitude_test_score").val(nat_result);
	$("#nat_applicant_name").html(full_name);
	$("#nat_result_modal").modal("show");
}

function formLicensesPerPosition(first_position, second_position, form_id) {
	$.ajax({
		url: base_url + "get-licenses-by-positions",
		type: "GET",
		dataType: "JSON",
		data: {
			first_position: first_position,
			second_position: second_position,
		},
		success: function (data) {
			$("#" + form_id).html(data.licenses_form);
		},
	});
}

function setSelectValueAfterElementChange(id, value) {
	var target = document.getElementById(id);

	var observer = new MutationObserver(function (mutations) {
		$("#" + id).val(value == 0 ? "" : value);
	});

	// configuration of the observer:
	var config = { attributes: true, childList: true, characterData: true };
	// pass in the target node, as well as the observer options
	observer.observe(target, config);
}

function getViewEditPrejoiningLicenses(crew_code, name) {
	var modal_licenses = $("#v_e_pre_joining_visa_modal_licenses");

	$.ajax({
		url: base_url + "get-list-licenses",
		type: "POST",
		data: { code: crew_code },
		success: function (data) {
			modal_licenses.find("#crew_list_licenses_edit").append(data);
		},
	});

	modal_licenses.find("#btn_edit_license_edit").val(crew_code);
	modal_licenses.find("#view_license").val(crew_code);
	modal_licenses.find("#vepjv_crew_name").html(name);
	modal_licenses.modal("show");
}

function getViewEditPrejoiningCertificates(crew_code, name) {
	var modal_certificates = $("#v_e_pre_joining_visa_modal_certificates");

	$.ajax({
		url: base_url + "get-list-certificates",
		type: "POST",
		data: { code: crew_code },
		success: function (data) {
			modal_certificates.find("#crew_list_certificates_edit").append(data);
		},
	});

	modal_certificates.find("#btn_edit_certificates").val(crew_code);
	modal_certificates.find("#btn_view_certificates_edit").val(crew_code);
	modal_certificates.find("#vepjv_crew_name_cert").html(name);
	modal_certificates.modal("show");
}

function getOnViewPrejoiningVisa(
	cmp_code = "",
	crew_code = "",
	full_name = ""
) {
	$.ajax({
		url: base_url + "get-list-licenses-cmp",
		type: "POST",
		data: {
			code: cmp_code,
			crew_code: crew_code,
		},
		success: function (data) {
			$("#crew_list_licenses").empty();
			$("#crew_list_licenses").html(data);
		},
	});

	$.ajax({
		url: base_url + "get-list-certificates-cmp",
		type: "POST",
		data: {
			code: cmp_code,
			crew_code: crew_code,
		},
		success: function (data) {
			$("#crew_list_certificates").empty();
			$("#crew_list_certificates").append(data);
		},
	});
	$("#btn_edit_license").hide();
	$("#btn_edit_certificates").hide();
	$("#cert_crew_name").html(
		getNameByCmpcode(cmp_code) ? getNameByCmpcode(cmp_code) : full_name
	);
	$("#pre_joining_visa_modal").modal("show");
}

function viewCrewContracts(crew_code, name) {
	$("#contract_table_body").DataTable({
		ajax: {
			url: base_url + "get-crew-contract-table",
			type: "POST",
			data: { crew_code: crew_code },
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

	$("#mlc_table_body").DataTable({
		ajax: {
			url: base_url + "get-crew-mlc-table",
			type: "POST",
			data: { crew_code: crew_code },
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
	$("#c_crew_name").html(name);
	$("#v_contracts_modal").modal("show");
}

function getMedicalRecords(crew_code, name) {
	$("#medical_table").DataTable({
		ajax: {
			url: base_url + "get-medical-records-table",
			type: "POST",
			data: { crew_code: crew_code },
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
	$("#m_crew_name").html(name);
}

$("#MedicalBtnClose").click(function () {
	$("#medical_table").DataTable().clear().draw();
	location.reload(true);
});

function updatePosAndVess() {
	var crew_name = $("#v_e_crew_information_modal")
		.find("#v_applicant_full_name")
		.text();
	var insigner = $("#v_e_crew_information_modal").find("#e_insigner").val();

	$("#edit_position_vessel_modal").find("#epvm_crew_name").text(crew_name);
	$("#edit_position_vessel_modal").find("#hidden_insigner").val(insigner);
	$("#edit_position_vessel_modal").modal("show");
}

function getViewPrejoiningRoutingSlip(monitor_code) {
	$.ajax({
		url: base_url + "get-routing-slip",
		type: "POST",
		data: {
			monitor_code: monitor_code,
		},
		dataType: "JSON",
		success: function (data) {
			if (data) {
				$("#mrsm_crew_name").html(data.full_name);
				$(".crew_name").html(data.full_name);
				$(".crew_pos").html(
					data.position_name + "(" + data.position_code + ")"
				);
				$(".crew_vsl").html(data.vsl_name + "(" + data.vsl_code + ")");

				if (data.type_applicant === "CBA") {
					$("#with_cba").prop("checked", true);
					$("#with_cba").val(1);
				} else if (data.with_cba === "1") {
					$("#with_cba").prop("checked", true);
					$("#with_cba").val(1);
				} else {
					$("#with_cba").val(0);
				}

				$("#mntr_code").val(data.monitor_code);
				$("#crw_code").val(data.crew_code);

				if (data.routing_details) {
					var routing_details = JSON.parse(data.routing_details);
					for (let index = 0; index < routing_details.length; index++) {
						if (routing_details[index] == "1") {
							$("#mrsm_csd_" + index).prop("checked", true);
						} else if (routing_details[index] == "0") {
							$("#mrsm_cs_" + index).prop("checked", true);
						}
					}
				}

				if (data.remarks != null) {
					var r_remarks = JSON.parse(data.remarks);
					for (let i = 0; i < r_remarks.length; i++) {
						var index = i + 1;
						$("#mrsm_remarks_" + index).val(r_remarks[i]);
					}
				}

				if (data.dates != null) {
					var r_dates = JSON.parse(data.dates);
					for (let i = 0; i < r_dates.length; i++) {
						var index = i + 2;
						$("#mrsm_date_0").val(
							r_dates[0] ? r_dates[0] : formatDateForDate(data.actc_date)
						);
						$("#mrsm_date_1").val(
							r_dates[1] ? r_dates[1] : formatDateForDate(data.acis_date)
						);
						$("#mrsm_date_" + index).val(r_dates[index]);
					}
				} else {
					$("#mrsm_date_0").val(
						data.actc_date ? formatDateForDate(data.actc_date) : ""
					);
					$("#mrsm_date_1").val(
						data.acis_date ? formatDateForDate(data.acis_date) : ""
					);
				}
			}
		},
	});

	$("#manage_routing_slip_modal").modal("show");
}
