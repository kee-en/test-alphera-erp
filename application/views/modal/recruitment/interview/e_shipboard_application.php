    <!-- EDIT SHIPBOARD EMPLOYMENT APPLICATION MODAL -->
    <form action="javascript:void(0)" method="POST" id="edit_shipboard_application_form" name="edit_shipboard_application_form" enctype="multipart/form-data">
        <div class="modal fade" id="e_shipboard_application_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 80%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-alphera font-20 m-0">Update Shipboard Employment Application</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <img class="align-self-start" id="e_applicant_photo" src="<?= base_url('assets/images/avatar-placeholder.png') ?>" alt="" width="110">

                                    <h3 class="text-alphera mb-0" id="es_applicant_full_name"></h3>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row text-center text-uppercase">
                            <div class="col-2">
                                <div class="m-0">
                                    <h4 class="m-0 font-18" id="es_date_of_application">-</h4>
                                    <p class="mb-0 text-muted text-truncate">Date of Application</p>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="m-0">
                                    <h4 class="m-0 font-18" id="es_date_of_availability">-</h4>
                                    <p class="mb-0 text-muted text-truncate">Date of Availability</p>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="m-0">
                                    <h4 class="m-0 font-18" id="es_first_position">-</h4>
                                    <p class="mb-0 text-muted text-truncate">1st Choice</p>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="m-0">
                                    <h4 class="m-0 font-18" id="es_second_position">-</h4>
                                    <p class="mb-0 text-muted text-truncate">2nd Choice</p>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="m-0">
                                    <h4 class="m-0 font-18" id="es_nat_result">-</h4>
                                    <p class="mb-0 text-muted text-truncate">NAT Result</p>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="m-0">
                                    <h4 class="m-0 font-18" id="es_tentative_vessel">-</h4>
                                    <p class="mb-0 text-muted text-truncate">Tentative Vessel</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body p-2">
                                    <div id="btnwizard">
                                        <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-4">
                                            <li class="nav-item">
                                                <a href="#tab1" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                                    <span class="d-none d-sm-inline">PERSONAL INFORMATION</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab2" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                                    <span class="d-none d-sm-inline">LICENSES/ENDORSEMENT/BOOK/ID</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab3" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                                    <span class="d-none d-sm-inline">TRAINING CERTIFICATE</Sspan>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab4" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                                    <span class="d-none d-sm-inline">SEA SERVICE RECORD</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content b-0 mb-0 pt-0">
                                            <input type="hidden" name="e_applicant_code" id="e_applicant_code">
                                            <input type="hidden" name="e_crew_code" id="e_crew_code">

                                            <!-- PERSONAL INFORMATION FORM -->
                                            <div class="tab-pane" id="tab1">
                                                <!-- POSITION DETAILS [START] -->
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Select First Position <span class="asterisk">*</span></label>
                                                                    <select class="custom-select" id="e_first_position" name="e_first_position">
                                                                        <option value="">Select First Position</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Select Second Position</label>
                                                                    <select class="custom-select" id="e_second_position" name="e_second_position">
                                                                        <option value="">Select Second Position</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Date Availability <span class="asterisk">*</span></label>
                                                                    <input type="date" class="form-control" id="e_date_available" name="e_date_available">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Source</label>
                                                                    <select class="custom-select" id="e_source_location" name="e_source_location">
                                                                        <option value="">Choose option</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4" id="recommend" style="display: none;">
                                                                <div class="form-group">
                                                                    <label>Recommended By <span class="asterisk">*</span></label>
                                                                    <input type="text" class="form-control" id="e_recommended_name" name="e_recommended_name" placeholder="Recommend By">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Type of Crew <span class="asterisk">*</span></label>
                                                                    <select class="custom-select" id="s_type_of_crew" name="s_type_of_crew">
                                                                        <option value="">Choose option</option>
                                                                        <option value="NEW">NEW</option>
                                                                        <option value="CSA">CSA</option>
                                                                        <option value="CSB">CSB</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Tentative Assign Vessel <span class="asterisk">*</span></label>
                                                                    <select class="custom-select" id="e_tentative_vessel" name="e_tentative_vessel">
                                                                        <option value="">Tentative Assign Vessel</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <center>
                                                                    <div id="my_camera" style="margin: 0 auto; width: 300px !important; height: 300px !important;"></div>
                                                                    <img id="image-tag" width="300" height="300" src="<?= base_url(); ?>assets/images/avatar-placeholder.png">
                                                                    <input type="hidden" id="web_image" name="web_image">
                                                                </center>
                                                            </div>
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
                                                <!-- POSITION DETAILS [END] -->

                                                <hr>

                                                <!-- PERSONAL INFORMATION [START] -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="text-alphera font-20 mt-0 mb-1">I. Personal Information</p>
                                                        <p class="text-muted font-18">Fill up the required fields below.</p>
                                                    </div>

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
                                                            <input type="text" class="form-control" id="e_telephone_number" name="e_telephone_number" placeholder="Telephone Number" maxlength="11" onkeypress="return isNumberKey(event)">
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
                                                        <p class="text-alphera font-20 mt-0 mb-1">Next of Kin</p>
                                                        <p class="text-muted font-18">Fill up the required fields below.</p>
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
                                                            <input type="text" class="form-control" id="e_full_name_child_0" name="e_full_name_child[]" placeholder="Full Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="e_birth_date_child_0" name="e_birth_date_child[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" id="e_mobile_no_child_0" name="e_mobile_no_child[]" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="rs2" style="display: none;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control" id="e_full_name_child_1" name="e_full_name_child[]" placeholder="Full Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="e_birth_date_child_1" name="e_birth_date_child[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" id="e_mobile_no_child_1" name="e_mobile_no_child[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="rs3" style="display: none;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control" id="e_full_name_child_2" name="e_full_name_child[]" placeholder="Full Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="e_birth_date_child_2" name="e_birth_date_child[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" id="e_mobile_no_child_2" name="e_mobile_no_child[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="rs4" style="display: none;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control" id="e_full_name_child_3" name="e_full_name_child[]" placeholder="Full Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="e_birth_date_child_3" name="e_birth_date_child[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" id="e_mobile_no_child_3" name="e_mobile_no_child[]" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="rs5" style="display: none;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control" id="e_full_name_child_4" name="e_full_name_child[]" placeholder="Full Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="e_birth_date_child_4" name="e_birth_date_child[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" id="e_mobile_no_child_4" name="e_mobile_no_child[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="rs6" style="display: none;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control" id="e_full_name_child_5" name="e_full_name_child[]" placeholder="Full Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="e_birth_date_child_5" name="e_birth_date_child[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" id="e_mobile_no_child_5" name="e_mobile_no_child[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="rs7" style="display: none;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control" id="e_full_name_child_6" name="e_full_name_child[]" placeholder="Full Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="e_birth_date_child_6" name="e_birth_date_child[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" id="e_mobile_no_child_6" name="e_mobile_no_child[]" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="rs8" style="display: none;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control" id="e_full_name_child_7" name="e_full_name_child[]" placeholder="Full Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="e_birth_date_child_7" name="e_birth_date_child[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" id="e_mobile_no_child_7" name="e_mobile_no_child[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="rs9" style="display: none;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control" id="e_full_name_child_8" name="e_full_name_child[]" placeholder="Full Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="e_birth_date_child_8" name="e_birth_date_child[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" id="e_mobile_no_child_8" name="e_mobile_no_child[]" maxlength="11" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="rs10" style="display: none;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control" id="e_full_name_child_9" name="e_full_name_child[]" placeholder="Full Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Birth Date <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="e_birth_date_child_9" name="e_birth_date_child[]">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Mobile Number</label>
                                                            <input type="text" class="form-control" id="e_mobile_no_child_9" name="e_mobile_no_child[]" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
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
                                                        <p class="text-alphera font-20 mt-0 mb-1">Educational Attainment</p>
                                                        <p class="text-muted font-18">Fill up the required fields below.</p>
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
                                                        <p class="text-alphera font-20 mt-0 mb-1">Working Gears</p>
                                                        <p class="text-muted font-18">Fill up the required fields below.</p>
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
                                                    <div class="col-md-12">
                                                        <div class="float-right">
                                                            <button type="button" class="btn btn-alphera button-next">Next</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- LICENSES FORM -->
                                            <div class="tab-pane" id="tab2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="text-alphera font-20 mt-0 mb-1">II. Licenses / Endorsement / Book / ID</p>
                                                        <p class="text-muted font-18">Fill up the required fields below.</p>
                                                    </div>
                                                </div>

                                                <div class="row" id="licenses_list">

                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="float-right">
                                                            <button type="button" class="btn btn-alphera button-next">Next</button>
                                                        </div>
                                                        <div class="float-left">
                                                            <button type="button" class="btn btn-secondary button-previous">Previous</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- TRAINING CERTIFICATE FORM -->
                                            <div class="tab-pane" id="tab3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="text-alphera font-20 mt-0 mb-1">III. Training Certificates</p>
                                                        <p class="text-muted font-18">Fill up the required fields below.</p>
                                                    </div>
                                                </div>

                                                <div class="row" id="training_certificate_list">

                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="float-right">
                                                            <button type="button" class="btn btn-alphera button-next">Next</button>
                                                        </div>
                                                        <div class="float-left">
                                                            <button type="button" class="btn btn-secondary button-previous">Previous</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- SEA SERVICE RECORD FORM -->
                                            <div class="tab-pane" id="tab4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="text-alphera font-20 mt-0 mb-1">IV. Sea Service Record</p>
                                                        <span class="text-muted font-18">Fill up the required fields below.</span>

                                                        <div id="sea_service_record_fields"></div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="float-right">
                                                            <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                                                            <button type="submit" class="btn btn-success" id="BtnEditShipboard">Save Changes</button>
                                                        </div>
                                                        <div class="float-left">
                                                            <button type="button" class="btn btn-secondary button-previous">Previous</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script type="text/javascript" src="<?= base_url('assets/javascript/e_shipboard_application.js') ?>"></script>