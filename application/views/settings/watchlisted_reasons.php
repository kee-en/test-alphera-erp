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
                                <li class="breadcrumb-item">Watchlisted Reasons</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Watchlisted Reasons</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Add New Reason</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="watchlisted_reason_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Code" id="code" name="code">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Reason Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Reason Name" id="reason_name" name="reason_name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btn_save_reasons">Save</button>
                                        <button type="reset" class="btn btn-secondary" id="BtnReset">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">List of Watchlisted Reasons</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive w-100 table-bordered" id="watchlisted_reasons_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>Code</th>
                                                <th>Reason Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>SAMPLE-01</td>
                                                <td>Poor Performance</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_watchlisted_modal" data-backdrop="static" data-keyboard="false">Edit</button>
                                                    <button type="button" class="btn btn-outline-danger btn-xs">Remove</button>
                                                </td>
                                            </tr>
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
    <div class="modal fade" id="edit_watchlisted_modal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-18 m-0">Edit Watchlisted Reasons</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="btnClose();">×</button>
                </div>
                <form action="javascript:void(0)" id="e_watchlisted_reason_form">
                    <div class="modal-body">
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Code" id="ewm_code" name="ewm_code">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Reason Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Reason Name" id="ewm_reason_name" name="ewm_reason_name">
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera" id="btn_edit_reasons">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="btnClose();">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>