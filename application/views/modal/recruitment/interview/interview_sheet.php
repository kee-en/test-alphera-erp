    <!-- ADD INTERVIEW SHEET MODAL -->
    <div class="modal fade" id="interview_sheet_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 65%;">
            <form action="javascript:void(0)" id="interview_sheet_form" name="interview_sheet_form" enctype="application/x-www-form-urlencoded">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-alphera font-20 m-0">Interview Sheet (<span id="interview_applicant_name"></span>)</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="is_applicant_code" name="is_applicant_code">
                        <input type="hidden" id="is_crew_code" name="is_crew_code">
                        <input type="hidden" id="is_status" name="is_status">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="header-title text-alphera mb-2">Recruiting Position and Type of Vessel</h4>
                                <!-- Position Requested -->
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="simpleinput">Position requested: </label>
                                    </div>
                                    <div class="col-md-10" id="is_position_applied_list">
                                        <div class="radio radio-alphera form-check-inline">
                                            <input type="radio" id="first_choice_position" name="position_requested">
                                            <label for="first_choice_position" id="first_choice_position_name"></label>
                                        </div>
                                        <div class="radio radio-alphera form-check-inline">
                                            <input type="radio" id="second_choice_position" name="position_requested">
                                            <label for="second_choice_position" id="second_choice_position_name"></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Type of Vessel -->
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="simpleinput">Type of Vessel: </label>
                                    </div>
                                    <div class="col-md-10" id="is_type_vessel_list">
                                        <div class="radio radio-alphera form-check-inline">
                                            <input type="radio" id="type_of_vsl_1" value="1" name="type_of_vessel">
                                            <label for="type_of_vsl_1" id="type_of_vsl_label">  </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Full Complement -->
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="simpleinput">Full Complement </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" id="is_required_no_of_crew" name="is_required_no_of_crew" class="form-control" placeholder="Required No. of Crew">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" id="is_present_no_of_crew" name="is_present_no_of_crew" class="form-control" placeholder="Present No. of Crew">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" id="is_crew_excess_or_shortage" name="is_crew_excess_or_shortage" class="form-control" placeholder="Crew Excess or Shortage">
                                        </div>
                                    </div>
                                </div>
                                <!-- Applied Crew -->
                                <h4 class="header-title text-alphera mb-2">Applied Crew</h4>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" id="is_applicant_name_one" name="is_applicant_name_one" class="form-control" placeholder="한 글">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" id="is_applicant_name_two" name="is_applicant_name_two" class="form-control" placeholder="漢 文">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" id="is_applicant_name_three" name="is_applicant_name_three" class="form-control" placeholder="English" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="date" id="is_birth_date" name="is_birth_date" class="form-control" placeholder="Birthday" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" id="is_kind_of_coc" name="is_kind_of_coc" class="form-control" placeholder="Kind of C.O.C.">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" id="is_position_last_vessel" name="is_position_last_vessel" class="form-control" placeholder="Position at Last Vessel" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Type of Vessel Table -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="thead-alphera">
                                                    <tr class="text-center">
                                                        <th style="width:20%;"></th>
                                                        <th>BULK</th>
                                                        <th>BULK</th>
                                                        <th>BULK</th>
                                                        <th>BULK</th>
                                                        <th>NA</th>
                                                        <th>Total Service Period</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td id="text-alignment">Type of Vessel</td>
                                                        <td><input type="text" id="bulk_vessel_1" name="bulk_one[]" class="form-control" readonly></td>
                                                        <td><input type="text" id="bulk_vessel_2" name="bulk_one[]" class="form-control" readonly></td>
                                                        <td><input type="text" id="bulk_vessel_3" name="bulk_one[]" class="form-control" readonly></td>
                                                        <td><input type="text" id="bulk_vessel_4" name="bulk_one[]" class="form-control" readonly></td>
                                                        <td id="text-alignment"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">Final Position</td>
                                                        <td><input type="text" id="bulk_position_1" name="bulk_two[]" class="form-control" readonly></td>
                                                        <td><input type="text" id="bulk_position_2" name="bulk_two[]" class="form-control" readonly></td>
                                                        <td><input type="text" id="bulk_position_3" name="bulk_two[]" class="form-control" readonly></td>
                                                        <td><input type="text" id="bulk_position_4" name="bulk_two[]" class="form-control" readonly></td>
                                                        <td id="text-alignment"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">Service Record</td>
                                                        <td><input type="text" id="bulk_record_1" name="bulk_three[]" class="form-control" readonly></td>
                                                        <td><input type="text" id="bulk_record_2" name="bulk_three[]" class="form-control" readonly></td>
                                                        <td><input type="text" id="bulk_record_3" name="bulk_three[]" class="form-control" readonly></td>
                                                        <td><input type="text" id="bulk_record_4" name="bulk_three[]" class="form-control" readonly></td>
                                                        <td id="text-alignment">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="na_one">
                                                                <label class="custom-control-label" for="na_one">N/A</label>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" id="total_service_one1" name="total_service_one" class="form-control" readonly>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Assessment -->
                                <h4 class="header-title text-alphera mb-2">Assessment</h4>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td id="text-alignment">Experience Analysis Vessel Type</td>
                                                        <td>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_one_eavt" value="1" name="is_eavt">
                                                                <label for="is_one_eavt"> Suitable </label>
                                                            </div>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_two_eavt" value="2" name="is_eavt">
                                                                <label for="is_two_eavt"> Not Suitable</label>
                                                            </div>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_three_eavt" value="3" name="is_eavt">
                                                                <label for="is_three_eavt"> Not Applicable</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">Age Limitation</td>
                                                        <td>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_one_age_limitation" value="1" name="is_age_limitation">
                                                                <label for="is_one_age_limitation"> Suitable </label>
                                                            </div>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_two_age_limitation" value="2" name="is_age_limitation">
                                                                <label for="is_two_age_limitation"> Not Suitable (Max. Age for New-crew)</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">Licenses & Certifications</td>
                                                        <td>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_one_license_cert" value="1" name="is_license_cert">
                                                                <label for="is_one_license_cert"> Suitable </label>
                                                            </div>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_two_license_cert" value="2" name="is_license_cert">
                                                                <label for="is_two_license_cert"> Not Suitable (Refer to CHECK LIST)</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">Physical Examination</td>
                                                        <td>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_one_physical_exam" value="1" name="is_physical_exam">
                                                                <label for="is_one_physica_exam"> Suitable </label>
                                                            </div>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_two_physical_exam" value="2" name="is_physical_exam">
                                                                <label for="is_two_physica_exam"> Not Suitable (Refer to Medical Cert.)</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">Ability to speak English</td>
                                                        <td>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_one_ability_english" value="1" name="is_ability_english">
                                                                <label for="is_one_ability_english"> Suitable </label>
                                                            </div>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_two_ability_english" value="2" name="is_ability_english">
                                                                <label for="is_two_ability_english"> Not Suitable (Check during Interview)</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">Assessment of Previous Company</td>
                                                        <td><input type="text" id="is_previous_company" name="is_previous_company" class="form-control">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- General Interview and Technical Interview -->
                                <h4 class="header-title text-alphera mb-2">General Interview and Technical Interview</h4>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="thead-alphera">
                                                    <tr class="text-center">
                                                        <th style="width:30%;">
                                                        </th>
                                                        <th style="width:30%;">General Field</th>
                                                        <th style="width:30%;">Technical Field</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <tr>
                                                        <td id="text-alignment">Score</td>
                                                        <td><input type="text" id="is_score_general" name="is_score_general" class="form-control" readonly>
                                                        </td>
                                                        <td><input type="text" id="is_score_technical" name="is_score_technical" class="form-control" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">Decision</td>
                                                        <td class="text-center">
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_decision_general_1" value="1" name="is_decision_general" disabled='disabled'>
                                                                <label for="decision_one"> Suitable </label>
                                                            </div>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_decision_general_0" value="0" name="is_decision_general" disabled='disabled'>
                                                                <label for="decision_one"> Not Suitable </label>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_decision_technical_1" value="1" name="is_decision_technical" disabled='disabled'>
                                                                <label for="decision_two"> Suitable </label>
                                                            </div>
                                                            <div class="radio radio-alphera form-check-inline">
                                                                <input type="radio" id="is_decision_technical_0" value="0" name="is_decision_technical" disabled='disabled'>
                                                                <label for="decision_two"> Not Suitable </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">Remark</td>
                                                        <td>
                                                            <textarea class="form-control" id="is_remark_general" name="is_remark_general" rows="2" readonly></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" id="is_remark_technical" name="is_remark_technical" rows="2" readonly></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">Evaluator</td>
                                                        <td><input type="text" id="is_evaluator_general" name="is_evaluator_general" class="form-control" readonly></td>
                                                        <td><input type="text" id="is_evaluator_technical" name="is_evaluator_technical" class="form-control" readonly></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Final Decision -->
                                <h4 class="header-title text-alphera mb-2">Final Decision</h4>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="custom-select" id="is_position_final" name="is_position_final" disabled>
                                                <option value="">Final Position</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" id="is_related_seniority" name="is_related_seniority" class="form-control" placeholder="Related Seniority (해당 호봉)">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="custom-select" id="is_type_vessel_final" name="is_type_vessel_final" disabled>
                                                <option value="">Final Vessel</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
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
                                                        <td id="text-alignment">1st Assessor</td>
                                                        <td id="text-alignment" class="first_name_assessor" id="first_name_assessor"></td>
                                                        <td style="vertical-align: middle;">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="is_first_assessor_app" name="is_first_decision_app" class="custom-control-input" value="1">
                                                                <label class="custom-control-label" for="is_first_assessor_app">Approved</label>
                                                            </div>
                                                            <div class="custom-control custom-radio mt-1">
                                                                <input type="radio" id="is_first_assessor_dis" name="is_first_decision_app" class="custom-control-input" value="2">
                                                                <label class="custom-control-label" for="is_first_assessor_dis">Disapproved</label>
                                                            </div>
                                                        </td>
                                                        <td><textarea class="form-control" id="is_first_remark" name="is_first_remark" rows="2"></textarea></td>
                                                    </tr>
                                                    <tr id="second_assessor_fields" style="display: none;">
                                                        <td id="text-alignment">2nd Assessor</td>
                                                        <td id="text-alignment" style="width: 20%;" class="second_name_assessor" id="second_name_assessor"></td>
                                                        <td style="vertical-align: middle;">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="is_second_assessor_app" name="is_second_assessor_app" class="custom-control-input" value="1">
                                                                <label class="custom-control-label" for="is_second_assessor_app">Approved</label>
                                                            </div>
                                                            <div class="custom-control custom-radio mt-1">
                                                                <input type="radio" id="is_second_assessor_dis" name="is_second_assessor_app" class="custom-control-input" value="2">
                                                                <label class="custom-control-label" for="is_second_assessor_dis">Disapproved</label>
                                                            </div>
                                                        </td>
                                                        <td><textarea class="form-control" id="is_second_remark" name="is_second_remark" rows="2"></textarea></td>
                                                    </tr>
                                                    <tr id="final_assessor_fields" style="display: none;">
                                                        <td id="text-alignment">Final Assessor</td>
                                                        <td id="text-alignment"><input type="text" class="form-control text-uppercase" id="is_final_name_assessor" name="is_final_name_assessor" value=""></td>
                                                        <td style="vertical-align: middle;">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="is_final_assessor_app" name="is_final_assessor_app" class="custom-control-input" value="1">
                                                                <label class="custom-control-label" for="is_final_assessor_app">Approved</label>
                                                            </div>
                                                            <div class="custom-control custom-radio mt-1">
                                                                <input type="radio" id="is_final_assessor_dis" name="is_final_assessor_app" class="custom-control-input" value="2">
                                                                <label class="custom-control-label" for="is_final_assessor_dis">Disapproved</label>
                                                            </div>
                                                        </td>
                                                        <td><textarea class="form-control" id="is_final_remark" name="is_final_remark" rows="2"></textarea></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- END -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group dropup mr-auto">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export As <i class="mdi mdi-chevron-up"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" onclick="printInterviewFormPdf()">PDF</a>
                                <a class="dropdown-item" onclick="printInterviewFormXl()">EXCEL</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-alphera" onclick="reload();"> Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/interview_sheet_form.js') ?>"></script>