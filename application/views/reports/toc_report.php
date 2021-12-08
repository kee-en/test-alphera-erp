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
                                <li class="breadcrumb-item"> TOC Report</li>
                            </ol>
                        </div>
                        <h4 class="page-title"> TOC Report</h4>
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
                                    <p class="text-alphera font-20 m-0">TOC Report</p>
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
                                    <label>Rank / Position <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="custom-select" id="toc_rank_filter" name="toc_rank_filter">
                                            <option value="">Select Rank / Position</option>
                                            <option value="">All Rank / Position</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary ml-1">Generate Report</button>
                                            <button type="reset" class="btn btn-secondary ml-1" onclick="resetForm()">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered m-0 text-center">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th rowspan="2">Rank</th>
                                                    <th colspan="6">TOC for Ex-Crew</th>
                                                    <th colspan="6">TOC for New Crew</th>
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row mb-5">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0"> TOC Report</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="toc_report_form" enctype="application/x-www-form-urlencoded">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Position:</label>
                                                <select class="custom-select" id="toc_rank_filter" name="toc_rank_filter">
                                                    <option value="">Select Rank</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btnGenerate">Generate Report</button>
                                        <button type="button" class="btn btn-secondary" id="BtnReset" onclick="resetForm()">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Ex-crew Data Count</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="page-title"> Current Year</h4>
                                    <?php if($show_result0): ?>
                                        <ul>
                                        <?php foreach($show_result0 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="page-title"> Last Year</h4>
                                    <?php if($show_result1): ?>
                                        <ul>
                                        <?php foreach($show_result1 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="page-title"> Last 2years</h4>
                                    <?php if($show_result2): ?>
                                        <ul>
                                        <?php foreach($show_result2 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="page-title"> Last 3years</h4>
                                    <?php if($show_result3): ?>
                                        <ul>
                                        <?php foreach($show_result3 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="page-title"> Last 4years</h4>
                                    <?php if($show_result4): ?>
                                        <ul>
                                        <?php foreach($show_result4 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="page-title"> Last 5years</h4>
                                    <?php if($show_result5): ?>
                                        <ul>
                                        <?php foreach($show_result5 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">New Hire Data Count</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="page-title"> Current Year</h4>
                                    <?php if($nh_show_result0): ?>
                                        <ul>
                                        <?php foreach($nh_show_result0 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="page-title"> Last Year</h4>
                                    <?php if($nh_show_result1): ?>
                                        <ul>
                                        <?php foreach($nh_show_result1 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="page-title"> Last 2years</h4>
                                    <?php if($nh_show_result2): ?>
                                        <ul>
                                        <?php foreach($nh_show_result2 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="page-title"> Last 3years</h4>
                                    <?php if($nh_show_result3): ?>
                                        <ul>
                                        <?php foreach($nh_show_result3 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="page-title"> Last 4years</h4>
                                    <?php if($nh_show_result4): ?>
                                        <ul>
                                        <?php foreach($nh_show_result4 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="page-title"> Last 5years</h4>
                                    <?php if($nh_show_result5): ?>
                                        <ul>
                                        <?php foreach($nh_show_result5 as $key): ?>
                                            <li><?= $key['position_name'] ?></li>
                                            <li><?= $key['remarks'] ?>: <?= $key['toc_count'] ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <li>No TOC data for now</li>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> -->
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/javascript/toc_report.js'); ?>"></script>