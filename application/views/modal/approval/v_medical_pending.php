<!-- VIEW PENDING MEDICAL MODAL -->
<div class="modal fade" id="view_pending_medical_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">Medical Record Review - <span id="apvm_crew_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="apvm_medical_form" name="apvm_medical_form" enctype="application/x-www-form-urlencoded">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-muted m-0">Name:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_full_name">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Date of Med. Exam:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_date_of_med">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Date of Med. Expiry:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_date_of_expiry">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Medical Status:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_medical_status">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Age:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_age">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Rank / Position:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_rank">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Height:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_height">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Weight:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_weight">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">BMI:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_bmi">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Waist Line:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_waist_line">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Cholesterol:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_cholesterol">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Triglycerides:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_triglycerides">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">FBS:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_fbs">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">SGPT:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_sgpt">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">SGOT:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_sgot">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">LDL:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_ldl">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">HDL:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_hdl">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">B/P:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_bp">-</p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted m-0">Specimen Ailment:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_specimen_ailment">--</p>
                        </div>

                        <div class="col-md-12">
                            <label class="text-muted m-0">Remarks:</label>
                            <p class="text-dark font-18 mt-0 mb-2" id="vpmm_remarks">--</p>
                        </div>

                        <input type="hidden" id="is_assessor_code" name="is_assessor_code" value="<?= $this->global->ecdc('dc', $this->session->userdata('user_code')) ?>">
                        <input type="hidden" id="is_approval_code" name="is_approval_code">

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="thead-alphera">
                                        <tr class="text-center">
                                            <th></th>
                                            <th>Name</th>
                                            <th>Decision</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="first_assessor_fields">
                                            <td id="text-alignment">DP Manager</td>
                                            <td id="text-alignment" class="first_name_assessor" id="first_name_assessor"></td>
                                            <td style="vertical-align: middle;">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="is_first_assessor_app" name="is_first_decision_app" class="custom-control-input" value="1" disabled>
                                                    <label class="custom-control-label" for="is_first_assessor_app">Approved</label>
                                                </div>
                                                <div class="custom-control custom-radio mt-1">
                                                    <input type="radio" id="is_first_assessor_dis" name="is_first_decision_app" class="custom-control-input" value="2" readonly>
                                                    <label class="custom-control-label" for="is_first_assessor_dis">Disapproved</label>
                                                    <input type="hidden" id="first_assessor_id" name="first_assessor_id">
                                                </div>
                                            </td>
                                            <td><textarea class="form-control" id="is_first_remark" name="is_first_remark" rows="2" readonly></textarea></td>
                                        </tr>
                                        <tr id="second_assessor_fields">
                                            <td id="text-alignment">Crew Operation Manager</td>
                                            <td id="text-alignment" style="width: 20%;" class="second_name_assessor" id="second_name_assessor"></td>
                                            <td style="vertical-align: middle;">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="is_second_assessor_app" name="is_second_assessor_app" class="custom-control-input" value="1" readonly>
                                                    <label class="custom-control-label" for="is_second_assessor_app">Approved</label>
                                                </div>
                                                <div class="custom-control custom-radio mt-1">
                                                    <input type="radio" id="is_second_assessor_dis" name="is_second_assessor_app" class="custom-control-input" value="2" readonly>
                                                    <label class="custom-control-label" for="is_second_assessor_dis">Disapproved</label>
                                                </div>
                                                <input type="hidden" id="second_assessor_id" name="second_assessor_id">
                                            </td>
                                            <td><textarea class="form-control" id="is_second_remark" name="is_second_remark" rows="2" readonly></textarea></td>
                                        </tr>
                                        <tr id="final_assessor_fields">
                                            <td id="text-alignment">General Manager</td>
                                            <td id="text-alignment" style="width: 20%;" class="is_final_name_assessor" id="is_final_name_assessor"></td>
                                            <td style="vertical-align: middle;">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="is_final_assessor_app" name="is_final_assessor_app" class="custom-control-input" value="1" readonly>
                                                    <label class="custom-control-label" for="is_final_assessor_app">Approved</label>
                                                </div>
                                                <div class="custom-control custom-radio mt-1">
                                                    <input type="radio" id="is_final_assessor_dis" name="is_final_assessor_app" class="custom-control-input" value="2" readonly>
                                                    <label class="custom-control-label" for="is_final_assessor_dis">Disapproved</label>
                                                </div>
                                                <input type="hidden" id="final_assessor_id" name="final_assessor_id">
                                            </td>
                                            <td><textarea class="form-control" id="is_final_remark" name="is_final_remark" rows="2" readonly></textarea></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnDisapproveMedical" data-dismiss="modal" aria-label="Close" onclick="reload();">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>