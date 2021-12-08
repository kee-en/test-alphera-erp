<!-- VIEW / EDIT PRE JOINING AND VISA MODAL -->
<div class="modal fade" id="crew_lineup" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 65%;">
        <div class="modal-content">
            <div class="modal-header">
                <p class="text-alphera font-20 mb-0">Generate Crew Lineup</p>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">Vessel <span class="asterisk">*</span></label>
                                <select class="custom-select" id="c_line_up_vsl" name="c_line_up_vsl">
                                    <option value="">Choose option</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">Joining Port</label>
                                <input type="text" class="form-control" id="c_line_up_joiningp" name="c_line_up_joiningp">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">Date of Embarkation</label>
                                <input type="date" class="form-control" id="c_line_up_embark" name="c_line_up_embark">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" id="BtnGenerate">Generate</button>
                            <button type="button" class="btn btn-success" id="BtnPostApproval" disabled>Post for approval</button>
                        </div>
                    </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <table class="table table-hover m-0 table-centered dt-responsive w-100 table-bordered" id="crew_lineup_table" style="display: none;">
                            <thead class="thead-alphera">
                                <tr>
                                    <th>No.</th>
                                    <th>Crew Name</th>
                                    <th>Position</th>
                                    <th>Vessel</th>
                                    <th>Date of Embarkation</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- <tr>
                                    <td colspan="6" class="text-center">There is no crew at the moment.</td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
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

            <div class="modal-footer">
                <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript" src="<?= base_url('assets/javascript/crew_lineup.js') ?>"></script>