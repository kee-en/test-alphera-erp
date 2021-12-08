    <!-- EDIT WARNING LETTER MODAL -->
    <div class="modal fade bs-example-modal-center" id="edit_warning_letter" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Warning Letter</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="javascript:void(0);" id="e_warning_letter">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label>Name of Crew</label>
                                <input type="text" class="form-control" placeholder="Name of Crew" id="e_crew_name" name="e_crew_name" readonly>
                                <input type="hidden" id="e_crew_id" name="e_crew_id" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Rank / Position</label>
                                <select class="custom-select" id="e_rank" name="e_rank">
                                    <option value="">Choose option</option>
                                    <?php foreach ($position_list as $value) : ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['position_code'] ?> - <?= $value['position_name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Type of Department</label>
                                <select class="custom-select" id="e_department" name="e_department">
                                    <option value="">Choose option</option>
                                    <?php foreach ($department_list as $value) : ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['department_name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Vessel</label>
                                <select class="custom-select" id="e_vessel" name="e_vessel">
                                    <option value="">Choose option</option>
                                    <?php foreach ($vessel_list as $value) : ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['vsl_name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Remarks</label>
                                <select class="custom-select" id="e_remarks" name="e_remarks">
                                    <option value="">Choose option</option>
                                    <option value="1">Not For Rehire (NRE)</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label>Additional Remarks</label>
                                <textarea class="form-control" id="e_additional_remarks" name="e_additional_remarks" rows="3" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>