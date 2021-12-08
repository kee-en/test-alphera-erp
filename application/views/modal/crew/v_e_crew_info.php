<!-- VIEW / EDIT CREW INFORMATION MODAL -->
<div class="modal fade" id="v_e_crew_information_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">Shipboard Employment Application</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="text-center">
                            <img class="align-self-start" id="v_applicant_photo" src="<?= base_url('assets/images/avatar-placeholder.png') ?>" alt="" width="110">
                            <h3 class="text-alphera mb-0 mt-2" id="v_applicant_full_name">-</h3>
                        </div>
                    </div>
                    <div class="col-md-12 text-center mt-1">
                        <button type="button" class="btn btn-alphera btn-xs btn-edit" onclick="btn_edit_crew_info()">Edit Crew Information</button>
                        <button type="button" class="btn btn-primary btn-xs btn-view" onclick="btn_view_crew_info()" style="display: none;">View Crew Information</button>
                    </div>
                </div>

                <hr>

                <div class="row text-center">
                    <div class="col-md-2"></div>
                    <div class="col-2">
                        <div class="m-0">
                            <h4 class="m-0 font-18" id="v_approved_position">-</h4>
                            <p class="mb-0 text-muted text-truncate">Rank / Position</p>
                            <a href="javascript:void(0)" onclick="updatePosAndVess();"><span class="text-alphera text-underline"><i class="mdi mdi-pencil"></i> Edit Position</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="m-0">
                            <h4 class="m-0 font-18" id="v_assign_vessel">-</h4>
                            <p class="mb-0 text-muted text-truncate">Assigned Vessel</p>
                            <a href="javascript:void(0)" onclick="updatePosAndVess();"><span class="text-alphera text-underline"><i class="mdi mdi-pencil"></i> Edit Vessel</span></a>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="m-0">
                            <h4 class="m-0 font-18" id="v_date_available">-</h4>
                            <p class="mb-0 text-muted text-truncate">Date of Availablity</p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row text-uppercase" id="v_row_info">
                    <div class="col-md-12">
                        <p class="text-alphera font-20 font-weight-medium mt-0 mb-1">PERSONAL INFORMATION</p>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="text-muted m-0">First Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_first_name">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Middle Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_middle_name">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Last Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_last_name">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Suffix</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_suffix">-</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Birth Place</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_place">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Civil Status</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_civil_status">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Email Address</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_email_address">-</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label class="text-muted m-0">Telephone Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_telephone_number">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_number">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Religion</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_religion">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Nationality</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_nationality">-</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label class="text-muted m-0">SSS Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_sss_no">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">TIN Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_tin_no">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Philhealth Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_philhealth_no">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Pag-Ibig Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_pag_ibig_no">-</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label class="text-muted m-0">Height (in cm)</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_height">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Weight (in kg)</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_weight">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">BMI</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_bmi">-</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="text-muted m-0">Home Address</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_home_address">-</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label class="text-muted m-0">Zip Code</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_zip_code">-</p>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted m-0">Provincial City</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_provincial_city">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <p class="text-alphera font-20 font-weight-medium mt-0 mb-1">NEXT OF KIN</p>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
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
                        </div>

                        <div class="row" id="children_row_1" style="display: none;">
                            <div class="col-md-4">
                                <label class="text-muted m-0">Full Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_full_name_children_0">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date_children_0">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_no_0">-</p>
                            </div>
                        </div>

                        <div class="row" id="children_row_2" style="display: none;">
                            <div class="col-md-4">
                                <label class="text-muted m-0">Full Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_full_name_children_1">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date_children_1">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_no_1">-</p>
                            </div>
                        </div>

                        <div class="row" id="children_row_3" style="display: none;">
                            <div class="col-md-4">
                                <label class="text-muted m-0">Full Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_full_name_children_2">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date_children_2">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_no_2">-</p>
                            </div>
                        </div>

                        <div class="row" id="children_row_4" style="display: none;">
                            <div class="col-md-4">
                                <label class="text-muted m-0">Full Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_full_name_children_3">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date_children_3">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_no_3">-</p>
                            </div>
                        </div>

                        <div class="row" id="children_row_5" style="display: none;">
                            <div class="col-md-4">
                                <label class="text-muted m-0">Full Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_full_name_children_4">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date_children_4">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_no_4">-</p>
                            </div>
                        </div>

                        <div class="row" id="children_row_6" style="display: none;">
                            <div class="col-md-4">
                                <label class="text-muted m-0">Full Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_full_name_children_5">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date_children_5">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_no_5">-</p>
                            </div>
                        </div>

                        <div class="row" id="children_row_7" style="display: none;">
                            <div class="col-md-4">
                                <label class="text-muted m-0">Full Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_full_name_children_6">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date_children_6">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_no_6">-</p>
                            </div>
                        </div>

                        <div class="row" id="children_row_8" style="display: none;">
                            <div class="col-md-4">
                                <label class="text-muted m-0">Full Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_full_name_children_7">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date_children_7">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_no_7">-</p>
                            </div>
                        </div>

                        <div class="row" id="children_row_9" style="display: none;">
                            <div class="col-md-4">
                                <label class="text-muted m-0">Full Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_full_name_children_8">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date_children_8">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_no_8">-</p>
                            </div>
                        </div>

                        <div class="row" id="children_row_10" style="display: none;">
                            <div class="col-md-4">
                                <label class="text-muted m-0">Full Name</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_full_name_children_9">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Birth Date</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_birth_date_children_9">-</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted m-0">Mobile Number</label>
                                <p class="text-dark font-18 mt-0 mb-2" id="v_mobile_no_9">-</p>
                            </div>
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
                        <p class="text-alphera font-20 font-weight-medium mt-0 mb-1">WORKING GEARS</p>
                    </div>

                    <div class="col-md-3">
                        <label class="text-muted m-0">Cover All</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="v_cover_all">-</p>
                    </div>

                    <div class="col-md-3">
                        <label class="text-muted m-0">Winter Jacket</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="v_winter_jacket">-</p>
                    </div>

                    <div class="col-md-3">
                        <label class="text-muted m-0">Shoes (in cms)</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="v_shoes">-</p>
                    </div>

                    <div class="col-md-3">
                        <label class="text-muted m-0">Winter Boots (bms)</label>
                        <p class="text-dark font-18 mt-0 mb-2" id="v_winter_boots">-</p>
                    </div>
                </div>

                <form action="javascript:void(0)" method="POST" id="e_crew_info_form">
                    <div class="row" id="e_row_info" style="display: none;">
                        <div class="col-md-12">
                            <!-- PERSONAL INFORMATION [START] -->
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-alphera font-18 mt-0 mb-1">I. Personal Information</p>
                                    <p class="text-muted">Fill up the required fields below.</p>
                                    <input type="hidden" class="form-control" id="e_crew_code" name="e_crew_code">
                                    <input type="hidden" class="form-control" id="e_insigner" name="e_insigner">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>First Name <span class="asterisk">*</span></label>
                                                <input type="text" class="form-control" id="e_first_name" name="e_first_name" placeholder="First name" onkeypress="return isAlphabet(event)">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Middle Name </label>
                                                <input type="text" class="form-control" id="e_middle_name" name="e_middle_name" placeholder="Middle Name" onkeypress="return isAlphabet(event)">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Last Name <span class="asterisk">*</span></label>
                                                <input type="text" class="form-control" id="e_last_name" name="e_last_name" placeholder="Last Name" onkeypress="return isAlphabet(event)">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Suffix</label>
                                                <input type="text" class="form-control" id="e_suffix" name="e_suffix" placeholder="Suffix" onkeypress="return isAlphabet(event)">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Birth Date <span class="asterisk">*</span></label>
                                                <input type="date" class="form-control" id="e_birth_date" name="e_birth_date">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Birth Place <span class="asterisk">*</span></label>
                                                <input type="text" class="form-control" id="e_birth_place" name="e_birth_place" placeholder="Birth Place">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Civil Status <span class="asterisk">*</span></label>
                                                <select class="custom-select" id="e_civil_status" name="e_civil_status">
                                                    <option value="">Choose option</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input type="email" class="form-control" id="e_email_address" name="e_email_address" placeholder="Email Address">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Telephone Number</label>
                                                <input type="text" class="form-control" id="e_telephone_number" name="e_telephone_number" placeholder="Telephone Number" maxlength="7" onkeypress="return isNumberKey(event)">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Mobile Number</label>
                                                <input type="text" class="form-control" id="e_mobile_number" name="e_mobile_number" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Religion</label>
                                                <select class="custom-select" id="e_religion" name="e_religion">
                                                    <option value="">Choose option</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nationality <span class="asterisk">*</span></label>
                                                <select class="custom-select" id="e_nationality" name="e_nationality">
                                                    <option value="">Choose option</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <center>
                                            <div id="my_camera" style="display: none;"></div>
                                            <img id="image-tag" width="300" height="241" src="<?= base_url(); ?>assets/images/avatar-placeholder.png">
                                            <input type="hidden" id="web_image" name="web_image">
                                        </center>

                                        <div class="col-md-12 mt-1" id="init_container">
                                            <button type="button" class="btn btn-primary btn-block" onclick="init_webcam()">TAKE A PICTURE</button>
                                        </div>

                                        <div class="col-md-12 mt-1" id="capture_container" style="display: none;">
                                            <button type="button" class="btn btn-primary btn-block" onclick="take_snapshot()">CAPTURE</button>
                                        </div>
                                        <div class="col-md-12 mt-1" id="retake_container" style="display: none;">
                                            <button type="button" class="btn btn-alphera btn-block" onclick="retake_snapshot()">RETAKE</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>SSS No.</label>
                                        <input type="text" class="form-control" id="e_sss_no" name="e_sss_no" placeholder="SSS No." maxlength="10" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>TIN No.</label>
                                        <input type="text" class="form-control" id="e_tin_no" name="e_tin_no" placeholder="TIN No." minlength="9" maxlength="12" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Philhealth No.</label>
                                        <input type="text" class="form-control" id="e_philhealth_no" name="e_philhealth_no" placeholder="Philhealth No." maxlength="12" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Pag-Ibig No.</label>
                                        <input type="text" class="form-control" id="e_pag_ibig_no" name="e_pag_ibig_no" placeholder="Pag-Ibig No." maxlength="12" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Height (in cm) <span class="asterisk">*</span></label>
                                        <input type="text" class="form-control" id="e_height" name="e_height" placeholder="Height (in cm)" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Weight (in kg) <span class="asterisk">*</span></label>
                                        <input type="text" class="form-control" id="e_weight" name="e_weight" placeholder="Weight (in kg)" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>BMI <span class="asterisk">*</span></label>
                                        <input type="text" class="form-control" id="e_bmi" name="e_bmi" placeholder="BMI" readonly>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>House/Unit/Flr #, Bldg Name, Blk or Lot # <span class="asterisk">*</span></label>
                                        <input type="text" class="form-control" id="e_home_address" name="e_home_address" placeholder="House/Unit/Flr #, Bldg Name, Blk or Lot #">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Barangay</label>
                                        <input type="text" class="form-control" id="e_barangay" name="e_barangay" placeholder="Barangay">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Province <span class="asterisk">*</span></label>
                                        <select class="custom-select" id="e_province" name="e_province">
                                            <option value="">Choose option</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City / Municipality <span class="asterisk">*</span></label>
                                        <select class="custom-select" id="e_city" name="e_city">
                                            <option value="">Choose option</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Country <span class="asterisk">*</span></label>
                                        <select class="custom-select" id="e_country" name="e_country">
                                            <option value="Philippines">Philippines</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Zip Code </label>
                                        <input type="text" class="form-control" id="e_zip_code" name="e_zip_code" placeholder="Zip Code" maxlength="4" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincial</label>
                                        <input type="text" class="form-control" id="e_provincial" name="e_provincial" placeholder="Provincial">
                                    </div>
                                </div>
                            </div>
                            <!-- PERSONAL INFORMATION [END] -->

                            <hr>

                            <!-- NEXT OF KIN [START] -->
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-alphera font-18 mt-0 mb-1">Next of Kin</p>
                                    <p class="text-muted">Fill up the required fields below.</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Spouse Name </label>
                                        <input type="text" class="form-control" id="e_spouse_name" name="e_spouse_name" placeholder="Spouse Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Occupation </label>
                                        <input type="text" class="form-control" id="e_occupation" name="e_occupation" placeholder="Occupation">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>No. of Children </label>
                                        <select class="custom-select" id="e_no_of_children" name="e_no_of_children">
                                            <option value="none">Choose option</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="rs1" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="r_full_name_0" name="r_full_name[]" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Birth Date <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="r_birth_date_0" name="r_birth_date[]">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" id="r_mobile_no_0" name="r_mobile_no[]" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="rs2" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="r_full_name_1" name="r_full_name[]" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Birth Date <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="r_birth_date_1" name="r_birth_date[]">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" id="r_mobile_no_1" name="r_mobile_no[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="rs3" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="r_full_name_2" name="r_full_name[]" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Birth Date <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="r_birth_date_2" name="r_birth_date[]">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" id="r_mobile_no_2" name="r_mobile_no[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="rs4" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="r_full_name_3" name="r_full_name[]" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Birth Date <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="r_birth_date_3" name="r_birth_date[]">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" id="r_mobile_no_3" name="r_mobile_no[]" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="rs5" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="r_full_name_4" name="r_full_name[]" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Birth Date <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="r_birth_date_4" name="r_birth_date[]">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" id="r_mobile_no_4" name="r_mobile_no[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="rs6" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="r_full_name_5" name="r_full_name[]" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Birth Date <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="r_birth_date_5" name="r_birth_date[]">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" id="r_mobile_no_5" name="r_mobile_no[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="rs7" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="r_full_name_6" name="r_full_name[]" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Birth Date <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="r_birth_date_6" name="r_birth_date[]">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" id="r_mobile_no_6" name="r_mobile_no[]" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="rs8" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="r_full_name_7" name="r_full_name[]" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Birth Date <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="r_birth_date_7" name="r_birth_date[]">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" id="r_mobile_no_7" name="r_mobile_no[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="rs9" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="r_full_name_8" name="r_full_name[]" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Birth Date <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="r_birth_date_8" name="r_birth_date[]">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" id="r_mobile_no_8" name="r_mobile_no[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="rs10" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" id="r_full_name_9" name="r_full_name[]" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Birth Date <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="r_birth_date_9" name="r_birth_date[]">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" id="r_mobile_no_9" name="r_mobile_no[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Father's Name</label>
                                        <input type="text" class="form-control" id="e_father_name" name="e_father_name" placeholder="Father's Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mother's Name</label>
                                        <input type="text" class="form-control" id="e_mother_name" name="e_mother_name" placeholder="Mother's Name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Address <span class="asterisk">*</span></label>
                                        <input type="text" class="form-control" id="e_kin_address" name="e_kin_address" placeholder="Address">
                                    </div>
                                </div>
                            </div>
                            <!-- NEXT OF KIN [END] -->

                            <hr>

                            <!-- EDUCATIONAL ATTAINMENT [START] -->
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-alphera font-18 mt-0 mb-1">Educational Attainment</p>
                                    <p class="text-muted">Fill up the required fields below.</p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Course <span class="asterisk">*</span></label>
                                        <input type="text" class="form-control" id="e_course" name="e_course" placeholder="Course">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>School <span class="asterisk">*</span></label>
                                        <input type="text" class="form-control" id="e_school_name" name="e_school_name" placeholder="School">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Inclusive Date From <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="e_inclusive_years_from" name="e_inclusive_years_from">
                                        <small>Ex. 01/01/<?= date("Y"); ?></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Inclusive Date To <span class="asterisk">*</span></label>
                                        <input type="date" class="form-control" id="e_inclusive_years_to" name="e_inclusive_years_to">
                                        <small>Ex. 02/01/<?= date("Y"); ?></small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>School Address</label>
                                        <input type="text" class="form-control" id="e_school_address" name="e_school_address" placeholder="School Address">
                                    </div>
                                </div>
                            </div>
                            <!-- EDUCATIONAL ATTAINMENT [END] -->

                            <hr>

                            <!-- WORKING GEARS [START] -->
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-alphera font-18 mt-0 mb-1">Working Gears</p>
                                    <p class="text-muted">Fill up the required fields below.</p>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Cover All</label>
                                        <input type="text" class="form-control" id="e_cover_all" name="e_cover_all" placeholder="Cover All" onkeypress="return isAlphabet(event)">
                                        <small>Specify sizes if S / M / L / XL / XXL</small>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Winter Jacket </label>
                                        <input type="text" class="form-control" id="e_winter_jacket" name="e_winter_jacket" placeholder="Winter Jacket" onkeypress="return isAlphabet(event)">
                                        <small>Specify sizes if S / M / L / XL / XXL</small>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Shoes (in cms) </label>
                                        <input type="text" class="form-control" id="e_shoes" name="e_shoes" placeholder="Shoes (in cms)" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Winter Boots (bms) </label>
                                        <input type="text" class="form-control" id="e_winter_boots" name="e_winter_boots" placeholder="Winter Boots (bms)" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>
                            <!-- WORKING GEARS [END] -->

                            <hr>

                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                                    <button type="submit" class="btn btn-primary" id="BtnSubmitCrewInfo">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
            </div> -->
        </div>
    </div>
</div>

<!-- Global JavaScript Modal -->
<script type="text/javascript" src="<?= base_url('assets/javascript/v_e_crew_info.js') ?>"></script>