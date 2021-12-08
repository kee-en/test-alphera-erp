<div class="modal fade" id="crew_filter" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="font-20 m-0">View Filters</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>

            <form action="javascript:void(0);" id="crew_filter_form" name="crew_filter_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Crew Name</label>
                                <input type="text" id="cf_crew_name" name="cf_crew_name" class="form-control" placeholder="Enter Crew Name">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rank / Position</label>
                                <select class="custom-select" id="cf_rank_position" name="cf_rank_position">
                                    <option value="">Select Rank / Position</option>
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name of Vessel</label>
                                <select class="custom-select" id="cf_vessel_name" name="cf_vessel_name">
                                    <option value="">Select Vessel</option>
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>

                        <?php if ($this->uri->segment(1) === "all-crew") : ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Crew Status</label>
                                    <select class="custom-select" id="cf_application_status" name="cf_application_status">
                                        <option value="">Select Crew Status</option>
                                        <option value="1">New Crew</option>
                                        <option value="2">On Process / Onboarding</option>
                                        <option value="3">Embarked</option>
                                        <option value="4">Disembarked</option>
                                        <option value="5">For Reporting</option>
                                        <option value="6">Not For Rehire (NRE)</option>
                                        <option value="7">On Vacation</option>
                                        <option value="8">Withdrawal Application</option>
                                    </select>
                                </div>
                            </div>
                        <?php elseif ($this->uri->segment(1) === "crew-management-plan") : ?>
                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label>Crew Status</label>
                                    <select class="custom-select" id="cf_application_status" name="cf_application_status">
                                        <option value="">Select Crew Status</option>
                                        <option value="3">Embarked</option>
                                        <option value="4">Disembarked</option>
                                    </select>
                                </div>
                            </div> -->
                        <?php endif; ?>

                        <?php if ($this->uri->segment(1) != "for-reporting") : ?>
                            <div class="col-md-12">
                                <label>End of Contract</label>
                                <div class="form-group">
                                    <select class="custom-select" id="cf_contract_status" name="cf_contract_status">
                                        <option value="">End of Contract</option>
                                        <option value="+30 days">30</option>
                                        <option value="+60 days">60</option>
                                        <option value="+90 days">90</option>
                                        <option value="+100 days">90 and above</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>Flight Availability</label>
                                <div class="form-group">
                                    <select class="custom-select" id="cf_flight_status" name="cf_flight_status">
                                        <option value="">Flight Availability</option>
                                        <option value="1">Available</option>
                                        <option value="0">Not Available</option>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="col-md-6" style="display: none;" id="d_date_from">
                            <div class="form-group">
                                <label id="date_from"></label>
                                <input type="date" class="form-control" id="cf_date_from" name="cf_date_from">
                            </div>
                        </div>

                        <div class="col-md-6" style="display: none;" id="d_date_to">
                            <div class="form-group">
                                <label id="date_to"></label>
                                <input type="date" class="form-control" id="cf_date_to" name="cf_date_to">
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
<script type="text/javascript" src="<?= base_url('assets/javascript/crew_filter.js') ?>"></script>