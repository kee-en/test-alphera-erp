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
                                <li class="breadcrumb-item">Marshall Monitoring Record</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Marshall Monitoring Record</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Marshall Monitoring Record</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form method="POST" action="print-marshall-monitoring" id="manage_reports_form" enctype="application/x-www-form-urlencoded">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Type of Report</label>
                                            <select class="custom-select" id="r_filter_by_type" name="r_filter_by_type">
                                                <option value="6" selected>Marshall Monitoring Record</option>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Type of License <span class="text-alphera">*</span></label>
                                            <select class="custom-select" id="r_type_of_license" name="r_type_of_license">
                                                <option value="1">SBOOK, ENDORSEMENT & GMDSS License</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Expiry Date From </label>
                                            <input type="date" class="form-control" placeholder="Date From" id="r_expiry_date_from" name="r_expiry_date_from">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Expiry Date To </label>
                                            <input type="date" class="form-control" placeholder="Date To" id="r_expiry_date_to" name="r_expiry_date_to">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btnGenerate" onclick="GenerateMarshallReport();">Generate</button>
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
                                            <?php if ($marshall_logs): ?>
                                                    <?php foreach ($marshall_logs as $row): ?>
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
    <script type="text/javascript" src="<?= base_url('assets/javascript/marshall_monitoring.js'); ?>"></script>