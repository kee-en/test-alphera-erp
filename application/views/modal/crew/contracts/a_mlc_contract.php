<!-- ADD MLC CONTRACT MODAL -->
<div class="modal fade" id="add_mlc_contract_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 65%;">
        <form action="javascript:void(0)" id="mlc_contract_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-20 m-0" id="a_mlc_crew_name"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-md-12">
                            <p class="text-alphera font-20 font-weight-medium mb-0">MLC CONTRACT</p>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4" id="col_mlc_contract">
                            <div class="form-group">
                                <label>Type of MLC Contract <span class="asterisk">*</span></label>
                                <select class="custom-select" id="c_mlc_contract" name="c_mlc_contract">
                                    <option value="">Choose option</option>
                                    <option value="1">Korean Flag</option>
                                    <option value="2">Panama Flag</option>
                                    <option value="3">Marshall Flag</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- MLC CONTRACT [START] -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row" id="col_form_details">
                                <input type="hidden" class="form-control" id="mlc_crew_code" name="mlc_crew_code">
                                <input type="hidden" name="mlc_monitor_code" id="mlc_monitor_code">

                                <div class="col-md-4">
                                    <label class="text-muted m-0">Form Number:</label>
                                    <p class="text-dark font-15 mt-0 mb-2" id="vc_form_number">-</p>
                                    <input type="hidden" id="mlc_form_number" name="mlc_form_number" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label class="text-muted m-0">Revision Number:</label>
                                    <p class="text-dark font-15 mt-0 mb-2" id="vc_revision_number">-</p>
                                    <input type="hidden" id="mlc_revision_number" name="mlc_revision_number" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label class="text-muted m-0">Revision Date:</label>
                                    <p class="text-dark font-15 mt-0 mb-2" id="vc_revision_date">-</p>
                                    <input type="hidden" id="mlc_revision_date" name="mlc_revision_date" class="form-control">
                                </div>
                            </div>

                            <div class="row" id="col_form_mlc">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0">
                                            <!-- [START] -->
                                            <thead>
                                                <tr>
                                                    <td rowspan="2" id="text-alignment">Shipowner</td>
                                                    <td id="text-alignment" style="width: 15%;">Company / Representative</td>
                                                    <td colspan="5" id="text-alignment">
                                                        <input type="text" id="mlc_company_name" name="mlc_company_name" class="form-control" value="POS SM Co.,Ltd. / Myeong Su KIM" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td id="text-alignment">Address</td>
                                                    <td colspan="5" id="text-alignment">
                                                        <input type="text" id="mlc_company_address" name="mlc_company_address" class="form-control" value="102, Joongang Daero, Jung-gu, Busan, Korea" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="2" id="text-alignment">Agent</td>
                                                    <td id="text-alignment">Company</td>
                                                    <td colspan="5" id="text-alignment"><input type="text" id="mlc_agent_name" name="mlc_agent_name" class="form-control" value="ALPHERA MARINE SERVICES INC.(formerly  POS-FIL SHIP MANAGEMENT CORPORATION)" readonly></td>
                                                </tr>

                                                <tr>
                                                    <td id="text-alignment">Address</td>
                                                    <td colspan="5" id="text-alignment">
                                                        <input type="text" id="mlc_agent_address" name="mlc_agent_address" class="form-control" value="7F, Jemarson Place, 1626 Pilar Hidalgo Lim St., Malate, Manila, Philippines 1004" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="2" id="text-alignment">Vessel</td>
                                                    <td id="text-alignment">Name</td>
                                                    <td colspan="5" id="text-alignment">
                                                        <select class="custom-select" id="mlc_vessel_name" name="mlc_vessel_name">
                                                            <option value="">Choose option</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td id="text-alignment">Kind</td>
                                                    <td colspan="5" id="text-alignment">
                                                        <select class="custom-select" id="mlc_vessel_type" name="mlc_vessel_type">
                                                            <option value="">Choose option</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="3" id="text-alignment">Seafarer</td>
                                                    <td colspan="1" id="text-alignment">Name</td>
                                                    <td id="text-alignment">
                                                        <input type="text" id="mlc_farer_name" name="mlc_farer_name" class="form-control" readonly>
                                                    </td>
                                                    <td colspan="1" id="text-alignment">Duty</td>
                                                    <td id="text-alignment">
                                                        <!-- <input type="text" id="mlc_farer_duty" name="mlc_farer_duty" class="form-control"> -->
                                                        <select class="custom-select" id="mlc_farer_duty" name="mlc_farer_duty">
                                                            <option value="">Choose option</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="2"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="1" id="text-alignment">Passport No.</td>
                                                    <td id="text-alignment">
                                                        <input type="text" id="mlc_farer_passport" name="mlc_farer_passport" class="form-control">
                                                    </td>
                                                    <td colspan="1" id="text-alignment">Seaman's Book No.</td>
                                                    <td id="text-alignment">
                                                        <input type="text" id="mlc_farer_book" name="mlc_farer_book" class="form-control">
                                                    </td>
                                                    <td colspan="1" id="text-alignment">License No.</td>
                                                    <td id="text-alignment">
                                                        <input type="text" id="mlc_farer_license" name="mlc_farer_license" class="form-control">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="1" id="text-alignment">Sex</td>
                                                    <td id="text-alignment">
                                                        <input type="text" id="mlc_farer_sex" name="mlc_farer_sex" class="form-control">
                                                    </td>
                                                    <td colspan="1" id="text-alignment">Nationality</td>
                                                    <td id="text-alignment">
                                                        <select class="custom-select" id="mlc_farer_nationality" name="mlc_farer_nationality">
                                                            <option value="">Choose option</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="1" id="text-alignment">Birth Date</td>
                                                    <td id="text-alignment">
                                                        <input type="date" id="mlc_farer_birthdate" name="mlc_farer_birthdate" class="form-control" readonly>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <!-- [END] -->

                                            <!-- [START] -->
                                            <thead class="text-left text-dark font-weight-medium bg-light font-letter-spacing">
                                                <tr>
                                                    <th colspan="7">1. The place where and date when seafarer's employment agreement agreement is entered into</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td colspan="2" id="text-alignment">1.1 Place</td>
                                                    <td id="text-alignment">
                                                        <input type="text" id="mlc_sign_place" name="mlc_sign_place" class="form-control">
                                                    </td>
                                                    <td colspan="2" id="text-alignment">1.2 Date</td>
                                                    <td colspan="3" id="text-alignment">
                                                        <input type="date" id="mlc_sign_date" name="mlc_sign_date" class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->

                                            <!-- [START] -->
                                            <thead class="text-left text-dark font-weight-medium bg-light font-letter-spacing">
                                                <tr>
                                                    <th colspan="7">2. Monthly Wage</th>
                                                </tr>
                                            </thead>

                                            <tbody class="text-center">
                                                <tr>
                                                    <td colspan="1" id="text-alignment">A. </td>
                                                    <td colspan="2" id="text-alignment">B.W: Basic Wage</td>
                                                    <td id="text-alignment"><input type="text" id="mlc_bw" name="mlc_bw" class="form-control"></td>
                                                    <td colspan="4" id="text-alignment">US$/Month</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" id="text-alignment">B. </td>
                                                    <td colspan="2" id="text-alignment">O.T: Overtime Allowances</td>
                                                    <td id="text-alignment"><input type="text" id="mlc_ot" name="mlc_ot" class="form-control"></td>
                                                    <td colspan="4" id="text-alignment">US$/Month (FIXED)</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" id="text-alignment">C. </td>
                                                    <td colspan="2" id="text-alignment">Paid Leave</td>
                                                    <td id="text-alignment"><input type="text" id="mlc_pl" name="mlc_pl" class="form-control"></td>
                                                    <td colspan="4" id="text-alignment">US$/Month ( 9.0 Days / Month )</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" id="text-alignment">D. </td>
                                                    <td colspan="2" id="text-alignment">Special Allowances</td>
                                                    <td id="text-alignment"><input type="text" id="mlc_sa" name="mlc_sa" class="form-control"></td>
                                                    <td colspan="4" id="text-alignment">US$/Month </br> <small class="text-muted"> *Special Allowances include SVA, SMB, Tanker, Dangerous Cargo, SBS, P/F etc</small></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" id="text-alignment">E. </td>
                                                    <td colspan="2" id="text-alignment">Rejoining Bonus</td>
                                                    <td id="text-alignment"><input type="text" id="mlc_rb" name="mlc_rb" class="form-control"></td>
                                                    <td colspan="4" id="text-alignment">US$/Month</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" id="text-alignment">F. </td>
                                                    <td colspan="2" id="text-alignment">M.T: Monthly Total Salary (F = A ~ + E) </td>
                                                    <td id="text-alignment"><input type="text" id="mlc_mts" name="mlc_mts" class="form-control"></td>
                                                    <td colspan="4" id="text-alignment">US$/Month</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" id="text-alignment">G. </td>
                                                    <td colspan="2" id="text-alignment">FKSU Special Membership Fee</td>
                                                    <td id="text-alignment"><input type="text" id="mlc_fksu" name="mlc_fksu" class="form-control"></td>
                                                    <td colspan="4" id="text-alignment">US$/Month </br> <small class="text-muted">*US$40 deductions from monthly total salary according to CA(CBA)</small></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" id="text-alignment">H. </td>
                                                    <td colspan="2" id="text-alignment">M.T after deductions (H = F - G)</td>
                                                    <td id="text-alignment"><input type="text" id="mlc_mt" name="mlc_mt" class="form-control"></td>
                                                    <td colspan="4" id="text-alignment">US$/Month</td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->

                                            <!-- [START] -->
                                            <thead class="text-left text-dark font-weight-medium bg-light font-letter-spacing">
                                                <tr>
                                                    <th colspan="7">3. Period of employment</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td colspan="4" id="text-alignment" class="text-left font-weight-medium">
                                                        When shipowner terminates the contract early, the required minimum notice period shall be over 30 days and when seafarer terminates
                                                        the contract early, the required notice shall be 15 days and notify the seafarer / shipowner.</td>
                                                    <td colspan="2" id="text-alignment"><input type="date" class="form-control" id="mlc_employment_period_from" name="mlc_employment_period_from"></td>
                                                    <td colspan="1" id="text-alignment"><input type="date" class="form-control" id="mlc_employment_period_to" name="mlc_employment_period_to"></td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->

                                            <!-- [START] -->
                                            <thead class="text-left text-dark font-weight-medium bg-light font-letter-spacing">
                                                <tr>
                                                    <th colspan="7">4. Termination of Contract</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        When shipowner terminates the contract early, the required minimum notice period shall be over 30 days and when seafarer terminates
                                                        the contract early, the required notice shall be 15 days and notify the seafarer / shipowner.
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->

                                            <!-- [START] -->
                                            <thead class="text-left text-dark font-weight-medium bg-light font-letter-spacing">
                                                <tr>
                                                    <th colspan="7">5. Pay day & Payment method</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        ( 15 ) th of following month. If the payment date falls on a holiday, payment will be made on the day before the holiday. And method of payment
                                                        will be paid to seafarer or credited to the bank account of seafarer. Some allotments should be remitted directly to persons nominated by the seafarers.
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->

                                            <!-- [START] -->
                                            <thead class="text-left text-dark font-weight-medium bg-light font-letter-spacing">
                                                <tr>
                                                    <th colspan="7" id="six_mp_header" style="display: none">6. Daily victualing expenses</th>
                                                    <th colspan="7" id="six_k_header" style="display: none">6. Standard of Hours of Work and Hours of Rest</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <!-- KOREAN FLAG -->
                                                <tr id="six_korean_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        6.1 Working Hours <br>
                                                        (1) Hours of Ordinary Work : 8 Hours in a day and 40 Hours in a week. But, who onboard Korean Flag Vessel : 8 Hours in a day and 44 Hours in a week <br>
                                                        (2) Over Time Work : Fixed Over Time or Guranteed Over Time (103 Hours/Month) shall be applied with Ship <br>
                                                        CBA <br>
                                                        <br>
                                                        6.2 Hours of rest <br>
                                                        (1) Minmum of 10 hours rest in any 24 hour period and 77 hours in any seven-day period <br>
                                                        (2) Minmum of 10 hours rest in any 24 hour period may be devided into no more than 2 periods, one of which shall be at least 6 hours in length. <br>
                                                        (3) The interval between consecutive periods of rest shall not exceed 14 hours. <br>
                                                        (4) Mustersand drills and drills shall be conducted in a manner that minimizes the disturbance of rest periods and does not induce fatigue. <br>
                                                    </td>
                                                </tr>
                                                <!-- PANAMA FLAG -->
                                                <tr id="six_panama_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        Minimum 11.50 USD
                                                    </td>
                                                </tr>
                                                <!-- MARSHALL FLAG -->
                                                <tr id="six_marshall_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        Minimum 11.50 USD
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->

                                            <tbody class="text-center">
                                                <tr class="text-left text-dark font-weight-medium bg-light">
                                                    <td colspan="7" id="seven_mp_header" style="display: none">7. Standard of hours of work and hours of rest</td>
                                                    <td colspan="7" id="seven_k_header" style="display: none">7. Health and social security protection benefits</td>
                                                </tr>

                                                <!-- KOREAN FLAG -->
                                                <tr id="seven_korean_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        7.1 Shipowner provides medical care, sickness benefit, employment injury benefit, invalidity benefit, family benefit and survivors' benefit to the seafarer.
                                                    </td>
                                                </tr>
                                                <!-- PANAMA FLAG -->
                                                <tr id="seven_panama_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        7.1 Working hours <br>
                                                        (1) Hours of Ordinary Work : 8 hrs in a day and 40 hrs in a week . / But, who onboard Korean flag vessel : 8 hrs in a day and 44 hrs in a week <br>
                                                        (2) Over time work : Fixed Over Time or Guranteed Over Time (103 hrs/Month) should be applied with the ship's CBA. <br>
                                                        <br>
                                                        7.2 Hours of rest
                                                        (1) Minmum of 10 hrs rest in any 24 hour period and 77 hrs in any seven-day period <br>
                                                        (2) Minmum of 10 hrs rest in any 24 hour period may be devided into no more than 2 periods, one of which shall be at least 6 hrs in length. <br>
                                                        (3) The interval between consecutive periods of rest shall not exceed 14 hrs. <br>
                                                        (4) Mustersand drills and drills shall be conducted in a manner that minimizes the disturbance of rest periods and does not induce fatigue. <br>
                                                    </td>
                                                </tr>
                                                <!-- MARSHALL FLAG -->
                                                <tr id="seven_marshall_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        7.1 Working hours <br>
                                                        (1) Hours of Ordinary Work : 8 hrs in a day and 40 hrs in a week . / But, who onboard Korean flag vessel : 8 hrs in a day and 44 hrs in a week <br>
                                                        (2) Over time work : Fixed Over Time or Guranteed Over Time (103 hrs/Month) should be applied with the ship's CBA. <br>
                                                        <br>
                                                        7.2 Hours of rest
                                                        (1) Minmum of 10 hrs rest in any 24 hour period and 77 hrs in any seven-day period <br>
                                                        (2) Minmum of 10 hrs rest in any 24 hour period may be devided into no more than 2 periods, one of which shall be at least 6 hrs in length. <br>
                                                        (3) The interval between consecutive periods of rest shall not exceed 14 hrs. <br>
                                                        (4) Mustersand drills and drills shall be conducted in a manner that minimizes the disturbance of rest periods and does not induce fatigue. <br>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <!-- [START] -->
                                            <tbody>
                                                <tr class="text-left text-dark font-weight-medium bg-light">
                                                    <td colspan="7" id="eight_mp_header" style="display: none">8. Health and social security protection benefits</td>
                                                    <td colspan="7" id="eight_k_header" style="display: none">8. Seafarer's entitlement to repatriation</td>
                                                </tr>

                                                <!-- KOREAN FLAG -->
                                                <tr id="eight_korean_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        8.1 Shipowner shall promptly repatriate the seafarer who leaves a ship at the place of which is not the seafarer's
                                                        country of residence or the place at which the seafarer agreed to enter into the engagement as shipowner's
                                                        expenses except on the misconduct or incompetence of seafarer. however, in case where shipowner paid
                                                        the expense of repatriation according shipowner to the request of seafarer, does not have any responsibility for
                                                        the repatriation. <br>
                                                        <br>
                                                        8.2 Probationary Service Period
                                                        It is hereby understood by the parties that the first six (6) weeks of service of each crew employed with the
                                                        PRINCIPAL shall be regarded as probationary period and both the PRINCIPAL and seafarer shall be entitled
                                                        to terminate the employment prior to the termination of employment shall apply. In such event the cost of
                                                        repatriation shall be the responsibility of the party who gives notice of termination but the compensation
                                                        for premature termination of employment shall not apply.
                                                    </td>
                                                </tr>
                                                <!-- PANAMA FLAG -->
                                                <tr id="eight_panama_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        Shipowner provides medical care, sickness benefit, employment injury benefit, invalidity benefit, family benefit and survivors' benefit
                                                        to the seafarer.
                                                    </td>
                                                </tr>
                                                <!-- MARSHALL FLAG -->
                                                <tr id="eight_marshall_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        Shipowner provides medical care, sickness benefit, employment injury benefit, invalidity benefit, family benefit and survivors' benefit
                                                        to the seafarer.
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->

                                            <!-- [START] -->
                                            <thead class="text-left text-dark font-weight-medium bg-light font-letter-spacing">
                                                <tr>
                                                    <th colspan="7" id="nine_k_header" style="display: none">9. Discipline</th>
                                                    <th colspan="7" id="nine_mp_header" style="display: none">9. Seafarer's entitlement to repatriation</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <!-- KOREAN FLAG -->
                                                <tr id="nine_korean_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        The seafarer shall accept the following disciplinary regulation by the Company. <br>
                                                        (1) Violence, violation of the law, smuggling, desertion, intoxication, lack of ability to his duty, insubordination, <br>
                                                        against lawful order, destruction, sabotage, embezzlement. <br>
                                                        (2) In case of the above paragraph 1, the master of the vessel has right to dismiss the seafarer as discipline <br>
                                                        with the master's report only which in mentioned the reason of discipline. <br>
                                                    </td>
                                                </tr>
                                                <!-- PANAMA FLAG -->
                                                <tr id="nine_panama_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        9.1 Shipowner shall promptly repatriate the seafarer who leaves a ship at the place of which is not the seafarer's country of residence or the place
                                                        at which the seafarer agreed to enter into the engagement as shipowner's expenses except on the misconduct or incompetence of seafarer.farer.
                                                        However, in case where shipowner paid the expense of repatriation according shipowner to the request of seafarer, does not have anyany
                                                        responsibility for the repatriation. <br>
                                                        <br>
                                                        9.2 Probationary Service Period
                                                        It is hereby understood by the parties that the first six (6) weeks of service of each crew employed with the PRINCIPAL shall be regarded as
                                                        probationary period and both the PRINCIPAL and seafarer shall be entitled to terminate the employment prior to the termination of employmentI
                                                        shall apply. In such event the cost of repatriation shall be the responsibility of the party who gives notice of termination but the compensation
                                                        for premature termination of employment shall not apply. <br>
                                                        <br>
                                                        9.3 Notwithstanding above 9.1, where a seafarer falls under any of the following cases, a shipowner may claim expenses incurred in the repatriation
                                                        against him/her: Provided, That the shipowner shall not claim an amount of money equivalent to 50/100 of the expenses incurred in the repatriation
                                                        of a seafarer repatriated after he/she has worked on board for six months or more
                                                        (1) When the seafarer leaves a ship without just reason <br>
                                                        (2) When the seafarer leaves a ship according to disciplinary punishment which regulated in national laws <br>
                                                        (3) When the reason is conformed to the collective bargaining agreement or rules of employment or national laws <br>
                                                    </td>
                                                </tr>
                                                <!-- MARSHALL FLAG -->
                                                <tr id="nine_marshall_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        9.1 Shipowner shall promptly repatriate the seafarer who leaves a ship at the place of which is not the seafarer's country of residence or the place
                                                        at which the seafarer agreed to enter into the engagement as shipowner's expenses except on the misconduct or incompetence of seafarer.farer.
                                                        However, in case where shipowner paid the expense of repatriation according shipowner to the request of seafarer, does not have anyany
                                                        responsibility for the repatriation. <br>
                                                        <br>
                                                        9.2 Probationary Service Period
                                                        It is hereby understood by the parties that the first six (6) weeks of service of each crew employed with the PRINCIPAL shall be regarded as
                                                        probationary period and both the PRINCIPAL and seafarer shall be entitled to terminate the employment prior to the termination of employmentI
                                                        shall apply. In such event the cost of repatriation shall be the responsibility of the party who gives notice of termination but the compensation
                                                        for premature termination of employment shall not apply. <br>
                                                        <br>
                                                        9.3 Notwithstanding above 9.1, where a seafarer falls under any of the following cases, a shipowner may claim expenses incurred in the repatriation
                                                        against him/her: Provided, That the shipowner shall not claim an amount of money equivalent to 50/100 of the expenses incurred in the repatriation
                                                        of a seafarer repatriated after he/she has worked on board for six months or more
                                                        (1) When the seafarer leaves a ship without just reason <br>
                                                        (2) When the seafarer leaves a ship according to disciplinary punishment which regulated in national laws <br>
                                                        (3) When the reason is conformed to the collective bargaining agreement or rules of employment or national laws <br>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->

                                            <!-- [START] -->
                                            <thead class="text-left text-dark font-weight-medium bg-light font-letter-spacing">
                                                <tr>
                                                    <th colspan="7">10. Etc</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <!-- KOREAN FLAG -->
                                                <tr id="etc_korean_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        10.1 Signing of this Contract of Employment binds the seafarer to sign the appropriate article of agreement of the ship to which he may be appointed by the Company during his employment. <br> <br>
                                                        10.2 Violations of the terms and conditions of this contract with its approved addendum shall he ground for disciplinary action against the erring party. <br> <br>
                                                        10.3 Any facts which are not defined in this contract, these are complied with national laws or the collective bargaining agreement or rules of employment.
                                                    </td>
                                                </tr>
                                                <!-- PANAMA FLAG -->
                                                <tr id="etc_panama_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        10.1 Signing of this Contract of Employment binds the seafarer to sign the appropriate article of agreement of the ship to which he may be appointed by the Company during his employment. <br> <br>
                                                        10.2 Any alterations or changes, in any part of this Contract shall be evaluated, verified, processed and approved by the Philippine Overseas Employment Administration (POEA). Upon approval, the same shall be deemed an integral part of the Standard Terms and conditionsgoverning the Employment of Filipino Seafarers On Board Ocean-Going Vessels. <br> <br>
                                                        10.3 Violations of the terms and conditions of this contract with its approved addendum shall he ground for disciplinary action against the erring party. <br> <br>
                                                        10.4 Any facts which are not defined in this contract, these are complied with national laws or the collective bargaining agreement or rules of employment.
                                                    </td>
                                                </tr>
                                                <!-- MARSHALL FLAG -->
                                                <tr id="etc_marshall_flag" style="display: none">
                                                    <td colspan="7" class="text-left font-weight-medium">
                                                        10.1 Signing of this Contract of Employment binds the seafarer to sign the appropriate article of agreement of the ship to which he may be appointed by the Company during his employment. <br> <br>
                                                        10.2 Any alterations or changes, in any part of this Contract shall be evaluated, verified, processed and approved by the Philippine Overseas Employment Administration (POEA). Upon approval, the same shall be deemed an integral part of the Standard Terms and conditionsgoverning the Employment of Filipino Seafarers On Board Ocean-Going Vessels. <br> <br>
                                                        10.3 Violations of the terms and conditions of this contract with its approved addendum shall he ground for disciplinary action against the erring party. <br> <br>
                                                        10.4 The Parties to this contract hereby stipulate that the terms and conditions laid down herein shall be subject to the applicable provisions of the Maritime Law and Regulations of the Republic of the Marshall Islands. Any dispute as to the terms and conditions of this contract shall be resolved in accordance with the Maritime Law and Regulations of the Republic of the Marshall Islands.10.5 Any facts which are not defined in this contract, these are complied with national laws or the collective bargaining agreement or rules of employment.<br> <br>
                                                        10.5 Any facts which are not defined in this contract, these are complied with national laws or the the collective bargaining agreement or rules of employment.
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->

                                            <!-- [START] -->
                                            <thead class="text-left text-dark font-weight-medium bg-light font-letter-spacing">
                                                <tr>
                                                    <th colspan="7">11. Any other</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td colspan="7" class="text-left font-weight-medium"> The home remittance should be paid by Peso and Exchange rate(US$ -> PHP) is followed up at the date standard exchange rates of bank when salary remit.</td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->

                                            <!-- [START] -->
                                            <thead class="text-left text-dark font-weight-medium bg-light font-letter-spacing">
                                                <tr>
                                                    <th colspan="7">In witness whereof, 2 copies of this Contract have been made and mutually signed by either parties thence each one of them are retained by the each party.</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td colspan="6" id="text-alignment">(Name of Seafarer)</td>
                                                    <td colspan="1" id="text-alignment"><input type="text" class="form-control" id="mlc_name_of_seafared" name="mlc_name_of_seafared" readonly></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6" id="text-alignment">(On behalf of the shipowner(s) of the Vessel)</td>
                                                    <td colspan="1" id="text-alignment"><input type="text" class="form-control" id="mlc_shipowner_vessel" name="mlc_shipowner_vessel"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6" id="text-alignment">Vice President Alphera Marine Services Inc.</td>
                                                    <td colspan="1" id="text-alignment"><input type="text" class="form-control" id="mlc_vp_alphera" name="mlc_vp_alphera"></td>
                                                </tr>
                                            </tbody>
                                            <!-- [END] -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MLC CONTRACT [END] -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="BtnAddContractMLC">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('assets/javascript/a_mlc_contract.js') ?>"></script>