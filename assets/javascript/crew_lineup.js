$(function () {
	formVessel("c_line_up_vsl");
});


$("#BtnGenerate").click(function () {
    var vsl1 = $('#c_line_up_vsl').val();
    var date1 = $('#c_line_up_embark').val();
    var jp = $('#c_line_up_joiningp').val();
    $('#crew_lineup_table').hide();
    $('#BtnPostApproval').attr('disabled','disabled');
    generateCrewLineup(vsl1, date1, jp);
});

function generateCrewLineup(vsl, date, jp) {
    $('#crew_lineup_table').show();
    $('#crew_lineup_table').DataTable().clear().destroy();
    $('#BtnPostApproval').removeAttr('disabled');

    $("#crew_lineup_table").DataTable({
        // processing: true,
        ajax: {
            url: base_url + "generate-crew-lineup",
            data(d){
                d.vsl = vsl;
                d.date = date;
                d.jp = jp;
            },
            type: "POST",
        },
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }

        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });
}

$("#BtnPostApproval").click(function () {
    var vessel = $('#c_line_up_vsl').val();
    var emb_date = $('#c_line_up_embark').val();
    var jp = $('#c_line_up_joiningp').val();

    $.ajax({
		url: base_url + "crew-lineup-for-approval",
		type: "POST",
		data: {vsl: vessel, date: emb_date, jp: jp},
		success: function (data) {
			if (data.type === "success") {
                Swal.fire({
                    icon: data.type,
                    title: data.title,
                    confirmButtonText: "Close",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then(function () {
                    location.reload(true);
                });
            } else {
                Swal.fire({
                    icon: data.type,
                    title: data.title,
                    confirmButtonText: "Close",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
            }
		},
	});
});