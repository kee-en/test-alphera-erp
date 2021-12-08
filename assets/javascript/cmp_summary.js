$(function () {
    formVessel('r_filter_by_vessel');
    formAllPosition('r_filter_by_pos');
});

function GenerateCMPReport()
{


    var values = [];

    values.push({ 
        "type"      : $('#r_filter_by_type').val(),
        "position"  : $('#r_filter_by_pos').val(),
        "vessel"    : $('#r_filter_by_vessel').val(),
        "sign_from" : $('#r_signon_date_from').val(),
        "sign_to"   : $('#r_signon_date_to').val(),
        "contract_from"  : $('#r_contract_date_from').val(),
        "contract_to"    : $('#r_contract_date_to').val(),
    });
    var arrStr = encodeURIComponent(JSON.stringify(values));
    window.open(base_url + "print-cmp-report"+"/"+arrStr);
}
