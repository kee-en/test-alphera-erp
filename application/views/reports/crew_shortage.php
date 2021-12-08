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
                                <li class="breadcrumb-item"> Crew Shortage Report</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Crew Shortage Report</h4>
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
                                    <p class="text-alphera font-20 m-0">Crew Shortage Report</p>
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
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="text-center thead-alphera">
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Required No.</th>
                                                    <th>Reserve Rate 40%</th>
                                                    <th>TTL</th>
                                                    <th>Crew (Onboard)</th>
                                                    <th>Vacation</th>
                                                    <th>TTL</th>
                                                    <th>Excess & Shortage</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <?php if ($crew_data) :
                                                    $count = 0;
                                                    $embark_count = 0;
                                                    $vaca_count = 0;
                                                ?>
                                                    <?php foreach ($crew_data as $row) :
                                                        $c_shortage = $this->global->getCrewShortageByPos($row['pos_id']);
                                                        if (!empty($c_shortage)) {
                                                            if ($row['pos_id'] == $c_shortage['position_code']) {
                                                                $pos_name = $row['position_name'];
                                                                $reserve_rate = round(intval($c_shortage['required_no'])  * 0.40);
                                                            }
                                                            if ($row['crew_status'] == 3) {
                                                                $embark_count = count($crew_data);
                                                            } else if ($row['crew_status'] == 7) {
                                                                $vaca_count = count($crew_data);
                                                            }
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?= $pos_name ?></td>
                                                            <td><?= !empty($c_shortage) ? $c_shortage['required_no'] : 0 ?></td>
                                                            <td><?= $reserve_rate ?></td>
                                                            <td><?= intval($c_shortage) + $reserve_rate ?></td>
                                                            <td><?= $embark_count ?></td>
                                                            <td><?= $vaca_count ?></td>
                                                            <td><?= intval($embark_count) + intval($vaca_count)  ?></td>
                                                            <td><?= (intval($c_shortage) + $reserve_rate) - (intval($embark_count) + intval($vaca_count))  ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
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
                    </div>
                </div>
            </div>
        </div>
    </div>