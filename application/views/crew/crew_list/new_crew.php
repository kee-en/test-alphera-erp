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
                                <li class="breadcrumb-item"> <a href="#">Crew List</a></li>
                                <li class="breadcrumb-item"> New Crew</li>
                            </ol>
                        </div>
                        <h4 class="page-title">New Crew</h4>
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
                                    <p class="text-alphera font-20 m-0">New Crew</p>
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
                                                <a class="dropdown-item" href="javascript: void(0);" onclick="PrintReport('csv','new')">CSV</a>
                                                <a class="dropdown-item" href="javascript: void(0);" onclick="PrintReport('excel','new')">EXCEL</a>
                                                <a class="dropdown-item" href="<?= base_url("print-new-crews") ?>" target="_blank">PDF</a>
                                                <!-- <a class="dropdown-item" href="javascript: void(0);" onclick="PrintReport('pdf','new')">PDF</a> -->
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
                                $search['name_search'] || $search['rank_search'] || $search['vessel_search'] || $search['status_search'] || $search['contract_search'] || $search['flight_search']
                                || $search['month_search_from'] || $search['month_search_to']
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
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['rank_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Crew Rank: <?= $this->global->getPositionById($search['rank_search'])['position_name'] ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['vessel_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Name of Vessel: <?= $this->global->getVesselById($search['vessel_search'])['vsl_name'] ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['status_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Crew Status: <?= $this->global->getCrewStatusForReport($search['status_search']); ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['contract_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Contract Status: <?= $search['contract_search'] ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['flight_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Flight Availability: <?= $search['flight_search'] ?>
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
                                        <?php foreach ($crew as $key) : ?>
                                            <div class="col-md-4 mb-2" id="div_applicant">
                                                <li class="list-group-item">
                                                    <div class="media">
                                                        <img class="align-self-start mr-3" id="applicant_img" src="<?= $this->applicant_registered->getApplicantPhoto("{$this->global->ecdc('ec',$key['applicant_code'])}"); ?>" alt="" width="60">
                                                        <div class="media-body">
                                                            <h5 class="mt-1 mb-0 font-17"><?= $key['full_name'] ?> (<?= $key['position_code'] ?>)</h5>
                                                            <?= $this->global->getCrewStatus($key['status']) ?>
                                                            <p class="text-muted m-0 font-15"><?= $key['city_name'] ?>, <?= $key['province_name'] ?></p>
                                                            <p class="text-muted m-0 font-15">Date of Availability: <?= (!$key['date_available'] ? '<span class="text-alphera text-underline">No Specific Date</span>' : date('M j, Y', strtotime($key['date_available']))) ?></p>
                                                            <p class="text-muted m-0 font-15">POEA Contract:
                                                                <?= $this->crew_management->get_contract_validity($key['crew_code']) ?>
                                                            </p>
                                                            <?= $this->global->getCrewWarningLetterCount($key['crew_code']) ?>
                                                            <?= $this->global->getCrewWatchlistStatus($key['crew_code']) ?>
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
                                                                <p class="mb-0 text-muted text-truncate font-15">Licenses</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <?= $this->crew_management->get_certificates_validity($key['crew_code']) ?>
                                                                <p class="mb-0 text-muted text-truncate font-15">Certificates</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <?= $this->medical->get_medical_validity($key['crew_code']) ?>
                                                                <p class="mb-0 text-muted text-truncate font-15">Medical</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-alphera btn-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Shipboard Employment Application" onclick="getViewEditApplicationNew('<?= $key['crew_code'] ?>')"><i class="mdi mdi-pencil"></i></button>
                                                        </div>

                                                        <div class="col">
                                                            <div class="btn-group dropdown btn-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Action">
                                                                <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-secondary" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <h6 class="dropdown-header"><b>Crew Information</b></h6>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getOnViewPrejoiningVisa('','<?= $key['crew_code']; ?>','<?= strtoupper($key['full_name']) ?> ')">View Pre-joining & Visa</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="viewCrewContracts('<?= $key['crew_code'] ?>','<?= $key['full_name'] ?>')">View Contracts (POEA / MLC)</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getMedicalRecords('<?= $key['crew_code'] ?>','<?= strtoupper($key['full_name']) ?> ')" data-toggle="modal" data-target="#v_medical_modal">View Medical</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getCrewFlightDetails('<?= $key['monitor_code'] ?>', '<?= $key['crew_code'] ?>')" data-toggle="modal" data-target="#a_flight_details_modal">View Flight Details</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getVesselHistory('<?= $key['crew_code'] ?>','<?= $key['full_name'] ?>')">View Vessel History</a>
                                                                    <?php $check = $this->all_crew->checkRequirements($key['crew_code']);
                                                                    if ($check['type'] != "complete") : ?>
                                                                        <?php $app_type = $this->global->getApplicants($key['crew_code']);
                                                                        if ($app_type['type_applicant'] === "OLD") : ?>
                                                                            <div role="separator" class="dropdown-divider"></div>
                                                                            <h6 class="dropdown-header"><b>Needs to be added:</b></h6>
                                                                            <a class="dropdown-item text-alphera" href="javascript:void(0)" <?= (($check['poea'] <= 0) ? 'style="display: none;"' : '') ?> onclick="addCrewPOEAContract('<?= $key['crew_code'] ?>','<?= strtoupper($key['full_name']) ?> ');">Add POEA Contract</a>
                                                                            <a class="dropdown-item text-alphera" href="javascript:void(0)" <?= (($check['mlc'] <= 0) ? 'style="display: none;"' : '') ?> onclick="addCrewMLCContract('<?= $key['crew_code'] ?>');">Add MLC Contract</a>
                                                                            <a class="dropdown-item text-alphera" href="javascript:void(0)" <?= (($check['medical'] <= 0) ? 'style="display: none;"' : '') ?> onclick="getMedicalDetails('<?= $key['crew_code'] ?>');">Add Medical</a>
                                                                            <a class="dropdown-item text-alphera" href="javascript:void(0)" <?= (($check['flight'] <= 0) ? 'style="display: none;"' : '') ?> onclick="getAllListFlightDetails('<?= $key['monitor_code'] ?>');" data-toggle="modal" data-target="#a_flight_details_modal">Add Flight Details</a>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
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
                                                        <th>DATE OF AVAILABILITY</th>
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
                                                        foreach ($crew as $key) :
                                                            $current_date = strtotime(date('Y-m-d'));
                                                            $contract_duration = strtotime($key['contract_duration']);
                                                            $diff = $current_date - $contract_duration;
                                                            $date_diff = round($diff / (60 * 60 * 24));
                                                            $class = "";

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
                                                                <td><?= $key['vsl_code'] ?></td>
                                                                <td><?= $key['vsl_name'] ?></td>
                                                                <td><?= $key['position_code'] ?></td>
                                                                <td><?= $key['full_name'] ?></td>
                                                                <td><?= $key['date_available'] ? date('M j, Y', strtotime($key['date_available'])) : '-' ?></td>
                                                                <?= $key['contract_duration'] ? '<td ' . $class . '>' .  date('M j, Y', strtotime($this->global->getCMP($key['monitor_code'])['disembark'])) . '</td>' : '<td>-</td>' ?>
                                                                <td>
                                                                    <?= $this->crew_management->validate_passport_table($key['crew_code']) ?>
                                                                </td>
                                                                <td>
                                                                    <?= $this->crew_management->get_license_validity_table($key['crew_code']) ?>
                                                                </td>
                                                                <td>
                                                                    <?= $this->crew_management->validate_certificates_table($key['crew_code']) ?>
                                                                </td>
                                                                <?= $this->crew_management->get_contract_validity_table($key['crew_code']) ?>
                                                                <td>
                                                                    <?= $this->crew_management->get_mlc_validity_table($key['crew_code']) ?>
                                                                </td>
                                                                <td>
                                                                    <?= $this->medical->get_medical_validity_table($key['crew_code']) ?>
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
    <script type="text/javascript" src="<?= base_url('assets/javascript/new_crew.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/javascript/a_poea_contract.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/javascript/a_mlc_contract.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/javascript/a_medical.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/javascript/a_flight_details.js') ?>"></script>