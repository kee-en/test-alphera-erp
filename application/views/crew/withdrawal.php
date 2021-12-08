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
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Crew</a></li>
                                <li class="breadcrumb-item">Withdrawal (TOC)</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Withdrawal (TOC)</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-3">
                    <form action="javascript:void(0)" id="crew_withdrawal_application">
                        <div class="card">
                            <div class="card-header">
                                <p class="text-alphera font-20 m-0">Add Crew for Withdrawal</p>
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
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Type of Department <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="w_department" name="w_department">
                                                <option value="0">Choose option</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Vessel <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="w_vessel" name="w_vessel">
                                                <option value="0">Choose option</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Reason <span class="asterisk">*</span></label>
                                            <select class="custom-select" id="w_reasons" name="w_reasons">
                                                <option value="0">Choose option</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Remarks</label>
                                            <textarea class="form-control" id="w_remarks" name="w_remarks" rows="5" placeholder=""></textarea>
                                        </div>
                                        <input type="hidden" id="w_crew_code" name="w_crew_code">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btn_save_withdrawal">Add</button>
                                        <button type="button" class="btn btn-secondary" id="btnResetWithdrawal">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col" style="margin: auto;">
                                    <p class="text-alphera font-20 m-0">List of Withdrawal (TOC)</p>
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
                                                <th>Date Added</th>
                                                <th>Issued By</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php if ($crew) : ?>
                                                <?php $count = 1;
                                                foreach ($crew as $key) : ?>
                                                    <tr>
                                                        <td><?= $count ?></td>
                                                        <td><?= $key['full_name'] ?></td>
                                                        <td><?= $key['position_code'] ?></td>
                                                        <td><?= $key['vsl_name'] ?></td>
                                                        <td><?= date('M j, Y', strtotime($key['date_created'])) ?></td>
                                                        <td><?= htmlentities((($key['issued_by'] == null) ? "Something Went Wrong" : $this->global->getAccountDetails($this->global->ecdc('dc',$key['issued_by'])))['full_name'], ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= $key['remarks'] ?></td>
                                                        <td><?= $key['status'] == '1' ? "TOC" : "For Approval" ?></td>
                                                        <td>
                                                            <?php if($key['status'] === "2"): ?>
                                                                <span class="badge badge-warning-outline">FOR APPROVAL</span>
                                                            <?php else : ?>
                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="unWithdrawal('<?= $key['crew_code'] ?>','<?= $key['full_name'] ?>')">Remove</button>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php $count++;
                                                endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        <p class="m-0">No data available in table</p>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
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
    <script type="text/javascript" src="<?= base_url('assets/javascript/crew_withdrawal.js') ?>"></script>