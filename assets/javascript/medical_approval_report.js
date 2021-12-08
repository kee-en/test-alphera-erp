$("#medical_approval_report_form").submit(function() {
    $.ajax({
        url: base_url + "set-medical-approval-report",
        type: "POST",
        data: $("#medical_approval_report_form").serialize(),
        success: function(data) {
            window.location.replace(base_url + 'medical-approval-report');
        },
    });
});

$("#mar_medical_status").change(function() {
    if (this.value == 1) {
        $('#select_crew_div').show();
    } else {
        $('#select_crew_div').hide();
    }
});

function resetForm() {
    $.ajax({
        url: base_url + "reset-medical-approval-report",
        type: "POST",
        success: function(data) {
            location.reload(true);
        },
    });
}