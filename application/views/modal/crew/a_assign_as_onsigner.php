<div class="modal fade" id="a_assign_as_onsigner" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">Assign as On Signer <span id="assign-crew-name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <form action="javascript:void(0)" id="assign_as_on_signer" method="POST">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <h4 class="text-default font-18 mt-0 mb-1">Assign as OnSigner</h4>
                            <p class="text-alphera font-15" style="text-align: justify;">
                                Note: Date of Embarkation is based on Offsigner Disembarkation Date.
                            </p>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-muted">Off Signer <span class="text-danger">*</span></label>
                                <select class="custom-select" id="a_offsigner" name="a_offsigner" style="width: 100%;" onchange="validateAssignOnsigner(this);">
                                    <option value="">Select Off Signer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Date of Embarkation <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="a_embarked_date" name="a_embarked_date" onchange="validateAssignOnsigner(this);">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Date of Disembarked <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="a_disembarked_date" name="a_disembarked_date" onchange="validateAssignOnsigner(this);">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="onsigner_mnt_code" id="onsigner_mnt_code">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnAssigOnsigner">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>