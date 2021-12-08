<!-- ADD FLIGHT DETAILS MODAL -->
<div class="modal fade" id="e_position_promotion" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">Update Rank and Vessel - <span id="epp_crew_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <form action="javascript:void(0)" id="edit_position_promotion" method="POST">
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
                                <select class="custom-select" id="epp_position" name="epp_position">
                                    <option value="">Select Rank / Position</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-muted">Vessel <span class="text-danger">*</span></label>
                                <select class="custom-select" id="epp_tentative_vessel" name="epp_tentative_vessel" readonly>
                                    <option value="">Select Vessel</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="hidden_crew_code" id="hidden_crew_code">
                    <input type="hidden" name="hidden_crew_old_pos" id="hidden_crew_old_pos">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="BtnPromotion">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>