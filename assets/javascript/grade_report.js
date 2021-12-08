$(function () {
	formAllPosition('grade_rank');
});

$("#crew_grade_form").submit(function () {
	$.ajax({
		url: base_url + "get-crew-grade-report",
		type: "POST",
		data: $("#crew_grade_form").serialize(),
		dataType: "JSON",
		success: function (data) {
			if (data) {
				var grade_main = data.main_count;
				var grade_compara = data.compara_count;

				$('#grade_count').html("");
				$('#compara_count').html("");

                if (grade_main) {
					for (let ii = 0; ii < grade_main.length; ii++) {
						var grade_name = grade_main[ii].grade != null ?  grade_main[ii].grade : "No Grade";

						$('<h4 class="font-18 m-0">'+ grade_name +' : <span class="text-muted">'+grade_main[ii].grade_count+'</span></h4>').appendTo('#grade_count');
					}
				}
				if (grade_compara) {
					for (let i = 0; i < grade_compara.length; i++) {
						var compara_grade_name = grade_compara[i].grade != null ?  grade_compara[i].grade : "No Grade";

						$('<h4 class="font-18 m-0">'+ compara_grade_name +' : <span class="text-muted">'+grade_compara[i].grade_count_compara+'</span></h4>').appendTo('#compara_count');
					}
				}
				
			}
		},
	});
});