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
                                <li class="breadcrumb-item"> Manage Users</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Manage Users</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-alphera font-20 m-0">List of Accounts</p>
                                </div>

                                <div class="col-md-6 text-lg-right">
                                    <a href="<?= base_url('register-user')?>"><button type="button" class="btn btn-primary"><i class="mdi mdi-plus"></i> Add New User</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-0 table-centered table-bordered" id="accounts_table">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Full Name</th>
                                                    <th>Username</th>
                                                    <th>User Type</th>
                                                    <th>Date Created</th>
                                                    <th>Last login Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
    
                                            <tbody>
    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CHANGE USER ACCESS MODAL -->
    <div class="modal fade" id="change_user_access_modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <form action="javascript:void(0)" id="update_user_access_form" name="update_user_access_form" enctype="application/x-www-form-urlencoded">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-alphera font-18 m-0" id="user_name"></h4>
                        <button type="button" id="modalClose" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>User Type <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="e_user_type" name="e_user_type">
                                                <option value="">Choose option</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Full Name <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Full Name" id="e_full_name" name="e_full_name" readonly>
                                            <input type="hidden" class="form-control" id="e_user_code" name="e_user_code">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Username <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Username" id="e_username" name="e_username" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Email Address <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Email Address" id="e_email_address" name="e_email_address" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Phone Number <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Phone Number" id="e_phone_number" name="e_phone_number" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Password <span class="asterisk">*</span></label>
                                            <input type="password" class="form-control" placeholder="Password" id="e_Password" name="e_Password" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera" id="update_user_access">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END CHANGE USER ACCESS MODAL -->

    <div class="modal fade" id="change_user_password_modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <form action="javascript:void(0)" id="update_user_password_form" name="update_user_password_form" enctype="application/x-www-form-urlencoded">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-alphera font-18 m-0" id="cp_user_name">Change Password</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Full Name </label>
                                    <input type="text" class="form-control" placeholder="Full Name" id="p_full_name" name="p_full_name" readonly>
                                    <input type="hidden" class="form-control" id="p_user_code" name="p_user_code">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Username </label>
                                    <input type="text" class="form-control" placeholder="Username" id="p_username" name="p_username" readonly>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email Address </label>
                                    <input type="text" class="form-control" placeholder="Email Address" id="p_email_address" name="p_email_address" readonly>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Phone Number </label>
                                    <input type="text" class="form-control" placeholder="Phone Number" id="p_phone_number" name="p_phone_number" readonly>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Password <span class="asterisk">*</span></label>
                                    <input type="password" class="form-control" placeholder="Password" id="p_password" name="p_password">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Confirm Password <span class="asterisk">*</span></label>
                                    <input type="password" class="form-control" placeholder="Confirm Password" id="p_confirm_password" name="p_confirm_password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera" id="update_user_access">Update</button>
                        <button type="button" id="CloseChangePass" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/manage_users.js') ?>"></script>