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
                                <li class="breadcrumb-item"> <a href="#">Points of Interview Form</a></li>
                                <li class="breadcrumb-item"> Manage Points of Interview</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Manage Points of Interview</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Add Points of Interview Per Position</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <div class="card-body">
                            <form action="javascript:void(0)" id="position_points_form">
                                <div class="row">
                                    <div class="col md-6">
                                        <label>Select Rank / Position <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select class="custom-select" id="position_list" name="position_list">
                                                <option value="0">Choose option</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-alphera" id="btn_save_points_interview">Save Changes</button>
                                            </div>
                                        </div>

                                        <ul class="parsley-errors-list filled" id="position_list_alert"></ul>
                                    </div>
                                </div>

                                <hr>

                                <div class="row" id="points_list">

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/javascript/manage_points.js') ?>"></script>