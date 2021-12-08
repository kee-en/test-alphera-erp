<?= link_tag('assets/custom/css/global.min.css') ?>

<style>
    .select2-container--default .select2-selection--single {
        background-color: #d7d7d7;
        border: 1px solid #d7d7d7;
        border-radius: 2px;
        font-weight: 500;
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
                                <li class="breadcrumb-item"> Manage CM Plan</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Manage CM Plan</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col" id="lbl-title">
                                    <p class="text-alphera font-20 m-0">Crew Management Plan</p>
                                    <span class="text-muted font-18">These are the crew that passed to the recruitment.</span>
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
                                                <a class="dropdown-item" href="javascript: void(0);" onclick="PrintCMPReport('csv')">CSV</a>
                                                <a class="dropdown-item" href="javascript: void(0);" onclick="PrintCMPReport('excel')">EXCEL</a>
                                                <a class="dropdown-item" href="<?= base_url("print-cm-plan") ?>" target="_blank">PDF</a>
                                                <!-- <a class="dropdown-item" href="javascript: void(0);" onclick="PrintCMPReport('pdf')">PDF</a> -->
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
                                                            <?php if ($search['status_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Crew Status: <?= $this->global->getCrewStatusForReport($search['status_search']); ?>
                                                                    <input type="hidden" id="status_search" value="<?= $search['status_search'] ?>">
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['contract_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Contract Status: <?= $search['contract_search'] ?>
                                                                    <input type="hidden" id="contract_search" value="<?= $search['contract_search'] ?>">
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($search['flight_search']) : ?>
                                                                <span class="mr-1 mb-1">
                                                                    Flight Availability: <?= $search['flight_search'] ?>
                                                                    <input type="hidden" id="flight_search" value="<?= $search['flight_search'] ?>">
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
                                        <?php foreach ($crew as $key) : ?>
                                            <div class="col-md-4 mb-2" id="div_applicant">
                                                <li class="list-group-item">
                                                    <div class="media">
                                                        <img class="align-self-start mr-3" id="applicant_img" src="<?= $this->applicant_registered->getApplicantPhoto("{$this->global->ecdc('ec',$key['applicant_code'])}"); ?>" alt="" width="60">
                                                        <div class="media-body">
                                                            <div class="d-flex w-100 justify-content-between">
                                                                <h5 class="mt-1 mb-0 font-17"><?= $key['full_name'] ?></h5>
                                                                <div class="btn-group dropdown">
                                                                    <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-secondary btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <h6 class="dropdown-header"><b>Off Signer Crew Information</b></h6>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="getViewEditApplicationCMP('<?= $key['crew_code'] ?>')">Edit Shipboard Application</a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="getViewPrejoiningVisa('<?= $key['crew_code'] ?>','<?= $key['full_name'] ?>')">View Pre-joining & Visa</a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewCrewContracts('<?= $key['crew_code'] ?>','<?= $key['full_name'] ?>')">View Contracts (POEA / MLC)</a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="getMedicalRecords('<?= $key['crew_code'] ?>','<?= $key['full_name'] ?>')" data-toggle="modal" data-target="#v_medical_modal">View Medicals</a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="getVesselHistory('<?= $key['crew_code'] ?>','<?= $key['full_name'] ?>','<?= $key['applicant_code'] ?>')">View Vessel History</a>
                                                                        <?php
                                                                        $contract = $this->contracts->getCrewPOEA($key['crew_code']);
                                                                        $hidden_edit = "";
                                                                        $hidden_view = "hidden";
                                                                        if (!empty($contract)) {
                                                                            $hidden_edit = $contract["status"] == "2" ? "hidden" : "";
                                                                            $hidden_view = $contract["status"] == "2" ? "" : "hidden";
                                                                        }
                                                                        ?>
                                                                        <div role="separator" class="dropdown-divider"></div>
                                                                        <h6 class="dropdown-header"><b>Manage CM Plan</b></h6>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editCMPlan('<?= $key['cmp_code'] ?>','<?= $key['status'] ?>')" <?= $hidden_edit ?>>Edit CM Plan</a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewCMPlan('<?= $key['cmp_code'] ?>','<?= $key['status'] ?>')" <?= $hidden_view ?>>View CM Plan</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?= $this->global->getCrewStatus($key['status']) ?>
                                                            <p class="text-muted m-0 font-15"><?= $key['city_name'] ?>, <?= $key['province_name'] ?></p>
                                                            <p class="text-muted m-0 font-15">Date of Disembarkation:
                                                                <?= (!$key['disembark'] ?
                                                                    "<span class=\"text-alphera text-underline\">
                                                                        <a class=\"m-0 font-15 text-alphera\" href=\"javascript:void(0)\"
                                                                            onclick=\"editCMPlan('{$key['cmp_code']}','{$key['status']}')\">
                                                                            No Specific Date
                                                                        </a>
                                                                    </span>" : date('M j, Y', strtotime($key['disembark']))) ?>
                                                            </p>
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
                                                                <h4 class="m-0 font-15"><?= $key['position_code'] ?></h4>
                                                                <p class="mb-0 text-muted text-truncate font-15">Rank</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <h4 class="m-0 font-15"><?= $key['vsl_code'] ?></h4>
                                                                <p class="mb-0 text-muted text-truncate font-15">Vessel</p>
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
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <div class="input-group">
                                                                <?= $this->crew_management->getOnSignerCrew($key['position_id'], $key['cmp_code'], $key['monitor_code'], 1) ?>
                                                                <div class="input-group-append" id="onsigner_menu_<?= $key['cmp_code'] ?>" style="display: <?= ($key['insigner']) ? "" : "none" ?>;">
                                                                    <button class="btn btn-alphera dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></button>
                                                                    <div class="dropdown-menu">
                                                                        <h6 class="dropdown-header"><b>On Signer Crew Information</b></h6>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="showShipboardAppOnsigner('<?= $key['cmp_code'] ?>');">View Shipboard Application</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="getOnViewPrejoiningVisa('<?= $key['cmp_code'] ?>');">View Pre-joining & Visa</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="OnviewCrewContracts('<?= $key['cmp_code'] ?>');">View Contracts (POEA / MLC)</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="getOnMedicalRecords('<?= $key['cmp_code'] ?>');">View Medical</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="getInsignerVesselHistory('<?= $key['cmp_code'] ?>','<?= $key['applicant_code'] ?>');">View Vessel History</a>
                                                                        <div role="separator" class="dropdown-divider"></div>
                                                                        <h6 class="dropdown-header"><b>Pre-Joining Routing Slip</b></h6>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="getViewPrejoiningRoutingSlip('<?= $key['insigner'] ?>')">Manage Routing Slip</a>
                                                                        <div role="separator" class="dropdown-divider"></div>
                                                                        <a class="dropdown-item text-alphera" href="javascript:void(0)" onclick="removeOnSigner('<?= $key['cmp_code'] ?>')">Remove as On Signer</a>
                                                                    </div>
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
                                            <?= $this->pagination->create_links(); ?>
                                        </nav>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <div class="count-pagination"><span><?= $showing_entries; ?></span></div>
                                    </div>
                                </div>
                            </div>

                            <div id="view_list">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm table-hover" id="gf_alphera_table">
                                                <thead class="text-center thead-alphera">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>CODE</th>
                                                        <th>VESSEL</th>
                                                        <th>RANK</th>
                                                        <th>NAME</th>
                                                        <th>GRADE</th>
                                                        <th>S/ON</th>
                                                        <th>END <br>CONTRACT</th>
                                                        <th>MEDICAL <br>STATUS</th>
                                                        <th>MONTHS <br>ONBOARD</th>
                                                        <th>X DATE</th>
                                                        <th>X PORT</th>
                                                        <th>RELIEVER</th>
                                                        <th>REMARKS</th>
                                                        <th>STATUS</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="text-center">
                                                    <?php if ($crew) : ?>
                                                        <?php $count = $count_page;
                                                        foreach ($crew as $key) :
                                                            $current_date = strtotime(date('Y-m-d'));
                                                            $contract_duration = strtotime($key['disembark']);
                                                            $diff = $contract_duration - $current_date;
                                                            $lagpas_60 = $contract_duration - $current_date;

                                                            $date_diff = round($diff / (60 * 60 * 24));
                                                            $excess_5 = round($lagpas_60 / (60 * 60 * 24));

                                                            $class = "";
                                                            $class_lagpas = "";

                                                            if ($key['disembark']) {
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
                                                                <td <?= $class_lagpas ?>><?= ++$count ?></td>
                                                                <td><?= $key['vsl_code'] ?></td>
                                                                <td><?= $key['vsl_name'] ?></td>
                                                                <td><?= $key['position_code'] ?></td>
                                                                <td><?= $key['full_name'] ?></td>
                                                                <td><?= $key['grade'] ? $key['grade'] : '-' ?></td>
                                                                <td><?= $key['embark'] ? date('M j, Y', strtotime($key['embark'])) : '-' ?></td>
                                                                <td <?= $key['disembark'] ? $class : "" ?>><?= $key['disembark'] ? date('M j, Y', strtotime($key['disembark'])) : '<span class="text-alphera font-weight-bold">No POEA Contract Issued</span>' ?></td>
                                                                <td><?= $key['crew_code'] ? $this->medical->get_medical_validity_table($key['crew_code']) : '-' ?></td>
                                                                <td><?= $key['months_onboard'] ? $key['months_onboard'] : '-' ?></td>
                                                                <td><?= $key['date_x'] ? date('M j, Y', strtotime($key['date_x'])) : '-' ?></td>
                                                                <td><?= $key['x_port'] ? $key['x_port'] : '-' ?></td>
                                                                <td><?= $this->crew_management->getOnSignerCrew($key['position_id'], $key['cmp_code'], $key['monitor_code'], 2) ?></td>

                                                                <td><?= $key['remarks'] ? $key['remarks'] : '-' ?></td>
                                                                <td><?= $this->global->getCrewStatusBadge($key['status']) ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="15" class="text-center">There is no crew at the moment.</td>
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
    <script type="text/javascript" src="<?= base_url('assets/javascript/crew_manage_plan.js') ?>"></script>