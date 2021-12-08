<style>
    @media screen and (max-width: 786px) {
        #v_vhm {
            max-width: 95% !important;
        }
    }
</style>

<!-- VIEW HISTORY MODAL -->
<div class="modal fade" id="vessel_history_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" id="v_vhm" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">List of Sea Service Records (<span id="gvh_applicant_name"></span>)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <form action="javascript:void(0);" id="update_sea_service_form" name="update_sea_service_form" method="POST" enctype="application/x-www-form-urlencoded">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12" id="list_view_vessel">
                            <div class="table-responsive m-0">
                                <table class="table table-sm table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered">
                                    <thead class="thead-alphera text-center">
                                        <tr>
                                            <th>No.</th>
                                            <th>Vessel</th>
                                            <th>Flag</th>
                                            <th>Salary</th>
                                            <th>Rank</th>
                                            <th>Type of VSL / Engine</th>
                                            <th>GRT / Power</th>
                                            <th>Date of Embarked</th>
                                            <th>Date of Disembarked</th>
                                            <th>Total of Service</th>
                                            <th>Agency</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-center" id="vessel_history_table">

                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td class="font-weight-medium" colspan="9">Overall Service Record:</td>
                                            <td class="text-center font-weight-medium" id="history_total_service"></td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12" id="list_edit_vessel" style="display: none;">
                            <div id="sea_service_record_fieldss"></div>
                            <input type="hidden" id="vh_applicant_code" name="vh_applicant_code">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveChangesVessel" style="display: none;" disabled>Save Changes</button>
                    <button type="button" class="btn btn-primary" id="btnEditVessel">Edit Sea Service Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#btnEditVessel").click(function() {
        var app_code = $("#vh_applicant_code").val();
        $("#list_view_vessel").hide();
        $("#list_edit_vessel").show();
        $("#btnEditVessel").hide();
        $("#btnSaveChangesVessel").show();
        shipboardApplicationSeaService(app_code);
    });

    function shipboardApplicationSeaService(code) {
        $.ajax({
            url: base_url + "get-sea-service-record",
            type: "POST",
            data: {
                code: code,
            },
            dataType: "JSON",
            success: function(data) {

                if (data.array_of_sea_services !== undefined) {

                    formSeaServices(data.array_of_sea_services.length, "sea_service_record_fieldss");

                    setTimeout(() => {
                        let count = 1;
                        data.array_of_sea_services.forEach(arr_of_sea_service => {

                            var total_service = getDateDuration(
                                arr_of_sea_service.embarked,
                                arr_of_sea_service.disembarked
                            );

                            total_service = total_service !== undefined ? total_service : "";


                            $("#s_vessel_name_" + count).val(arr_of_sea_service.vessel);
                            $("#s_flag_" + count).val(arr_of_sea_service.flag);
                            $("#s_salary_" + count).val(arr_of_sea_service.salary);
                            $("#s_rank_" + count).val(arr_of_sea_service.rank);
                            $("#s_vsl_engn_" + count).val(arr_of_sea_service.type_vessel);
                            $("#s_grt_power" + count).val(arr_of_sea_service.grt_power);
                            $("#s_embarked" + count).val(arr_of_sea_service.embarked);
                            $("#s_disembarked" + count).val(arr_of_sea_service.disembarked);
                            $("#s_total_service" + count).val(total_service);
                            $("#s_agency" + count).val(arr_of_sea_service.agency);
                            $("#s_remarks" + count).val(arr_of_sea_service.remarks);
                            count++;

                            $("#btnSaveChangesVessel").prop('disabled', false);

                        });
                    }, 1000);



                } else {

                    setTimeout(() => {
                        formSeaService("sea_service_record_fieldss");
                        $("#btnSaveChangesVessel").prop('disabled', false);
                    }, 1000)
                }


                // let name_of_vessel = JSON.parse(data.name_of_vessel);
                // let flag = JSON.parse(data.flag);
                // let salary = JSON.parse(data.salary);
                // let rank = JSON.parse(data.rank);
                // let type_eng = JSON.parse(data.type_of_vsl_eng);
                // let grt_power = JSON.parse(data.grt_power);
                // let embarked = JSON.parse(data.embarked);
                // let disembarked = JSON.parse(data.disembarked);
                // let total_service = JSON.parse(data.total_service);
                // let agency = JSON.parse(data.agency);
                // let remarks = JSON.parse(data.remarks);

                // if (name_of_vessel != null) {
                //     for (let index = 0; index < name_of_vessel.length; index++) {
                //         formSeaService("sea_service_record_fields");
                //     }

                //     setTimeout(() => {
                //         for (let index = 0; index < name_of_vessel.length; index++) {
                //             count = index;
                //             $("#s_vessel_name_" + (count + 1)).val(name_of_vessel[index]);
                //             $("#s_flag_" + (count + 1)).val(flag[index]);
                //             $("#s_salary_" + (count + 1)).val(salary[index]);
                //             $("#s_rank_" + (count + 1)).val(rank[index]);
                //             $("#s_vsl_engn_" + (count + 1)).val(type_eng[index]);
                //             $("#s_grt_power" + (count + 1)).val(grt_power[index]);
                //             $("#s_embarked" + (count + 1)).val(embarked[index]);
                //             $("#s_disembarked" + (count + 1)).val(disembarked[index]);
                //             $("#s_total_service" + (count + 1)).val(total_service[index]);
                //             $("#s_agency" + (count + 1)).val(agency[index]);
                //             $("#s_remarks" + (count + 1)).val(remarks[index]);
                //         }
                //     }, 1000);

                // } else {
                //     formSeaService("sea_service_record_fields");
                // }
            },
        });
    }

    $("#update_sea_service_form").submit(function() {
        $.ajax({
            url: base_url + "update-sea-service",
            type: "POST",
            data: $("#update_sea_service_form").serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $("#btnSaveChangesVessel").html(
                    '<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
                );
                $("#btnSaveChangesVessel").prop("disabled", true);
            },
            success: function(data) {

                Swal.fire({
                    icon: data.type,
                    title: data.title,
                    text: data.text,
                    confirmButtonText: "Close",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then(function() {
                    if (data.type === "success") {
                        location.reload(true);
                    }
                });

                $("#btnSaveChangesVessel").html(
                    'Save Changes'
                );
                $("#btnSaveChangesVessel").prop("disabled", false);
            },
        });
    });

    // function totalservice(number) {
    //     var embark = $('#s_embarked' + number).val();
    //     var disembark = $('#s_disembarked' + number).val();

    //     if (embark && disembark) {
    //         $("#s_total_service" + number).val(
    //             getDateDuration(embark, disembark)
    //         );
    //     }
    // }

    function addSeaService() {
        formSeaService("sea_service_record_fieldss");
    }
</script>