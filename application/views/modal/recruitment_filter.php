<div class="modal fade" id="recruitment_filter" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="font-20 m-0">View Filters</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>

            <form action="javascript:void(0);" id="recruitment_filter_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Applicant Name</label>
                                <input type="text" id="rf_applicant_name" name="rf_applicant_name" class="form-control" placeholder="Enter Applicant Name">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name of Vessel</label>
                                <select class="custom-select" id="rf_vessel_name" name="rf_vessel_name">
                                    <option value="">Select Vessel</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Applicant Rank</label>
                                <select class="custom-select" id="rf_rank" name="rf_rank">
                                    <option value="">Select Rank</option>
                                </select>
                            </div>
                        </div>
                        <?php if($this->uri->segment(1) === 'registered-applicants'): ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Application Status</label>
                                <select class="custom-select" id="rf_application_status" name="rf_application_status">
                                    <option value="">Select Application Status</option>
                                    <option value="00">On Process</option>
                                    <option value="1">Pending (NAT Result)</option>
                                    <option value="2">Interview 1st Assessor</option>
                                    <option value="3">Interview 2nd Assessor</option>
                                    <option value="4">For Principal Approval</option>
                                    <option value="5">Principal Approved</option>
                                    <option value="6">Passed (Recruitment)</option>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Date Availability From</label>
                                <input type="date" class="form-control" id="rf_date_availability_from" name="rf_date_availability_from">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Date Availability To</label>
                                <input type="date" class="form-control" id="rf_date_availability_to" name="rf_date_availability_to">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnFilter">Filter</button>
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function () {
	formVessel('rf_vessel_name');
    formAllPosition('rf_rank');
});
</script>