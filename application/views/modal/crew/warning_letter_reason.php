    <!-- ADD FLIGHT DETAILS MODAL -->
<div class="modal fade" id="warning_letter_reason_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0"><span id="wlrm_crew_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <h4 class="text-default font-18 mt-0 mb-1">Reason for Warning Letter</h4>
                        <p class="text-muted font-15" style="text-align: justify;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>

                        <hr class="mt-0" style="border: 1px solid #f5f6f8;">
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Remarks</label>
                            <select class="custom-select" id="wlrm_remarks" name="wlrm_remarks" disabled>
                                <option value="">Choose option</option>
                                <option value="1">Not For Rehire (NRE)</option>
                                <option value="2">Early Disembarkation</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Reasons</label>
                                <select class="custom-select" id="w_type_of_nre" name="w_type_of_nre">
                                    <option value="">Choose option</option>
                                </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Additional Remarks</label>
                            <textarea class="form-control" id="wlrm_additional_remarks" name="wlrm_additional_remarks" rows="3" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
            </div>
        </div>
    </div>
</div>