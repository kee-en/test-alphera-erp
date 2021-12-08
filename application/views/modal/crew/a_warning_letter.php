<!-- ADD FLIGHT DETAILS MODAL -->
<div class="modal fade" id="add_warning_letter_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0"><span id="awlm_crew_name">Marvic B Tifora</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <form action="javascript:void(0)" id="add_warning_letter_form" method="POST">   
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <h4 class="text-default font-18 mt-0 mb-1">Add Warning Letter</h4>
                            <p class="text-muted font-15" style="text-align: justify;">
                                Fill up the required fields below.
                            </p>

                            <hr class="mt-0" style="border: 1px solid #f5f6f8;">
                        </div>

                        <div class="col-md-12">
                                    <div class="form-group">
                                            <label>Rank / Position <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="awlm_rank" name="awlm_rank" disabled="true">
                                                <option value="">Choose option</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Type of Department <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="awlm_department" name="awlm_department" disabled="true">
                                                <option value="">Choose option</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Vessel <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="awlm_vessel" name="awlm_vessel" disabled="true">
                                                <option value="">Choose option</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Remarks <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="awlm_remarks" name="awlm_remarks">
                                                <option value="">Choose option</option>
                                                <option value="1">Not For Rehire (NRE)</option>
                                                <option value="2">Early Disembarkation</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Reasons <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="awlm_type_of_nre" name="awlm_type_of_nre">
                                                <option value="">Choose option</option>
                                                <option value="1">Poor Performance / Evaluation</option>
                                                <option value="2">Retire / Age Factor</option>
                                                <option value="3">Medical / Health Reason</option>
                                                <option value="4">Disciplinary</option>
                                                <option value="5">Own Request</option>
                                                <option value="6">Injury</option>
                                                <option value="7">Casualty Cases</option>
                                                <option value="8">Vessel Reduction</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Additional Remarks</label>
                                            <textarea class="form-control" id="awlm_additional_remarks" name="awlm_additional_remarks" rows="3" placeholder=""></textarea>
                                            <input type="hidden" id="awl_crew_name" name="awl_crew_name">
                                            <input type="hidden" id="awl_crew_code" name="awl_crew_code">
                                            <input type="hidden" id="awl_monitor_code" name="awl_monitor_code">
                                            <input type="hidden" id="awl_applicant_code" name="awl_applicant_code">
                                        </div>
                                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url('assets/javascript/a_warning_letter.js') ?>"></script>