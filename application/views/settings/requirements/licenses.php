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
                                <li class="breadcrumb-item"> <a href="#">System Configuration</a></li>
                                <li class="breadcrumb-item"> <a href="#">Requirements</a></li>
                                <li class="breadcrumb-item"> Licenses / Endorsement / Book / ID</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Licenses / Endorsement / Book / ID</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Add New License</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="license_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>License Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="License Code" id="license_code" name="license_code">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>License Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="License Name" id="license_name" name="license_name">
                                        </div>
                                    </div>

                                    <div class="col-md-12 ml-1 mt-1">
                                        <div class="checkbox checkbox-alphera form-check-inline">
                                            <input type="checkbox" id="required" name="required" value="1">
                                            <label for="required"> Required </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btn_save_license">Add</button>
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
                            <p class="text-alphera font-20 m-0">List of Licenses / Endorsement / Book / ID</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive w-100 table-bordered" id="license_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>License Code</th>
                                                <th>License Name</th>
                                                <th>Required</th>
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
    <div class="modal fade" id="edit_license_modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-18 m-0">Edit Licenses / Endorsement / Book / ID</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="btnClose();">×</button>
                </div>
                <form action="javascript:void(0)" id="e_license_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>License Code <span class="text-danger">*</span></label>
                                    <input type="hidden" class="form-control" placeholder="License Code" id="e_license_id" name="e_license_id">
                                    <input type="text" class="form-control" placeholder="License Code" id="e_license_code" name="e_license_code">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>License Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="License Name" id="e_license_name" name="e_license_name">
                                </div>
                            </div>

                            <div class="col-md-12 ml-1 mt-1">
                                <div class="checkbox checkbox-alphera form-check-inline">
                                    <input type="checkbox" id="e_required" name="e_required" value="1">
                                    <label for="e_required"> Required </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera" id="btn_edit_license">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="btnClose();">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/licenses.js') ?>"></script>