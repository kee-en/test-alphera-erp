<!-- VIEW / EDIT PRE JOINING AND VISA MODAL -->
<div class="modal fade" id="v_contracts_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0"><span id="c_crew_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs nav-bordered nav-justified">
                            <li class="nav-item">
                                <a href="#vpjv_tab1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    POEA Contracts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#vpjv_tab2" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    MLC Contracts
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="vpjv_tab1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <p class="text-alphera font-20 mb-0">List of POEA Contract</p>
                                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                                            </div>

                                            <div class="col-md-12">
                                                <!-- <ul class="list-group" id="contract_list"></ul> -->

                                                <table class="table table-hover m-0 table-centered dt-responsive w-100 table-bordered" id="contract_table_body">
                                                    <thead class="thead-alphera">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Type of Contract</th>
                                                            <th>Duration of Contract</th>
                                                            <th>Issued By</th>
                                                            <th>Date Created</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <nav>
                                                    <div class="pagination pagination-sm">
                                                    </div>
                                                </nav>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <div class="count-pagination"><span id="pagination"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="vpjv_tab2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <p class="text-alphera font-20 mb-0">List of MLC Contract</p>
                                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                                            </div>

                                            <div class="col-md-12">
                                                <!-- <ul class="list-group" id="contract_list"></ul> -->

                                                <table class="table table-hover m-0 table-centered dt-responsive w-100 table-bordered" id="mlc_table_body">
                                                    <thead class="thead-alphera">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Type of Contract</th>
                                                            <th>Type of MLC</th>
                                                            <th>Issued By</th>
                                                            <th>Date Created</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-8">
                                                <nav>
                                                    <div class="pagination pagination-sm">
                                                    </div>
                                                </nav>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <div class="count-pagination"><span id="pagination"></span></div>
                                            </div>
                                        </div>
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
</div>

<script type="text/javascript" src="<?= base_url('assets/javascript/v_contracts.js') ?>"></script>