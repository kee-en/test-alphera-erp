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
                                <li class="breadcrumb-item"> Repatriation Report</li>
                            </ol>
                        </div>
                        <h4 class="page-title"> Repatriation Report</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0"> Repatriation Report</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="manage_reports_form" enctype="application/x-www-form-urlencoded">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Report Type:</label>
                                                <select class="custom-select" id="gen_filter_type" name="gen_filter_type">
                                                    <option value="">Select Report Type</option>
                                                    <option value="1">Total Crew Onboard</option>
                                                    <option value="2">Total Crew Deployed</option>
                                                    <option value="3">Total New Hire Deployed</option>
                                                    <option value="4">Total Ex-crew Deployed</option>
                                                    <option value="5">Total Crew Repatriated (Finished Contract)</option>
                                                    <option value="6">Total Crew Repatriated due to illness (Unfinished Contract)</option>
                                                    <option value="7">Total Crew Repatriated due to injury (Unfinished Contract)</option>
                                                    <option value="8">Total Crew Repatriated due to disciplinary req. (Unfinished Contract)</option>
                                                    <option value="9">Total Crew Repatriated due to own req. (Unfinished Contract)</option>
                                                    <option value="10">Total Crew Repatriated due to jumpship cases (Unfinished Contract)</option>
                                                    <option value="11">Total Crew Repatriated due to casualty cases (Unfinished Contract)</option>
                                                    <option value="12">Total Crew Repatriated due to vessel reduction (Unfinished Contract)</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Report Type:</label>
                                                <select class="custom-select" id="gen_filter_duration" name="gen_filter_duration">
                                                    <option value="">Select Duration Type</option>
                                                    <option value="1">Per Month</option>
                                                    <option value="2">Per Year</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="vessel_type" style="display: none;">
                                        <div class="form-group">
                                            <label>Vessel Type: </label>
                                                <select class="custom-select" id="gen_filter_vsl_type" name="gen_filter_vsl_type">
                                                    <option value="0">Select Vessel Type</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="month_div" style="display: none;">
                                        <div class="form-group">
                                            <label>Month: </label>
                                            <input type="month" class="form-control" placeholder="Month From" id="gen_month_filter" name="gen_month_filter">
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="year_div" style="display: none;">
                                        <div class="form-group">
                                            <label>Year: </label>
                                            <input type="year" class="form-control" placeholder="Month From" id="gen_year_filter" name="gen_year_filter">
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="gen_type_reason" style="display: none;">
                                        <div class="form-group">
                                            <label>Remarks: </label>
                                            <input type="text" class="form-control" placeholder="Reason" id="gen_type_remarks" name="gen_type_remarks">
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
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/javascript/repatriation.js'); ?>"></script>