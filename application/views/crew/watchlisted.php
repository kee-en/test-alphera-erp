<style>
    .select2-container .select2-selection--single {
        letter-spacing: 1px;
        padding: 0.45rem 0.9rem;
        font-size: 15px;
        font-weight: 400;
        line-height: 1.5;
        color: #3b3f5c;
        background-color: #fff;
        border-radius: 8px;
    }

    .select2-container .select2-selection--single {
        border: 1px solid #ced4da;
        height: 40px;
        outline: 0;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 25px;
        padding-left: 0px !important;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 50px;
        width: 34px;
        right: 0px;
    }
</style>

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
                                <li class="breadcrumb-item"> <a href="#">Crew</a></li>
                                <li class="breadcrumb-item"> Crew Watchlisted</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Crew Watchlisted</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-3">
                    <form action="javascript:void(0)" id="crew_watchlisted_form">
                        <div class="card">
                            <div class="card-header">
                                <p class="text-alphera font-20 m-0">Add Crew for Watchlisted</p>
                                <span class="text-muted">Fill up the required fields below.</span>
                            </div>
                            <div class="card-body" id="w_crew_div">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name of Crew <span class="asterisk">*</span></label>
                                            <select class="custom-select" data-toggle="select2" id="w_crew_name" name="w_crew_name" style="width: 100%;">
                                                <option value="0">SELECT CREW NAME</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Rank / Position <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="w_rank" name="w_rank">
                                                <option value="0">Choose option</option>
                                                <?php foreach ($position_list as $value) : ?>
                                                    <option value="<?= $value['id'] ?>"><?= $value['position_code'] ?> - <?= $value['position_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Type of Department <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="w_department" name="w_department">
                                                <option value="0">Choose option</option>
                                                <?php foreach ($department_list as $value) : ?>
                                                    <option value="<?= $value['id'] ?>"><?= $value['department_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Vessel <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="w_vessel" name="w_vessel">
                                                <option value="0">Choose option</option>
                                                <?php foreach ($vessel_list as $value) : ?>
                                                    <option value="<?= $value['id'] ?>"><?= $value['vsl_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Certificates <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="w_certificates" name="w_certificates">
                                                <option value="">Choose option</option>
                                                <option value="POEA">POEA Certificates</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>E-Registration Number <span class="asterisk">*</span></label>
                                            <input type="text" class="form-control" placeholder="E-Registration Number" id="w_registration_no" name="w_registration_no" onkeypress="return isNumberKey(event)">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Remarks</label>
                                            <textarea class="form-control" id="w_remarks" name="w_remarks" rows="5" placeholder=""></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btn_save_watchlisted">Add</button>
                                        <button type="button" class="btn btn-secondary" id="btnResetWatchlisted">Reset</button>
                                    </div>
                                </div>

                                <input type="hidden" class="form-control" value="" name="search" id="search">
                                <input type="hidden" class="form-control" value="" name="w_applicant_code" id="w_applicant_code">
                                <input type="hidden" class="form-control" value="" name="w_cname" id="w_cname">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col" style="margin: auto;">
                                    <p class="text-alphera font-20 m-0">List of Crew Watchlisted</p>
                                </div>

                                <div class="col-md-3">
                                    <select class="custom-select" id="cw_export_as" name="cw_export_as">
                                        <option value="">Export As</option>
                                        <option value="csv">CSV</option>
                                        <option value="excel">Excel</option>
                                        <option value="pdf">PDF</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered" id="crew_watchlisted_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>ID</th>
                                                <th>Full Name</th>
                                                <th>Rank</th>
                                                <th>Vessel</th>
                                                <th>Certificates</th>
                                                <th>E-Registration No.</th>
                                                <th>Date Added</th>
                                                <th>Issued By</th>
                                                <th>Remarks</th>
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

    <script type="text/javascript" src="<?= base_url('assets/javascript/watchlist.min.js') ?>"></script>