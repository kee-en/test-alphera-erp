$(function () {
	formTypeVessel('gen_filter_vsl_type');
});

$("#gen_filter_type").change(function () {
	if (this.value == 1) {
        $('#vessel_type').show();
    }else if(this.value == 11){
        $('#gen_type_reason').show();
        $('#vessel_type').hide();
    }else if(this.value == 12){
        $('#gen_type_reason').show();
        $('#vessel_type').hide();
    }else{
        $('#vessel_type').hide();
        $('#gen_type_reason').hide();
    }
});

$("#BtnReset").click(function () {
    $('#year_div').hide();
    $('#month_div').hide();
    $('#vessel_type').hide();
	$('#gen_type_reason').hide();
});

$("#gen_filter_duration").change(function () {
	if (this.value == 1) {
        $('#year_div').hide();
        $('#month_div').show();
    } else if(this.value == 2){
        $('#year_div').show();
        $('#month_div').hide();
    }else{
        $('#year_div').hide();
        $('#month_div').hide();
    }
});

$("#manage_reports_form").submit(function () {
	$.ajax({
		url: base_url + "get-gen-crew-report",
		type: "POST",
		data: $("#manage_reports_form").serialize(),
		dataType: "JSON",
		success: function (data) {
            var result = data.count;
            var comparative = data.comparative_count;
            
            if (data) {
                var options = {
                    chart: {
                        height: 320,
                        type: "pie",
                        redrawOnParentResize: true
                    },
                    series: [result.crew_number, comparative.crew_number],
                    labels: ["Current Data", "Comparative Data"],
                    colors: ["#56c2d6", "#f0643b"],
                    legend: {
                        show: !0,
                        position: "bottom",
                        horizontalAlign: "center",
                        verticalAlign: "middle",
                        floating: !1,
                        fontSize: "14px",
                        offsetX: 0,
                        offsetY: -10
                    },
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            chart: {
                                height: 240
                            },
                            legend: {
                                show: !1
                            }
                        }
                    }]
                };
                var chart = new ApexCharts(document.querySelector("#repatriation-graph-1"), options);
                chart.render();
            }
		},
	});
});