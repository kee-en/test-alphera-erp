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
                                <li class="breadcrumb-item"> <a href="#">Vessels</a></li>
                                <li class="breadcrumb-item"> Manage Vessels</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Manage Vessels</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Add New Vessel</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="add_vessel_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Vessel Code <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Vessel Code" id="vsl_code" name="vsl_code">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Vessel Name <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Vessel Name" id="vsl_name" name="vsl_name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Type of Vessel <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="type_of_vessel" name="type_of_vessel">
                                                <option value="">Choose option</option>
                                                <?php foreach ($vessel_type as $value) : ?>
                                                    <option value="<?= $value['id'] ?>"><?= $value['tv_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Type of Engine <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="type_of_engine" name="type_of_engine">
                                                <option value="">Choose option</option>
                                                <?php foreach ($vessel_engine as $value) : ?>
                                                    <option value="<?= $value['id'] ?>"><?= $value['engine_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Acquisition Status <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="type_of_engine" name="type_of_engine">
                                                <option value="">Choose option</option>
                                                <option value="1">Manned</option>
                                                <option value="2">Newly Takeover</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btnAddVessel">Add</button>
                                        <button type="reset" class="btn btn-secondary" id="BtnReset">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">List of Vessels</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered" id="manage_vessel_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>Vessel Code</th>
                                                <th>Vessel Name</th>
                                                <th>Type of Vessel </th>
                                                <th>Type of Engine</th>
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

    <!-- EDIT VESSEL MODAL -->
    <div class="modal fade bs-example-modal-center" id="edit_vessel_modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-18 m-0">Edit Vessel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="btnClose();">×</button>
                </div>
                <form action="javascript:void(0)" id="edit_vessel_form">
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="form-control" id="e_vsl_id" name="e_vsl_id">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Vessel Code <span class="asterisk">*</span></label>
                                    <input type="text" class="form-control" placeholder="Vessel Code" id="e_vsl_code" name="e_vsl_code">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Vessel Name <span class="asterisk">*</span></label>
                                    <input type="text" class="form-control" placeholder="Vessel Name" id="e_vsl_name" name="e_vsl_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Type of Vessel <span class="asterisk">*</span></label>
                                    <select class="custom-select" id="e_type_of_vessel" name="e_type_of_vessel">
                                        <option value="">Choose option</option>
                                        <?php foreach ($vessel_type as $value) : ?>
                                            <option value="<?= $value['id'] ?>"><?= $value['tv_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Type of Engine <span class="asterisk">*</span></label>
                                    <select class="custom-select" id="e_type_of_engine" name="e_type_of_engine">
                                        <option value="">Choose option</option>
                                        <?php foreach ($vessel_engine as $value) : ?>
                                            <option value="<?= $value['id'] ?>"><?= $value['engine_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Acquisition Status <span class="asterisk">*</span></label>
                                    <select class="custom-select" id="type_acquisition_status" name="type_acquisition_status">
                                        <option value="">Choose option</option>
                                        <option value="1">Manned</option>
                                        <option value="2">Newly Takeover</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera" id="btnEditVessel">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="btnClose();">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/manage_vessel.js') ?>"></script>