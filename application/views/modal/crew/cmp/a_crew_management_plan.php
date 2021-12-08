<!-- ADD CONTRACT MODAL -->
<div class="modal fade" id="a_crew_management_plan" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">Crew Management Plan - <span id="cmp_crew_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="edit_cmp_form" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <p class="text-alphera font-20 m-0" id="modal-body-title">Edit Crew Management Plan</p>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Full Name <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_full_name" name="c_full_name" readonly>
                                <input type="hidden" class="form-control" id="cmp_code" name="cmp_code">
                                <input type="hidden" class="form-control" id="crew_code" name="crew_code">
                                <input type="hidden" class="form-control" id="status" name="status">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Rank <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_rank" name="c_rank" readonly>
                            </div>
                        </div>
                        <div class="col-md-6" id="vessel_div">
                            <div class="form-group">
                                <label class="col-form-label">Vessel <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_vessel" name="c_vessel" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Availability</label>
                                <input type="date" class="form-control" id="c_available" name="c_available" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Disembarked <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="c_disembark" name="c_disembark">
                            </div>
                        </div>
                        <div class="col-md-6" id="line_up_div" style="display: none;">
                            <div class="form-group">
                                <label class="col-form-label">Line-Up <span class="asterisk">*</span></label>
                                <select class="custom-select" id="c_line_up" name="c_line_up">
                                    <option value="">Choose option</option>
                                    <option value="test">Test</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Sign On <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="c_sign_on" name="c_sign_on">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">End Contract <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="c_end_contract" name="c_end_contract">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Months Onboard <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_onboard" name="c_onboard" placeholder="Months Onboard">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">X Date</label>
                                <input type="date" class="form-control" id="c_x_date" name="c_x_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">X Port</label>
                                <input type="text" class="form-control" id="c_x_port" name="c_x_port" placeholder="X Port">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Remarks</label>
                                <textarea class="form-control" id="c_remarks" name="c_remarks" rows="2" placeholder="Ex. To be confirmed, Ready, For Approval, Transfer from Arborella, etc."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span id="view-note"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="BtnUpdateCMP">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url('assets/javascript/a_crew_management_plan.js') ?>"></script>