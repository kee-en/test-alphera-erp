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
                                <li class="breadcrumb-item"> <a href="#">System Configuration</a></li>
                                <li class="breadcrumb-item"> Backup Database</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Backup Database</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col" style="margin: auto;">
                                    <p class="text-alphera font-20 m-0">Backup Database</p>
                                </div>

                                <div class="col text-right">
                                    <button type="button" class="btn btn-alphera">Upload New</button>
                                    <button type="button" class="btn btn-secondary" id="Btn_backup">Backup Database</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>File</th>
                                                <th>Type</th>
                                                <th>Backup Date</th>
                                                <th>Action by</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php if (isset($results)) { ?>
                                                <?php $count = 1;
                                                $array = json_decode(json_encode($results), true);
                                                foreach ($array as $row) { ?>
                                                    <tr>
                                                        <td><?= $count ?></td>
                                                        <td><?= $row["file_name"] ?></td>
                                                        <td>MySQL Database</td>
                                                        <td><?= $row['date_created'] ?></td>
                                                        <td><?= $row['usercode'] ?></td>
                                                        <td> <button type="button" class="btn btn-outline-danger btn-xs" onclick="deleteDB('<?php echo $row['file_name'] ?>','<?php echo $row['id'] ?>')">Delete Permanently</button></td>
                                                    </tr>
                                                <?php $count++;
                                                } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td>No data to display</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row justify-content-between mt-4">
                                <div class="col" id="navigation-align">
                                    <nav>
                                        <?= $this->pagination->create_links(); ?>
                                    </nav>
                                </div>
                                <div class="col text-right">
                                    <?php if (isset($backup_count)) { ?>
                                        <div class="count-pagination"><span><?= $backup_count ?></span></div>
                                    <?php } else { ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/backup_db.js') ?>"></script>