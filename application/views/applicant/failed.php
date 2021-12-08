<?= link_tag('assets/custom/css/global.min.css') ?>

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
                                <li class="breadcrumb-item"> <a href="#">Recruitment</a></li>
                                <li class="breadcrumb-item"> Not Qualified</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Not Qualified</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8" id="lbl-title">
                                    <p class="text-alphera font-20 m-0">List of Not Qualified Applicants</p>
                                    <span class="text-muted font-18">These are the applicants that recently <span class="text-underline">not qualified</span> their application by the assessor(s).</span>
                                </div>

                                <div class="col text-right" id="btn-collection">
                                    <div class="btn-group btn-grp-collection" role="group" aria-label="">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#recruitment_filter"><i class="mdi mdi-filter-outline"></i> View Filters</button>

                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn btn-secondary dropdown-toggle ml-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-download"></i> Download Report
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <h6 class="dropdown-header"><b>Export As</b></h6>
                                                <a class="dropdown-item" href="<?= base_url('print-notqualified-applicant-csv') ?>">CSV</a>
                                                <a class="dropdown-item" href="<?= base_url('print-notqualified-applicant-xl') ?>">EXCEL</a>
                                                <a class="dropdown-item" href="<?= base_url('print-not-qualified-applicants') ?>" target="_blank">PDF</a>

                                                <!-- <a class="dropdown-item" href="<?= base_url('print-notqualified-applicant-pdf') ?>">PDF</a> -->
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-secondary ml-1"><i class="mdi mdi-view-grid"></i></button>

                                        <button type="button" class="btn btn-secondary ml-1"><i class="mdi mdi-view-list"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php if ($search['name_search'] != NULL || $search['status_search'] != NULL || $search['vessel_search'] || $search['rank_search'] || $search['month_search_to'] || $search['month_search_from']) : ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="search-display" style="padding: 0px;">
                                            <div class="container-fluid">
                                                <div class="row pt-3 pb-3 mb-3">
                                                    <div class="col-md-10">
                                                        <div class="filter-result" id="displayFilters">
                                                            <?php if ($search['name_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Applicant Name: <?= $search['name_search'] ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['vessel_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Name of Vessel: <?= $this->global->getVesselById($search['vessel_search'])['vsl_name'] ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['rank_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Rank: <?= $this->global->getPosition($search['rank_search'])['position_name'] ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['status_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Application Status: <?= $this->global->getApplicantStatusForReports($search['status_search']) ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['month_search_to'] && $search['month_search_from']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Date Availability From: <?= date('F j, Y', strtotime($this->session->userdata('month_search_from'))) ?>
                                                                </span>
                                                                <span class="mr-1 mb-1">
                                                                    Date Availability To: <?= date('F j, Y', strtotime($this->session->userdata('month_search_to'))) ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 text-right" style="margin: auto;">
                                                        <button type="button" class="btn btn-alphera btn-xs" id="BtnResetSearch">Reset Filters</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <?php if (!empty($applicants)) : ?>
                                    <?php foreach ($applicants as $key) : ?>
                                        <div class="col-md-4 mb-2" id="div_applicant">
                                            <li class="list-group-item">
                                                <div class="media">
                                                    <img class="align-self-start mr-3" id="applicant_img" src="<?= $this->applicant_registered->getApplicantPhoto("{$this->global->ecdc('ec',$key['applicant_code'])}"); ?>" alt="" width="60">
                                                    <div class="media-body">
                                                        <h5 class="mt-1 mb-0 font-17"><?= $key['full_name'] ?></h5>
                                                        <?= $this->global->getApplicantStatus($key['status']) ?>
                                                        <p class="text-muted m-0 font-15"><?= $key['city_name']; ?>, <?= $key['province_name'] ?></p>
                                                        <p class="text-muted m-0 font-15">Date of Availability: <?= (!$key['date_available'] ? '<span class="text-alphera text-underline">No Specific Date</span>' : date('M j, Y', strtotime($key['date_available']))) ?></p>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row text-center">
                                                    <div class="col-3" id="applicant_data">
                                                        <div class="m-0">
                                                            <h4 class="m-0 font-15"><?= (!$key['position_one'] ? '<span class="text-danger">-</span>' : $key['position_one']) ?></h4>
                                                            <p class="mb-0 text-muted text-truncate font-15">1st Position</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-3" id="applicant_data">
                                                        <div class="m-0">
                                                            <h4 class="m-0 font-15"><?= (!$key['position_second'] ? '<span class="text-danger">-</span>' : $key['position_second']) ?></h4>
                                                            <p class="mb-0 text-muted text-truncate font-15">2nd Position</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-3" id="applicant_data">
                                                        <div class="m-0">
                                                            <?= $this->global->getBMIScore($key['height'], $key['weight']); ?>
                                                            <p class="mb-0 text-muted text-truncate font-15">BMI</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-3" id="applicant_data">
                                                        <div class="m-0">
                                                            <?php if ($key['nat_result'] >= 50) : ?>
                                                                <?php $color = 'text-success'; ?>
                                                            <?php else : ?>
                                                                <?php $color = 'text-danger'; ?>
                                                            <?php endif; ?>
                                                            <h4 class="m-0 font-15 <?= $color; ?>" title="<?= (!$key['nat_result'] ? 'NO RESULT AVAILABLE' : $key['nat_result'] . '%') ?>"><?= (!$key['nat_result'] ? '<span class="text-danger">-</span>' : $key['nat_result'] . '%') ?></h4>
                                                            <p class="mb-0 text-muted text-truncate font-15">NAT Result</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col">
                                                        <button type="button" class="btn btn-alphera btn-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Shipboard Employment Application" onclick="getApplicantDetails('<?= $key['applicant_code'] ?>')"><i class="mdi mdi-eye"></i></button>
                                                    </div>

                                                    <div class="col">
                                                        <div class="btn-group dropdown btn-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Action">
                                                            <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-secondary" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="viewFailedReason('<?= $key['applicant_code'] ?>')">View Reason for Rejection</a>
                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="getVesselHistory('<?= $key['applicant_code'] ?>','<?= $key['full_name'] ?>')">View Vessel History</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="col-md-12">
                                        <p class="text-muted text-center mt-5 mb-5 font-18">There is no applicant at the moment.</p>
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
                                    <div class="count-pagination"><span><?= $applicant_count ?></span></div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/v_shipboard_application.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/javascript/failed.js') ?>"></script>