<?php
try {
    $header = '
    <style>
    .myfixed {
        text-align: center;
    }
    </style>
    ';

    $mpdf = new \Mpdf\Mpdf([
      'tempDir' => __DIR__ . '/temp_files', // uses the current directory's parent "tmp" subfolder
      'setAutoTopMargin' => 'stretch',
      'setAutoBottomMargin' => 'stretch'
    ]);
    $mpdf->WriteHTML($header);
    $mpdf->WriteHTML('
<div class="content-wrapper">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row myfixed">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-center">
                            <center><h4>Republic of the Philippines</h4></center>
                            <center><h4>Department of Labor and Employment</h4></center>
                            <center><h4>PHILIPPINE OVERSEAS EMPLOYMENT ADMINISTRATION</h4></center>
                        </div>
                        <center><h4 class="page-title">CONTRACT OF EMPLOYMENT</h4></center>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row md-12">
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                <h5>KNOWN ALL MEN BY THESE PRESENTS:</h5>

                <div class="row md-12" >
                <div class="column" style="float:left; width:50%" >
                    <p class="m-b-10"><strong>Name of Seafarer : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["full_name"].'</span></p>
                    <p class="m-b-10"><strong>Date of Birth : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.date('M j, Y', strtotime($crew_data["birth_date"])).'</span></p>
                    <p class="m-b-10"><strong>Place of Birth : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["birth_place"].'</span></p>
                    <p class="m-b-10"><strong>Address : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["full_address"].'</span></p>
                </div>

                <div class="column" style="float:right; width:40%; margin-left:30px" >
                <p class="m-b-10"><strong>SIRB No : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["sirb_no"].'</span></p>
                <p><strong>SRC No : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["src_no"].'</span></p>
                <p><strong>License No : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["license"].'</span></p>
                </div>
                </div>
                    <div class="col-md-12"><p style="font-style: italic;">Hereinafter referred to as the Seafarer</p></div>
                    <p class="m-b-10"><strong>Name of Agent : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["agent_name"].'</span></p>
                    <p class="m-b-10"><strong>Name of Principal/Shipowner : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["ps_name"].'</span></p>
                    <p class="m-b-10"><strong>Address of Principal/Shipowner : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["ps_address"].'</span></p>

                    <div class="col-md-12"><h4 style="font-style: italic;font-weight:bolder;">For the following vessel:</h4><p></p></div>
                    <div class="row md-12" >
                    <div class="column" style="float:left; width:50%" >
                        <p class="m-b-10"><strong>Name of Vessel : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["vsl_name"].'</span></p>
                        <p class="m-b-10"><strong>IMO Number : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["imo_no"].'</span></p>
                        <p class="m-b-10"><strong>Gross Tonnage (GRT) : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["grt"].'</span></p>
                        <p class="m-b-10"><strong>Year Built : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["year_build"].'</span></p>
                    </div>
                    <div class="column" style="float:right; width:40%; margin-left:30px" >
                        <p class="m-b-10"><strong>Flag : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["flag"].'</span></p>
                        <p class="m-b-10"><strong>Type of Vessel : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["vessel_type"].'</span></p>
                        <p class="m-b-10"><strong>Society Classification : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["society_classification"].'</span></p>
                    </div>
                    </div>

                    <br>
                    <div class="col-md-12"><h5 style="font-style: italic;font-weight:bolder;">Hereinafter referred to as the Employer</h5><p></p></div>

                    <center><h4>WITNESSETH</h4></center>
                    <div class="col-md-12">
                        <div class="row">
                            <ol>
                                <li>
                                    <b>The employee shall be employed on board under the following terms and conditions:</b>
                                    <ul style="list-style-type:none;">
                                        <li>1.1 <strong>Duration of Contract : </strong>'.$crew_data["contract_duration"].'</li>
                                        <li>1.2 <strong>Position : </strong> <span class="float-left"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["position_name"].'</span></li>
                                        <li>1.3 <strong>Basic Monthly Salary : </strong> <span class="float-left"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["monthly_salary"].'</span></li>
                                        <li>1.4 <strong>Hours of Work : </strong> <span class="float-left"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["work_hours"].'</span></li>
                                        <li>1.5 <strong>Overtime : </strong> <span class="float-left"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["ot"].'</span></li>
                                        <li>1.6 <strong>Vacation Leave with Pay : </strong> <span class="float-left"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["vl_pay"].'</span></li>
                                        <li>1.7 <strong>Others : </strong> <span class="float-left"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["others"].'</span></li>
                                        <li>1.8 <strong>Total Salary : </strong> <span class="float-left"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["total_salary"].'</span></li>
                                        <li>1.9 <strong>Point of Hire : </strong> <span class="float-left"> &nbsp;&nbsp;&nbsp;&nbsp;'.date('M j, Y', strtotime($crew_data["hire_point"])).'</span></li>
                                        <li>1.10 <strong>Collective Bargaining Agreement, if any : </strong> <span class="float-left"> &nbsp;&nbsp;&nbsp;&nbsp;'.$crew_data["collective_agreement"].'</span></li>
                                    </ul>
                                </li>
                                <br>
                                <li><b>The herein terms and conditions in accordance with Governing Board Resolution No. 9
                                    and MemorandumCircularNo.10, both series of 2010, shall be strictly and faithfully observed.</b></li>
                                    <br>
                                <li><b>Any alterations or changes, in any part of this Contract shall be evaluated, verified, processed and approved by thePhilippine Overseas Employment Administration (POEA).
                                     Upon approval, the same shall be deemed an integral part ofthe Standard Terms and Conditions Governing the Employment of Filipino Seafarers On-Board Ocean-Going Vessels.</b></li>
                                     <br>
                                <li><b>Violations of the terms and conditions of this contract with its approved addendum shall he ground for disciplinaryaction against the erring party. </b></li>
                            </ol>
                            <div class="cold-md-12">
                            <p style="font-style: italic;">IN WITNESS WHEREOF the parties have hereto set their hands this  03 Day of JAN 2020 at Manila, Philippines</p>
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-12"><h4 style="font-style: italic;font-weight:bolder;">For the following vessel:</h4><p></p></div>

                        <div class="row md-12" >
                        <div class="column" style="float:left; width:50%" >
                            <input type="text" class="signature" style="border: 0;border-bottom: 1px solid #000;"/>
                            <p>'.$crew_data["full_name"].'</p><center><label><b>SEAFARER</b></label></center>
                        </div>
                        <div class="column" style="float:right; width:40%; margin-left:30px" >
                            <p></p><center><label><b>For the EmployerName & Signature /Designation</b></label></center>
                        </div>
                        </div>

                        <div class="row md-12" >
                        <div class="column" style="float:left; width:50%" >
                            <p>'.date('Y-m-d').'</p><center><label><b>DATE</b></label></center>
                        </div>
                        <div class="column" style="float:right; width:40%; margin-left:30px" >
                            <p></p><center><label><b>Name & Signature of POEA OfficialX</b></label></center>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>',\Mpdf\HTMLParserMode::HTML_BODY);

    // Saves file on the server as 'filename.pdf'
$mpdf->Output('contract.pdf', \Mpdf\Output\Destination::DOWNLOAD);

  } catch (\Mpdf\MpdfException $e) {
      print "Creating an mPDF object failed with" . $e->getMessage();
  }
