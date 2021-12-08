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
                                <li class="breadcrumb-item"> Recruitment Performance Report</li>
                            </ol>
                        </div>
                        <h4 class="page-title"> Recruitment Performance Report</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-12">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Comparative Data Count</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                    <h4 class="page-title"> Recruitment Performance Report</h4>
                                    <?php if($applied): ?>
                                        <ul>
                                            <?php foreach ($applied as $key): ?>
                                                <?php if($key['position_name'] != null): ?>
                                                    <li><?= $key['position_name'] ?>: <?= $key['rank_count'] ?></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                    <h4 class="page-title"> Passed Recruitment Performance Report</h4>
                                    <?php if($passed):?>
                                        <ul>
                                            <?php foreach ($passed as $ii): ?>
                                                <li><?= $ii['position_name'] ?>: <?= $ii['rank_count'] ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                    <h4 class="page-title"> Failed Recruitment Performance Report</h4>
                                        <?php if($all_applicants):
                                            $remarks = array();
                                        ?>
                                        <?php foreach ($all_applicants as $row): ?>
                                            <?php if($row['status'] === "9"):?>
                                                <?php array_push($remarks, $row['remark']); ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <!-- Show Ranks with count -->
                                        <?php if($failed): ?>
                                            <ul>
                                            <?php foreach ($failed as $row): ?>
                                                <li><?= $ii['position_name'] ?>: <?= $ii['rank_count'] ?></li>
                                            <?php endforeach; ?>
                                            </ul>
                                            <ul>
                                                <?php
                                                    $remark_count = array_count_values($remarks); 
                                                    foreach ($remark_count as $rr => $value):
                                                ?>
                                                <li><?= $rr ?>: <?= $value ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <li>No Failed Applicants</li>
                                        <?php endif; ?>
                                        <!-- End Show Ranks with count -->
                                    <?php else: ?>
                                        <li>No Failed Applicants</li>
                                    <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>