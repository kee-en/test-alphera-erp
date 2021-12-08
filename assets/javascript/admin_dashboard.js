$(function () {
	get_total_onboard_crew();
    get_peme_donut();
    getExpiredDocs();
    getExpiredLicenses();
    recruitment_performance_report();
});


function get_total_onboard_crew()
{
    $.ajax({
		url: base_url + "get-dashboard-donut",
		type: "GET",
		data: {},
		dataType: "JSON",
		success: function (data) {
			if (data) {
                var green = Math.trunc(data.contract_green);
                    var options = {
                        series: [green, data.contract_yellow, data.contract_red,data.contract_expired],
                        chart: {
                        width: 380,
                        type: 'donut',
                        dropShadow: {
                        enabled: true,
                        color: '#111',
                        top: -1,
                        left: 3,
                        blur: 3,
                        opacity: 0.2
                        }
                    },
                    stroke: {
                        width: 0,
                    },
                    plotOptions: {
                        pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    showAlways: true,
                                    show: true
                                }
                            }
                        }
                        }
                    },
                    labels: ["90 Days", "60 Days", "30 Days", "Expired"],
                    colors:['#1B834A', '#e5e535', '#f86c2c', '#F44336'],
                    dataLabels: {
                        enabled: true,
                        style: {
                            colors: ['#333']
                        },
                    },
                    fill: {
                    type: 'gradient',
                        opacity: 1,
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'lighten',
                                value: 0.15,
                            }
                        }
                    },
                    theme: {
                        palette: 'palette2'
                    },
                    title: {
                        text: "Total No. Of Contract Durations"
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                        }
                    }]
                    };
            
                    var chart = new ApexCharts(document.querySelector("#total_crew_onboard"), options);
                    chart.render();
        }
		},
	});
}

function get_peme_donut()
{
    $.ajax({
		url: base_url + "get-dashboard-donut-peme",
		type: "GET",
		data: {},
		dataType: "JSON",
		success: function (data) {
			if (data) {
                
        var options = {
            series: [data.medical_green, data.medical_yellow, data.medical_red, data.medical_expired],
            chart: {
            width: 380,
            type: 'donut',
            },
            plotOptions: {
                pie: {
                startAngle: -90,
                endAngle: 270
                }
            },
            dataLabels: {
                enabled: true
            },
            fill: {
                type: 'gradient',
            },
            labels: ["90 Days", "60 Days", "30 Days", "Expired"],
            colors:['#1B834A', '#e5e535', '#f86c2c', '#F44336'],
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#333']
                },
            },
            title: {
                text: 'Total Crew PEME Donut'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
                }
            }]
        };
            var chart = new ApexCharts(document.querySelector("#crew_peme"), options);
            chart.render();
            }
		},
	});
}

function getExpiredDocs() {
    $.ajax({
		url: base_url + "get-expired-docs",
		type: "GET",
		data: {},
		dataType: "JSON",
		success: function (data) {
            if (data) {
                $('#expired').html(data.expired);
                $('#valid').html(data.valid);
                $('#days60').html(data.sxtydays);
                $('#days30').html(data.thrtydays);
            }
		},
	});
}

function getExpiredLicenses() {
    $.ajax({
		url: base_url + "get-expired-certs",
		type: "GET",
		data: {},
		dataType: "JSON",
		success: function (data) {
            if (data) {
                $('#lics_expired').html(data.expired);
                $('#lics_valid').html(data.valid);
                $('#lics_days60').html(data.sxtydays);
                $('#lics_days30').html(data.thrtydays);
            }
		},
	});
}


function recruitment_performance_report()
{
    $.ajax({
		url: base_url + "get-recruitment-performance",
		type: "GET",
		data: {},
		dataType: "JSON",
		success: function (data) {
            if (data) {
                var total_new_hire = data.total_new_hire;
                var accepted_count = data.accepted_count;
                var per_rank_count = data.per_rank_count;

                if (total_new_hire) {
                    var total = total_new_hire[0]['rank_count'] + total_new_hire[1]['rank_count'] + total_new_hire[2]['rank_count'];
                    var value1 = total_new_hire[0]['rank_count'] / total * 100;
                    var value2 = total_new_hire[1]['rank_count'] / total * 100;
                    var value3 = total_new_hire[2]['rank_count'] / total * 100;

                        var options = {
                            chart: {
                                height: 320,
                                type: "pie",
                                redrawOnParentResize: true
                            },
                            series: [value1, value2, value3],
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
                            labels: [total_new_hire[0]['description'], total_new_hire[1]['description'], total_new_hire[2]['description']],
                            colors: ["#56c2d6", "#f0643b", "#ebeff2"],
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
                            }],
                            fill: {
                                type: "gradient"
                            }
                        };
                        var chart = new ApexCharts(document.querySelector("#apex-donut-1"), options);
                        chart.render();
                }

                if (per_rank_count) {
                    var total = 0;
                    var series = [];
                    var labels = [];
                    var color_arr = [];
                    for (let index = 0; index < per_rank_count.length; index++) {
                        total += parseInt(per_rank_count[index].rank_count);
                        labels.push(per_rank_count[index].position_name);
                        var color = '#'+(Math.random() * 0xFFFFFF << 0).toString(16).padStart(6, '0');
                        color_arr.push(color);
                    }
                    
                    var val1 = parseInt(per_rank_count[0]['rank_count']) / total * 100;
                    var val2 = parseInt(per_rank_count[1]['rank_count']) / total * 100;
                    var val3 = parseInt(per_rank_count[2]['rank_count']) / total * 100;
                    var val4 = parseInt(per_rank_count[3]['rank_count']) / total * 100;
                    var val5 = parseInt(per_rank_count[4]['rank_count']) / total * 100;
                    var val6 = parseInt(per_rank_count[5]['rank_count']) / total * 100;
                    var val7 = parseInt(per_rank_count[6]['rank_count']) / total * 100;
                    var val8 = parseInt(per_rank_count[7]['rank_count']) / total * 100;
                    var val9 = parseInt(per_rank_count[8]['rank_count']) / total * 100;
                    var val10 = parseInt(per_rank_count[9]['rank_count']) / total * 100;
                    var val11 = parseInt(per_rank_count[10]['rank_count']) / total * 100;
                    var val12 = parseInt(per_rank_count[11]['rank_count']) / total * 100;
                    var val13 = parseInt(per_rank_count[12]['rank_count']) / total * 100;
                    var val14 = parseInt(per_rank_count[13]['rank_count']) / total * 100;
                    var val15 = parseInt(per_rank_count[14]['rank_count']) / total * 100;
                    var val16 = parseInt(per_rank_count[15]['rank_count']) / total * 100;
                    var val17 = parseInt(per_rank_count[16]['rank_count']) / total * 100;
                    var val18 = parseInt(per_rank_count[17]['rank_count']) / total * 100;

                        var options = {
                            chart: {
                                height: 320,
                                type: "pie",
                                redrawOnParentResize: true
                            },
                            series: [val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,val12,val13,val14,val15,val16,val17,val18],
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
                            labels: [labels[0],labels[1],labels[2],labels[3],labels[4],labels[5],labels[6],labels[7],labels[8],labels[9],
                            labels[10],labels[11],labels[12],labels[13],labels[14],labels[15],labels[16],labels[17]],
                            colors: [color_arr[0],color_arr[1],color_arr[2],color_arr[3],color_arr[4],color_arr[5],color_arr[6],color_arr[7],color_arr[8],color_arr[9],
                            color_arr[10],color_arr[11],color_arr[12],color_arr[13],color_arr[14],color_arr[15],color_arr[16],color_arr[17]],
                            responsive: [{
                                breakpoint: 600,
                                options: {
                                    chart: {
                                        height: 300
                                    },
                                    legend: {
                                        show: !1
                                    }
                                }
                            }],
                            fill: {
                                type: "gradient"
                            }
                        };
                        var chart = new ApexCharts(document.querySelector("#apex-donut-2"), options);
                        chart.render();
                }

                if (accepted_count) {
                    var total = 0;
                    var series = [];
                    var labels = [];

                    for (let index = 0; index < accepted_count.length; index++) {
                        total += parseInt(accepted_count[index].rank_count);
                        

                        labels.push(accepted_count[index].description);
                    }

                    var val1 = parseInt(accepted_count[0]['rank_count']) / total * 100;
                    var val2 = parseInt(accepted_count[1]['rank_count']) / total * 100;
                    var val3 = parseInt(accepted_count[2]['rank_count']) / total * 100;
                    
                        var options = {
                            chart: {
                                height: 320,
                                type: "pie",
                                redrawOnParentResize: true
                            },
                            series: [val1, val2, val3],
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
                            labels: [labels[0], labels[1], labels[2]],
                            colors: ["#56c2d6", "#f0643b", "#ebeff2"],
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
                            }],
                            fill: {
                                type: "gradient"
                            }
                        };
                        var chart = new ApexCharts(document.querySelector("#apex-donut-3"), options);
                        chart.render();
                }
            }
		},
	});
}
