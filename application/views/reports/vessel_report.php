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
                                <li class="breadcrumb-item"> Vessels Report</li>
                            </ol>
                        </div>
                        <h4 class="page-title"> Vessels Report</h4>
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
                                    <p class="text-alphera font-20 m-0">Vessels Report</p>
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
                                    <label>Report Type <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="custom-select" id="toc_rank_filter" name="toc_rank_filter">
                                            <option value="">Select Report Type</option>
                                            <option value="1">Vessels Manned</option>
                                            <option value="2">Newly Overtaken vessels</option>
                                            <option value="3">Vessel Reduction</option>
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
                                                    <th rowspan="2">Vessel Type</th>
                                                    <th rowspan="2">Total No. of Vessel/s</th>
                                                    <th colspan="5" style="display: none;">Reduction Type</th>
                                                    <th colspan="6">Comparative (Previous and Present Year)</th>
                                                </tr>

                                                <tr>
                                                    <th id="rt_col" style="display: none;">Laid up</th>
                                                    <th id="rt_col" style="display: none;">Sold</th>
                                                    <th id="rt_col" style="display: none;">Change management</th>
                                                    <th id="rt_col" style="display: none;">Scrapped</th>
                                                    <th id="rt_col" style="display: none;">Collision/sunk</th>

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
                                                    <th>Bulk Carrier</th>
                                                    <th>103</th>
                                                    <th id="rt_val" style="display: none;">0</th>
                                                    <th id="rt_val" style="display: none;">0</th>
                                                    <th id="rt_val" style="display: none;">0</th>
                                                    <th id="rt_val" style="display: none;">0</th>
                                                    <th id="rt_val" style="display: none;">0</th>
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
                            <p class="text-alphera font-20 m-0"> Vessels Report</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="vessels_reports_form" enctype="application/x-www-form-urlencoded">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Report Type:</label>
                                            <select class="custom-select" id="vsl_filter_type" name="vsl_filter_type">
                                                <option value="">Select Report Type</option>
                                                <option value="1">Vessels Manned</option>
                                                <option value="2">Newly Overtaken vessels</option>
                                                <option value="3">Vessel Reduction</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Vessel Type: </label>
                                            <select class="custom-select" id="filter_vsl_type" name="filter_vsl_type">
                                                <option value="0">Select Vessel Type</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="reduction_option" style="display: none;">
                                        <div class="form-group">
                                            <label>Reduction Type: </label>
                                            <select class="custom-select" id="filter_reduction_type" name="filter_reduction_type">
                                                <option value="">Select Reduction Type</option>
                                                <option value="2">Laid Up</option>
                                                <option value="3">Sold</option>
                                                <option value="4">Change Management</option>
                                                <option value="5">Scrapped</option>
                                                <option value="6">Colision/Sunk</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btnGenerate">Generate Report</button>
                                        <button type="reset" class="btn btn-secondary" id="BtnReset">Reset</button>
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
                                    <h4 class="font-18 m-0">Vessel Count : <span class="text-muted" id="vessel_count"></span></h4>
                                    <h4 class="font-18 m-0">Compara Vessel Count : <span class="text-muted" id="compara_vessel_count"></span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/javascript/vessel_report.js'); ?>"></script>