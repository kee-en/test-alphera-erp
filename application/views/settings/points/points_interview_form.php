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
                                <li class="breadcrumb-item"> Points of Interview Form</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Points of Interview Form</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Add New Points of Interview</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="interview_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Points of Interview <span class="asterisk">*</span></label>
                                            <textarea class="form-control" id="points_of_interview" name="points_of_interview" rows="4"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12 ml-1 mt-1">
                                        <div class="checkbox checkbox-alphera form-check-inline">
                                            <input type="checkbox" id="general_form" name="general_form" value="1">
                                            <label for="general_form"> For General Form </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                        <button type="reset" id="resetbtn" class="btn btn-secondary">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">List of Points of Interview</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered" id="points_of_interview_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>Points of Interview</th>
                                                <th>Form Type</th>
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
    <div class="modal fade bs-example-modal-center" id="edit_points_of_interview_modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-18 m-0">Edit Points of Interview</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="btnClose();">×</button>
                </div>
                <form action="javascript:void(0)" id="e_interview_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Points of Interview <span class="asterisk">*</span></label>
                                    <input type="hidden" class="form-control" id="e_points_of_interview_id" name="e_points_of_interview_id">
                                    <textarea class="form-control" id="e_points_of_interview" name="e_points_of_interview" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 ml-1 mt-1">
                                <div class="checkbox checkbox-alphera form-check-inline">
                                    <input type="checkbox" id="e_general_form" name="e_general_form" value="1">
                                    <label for="e_general_form"> For General Form </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera" id="btn_edit_points">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="btnClose();">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/points_of_interview.js') ?>"></script>