<style>
    .e-pending {
        display: none;
    }
</style>

<!-- ADD MEDICAL MODAL -->
<div class="modal fade" id="edit_medical_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">Edit Medical</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="edit_medical_form">
                <div class="modal-body" id="modal_body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date of Med. Exam <span class="asterisk">*</span></label>
                                <input type="hidden" class="form-control" id="e_m_crew_code" name="e_m_crew_code">
                                <input type="hidden" class="form-control" id="e_m_medical_code" name="e_m_medical_code">
                                <input type="date" class="form-control" id="e_m_date_med_exam" name="e_m_date_med_exam">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date of Expiry <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="e_m_medical_expiry_date" name="e_m_medical_expiry_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="e_m_full_name" name="e_m_full_name" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Age <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="e_m_age" name="e_m_age" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="e_m_position" name="e_m_position" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Medical Status <span class="asterisk">*</span></label>
                                <select class="custom-select" id="e_m_status" name="e_m_status">
                                    <option value="">Choose option</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Fit For Sea Duty</option>
                                    <option value="3" hidden>Expired</option>
                                    <option value="4" hidden>Rejected</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Height (in cm) <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="e_m_height" name="e_m_height" onkeypress="return isNumberKey(event)">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Weight (in kg) <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="e_m_weight" name="e_m_weight" onkeypress="return isNumberKey(event)">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>BMI</label>
                                <input type="text" class="form-control" id="e_m_bmi" name="e_m_bmi" readonly>
                            </div>
                        </div>

                        <div class="col-md-6 e-pending">
                            <div class="form-group">
                                <label>Waist Line</label>
                                <input type="text" class="form-control" id="e_m_waistline" name="e_m_waistline">
                            </div>
                        </div>

                        <div class="col-md-6 e-pending">
                            <div class="form-group">
                                <label>Cholesterol</label>
                                <input type="text" class="form-control" id="e_m_cholesterol" name="e_m_cholesterol">
                            </div>
                        </div>

                        <div class="col-md-6 e-pending">
                            <div class="form-group">
                                <label>Triglycerides</label>
                                <input type="text" class="form-control" id="e_m_triglycerides" name="e_m_triglycerides">
                            </div>
                        </div>

                        <div class="col-md-6 e-pending">
                            <div class="form-group">
                                <label>FBS</label>
                                <input type="text" class="form-control" id="e_m_fbs" name="e_m_fbs">
                            </div>
                        </div>

                        <div class="col-md-6 e-pending">
                            <div class="form-group">
                                <label>SGPT</label>
                                <input type="text" class="form-control" id="e_m_sgpt" name="e_m_sgpt">
                            </div>
                        </div>

                        <div class="col-md-6 e-pending">
                            <div class="form-group">
                                <label>SGOT</label>
                                <input type="text" class="form-control" id="e_m_sgot" name="e_m_sgot">
                            </div>
                        </div>

                        <div class="col-md-6 e-pending">
                            <div class="form-group">
                                <label>LDL</label>
                                <input type="text" class="form-control" id="e_m_ldl" name="e_m_ldl">
                            </div>
                        </div>

                        <div class="col-md-6 e-pending">
                            <div class="form-group">
                                <label>HDL</label>
                                <input type="text" class="form-control" id="e_m_hdl" name="e_m_hdl">
                            </div>
                        </div>

                        <div class="col-md-6 e-pending">
                            <div class="form-group">
                                <label>B/P</label>
                                <input type="text" class="form-control" id="e_m_bp" name="e_m_bp">
                            </div>
                        </div>

                        <div class="col-md-6 e-pending">
                            <div class="form-group">
                                <label>Specimen Ailment</label>
                                <input type="text" class="form-control" id="e_m_specific_ailment" name="e_m_specific_ailment">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-textarea">Remarks</label>
                                <textarea class="form-control" id="e_m_add_remarks" name="e_m_add_remarks" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="BtnEditMedical">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('assets/javascript/e_medical.js') ?>"></script>