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
                                <li class="breadcrumb-item"> Promotion List Report</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Promotion List Report</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6 mt-1">
                                    <p class="text-alphera font-20 m-0">Promotion List Report</p>
                                </div>

                                <div class="col-md-6 text-right">
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-secondary dropdown-toggle ml-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-download"></i> Download Report
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <h6 class="dropdown-header"><b>Download Report As</b></h6>
                                            <a class="dropdown-item" href="">CSV</a>
                                            <a class="dropdown-item" href="">EXCEL</a>
                                            <a class="dropdown-item" href="" target="_blank">PDF</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered m-0 text-center">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Count</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Master (MSTR)</th>
                                                    <th>0</th>
                                                    <th>READY FOR PROMOTION</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-8" id="lbl-title">
                                    <p class="text-alphera font-20 m-0">Promotion List Report</p>
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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="search-display" style="padding: 0px;">
                                        <div class="container-fluid">
                                            <div class="row pt-3 pb-3 mb-3">
                                                <div class="col-md-10">
                                                    <div class="filter-result" id="displayFilters">

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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="text-center thead-alphera">
                                                <tr>
                                                    <th>POSITION</th>
                                                    <th>COUNT</th>
                                                    <th>STATUS</th>
                                                </tr>
                                            </thead>

                                            <tbody class="text-center">
                                                <?php if ($prom_pos) : ?>
                                                    <?php foreach ($prom_pos as $row) : ?>
                                                        <?php if (isset($promotion['' . $row['position_name'] . '_count'], $promotion)) : ?>
                                                            <tr>
                                                                <td><?= $row['position_name'] ?></td>
                                                                <td><?= $promotion['' . $row['position_name'] . '_count'] != null ? $promotion['' . $row['position_name'] . '_count'] : 0  ?></td>
                                                                <td>READY FOR PROMOTION</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center">There is no crew for promotion at the moment.</td>
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
                                    </nav>
                                </div>
                                <div class="col">
                                    <div class="count-pagination">
                                        <span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>