    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fe-bell noti-icon"></i>
                            <span class="badge badge-danger rounded-circle noti-icon-badge">5</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0 text-white">
                                    <span class="float-right">
                                        <a href="" class="text-light">
                                            <small>Clear All</small>
                                        </a>
                                    </span>Notification
                                </h5>
                            </div>

                            <div class="slimscroll noti-scroll">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                    <div class="notify-icon">
                                        <img src="assets/images/users/user-1.jpg" class="img-fluid rounded-circle" alt="" />
                                    </div>
                                    <p class="notify-details">Cristina Pride</p>
                                    <p class="text-muted mb-0 user-msg">
                                        <small>Hi, How are you? What about our next meeting</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-primary">
                                        <i class="mdi mdi-comment-account-outline"></i>
                                    </div>
                                    <p class="notify-details">Caleb Flakelar commented on Admin
                                        <small class="text-muted">1 min ago</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon">
                                        <img src="assets/images/users/user-4.jpg" class="img-fluid rounded-circle" alt="" />
                                    </div>
                                    <p class="notify-details">Karen Robinson</p>
                                    <p class="text-muted mb-0 user-msg">
                                        <small>Wow ! this admin looks good and awesome design</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-warning">
                                        <i class="mdi mdi-account-plus"></i>
                                    </div>
                                    <p class="notify-details">New user registered.
                                        <small class="text-muted">5 hours ago</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-info">
                                        <i class="mdi mdi-comment-account-outline"></i>
                                    </div>
                                    <p class="notify-details">Caleb Flakelar commented on Admin
                                        <small class="text-muted">4 days ago</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-secondary">
                                        <i class="mdi mdi-heart"></i>
                                    </div>
                                    <p class="notify-details">Carlos Crouch liked
                                        <b>Admin</b>
                                        <small class="text-muted">13 days ago</small>
                                    </p>
                                </a>
                            </div>

                            <!-- All-->
                            <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                View all
                                <i class="fi-arrow-right"></i>
                            </a>

                        </div>
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="<?= base_url('assets/images/avatar-placeholder.png') ?>" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ml-1 font-weight-medium">
                                Hi, <span class="text-alphera"><?= $this->session->userdata('full_name') ?></span> <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <a href="<?= base_url('my-account') ?>" class="dropdown-item notify-item">
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <span>Help / FAQs</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" onclick="accountLogout()" class="dropdown-item notify-item">
                                <span>Sign Out</span>
                            </a>

                        </div>
                    </li>

                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="javascript:void(0);" class="logo text-center">
                        <span class="logo-lg">
                            <img src="<?= base_url() ?>assets/images/alphera/alphera_logo.png" alt="" height="45">
                        </span>
                        <span class="logo-sm">
                            <img src="<?= base_url() ?>assets/images/alphera/alphera_logo_sm.png" alt="" height="32">
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </li>
                </ul>
            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="slimscroll-menu">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <li class="menu-title">General Menu</li>

                            <li class="">
                                <a href="<?= base_url('dashboard') ?>">
                                    <i class="la la-bar-chart"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>

                            <li class="">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#select_application_type">
                                    <i class="la la-list"></i>
                                    <span> Add New Application </span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="la la-users"></i>
                                    <span> Recruitment </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level nav" aria-expanded="false">
                                    <li>
                                        <a href="<?= base_url('registered-applicants') ?>">
                                            <span> - Registered Applicants </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('pending-applicants') ?>">
                                            <span> - Pending </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('for-interview') ?>">
                                            <span> - For Interview </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('for-approval') ?>">
                                            <span> - Principal Approval </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('passed-applicants') ?>">
                                            <span> - Passed </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('not-qualified') ?>">
                                            <span> - Not Qualified </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('reserved-applicants') ?>">
                                            <span> - Reserved Applicants </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="la la-users"></i>
                                    <span> Crew </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level nav" aria-expanded="false">
                                    <li>
                                        <a href="<?= base_url('crew-management-plan') ?>"> - Manage CM Plan</a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);" aria-expanded="false"> - Crew List
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-third-level nav" aria-expanded="false">
                                            <li>
                                                <a href="<?= base_url('all-crew') ?>"> - All Crew</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('new-crew') ?>"> - New Crew</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('ex-crew') ?>"> - Ex Crew</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('nre-crew') ?>"> - NRE Crew</a>
                                            </li>
                                            <!-- <li>
                                                <a href="<?= base_url('withdrawal-crew') ?>"> - Withdrawal (TOC)</a>
                                            </li> -->
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('manage-prejoining') ?>"> - Pre-Joining Monitoring</a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);" aria-expanded="false"> - Crew Monitoring
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-third-level nav" aria-expanded="false">
                                            <li>
                                                <a href="<?= base_url('pre-joining-visa') ?>"> - Pre-joining & Visa</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('contracts') ?>"> - Contracts</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('medical') ?>"> - Medical</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('for-onboarding') ?>"> - For Onboarding</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('flight-monitoring') ?>"> - Flight Monitoring</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('crew-embarked') ?>"> - Embarked</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('crew-disembarked') ?>"> - Disembarked</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('for-reporting') ?>"> - For Reporting</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('crew-promotion') ?>"> - Crew Promotion</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('crew-watchlisted') ?>"> - Watchlisted</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('crew-warning-letter') ?>"> - Warning Letter</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('withdrawal') ?>"> - Withdrawal (TOC)</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin-approval') ?>"> - For Approval</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="la la-ship"></i>
                                    <span> Vessels </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level nav" aria-expanded="false">
                                    <li>
                                        <a href="<?= base_url('manage-vessel') ?>"> - Manage Vessels</a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);" aria-expanded="false" -> - Settings
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-third-level nav" aria-expanded="false">
                                            <li>
                                                <a href="<?= base_url('type-of-vessel') ?>"> - Type of Vessels</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('type-of-engine') ?>"> - Type of Engine</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('archive-vessel') ?>"> - Archive Vessels</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="la la-users"></i>
                                    <span> Users </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level nav" aria-expanded="false">
                                    <li>
                                        <a href="<?= base_url('manage-users') ?>"> - Manage Users</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('register-user') ?>"> - Register User</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('user-responsibility') ?>"> - User Responsibility</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('user-group') ?>"> - User Group</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="la la-file"></i>
                                    <span> Manage Reports </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level nav" aria-expanded="false">
                                    <li>
                                        <a href="<?= base_url('cmp-summary') ?>"> - Crew Management Plan (Summary)</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('crew-daily-departure') ?>"> - Crew Daily Departure</a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <span> - Crew Monitoring </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level nav" aria-expanded="false">
                                            <li>
                                                <a href="<?= base_url('prejoining-monitoring') ?>"> - Prejoining Monitoring</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('us-visa-status') ?>"> - US Visa Status</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('medical-monitoring') ?>"> - Medical Monitoring</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('list-signers') ?>"> - ON-OFF Signers</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('panama-monitoring') ?>"> - Panama Monitoring</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('marshall-monitoring') ?>"> - Marshall Monitoring</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('repatriation-report') ?>"> - Repatriation Monitoring</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('illness-injury-report') ?>"> - Illness/Injury Rate Monitoring</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('warning-letter-report') ?>"> - Warning Letter Report</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('crew-grade-report') ?>"> - Crew grade report</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('vessel-report') ?>"> - Vessel report</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('toc-report') ?>"> - TOC report</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('nre-report') ?>"> - NRE report</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('medical-approval-report') ?>"> - Medical Approval Report</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('promotion-list-report') ?>"> - Promotion List Report</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('crew-shortage-report') ?>"> - Crew Shortage Report</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('evaluation-rate-report') ?>"> - Evaluation Rate Report</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="la la-cog"></i>
                                    <span> System Configuration </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level nav" aria-expanded="false">
                                    <li>
                                        <a href="<?= base_url('audit-trail') ?>"> - Audit Trail</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('backup-db') ?>"> - Backup Database</a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <span> - Requirements </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level nav" aria-expanded="false">
                                            <li>
                                                <a href="<?= base_url('training-certificate') ?>"> - Training Certificate</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('licenses') ?>"> - Licenses, etc.</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <span> - Position </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level nav" aria-expanded="false">
                                            <li>
                                                <a href="<?= base_url('manage-requirements') ?>"> - Manage Certificates</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('manage-licenses') ?>"> - Manage Licenses</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('position') ?>"> - Add Position / Rank</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <span> - Points of Interview Form </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level nav" aria-expanded="false">
                                            <li>
                                                <a href="<?= base_url('manage-points-of-interview') ?>"> - Manage G/T Form</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('points-interview-form') ?>"> - Add Points of Interview</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('evaluation-sheet') ?>"> - Evaluation Sheet</a>
                                    </li>
                                    <!-- <li>
                                        <a href="<?= base_url('watchlisted-reasons') ?>"> - Watchlisted Reasons</a>
                                    </li> -->
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="la la-lock"></i>
                                    <span> Developer </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level nav" aria-expanded="false">
                                    <li>
                                        <a href="<?= base_url('module') ?>"> - Module</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('sub-module') ?>"> - Sub Module</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('node') ?>"> - Node</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->

            <div class="modal fade" id="select_application_type" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <img src="<?= base_url('assets/images/alphera/icons/click.png') ?>" width="100" height="100" alt="">
                                <h4 class="mb-1">Select Shipboard Application Form</h4>
                                <p class="text-muted mb-3">You can create a new application for an <span class="text-underline">Applicant</span> or add the <span class="text-underline">Existing Crew</span> information by selecting the application type below:</p>
                            </div>

                            <div class="col-md-6">
                                <a href="<?= base_url('create-new-application'); ?>">
                                    <div class="card app_type">
                                        <div class="card-body">
                                            <h4 class="header-title text-default m-0">Applicant <br> (Recruitment)</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6">
                                <a href="<?= base_url('crew-existing-application-form'); ?>">
                                    <div class="card app_type">
                                        <div class="card-body">
                                            <h4 class="header-title text-default m-0">Crew <br> (Exisiting Crew)</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>