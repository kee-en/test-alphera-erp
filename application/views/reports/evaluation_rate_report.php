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
                                <li class="breadcrumb-item"> <a href="#">Manage Reports</a></li>
                                <li class="breadcrumb-item"> Evaluation Rate Report</li>
                            </ol>
                        </div>
                        <h4 class="page-title"> Evaluation Rate Report</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6 mt-1">
                                    <p class="text-alphera font-20 m-0">Evaluation Rate Report</p>
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
                                                    <th rowspan="2">Rank</th>
                                                    <th colspan="4">Evaluation for Ex-Crew</th>
                                                    <th colspan="4">Evaluation for New Crew</th>
                                                </tr>

                                                <tr>
                                                    <th>A</th>
                                                    <th>B</th>
                                                    <th>C</th>
                                                    <th>D</th>
                                                    <th>A</th>
                                                    <th>B</th>
                                                    <th>C</th>
                                                    <th>D</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Master (MSTR)</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-0 table-centered table-bordered">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th>Position</th>
                                                    <th>A</th>
                                                    <th>B</th>
                                                    <th>C</th>
                                                    <th>D</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php if ($ex_crew) :
                                                    $count_a = 0;
                                                    $count_b = 0;
                                                    $count_c = 0;
                                                    $count_d = 0;
                                                ?>
                                                    <?php
                                                    foreach ($ex_crew as $row) :
                                                        if ($row['grade'] == "A") {
                                                            $count_a++;
                                                        } elseif ($row['grade'] == "B") {
                                                            $count_b++;
                                                        } elseif ($row['grade'] == "C") {
                                                            $count_c++;
                                                        } elseif ($row['grade'] == "D") {
                                                            $count_d++;
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?= $row['position_name'] ?></td>
                                                            <td><?= $count_a ?></td>
                                                            <td><?= $count_b ?></td>
                                                            <td><?= $count_c ?></td>
                                                            <td><?= $count_d ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td class="text-center" colspan="5">There are no data to display</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Evaluation List New-crew</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-0 table-centered table-bordered">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th>Position</th>
                                                    <th>A</th>
                                                    <th>B</th>
                                                    <th>C</th>
                                                    <th>D</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php if ($new_crew) :
                                                    $count_a = 0;
                                                    $count_b = 0;
                                                    $count_c = 0;
                                                    $count_d = 0;
                                                ?>
                                                    <?php foreach ($new_crew as $row) :
                                                        if ($row['grade'] == "A") {
                                                            $count_a++;
                                                        } elseif ($row['grade'] == "B") {
                                                            $count_b++;
                                                        } elseif ($row['grade'] == "C") {
                                                            $count_c++;
                                                        } elseif ($row['grade'] == "D") {
                                                            $count_d++;
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?= $row['position_name'] ?></td>
                                                            <td><?= $count_a ?></td>
                                                            <td><?= $count_b ?></td>
                                                            <td><?= $count_c ?></td>
                                                            <td><?= $count_d ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td class="text-center" colspan="5">There are no data to display</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/javascript/warning_letter_report.js'); ?>"></script>