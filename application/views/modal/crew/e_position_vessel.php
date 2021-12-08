<!-- ADD FLIGHT DETAILS MODAL -->
<div class="modal fade" id="edit_position_vessel_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">Update Rank and Vessel - <span id="epvm_crew_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="javascript:void(0)" id="edit_position_vessel" method="POST">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <h4 class="text-default font-18 mt-0 mb-1">Update Rank and Vessel</h4>
                            <p class="text-muted font-15" style="text-align: justify;">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-muted">Rank / Position <span class="text-danger">*</span></label>
                                <select class="custom-select" id="epvm_position" name="epvm_position">
                                    <option value="">Select Rank / Position</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-muted">Vessel <span class="text-danger">*</span></label>
                                <select class="custom-select" id="epvm_tentative_vessel" name="epvm_tentative_vessel" readonly>
                                    <option value="">Select Vessel</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" id="hid_code_pos_update" name="hid_code_pos_update">
                        <input type="hidden" id="hidden_insigner" name="hidden_insigner">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="BtnUpdatePositionVessel">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        formVessel("epvm_tentative_vessel");
        formAllPosition("epvm_position");
    });

    $("#edit_position_vessel").submit(function(data) {

        var insigner = $("#edit_position_vessel_modal").find("#hidden_insigner").val();
        var message = insigner ? "Are you sure you want to update rank/vessel having crew insigner assign?" : "Are you sure you want to update rank/vessel?";

        Swal.fire({
            title: message,
            icon: "warning",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: base_url + "update-crew-pos-vessel",
                    type: "POST",
                    data: $("#edit_position_vessel").serialize(),
                    success: function(data) {

                        validationInput(data.epvm_position, "epvm_position");
                        validationInput(data.epvm_tentative_vessel, "epvm_tentative_vessel");

                        if (data.type === "success") {
                            Swal.fire({
                                icon: data.type,
                                title: data.title,
                                text: data.text,
                                confirmButtonText: "Close",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then(function() {
                                location.reload(true);
                            });
                        } else {
                            Swal.fire({
                                icon: data.type,
                                title: data.title,
                                text: data.text,
                                confirmButtonText: "Close",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
                        }
                    },
                });
            }
        });
    });
</script>