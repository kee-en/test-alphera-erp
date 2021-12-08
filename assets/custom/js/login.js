$("#login_form").submit(function (data) {
	$.ajax({
		url: base_url + "auth",
		type: "POST",
		data: $("#login_form").serialize(),
		dataType: "JSON",
		beforeSend: function () {
            $("#btn_login").html(
                '<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
            );
        },
		success: function (data) {
			if (data.type === "success") {
				Swal.fire({
					icon: data.type,
					title: data.title,
					text: data.text,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					location.replace(base_url + "registered-applicants");
				});
			} else {
				Swal.fire({
					icon: data.type,
					title: data.title
				});
			}

			$("#btn_login").html("Log In");
		},
	});
});
