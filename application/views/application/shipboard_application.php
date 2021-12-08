<style>
    #image-tag {
        margin: 0 auto;
        width: 100%;
        height: 250px;
        margin-bottom: 10px;
    }

    #my_camera {
        margin: 0 auto;
        width: 300px !important;
        height: 260px !important;
    }
</style>
<div class="mt-5 mb-5">
    <div class="container-fluid">
        <div class="row justify-content-center mb-2">
            <div class="col-md-8">
                <div class="text-center">
                    <a href="<?= base_url() ?>">
                        <span><img class="mb-3" src="<?= base_url('assets/images/alphera/alphera_logo.png') ?>" alt="Alphera Marine Services Inc." height="64"></span>
                    </a>

                    <p class="text-muted font-18">Don't have an Shipboard Employment Application? Create your free application now.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p class="text-alphera font-20 m-0">Shipboard Employment Application</p>
                        <span class="text-muted font-18">Please fill up the form below to process your application.</span>
                    </div>

                    <div class="card-body">
                        <form action="javascript:void(0)" id="application_form" name="application_form" enctype="application/x-www-form-urlencoded">
                            <div id="btnwizard">
                                <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-4">
                                    <li class="nav-item">
                                        <a href="#tab1" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-account-circle mr-1"></i> <br>
                                            <span class="d-none d-sm-inline">PERSONAL INFORMATION</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tab2" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-file mr-1"></i> <br>
                                            <span class="d-none d-sm-inline">LICENSES/ENDORSEMENT/BOOK/ID</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tab3" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-wunderlist mr-1"></i> <br>
                                            <span class="d-none d-sm-inline">TRAINING CERTIFICATE</Sspan>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tab4" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="la la-ship mr-1"></i> <br>
                                            <span class="d-none d-sm-inline">SEA SERVICE RECORD</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content b-0 mb-0 pt-0">
                                    <!-- PERSONAL INFORMATION FORM -->
                                    <div class="tab-pane" id="tab1">
                                        <!-- POSITION DETAILS [START] -->
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="text-alphera font-20 mt-0 mb-1">Basic Information</p>
                                                        <p class="text-muted font-18">Fill up the required fields below.</p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Select First Position <span class="asterisk">*</span></label>
                                                            <select class="custom-select" id="s_first_position" name="s_first_position">
                                                                <option value="">Select First Position</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Select Second Position</label>
                                                            <select class="custom-select" id="s_second_position" name="s_second_position">
                                                                <option value="">Select Second Position</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Date Availability <span class="asterisk">*</span></label>
                                                            <input type="date" class="form-control" id="s_date_available" name="s_date_available">
                                                            <input type="hidden" class="form-control" id="r_type_crew" name="r_type_crew" value="NEW">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Source</label>
                                                            <select class="custom-select" id="s_source_location" name="s_source_location">
                                                                <option value="">Choose option</option>
                                                                <option value="1">Recommended</option>
                                                                <option value="2">Walk-In</option>
                                                                <option value="3">Others</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group" id="recommend" style="display: none;">
                                                            <label>Recommended By <span class="asterisk">*</span></label>
                                                            <input type="text" class="form-control" id="s_recommended_name" name="s_recommended_name" placeholder="Recommend By">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <center>
                                                            <div id="my_camera" style="display: none;"></div>
                                                            <img id="image-tag" width="300" height="241" src="<?= base_url(); ?>assets/images/avatar-placeholder.png">
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
                                                    <input type="text" class="form-control" id="s_first_name" name="s_first_name" placeholder="First name" onkeypress="return isAlphabet(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Middle Name </label>
                                                    <input type="text" class="form-control" id="s_middle_name" name="s_middle_name" placeholder="Middle Name" onkeypress="return isAlphabet(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Last Name <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" id="s_last_name" name="s_last_name" placeholder="Last Name" onkeypress="return isAlphabet(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Suffix</label>
                                                    <input type="text" class="form-control" id="s_suffix" name="s_suffixs_telephone_number" placeholder="Suffix" onkeypress="return isAlphabet(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Birth Date <span class="asterisk">*</span></label>
                                                    <input type="date" class="form-control" id="s_birth_date" name="s_birth_date">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Birth Place <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" id="s_birth_place" name="s_birth_place" placeholder="Birth Place">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Civil Status <span class="asterisk">*</span></label>
                                                    <select class="custom-select" id="s_civil_status" name="s_civil_status">
                                                        <option value="">Choose option</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Email Address </label>
                                                    <input type="email" class="form-control" id="s_email_address" name="s_email_address" placeholder="Email Address">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Telephone Number</label>
                                                    <input type="text" class="form-control" id="s_telephone_number" name="s_telephone_number" placeholder="Telephone Number" maxlength="8" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Mobile Number </label>
                                                    <input type="text" class="form-control" id="s_mobile_number" name="s_mobile_number" placeholder="Mobile Number" maxlength="11" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Religion </label>
                                                    <select class="custom-select" id="s_religion" name="s_religion">
                                                        <option value="">Choose option</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Nationality <span class="asterisk">*</span></label>
                                                    <select class="custom-select" id="s_nationality" name="s_nationality">
                                                        <option value="">Choose option</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>SSS No. </label>
                                                    <input type="text" class="form-control" id="s_sss_no" name="s_sss_no" placeholder="SSS No." maxlength="10" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>TIN No. </label>
                                                    <input type="text" class="form-control" id="s_tin_no" name="s_tin_no" placeholder="TIN No." minlength="9" maxlength="12" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Philhealth No. </label>
                                                    <input type="text" class="form-control" id="s_philhealth_no" name="s_philhealth_no" placeholder="Philhealth No." maxlength="12" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Pag-Ibig No. </label>
                                                    <input type="text" class="form-control" id="s_pag_ibig_no" name="s_pag_ibig_no" placeholder="Pag-Ibig No." maxlength="12" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Height (in cm) <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" id="s_height" name="s_height" placeholder="Height (in cm)" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Weight (in kg) <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" id="s_weight" name="s_weight" placeholder="Weight (in kg)" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>BMI <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" id="s_bmi" name="s_bmi" placeholder="BMI" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>House/Unit/Flr #, Bldg Name, Blk or Lot # <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" id="s_home_address" name="s_home_address" placeholder="House/Unit/Flr #, Bldg Name, Blk or Lot #">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Barangay</label>
                                                    <input type="text" class="form-control" id="s_barangay" name="s_barangay" placeholder="Barangay">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Province <span class="asterisk">*</span></label>
                                                    <select class="custom-select" id="s_province" name="s_province">
                                                        <option value="">Choose option</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>City / Municipality <span class="asterisk">*</span></label>
                                                    <select class="custom-select" id="s_city" name="s_city">
                                                        <option value="">Choose option</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Country <span class="asterisk">*</span></label>
                                                    <select class="custom-select" id="s_country" name="s_country">
                                                        <option value="Philippines">Philippines</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Zip Code </label>
                                                    <input type="text" class="form-control" id="s_zip_code" name="s_zip_code" placeholder="Zip Code" maxlength="4" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Provincial</label>
                                                    <input type="text" class="form-control" id="s_provincial" name="s_provincial" placeholder="Provincial">
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
                                                    <input type="text" class="form-control" id="s_spouse_name" name="s_spouse_name" placeholder="Spouse Name">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Occupation </label>
                                                    <input type="text" class="form-control" id="s_occupation" name="s_occupation" placeholder="Occupation">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>No. of Children </label>
                                                    <select class="custom-select" id="s_no_of_children" name="s_no_of_children">
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
                                                    <label>Father's Name </label>
                                                    <input type="text" class="form-control" id="s_father_name" name="s_father_name" placeholder="Father's Name">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Mother's Name </label>
                                                    <input type="text" class="form-control" id="s_mother_name" name="s_mother_name" placeholder="Mother's Name">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Address <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" id="s_kin_address" name="s_kin_address" placeholder="Address">
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
                                                    <input type="text" class="form-control" id="s_course" name="s_course" placeholder="Course">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>School <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" id="s_school_name" name="s_school_name" placeholder="School">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Inclusive Date From <span class="asterisk">*</span></label>
                                                    <input type="date" class="form-control" id="s_inclusive_years_from" name="s_inclusive_years_from">
                                                    <small>Ex. 01/01/<?= date("Y"); ?></small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Inclusive Date To <span class="asterisk">*</span></label>
                                                    <input type="date" class="form-control" id="s_inclusive_years_to" name="s_inclusive_years_to">
                                                    <small>Ex. 02/01/<?= date("Y"); ?></small>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>School Address </label>
                                                    <input type="text" class="form-control" id="s_school_address" name="s_school_address" placeholder="School Address">
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
                                                    <input type="text" class="form-control" id="s_cover_all" name="s_cover_all" placeholder="Cover All" onkeypress="return isAlphabet(event)">
                                                    <small>Specify sizes if S / M / L / XL / XXL</small>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Winter Jacket </label>
                                                    <input type="text" class="form-control" id="s_winter_jacket" name="s_winter_jacket" placeholder="Winter Jacket" onkeypress="return isAlphabet(event)">
                                                    <small>Specify sizes if S / M / L / XL / XXL</small>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Shoes (in cms) </label>
                                                    <input type="text" class="form-control" id="s_shoes" name="s_shoes" placeholder="Shoes (in cms)" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Winter Boots (bms) </label>
                                                    <input type="text" class="form-control" id="s_winter_boots" name="s_winter_boots" placeholder="Winter Boots (bms)" onkeypress="return isNumberKey(event)">
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
                                            <div class="col-md-12">
                                                <center>
                                                    <em class="text-muted font-20">Please select first your desire <span class="text-underline">"Rank"</span> to display your license requirements.</em>
                                                </center>
                                            </div>
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
                                            <div class="col-md-12">
                                                <center>
                                                    <em class="text-muted font-20">Please select first your desire <span class="text-underline">"Rank"</span> to display your training certification requirements.</em>
                                                </center>
                                            </div>
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
                                                    <button type="submit" class="btn btn-success" id="btn_submit">Submit Your Application</button>
                                                </div>
                                                <div class="float-left">
                                                    <button type="button" class="btn btn-secondary button-previous">Previous</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer footer-alt">
    Copyright © <script type="text/javascript">
        document.write(new Date().getFullYear());
    </script> Alphera - ERP Web System. Developed by <a href="javascript:void(0)">Springboard Philippines</a>
</footer>

<script type="text/javascript" src="<?= base_url('assets/custom/js/shipboard_application.min.js') ?>"></script>