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
                                <li class="breadcrumb-item"> <a href="#">Crew List</a></li>
                                <li class="breadcrumb-item"> Withdrawal Crew</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Withdrawal Crew</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col" style="margin: auto;">
                                    <p class="text-alphera font-20 m-0">List of Withdrawal Crew</p>
                                </div>

                                <div class="col-md-2">
                                    <select class="custom-select" id="export_withdraw" name="export_withdraw">
                                        <option value="">Export As</option>
                                        <option value="1">CSV</option>
                                        <option value="2">Excel</option>
                                        <option value="3">PDF</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="javascript:void(0)" id="search_crew_withdraw">
                                <div class="row">
                                    <div class="col">
                                        <label>Crew Name</label>
                                        <input type="text" id="s_crew_withdraw" name="s_crew_withdraw" class="form-control" placeholder="Enter Crew Name" value="">
                                    </div>

                                    <div class="col">
                                        <label>Name of Vessel</label>
                                        <select class="custom-select" id="s_crew_vessel" name="s_crew_vessel">
                                            <option value="">Vessel</option>
                                        </select>
                                    </div>

                                    <div class="col">
                                        <label>Date Availability From</label>
                                        <input type="date" class="form-control" id="s_crew_available_from" name="s_crew_available_from" value="">
                                    </div>

                                    <div class="col">
                                        <label>Date Availability To</label>
                                        <input type="date" class="form-control" id="s_crew_available_to" name="s_crew_available_to" value="">
                                    </div>

                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block" id="btnSearch">Search</button>
                                    </div>

                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="reset" class="btn btn-secondary btn-block" id="btnResetForm">Reset</button>
                                    </div>
                                </div>
                            </form>

                            <hr>

                            <div class="row">
                                <?php if ($crew) : ?>
                                    <?php foreach ($crew as $key) : ?>
                                        <div class="col-md-4 mb-2">
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <img class="align-self-start mr-3" src="<?= base_url('assets/images/avatar-placeholder.png') ?>" alt="" width="60">
                                                    <div class="media-body">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h5 class="mt-1 mb-1 font-18"><?= $key['full_name'] ?> (<?= $key['position_code'] ?>)</h5>
                                                            <div class="btn-group dropdown">
                                                                <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal font-18 text-muted"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="showShipboardAppW('<?= $key['crew_code'] ?>');">View Shipboard Application</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getViewEditPrejoining('<?= $key['crew_code'] ?>');">View Pre-joining & Visa</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="viewCrewContracts('<?= $key['crew_code'] ?>');" >View Contracts</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getMedicalRecords('<?= $key['crew_code'] ?>');">View Medical</a>
                                                                    <div role="separator" class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getVesselHistory('<?= $key['crew_code'] ?>','<?= $key['full_name'] ?>')">View Vessel History</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?= $this->global->getCrewStatus($key['status']) ?>
                                                        <p class="text-muted m-0 font-weight-medium font-15"><?= $key['city_name'] ?>, <?= $key['province_name'] ?></p>
                                                        <p class="text-muted m-0 font-15">Date of Availability: <?= (!$key['date_available'] ? '<span class="text-alphera text-underline">No Specific Date</span>' : date('M j, Y', strtotime($key['date_available']))) ?></p>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row text-center">
                                                    <div class="col-3" id="applicant_data">
                                                        <div class="m-0">
                                                            <?= $this->crew_management->validate_passport($key['crew_code']) ?>
                                                            <p class="mb-0 text-muted text-truncate font-15">Passport</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-3" id="applicant_data">
                                                        <div class="m-0">
                                                            <?= $this->crew_management->get_license_validity($key['crew_code']) ?>
                                                            <p class="mb-0 text-muted text-truncate font-15">Licenses Validity</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-3" id="applicant_data">
                                                        <div class="m-0">
                                                            <?= $this->crew_management->get_contract_validity($key['crew_code']) ?>
                                                            <p class="mb-0 text-muted text-truncate font-15">POEA Validity</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-3" id="applicant_data">
                                                        <div class="m-0">
                                                            <?= $this->medical->get_medical_validity($key['crew_code']) ?>
                                                            <p class="mb-0 text-muted text-truncate font-15">Medical Status</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-alphera btn-block" onclick="getViewEditApplicationW('<?= $key['crew_code'] ?>')">View / Edit Shipboard Application</button>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="col-md-12">
                                        <p class="text-muted text-center mt-5 mb-5 font-18">There is no crew at the moment.</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-8" id="navigation-align">
                                    <nav>
                                        <?= $this->pagination->create_links() ?>
                                    </nav>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="count-pagination"><span><?= $showing_entries ?></span></div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/javascript/withdrawal.js') ?>"></script>