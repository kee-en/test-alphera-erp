$(document).ready(function () {

});

$("#Btn_backup").click(function () {
	window.open(base_url + "backup-database-function");
	location.reload(true);
});

function deleteDB(name, id) {
	Swal.fire({
		title: "Are you sure you want to delete this database?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, delete it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "delete-backup-db",
				type: "POST",
				data: {
					file_name: name,
					id: id
				},
				success: function (data) {
					Swal.fire({
						icon: data.type,
						title: data.title,
						allowOutsideClick: false,
						allowEscapeKey: false,
					}).then(function () {
						location.reload(true);
					});
				}
			});
		}
	});
};
