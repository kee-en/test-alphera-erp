<!-- VIEW / EDIT PRE JOINING AND VISA MODAL -->
<div class="modal fade" id="v_e_pre_joining_visa_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0" id="vepjv_crew_name"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs nav-bordered nav-justified">
                            <li class="nav-item">
                                <a href="#v_e_tab1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    Licenses / Endorsement / Book / ID
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#v_e_tab2" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    Training Certificates
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="v_e_tab1">
                                <div class="row" id="v_row_licenses">
                                    <div class="col-md-10 mb-2">
                                        <p class="text-alphera font-20 mb-0">Licenses / Endorsement / Book / ID</p>
                                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" id="btn_edit_license_edit" class="btn btn-alphera btn-block btn-edit-license">Edit Licenses</button>
                                    </div>

                                    <div class="col-md-12">
                                        <ul class="list-group" id="crew_list_licenses_edit">

                                        </ul>
                                    </div>
                                </div>
                                <form action="javascript:void(0)" id="form_crew_license" name="form_crew_license" enctype="application/x-www-form-urlencoded">
                                    <div class="row" id="e_row_licenses" style="display: none;">
                                        <div class="col-md-10 mb-2">
                                            <p class="text-alphera font-20 mb-0">Licenses / Endorsement / Book / ID</p>
                                            <span>Note: Fill up the required fields below.</span>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" id="btn_view_license" class="btn btn-primary btn-block btn-view-license">View Licenses</button>
                                        </div>
                                        <input type="hidden" id="l_crew_code" name="l_crew_code">
                                        <div class="row" id="licenses_list"></div>

                                        <div class="col-lg-12 text-right mt-2">
                                            <button type="submit" class="btn btn-alphera">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="v_e_tab2">
                                <div class="row" id="v_row_certificates">
                                    <div class="col-md-10 mb-2">
                                        <p class="text-alphera font-20 mb-0">Training Certificates</p>
                                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" id="btn_edit_certificates" class="btn btn-alphera btn-block btn-edit-cert">Edit Certificates</button>
                                    </div>

                                    <div class="col-md-12">
                                        <ul class="list-group" id="crew_list_certificates_edit"></ul>
                                    </div>
                                </div>
                                <form action="javascript:void(0)" id="form_crew_training" name="form_crew_training" enctype="application/x-www-form-urlencoded">
                                    <div class="row" id="e_row_certificates" style="display: none;">
                                        <div class="col-md-10 mb-2">
                                            <p class="text-alphera font-20 mb-0">Training Certificates</p>
                                            <span>Note: Fill up the required fields below.</span>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" id="btn_view_certificates_edit" class="btn btn-primary btn-block btn-view-cert">View Certificates</button>
                                        </div>
                                        <input type="hidden" id="t_crew_code" name="t_crew_code">
                                        <div class="row" id="training_certificate_list"></div>

                                        <div class="col-lg-12 text-right mt-2">
                                            <button type="submit" class="btn btn-alphera">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>