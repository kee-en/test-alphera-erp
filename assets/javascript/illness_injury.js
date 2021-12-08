
$("#illness_injury_form").submit(function () {
	$.ajax({
		url: base_url + "get-illness-injury-rate",
		type: "POST",
		data: $("#illness_injury_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			if (data) {
				var results = data.filtered_result
				$('#total_rate').html(data.total_rate + "%");
				$('#per_rank_display').html("");
				for (let index = 0; index < results.length; index++) {
					$('<h4 class="font-18 m-0" id="filtered_result">'+ results[index].rank +' : <span class="text-muted">'+results[index].numbers+'</span></h4>').appendTo('#per_rank_display');
				}
			}
		},
	});
});