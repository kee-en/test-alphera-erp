<style>
    @media screen and (max-width: 786px) {
        #v_sam {
            max-width: 95% !important;
        }

        #lbl_sam {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 33.33333%;
            flex: 0 0 33.33333%;
            max-width: 33.33333%;
            margin-top: 10px;
        }
    }

    @media screen and (max-width: 552px) {
        #lbl_sam {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }
    }
</style>


<!-- VIEW SHIPBOARD APPLICATION MODAL -->
<div class="modal fade" id="shipboard_application_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" id="v_sam" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">View Shipboard Employment Application</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <div class="modal-body p-4">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="text-center">
                            <img class="align-self-start" id="v_applicant_photo" src="<?= base_url('assets/images/avatar-placeholder.png') ?>" alt="" width="110">

                            <h3 class="text-alphera mb-0 mt-2" id="v_applicant_full_name"></h3>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row text-center text-uppercase">
                    <div class="col-2" id="lbl_sam">
                        <div class="m-0">
                            <h4 class="m-0 font-18" id="v_date_of_application">-</h4>
                            <p class="mb-0 text-muted text-truncate">Date of Application</p>
                        </div>
                    </div>
                    <div class="col-2" id="lbl_sam">
                        <div class="m-0">
                            <h4 class="m-0 font-18" id="v_date_of_availability">-</h4>
                            <p class="mb-0 text-muted text-truncate">Date of Availability</p>
                        </div>
                    </div>
                    <div class="col-2" id="lbl_sam">
                        <div class="m-0">
                            <h4 class="m-0 font-18" id="v_first_position">-</h4>
                            <p class="mb-0 text-muted text-truncate">1st Choice</p>
                        </div>
                    </div>
                    <div class="col-2" id="lbl_sam">
                        <div class="m-0">
                            <h4 class="m-0 font-18" id="v_second_position">-</h4>
                            <p class="mb-0 text-muted text-truncate">2nd Choice</p>
                        </div>
                    </div>
                    <div class="col-2" id="lbl_sam">
                        <div class="m-0">
                            <h4 class="m-0 font-18" id="v_nat_result">-</h4>
                            <p class="mb-0 text-muted text-truncate">NAT Result</p>
                        </div>
                    </div>
                    <div class="col-2" id="lbl_sam">
                        <div class="m-0">
                            <h4 class="m-0 font-18" id="v_tentative_vessel">-</h4>
                            <p class="mb-0 text-muted text-truncate">Tentative Vessel</p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs nav-bordered">
                            <li class="nav-item">
                                <a href="#v_tab1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    GENERAL INFORMATION
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#v_tab2" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    LICENSES
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#v_tab3" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    CERTIFICATES
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#v_tab4" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    SEA SERVICE RECORD
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="v_tab1">
                                <div class="row text-uppercase">
                                    <div class="col-md-12">
                                        <p class="text-alphera font-20 font-weight-medium mt-0 mb-1">PERSONAL INFORMATION</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">First Name</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_first_name">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Middle Name</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_middle_name">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Last Name</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_last_name">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Suffix</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_suffix">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Birth Date</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Birth Place</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_birth_place">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Civil Status</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_civil_status">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Email Address</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_email_address">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Telephone Number</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_telephone_number">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Mobile Number</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_number">09657283167</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Religion</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_religion">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Nationality</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_nationality">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">SSS Number</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_sss_no">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">TIN Number</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_tin_no">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Philhealth Number</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_philhealth_no">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Pag-Ibig Number</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_pag_ibig_no">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Height (in cm)</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_height">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Weight (in kg)</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_weight">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">BMI</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_bmi">-</p>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="text-muted m-0">Home Address</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_home_address">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Zip Code</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_zip_code">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Provincial City</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_provincial_city">-</p>
                                    </div>

                                    <div class="col-md-12">
                                        <hr class="mt-0" style="border: 1px solid #f5f6f8;">

                                        <p class="text-alphera font-20 font-weight-medium mt-0 mb-1">NEXT OF KIN</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Spouse Name</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_spouse_name">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Occupation</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_no_of_occupation">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">No. of Children</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_no_of_children">-</p>
                                    </div>

                                    <div class="col-md-4" id="child_name_d">
                                        <label class="text-muted m-0">Full Name</label>
                                        <div id="child_name_div">
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="child_birthdate_d">
                                        <label class="text-muted m-0">Birth Date</label>
                                        <div id="child_birth_date_div">
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="child_mobile_d">
                                        <label class="text-muted m-0">Mobile Number</label>
                                        <div id="child_mobile_div">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Father's Name</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_father_name">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Mother's Name</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_mother_name">-</p>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="text-muted m-0">Address</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_address">-</p>
                                    </div>

                                    <div class="col-md-12">
                                        <hr class="mt-0" style="border: 1px solid #f5f6f8;">

                                        <p class="text-alphera font-20 font-weight-medium mt-0 mb-1">EDUCATIONAL ATTAINMENT</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Course</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_course">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">School</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_school">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Inclusive Date From-To</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_inclusive_years">-</p>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="text-muted m-0">School Address</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_school_address">-</p>
                                    </div>

                                    <div class="col-md-12">
                                        <hr class="mt-0" style="border: 1px solid #f5f6f8;">

                                        <p class="text-alphera font-20 font-weight-medium mt-0 mb-1">WORKING GEARS</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Cover All</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_cover_all">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Winter Jacket</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_winter_jacket">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Shoes (in cms)</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_shoes">-</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-muted m-0">Winter Boots (bms)</label>
                                        <p class="text-dark font-18 mt-0 mb-2" id="v_winter_boots">-</p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane show" id="v_tab2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-alphera font-20 font-weight-medium mt-0 mb-1">LICENSES / ENDORSEMENT / BOOK / ID</p>
                                    </div>

                                    <div class="col-md-12">
                                        <ul class="list-group" id="list_licenses">

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="v_tab3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-alphera font-20 font-weight-medium mt-0 mb-1">TRAINING CERTIFICATES</p>
                                    </div>

                                    <div class="col-md-12">
                                        <ul class="list-group" id="list_certificates">

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="v_tab4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-alphera font-20 font-weight-medium mt-0 mb-1">SEA SERVICE RECORD</p>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="table-responsive m-0">
                                            <table class="table table-sm table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered">
                                                <thead class="thead-alphera text-center">
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

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="font-weight-medium" colspan="9">Overall Service Record:</td>
                                                        <td class="text-center" id="total_service_one"></td>
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

<script type="text/javascript" src="<?= base_url('assets/javascript/v_shipboard_application.js') ?>"></script>