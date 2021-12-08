<!-- ADD FLIGHT DETAILS MODAL -->
<div class="modal fade" id="a_flight_details_modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="max-width: 65%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0" id="header_title">Add Flight Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="btnCloseFlightDetails">×</button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="add_flight_details_form" method="POST">
                    <div class="row mb-2">
                        <div class="col-md-9">
                            <p class="text-alphera font-20 m-0">List of Flight Details</p>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover m-0 table-centered dt-responsive w-100 table-bordered" id="flight_table">
                                <thead class="thead-alphera">
                                    <tr>
                                        <th></th>
                                        <th>Vessel Name</th>
                                        <th>Departure Country</th>
                                        <th>Departure Date/Time</th>
                                        <th>Destination Country</th>
                                        <th>Destination Date/Time</th>
                                        <th>Airline</th>
                                        <th>Airfare</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url("assets/javascript/a_flight_details.js") ?>"></script>