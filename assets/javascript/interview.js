$("#recruitment_filter_form").submit(function () {
	$.ajax({
		url: base_url + "search-interview",
		type: "POST",
		data: $("#recruitment_filter_form").serialize(),
		success: function (data) {
			location.reload(true);
		},
	});
});
$("#BtnResetSearch").click(function () {
	$.ajax({
		url: base_url + "unset-search-interview",
		type: "POST",
		success: function (data) {
			location.reload(true);
		},
	});
});
$(".dropdown").on("click", function () {
	var ddown_key = $(this).attr("data-dropdown-key");

	var applicant_code = ddown_key;
	$.ajax({
		url: base_url + "check-technical-form",
		type: "GET",
		data: {
			applicant_code: applicant_code,
		},
		success: function (data) {
			if (data.check_tech_form != 1{
				$("#technical-form-menu").addClass("disabled-link");
			} else {
				$("#technical-form-menu").removeClass("disabled-link");
			}

			$(".disabled-link").click(function (event) {
				// event.preventDefault();
				event.stopPropagation();
			});
		},
	});
});

// $("#search_interview_form").submit(function () {});
function proceedFinalAssessor(code) {
	alert(code);
}

function printEva(applicant_code) {
	window.open(
		base_url + "print-evaluation-applicant-xl" + "/" + applicant_code
	);
}
function printGeneral(applicant_code) {
	window.open(
		base_url + "print-general-applicant" + "/" + applicant_code + "/" + "xl"
	);
}
function printInterviewSheet(applicant_code) {
	window.open(base_url + "print-interview-sheet-pdf" + "/" + applicant_code);
}

$("#e_no_of_children").on("change", function () {
	if (this.value == "1") {
		$("#rs1").show();
		$("#rs2").hide();
		$("#rs3").hide();
		$("#rs4").hide();
		$("#rs5").hide();
		$("#rs6").hide();
		$("#rs7").hide();
		$("#rs8").hide();
		$("#rs9").hide();
		$("#rs10").hide();
	} else if (this.value == "2") {
		$("#rs1").show();
		$("#rs2").show();
		$("#rs3").hide();
		$("#rs4").hide();
		$("#rs5").hide();
		$("#rs6").hide();
		$("#rs7").hide();
		$("#rs8").hide();
		$("#rs9").hide();
		$("#rs10").hide();
	} else if (this.value == "3") {
		$("#rs1").show();
		$("#rs2").show();
		$("#rs3").show();
		$("#rs4").hide();
		$("#rs5").hide();
		$("#rs6").hide();
		$("#rs7").hide();
		$("#rs8").hide();
		$("#rs9").hide();
		$("#rs10").hide();
	} else if (this.value == "4") {
		$("#rs1").show();
		$("#rs2").show();
		$("#rs3").show();
		$("#rs4").show();
		$("#rs5").hide();
		$("#rs6").hide();
		$("#rs7").hide();
		$("#rs8").hide();
		$("#rs9").hide();
		$("#rs10").hide();
	} else if (this.value == "5") {
		$("#rs1").show();
		$("#rs2").show();
		$("#rs3").show();
		$("#rs4").show();
		$("#rs5").show();
		$("#rs6").hide();
		$("#rs7").hide();
		$("#rs8").hide();
		$("#rs9").hide();
		$("#rs10").hide();
	} else if (this.value == "6") {
		$("#rs1").show();
		$("#rs2").show();
		$("#rs3").show();
		$("#rs4").show();
		$("#rs5").show();
		$("#rs6").show();
		$("#rs7").hide();
		$("#rs8").hide();
		$("#rs9").hide();
		$("#rs10").hide();
	} else if (this.value == "7") {
		$("#rs1").show();
		$("#rs2").show();
		$("#rs3").show();
		$("#rs4").show();
		$("#rs5").show();
		$("#rs6").show();
		$("#rs7").show();
		$("#rs8").hide();
		$("#rs9").hide();
		$("#rs10").hide();
	} else if (this.value == "8") {
		$("#rs1").show();
		$("#rs2").show();
		$("#rs3").show();
		$("#rs4").show();
		$("#rs5").show();
		$("#rs6").show();
		$("#rs7").show();
		$("#rs8").show();
		$("#rs9").hide();
		$("#rs10").hide();
	} else if (this.value == "9") {
		$("#rs1").show();
		$("#rs2").show();
		$("#rs3").show();
		$("#rs4").show();
		$("#rs5").show();
		$("#rs6").show();
		$("#rs7").show();
		$("#rs8").show();
		$("#rs9").show();
		$("#rs10").hide();
	} else if (this.value == "10") {
		$("#rs1").show();
		$("#rs2").show();
		$("#rs3").show();
		$("#rs4").show();
		$("#rs5").show();
		$("#rs6").show();
		$("#rs7").show();
		$("#rs8").show();
		$("#rs9").show();
		$("#rs10").show();
	} else {
		$("#rs1").hide();
		$("#rs2").hide();
		$("#rs3").hide();
		$("#rs4").hide();
		$("#rs5").hide();
		$("#rs6").hide();
		$("#rs7").hide();
		$("#rs8").hide();
		$("#rs9").hide();
		$("#rs10").hide();
	}
});

// $("#eva").click(function() {
// 	if (this.value == 1) {
// 		var app_code = $('#appCode').val();

// 	}

// 	// if (this.value == 1) {
// 	// var code = $("#appCode").val();
// 	// $.ajax({
// 	// 	url: base_url + "print-evaluation-applicant_pdf",
// 	// 	type: "post",
// 	// 	data: {
// 	// 		code: code
// 	// 	},
// 	// 	success: function(data) {
// 	// 		if (data != null) {
// 	// 			window.open(base_url + "print-evaluation-applicant_pdf");
// 	// 		}
// 	// 	}
// 	// });
// 	// }
// });
