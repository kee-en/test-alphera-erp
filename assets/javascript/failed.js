$("#recruitment_filter_form").submit(function() {
	$.ajax({
		url: base_url + "search-failed",
		type: "POST",
		data: $("#recruitment_filter_form").serialize(),
		success: function(data) {
			location.reload(true);
		}
	});
});
$("#BtnResetSearchFailed").click(function() {
	$.ajax({
		url: base_url + "unset-search-failed",
		type: "POST",
		success: function(data) {
			location.reload(true);
		}
	});
});

function viewFailedReason(code)
{
	$.ajax({
		url: base_url + "get-failed-reason",
		type: "POST",
		data: {
			applicant_code: code,
		},
		dataType: "JSON",
		success: function (data) {
			$('#BtnSubmitNotQual').hide();
			$('#r_add_remark').val(data.remark);
			$('#r_add_remark').prop('disabled', true);
			$('#modal_header').html("Reason For Rejection");
		},
	});
	$('#not_qualified_modal').modal('show');
}