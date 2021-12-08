$(document).ready(function() {
	$("#type_of_engine_table").DataTable({
		ajax: {
			url: base_url + "get-engine-type-table",
			type: "POST"
		},
		language: {
			paginate: {
				previous: "<i class='mdi mdi-chevron-left'>",
				next: "<i class='mdi mdi-chevron-right'>"
			}
		},
		drawCallback: function() {
			$(".dataTables_paginate > .pagination").addClass("pagination-rounded");
		}
	});
});

$("#vessel_engine_form").submit(function() {
	$.ajax({
		url: base_url + "add-vessel-engine",
		type: "POST",
		data: $("#vessel_engine_form").serialize(),
		dataType: "JSON",
		success: function(data) {
			validationInput(data.engine_code, "engine_code");
			validationInput(data.engine_name, "engine_name");
			if (data.type === "success") {
				$("#vessel_engine_form").trigger("reset");
				$("#type_of_engine_table")
					.DataTable()
					.ajax.reload();
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			}else if(data.type === "error"){
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			}
		}
	});
});

function editVesselEngine(id) {
	$.ajax({
		url: base_url + "get-vessel-engine",
		type: "POST",
		data: {
			id: id
		},
		dataType: "JSON",
		success: function(data) {
			$("#e_engine_id").val(data.id);
			$("#e_engine_code").val(data.engine_code);
			$("#e_engine_name").val(data.engine_name);
		}
	});
}

$("#e_vessel_engine_form").submit(function() {
	$.ajax({
		url: base_url + "save-edit-vessel-engine",
		type: "POST",
		data: $("#e_vessel_engine_form").serialize(),
		dataType: "JSON",
		success: function(data) {
			validationInput(data.e_engine_code, "e_engine_code");
			validationInput(data.e_engine_name, "e_engine_name");
			if (data.type === "success") {
				$("#edit_engine_vessel_modal").modal("toggle");
				$("#type_of_engine_table")
					.DataTable()
					.ajax.reload();
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			}else if(data.type === "warning"){
				Swal.fire({
					icon: data.type,
					title: data.title,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
			}
		}
	});
});

function removeVesselEngine(id) {
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
				url: base_url + "remove-vessel-engine",
				type: "POST",
				data: {
					id: id
				},
				dataType: "JSON",
				success: function(data) {
					Swal.fire({
						icon: data.type,
						title: data.title,
						confirmButtonText: "Close",
						allowOutsideClick: false,
						allowEscapeKey: false,
					});
		
					if (data.type === "success") {
						$("#type_of_engine_table")
							.DataTable()
							.ajax.reload();
					}
				}
			});
		}
	});
}

$("#btnReset").click(function(){
	validationInput("", "engine_code");
	validationInput("", "engine_name");
});

function btnClose() {
	location.reload(true);
}

//VALIDATIONS
$("#engine_code").keyup(function () {
	$.ajax({
		url: base_url + "add-engine-type-validation",
		type: "POST",
		data: $("#vessel_engine_form").serialize(),
		success: function (data) {
			validationInput(data.engine_code, "engine_code");
		},
	});
});
$("#engine_name").keyup(function () {
	$.ajax({
		url: base_url + "add-engine-type-validation",
		type: "POST",
		data: $("#vessel_engine_form").serialize(),
		success: function (data) {
			validationInput(data.engine_name, "engine_name");
		},
	});
});

$("#e_engine_code").keyup(function () {
	$.ajax({
		url: base_url + "edit-engine-type-validation",
		type: "POST",
		data: $("#e_vessel_engine_form").serialize(),
		success: function (data) {
			validationInput(data.e_engine_code, "e_engine_code");
		},
	});
});
$("#e_engine_name").keyup(function () {
	$.ajax({
		url: base_url + "edit-engine-type-validation",
		type: "POST",
		data: $("#e_vessel_engine_form").serialize(),
		success: function (data) {
			validationInput(data.e_engine_name, "e_engine_name");
		},
	});
});