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
                                <li class="breadcrumb-item"> <a href="#">Manage Reports</a></li>
                                <li class="breadcrumb-item"> Medical Approval Report</li>
                            </ol>
                        </div>
                        <h4 class="page-title"> Medical Approval Report</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6 mt-1">
                                    <p class="text-alphera font-20 m-0">Medical Approval Report</p>
                                </div>

                                <div class="col-md-6 text-right">
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-secondary dropdown-toggle ml-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-download"></i> Download Report
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <h6 class="dropdown-header"><b>Download Report As</b></h6>
                                            <a class="dropdown-item" href="">CSV</a>
                                            <a class="dropdown-item" href="">EXCEL</a>
                                            <a class="dropdown-item" href="" target="_blank">PDF</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Medical Status <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="custom-select" id="mar_medical_status" name="mar_medical_status">
                                            <option value="">Select Medical Status</option>
                                            <option value="1">Onboard Crew - Pending Medical</option>
                                            <option value="2">Joining Crew - Medical Expired by 3 Months</option>
                                            <option value="3">Joining Crew - Approved Re-Medical</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary ml-1">Generate Report</button>
                                            <button type="reset" class="btn btn-secondary ml-1" onclick="resetForm()">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Onboard Crew - Pending Medical -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered m-0 text-center">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th rowspan="2">Rank</th>
                                                    <th colspan="6">Medical Status for Ex-Crew</th>
                                                    <th colspan="6">Medical Status for New Crew</th>
                                                </tr>

                                                <tr>
                                                    <th>Current Year</th>
                                                    <th>Last Year</th>
                                                    <th>Last 2 Years</th>
                                                    <th>Last 3 Years</th>
                                                    <th>Last 4 Years</th>
                                                    <th>Last 5 Years</th>

                                                    <th>Current Year</th>
                                                    <th>Last Year</th>
                                                    <th>Last 2 Years</th>
                                                    <th>Last 3 Years</th>
                                                    <th>Last 4 Years</th>
                                                    <th>Last 5 Years</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Master (MSTR)</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Joining Crew - Medical Expired by 3 months & Joining Crew - Approved Re-Medical -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered m-0 text-center">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Crew Name</th>
                                                    <th>Rank</th>
                                                    <th>Expiry Date</th>
                                                    <th>Medical Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>1</th>
                                                    <th>MARVIC B. TIFORA</th>
                                                    <th>Master (MSTR)</th>
                                                    <th>Nov 25, 2021</th>
                                                    <th>
                                                        <span class="text-success">VALID</span>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row mb-5">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0"> Medical Approval Report</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="medical_approval_report_form" enctype="application/x-www-form-urlencoded">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Medical Status: </label>
                                            <select class="custom-select" id="mar_medical_status" name="mar_medical_status">
                                                <option value="">Select Medical Status</option>
                                                <option value="1">Onboard Crew - Pending Medical</option>
                                                <option value="2">Joining Crew - Medical Expired by 3months</option>
                                                <option value="3">Joining Crew - Approved Re-Medical</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="select_crew_div" style="display: none;">
                                        <div class="form-group">
                                            <label>Crew Type: </label>
                                            <select class="custom-select" id="mar_crew_type" name="mar_crew_type">
                                                <option value="">Select Crew Type</option>
                                                <option value="1">Ex-crew</option>
                                                <option value="2">New crew</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Generate Report</button>
                                        <button type="reset" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">List of Logs</p>
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->userdata('mar_medical_search') == 1) : ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="page-title"> Current Year</h4>
                                        <?php if ($medicals0) : ?>
                                            <ul>
                                                <?php foreach ($medicals0 as $key) : ?>
                                                    <li><?= $key['position_name'] ?>: <?= $key['med_count'] ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <li>No Medical data for now</li>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="page-title"> Last Year</h4>
                                        <?php if ($medicals1) : ?>
                                            <ul>
                                                <?php foreach ($medicals1 as $key) : ?>
                                                    <li><?= $key['position_name'] ?>: <?= $key['med_count'] ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <li>No Medical data for now</li>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="page-title"> Last 2years</h4>
                                        <?php if ($medicals2) : ?>
                                            <ul>
                                                <?php foreach ($medicals2 as $key) : ?>
                                                    <li><?= $key['position_name'] ?>: <?= $key['med_count'] ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <li>No Medical data for now</li>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="page-title"> Last 3years</h4>
                                        <?php if ($medicals3) : ?>
                                            <ul>
                                                <?php foreach ($medicals3 as $key) : ?>
                                                    <li><?= $key['position_name'] ?>: <?= $key['med_count'] ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <li>No Medical data for now</li>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="page-title"> Last 4years</h4>
                                        <?php if ($medicals4) : ?>
                                            <ul>
                                                <?php foreach ($medicals4 as $key) : ?>
                                                    <li><?= $key['position_name'] ?>: <?= $key['med_count'] ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <li>No Medical data for now</li>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="page-title"> Last 5years</h4>
                                        <?php if ($medicals5) : ?>
                                            <ul>
                                                <?php foreach ($medicals5 as $key) : ?>
                                                    <li><?= $key['position_name'] ?>: <?= $key['med_count'] ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <li>No Medical data for now</li>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php elseif ($this->session->userdata('mar_medical_search') == 2) : ?>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-0 table-centered table-bordered">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Crewname</th>
                                                    <th>Medical Status</th>
                                                    <th>Expiry Status</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php if ($joining_expired) : ?>
                                                    <?php $count = 0;
                                                    foreach ($joining_expired as $row) : ?>
                                                        <?php if ($row['medical_status'] == 1) {
                                                            $status = "PENDING";
                                                        } else if ($row['medical_status'] == 2) {
                                                            $status = "FIT FOR SEA DUTY";
                                                        } else {
                                                            $status = "WITH APPROVAL";
                                                        } ?>

                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= $row['full_name'] ?></td>
                                                            <td><?= $status ?></td>
                                                            <td><?= $this->medical->get_medical_validity_table($row['crew_code']) ?></td>
                                                        </tr>
                                                    <?php $count++;
                                                    endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td class="text-center" colspan="4">There are no data to display</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php elseif ($this->session->userdata('mar_medical_search') == 3) : ?>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-0 table-centered table-bordered">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Crewname</th>
                                                    <th>Medical Status</th>
                                                    <th>Expiry Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($joining_expired) : ?>
                                                    <?php $count = 0;
                                                    foreach ($joining_expired as $row) : ?>
                                                        <?php if ($row['medical_status'] == 1) {
                                                            $status = "PENDING";
                                                        } else if ($row['medical_status'] == 2) {
                                                            $status = "FIT FOR SEA DUTY";
                                                        } else {
                                                            $status = "WITH APPROVAL";
                                                        } ?>
                                                        <tr>
                                                            <td><?= $count ?></td>
                                                            <td><?= $row['full_name'] ?></td>
                                                            <td><?= $status ?></td>
                                                            <td><?= $this->medical->get_medical_validity_table($row['crew_code']) ?></td>
                                                        </tr>
                                                    <?php $count++;
                                                    endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td class="text-center" colspan="4">There are no data to display</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="page-title"> Select a report category</h4>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/javascript/medical_approval_report.js'); ?>"></script>