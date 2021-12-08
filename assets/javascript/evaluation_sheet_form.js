$("#evaluation_sheet_form").submit(function () {
	Swal.fire({
		title: "Are you sure you want to save this?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, save it!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "save-edit-evaluation-sheet-form",
				type: "POST",
				data: $("#evaluation_sheet_form").serialize(),
				dataType: "JSON",
				success: function (data) {
					if (data.type) {
						Swal.fire({
							icon: data.type,
							title: data.title,
						});

						if (data.type === "success") {
							$("#evaluation_sheet_form").trigger("reset");
						}
					}
				},
			});
		}
	});
});

function positionOnChange(id) {
	$.ajax({
		url: base_url + "get-evaluation-value",
		type: "POST",
		data: {
			id: id,
		},
		success: function (data) {
			if (data === null) {
				$("#evaluation_sheet_form")[0].reset();
			} else {
				var count = 1;
				var add_point = JSON.parse(data.additional_point);
				var sub_point = JSON.parse(data.subtract_point);
				var evaluations = JSON.parse(data.evaluations);

				if (add_point) {
					for (let add = 0; add < add_point.length; add++) {
						$("#additional_point_" + count).val(add_point[add]);
						count++;
					}
				}

				count = 1;

				if (sub_point) {
					for (let sub = 0; sub < sub_point.length; sub++) {
						$("#subtract_point_" + count).val(sub_point[sub]);
						count++;
					}
				}

				if (evaluations) {
					$("#min_age").val(evaluations.min_age);
					$("#tob_period").val(evaluations.tob_period);
					$("#sks_skr").val(evaluations.sks_skr);
					$("#skor_standard").val(evaluations.skor_standard);
					$("#age_standard").val(evaluations.age_standard);
				} else {
					$("#min_age").val("");
					$("#tob_period").val("");
					$("#sks_skr").val("");
					$("#skor_standard").val("");
					$("#age_standard").val("");
				}
			}
		},
	});
}
