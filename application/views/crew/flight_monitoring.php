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
                                <li class="breadcrumb-item"> <a href="#">Crew</a></li>
                                <li class="breadcrumb-item"> Flight Monitoring</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Flight Monitoring</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-4">

                    <form action="javascript:void(0)" id="flight_information_form">
                        <div class="card">
                            <div class="card-header">
                                <p class="text-alphera font-20 m-0">Add Flight Information</p>
                                <span>Fill up the required fields below.</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Vessel <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="flight_vessel" name="flight_vessel">
                                                <option value="">Choose option</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Flight Number <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" id="f_flight_number" name="f_flight_number">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Departure Country <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Departure Country" id="f_departure_country" name="f_departure_country">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Departure Date <span class="asterisk">*</span></label>
                                            <input type="date" class="form-control" id="f_departure_date" name="f_departure_date">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Departure Time <span class="asterisk">*</span></label>
                                            <input type="time" class="form-control" id="f_departure_time" name="f_departure_time">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Destination Country <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Destination Country" id="f_destination_country" name="f_destination_country">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Destination Date <span class="asterisk">*</span></label>
                                            <input type="date" class="form-control" id="f_destination_date" name="f_destination_date">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Destination Time <span class="asterisk">*</span></label>
                                            <input type="time" class="form-control" id="f_destination_time" name="f_destination_time">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Airfare <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Airfare" id="f_airfare" name="f_airfare" onkeypress="return isNumberKey(event)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Airline <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Airline" id="f_airline" name="f_airline">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Option</label>
                                            <input type="date" class="form-control" id="f_option_date" name="f_option_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add</button>
                                <button type="button" class="btn btn-secondary" id="btnResetFlightInfo">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col" style="margin: auto;">
                                    <p class="text-alphera font-20 m-0">List of Flight Information</p>
                                </div>
                                <div class="col-md-3">
                                    <select class="custom-select" id="fm_export_as" name="fm_export_as">
                                        <option value="">Export as</option>
                                        <option value="csv">CSV</option>
                                        <option value="excel">Excel</option>
                                        <option value="pdf">PDF</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered" id="flight_information_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>Vessel</th>
                                                <th>Flight No.</th>
                                                <th>Departure Country</th>
                                                <th>Departure Date/Time</th>
                                                <th>Destination Country</th>
                                                <th>Destination Date/Time</th>
                                                <th>Airfare</th>
                                                <th>Airline</th>
                                                <th>Option</th>
                                                <th>No. of Crew Assigned: </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

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

    <script type="text/javascript" src="<?= base_url('assets/javascript/flight_monitoring.min.js') ?>"></script>