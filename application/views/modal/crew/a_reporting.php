<!-- ADD FLIGHT DETAILS MODAL -->
<div class="modal fade" id="a_reporting_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">For Reporting - <span id="r_crew_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <form action="javascript:void(0)" id="add_reporting_form" method="POST">
                <input type="hidden" id="report_crew_code" name="report_crew_code">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <h4 class="text-default font-18 mt-0 mb-1">Reporting Form (Crew Performance Evaluation)</h4>
                            <p class="text-muted font-15" style="text-align: justify;">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                Note: If you want to promote the Crew, you can update the form below. If you didn't update, the details (Rank & Vessel) of the crew won't be changed.
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-muted">Rank / Position <span class="text-danger">*</span></label>
                                <select class="custom-select" id="r_position" name="r_position">
                                    <option value="">Select Rank / Position</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-muted">Vessel <span class="text-danger">*</span></label>
                                <select class="custom-select" id="r_tentative_vessel" name="r_tentative_vessel">
                                    <option value="">Select Vessel</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-muted">Crew Performance Evaluation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="r_crew_evaluation" name="r_crew_evaluation">
                                <small>Example: A, B, C, D, ect.</small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-muted">Date of Availability <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="r_date_availability" name="r_date_availability">
                                <input type="hidden" class="form-control" id="r_sea_service" name="r_sea_service">
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

<script type="text/javascript" src="<?= base_url('assets/javascript/reporting.js') ?>"></script>