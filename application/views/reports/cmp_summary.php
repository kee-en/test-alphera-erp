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
                                <li class="breadcrumb-item"> Crew Management Plan (Summary)</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Crew Management Plan (Summary)</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Crew Management Plan (Summary)</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="manage_reports_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Type of Report</label>
                                            <select class="custom-select" id="r_filter_by_type" name="r_filter_by_type">
                                                <option value="1" selected>Crew Management Plan (Summary)</option>
                                                <!-- <option value="2">Daily Crew Departure Report</option>
                                                <option value="3">Daily Crew Change Report</option>
                                                <option value="4">ON-OFF Signer</option>
                                                <option value="5">PANAMA Monitoring Report</option>
                                                <option value="6">Ratings 10yrs Experience</option>
                                                <option value="7">Prejoining Monitoring</option>
                                                <option value="8">US Visa Status (On Vacation Crew)</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Rank / Position <span class="text-alphera">*</span></label>
                                            <select class="custom-select" id="r_filter_by_pos" name="r_filter_by_pos">
                                                <option value="">Select Rank / Position</option>
                                                <option value="all">All Rank / Position</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Vessel <span class="text-alphera">*</span></label>
                                            <select class="custom-select" id="r_filter_by_vessel" name="r_filter_by_vessel">
                                                <option value="">Select Vessel</option>
                                                <option value="all">All Vessel</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sign On Date From </label>
                                            <input type="date" class="form-control" placeholder="Date From" id="r_signon_date_from" name="r_signon_date_from">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sign On Date To </label>
                                            <input type="date" class="form-control" placeholder="Date To" id="r_signon_date_to" name="r_signon_date_to">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contract Date From </label>
                                            <input type="date" class="form-control" placeholder="Date From" id="r_contract_date_from" name="r_contract_date_from">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contract Date To </label>
                                            <input type="date" class="form-control" placeholder="Date To" id="r_contract_date_to" name="r_contract_date_to">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btnGenerate" onclick="GenerateCMPReport()">Generate</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-0 table-centered table-bordered">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Type of Report</th>
                                                    <th>Action By</th>
                                                    <th>Date Created</th>
                                                </tr>
                                            </thead>
    
                                            <tbody>
                                                <?php if ($cmp_logs) : ?>
                                                    <?php foreach ($cmp_logs as $row) : ?>
                                                        <tr>
                                                            <td><?= $row['id'] ?></td>
                                                            <td><?= $row['report_type'] ?></td>
                                                            <td><?= $this->global->GetAsessorFullName($row['action_by'])->fullname ?></td>
                                                            <td><?= date('F j, Y', strtotime($row['date_created'])) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td class="text-center" colspan="4">There are no data to display</td>
                                                    </tr>
                                                <?php endif; ?>
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
    <script type="text/javascript" src="<?= base_url('assets/javascript/cmp_summary.js'); ?>"></script>