$(function () {
    formVessel('cf_vessel_name');
    formAllPosition('cf_rank_position');
});

$("#cf_application_status").change(function () {
    if (this.value === "3") {
        $('#date_from').html('Date of Embarked From');
        $('#date_to').html('Date of Embarked To');
        $('#d_date_from').show();
        $('#d_date_to').show();
    } else if (this.value === "4") {
        $('#date_from').html('Date of Disembarked From');
        $('#date_to').html('Date of Disembarked To');
        $('#d_date_from').show();
        $('#d_date_to').show();
    } else if (this.value === "7") {
        $('#date_from').html('Date of Availability From');
        $('#date_to').html('Date of Availability To');
        $('#d_date_from').show();
        $('#d_date_to').show();
    }
});
