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
                                <li class="breadcrumb-item"> Module</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Module</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Add New Module</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>

                        <form action="javascript:void(0)" id="add_module_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Module Name <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Module Name" id="module_name" name="module_name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>URL <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="URL" id="url" name="url">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Icon <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="Icon" id="icon" name="icon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btnAddModule">Add</button>
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
                            <p class="text-alphera font-20 m-0">List of Module</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered" id="module_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>Module Name</th>
                                                <th>URL</th>
                                                <th>Icon</th>
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

    <!-- MODULE MODAL -->
    <div class="modal fade" id="edit_module_modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-18 m-0">Edit Module</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="btnEditIconModule">×</button>
                </div>
                <form action="javascript:void(0)" id="edit_module_form">
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="form-control" id="e_module_id" name="e_module_id">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Module Name <span class="asterisk">*</span></label>
                                    <input type="text" class="form-control" placeholder="Module Name" id="e_module_name" name="e_module_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>URL <span class="asterisk">*</span></label>
                                    <input type="text" class="form-control" placeholder="URL" id="e_module_url" name="e_module_url">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Icon <span class="asterisk">*</span></label>
                                    <input type="text" class="form-control" placeholder="Icon" id="e_module_icon" name="e_module_icon">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera" id="btnEditModule">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseEditModule">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/module.js') ?>"></script>