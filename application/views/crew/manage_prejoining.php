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
                                <li class="breadcrumb-item"> Manage Pre-joining</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Manage Pre-joining</h4>
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
                                    <p class="text-alphera font-20 m-0">Manage Pre-joining</p>
                                    <span class="text-muted font-18">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                                </div>

                                <div class="col text-right" id="btn-collection">
                                    <div class="btn-group btn-grp-collection" role="group" aria-label="">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crew_filter"><i class="mdi mdi-filter-outline"></i> View Filters</button>
                                        <button type="button" class="btn btn-success ml-1" data-toggle="modal" data-target="#crew_lineup"><i class="mdi mdi-filter-outline"></i> Generate Crew Lineup</button>

                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn btn-secondary dropdown-toggle ml-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-download"></i> Download Report
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <h6 class="dropdown-header"><b>Export As</b></h6>
                                                <a class="dropdown-item" href="javascript: void(0);" onclick="PrintReport('csv')">CSV</a>
                                                <a class="dropdown-item" href="javascript: void(0);" onclick="PrintReport('excel')">EXCEL</a>
                                                <a class="dropdown-item" href="<?= base_url("print-pre-joining-crews") ?>" target="_blank">PDF</a>
                                                <!-- <a class="dropdown-item" href="javascript: void(0);" onclick="PrintReport('pdf')">PDF</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php if ($search['name_search'] || $search['rank_search'] || $search['vessel_search'] || $search['contract_search'] || $search['flight_search']) : ?>
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
                                                                    Flight Availability: <?= $search['flight_search'] == '1' ? "Available" : "Not Available" ?>
                                                                    <input type="hidden" id="flight_search" value="<?= $search['flight_search'] ?>">
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
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="text-center thead-alphera">
                                                <tr>
                                                    <th rowspan="2">#</th>
                                                    <th rowspan="2">VESSEL</th>
                                                    <th colspan="2">OFF SIGNER</th>
                                                    <th colspan="3">ON SIGNER</th>
                                                    <th rowspan="2">JOINING PORT</th>
                                                    <th rowspan="2">JOINING DATE</th>
                                                    <th rowspan="2">APPROVAL STATUS</th>
                                                    <th colspan="5">DOCUMENT STATUS</th>
                                                    <th rowspan="2">REMARKS</th>
                                                </tr>

                                                <tr>
                                                    <th>RANK</th>
                                                    <th>NAME</th>
                                                    <th>RANK</th>
                                                    <th>NAME</th>
                                                    <th>CONTACT NO./S</th>
                                                    <th>MEDICAL</th>
                                                    <th>LICENSES</th>
                                                    <th>TRAINING(S)</th>
                                                    <th>POEA</th>
                                                    <th>MLC</th>
                                                </tr>
                                            </thead>

                                            <tbody class="text-center">
                                                <?php if ($crew) : ?>
                                                    <?php $count = $count_page;
                                                    foreach ($crew as $row) :
                                                    ?>
                                                        <tr>
                                                            <td><?= ++$count ?></td>
                                                            <td><?= $row['vsl_code'] ?></td>
                                                            <td><?= $row['position_code'] ?></td>
                                                            <td><?= $row['full_name'] ?></td>
                                                            <td><?= $row['insigner'] != NULL ? $this->global->getCrewNameByMonitorCode($row['insigner'])['position_code'] : "-"  ?></td>
                                                            <td><?= $row['insigner'] != NULL ? $this->global->getCrewNameByMonitorCode($row['insigner'])['full_name'] : "-"  ?></td>
                                                            <td><?= $row['insigner'] != NULL ? $this->global->getCrewNameByMonitorCode($row['insigner'])['mobile_number'] : "-"  ?></td>
                                                            <td><?= $row['x_port'] ? $row['x_port'] : '-' ?></td>
                                                            <td><?= $row['embark'] ? date('M j, Y', strtotime($row['embark'])) : '-' ?></td>
                                                            <td><span class="badge badge-success-outline">APPROVED</span></td>
                                                            <td><?= $this->medical->get_medical_validity_table($row['crew_code']) ?></td>
                                                            <td>
                                                                <?= $this->crew_management->get_license_validity_table($row['crew_code']) ?>
                                                            </td>
                                                            <td><?= $this->crew_management->validate_certificates_table($row['crew_code']) ?></td>
                                                            <?= $this->crew_management->get_contract_validity_table($row['crew_code']) ?>
                                                            <td><?= $this->crew_management->get_mlc_validity_table($row['crew_code']) ?></td>
                                                            <td><?= $row['remarks'] ? $row['remarks'] : '-' ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="22" class="text-center">There is no crew at the moment.</td>
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
                                        <?= $this->pagination->create_links() ?>
                                    </nav>
                                </div>
                                <div class="col">
                                    <div class="count-pagination">
                                        <span>
                                            <?= $showing_entries ?>
                                        </span>
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
    <script type="text/javascript" src="<?= base_url('assets/javascript/manage_prejoining.js') ?>"></script>