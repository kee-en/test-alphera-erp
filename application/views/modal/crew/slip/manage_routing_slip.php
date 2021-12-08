<!-- VIEW / EDIT PRE JOINING AND VISA MODAL -->
<div class="modal fade" id="manage_routing_slip_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <form action="javascript:void(0);" id="mrsm_routing_slip_form" method="POST">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-20 m-0" id="mrsm_crew_name"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <p class="text-alphera font-20 font-weight-medium mb-0">PRE-JOINING ROUTING SLIP</p>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span>
                        </div>
                    </div>
                        <input type="hidden" id="mntr_code" name="mntr_code">
                        <input type="hidden" id="crw_code" name="crw_code">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <!-- [START] -->
                                    <thead>
                                        <tr>
                                            <td id="text-alignment">Name:</td>
                                            <td id="text-alignment" class="crew_name">Christine Silva</td>
                                            <td id="text-alignment">Rank:</td>
                                            <td id="text-alignment" class="crew_pos">Master (MSTR)</td>
                                            <td id="text-alignment">Line-up Vessel:</td>
                                            <td id="text-alignment" class="crew_vsl">ARBORELLA (A/B)</td>
                                            <td id="text-alignment">Please check if w/CBA:</td>
                                            <td id="text-alignment">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="with_cba" name="with_cba">
                                                    <label class="custom-control-label" for="with_cba"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="header-title text-alphera mb-2">I. CREWING SECTION</h4>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="text-center thead-light">
                                        <tr>
                                            <th style="width: 25%;">Subject Routing</th>
                                            <th>Remarks / Instructions</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1. Initial verification of documents</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_1" name="mrsm_remarks_1" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_0" name="mrsm_date_0"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_0" value="0" name="mrsm_cs_status_1" onclick="getRoutingDateNow(0)"> 
                                                    <label for="status_1"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_0" value="1" name="mrsm_cs_status_1" onclick="getRoutingDateNow(0)">
                                                    <label for="status_1"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2. Interview, assessment and briefing</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_2" name="mrsm_remarks_2" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_1" name="mrsm_date_1"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_1" value="0" name="mrsm_cs_status_2" onclick="getRoutingDateNow(1)">
                                                    <label for="status_2"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_1" value="1" name="mrsm_cs_status_2" onclick="getRoutingDateNow(1)">
                                                    <label for="status_2"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3. COVID Protocols</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_3" name="mrsm_remarks_3" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_2" name="mrsm_date_2"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_2" value="0" name="mrsm_cs_status_3" onclick="getRoutingDateNow(2)">
                                                    <label for="status_3"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_2" value="1" name="mrsm_cs_status_3" onclick="getRoutingDateNow(2)">
                                                    <label for="status_3"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="header-title text-alphera mb-2">II. DOCUMENTATION & PROCESSING DEPARTMENT</h4>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="text-center thead-light">
                                        <tr>
                                            <th style="width: 25%;">Subject Routing</th>
                                            <th>Remarks / Instructions</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1. Verification of documents</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_4" name="mrsm_remarks_4" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_3" name="mrsm_date_3"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_3" value="0" name="mrsm_cs_status_4" onclick="getRoutingDateNow(3)">
                                                    <label for="status_4"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_3" value="1" name="mrsm_cs_status_4" onclick="getRoutingDateNow(3)">
                                                    <label for="status_4"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2. Medical</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_5" name="mrsm_remarks_5" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_4" name="mrsm_date_4"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_4" value="0" name="mrsm_cs_status_5" onclick="getRoutingDateNow(4)">
                                                    <label for="status_5"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_4" value="1" name="mrsm_cs_status_5" onclick="getRoutingDateNow(4)">
                                                    <label for="status_5"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3. POEA / MLC Contracts (Briefing / Signing)</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_6" name="mrsm_remarks_6" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_5" name="mrsm_date_5"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_5" value="0" name="mrsm_cs_status_6" onclick="getRoutingDateNow(5)">
                                                    <label for="status_6"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_5" value="1" name="mrsm_cs_status_6" onclick="getRoutingDateNow(5)">
                                                    <label for="status_6"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4. Flag Requirements</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_7" name="mrsm_remarks_7" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_6" name="mrsm_date_6"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_6" value="0" name="mrsm_cs_status_7" onclick="getRoutingDateNow(6)">
                                                    <label for="status_7"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_6" value="1" name="mrsm_cs_status_7" onclick="getRoutingDateNow(6)">
                                                    <label for="status_7"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5. VISA Requirements</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_8" name="mrsm_remarks_8" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_7" name="mrsm_date_7"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_7" value="0" name="mrsm_cs_status_8" onclick="getRoutingDateNow(7)">
                                                    <label for="status_8"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_7" value="1" name="mrsm_cs_status_8" onclick="getRoutingDateNow(7)">
                                                    <label for="status_8"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="header-title text-alphera mb-2">III. IN-HOUSE TRAINING REQUIREMENTS</h4>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="text-center thead-light">
                                        <tr>
                                            <th style="width: 25%;">Subject Routing</th>
                                            <th>Remarks / Instructions</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1. POS SM Company Policies</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_9" name="mrsm_remarks_9" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_8" name="mrsm_date_8"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_8" value="0" name="mrsm_cs_status_9" onclick="getRoutingDateNow(8)">
                                                    <label for="status_10"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_8" value="1" name="mrsm_cs_status_9" onclick="getRoutingDateNow(8)">
                                                    <label for="status_10"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2. Duties and Responsibilities</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_10" name="mrsm_remarks_10" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_9" name="mrsm_date_9"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_9" value="0" name="mrsm_cs_status_10" onclick="getRoutingDateNow(9)">
                                                    <label for="status_11"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_9" value="1" name="mrsm_cs_status_10" onclick="getRoutingDateNow(9)">
                                                    <label for="status_11"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3. PDOS</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_11" name="mrsm_remarks_11" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_10" name="mrsm_date_10"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_10" value="0" name="mrsm_cs_status_11" onclick="getRoutingDateNow(10)">
                                                    <label for="status_12"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_10" value="1" name="mrsm_cs_status_11" onclick="getRoutingDateNow(10)">
                                                    <label for="status_12"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4. Anti-Piracy Training</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_12" name="mrsm_remarks_12" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_11" name="mrsm_date_11"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_11" value="0" name="mrsm_cs_status_12" onclick="getRoutingDateNow(11)">
                                                    <label for="status_13"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_11" value="1" name="mrsm_cs_status_12" onclick="getRoutingDateNow(11)">
                                                    <label for="status_13"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5. Online Training</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_13" name="mrsm_remarks_13" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_12" name="mrsm_date_12"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_12" value="0" name="mrsm_cs_status_13" onclick="getRoutingDateNow(12)">
                                                    <label for="status_14"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_12" value="1" name="mrsm_cs_status_13" onclick="getRoutingDateNow(12)">
                                                    <label for="status_14"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="header-title text-alphera mb-2">IV. ACCOUNTING DEPARTMENT</h4>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="text-center thead-light">
                                        <tr>
                                            <th style="width: 25%;">Subject Routing</th>
                                            <th>Remarks / Instructions</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1. Allotment Slip</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_14" name="mrsm_remarks_14" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_13" name="mrsm_date_13"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_13" value="0" name="mrsm_cs_status_14" onclick="getRoutingDateNow(13)">
                                                    <label for="status_15"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_13" value="1" name="mrsm_cs_status_14" onclick="getRoutingDateNow(13)">
                                                    <label for="status_15"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2. Briefing on Accounting procedures / policies</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_15" name="mrsm_remarks_15" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_14" name="mrsm_date_14"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_14" value="0" name="mrsm_cs_status_15" onclick="getRoutingDateNow(14)">
                                                    <label for="status_16"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_14" value="1" name="mrsm_cs_status_15" onclick="getRoutingDateNow(14)">
                                                    <label for="status_16"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="header-title text-alphera mb-2">IV. HR / ADMIN DEPARTMENT</h4>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="text-center thead-light">
                                        <tr>
                                            <th style="width: 25%;">Subject Routing</th>
                                            <th>Remarks / Instructions</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1. Quarantine Briefing</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_16" name="mrsm_remarks_16" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_15" name="mrsm_date_15"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_15" value="0" name="mrsm_cs_status_16" onclick="getRoutingDateNow(15)">
                                                    <label for="status_17"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_15" value="1" name="mrsm_cs_status_16" onclick="getRoutingDateNow(15)">
                                                    <label for="status_17"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2. Surrender of ID (For CBS only)</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_17" name="mrsm_remarks_17" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_16" name="mrsm_date_16"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_16" value="0" name="mrsm_cs_status_17" onclick="getRoutingDateNow(16)">
                                                    <label for="status_18"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_16" value="1" name="mrsm_cs_status_17" onclick="getRoutingDateNow(16)">
                                                    <label for="status_18"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3. Medical Repatriation and Safety Briefing</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_18" name="mrsm_remarks_18" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_17" name="mrsm_date_17"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_17" value="0" name="mrsm_cs_status_18" onclick="getRoutingDateNow(17)">
                                                    <label for="status_19"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_17" value="1" name="mrsm_cs_status_18" onclick="getRoutingDateNow(17)">
                                                    <label for="status_19"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4. Prejoining Satisfaction Questionnaire</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_19" name="mrsm_remarks_19" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_18" name="mrsm_date_18"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_18" value="0" name="mrsm_cs_status_19" onclick="getRoutingDateNow(18)">
                                                    <label for="status_20"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_18" value="1" name="mrsm_cs_status_19" onclick="getRoutingDateNow(18)">
                                                    <label for="status_20"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="header-title text-alphera mb-2">V. DOCUMENTATION & PROCESSING DEPARTMENT</h4>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="text-center thead-light">
                                        <tr>
                                            <th style="width: 25%;">Subject Routing</th>
                                            <th>Remarks / Instructions</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1. Booking / PTA</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_20" name="mrsm_remarks_20" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_19" name="mrsm_date_19"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_19" value="0" name="mrsm_cs_status_20" onclick="getRoutingDateNow(19)">
                                                    <label for="status_21"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_19" value="1" name="mrsm_cs_status_20" onclick="getRoutingDateNow(19)">
                                                    <label for="status_21"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2. Uniforms</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_21" name="mrsm_remarks_21" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_20" name="mrsm_date_20"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_20" value="0" name="mrsm_cs_status_21" onclick="getRoutingDateNow(20)">
                                                    <label for="status_22"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_20" value="1" name="mrsm_cs_status_21" onclick="getRoutingDateNow(20)">
                                                    <label for="status_22"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3. Briefing and Dispatch</td>
                                            <td>
                                                <textarea class="form-control" id="mrsm_remarks_22" name="mrsm_remarks_22" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment"><input class="form-control" type="date" id="mrsm_date_21" name="mrsm_date_21"></td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_cs_21" value="0" name="mrsm_cs_status_22" onclick="getRoutingDateNow(21)">
                                                    <label for="status_23"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="mrsm_csd_21" value="1" name="mrsm_cs_status_22" onclick="getRoutingDateNow(21)">
                                                    <label for="status_23"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="BtnSubmitRoutingSlip">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
function getRoutingDateNow(num) {
    var now = new Date();

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#mrsm_date_'+num).val(today);
}

$("#mrsm_routing_slip_form").submit(function () {
	$.ajax({
		url: base_url + "save-routing-slip",
		type: "POST",
		data: $("#mrsm_routing_slip_form").serialize(),
		beforeSend: function () {
			$("#BtnSubmitRoutingSlip").html(
				'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
			);
			$("#BtnSubmitRoutingSlip").prop("disabled", true);
		},
		success: function (data) {

			if (data.type) {
				Swal.fire({
					icon: data.type,
					title: data.title,
					text: data.text,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					if (data.type === 'success') {
                        location.reload();
					}
				});
			}
			$("#BtnSubmitRoutingSlip").html(
				'Submit'
			);
			$("#BtnSubmitRoutingSlip").prop("disabled", false);
		}
	});
});

$("#with_cba").change(function() {
  var name = $(this).attr("name");
  $("input[type=checkbox][name=" + name + "]").val(($(this).is(":checked") ? 1 : 0));
})
</script>