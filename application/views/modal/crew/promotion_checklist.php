<!-- ADD FLIGHT DETAILS MODAL -->
<div class="modal fade" id="view_promotion_checklist" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">For Promotion - <span id="vpc_crew_name"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <h4 class="text-default font-18 mt-0 mb-1">Crew Promotion (Checklist)</h4>
                        <p class="text-muted font-15" style="text-align: justify;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                        <input type="hidden" id="promotion_chck_hid_crew" name="promotion_chck_hid_crew">
                    </div>

                    <div class="col-md-12">
                        <div class="alert alert-warning" role="alert">
                            Note: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </div>
                    </div>

                    <div class="col-md-12">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="media">
                                    <img id="updated_pos_vess" class="align-self-start mr-3" src="<?= base_url('assets/alphera/icons/gray_check.png') ?>" alt="" width="50" height="50">
                                    <div class="media-body">
                                        <h4 class="mt-0 mb-1">Update Rank and Vessel</h4>
                                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Click <a href="javascript:void(0);" id="add_pos_ves" onclick="updatePosVessel()">here.</a>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="media">
                                    <img id="updated_mlc" class="align-self-start mr-3" src="<?= base_url('assets/alphera/icons/gray_check.png') ?>" alt="" width="50" height="50">
                                    <div class="media-body">
                                        <h4 class="mt-0 mb-1">Update MLC Contract</h4>
                                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Click <a href="javascript:void(0);" id="add_mlc" onclick="updateMLC()">here.</a>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="media">
                                    <img id="updated_poea" class="align-self-start mr-3" src="<?= base_url('assets/alphera/icons/gray_check.png') ?>" alt="" width="50" height="50">
                                    <div class="media-body">
                                        <h4 class="mt-0 mb-1">Update POEA Contract</h4>
                                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Click <a href="javascript:void(0);" id="add_poea" onclick="updatePOEA()">here.</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
            </div>
        </div>
    </div>
</div>