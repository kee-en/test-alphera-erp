<!-- ADD POEA CONTRACT MODAL -->
<div class="modal fade" id="promotion_poea_contracts_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 65%;">
        <form action="javascript:void(0)" id="promotion_poea_contract_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-20 m-0" id="promotion_poea_crew_name"></h4>
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
                    <div class="row" id="promotion_poea_contract">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SIRB No. <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_sirb_no" name="promotion_sirb_no">
                                <input type="hidden" id="promotion_hid_crew_code" name="promotion_hid_crew_code">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SRC No. <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_src_no" name="promotion_src_no">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>License No.</label>
                                <input type="text" class="form-control" id="promotion_license_no" name="promotion_license_no" >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name of Agent <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_name_of_agent" name="promotion_name_of_agent">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name of Principal/Shipowner <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_name_of_principal" name="promotion_name_of_principal">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address of Principal/Shipowner <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_address_of_principal" name="promotion_address_of_principal">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name of Vessel <span class="asterisk">*</span></label>
                                <select class="custom-select" id="promotion_vessel_name" name="promotion_vessel_name" readonly>
                                    <option value="">Choose option</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>IMO Number <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_imo_number" name="promotion_imo_number" onkeypress="return isNumberKey(event)">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gross Tonnage (GRT) <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_gross_tonnage" name="promotion_gross_tonnage">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year Built <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="promotion_year_built" name="promotion_year_built">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Flag <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_flag" name="promotion_flag">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type of Vessel <span class="asterisk">*</span></label>
                                <select class="custom-select" id="promotion_vessel_type" name="promotion_vessel_type" readonly>
                                    <option value="">Choose option</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classification Society <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_classification_society" name="promotion_classification_society">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Duration of Contract <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="promotion_duration_contract" name="promotion_duration_contract">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position <span class="asterisk">*</span></label>
                                <select class="custom-select" id="promotion_position" name="promotion_position" readonly>
                                    <option value="">Choose option</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Basic Monthly Salary <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_monthly_salary" name="promotion_monthly_salary">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hours of work <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_hours_of_work" name="promotion_hours_of_work">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Overtime <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_overtime" name="promotion_overtime">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vacation Leave with Pay <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_vacation_leave_with_pay" name="promotion_vacation_leave_with_pay">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Others <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_others" name="promotion_others">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total Salary <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_total_salary" name="promotion_total_salary">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Point of Hire <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_point_of_hire" name="promotion_point_of_hire">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Collective Bargaining Agreement <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="promotion_collective_agreement" name="promotion_collective_agreement">
                            </div>
                        </div>
                    </div>
                    <!-- POEA CONTRACT [END] -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSavePromotion_poea">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>