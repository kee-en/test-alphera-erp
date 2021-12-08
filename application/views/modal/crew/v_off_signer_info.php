    <!-- VIEW CREW INFORMATION MODAL -->
    <div class="modal fade" id="v_crew_off_signer_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-20 m-0">View Shipboard Employment Application</h4>
                    <button type="button" class="close" id="OffSignerBtnClose" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="text-center">
                                <img class="align-self-start" src="<?= base_url('assets/images/avatar-placeholder.png') ?>" alt="" width="110">

                                <h3 class="text-alphera mb-0 mt-2" id="off_registered_name">-</h3>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row text-center text-uppercase">
                        <div class="col-md-3"></div>
                        <div class="col-2">
                            <div class="m-0">
                                <h4 class="m-0 font-18" id="on_date_of_availability">-</h4>
                                <p class="mb-0 text-muted text-truncate">Date of Disembark</p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="m-0">
                                <h4 class="m-0 font-18" id="on_second_position">-</h4>
                                <p class="mb-0 text-muted text-truncate">Rank / Position</p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="m-0">
                                <h4 class="m-0 font-18" id="on_tentative_vessel">-</h4>
                                <p class="mb-0 text-muted text-truncate">Vessel</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-bordered">
                                <li class="nav-item">
                                    <a href="#vof_tab1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                        GENERAL INFORMATION
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#vof_tab2" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        LICENSES
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#vof_tab3" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        CERTIFICATES
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#vof_tab4" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        SEA SERVICE RECORDS
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content text-uppercase">
                                <div class="tab-pane active" id="vof_tab1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-alphera font-20 font-weight-medium m-0 mb-1">PERSONAL INFORMATION</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">First Name</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_first_name">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Middle Name</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_middle_name">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Last Name</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_last_name">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Suffix</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_suffix">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Birth Date</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_birth_date">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Birth Place</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_birth_place">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Civil Status</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_civil_single">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Email Address</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_email_address">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Telephone Number</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_telephone_number">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Mobile Number</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_mobile_number">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Religion</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_religion">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Nationality</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_nationality">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">SSS Number</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_sss_no">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">TIN Number</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_tin_no">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Philhealth Number</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_philhealth_no">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Pag-Ibig Number</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_pag_ibig_no">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Height (in cm)</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_height">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Weight (in kg)</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_weight">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">BMI</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_bmi">-</p>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="text-muted m-0">Home Address</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_home_address">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Zip Code</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_zip_code">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Provincial City</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_provincial_city">-</p>
                                        </div>

                                        <div class="col-md-12">
                                            <p class="text-alphera font-20 font-weight-medium m-0 mb-1">NEXT OF KIN</p>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-muted m-0">Spouse Name</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_spouse_name">-</p>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-muted m-0">Occupation</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_no_of_occupation">-</p>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-muted m-0">No. of Children</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_no_of_children">-</p>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-muted m-0">Father's Name</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_father_name">-</p>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-muted m-0">Mother's Name</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_mother_name">-</p>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="text-muted m-0">Address</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_address">-</p>
                                        </div>

                                        <div class="col-md-12">
                                            <p class="text-alphera font-20 font-weight-medium m-0 mb-1">EDUCATIONAL ATTAINMENT</p>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-muted m-0">Course</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_course">-</p>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-muted m-0">School</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_school">-</p>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-muted m-0">Inclusive Date From-To</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_inclusive_years">-</p>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="text-muted m-0">School Address</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_school_address">-</p>
                                        </div>

                                        <div class="col-md-12">
                                            <p class="text-alphera font-20 font-weight-medium m-0 mb-1">WORKING GEARS</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Cover All</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_cover_all">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Winter Jacket</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_winter_jacket">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Shoes (in cms)</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_shoes">-</p>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted m-0">Winter Boots (bms)</label>
                                            <p class="text-dark font-18 mt-0 mb-2" id="on_winter_boots">-</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane show" id="vof_tab2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-alphera font-20 font-weight-medium m-0 mb-1">LICENSES / ENDORSEMENT / BOOK / ID</p>
                                        </div>

                                        <div class="col-md-12">
                                            <ul class="list-group" id="list_licenses">

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="vof_tab3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-alphera font-20 font-weight-medium m-0 mb-1">TRAINING CERTIFICATES</p>
                                        </div>

                                        <div class="col-md-12">
                                            <ul class="list-group" id="list_certificates">

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="vof_tab4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-alphera font-20 font-weight-medium m-0 mb-1">SEA SERVICE RECORD</p>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="table-responsive m-0">
                                                <table class="table table-sm table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered">
                                                    <thead class="thead-alphera">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Vessel</th>
                                                            <th>Flag</th>
                                                            <th>Salary</th>
                                                            <th>Rank</th>
                                                            <th>Type of VSL / Engine</th>
                                                            <th>GRT / Power</th>
                                                            <th>Date of Embarked</th>
                                                            <th>Date of Disembarked</th>
                                                            <th>Total of Service</th>
                                                            <th>Agency</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center" id="sea_service_record_table">
                                                        <tr>
                                                            <td colspan="11">No data available in table</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="font-weight-medium" colspan="9">Overall Service Record:</td>
                                                            <td class="text-center font-weight-medium" id="total_service_one"></td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/v_off_signer_info.js') ?>"></script>