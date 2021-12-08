<!-- ADD POEA CONTRACT MODAL -->
<div class="modal fade" id="add_poea_contracts_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 65%;">
        <form action="javascript:void(0)" id="poea_contract_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-20 m-0" id="a_poea_crew_name"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-md-12">
                            <p class="text-alphera font-20 font-weight-medium mb-0">POEA CONTRACT</p>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                        </div>
                    </div>

                    <hr>

                    <!-- POEA CONTRACT [START] -->
                    <div class="row" id="r_poea_contract">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SIRB No. <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_sirb_no" name="c_sirb_no">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SRC No. <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_src_no" name="c_src_no">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>License No.</label>
                                <input type="text" class="form-control" id="c_license_no" name="c_license_no">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name of Agent <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_name_of_agent" name="c_name_of_agent" value="ALPHERA MARINE SERVICES INC., (FORMERLY POS-FIL SHIP MANAGEMENT CORPORATION)">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name of Principal/Shipowner <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_name_of_principal" name="c_name_of_principal" value="POS SM CO., LTD">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address of Principal/Shipowner <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_address_of_principal" name="c_address_of_principal" value="4F PAN OCEAN BUILDING 102 JUNGANG-DAERO, JUNG GU, BUSAN 48938 KOREA">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name of Vessel <span class="asterisk">*</span></label>
                                <select class="custom-select" id="c_vessel_name" name="c_vessel_name" readonly>
                                    <option value="">Choose option</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>IMO Number <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_imo_number" name="c_imo_number">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gross Tonnage (GRT) <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_gross_tonnage" name="c_gross_tonnage">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year Built <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="c_year_built" name="c_year_built">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Flag <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_flag" name="c_flag">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type of Vessel <span class="asterisk">*</span></label>
                                <select class="custom-select" id="c_vessel_type" name="c_vessel_type" readonly>
                                    <option value="">Choose option</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classification Society <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_classification_society" name="c_classification_society">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Duration of Contract <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="c_duration_contract" name="c_duration_contract">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position <span class="asterisk">*</span></label>
                                <select class="custom-select" id="c_position" name="c_position" readonly>
                                    <option value="">Choose option</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Basic Monthly Salary <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_monthly_salary" name="c_monthly_salary">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hours of work <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_hours_of_work" name="c_hours_of_work">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Overtime <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_overtime" name="c_overtime">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vacation Leave with Pay <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_vacation_leave_with_pay" name="c_vacation_leave_with_pay">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Others <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_others" name="c_others">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total Salary <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_total_salary" name="c_total_salary">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Point of Hire <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_point_of_hire" name="c_point_of_hire">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Collective Bargaining Agreement <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="c_collective_agreement" name="c_collective_agreement">
                                <input type="hidden" class="form-control" id="c_crew_code" name="c_crew_code">
                                <input type="hidden" name="c_monitor_code" id="c_monitor_code">
                                <input type="hidden" name="c_applicant_type" id="c_applicant_type">
                            </div>
                        </div>
                    </div>
                    <!-- POEA CONTRACT [END] -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="BtnAddContractPOEA">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('assets/javascript/a_poea_contract.js') ?>"></script>