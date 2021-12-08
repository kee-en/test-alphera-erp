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
                                <li class="breadcrumb-item"> <a href="#">Settings</a></li>
                                <li class="breadcrumb-item"> Evaluation Sheet</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Evaluation Sheet</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">Add Evaluation Sheet</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <form action="javascript:void(0)" method="POST" id="evaluation_sheet_form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col md-6">
                                        <label>Select Rank / Position <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select class="custom-select" id="position_list" name="position_list" onchange="positionOnChange(this.value)" required>
                                                <option value="">Choose option</option>
                                                <?php foreach ($position_list as $value) : ?>
                                                    <option value=" <?= $value['id'] ?>"><?= $value['position_code'] ?> - <?= $value['position_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-alphera" id="btn_save_points_interview">Save Changes</button>
                                            </div>
                                        </div>

                                        <ul class="parsley-errors-list filled" id="position_list_alert"></ul>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive" style="white-space: nowrap;">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="thead-alphera text-center">
                                                    <tr>
                                                        <th>AGE</th>
                                                        <th>TOTAL ON BOARD (PERIOD)</th>
                                                        <th>SAME KIND OF SHIP / SAME KIND OF RANK</th>
                                                        <th>SHORT ON BOARD</th>
                                                        <th>MIXED CREW</th>
                                                        <th>BMI</th>
                                                        <th>FITNESS</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <tr>
                                                        <td id="text-alignment">
                                                            <input type="text" class="form-control text-center text-uppercase" id="min_age" name="min_age">
                                                        </td>
                                                        <td id="text-alignment">
                                                            <input type="text" class="form-control text-center text-uppercase" id="tob_period" name="tob_period">
                                                        </td>
                                                        <td id="text-alignment">
                                                            <input type="text" class="form-control text-center text-uppercase" id="sks_skr" name="sks_skr">
                                                        </td>
                                                        <td id="text-alignment">UNDER 2 TIMES WITHIN 3 YEARS</td>
                                                        <td id="text-alignment">EXPERIENCED</td>
                                                        <td id="text-alignment">19-28</td>
                                                        <td id="text-alignment">FITNESS</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="table-responsive" style="white-space: nowrap;">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="thead-alphera text-center">
                                                    <tr>
                                                        <th></th>
                                                        <th>ITEM</th>
                                                        <th>STANDARD</th>
                                                        <th style="width: 10%;">ADDITIONAL POINT</th>
                                                        <th style="width: 10%;">SUBTRACT POINT</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <tr>
                                                        <td rowspan="14" id="text-alignment">WORKING <br> EXPERIENCE</td>
                                                        <td id="text-alignment">SAME KIND OF RANK</td>
                                                        <td id="text-alignment">
                                                            <input type="text" class="form-control text-center text-uppercase" id="skor_standard" name="skor_standard">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control text-center text-uppercase" id="additional_point_1" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_1_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_1" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_1_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" id="text-alignment">SAME KIND OF SHIP</td>
                                                        <td rowspan="2" id="text-alignment">WITHIN 5 YEARS <br> (RECENTLY)</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_2" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_2_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_2" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_2_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_3" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_3_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_3" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_3_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="3" id="text-alignment">EXPERIENCE WITH ROUTE <br> (W-WIDE)</td>
                                                        <td rowspan="2" id="text-alignment">WITHIN 5 YEARS <br>(RECENTLY)</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_4" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_4_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_4" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_4_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_5" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_5_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_5" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_5_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">INEXPERIENCED</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_6" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_6_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_6" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_6_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="4" id="text-alignment">LEAVE OF ABSENCE</td>
                                                        <td id="text-alignment">SHORTLY BEFORE - <br> MORE THAN 1 YEAR</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_7" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_7_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_7" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_7_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">SHORTLY BEFORE - <br> MORE THAN 2 YEAR</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_8" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_8_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_8" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_8_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">SHORTLY BEFORE - <br> MORE THAN 3 YEAR</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_9" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_9_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_9" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_9_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">SHORTLY BEFORE - <br> WITHIN 5 YEAR</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_10" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_10_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_10" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_10_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="3" id="text-alignment">RIDE TOGETHER WITH S. KOREAN</td>
                                                        <td id="text-alignment">MORE THAN 3 TIMES</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_11" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_11_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_11" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_11_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">MORE THAN 4 TIMES</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_12" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_12_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_12" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_12_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">NOTHING</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_13" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_13_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_13" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_13_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">REPUTATION OF PREVIOUS COMPANY</td>
                                                        <td id="text-alignment">WITHIN 5 YEARS <br> (RECENTLY)</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_14" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_14_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_14" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_14_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <!-- LOYALTY -->
                                                    <tr>
                                                        <td rowspan="7" id="text-alignment">LOYALTY</td>
                                                        <td id="text-alignment">RE-HIRE</td>
                                                        <td id="text-alignment">RE-HIRE (SAME AGENT)</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_15" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_15_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_15" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_15_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" id="text-alignment">FAMILY RELATIONS</td>
                                                        <td id="text-alignment">MARRIED + CHILD</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_16" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_16_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_16" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_16_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="text-alignment">ONLY MARRIED</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_17" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_17_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_17" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_17_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" id="text-alignment">CHANGE JOBS</td>
                                                        <td rowspan="2" id="text-alignment">WITHIN 5 YEARS <br>(RECENTLY)</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_18" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_18_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_18" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_18_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_19" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_19_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_19" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_19_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="1" id="text-alignment">SHORT ON BOARD</td>
                                                        <td rowspan="1" id="text-alignment">WITHIN 5 YEARS <br>(RECENTLY)</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_20" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_20_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_20" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_20_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="1" id="text-alignment">PROMOTION WHEN CHANGE JOB</td>
                                                        <td rowspan="1" id="text-alignment">WITHIN 5 YEARS <br>(RECENTLY)</td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_21" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_21_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_21" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_21_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <!-- HEALTH -->
                                                    <tr>
                                                        <td rowspan="2" id="text-alignment">HEALTH</td>
                                                        <td rowspan="2" id="text-alignment">AGE</td>
                                                        <td rowspan="2" id="text-alignment">
                                                            <input type="text" class="form-control text-center text-uppercase" id="age_standard" name="age_standard">
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_22" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_22_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_22" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_22_alert"></ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="additional_point_23" name="additional_point[]">
                                                            <ul class="parsley-errors-list filled" id="additional_point_23_alert"></ul>
                                                        </td>
                                                        <td><input type="text" class="form-control text-center text-uppercase" id="subtract_point_23" name="subtract_point[]">
                                                            <ul class="parsley-errors-list filled" id="subtract_point_23_alert"></ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url('assets/javascript/evaluation_sheet_form.js') ?>"></script>