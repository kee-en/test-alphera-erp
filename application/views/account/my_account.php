<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"> <a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item"> My Account</li>
                            </ol>
                        </div>
                        <h4 class="page-title">My Account</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-alphera font-18 mt-0 mb-1">Edit Personal Information</p>

                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <p class="text-muted font-13">
                                        Enter your full name and active mobile number. You can change your basic information at any time.
                                    </p>
                                </div>
                                <div class="col-md-5">
                                    <form action="javascript:void(0)" id="personal_info_form" name="personal_info_form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>User Code </label>
                                                    <input type="text" class="form-control" id="user_code" name="user_code" placeholder="User Code" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Full Name <span class="text-alphera">*</span></label>
                                                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone Number <span class="text-alphera">*</span></label>
                                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" maxlength="11">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-alphera">Save Changes</button>
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <img src="<?= base_url('assets/images/avatar-placeholder.png') ?>" alt="user-image" class="rounded-circle" width="150" height="150">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <p class="text-alphera font-18 mt-0 mb-1">View Email Address / Username</p>

                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <p class="text-muted font-13">
                                        Your primary email address and username is not editable.
                                    </p>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email Address </label>
                                                <input type="text" class="form-control" id="email_address" name="email_address" placeholder="Email Address" value="<?= $this->session->userdata('email_address') ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Username </label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <p class="text-alphera font-18 mt-0 mb-1">Change Password</p>

                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <p class="text-muted font-13">
                                        Create a strong password and don't reuse it for other accounts. Changing your password will sign you out of all your devices.
                                    </p>
                                </div>
                                <div class="col-md-5">
                                    <form action="javascript:void(0)" id="password_form" name="password_form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Current Password <span class="text-alphera">*</span></label>
                                                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>New Password <span class="text-alphera">*</span></label>
                                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Confirm Password <span class="text-alphera">*</span></label>
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-alphera">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: base_url + "get-account-details",
                type: 'post',
                success: function(data) {

                    $('#user_code').val(data.user_code);
                    $('#full_name').val(data.full_name);
                    $('#phone_number').val(data.phone_number);
                    $('#username').val(data.username);
                }
            });
        });
    </script>