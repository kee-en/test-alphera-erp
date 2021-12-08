<!-- VIEW PENDING MEDICAL MODAL -->
<div class="modal fade" id="view_crew_promotion_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0" id="vcpm_crew_name"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <p class="text-alphera font-20 mb-0">Crew Details for Promotion</p>
                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted m-0">Graduated School:</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="vcpm_school">-</p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted m-0">Entry Date:</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="vcpm_entry_date">-</p>
                    </div>

                    <div class="col-md-12">
                        <label class="text-muted m-0">Evaluation:</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="vcpm_grade">-</p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted m-0">New Rank:</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="vcpm_new_rank">-</p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted m-0">New Vessel:</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="vcpm_new_vessel">-</p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted m-0">Old Rank:</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="vcpm_prev_rank">-</p>
                    </div>


                    <div class="col-md-6">
                        <label class="text-muted m-0">Old Vessel:</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="vcpm_prev_vessel">-</p>
                    </div>

                    <div class="col-md-12">
                        <label class="text-muted m-0">New Date of Contract:</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="vcpm_contract">-</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" onclick="reload();">Cancel</button>
            </div>
        </div>
    </div>
</div>