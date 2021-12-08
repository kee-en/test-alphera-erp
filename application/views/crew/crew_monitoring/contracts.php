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
                                <li class="breadcrumb-item"> Contracts</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Contracts</h4>
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
                                    <p class="text-alphera font-20 m-0">Contracts</p>
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
                                                <a class="dropdown-item" href="<?= base_url("print-crew-monitoring-contracts") ?>" target="_blank">PDF</a>
                                                <!-- <a class="dropdown-item" href="javascript: void(0);" onclick="PrintReport('csv')">PDF</a> -->
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
                                $search['name_search'] || $search['rank_search'] || $search['vessel_search'] || $search['contract_search'] || $search['flight_search']
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
                                                <li class="list-group-item" <?= $this->crew_management->get_contract_validity_card($key['crew_code']) ?>>
                                                    <div class="media">
                                                        <img class="align-self-start mr-3" id="applicant_img" src="<?= base_url('assets/images/avatar-placeholder.png') ?>" alt="" width="60">
                                                        <div class="media-body">
                                                            <h5 class="mt-1 mb-0 font-17"><?= $key['full_name'] ?> (<?= $key['position_code'] ?>)</h5>
                                                            <?= $this->global->getCrewStatus($key['status']) ?>
                                                            <p class="text-muted m-0 font-15"><?= $key['city_name'] ?>, <?= $key['province_name'] ?></p>
                                                            <p class="text-muted m-0 font-15">Date of Availability: <?= (!$key['date_available'] ? '<span class="text-alphera text-underline">No Specific Date</span>' : date('M j, Y', strtotime($key['date_available']))) ?></p>
                                                            <?= $this->global->getCrewWarningLetterCount($key['crew_code']) ?>
                                                            <?= $this->global->getCrewWatchlistStatus($key['crew_code']) ?>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row text-center">
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <h4 class="m-0 font-15"><?= $key['position_code']; ?></h4>
                                                                <p class="mb-0 text-muted text-truncate font-15">Rank</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <h4 class="m-0 font-15 "><?= $key['vsl_code']; ?></h4>
                                                                <p class="mb-0 text-muted text-truncate font-15">Vessel</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <?= $this->crew_management->get_contract_validity($key['crew_code']) ?>
                                                                <p class="mb-0 text-muted text-truncate font-15">POEA</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-3" id="applicant_data">
                                                            <div class="m-0">
                                                                <?= $this->crew_management->get_mlc_validity($key['crew_code']) ?>
                                                                <p class="mb-0 text-muted text-truncate font-15">MLC</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-alphera btn-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Shipboard Employment Application" onclick="getViewEditApplication('<?= $key['crew_code'] ?>')"><i class="mdi mdi-pencil"></i></button>
                                                        </div>

                                                        <div class="col">
                                                            <div class="btn-group dropdown btn-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Action">
                                                                <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-secondary" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <h6 class="dropdown-header"><b>On Signer Crew Information</b></h6>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="viewOffsignerDetails('<?= $key['crew_code'] ?>')">View Shipboard Application</a>

                                                                    <?php $check = $this->all_crew->checkRequirements($key['crew_code']);
                                                                    if ($check['type'] === "incomplete") : ?>
                                                                        <a class="dropdown-item" href="javascript:void(0);" <?= (($check['poea'] <= 0) ? 'style="display: none;"' : '') ?> onclick="addCrewPOEAContract('<?= $key['crew_code'] ?>','<?= $key['full_name'] ?>')">Add POEA Contract</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" <?= (($check['mlc'] <= 0) ? 'style="display: none;"' : '') ?> onclick="addCrewMLCContract('<?= $key['crew_code'] ?>')">Add MLC Contract</a>
                                                                    <?php endif; ?>


                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="viewCrewContracts('<?= $key['crew_code'] ?>','<?= $key['full_name'] ?>')">View Contracts (POEA / MLC)</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getVesselHistory('<?= $key['crew_code'] ?>', '<?= $key['full_name'] ?>')">View Vessel History</a>
                                                                    <div role="separator" class="dropdown-divider"></div>
                                                                    <h6 class="dropdown-header"><b>Pre-Joining Routing Slip</b></h6>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="getViewPrejoiningRoutingSlip('<?= $key['monitor_code'] ?>')">Manage Routing Slip</a>
                                                                    <div role="separator" class="dropdown-divider"></div>
                                                                    <h6 class="dropdown-header"><b>Off-Signer Crew Information</b></h6>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="viewOffsignerDetails('<?= $key['offsigner'] ?>')">View Shipboard Application</a>
                                                                    <!-- <a class="dropdown-item" href="javascript:void(0)" onclick="getOffSignerVesselHistory('<?= $this->crew_management->getOffSignerDetails($key['offsigner'])['cmp_code']; ?>')">View Vessel History</a> -->
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
                                                        <th>DATE OF AVAILABILITY</th>
                                                        <th>BMI</th>
                                                        <th>PASSPORT</th>
                                                        <th>POEA</th>
                                                        <th>MLC</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="text-center">
                                                    <?php if ($crew) : ?>
                                                        <?php $count = 1;
                                                        foreach ($crew as $key) :
                                                        ?>
                                                            <tr>
                                                                <td><?= $count ?></td>
                                                                <td><?= $key['vsl_code'] ?></td>
                                                                <td><?= $key['vsl_name'] ?></td>
                                                                <td><?= $key['position_code'] ?></td>
                                                                <td><?= $key['full_name'] ?></td>
                                                                <td><?= $key['date_available'] != NULL ? date('M j, Y', strtotime($key['date_available'])) : "-" ?></td>
                                                                <td><?= $this->global->getBMIScore($key['height'], $key['weight']); ?></td>
                                                                <td>
                                                                    <?= $this->crew_management->validate_passport_table($key['crew_code']) ?>
                                                                </td>
                                                                <?= $this->crew_management->get_contract_validity_table($key['crew_code']) ?>
                                                                <td>
                                                                    <?= $this->crew_management->get_mlc_validity_table($key['crew_code']) ?>
                                                                </td>
                                                            </tr>
                                                        <?php $count++;
                                                        endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="10" class="text-center">There is no crew at the moment.</td>
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
    <script type="text/javascript" src="<?= base_url('assets/javascript/v_contracts.js') ?>"></script>