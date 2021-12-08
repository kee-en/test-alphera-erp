$(document).ready(function () {
	$("#points_of_interview_table").DataTable({
		ajax: {
			url: base_url + "get-interview-form-table",
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

$("#interview_form").submit(function () {
	$.ajax({
		url: base_url + "add-points-interview-form",
		type: "POST",
		data: $("#interview_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.points_of_interview, "points_of_interview");
			if (data.type === "success") {
				$("#interview_form").trigger("reset");
				$("#points_of_interview_table")
					.DataTable()
					.ajax.reload();
				Swal.fire({
					icon: data.type,
					title: data.title
				});
			} else if (data.type === "error") {
				Swal.fire({
					icon: data.type,
					title: data.title
				});
			}
		}
	});
});

function editInterviewForm(id) {
	$.ajax({
		url: base_url + "get-interview-form-details",
		type: "POST",
		data: {
			id: id
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_points_of_interview_id").val(data.id);
			$("#e_points_of_interview").val(data.pti_description);
			if (data.general_form === "1") {
				$("#e_general_form").attr("checked", true);
			}
		}
	});
}

$("#e_interview_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-points-interview-form",
		type: "POST",
		data: $("#e_interview_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.e_points_of_interview, "e_points_of_interview");
			if (data.type === "success") {
				$("#edit_points_of_interview_modal").modal("toggle");
				$("#points_of_interview_table")
					.DataTable()
					.ajax.reload();
				Swal.fire({
					icon: data.type,
					title: data.title
				});
			} else if (data.type === "warning") {
				Swal.fire({
					icon: data.type,
					title: data.title
				});
			}
		}
	});
});

function removeInterviewForm(id) {
	Swal.fire({
		title: "Are you sure you want to remove this?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, remove it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "remove-interview-form",
				type: "POST",
				data: {
					id: id
				},
				dataType: "JSON",
				success: function (data) {
					Toast.fire({
						icon: data.type,
						title: data.title
					});

					if (data.type === "success") {
						$("#points_of_interview_table")
							.DataTable()
							.ajax.reload();
					}
				}
			});
		}
	});
}
$("#resetbtn").click(function () {
	validationInput("", "points_of_interview");
});

function btnClose() {
	location.reload(true);
}

$("#points_of_interview").keyup(function () {
	$.ajax({
		url: base_url + "add-interview-validation",
		type: "POST",
		data: $("#interview_form").serialize(),
		success: function (data) {
			validationInput(data.points_of_interview, "points_of_interview");
		},
	});
});

$("#e_points_of_interview").keyup(function () {
	$.ajax({
		url: base_url + "edit-interview-validation",
		type: "POST",
		data: $("#e_interview_form").serialize(),
		success: function (data) {
			validationInput(data.e_points_of_interview, "e_points_of_interview");
		},
	});
});
