    <!-- ADD FLIGHT DETAILS MODAL -->
    <div class="modal fade" id="remove_crew_toc_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0"><span id="wlrm_crew_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <form action="javascript:void(0)" id="un_toc_form" method="POST">
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <h4 class="text-default font-18 mt-0 mb-1">Remove Crew from TOC</h4>
                        <p class="text-muted font-15" style="text-align: justify;">
                            Please be reminded that principal approval is needed for this action to reflect into CM Plan.
                        </p>

                        <hr class="mt-0" style="border: 1px solid #f5f6f8;">
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Return As</label>
                            <select class="custom-select" id="toc_status" name="toc_status">
                                <option value="">Choose option</option>
                                <option value="1">New Crew</option>
                                <option value="7">Ex-Crew</option>
                            </select>
                        </div>
                        <input type="hidden" name="crew_code" id="crew_code">
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