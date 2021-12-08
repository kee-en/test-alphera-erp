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
                                <li class="breadcrumb-item"> Crew Grade Report</li>
                            </ol>
                        </div>
                        <h4 class="page-title"> Crew Grade Report</h4>
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
                                    <p class="text-alphera font-20 m-0">Crew Grade Report</p>
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
                                        <select class="custom-select" id="nre_rank_filter" name="nre_rank_filter">
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
                                                    <th colspan="5">Poor Evaluation Rate for Ex-Crew</th>
                                                    <th colspan="5">Poor Evaluation Rate for New Crew</th>
                                                </tr>

                                                <tr>
                                                    <th>S</th>
                                                    <th>A</th>
                                                    <th>B</th>
                                                    <th>C</th>
                                                    <th>D</th>

                                                    <th>S</th>
                                                    <th>A</th>
                                                    <th>B</th>
                                                    <th>C</th>
                                                    <th>D</th>
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
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Total Percent (%)</th>
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

                                                <tr>
                                                    <th colspan="1">Total historical over the past years</th>
                                                    <th colspan="10">0</th>
                                                </tr>
                                            </tfoot>
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
                            <p class="text-alphera font-20 m-0"> Crew Grade Report Filters</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="crew_grade_form" enctype="application/x-www-form-urlencoded">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Crew Type: </label>
                                            <select class="custom-select" id="grade_crew_type" name="grade_crew_type">
                                                <option value="0">Select Crew Type</option>
                                                <option value="1">Ex-crew</option>
                                                <option value="2">New crew</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Rank:</label>
                                            <select class="custom-select" id="grade_rank" name="grade_rank">
                                                <option value="">Please Select a Rank</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Month range from: </label>
                                            <input type="month" class="form-control" placeholder="Month From" id="grade_month_from" name="grade_month_from">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Month range to: </label>
                                            <input type="month" class="form-control" placeholder="Month To" id="grade_month_to" name="grade_month_to">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Generate Report</button>
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
                            <p class="text-alphera font-20 m-0">Comparative Data Count</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Current Grade Count:</label>
                                    <div class="col-md-6" id="grade_count" name="grade_count">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Comparative Grade Count:</label>
                                    <div class="col-md-6" id="compara_count" name="compara_count">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/javascript/grade_report.js'); ?>"></script>