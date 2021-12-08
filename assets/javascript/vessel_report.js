$(function () {
	formTypeVessel('filter_vsl_type');
});

$("#vsl_filter_type").change(function () {
	if (this.value == 3) {
        $('#reduction_option').show();
    }else{
        $('#reduction_option').hide();
    }
});

$("#vessels_reports_form").submit(function () {
	$.ajax({
		url: base_url + "get-vessels-report",
		type: "POST",
		data: $("#vessels_reports_form").serialize(),
		dataType: "JSON",
		success: function (data) {
            if (data) {
                $('#vessel_count').text(data.vessel_count);
                $('#compara_vessel_count').text(data.comparative_count);
            }
		},
	});
});
