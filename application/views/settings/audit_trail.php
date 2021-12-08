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
                                <li class="breadcrumb-item"> Audit Trail</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Audit Trail</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Filter Logs</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" id="position_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <input type="text" class="form-control" placeholder="Date From" id="date_from" name="date_from">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Date To</label>
                                            <input type="text" class="form-control" placeholder="Date To" id="date_to" name="date_to">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Filter By</label>
                                            <select class="custom-select" id="filter_by" name="filter_by">
                                                <option value="">Choose option</option>
                                                <option value="1">By Action</option>
                                                <option value="2">By User</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" id="btnFilter">Filter</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">List of Logs</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive" style="white-space: nowrap;">
                                        <table class="table table-hover m-0 table-bordered" id="audit_trail_table">
                                            <thead class="thead-alphera">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Full Name</th>
                                                    <th>Action</th>
                                                    <th>Description</th>
                                                    <th>Effect to</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
    
                                            <tbody>
                                                <?php if (isset($results)) { ?>
                                                    <?php $count = 1;
                                                    $array = json_decode(json_encode($results), true);
                                                    foreach ($array as $row) { ?>
                                                        <tr>
                                                            <td><?= $record_count++ ?></td>
                                                            <td><?= $row["full_name"] ?></td>
                                                            <td><?= $row["status"] ?></td>
                                                            <td><?= 'IP Address:' . $row['address'] . ', OS:' . $row['address'] ?></td>
                                                            <td><?= $row['full_name'] ?></td>
                                                            <td><?= date('F j, Y h:i', strtotime($row['date'])) ?></td>
                                                        </tr>
                                                    <?php  } ?>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td>No data to display</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row d-flex justify-content-between mt-4">
                                        <div class="col-md-6" id="navigation-align">
                                            <nav>
                                                <?php if (isset($links)) { ?>
                                                    <?= $links ?>
                                                <?php } ?>
                                            </nav>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <div class="count-pagination"><span><?= $audit_count ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/audit_trail.js') ?>"></script>