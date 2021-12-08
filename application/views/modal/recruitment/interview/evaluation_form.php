<!-- ADD EVALUATION FORM MODAL -->
<div class="modal fade" id="evaluation_form_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 65%;">
        <form action="javascript:void(0)" id="evaluation_form" name="evaluation_form" enctype="application/x-www-form-urlencoded">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-20 m-0"><span id="eval_applicant_name"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ef_applicant_code" id="ef_applicant_code">
                    <input type="hidden" name="ef_crew_code" id="ef_crew_code">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <p class="text-alphera font-20 font-weight-medium mb-0">EVALUATION FORM</p>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="text-center">
                                <tr>
                                    <td id="text-alignment">VESSEL</td>
                                    <td colspan="6">
                                        <select class="custom-select" id="ef_vessel" name="ef_vessel" disabled>
                                            <option value="">TENTATIVE ASSIGN VESSEL</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">RANK</td>
                                    <td colspan="6">
                                        <select class="custom-select" id="ef_rank" name="ef_rank">
                                            <option value="">SELECT RANK / POSITION</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">NAME</td>
                                    <td colspan="6"><input type="text" id="ef_name" name="ef_name" class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">NATIONALITY</td>
                                    <td colspan="6"><input type="text" id="ef_nationality" name="ef_nationality" class="form-control" readonly></td>
                                </tr>
                                <tr class="text-left text-alphera font-weight-medium">
                                    <td colspan="7">MINIMUM REQUIREMENTS</td>
                                </tr>
                                <tr>
                                    <th>Age</th>
                                    <th>Total On Board (Period)</th>
                                    <th>Same Kind of Ship / Same Kind of Rank</th>
                                    <th>Short On Board</th>
                                    <th>Mixed Crew</th>
                                    <th>BMI</th>
                                    <th>Interview</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td id="text-alignment" class="min_age">18-45</td>
                                    <td id="text-alignment" class="tob_period">EXCESS 1 YEAR</td>
                                    <td id="text-alignment" class="sks_skr">MORE THAN 6 MONTHS PER 1 TIME <br>/ MORE THAN 6 MONTHS</td>
                                    <td id="text-alignment">UNDER 2 TIMES <br> WITHIN 3 YEARS</td>
                                    <td id="text-alignment">EXPERIENCED</td>
                                    <td id="text-alignment">19-28</td>
                                    <td id="text-alignment">FITNESS</td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control text-center font-weight-medium text-uppercase" id="ef_age" name="ef_age" readonly></td>
                                    <td><input type="text" class="form-control text-center font-weight-medium text-uppercase" id="ef_total_board" name="ef_total_board"></td>
                                    <td><input type="text" class="form-control text-center font-weight-medium text-uppercase" id="ef_same_ship" name="ef_same_ship"></td>
                                    <td><input type="text" class="form-control text-center font-weight-medium text-uppercase" id="ef_short_board" name="ef_short_board"></td>
                                    <td><input type="text" class="form-control text-center font-weight-medium text-uppercase" id="ef_mixed_crew" name="ef_mixed_crew"></td>
                                    <td><input type="text" class="form-control text-center font-weight-medium text-uppercase" id="ef_bmi" name="ef_bmi" readonly></td>
                                    <td><input type="text" class="form-control text-center font-weight-medium text-uppercase" id="ef_interview" name="ef_interview"></td>
                                </tr>
                                <tr class="text-left text-alphera font-weight-medium">
                                    <td colspan="7">ENHANCED RATING</td>
                                </tr>
                            </tbody>
                            <thead class="text-center thead-alphera">
                                <tr>
                                    <th></th>
                                    <th>Item</th>
                                    <th>Standard</th>
                                    <th>Additional Point</th>
                                    <th>Subtract Point</th>
                                    <th>Detail</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td rowspan="14" id="text-alignment">WORKING <br> EXPERIENCE</td>
                                    <td id="text-alignment">SAME KIND OF RANK</td>
                                    <td id="text-alignment" class="skor_standard">EXCESS 1 YEAR</td>
                                    <td class="blue add_point" id="add_point_1"></td>
                                    <td class="red sub_point" id="sub_point_1"></td>
                                    <td class="detail_input" id="detail_input_1"></td>
                                    <td class="score_input" id="score_input_1"></td>
                                </tr>
                                <tr>
                                    <td rowspan="2" id="text-alignment">SAME KIND OF SHIP</td>
                                    <td rowspan="2" id="text-alignment">WITHIN 5 YEARS <br> (RECENTLY)</td>
                                    <td class="blue add_point" id="add_point_2"></td>
                                    <td class="red sub_point" id="sub_point_2"></td>
                                    <td class="detail_input" id="detail_input_2"></td>
                                    <td class="score_input" id="score_input_2"></td>
                                </tr>
                                <tr>
                                    <td class="blue add_point" id="add_point_3"></td>
                                    <td class="red sub_point" id="sub_point_3"></td>
                                    <td class="detail_input" id="detail_input_3"></td>
                                    <td class="score_input" id="score_input_3"></td>
                                </tr>
                                <tr>
                                    <td rowspan="3" id="text-alignment">EXPERIENCE WITH ROUTE <br> (W-WIDE)</td>
                                    <td rowspan="2" id="text-alignment">WITHIN 5 YEARS <br>(RECENTLY)</td>
                                    <td class="blue add_point" id="add_point_4"></td>
                                    <td class="red sub_point" id="sub_point_4"></td>
                                    <td class="detail_input" id="detail_input_4"></td>
                                    <td class="score_input" id="score_input_4"></td>
                                </tr>
                                <tr>
                                    <td class="blue add_point" id="add_point_5"></td>
                                    <td class="red sub_point" id="sub_point_5"></td>
                                    <td class="detail_input" id="detail_input_5"></td>
                                    <td class="score_input" id="score_input_5"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">INEXPERIENCED</td>
                                    <td class="blue add_point" id="add_point_6"></td>
                                    <td class="red sub_point" id="sub_point_6"></td>
                                    <td class="detail_input" id="detail_input_6"></td>
                                    <td class="score_input" id="score_input_6"></td>
                                </tr>
                                <tr>
                                    <td rowspan="4" id="text-alignment">LEAVE OF ABSENCE</td>
                                    <td id="text-alignment">SHORTLY BEFORE - <br> MORE THAN 1 YEAR</td>
                                    <td class="blue add_point" id="add_point_7"></td>
                                    <td class="red sub_point" id="sub_point_7"></td>
                                    <td class="detail_input" id="detail_input_7"></td>
                                    <td class="score_input" id="score_input_7"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">SHORTLY BEFORE - <br> MORE THAN 2 YEAR</td>
                                    <td class="blue add_point" id="add_point_8"></td>
                                    <td class="red sub_point" id="sub_point_8"></td>
                                    <td class="detail_input" id="detail_input_8"></td>
                                    <td class="score_input" id="score_input_8"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">SHORTLY BEFORE - <br> MORE THAN 3 YEAR</td>
                                    <td class="blue add_point" id="add_point_9"></td>
                                    <td class="red sub_point" id="sub_point_9"></td>
                                    <td class="detail_input" id="detail_input_9"></td>
                                    <td class="score_input" id="score_input_9"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">SHORTLY BEFORE - <br> WITHIN 5 YEAR</td>
                                    <td class="blue add_point" id="add_point_10"></td>
                                    <td class="red sub_point" id="sub_point_10"></td>
                                    <td class="detail_input" id="detail_input_10"></td>
                                    <td class="score_input" id="score_input_10"></td>
                                </tr>
                                <tr>
                                    <td rowspan="3" id="text-alignment">RIDE TOGETHER WITH S. KOREAN</td>
                                    <td id="text-alignment">MORE THAN 3 TIMES</td>
                                    <td class="blue add_point" id="add_point_11"></td>
                                    <td class="red sub_point" id="sub_point_11"></td>
                                    <td class="detail_input" id="detail_input_11"></td>
                                    <td class="score_input" id="score_input_11"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">MORE THAN 4 TIMES</td>
                                    <td class="blue add_point" id="add_point_12"></td>
                                    <td class="red sub_point" id="sub_point_12"></td>
                                    <td class="detail_input" id="detail_input_12"></td>
                                    <td class="score_input" id="score_input_12"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">NOTHING</td>
                                    <td class="blue add_point" id="add_point_13"></td>
                                    <td class="red sub_point" id="sub_point_13"></td>
                                    <td class="detail_input" id="detail_input_13"></td>
                                    <td class="score_input" id="score_input_13"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">REPUTATION OF PREVIOUS COMPANY</td>
                                    <td id="text-alignment">WITHIN 5 YEARS <br> (RECENTLY)</td>
                                    <td class="blue add_point" id="add_point_14"></td>
                                    <td class="red sub_point" id="sub_point_14"></td>
                                    <td class="detail_input" id="detail_input_14"></td>
                                    <td class="score_input" id="score_input_14"></td>
                                </tr>
                                <!-- LOYALTY -->
                                <tr>
                                    <td rowspan="7" id="text-alignment">LOYALTY</td>
                                    <td id="text-alignment">RE-HIRE</td>
                                    <td id="text-alignment">RE-HIRE (SAME AGENT)</td>
                                    <td class="blue add_point" id="add_point_15"></td>
                                    <td class="red sub_point" id="sub_point_15"></td>
                                    <td class="detail_input" id="detail_input_15"></td>
                                    <td class="score_input" id="score_input_15"></td>
                                </tr>
                                <tr>
                                    <td rowspan="2" id="text-alignment">FAMILY RELATIONS</td>
                                    <td id="text-alignment">MARRIED + CHILD</td>
                                    <td class="blue add_point" id="add_point_16"></td>
                                    <td class="red sub_point" id="sub_point_16"></td>
                                    <td class="detail_input" id="detail_input_16"></td>
                                    <td class="score_input" id="score_input_16"></td>
                                </tr>
                                <tr>
                                    <td id="text-alignment">ONLY MARRIED</td>
                                    <td class="blue add_point" id="add_point_17"></td>
                                    <td class="red sub_point" id="sub_point_17"></td>
                                    <td class="detail_input" id="detail_input_17"></td>
                                    <td class="score_input" id="score_input_17"></td>
                                </tr>
                                <tr>
                                    <td rowspan="2" id="text-alignment">CHANGE JOBS</td>
                                    <td rowspan="2" id="text-alignment">WITHIN 5 YEARS <br>(RECENTLY)</td>
                                    <td class="blue add_point" id="add_point_18"></td>
                                    <td class="red sub_point" id="sub_point_18"></td>
                                    <td class="detail_input" id="detail_input_18"></td>
                                    <td class="score_input" id="score_input_18"></td>
                                </tr>
                                <tr>
                                    <td class="blue add_point" id="add_point_19"></td>
                                    <td class="red sub_point" id="sub_point_19"></td>
                                    <td class="detail_input" id="detail_input_19"></td>
                                    <td class="score_input" id="score_input_19"></td>
                                </tr>
                                <tr>
                                    <td rowspan="1" id="text-alignment">SHORT ON BOARD</td>
                                    <td rowspan="1" id="text-alignment">WITHIN 5 YEARS <br>(RECENTLY)</td>
                                    <td class="blue add_point" id="add_point_20"></td>
                                    <td class="red sub_point" id="sub_point_20"></td>
                                    <td class="detail_input" id="detail_input_20"></td>
                                    <td class="score_input" id="score_input_20"></td>
                                </tr>
                                <tr>
                                    <td rowspan="1" id="text-alignment">PROMOTION WHEN CHANGE JOB</td>
                                    <td rowspan="1" id="text-alignment">WITHIN 5 YEARS <br>(RECENTLY)</td>
                                    <td class="blue add_point" id="add_point_21"></td>
                                    <td class="red sub_point" id="sub_point_21"></td>
                                    <td class="detail_input" id="detail_input_21"></td>
                                    <td class="score_input" id="score_input_21"></td>
                                </tr>
                                <!-- HEALTH -->
                                <tr>
                                    <td rowspan="2" id="text-alignment">HEALTH</td>
                                    <td rowspan="2" id="text-alignment">AGE</td>
                                    <td rowspan="2" id="text-alignment" class="age_standard">40</td>
                                    <td class="blue add_point" id="add_point_22"></td>
                                    <td class="red sub_point" id="sub_point_22"></td>
                                    <td class="detail_input" id="detail_input_22"></td>
                                    <td class="score_input" id="score_input_22"></td>
                                </tr>
                                <tr>
                                    <td class="blue add_point" id="add_point_23"></td>
                                    <td class="red sub_point" id="sub_point_23"></td>
                                    <td class="detail_input" id="detail_input_23"></td>
                                    <td class="score_input" id="score_input_23"></td>
                                </tr>
                                <!-- SCORE -->
                                <tr>
                                    <td rowspan="2" colspan="2" id="text-alignment">SCORE</td>
                                    <td rowspan="2" id="text-alignment">PASS: MORE THAN 25 SCORE <br> REJECT: LESS
                                        THAN -15 SCORE</td>
                                    <td colspan="2" id="text-alignment">ADDITIONAL POINT</td>
                                    <td><input type="text" class="form-control text-center font-weight-medium text-uppercase" id="additional_point_detail" name="additional_point_detail" readonly></td>
                                    <td><input type="number" class="form-control text-center font-weight-medium text-uppercase" id="addtional_point_score" name="addtional_point_score" readonly></td>
                                </tr>
                                <tr>
                                    <td colspan="2" id="text-alignment">SUBTRACT POINT</td>
                                    <td><input type="text" class="form-control text-center font-weight-medium text-uppercase" id="substract_point_detail" name="substract_point_detail" readonly></td>
                                    <td><input type="number" class="form-control text-center font-weight-medium text-uppercase" id="substract_point_score" name="substract_point_score" readonly></td>
                                </tr>
                                <tr>
                                    <td colspan="5" id="text-alignment">FINAL RESULT</td>
                                    <td id="final_evaluation"><input type="text" class="form-control text-center font-weight-medium" id="eval_final" name="eval_final" readonly></td>
                                    <td id="final_evaluation"><input type="number" class="form-control text-center font-weight-medium" id="eval_score" name="eval_score" readonly></td>
                                </tr>
                                <input type="hidden" id="applicant-code-hidden" name="applicant-code-hidden">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group dropup mr-auto">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export As <i class="mdi mdi-chevron-up"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" onclick="printEvaluationFormPdf()">PDF</a>
                            <a class="dropdown-item" onclick="printEvaluationFormXl()">EXCEL</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?= base_url('assets/javascript/evaluation_form.js') ?>"></script>