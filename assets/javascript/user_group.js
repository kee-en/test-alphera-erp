$(document).ready(function () {
	$("#user_group_table").DataTable({
		ajax: {
			url: base_url + "get-user-group-table",
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

$("#user_group_form").submit(function () {
	$.ajax({
		url: base_url + "add-user-group",
		type: "POST",
		data: $("#user_group_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			if (data.type) {
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});

				if (data.type === "success") {
					$("#user_group_form").trigger("reset");
					$("#user_group_table")
						.DataTable()
						.ajax.reload();
				}
			}
		}
	});
});

function editUserGroup(id) {
	$.ajax({
		url: base_url + "get-user-group",
		type: "POST",
		data: {
			id: id
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_user_group_id").val(data.id);
			$("#e_code").val(data.code);
			$("#e_description").val(data.description);
		}
	});
}

$("#e_user_group_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-user-group",
		type: "POST",
		data: $("#e_user_group_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			if (data.type) {
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});

				if (data.type === "success") {
					$("#edit_user_group_modal").modal("toggle");
					$("#user_group_table")
						.DataTable()
						.ajax.reload();
				}
			}
		}
	});
});

function removeUserGroup(id) {
	Swal.fire({
		title: "Are you sure you want to remove this ?",
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
				url: base_url + "remove-user-group",
				type: "POST",
				data: {
					id: id
				},
				dataType: "JSON",
				success: function (data) {
					Swal.fire({
						icon: data.type,
						title: data.title,
						confirmButtonText: "Close",
						allowOutsideClick: false,
						allowEscapeKey: false,
					});

					if (data.type === "success") {
						$("#user_group_table")
							.DataTable()
							.ajax.reload();
					}
				}
			});
		}
	});
}