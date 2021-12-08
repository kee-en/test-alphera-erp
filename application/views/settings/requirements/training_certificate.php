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
                                <li class="breadcrumb-item"> Training Certificate</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Training Certificate</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Add New Certificate</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="certificate_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Certificate Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Certificate Code" id="cert_code" name="cert_code">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Certificate Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Certificate Name" id="cert_name" name="cert_name">
                                        </div>
                                    </div>
                                    <div class="col-md-12 ml-1 mt-1">
                                        <div class="checkbox checkbox-alphera form-check-inline">
                                            <input type="checkbox" id="with_cop" name="with_cop" value="1">
                                            <label for="with_cop"> With COP </label>
                                        </div>
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
                                        <button type="submit" class="btn btn-primary" id="btn_save_certificate">Add</button>
                                        <button type="reset" id="BtnReset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">List of Training Certificate</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered" id="training_certificate_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>Certificate Code</th>
                                                <th>Certificate Name</th>
                                                <th>COP</th>
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
    <div class="modal fade" id="edit_certificate_modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-18 m-0">Edit Training Certificate</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="btnClose();">×</button>
                </div>
                <form action="javascript:void(0)" id="e_certificate_form">
                    <div class="modal-body">
                        <input type="hidden" id="e_certificate_id" name="e_certificate_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Certificate Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Certificate Code" id="e_cert_code" name="e_cert_code">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Certificate Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Certificate Name" id="e_cert_name" name="e_cert_name">
                                </div>
                            </div>

                            <div class="col-md-12 ml-1 mt-1">
                                <div class="checkbox checkbox-alphera form-check-inline">
                                    <input type="checkbox" id="e_with_cop" name="e_with_cop" value="1">
                                    <label for="e_with_cop"> With COP </label>
                                </div>
                                <div class="checkbox checkbox-alphera form-check-inline">
                                    <input type="checkbox" id="e_required" name="e_required" value="1">
                                    <label for="e_required"> Required </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera" id="btn_edit_certificate">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="btnClose();">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/training_certificate.js') ?>"></script>