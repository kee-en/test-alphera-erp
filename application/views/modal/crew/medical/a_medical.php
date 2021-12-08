<style>
    .r-pending {
        display: none;
    }
</style>

<!-- ADD MEDICAL MODAL -->
<div class="modal fade" id="add_medical_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0" id="am_crew_name"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="medical_form" name="medical_form" enctype="application/x-www-form-urlencoded">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date of Med. Exam <span class="asterisk">*</span></label>
                                <input type="hidden" class="form-control" id="m_crew_code" name="m_crew_code">
                                <input type="date" class="form-control" id="m_date_med_exam" name="m_date_med_exam">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date of Expiry <span class="asterisk">*</span></label>
                                <input type="date" class="form-control" id="m_medical_expiry_date" name="m_medical_expiry_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="m_full_name" name="m_full_name" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Age <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="m_age" name="m_age" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position <span class="asterisk">*</span></label>
                                <select class="custom-select" id="m_position" name="m_position" disabled>
                                    <option value="">Choose option</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Medical Status <span class="asterisk">*</span></label>
                                <select class="custom-select" id="m_status" name="m_status">
                                    <option value="">Choose option</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Fit For Sea Duty</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Height (in cm) <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="m_height" name="m_height" onkeypress="return isNumberKey(event)">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Weight (in kg) <span class="asterisk">*</span></label>
                                <input type="text" class="form-control" id="m_weight" name="m_weight" onkeypress="return isNumberKey(event)">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>BMI</label>
                                <input type="text" class="form-control" id="m_bmi" name="m_bmi" readonly>
                            </div>
                        </div>

                        <div class="col-md-6 r-pending">
                            <div class="form-group">
                                <label>Waist Line</label>
                                <input type="text" class="form-control" id="m_waistline" name="m_waistline">
                            </div>
                        </div>

                        <div class="col-md-6 r-pending">
                            <div class="form-group">
                                <label>Cholesterol</label>
                                <input type="text" class="form-control" id="m_cholesterol" name="m_cholesterol">
                            </div>
                        </div>

                        <div class="col-md-6 r-pending">
                            <div class="form-group">
                                <label>Triglycerides</label>
                                <input type="text" class="form-control" id="m_triglycerides" name="m_triglycerides">
                            </div>
                        </div>

                        <div class="col-md-6 r-pending">
                            <div class="form-group">
                                <label>FBS</label>
                                <input type="text" class="form-control" id="m_fbs" name="m_fbs">
                            </div>
                        </div>

                        <div class="col-md-6 r-pending">
                            <div class="form-group">
                                <label>SGPT</label>
                                <input type="text" class="form-control" id="m_sgpt" name="m_sgpt">
                            </div>
                        </div>

                        <div class="col-md-6 r-pending">
                            <div class="form-group">
                                <label>SGOT</label>
                                <input type="text" class="form-control" id="m_sgot" name="m_sgot">
                            </div>
                        </div>

                        <div class="col-md-6 r-pending">
                            <div class="form-group">
                                <label>LDL</label>
                                <input type="text" class="form-control" id="m_ldl" name="m_ldl">
                            </div>
                        </div>

                        <div class="col-md-6 r-pending">
                            <div class="form-group">
                                <label>HDL</label>
                                <input type="text" class="form-control" id="m_hdl" name="m_hdl">
                            </div>
                        </div>

                        <div class="col-md-6 r-pending">
                            <div class="form-group">
                                <label>B/P</label>
                                <input type="text" class="form-control" id="m_bp" name="m_bp">
                            </div>
                        </div>

                        <div class="col-md-6 r-pending">
                            <div class="form-group">
                                <label>Specific Ailment</label>
                                <input type="text" class="form-control" id="m_specific_ailment" name="m_specific_ailment">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-textarea">Remarks</label>
                                <textarea class="form-control" id="m_add_remarks" name="m_add_remarks" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="BtnAddMedical">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('assets/javascript/a_medical.js') ?>"></script>