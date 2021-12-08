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
                                <li class="breadcrumb-item"> Illness/Injury Rate Report</li>
                            </ol>
                        </div>
                        <h4 class="page-title"> Illness/Injury Rate Report</h4>
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
                                    <p class="text-alphera font-20 m-0">Illness/Injury Rate Report</p>
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
                                    <label>Reasons <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="custom-select" id="brk_reasons" name="brk_reasons">
                                            <option value="">Select Reasons</option>
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
                                                    <th colspan="6">Illness/Injury Rate for Ex-Crew</th>
                                                    <th colspan="6">Illness/Injury Rate for New Crew</th>
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
                                                    <th>0</th>
                                                    <th>0</th>
                                                </tr>

                                                <tr>
                                                    <th colspan="1">Total historical over the past years</th>
                                                    <th colspan="12">0</th>
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
                            <p class="text-alphera font-20 m-0"> Illness/Injury Rate Report</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="illness_injury_form" enctype="application/x-www-form-urlencoded">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Reasons: </label>
                                                <select class="custom-select" id="brk_reasons" name="brk_reasons">
                                                    <option value="0">Select Crew Type</option>
                                                    <option value="3">Illness</option>
                                                    <option value="6">Injury</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Rank:</label>
                                                <select class="custom-select" id="" name="brk_rank">
                                                    <option value="1">Per Rank</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Crew Type: </label>
                                                <select class="custom-select" id="brk_crew_type" name="brk_crew_type">
                                                    <option value="0">Select Crew Type</option>
                                                    <option value="1">Ex-crew</option>
                                                    <option value="2">New crew</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Month range from: </label>
                                            <input type="month" class="form-control" placeholder="Month From" id="brk_month_from" name="brk_month_from">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Month range to: </label>
                                            <input type="month" class="form-control" placeholder="Month To" id="brk_month_to" name="brk_month_to">
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
                                    <div class="col-md-6">
                                        <h4 class="font-18 m-0">Current Number Count: <p class="text-alphera font-20 m-0" id="total_rate"></p></h4>
                                    </div>
                                    <div class="test" id="per_rank_display" name="per_rank_display">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/javascript/illness_injury.js'); ?>"></script>