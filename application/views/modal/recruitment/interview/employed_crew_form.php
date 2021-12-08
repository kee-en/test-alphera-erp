<!-- ADD EMPLOYED CREW FORM MODAL -->
<form action="javascript:void(0)" id="employed_crew_form" name="employed_crew_form" enctype="application/x-www-form-urlencoded">
    <div class="modal fade" id="employed_crew_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 65%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-20 m-0"><span id="ecf_applicant_name"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ec_applicant_code" name="ec_applicant_code">
                    <input type="hidden" id="ec_crew_code" name="ec_crew_code">
                    <input type="hidden" id="ec_status" name="ec_status">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="text-alphera font-20 font-weight-medium mb-0">FORM FOR NEWLY EMPLOYED CREW</p>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td id="text-alignment">TENTATIVE ASSIGN VESSEL</td>
                                    <td>
                                        <select class="custom-select" id="ec_vessel" name="ec_vessel" disabled>
                                            <option value="">Vessel</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">RANK</td>
                                    <td>
                                        <select class="custom-select" id="ec_rank" name="ec_rank" disabled>
                                            <option value="">RANK / POSITION</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">NAME</td>
                                    <td><input type="text" id="ec_name" name="ec_name" class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td><br></td>
                                    <td><br></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Check Point</td>
                                    <td><input type="text" id="ec_check_point" name="ec_check_point" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Service Record (TTL)</td>
                                    <td><input type="text" id="ec_service_record_ttl" name="ec_service_record_ttl" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Service Record (Rank)</td>
                                    <td><input type="text" id="ec_service_record_rank" name="ec_service_record_rank" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Previous Manning Company</td>
                                    <td><input type="text" id="ec_previous_manning_company" name="ec_previous_manning_company" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Reputation</td>
                                    <td><input type="text" id="ec_reputation" name="ec_reputation" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Date of Birth</td>
                                    <td><input type="text" id="ec_date_of_birth" name="ec_date_of_birth" class="form-control" readonly </td> </tr> <tr>
                                    <td id="text-alignment">Transfer of 3 years</td>
                                    <td><input type="text" id="ec_transfer" name="ec_transfer" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Carrier (Ship Type)</td>
                                    <td><input type="text" id="ec_carrier" name="ec_carrier" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Experience with Korean crew</td>
                                    <td><input type="text" id="ec_exp_korean_crew" name="ec_exp_korean_crew" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Body Mass Index</td>
                                    <td><input type="text" id="ec_bmi" name="ec_bmi" class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">History of Past Injuries</td>
                                    <td><input type="text" id="ec_past_injuries" name="ec_past_injuries" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">History of Past Diseases</td>
                                    <td><input type="text" id="ec_past_disease" name="ec_past_disease" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Leave of Absence (past 3 years)</td>
                                    <td><input type="text" id="ec_leave_of_absence" name="ec_leave_of_absence" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Short Contract (past 3 years)</td>
                                    <td><input type="text" id="ec_short_contract" name="ec_short_contract" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">School</td>
                                    <td><input type="text" id="ec_school" name="ec_school" class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Married Yes/No</td>
                                    <td><input type="text" id="ec_married" name="ec_married" class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Number of Children</td>
                                    <td><input type="text" id="ec_no_of_children" name="ec_no_of_children" class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">Appearance</td>
                                    <td><input type="text" id="ec_appearance" name="ec_appearance" class="form-control"></td>
                                </tr>
                                <tr id="first_assessor_tr">
                                    <td id="text-alignment">1st Interview / Result</td>
                                    <td><textarea class="form-control" id="ec_first_interview_result" name="ec_first_interview_result" rows="5"></textarea></td>
                                </tr>
                                <tr id="second_assessor_tr">
                                    <td id="text-alignment">2nd Interview / Result</td>
                                    <td><textarea class="form-control" id="ec_second_interview_result" name="ec_second_interview_result" rows="5"></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group dropup mr-auto">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export As <i class="mdi mdi-chevron-up"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" onclick="printEmployedFormPdf()">PDF</a>
                            <a class="dropdown-item" onclick="printEmployedFormXl()">EXCEL</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('assets/javascript/employed_crew_form.js') ?>"></script>