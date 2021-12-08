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
                                <li class="breadcrumb-item"> <a href="#">Developer</a></li>
                                <li class="breadcrumb-item"> Sub Module</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Sub Module</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Add New Sub Module</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="add_sub_module_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Module <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="module" name="module">
                                                <option value="">Choose option</option>
                                                <?php foreach ($module as $value) : ?>
                                                    <option value="<?= $value['id'] ?>"><?= $value['description'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sub Module <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Sub Module Name" id="sub_module" name="sub_module">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Target Link <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="target_link" name="target_link">
                                                <option value="0">Quick Link</option>
                                                <option value="1">Child Node</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>URL <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="URL" id="sub_module_url" name="sub_module_url" value="#" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btnAddSubModule">Add</button>
                                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">List of Sub Module</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive w-100 table-bordered" id="sub_module_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>Module</th>
                                                <th>Sub Module</th>
                                                <th>URL </th>
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

    <!-- SUB MODULE MODAL -->
    <div class="modal fade" id="edit_sub_module_modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-18 m-0">Edit Sub Module</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="btnEditIconSubModule">×</button>
                </div>
                <form action="javascript:void(0)" id="edit_sub_module_form">
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="form-control" id="e_sub_module_id" name="e_sub_module_id">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Module <span class="asterisk">*</span></label>
                                    <select class="custom-select" id="e_module" name="e_module">
                                        <option value="">Choose option</option>
                                        <?php foreach ($module as $value) : ?>
                                            <option value="<?= $value['id'] ?>"><?= $value['description'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sub Module <span class="asterisk">*</span></label>
                                    <input type="text" class="form-control" placeholder="Sub Module" id="e_sub_module" name="e_sub_module">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Target Link <span class="asterisk">*</span></label>
                                    <select class="custom-select" id="e_target_link" name="e_target_link">

                                        <option value="0">Quick Link</option>
                                        <option value="1">Child Node</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>URL <span class="asterisk">*</span></label>
                                    <input type="text" class="form-control" placeholder="URL" id="e_sub_module_url" name="e_sub_module_url">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera" id="btnEditSubModule">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseEditSubModule">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/sub_module.js') ?>"></script>