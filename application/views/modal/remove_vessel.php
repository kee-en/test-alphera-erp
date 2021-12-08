    <!-- ADD FLIGHT DETAILS MODAL -->
    <div class="modal fade" id="remove_vessel_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0"><span id="vsl_rmv_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <form action="javascript:void(0)" id="remove_vessel_form" method="POST">
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <h4 class="text-default font-18 mt-0 mb-1">Remove Vessel</h4>
                        <hr class="mt-0" style="border: 1px solid #f5f6f8;">
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Remove As:</label>
                            <select class="custom-select" id="vsl_rmv_status" name="vsl_rmv_status">
                                <option value="">Choose option</option>
                                <option value="2">Laid Up</option>
                                <option value="3">Sold</option>
                                <option value="4">Change management</option>
                                <option value="5">Scrapped</option>
                                <option value="6">Collision/Sunk</option>
                            </select>
                        </div>
                        <input type="hidden" name="vsl_rmv_id" id="vsl_rmv_id">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>