$("#s_source_location").on("change", function () {
	$("#recommend").css("display", "none");
	if ($(this).val() === "1") {
		$("#recommend").css("display", "block");
	}
});

$("#s_current_crew_status").on("change", function () {
	$("#current_onsigner").css("display", "none");
	if ($(this).val() === "3") {
		$("#embark_date").css("display", "block");
		$("#disembark_date").css("display", "block");
	} else if ($(this).val() === "4") {
		$("#embark_date").css("display", "block");
		$("#disembark_date").css("display", "block");
	} else if ($(this).val() === "5") {
		$("#embark_date").css("display", "block");
		$("#disembark_date").css("display", "block");
	} else {
		$("#embark_date").hide();
		$("#disembark_date").hide();
	}
});

$("#s_no_of_children").on("change", function () {
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

