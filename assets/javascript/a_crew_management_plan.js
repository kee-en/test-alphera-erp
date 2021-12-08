$("#edit_cmp_form").submit(function () {
	$.ajax({
		url: base_url + "update-cmp-form",
		type: "POST",
		data: $("#edit_cmp_form").serialize(),
		beforeSend: function () {
			$("#BtnUpdateCMP").html(
				'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
			);
			$("#BtnUpdateCMP").prop("disabled", true);
		},
		success: function (data) {
			validationInput(data.c_onboard, "c_onboard");
			validationInput(data.c_line_up, "c_line_up");
			validationInput(data.c_sign_on, "c_sign_on");
			validationInput(data.c_end_contract, "c_end_contract");

			if (data.type) {
				Swal.fire({
					icon: data.type,
					title: data.title,
					text: data.text,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					if (data.type === 'success') {
						location.reload(true);
					}
				});
			}
			$("#BtnUpdateCMP").html(
				'Save Chnages'
			);
			$("#BtnUpdateCMP").prop("disabled", false);
		},
	});
})