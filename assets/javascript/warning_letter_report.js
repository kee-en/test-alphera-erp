$(function() {
    formWarningStatuses('acwl_reason');
});

$("#warning_letter_report_form").submit(function() {
    $.ajax({
        url: base_url + "get-warning-letter-report",
        type: "POST",
        data: $("#warning_letter_report_form").serialize(),
        dataType: "JSON",
        success: function(data) {
            if (data) {
                var date = new Date();
                for (let index = 0; index <= 5; index++) {
                    $('#per_rank_display_' + index).html("");
                    var result = data.show_result + index;
                    date.setFullYear(2021);
                    date.setFullYear(date.getFullYear() - index);
                    console.log(index);
                    if (result) {
                        $('<h4 class="font-18 m-0" id="filtered_result">' + ((result == null) ? "No Data" : result[index].rank) + ' : <span class="text-muted">' + ((result == null) ? "0" : result[index].wl_count) + '</span></h4>').appendTo('#per_rank_display');
                    } else {
                        $('<h4 class="font-18 m-0" id="filtered_result">Warning Letter Data ' + date.getFullYear() + ': <span class="text-muted">0</span></h4>').appendTo('#per_rank_display');
                    }
                }
            }
        },
    });
});