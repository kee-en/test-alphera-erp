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
                                <li class="breadcrumb-item"> <a href="#">Users</a></li>
                                <li class="breadcrumb-item"> Register User</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Register User</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Register User</p>
                        </div>
                        <form action="javascript:void(0)" id="add_user_type_form" name="add_user_type_form" enctype="application/x-www-form-urlencoded">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="text-alphera font-18 mt-0 mb-1">I. Add New User</p>
                                                <p class="text-muted m-0">Fill up the required fields below.</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>User Type <span class="asterisk">*</span></label>
                                                    <select class="custom-select" id="user_type" name="user_type">
                                                        <option value="">Choose option</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Full Name <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Full Name" id="full_name" name="full_name">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Username <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Username" id="username" name="username">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Email Address <span class="asterisk">*</span></label>
                                                    <input type="email" class="form-control" placeholder="Email Address" id="email_address" name="email_address">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Phone Number <span class="asterisk">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Phone Number" id="phone_number" name="phone_number" maxlength="11" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Password <span class="asterisk">*</span></label>
                                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Confirm Password <span class="asterisk">*</span></label>
                                                    <input type="password" class="form-control" placeholder="Confirm Password" id="confirm_password" name="confirm_password">
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="text-alphera font-18 mt-0 mb-1">II. Add User Responsibility</p>
                                                <p class="text-muted m-0">Put a check mark on the check boxes to set up user responsibility of the user.</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row" id="responsibility_list">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Add User</button>
                                        <button type="reset" id="BtnReset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/register_user.js') ?>"></script>