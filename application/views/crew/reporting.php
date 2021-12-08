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
                                <li class="breadcrumb-item"> <a href="#">Crew</a></li>
                                <li class="breadcrumb-item"> For Reporting</li>
                            </ol>
                        </div>
                        <h4 class="page-title">For Reporting</h4>
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
                                    <p class="text-alphera font-20 m-0">For Reporting</p>
                                    <span class="text-muted font-18">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                                </div>

                                <div class="col text-right" id="btn-collection">
                                    <div class="btn-group btn-grp-collection" role="group" aria-label="">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crew_filter"><i class="mdi mdi-filter-outline"></i> View Filters</button>

                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn btn-secondary dropdown-toggle ml-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-download"></i> Download Report
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <h6 class="dropdown-header"><b>Export As</b></h6>
                                                <a class="dropdown-item" href="javascript: void(0);" onclick="PrintReport('csv')">CSV</a>
                                                <a class="dropdown-item" href="javascript: void(0);" onclick="PrintReport('excel')">EXCEL</a>
                                                <a class="dropdown-item" href="javascript: void(0);" onclick="PrintReport('pdf')">PDF</a>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-secondary ml-1" id="btn_grid"><i class="mdi mdi-view-grid"></i></button>

                                        <button type="button" class="btn btn-secondary ml-1" id="btn_list"><i class="mdi mdi-view-list"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php if (
                                $search['name_search'] || $search['rank_search'] || $search['vessel_search']
                            ) : ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="search-display" style="padding: 0px;">
                                            <div class="container-fluid">
                                                <div class="row pt-3 pb-3 mb-3">
                                                    <div class="col-md-10">
                                                        <div class="filter-result" id="displayFilters">
                                                            <?php if ($search['name_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Crew Name: <?= $search['name_search'] ?>
                                                                    <input type="hidden" id="name_search" value="<?= $search['name_search'] ?>">
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['rank_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Crew Rank: <?= $this->global->getPositionById($search['rank_search'])['position_name'] ?>
                                                                    <input type="hidden" id="rank_search" value="<?= $search['rank_search'] ?>">
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['vessel_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Name of Vessel: <?= $this->global->getVesselById($search['vessel_search'])['vsl_name'] ?>
                                                                    <input type="hidden" id="vessel_search" value="<?= $search['vessel_search'] ?>">
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['contract_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Contract Status: <?= $search['contract_search'] ?>
                                                                    <input type="hidden" id="contract_search" value="<?= $search['contract_search'] ?>">
                                                                </span>
                                                            <?php endif; ?>

                                                            <?php if ($search['month_search_from']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    <?php if ($search['status_search'] === "3") : ?>
                                                                        Date Embarked From: <?= date('F j, Y', strtotime($search['month_search_from'])) ?>
                                                                    <?php elseif ($search['status_search'] === "4") : ?>
                                                                        Date Disembarked From: <?= date('F j, Y', strtotime($search['month_search_from'])) ?>
                                                                    <?php elseif ($search['status_search'] === "7") : ?>
                                                                        Date of Availability From: <?= date('F j, Y', strtotime($search['month_search_from'])) ?>
                                                                    <?php endif; ?>
                                                                    <input type="hidden" id="month_search_from" value="<?= $search['month_search_from'] ?>">
                                                                </span>
                                                            <?php endif; ?>

                                                            <?php if ($search['month_search_to']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    <?php if ($search['status_search'] === "3") : ?>
                                                                        Date Embarked To: <?= date('F j, Y', strtotime($search['month_search_to'])) ?>
                                                                    <?php elseif ($search['status_search'] === "4") : ?>
                                                                        Date Disembarked To: <?= date('F j, Y', strtotime($search['month_search_to'])) ?>
                                                                    <?php elseif ($search['status_search'] === "7") : ?>
                                                                        Date of Availability To: <?= date('F j, Y', strtotime($search['month_search_to'])) ?>
                                                                    <?php endif; ?>
                                                                    <input type="hidden" id="month_search_to" value="<?= $search['month_search_to'] ?>">
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

                            <div id="view_grid" style="display: none;">
                                <div class="row">
                                    <?php if ($crew) : ?>
                                        <?php foreach ($crew as $reporting) :
                                            $current_date = strtotime(date('Y-m-d'));
                                            $disembark = $this->global->getCMP($reporting['monitor_code'])['disembark'];
                                            $contract_duration = strtotime($disembark);
                                            $diff = $contract_duration - $current_date;
                                            $date_diff = round($diff / (60 * 60 * 24));
                                            $class = "";
                                            if ($date_diff >= 90) {
                                                $class = 'class="bg-light-success"';
                                            } else if ($date_diff >= 60 && $date_diff <= 90) {
                                                $class = 'class="bg-light-success"';
                                            } else if ($date_diff >= 31 && $date_diff <= 60) {
                                                $class = 'class="bg-light-warning"';
                                            } else if ($date_diff <= 30 && $date_diff >= 1) {
                                                $class = 'class="bg-light-danger"';
                                            } else if ($date_diff <= 0) {
                                                $class = 'class="bg-light-danger"';
                                            }
                                        ?>
                                            <div class="col-md-4 mb-2" id="div_applicant">
                                                <li class="list-group-item">
                                                    <div class="media">
                                                        <img class="align-self-start mr-3" id="applicant_img" src="<?= base_url('assets/images/avatar-placeholder.png') ?>" alt="" width="60">
                                                        <div class="media-body">
                                                            <h5 class="mt-1 mb-0 font-17"><?= $reporting['full_name'] ?> (<?= $reporting['position_code'] ?>)</h5>
                                                            <?= $this->global->getCrewStatus($reporting['status']) ?>
                                                            <p class="text-muted m-0 font-15"><?= $reporting['city_name'] ?>, <?= $reporting['province_name'] ?></p>
                                                            <p class="text-muted m-0 font-15">Date of Disembarkation: <?= (!$disembark ? '<span class="text-alphera text-underline">No Specific Date</span>' : date('M j, Y', strtotime($disembark))) ?></p>
                                                            <?= $this->global->getCrewWarningLetterCount($reporting['crew_code']) ?>
                                                            <?= $this->global->getCrewWatchlistStatus($reporting['crew_code']) ?>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row text-center">
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <?= $this->crew_management->validate_passport($reporting['crew_code']) ?>
                                                                <p class="mb-0 text-muted text-truncate font-15">Passport</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <?= $this->crew_management->get_license_validity($reporting['crew_code']) ?>
                                                                <p class="mb-0 text-muted text-truncate font-15">Licenses</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <?= $this->crew_management->get_contract_validity($reporting['crew_code']) ?>
                                                                <p class="mb-0 text-muted text-truncate font-15">Contracts</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <?= $this->medical->get_medical_validity($reporting['crew_code']) ?>
                                                                <p class="mb-0 text-muted text-truncate font-15">Medical</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-alphera btn-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Shipboard Employment Application" onclick="getViewEditApplication('<?= $reporting['crew_code'] ?>')"><i class="mdi mdi-pencil"></i></button>
                                                        </div>

                                                        <div class="col">
                                                            <div class="btn-group dropdown btn-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Action">
                                                                <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-secondary" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <h6 class="dropdown-header"><b>Crew Informations</b></h6>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getOnViewPrejoiningVisa('','<?= $reporting['crew_code']; ?>','<?= strtoupper($reporting['full_name']) ?>')">View Pre-joining & Visa</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="viewCrewContracts('<?= $reporting['crew_code'] ?>', '<?= $reporting['full_name'] ?>')">View Contracts (POEA / MLC)</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#v_medical_modal" onclick="getMedicalRecords('<?= $reporting['crew_code'] ?>', '<?= $reporting['full_name'] ?>')">View Medical</a>
                                                                    <div role="separator" class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getCrewReporting('<?= $reporting['crew_code'] ?>', '<?= $reporting['full_name'] ?>')">Add to On Vacation</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="col-md-12">
                                            <p class="text-muted text-center font-18 mt-5 mb-5">There is no crew at the moment.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="row justify-content-between mt-3">
                                    <div class="col" id="navigation-align">
                                        <nav>
                                            <?= $this->pagination->create_links(); ?>
                                        </nav>
                                    </div>
                                    <div class="col">
                                        <div class="count-pagination"><span><?= $showing_entries; ?></span></div>
                                    </div>
                                </div>
                            </div>

                            <div id="view_list">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm table-hover">
                                                <thead class="text-center thead-alphera">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>CODE</th>
                                                        <th>VESSEL</th>
                                                        <th>RANK</th>
                                                        <th>NAME</th>
                                                        <th>S/ON</th>
                                                        <th>DATE OF DISEMBARKATION</th>
                                                        <th>PASSPORT</th>
                                                        <th>LICENSES</th>
                                                        <th>CERTIFICATES</th>
                                                        <th>POEA</th>
                                                        <th>MLC</th>
                                                        <th>MEDICAL</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="text-center">
                                                    <?php if ($crew) : ?>
                                                        <?php $count = $count_page;
                                                        foreach ($crew as $reporting) :
                                                            $current_date = strtotime(date('Y-m-d'));
                                                            $disembark = $this->global->getCMP($reporting['monitor_code'])['disembark'];
                                                            $contract_duration = strtotime($disembark);
                                                            $diff = $contract_duration - $current_date;
                                                            $lagpas_60 = $contract_duration - $current_date;

                                                            $date_diff = round($diff / (60 * 60 * 24));
                                                            $excess_5 = round($lagpas_60 / (60 * 60 * 24));

                                                            $class = "";
                                                            $class_lagpas = "";

                                                            if ($disembark) {
                                                                if ($excess_5 <= 5) {
                                                                    $class_lagpas = 'class="bg-danger text-white"';
                                                                } else {
                                                                    $class_lagpas = '';
                                                                }
                                                            }


                                                            if ($date_diff >= 90) {
                                                                $class = '';
                                                            } else if ($date_diff >= 60 && $date_diff <= 90) {
                                                                $class = 'class="bg-success text-white"';
                                                            } else if ($date_diff >= 31 && $date_diff <= 60) {
                                                                $class = 'class="bg-warning"';
                                                            } else if ($date_diff <= 30 && $date_diff >= 1) {
                                                                $class = 'class="bg-danger text-white"';
                                                            } else if ($date_diff <= 0) {
                                                                $class = 'class="bg-danger text-white"';
                                                            }

                                                        ?>
                                                            <tr>
                                                                <td><?= ++$count ?></td>
                                                                <td><?= $reporting['vsl_code'] ?></td>
                                                                <td><?= $reporting['vsl_name'] ?></td>
                                                                <td><?= $reporting['position_code'] ?></td>
                                                                <td><?= $reporting['full_name'] ?></td>
                                                                <td><?= $this->global->getCMP($reporting['monitor_code'])['sign_on'] ?></td>
                                                                <td <?= $class ?>><?= date('M j, Y', strtotime($this->global->getCMP($reporting['monitor_code'])['disembark'])) ?></td>
                                                                <td>
                                                                    <?= $this->crew_management->validate_passport_table($reporting['crew_code']) ?>
                                                                </td>
                                                                <td>
                                                                    <?= $this->crew_management->get_license_validity_table($reporting['crew_code']) ?>
                                                                </td>
                                                                <td>
                                                                    <?= $this->crew_management->validate_certificates_table($reporting['crew_code']) ?>
                                                                </td>
                                                                <?= $this->crew_management->get_contract_validity_table($reporting['crew_code']) ?>
                                                                <td>
                                                                    <?= $this->crew_management->get_mlc_validity_table($reporting['crew_code']) ?>
                                                                </td>
                                                                <td>
                                                                    <?= $this->medical->get_medical_validity_table($reporting['crew_code']) ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="13" class="text-center">There is no crew at the moment.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-between mt-3">
                                    <div class="col" id="navigation-align">
                                        <nav>
                                            <?= $this->pagination->create_links(); ?>
                                        </nav>
                                    </div>
                                    <div class="col">
                                        <div class="count-pagination">
                                            <span>
                                                <?= $showing_entries; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#btn_grid").click(function() {
            $("#view_grid").show();
            $("#view_list").hide();
        })

        $("#btn_list").click(function() {
            $("#view_grid").hide();
            $("#view_list").show();
        })
    </script>
    <script type="text/javascript" src="<?= base_url('assets/javascript/for_reporting.js') ?>"></script>