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
                                <li class="breadcrumb-item"> Position</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Position</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Add New Position / Rank</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="position_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Position Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Position Code" id="position_code" name="position_code">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Position Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Position Name" id="position_name" name="position_name">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Department <span class="text-danger">*</span></label>
                                            <select class="custom-select" id="department" name="department">
                                                <option value="">Choose option</option>
                                                <?php foreach ($department_list as $value) : ?>
                                                    <option value="<?= $value['id'] ?>"><?= $value['department_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="text-muted">Age Limit</label>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Maximum Age (New Crew) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Maximum Age (New Crew)" id="maximum_age_new" name="maximum_age_new" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Maximum Age (Ex Crew) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Maximum Age (Ex Crew)" id="maximum_age_ex" name="maximum_age_ex" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="text-muted">Boarding Experience (in month)</label>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Minimum Experience <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Minimum Experience" id="minimum_exp" name="minimum_exp" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Maximum Experience <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Maximum Experience" id="maximum_exp" name="maximum_exp" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btn_save_position">Add</button>
                                        <button type="button" id="ResetBtn" class="btn btn-secondary">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">List of Position / Rank</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered" id="position_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>Position Code</th>
                                                <th>Position Name</th>
                                                <th>Age Limit</th>
                                                <th>Experience</th>
                                                <th>Department</th>
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

    <!-- EDIT POSITION MODAL -->
    <div class="modal fade bs-example-modal-center" id="edit_position_form" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-18 m-0">Edit Position</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="btnClose();">×</button>
                </div>
                <form action="javascript:void(0)" id="e_position_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Position Code</label>
                                    <input type="hidden" class="form-control" id="e_position_id" name="e_position_id">
                                    <input type="text" class="form-control" placeholder="Position Code" id="e_position_code" name="e_position_code">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Position Name</label>
                                    <input type="text" class="form-control" placeholder="Position Name" id="e_position_name" name="e_position_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="custom-select" id="e_department" name="e_department">
                                        <option value="">Choose option</option>
                                        <?php foreach ($department_list as $value) : ?>
                                            <option value="<?= $value['id'] ?>"><?= $value['department_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="text-muted">Age Limit</label>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Maximum Age (New Crew)</label>
                                    <input type="text" class="form-control" placeholder="Maximum Age (New Crew)" id="e_maximum_age_new" name="e_maximum_age_new">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Maximum Age (Ex Crew)</label>
                                    <input type="text" class="form-control" placeholder="Maximum Age (Ex Crew)" id="e_maximum_age_ex" name="e_maximum_age_ex">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="text-muted">Boarding Experience (in month)</label>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Minimum Experience</label>
                                    <input type="text" class="form-control" placeholder="Minimum Experience" id="e_minimum_exp" name="e_minimum_exp">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Maximum Experience</label>
                                    <input type="text" class="form-control" placeholder="Maximum Experience" id="e_maximum_exp" name="e_maximum_exp">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-alphera" id="btn_edit_position">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="btnClose();">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/position.js') ?>"></script>