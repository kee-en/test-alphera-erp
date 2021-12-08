    <!-- VIEW / EDIT PRE JOINING AND VISA MODAL -->
    <div class="modal fade" id="pre_joining_visa_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-20 m-0" id="cert_crew_name"></h4>
                    <button type="button" class="close" id="BtnClose" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-bordered nav-justified">
                                <li class="nav-item">
                                    <a href="#v_tab1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                        Licenses / Endorsement / Book / ID
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#v_tab2" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        Training Certificates
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="v_tab1">
                                    <div class="row" id="">
                                        <div class="col-md-10 mb-2">
                                            <p class="text-alphera font-20 mb-0">Licenses / Endorsement / Book / ID</p>
                                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                                        </div>

                                        <div class="col-md-2">
                                            <!-- <button type="button" id="btn_edit_license" class="btn btn-alphera btn-block btn-edit-license">Edit Licenses</button> -->
                                        </div>

                                        <div class="col-md-12">
                                            <ul class="list-group" id="crew_list_licenses">

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="v_tab2">
                                    <div class="row" id="">
                                        <div class="col-md-10 mb-2">
                                            <p class="text-alphera font-20 mb-0">Training Certificates</p>
                                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                                        </div>

                                        <div class="col-md-2">
                                            <!-- <button type="button" id="btn_edit_certificates" class="btn btn-alphera btn-block btn-edit-cert">Edit Certificates</button> -->
                                        </div>

                                        <div class="col-md-12">
                                            <ul class="list-group" id="crew_list_certificates"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                </div>
            </div>
        </div>
    </div>