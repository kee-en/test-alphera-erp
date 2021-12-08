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
                                <li class="breadcrumb-item"> Dashboard</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h4 class="font-18 m-0">New Hire</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mt-1">
                                <div class="float-left" dir="ltr">
                                    <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#DE4A2D " data-bgColor="#E46E56" value="<?= $new_applicant ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                </div>
                                <div class="text-right">
                                    <h2 class="m-0"> <?= $new_applicant ?> </h2>
                                    <p class="text-muted mb-0">Total No. Of New Hire Deployed</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">EMBARKED</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mt-1">
                                <div class="float-left" dir="ltr">
                                    <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#1B834A" data-bgColor="#76B492" value="<?= $embark ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                </div>
                                <div class="text-right">
                                    <h2 class="m-0"> <?= $embark ?> </h2>
                                    <p class="text-muted mb-0">Total No. Of Embarked Crew</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h4 class="font-18 m-0">Ex-Crew</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mt-1">
                                <div class="float-left" dir="ltr">
                                    <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#675db7" data-bgColor="#e8e7f4" value="<?= $ex_crew ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                </div>
                                <div class="text-right">
                                    <h2 class="m-0"> <?= $ex_crew ?> </h2>
                                    <p class="text-muted mb-0">Total No. Of Ex-Crew Deployed</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h4 class="font-18 m-0">On-Vacation</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mt-1">
                                <div class="float-left" dir="ltr">
                                    <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#f44336" data-bgColor="#f8aca7" value="<?= $on_vacation ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                </div>
                                <div class="text-right">
                                    <h2 class="m-0"> <?= $on_vacation ?> </h2>
                                    <p class="text-muted mb-0">Total No. Of On-Vacation</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">Medical Repatriation</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mt-1">
                                <div class="float-left" dir="ltr">
                                    <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#ffbd4a" data-bgColor="#FFE6BA" value="<?= $medical ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                </div>
                                <div class="text-right">
                                    <h2 class="m-0"> <?= $medical ?> </h2>
                                    <p class="text-muted mb-0">Total No. Of Medical Repatriation</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">TOC</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mt-1">
                                <div class="float-left" dir="ltr">
                                    <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#56c2d6" data-bgColor=#9fdeea value="0" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                </div>
                                <div class="text-right">
                                    <h2 class="m-0"> 0 </h2>
                                    <p class="text-muted mb-0">Total No. Of TOC</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">On-Vacation w/ TOC</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mt-1">
                                <div class="float-left" dir="ltr">
                                    <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#5089de" data-bgColor="#5c9bfa" value="<?= $nre ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                </div>
                                <div class="text-right">
                                    <h2 class="m-0" id="for_toc"></h2>
                                    <p class="text-muted mb-0">Total No. Of On-Vaction w/ TOC</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">NRE</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mt-1">
                                <div class="float-left" dir="ltr">
                                    <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#e36498" data-bgColor="#f8abcb" value="<?= $nre ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" />
                                </div>
                                <div class="text-right">
                                    <h2 class="m-0"> <?= $nre ?> </h2>
                                    <p class="text-muted mb-0">Total No. Of NRE</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">Status of Licenses</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-1 text-center">
                                <div class="col-6">
                                    <h2 class="m-0" id="lics_expired">0</h2>
                                    <p class="text-muted mb-0">Total No. Of Expired</p>
                                </div>

                                <div class="col-6">
                                    <h2 class="m-0" id="lics_valid">0</h2>
                                    <p class="text-muted mb-0">Total No. Of 90 day(s)</p>
                                </div>

                                <div class="col-6 mt-2">
                                    <h2 class="m-0" id="lics_days60">0</h2>
                                    <p class="text-muted mb-0">Total No. Of 60 day(s)</p>
                                </div>

                                <div class="col-6 mt-2">
                                    <h2 class="m-0" id="lics_days30">0</h2>
                                    <p class="text-muted mb-0">Total No. Of 30 day(s)</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <a href="<?= base_url('manage-prejoining') ?>"><p class="font-weight-medium font-16 m-0 text-alphera">View More</p></a>
                                </div>
                                <div class="col text-right">
                                    <a href="<?= base_url('manage-prejoining') ?>"><p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <div class="col-xl-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">Status of Training Certficates</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-1 text-center">
                                <div class="col-6">
                                    <h2 class="m-0" id="valid">0</h2>
                                    <p class="text-muted mb-0">Total No. Of Expired</p>
                                </div>

                                <div class="col-6">
                                    <h2 class="m-0" id="expired">0</h2>
                                    <p class="text-muted mb-0">Total No. Of 90 day(s)</p>
                                </div>

                                <div class="col-6 mt-2">
                                    <h2 class="m-0" id="days60">0</h2>
                                    <p class="text-muted mb-0">Total No. Of 60 day(s)</p>
                                </div>

                                <div class="col-6 mt-2">
                                    <h2 class="m-0" id="days30">0</h2>
                                    <p class="text-muted mb-0">Total No. Of 30 day(s)</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <a href="<?= base_url('manage-prejoining') ?>"><p class="font-weight-medium font-16 m-0 text-alphera">View More</p></a>
                                </div>
                                <div class="col text-right">
                                    <a href="<?= base_url('manage-prejoining') ?>"><p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">Total No. Contract Duration</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="total_crew_onboard" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">Joining Crew PEME</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="crew_peme" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">Recruitment Performance Report</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="apex-donut-1" class="apex-charts"></div>
                                </div>
                                <div class="col-md-6">
                                    <div id="apex-donut-3" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><a href="<?= base_url('recruitment-performance') ?>">View More</a></p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8">
                                    <h4 class="font-18 m-0">Recruitment Performance Report Per Rank</h4>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-20 m-0 text-muted"><i class="mdi mdi-help-circle-outline"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="apex-donut-2" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <p class="font-weight-medium font-16 m-0 text-alphera">View More</p>
                                </div>
                                <div class="col text-right">
                                    <p class="font-weight-medium font-16 m-0 text-alphera"><i class="mdi mdi-arrow-right"></i></p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div> -->

            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/javascript/admin_dashboard.js'); ?>"></script>