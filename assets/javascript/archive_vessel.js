$(document).ready(function() {
	$("#archive_vessel_table").DataTable({
		ajax: {
			url: base_url + "get-archive-vessel-table",
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

function permanentlyDelete(id) {
	Swal.fire({
		title: "Are you sure you want to delete this data permanently ?",
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
				url: base_url + "permanently-delete-vessel",
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
						$("#archive_vessel_table")
							.DataTable()
							.ajax.reload();
					}
				}
			});	
		}
	});
}

function restoreVessel(id) {
	Swal.fire({
		title: "Are you sure you want to restore this data ?",
		icon: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
		allowEscapeKey: false,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "restore-vessel",
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
						$("#archive_vessel_table")
							.DataTable()
							.ajax.reload();
					}
				}
			});
		}
	});
}
