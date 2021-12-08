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
                                <li class="breadcrumb-item"> For Approval</li>
                            </ol>
                        </div>
                        <h4 class="page-title">For Approval</h4>
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
                                    <p class="text-alphera font-20 m-0">For Approval</p>
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
                            <div id="view_list">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item" onclick="sortBy('pending')">
                                                <a id="approved_li" href="<?= base_url('admin-approval') . '?sort=pending' ?>" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                    Pending <span class="badge badge-danger"><?= $this->input->get('sort') === "pending" ? $approval_count : 0 ?></span>
                                                </a>
                                            </li>
                                            <li class="nav-item" onclick="sortBy('approved')">
                                                <a href="<?= base_url('admin-approval') . '?sort=approved' ?>" data-toggle="tab" aria-expanded="true" class="nav-link">
                                                    Approved
                                                </a>
                                            </li>
                                            <li class="nav-item" onclick="sortBy('reject')">
                                                <a href="<?= base_url('admin-approval') . '?sort=reject' ?>" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                    Rejected
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="pending">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-sm table-hover">
                                                                <thead class="text-center thead-alphera">
                                                                    <tr>
                                                                        <th>NO.</th>
                                                                        <th>REQUEST BY</th>
                                                                        <th>DEPARTMENT</th>
                                                                        <th>DESCRIPTION</th>
                                                                        <th>TYPE OF REQUEST</th>
                                                                        <th>DATE OF REQUEST</th>
                                                                        <th>STATUS</th>
                                                                        <th>ACTION</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody class="text-center">
                                                                    <?php if ($pending) : ?>
                                                                        <?php $count = 1;
                                                                        foreach ($pending as $row) :
                                                                            $request_type = str_replace('_', ' ', $row['request_type']);
                                                                        ?>
                                                                            <tr>
                                                                                <td><?= $count ?></td>
                                                                                <td><?= $this->global->getAccountDetails($this->global->ecdc('dc', $row['request_by']))['full_name'] ?></td>
                                                                                <td><?= ucwords($row['department']) ?></td>
                                                                                <td><?= !empty($row['remarks']) ? $row['remarks'] : "-"  ?></td>
                                                                                <?php if ($row['request_type'] === "crew_lineup_approval") : ?>
                                                                                    <td><?= ucwords($request_type) ?></td>
                                                                                <?php else : ?>
                                                                                    <td><?= ucwords($request_type) ?> (<?= $row['full_name'] ?>)</td>
                                                                                <?php endif; ?>
                                                                                <td><?= date('M j, Y', strtotime($row['date_created'])) ?></td>
                                                                                <td>
                                                                                    <?php if ($row['status'] == "1") : ?>
                                                                                        <span class="badge badge-success-outline">APPROVED</span>
                                                                                    <?php elseif ($row['status'] == "2") : ?>
                                                                                        <span class="badge badge-warning-outline">PENDING</span>
                                                                                    <?php else : ?>
                                                                                        <span class="badge badge-danger-outline">REJECTED</span>
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="btn-group" role="group" aria-label="">
                                                                                        <?php if ($row['request_type'] === "medical_approval") : ?>
                                                                                            <?php if ($row['status'] === "2") : ?>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="viewMedicalRequest('<?= $row['approval_code'] ?>', '<?= $row['full_name'] ?>')"><i class="mdi mdi-eye font-16"></i></button>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="approveMedicalRequest('<?= $row['approval_code'] ?>')"><i class="mdi mdi-check font-16"></i></button>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="rejectMedicalRequest('<?= $row['approval_code'] ?>', '<?= $row['crew_code'] ?>')"><i class="mdi mdi-close font-16"></i></button>
                                                                                            <?php else : ?>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="viewMedicalRequest('<?= $row['approval_code'] ?>', '<?= $row['full_name'] ?>')"><i class="mdi mdi-eye font-16"></i></button>
                                                                                            <?php endif; ?>
                                                                                        <?php elseif ($row['request_type'] === "for_withdrawal" || $row['request_type'] === "un_toc") : ?>
                                                                                            <?php if ($row['status'] === "2") : ?>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="approveTocRequest('<?= $row['approval_code'] ?>', '<?= $row['crew_code'] ?>', '<?= $row['request_type'] ?>')"><i class="mdi mdi-check font-16"></i></button>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="rejectTocRequest('<?= $row['approval_code'] ?>', '<?= $row['crew_code'] ?>', '<?= $row['request_type'] ?>')"><i class="mdi mdi-close font-16"></i></button>
                                                                                            <?php else : ?>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs"><i class="mdi mdi-eye font-16"></i></button>
                                                                                            <?php endif; ?>
                                                                                        <?php elseif ($row['request_type'] === "promotion") : ?>
                                                                                            <?php if ($row['status'] === "2") : ?>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="viewPromotionRequest('<?= $row['approval_code'] ?>', '<?= $row['crew_code'] ?>')"><i class="mdi mdi-eye font-16"></i></button>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="approvePromotion('<?= $row['approval_code'] ?>', '<?= $row['crew_code'] ?>', '<?= $row['request_type'] ?>')"><i class="mdi mdi-check font-16"></i></button>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="rejectPromotion('<?= $row['approval_code'] ?>')"><i class="mdi mdi-close font-16"></i></button>
                                                                                            <?php else : ?>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs"><i class="mdi mdi-eye font-16"></i></button>
                                                                                            <?php endif; ?>
                                                                                        <?php elseif ($row['request_type'] === "crew_lineup_approval") : ?>
                                                                                            <?php if ($row['status'] === "2") : ?>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="viewCrewLineupRequest('<?= $row['approval_code'] ?>')"><i class="mdi mdi-eye font-16"></i></button>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="approveCrewLineup('<?= $row['approval_code'] ?>')"><i class="mdi mdi-check font-16"></i></button>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs" onclick="rejectCrewLineup('<?= $row['approval_code'] ?>')"><i class="mdi mdi-close font-16"></i></button>
                                                                                            <?php else : ?>
                                                                                                <button type="button" class="btn btn-outline-danger btn-xs"><i class="mdi mdi-eye font-16"></i></button>
                                                                                            <?php endif; ?>
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php $count++;
                                                                        endforeach; ?>
                                                                    <?php else : ?>
                                                                        <tr>
                                                                            <td colspan="8" class="text-center">No data available in table</td>
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
                                            <div class="tab-pane show" id="approved">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-sm table-hover">
                                                                <thead class="text-center thead-alphera">
                                                                    <tr>
                                                                        <th>NO.</th>
                                                                        <th>REQUEST BY</th>
                                                                        <th>DEPARTMENT</th>
                                                                        <th>DESCRIPTION</th>
                                                                        <th>TYPE OF REQUEST</th>
                                                                        <th>DATE OF REQUEST</th>
                                                                        <th>STATUS</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody class="text-center">
                                                                    <?php if ($pending) : ?>
                                                                        <?php $count = 1;
                                                                        foreach ($pending as $row) : ?>
                                                                            <tr>
                                                                                <td><?= $count ?></td>
                                                                                <td><?= $this->global->getAccountDetails($this->global->ecdc('dc', $row['request_by']))['full_name'] ?></td>
                                                                                <td><?= ucfirst($row['department']) ?></td>
                                                                                <td><?= $row['remarks'] ?></td>
                                                                                <td><?= ucfirst($row['request_type']) ?> (<?= $row['full_name'] ?>O)</td>
                                                                                <td><?= date('M j, Y', strtotime($row['date_created'])) ?></td>
                                                                                <td>
                                                                                    <?= $row['status'] === 1 ? '<span class="badge badge-warning-outline">APPROVED</span>' : '<span class="badge badge-warning-outline">PENDING</span>' ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php $count++;
                                                                        endforeach; ?>
                                                                    <?php else : ?>
                                                                        <tr>
                                                                            <td colspan="8" class="text-center">No data available in table</td>
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
                                            <div class="tab-pane" id="rejected">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-sm table-hover">
                                                                <thead class="text-center thead-alphera">
                                                                    <tr>
                                                                        <th>NO.</th>
                                                                        <th>REQUEST BY</th>
                                                                        <th>DEPARTMENT</th>
                                                                        <th>DESCRIPTION</th>
                                                                        <th>TYPE OF REQUEST</th>
                                                                        <th>DATE OF REQUEST</th>
                                                                        <th>STATUS</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody class="text-center">
                                                                    <?php if ($pending) : ?>
                                                                        <?php $count = 1;
                                                                        foreach ($pending as $row) : ?>
                                                                            <tr>
                                                                                <td><?= $count ?></td>
                                                                                <td><?= $this->global->getAccountDetails($this->global->ecdc('dc', $row['request_by']))['full_name'] ?></td>
                                                                                <td><?= ucfirst($row['department']) ?></td>
                                                                                <td><?= $row['remarks'] ?></td>
                                                                                <td><?= ucfirst($row['request_type']) ?> (<?= $row['full_name'] ?>O)</td>
                                                                                <td><?= date('M j, Y', strtotime($row['date_created'])) ?></td>
                                                                                <td>
                                                                                    <?= $row['status'] === 1 ? '<span class="badge badge-warning-outline">APPROVED</span>' : '<span class="badge badge-warning-outline">PENDING</span>' ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php $count++;
                                                                        endforeach; ?>
                                                                    <?php else : ?>
                                                                        <tr>
                                                                            <td colspan="8" class="text-center">No data available in table</td>
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
    <script type="text/javascript" src="<?= base_url('assets/javascript/admin_approval.js') ?>"></script>