$(function () {
    formAllCrewName('w_crew_name');
	formAllTocReasons('w_reasons');
	
    var $eventSelect = $("#w_crew_name").select2();
    $eventSelect.on('change', function (e) {
        var app_code = this.value;
        $.ajax({
            url: base_url + "search-warningletter-id",
            type: "POST",
            data: { app_code: app_code },
            success: function (data) {
                if (data) {
                    $("#w_rank").empty();
                    $("#w_department").empty();
                    $("#w_vessel").empty();
                    $("#w_crew_code").empty();
                    $.each(data, function (key, value) {
                        $("#w_rank").append('<option value=' + value.position + '>' + value.position_name + '</option>');
                        $("#w_department").append('<option value=' + value.type_of_department + '>' + value.department_name + '</option>');
                        $("#w_vessel").append('<option value=' + value.vessel_assign + '>' + value.vsl_name + '</option>');
                        $("#w_crew_code").val(value.crew_code);
                    });
                }
            }
        });
    });
});

$("#btnResetWithdrawal").click(function () {
    validationInput("", "w_crew_name");
    validationInput("", "w_rank");
    validationInput("", "w_department");
    validationInput("", "w_vessel");
    validationInput("", "w_remarks");

    $('#w_rank')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Choose option</option>')
        .val('0');
    $('#w_department')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Choose option</option>')
        .val('0');
    $('#w_vessel')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Choose option</option>')
        .val('0');
    $('#w_crew_name')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Crew Name</option>')
        .val('0');
    formAllCrewName('w_crew_name');

    document.getElementById("crew_warning_letter_form").reset();
});


$('#crew_withdrawal_application').submit(function() {
	$.ajax({
			url: base_url + "save-crew-toc",
			type: "POST",
			data: $("#crew_withdrawal_application").serialize(),
			dataType: "JSON",
			beforeSend: function () {
				$("#btn_save_withdrawal").html(
					'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
				);
				$("#btn_save_withdrawal").prop("disabled", true);
			},
			success: function (data) {
	
				validationInput(data.w_crew_name, "w_crew_name");
				validationInput(data.w_rank, "w_rank");
				validationInput(data.w_vessel, "w_vessel");
				validationInput(data.w_remarks, "w_remarks");
				validationInput(data.w_department, "w_department");

                if (data.type) {
                    Swal.fire({
                        icon: data.type,
                        title: data.title,
                        text: data.text,
                        confirmButtonText: "Close",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then(function () {
                        if (data.type === "success") {
                            location.reload();
                        }
                    });
                }
				

				$("#btn_save_withdrawal").html(
					'Add'
				);
				$("#btn_save_withdrawal").prop("disabled", false);
		},
	});
});

function unWithdrawal(crew_code,fullname)
{
    $('#crew_code').val(crew_code);
    $('#wlrm_crew_name').val(fullname);
    $('#remove_crew_toc_modal').modal('show');
}

$("#un_toc_form").submit(function () {
	$.ajax({
		url: base_url + "un-withdrawal-crew",
		type: "POST",
		data: $("#un_toc_form").serialize(),
		dataType: "JSON",
		success: function (data) { 
			validationInput(data.toc_status, "toc_status");

			Swal.fire({
				icon: data.type,
				title: data.title,
				text: data.text,
				confirmButtonText: "Close",
				allowOutsideClick: false,
				allowEscapeKey: false,
			}).then(function () {
				if (data.type === "success") {
					location.reload();
				}
			});
		},
	});
});

$("#w_crew_name").change(function () {
	$.ajax({
		url: base_url + "add-toc-validation",
		type: "POST",
		data: $("#crew_withdrawal_application").serialize(),
		success: function (data) {
			validationInput(data.w_crew_name, "w_crew_name");
		},
	});
});
$("#w_rank").change(function () {
	$.ajax({
		url: base_url + "add-toc-validation",
		type: "POST",
		data: $("#crew_withdrawal_application").serialize(),
		success: function (data) {
			validationInput(data.w_rank, "w_rank");
		},
	});
});
$("#w_vessel").change(function () {
	$.ajax({
		url: base_url + "add-toc-validation",
		type: "POST",
		data: $("#crew_withdrawal_application").serialize(),
		success: function (data) {
            validationInput(data.w_vessel, "w_vessel");
		},
	});
});
$("#w_department").change(function () {
	$.ajax({
		url: base_url + "add-toc-validation",
		type: "POST",
		data: $("#crew_withdrawal_application").serialize(),
		success: function (data) {
			validationInput(data.w_department, "w_department");
		},
	});
});
$("#w_remarks").keyup(function () {
	$.ajax({
		url: base_url + "add-toc-validation",
		type: "POST",
		data: $("#crew_withdrawal_application").serialize(),
		success: function (data) {
            validationInput(data.w_remarks, "w_remarks");
		},
	});
});