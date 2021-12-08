$(document).ready(function () {
	$("#node_table").DataTable({
		ajax: {
			url: base_url + "get-node-table",
			type: "POST",
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
});

$("#add_node_form").submit(function () {
	$.ajax({
		url: base_url + "add-node",
		type: "POST",
		data: $("#add_node_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			validationInput(data.sub_module, "sub_module");
			validationInput(data.node, "node");
			validationInput(data.node_url, "node_url");

			if (data.type === "success") {
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					location.reload(true);
				});
			}
		},
	});
});

$("#btnReset").click(function () {
	validationInput("", "sub_module");
	validationInput("", "node");
	validationInput("", "node_url");
});

function editNode(id) {
	$.ajax({
		url: base_url + "get-node",
		type: "POST",
		data: {
			id: id,
		},
		dataType: "JSON",
		success: function (data) {
			$("#e_node_id").val(data.id);
			$("#e_sub_module").val(data.form_sub_module_id);
			$("#e_node_name").val(data.description);
			$("#e_node_url").val(data.url);
		},
	});
}

$("#edit_node_form").submit(function () {
	$.ajax({
		url: base_url + "save-edit-node",
		type: "POST",
		data: $("#edit_node_form").serialize(),
		dataType: "JSON",
		beforeSend: function () {
			$("#btnEditNode").html(
				'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
			);
		},
		success: function (data) {
			validationInput(data.e_sub_module, "e_sub_module");
			validationInput(data.e_node_name, "e_node_name");
			validationInput(data.e_node_url, "e_node_url");

			if (data.type === "success") {
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					location.reload(true);
				});
			}

			$("#btnEditNode").html("Save Changes");
		},
	});
});

$("#btnIconEditNode").click(function () {
	validationInput("", "e_sub_module");
	validationInput("", "e_node_name");
	validationInput("", "e_node_url");
});

$("#btnCloseEditNode").click(function () {
	validationInput("", "e_sub_module");
	validationInput("", "e_node_name");
	validationInput("", "e_node_url");
});

function removeNode(id) {
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
				url: base_url + "remove-node",
				type: "POST",
				data: {
					id: id,
				},
				dataType: "JSON",
				success: function (data) {
					if (data.type === "success") {
						Swal.fire({
							icon: data.type,
							title: data.title,
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

$("#sub_module").keyup(function () {
	$.ajax({
		url: base_url + "add-node-form-validation",
		type: "POST",
		data: $("#add_node_form").serialize(),
		success: function (data) {
			validationInput(data.sub_module, "sub_module");
		},
	});
});

$("#node").keyup(function () {
	$.ajax({
		url: base_url + "add-node-form-validation",
		type: "POST",
		data: $("#add_node_form").serialize(),
		success: function (data) {
			validationInput(data.node, "node");
		},
	});
});

$("#node_url").keyup(function () {
	$.ajax({
		url: base_url + "add-node-form-validation",
		type: "POST",
		data: $("#add_node_form").serialize(),
		success: function (data) {
			validationInput(data.node_url, "node_url");
		},
	});
});

$("#e_sub_module").change(function () {
	$.ajax({
		url: base_url + "edit-node-form-validation",
		type: "POST",
		data: $("#edit_node_form").serialize(),
		success: function (data) {
			validationInput(data.e_sub_module, "e_sub_module");
		},
	});
});

$("#e_node_name").keyup(function () {
	$.ajax({
		url: base_url + "edit-node-form-validation",
		type: "POST",
		data: $("#edit_node_form").serialize(),
		success: function (data) {
			validationInput(data.e_node_name, "e_node_name");
		},
	});
});

$("#e_node_url").keyup(function () {
	$.ajax({
		url: base_url + "edit-node-form-validation",
		type: "POST",
		data: $("#edit_node_form").serialize(),
		success: function (data) {
			validationInput(data.e_node_url, "e_node_url");
		},
	});
});
