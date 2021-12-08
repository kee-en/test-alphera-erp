$(function () {
    formVessel('r_filter_by_vessel');
    formAllPosition('r_filter_by_pos');
});

function GenerateDailyDepartReport()
{
    var values = [];

    values.push({ 
        "type"      : $('#r_filter_by_type').val(),
        "position"  : $('#r_filter_by_pos').val(),
        "vessel"    : $('#r_filter_by_vessel').val(),
        "depart_from" : $('#r_date_from').val(),
        "depart_to"   : $('#r_date_to').val(),
    });
    var arrStr = encodeURIComponent(JSON.stringify(values));
    window.open(base_url + "print-daily-departure-report"+"/"+arrStr);
}