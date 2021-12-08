<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_crew_module extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->load->library('pdf');
    }

    // MANAGE CM PLAN - START
    public function print_cm_plan()
    {

        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $crews = $this->crew_management->getOffSignerCrew($conditions);
        $count_crews = count($crews);

        $nobr = $count_crews >= 7 ? "true" : "";

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('CM PLAN SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "CREW MANAGEMENT PLAN SUMMARY", $XBORDER, 1, 0, true, 'C', true);


        $pdf->ln(5);
        $html = "<table border=\"1\" cellpadding=\"4\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NR</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CODE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>VESSEL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>RANK</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>S/ON</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>END CONTRACT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MOS. ONBOARD</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>X DATE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>X PORT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>RELIEVER</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>REMARKS</b></th>
                    </tr>";

        if ($crews) {
            $nr = 1;

            foreach ($crews as $crew) {
                $reliever_name = "-";
                $reliever_code = $this->global->getCrew($crew['insigner']);
                if (!empty($reliever_code)) {
                    $reliever_name = $reliever_code['crew_code'] != NULL ? $this->global->GetCrewFullName($reliever_code['crew_code'])->full_name : "-";
                }

                $cmp_code = $crew['cmp_code'] ? $crew['cmp_code'] : "-";
                $vsl_name = $crew['vsl_name'] ? $crew['vsl_name'] : "-";
                $position_name = $crew['position_name'] ? $crew['position_name'] : "-";
                $full_name = $crew['full_name'] ? $crew['full_name'] : "-";
                $sign_on = $crew['sign_on'] ? $crew['sign_on'] : "-";
                $contract_duration = $crew['disembark'] ? $crew['disembark'] : "-";
                $months_onboard = $crew['months_onboard'] ? $crew['months_onboard'] : "-";
                $date_x = $crew['date_x'] ? $crew['date_x'] : "-";
                $x_port = $crew['x_port'] ? $crew['x_port'] : "-";
                $remarks = $crew['remarks'] ? $crew['remarks'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$nr}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$cmp_code}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$vsl_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$full_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$sign_on}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$contract_duration}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$months_onboard}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$date_x}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$x_port}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$reliever_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$remarks}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"12\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('cm_plan.pdf', 'I');
    }
    // MANAGE CM PLAN - END

    // CREW LIST - START
    public function print_all_crews()
    {

        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');


        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('ALL CREWS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "ALL CREWS SUMMARY", $XBORDER, 1, 0, true, 'C', true);


        $pdf->ln(5);

        $all_crews = $this->all_crew->getAllCrew($conditions);
        $count_all_crews = count($all_crews);
        $nobr = $count_all_crews >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"5\">
                        <tr>
                            <th style=\"font-size:8px;\" align=\"center\"><b>CREW CODE</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>NAME</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>RANK</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>DATE <br> AVAILABILITY</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>S/ON</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>DATE OF <br> DISEMBARKATION</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>PASSPORT</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>LICENSES</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>CERTIFICATES</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>POEA</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>MLC</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>MEDICAL</b></th>
                            <th style=\"font-size:8px;\" align=\"center\"><b>STATUS</b></th>
                        </tr>";

        if ($all_crews) {

            foreach ($all_crews as $all_crew) {

                $date_available = $all_crew['date_available'] ? date("Y-m-d", strtotime($all_crew['date_available'])) : "-";
                $sign_on = $all_crew['sign_on'] ? date("Y-m-d", strtotime($all_crew['sign_on'])) : "-";
                $contract_duration = $all_crew['contract_duration'] ? date("Y-m-d", strtotime($all_crew['contract_duration'])) : "-";

                $passport_validity = $this->crew_management->validate_passport_report($all_crew['crew_code']);
                $passport_style = "";
                if (strtolower($passport_validity) == "expired") {
                    $passport_style = "color: red;";
                } else if (strtolower($passport_validity) == "valid") {
                    $passport_style = "color: green;";
                }

                $licenses_validity = $this->crew_management->get_license_validity_report($all_crew['crew_code']);
                $licenses_style = "";
                if (strtolower($licenses_validity) == "expired") {
                    $licenses_style = "color: red;";
                } else if (strtolower($licenses_validity) == "valid") {
                    $licenses_style = "color: green;";
                } else if (strtolower($licenses_validity) == "near/expired") {
                    $licenses_style = "color: orange;";
                }

                $cert_validity = $this->crew_management->validate_certificates_report($all_crew['crew_code']);
                $cert_style = "";
                if (strtolower($cert_validity) == "expired") {
                    $cert_style = "color: red;";
                } else if (strtolower($cert_validity) == "valid") {
                    $cert_style = "color: green;";
                } else if (strtolower($cert_validity) == "near/expired") {
                    $cert_style = "color: orange;";
                }

                $contract = $this->contracts->getCrewContract($all_crew['crew_code']);
                $contract_contract_duration = "N/A";
                if (!empty($contract)) {
                    $new_contract = $contract[0];
                    $contract_contract_duration = $new_contract["contract_duration"];
                }

                $mlc_validity = $this->crew_management->get_mlc_validity_report($all_crew['crew_code']);
                $mlc_style = "";
                if (strtolower($mlc_validity) == "valid") {
                    $mlc_style = "color: green;";
                }

                $medical_validity = $this->medical->get_medical_validity_report($all_crew['crew_code']);
                $medical_style = "";
                if (strtolower($medical_validity) == "valid") {
                    $medical_style = "color: green;";
                } else if (strtolower($medical_validity) == "pending") {
                    $medical_style = "color: orange;";
                } else if (strtolower($medical_validity) == "expired" || strtolower($medical_validity) == "rejected") {
                    $medical_style = "color: red;";
                }

                $crew_status = $this->global->getCrewStatusReport($all_crew['crew_status']);

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$all_crew['crew_code']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$all_crew['full_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$all_crew['position_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$date_available}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$sign_on}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$contract_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$passport_style}\">{$passport_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$licenses_style}\">{$licenses_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$cert_style}\">{$cert_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$contract_contract_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$mlc_style}\">{$mlc_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$medical_style}\">{$medical_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$crew_status["style"]}\">{$crew_status["status"]}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"13\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Output('all_crews.pdf', 'I');
    }

    public function print_new_crews()
    {
        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');


        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('NEW CREWS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "NEW CREWS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $new_crews = $this->new_crew->getNewCrew($conditions);

        $count_new_crews = count($new_crews);

        $nobr = $count_new_crews >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CREW CODE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>RANK</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE <br> AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE OF <br> DISEMBARKATION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>PASSPORT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>LICENSES</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CERTIFICATES</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>POEA</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MLC</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MEDICAL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>STATUS</b></th>
                    </tr>";
        if ($new_crews) {

            foreach ($new_crews as $new_crew) {
                $date_available = $new_crew['date_available'] ? date("Y-m-d", strtotime($new_crew['date_available'])) : "-";
                $contract_duration = $new_crew['contract_duration'] ? date("Y-m-d", strtotime($new_crew['contract_duration'])) : "-";
                $passport_validity = $this->crew_management->validate_passport_report($new_crew['crew_code']);

                $passport_style = "";
                if (strtolower($passport_validity) == "expired") {
                    $passport_style = "color: red;";
                } else if (strtolower($passport_validity) == "valid") {
                    $passport_style = "color: green;";
                }

                $licenses_validity = $this->crew_management->get_license_validity_report($new_crew['crew_code']);
                $licenses_style = "";
                if (strtolower($licenses_validity) == "expired") {
                    $licenses_style = "color: red;";
                } else if (strtolower($licenses_validity) == "valid") {
                    $licenses_style = "color: green;";
                } else if (strtolower($licenses_validity) == "near/expired") {
                    $licenses_style = "color: orange;";
                }

                $cert_validity = $this->crew_management->validate_certificates_report($new_crew['crew_code']);
                $cert_style = "";
                if (strtolower($cert_validity) == "expired") {
                    $cert_style = "color: red;";
                } else if (strtolower($cert_validity) == "valid") {
                    $cert_style = "color: green;";
                } else if (strtolower($cert_validity) == "near/expired") {
                    $cert_style = "color: orange;";
                }

                $contract = $this->contracts->getCrewContract($new_crew['crew_code']);
                $contract_contract_duration = "N/A";
                if (!empty($contract)) {
                    $new_contract = $contract[0];
                    $contract_contract_duration = $new_contract["contract_duration"];
                }

                $mlc_validity = $this->crew_management->get_mlc_validity_report($new_crew['crew_code']);
                $mlc_style = "";
                if (strtolower($mlc_validity) == "valid") {
                    $mlc_style = "color: green;";
                }

                $medical_validity = $this->medical->get_medical_validity_report($new_crew['crew_code']);
                $medical_style = "";
                if (strtolower($medical_validity) == "valid") {
                    $medical_style = "color: green;";
                } else if (strtolower($medical_validity) == "pending") {
                    $medical_style = "color: orange;";
                } else if (strtolower($medical_validity) == "expired" || strtolower($medical_validity) == "rejected") {
                    $medical_style = "color: red;";
                }

                $crew_status = $this->global->getCrewStatusReport($new_crew['status']);

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$new_crew['crew_code']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$new_crew['full_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$new_crew['position_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$date_available}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$contract_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$passport_style}\">{$passport_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$licenses_style}\">{$licenses_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$cert_style}\">{$cert_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$contract_contract_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$mlc_style}\">{$mlc_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$medical_style}\">{$medical_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$crew_status["style"]}\">{$crew_status["status"]}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"12\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }
        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Output('new_crews.pdf', 'I');
    }

    public function print_ex_crews()
    {
        $conditions = [];


        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('EX CREWS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "EX CREWS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $ex_crews = $this->ex_crew->getExCrew($conditions);

        $count_ex_crews = count($ex_crews);

        $nobr = $count_ex_crews >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CREW CODE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>RANK</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE <br> AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE OF <br> DISEMBARKATION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>PASSPORT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>LICENSES</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CERTIFICATES</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>POEA</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MLC</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MEDICAL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>STATUS</b></th>
                    </tr>";

        if ($ex_crews) {

            foreach ($ex_crews as $ex_crew) {
                $date_available = $ex_crew['date_available'] ? date("Y-m-d", strtotime($ex_crew['date_available'])) : "-";
                $contract_duration = $ex_crew['contract_duration'] ? date("Y-m-d", strtotime($ex_crew['contract_duration'])) : "-";
                $passport_validity = $this->crew_management->validate_passport_report($ex_crew['crew_code']);

                $passport_style = "";
                if (strtolower($passport_validity) == "expired") {
                    $passport_style = "color: red;";
                } else if (strtolower($passport_validity) == "valid") {
                    $passport_style = "color: green;";
                }

                $licenses_validity = $this->crew_management->get_license_validity_report($ex_crew['crew_code']);
                $licenses_style = "";
                if (strtolower($licenses_validity) == "expired") {
                    $licenses_style = "color: red;";
                } else if (strtolower($licenses_validity) == "valid") {
                    $licenses_style = "color: green;";
                } else if (strtolower($licenses_validity) == "near/expired") {
                    $licenses_style = "color: orange;";
                }

                $cert_validity = $this->crew_management->validate_certificates_report($ex_crew['crew_code']);
                $cert_style = "";
                if (strtolower($cert_validity) == "expired") {
                    $cert_style = "color: red;";
                } else if (strtolower($cert_validity) == "valid") {
                    $cert_style = "color: green;";
                } else if (strtolower($cert_validity) == "near/expired") {
                    $cert_style = "color: orange;";
                }

                $contract = $this->contracts->getCrewContract($ex_crew['crew_code']);
                $contract_contract_duration = "N/A";
                if (!empty($contract)) {
                    $new_contract = $contract[0];
                    $contract_contract_duration = $new_contract["contract_duration"];
                }

                $mlc_validity = $this->crew_management->get_mlc_validity_report($ex_crew['crew_code']);
                $mlc_style = "";
                if (strtolower($mlc_validity) == "valid") {
                    $mlc_style = "color: green;";
                }

                $medical_validity = $this->medical->get_medical_validity_report($ex_crew['crew_code']);
                $medical_style = "";
                if (strtolower($medical_validity) == "valid") {
                    $medical_style = "color: green;";
                } else if (strtolower($medical_validity) == "pending") {
                    $medical_style = "color: orange;";
                } else if (strtolower($medical_validity) == "expired" || strtolower($medical_validity) == "rejected") {
                    $medical_style = "color: red;";
                }

                $crew_status = $this->global->getCrewStatusReport($ex_crew['status']);

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$ex_crew['crew_code']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$ex_crew['full_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$ex_crew['position_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$date_available}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$contract_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$passport_style}\">{$passport_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$licenses_style}\">{$licenses_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$cert_style}\">{$cert_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$contract_contract_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$mlc_style}\">{$mlc_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$medical_style}\">{$medical_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$crew_status["style"]}\">{$crew_status["status"]}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"12\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }


        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('ex_crews.pdf', 'I');
    }

    public function print_nre_crews()
    {
        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('nre_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('nre_vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('nre_rank_search');

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('NRE CREWS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "NRE CREWS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $nre_crews = $this->nre_crew->getCrewNotForRehire($conditions);

        $count_nre_crews = count($nre_crews);

        $nobr = $count_nre_crews >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CREW CODE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>RANK</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE <br> AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>S/ON</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE OF <br> DISEMBARKATION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>PASSPORT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>LICENSES</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CERTIFICATES</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>POEA</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MLC</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MEDICAL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>STATUS</b></th>
                    </tr>";

        if ($nre_crews) {

            foreach ($nre_crews as $nre_crew) {
                $date_available = $nre_crew['date_available'] ? date("Y-m-d", strtotime($nre_crew['date_available'])) : "-";
                $contract_duration = $nre_crew['contract_duration'] ? date("Y-m-d", strtotime($nre_crew['contract_duration'])) : "-";
                $passport_validity = $this->crew_management->validate_passport_report($nre_crew['crew_code']);

                $s_on = $this->global->getCMP($nre_crew['monitor_code'])['sign_on'] ? date('M j, Y', strtotime($this->global->getCMP($nre_crew['monitor_code'])['sign_on'])) : '-';

                $passport_style = "";
                if (strtolower($passport_validity) == "expired") {
                    $passport_style = "color: red;";
                } else if (strtolower($passport_validity) == "valid") {
                    $passport_style = "color: green;";
                }

                $licenses_validity = $this->crew_management->get_license_validity_report($nre_crew['crew_code']);
                $licenses_style = "";
                if (strtolower($licenses_validity) == "expired") {
                    $licenses_style = "color: red;";
                } else if (strtolower($licenses_validity) == "valid") {
                    $licenses_style = "color: green;";
                } else if (strtolower($licenses_validity) == "near/expired") {
                    $licenses_style = "color: orange;";
                }

                $cert_validity = $this->crew_management->validate_certificates_report($nre_crew['crew_code']);
                $cert_style = "";
                if (strtolower($cert_validity) == "expired") {
                    $cert_style = "color: red;";
                } else if (strtolower($cert_validity) == "valid") {
                    $cert_style = "color: green;";
                } else if (strtolower($cert_validity) == "near/expired") {
                    $cert_style = "color: orange;";
                }

                $contract = $this->contracts->getCrewContract($nre_crew['crew_code']);
                $contract_contract_duration = "N/A";
                if (!empty($contract)) {
                    $new_contract = $contract[0];
                    $contract_contract_duration = $new_contract["contract_duration"];
                }

                $mlc_validity = $this->crew_management->get_mlc_validity_report($nre_crew['crew_code']);
                $mlc_style = "";
                if (strtolower($mlc_validity) == "valid") {
                    $mlc_style = "color: green;";
                }

                $medical_validity = $this->medical->get_medical_validity_report($nre_crew['crew_code']);
                $medical_style = "";
                if (strtolower($medical_validity) == "valid") {
                    $medical_style = "color: green;";
                } else if (strtolower($medical_validity) == "pending") {
                    $medical_style = "color: orange;";
                } else if (strtolower($medical_validity) == "expired" || strtolower($medical_validity) == "rejected") {
                    $medical_style = "color: red;";
                }

                $crew_status = $this->global->getCrewStatusReport($nre_crew['status']);

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$nre_crew['crew_code']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$nre_crew['full_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$nre_crew['position_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$date_available}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$s_on}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$contract_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$passport_style}\">{$passport_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$licenses_style}\">{$licenses_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$cert_style}\">{$cert_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$contract_contract_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$mlc_style}\">{$mlc_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$medical_style}\">{$medical_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$crew_status["style"]}\">{$crew_status["status"]}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"13\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('nre_crews.pdf', 'I');
    }
    // CREW LIST - END

    // PRE-JOINING MONITORING - START
    public function print_pre_joining_crews()
    {
        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('MANAGE PRE-JOINING SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "MANAGE PRE-JOINING SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $prejoining_crews = $this->crew_management->FilterPrejoining($conditions);

        $count_prejoining_crews = count($prejoining_crews);

        $nobr = $count_prejoining_crews >= 7 ? "true" : "";


        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th colspan=\"2\"></th>
                        <th style=\"font-size:8px;\" align=\"center\" colspan=\"2\">OFF SIGNER</th>
                        <th style=\"font-size:8px;\" align=\"center\" colspan=\"2\">ON SIGNER</th>
                        <th colspan=\"3\"></th>
                        <th style=\"font-size:8px;\" align=\"center\" colspan=\"5\">DOCUMENT STATUS</th>
                        <th colspan=\"1\"></th>
                    </tr>
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>VESSEL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>RANK</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>RANK</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CONTACT NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>JOINING PORT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>JOINING DATE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVAL STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MEDICAL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>LICENSES</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>TRAININGS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>POEA</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MLC</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>REMARKS</b></th>
                    </tr>";


        if ($prejoining_crews) {
            foreach ($prejoining_crews as $row) {

                $insigner_position = $row['insigner'] != NULL ? $this->global->getCrewNameByMonitorCode($row['insigner'])['position_code'] : "-";
                $insigner_name = $row['insigner'] != NULL ? $this->global->getCrewNameByMonitorCode($row['insigner'])['full_name'] : "-";
                $insigner_mobile_no = $row['insigner'] != NULL ? $this->global->getCrewNameByMonitorCode($row['insigner'])['mobile_number'] : "-";
                $x_port = $row['x_port'] ? $row['x_port'] : '-';
                $embark = $row['embark'] ? date('M j, Y', strtotime($row['embark'])) : '-';
                $remarks = $row['remarks'] ? $row['remarks'] : '-';

                $licenses_validity = $this->crew_management->get_license_validity_report($row['crew_code']);
                $licenses_style = "";
                if (strtolower($licenses_validity) == "expired") {
                    $licenses_style = "color: red;";
                } else if (strtolower($licenses_validity) == "valid") {
                    $licenses_style = "color: green;";
                } else if (strtolower($licenses_validity) == "near/expired") {
                    $licenses_style = "color: orange;";
                }

                $cert_validity = $this->crew_management->validate_certificates_report($row['crew_code']);
                $cert_style = "";
                if (strtolower($cert_validity) == "expired") {
                    $cert_style = "color: red;";
                } else if (strtolower($cert_validity) == "valid") {
                    $cert_style = "color: green;";
                } else if (strtolower($cert_validity) == "near/expired") {
                    $cert_style = "color: orange;";
                }

                $contract = $this->contracts->getCrewContract($row['crew_code']);
                $contract_contract_duration = "N/A";
                if (!empty($contract)) {
                    $new_contract = $contract[0];
                    $contract_contract_duration = $new_contract["contract_duration"];
                }

                $mlc_validity = $this->crew_management->get_mlc_validity_report($row['crew_code']);
                $mlc_style = "";
                if (strtolower($mlc_validity) == "valid") {
                    $mlc_style = "color: green;";
                }

                $medical_validity = $this->medical->get_medical_validity_report($row['crew_code']);
                $medical_style = "";
                if (strtolower($medical_validity) == "valid") {
                    $medical_style = "color: green;";
                } else if (strtolower($medical_validity) == "pending") {
                    $medical_style = "color: orange;";
                } else if (strtolower($medical_validity) == "expired" || strtolower($medical_validity) == "rejected") {
                    $medical_style = "color: red;";
                }

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['vsl_code']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['position_code']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['full_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$insigner_position}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$insigner_name}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$insigner_mobile_no}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$x_port}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$embark}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; color: green;\">APPROVED</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$medical_style}\">{$medical_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$licenses_style}\">{$licenses_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$cert_style}\">{$cert_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$contract_contract_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$mlc_style}\">{$mlc_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$remarks}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"15\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }


        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('pre_joining_crews.pdf', 'I');
    }
    // PRE-JOINING MONITORING - END


    // CREW MONITORING - START


    public function print_prejoining_visa_crews()
    {
        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('PRE-JOINING & VISA SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "PRE-JOINING & VISA SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $prejoining_visa_crews = $this->pre_joining->getPreJoiningCrew($conditions);

        $count_prejoining_visa_crews = count($prejoining_visa_crews);

        $nobr = $count_prejoining_visa_crews >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CREW CODE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>VESSEL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>RANK</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE OF AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>BMI</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>PASSPORT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>LICENSES</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CERTIFICATES</b></th>
                    </tr>";

        if ($prejoining_visa_crews) {
            foreach ($prejoining_visa_crews as $row) {

                $date_available = $row['date_available'] ? date("Y-m-d", strtotime($row['date_available'])) : "-";
                $bmi =  $this->global->getBMIScore($row['height'], $row['weight']);

                $passport_validity = $this->crew_management->validate_passport_report($row['crew_code']);
                $passport_style = "";
                if (strtolower($passport_validity) == "expired") {
                    $passport_style = "color: red;";
                } else if (strtolower($passport_validity) == "valid") {
                    $passport_style = "color: green;";
                }

                $licenses_validity = $this->crew_management->get_license_validity_report($row['crew_code']);
                $licenses_style = "";
                if (strtolower($licenses_validity) == "expired") {
                    $licenses_style = "color: red;";
                } else if (strtolower($licenses_validity) == "valid") {
                    $licenses_style = "color: green;";
                } else if (strtolower($licenses_validity) == "near/expired") {
                    $licenses_style = "color: orange;";
                }


                $cert_validity = $this->crew_management->validate_certificates_report($row['crew_code']);
                $cert_style = "";
                if (strtolower($cert_validity) == "expired") {
                    $cert_style = "color: red;";
                } else if (strtolower($cert_validity) == "valid") {
                    $cert_style = "color: green;";
                } else if (strtolower($cert_validity) == "near/expired") {
                    $cert_style = "color: orange;";
                }

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['crew_code']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['vsl_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['position_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['full_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$date_available}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$bmi}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$passport_style}\">{$passport_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$passport_style}\">{$passport_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$licenses_style}\">{$licenses_validity}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px; {$cert_style}\">{$cert_validity}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:7px;\" align=\"center\" colspan=\"8\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('pre_joining_visa_crews.pdf', 'I');
    }


    public function print_crew_monitoring_contracts()
    {

        $conditions = [];


        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');


        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('CREW MONITORING - CONTRACTS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "CONTRACTS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);


        $contracts_crews = $this->contracts->getContractCrew($conditions);

        $count_contracts_crews = count($contracts_crews);

        $nobr = $count_contracts_crews >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CREW CODE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ADDRESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVED POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>VESSEL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>POEA CONTRACT DURATION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MLC CONTRACT DURATION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MLC TYPE</b></th>
                    </tr>";
        if ($contracts_crews) {
            foreach ($contracts_crews as $row) {

                $date_available = $row['date_available'] ? date("Y-m-d", strtotime($row['date_available'])) : "-";
                $status = $this->global->getCrewStatusForReport($row['status']);
                $address = $row['province_name'] . '' . $row['city_name'];
                $position_name = $row['position_name'] != NULL ? $row['position_name'] : "-";
                $vsl_name = $row['vsl_name'] != NULL ? $row['vsl_name'] : "-";

                $passport_validity = $this->crew_management->validate_passport_report($row['crew_code']);
                $passport_style = "";
                if (strtolower($passport_validity) == "expired") {
                    $passport_style = "color: red;";
                } else if (strtolower($passport_validity) == "valid") {
                    $passport_style = "color: green;";
                }

                $contract = $this->contracts->getCrewContract($row['crew_code']);
                $contract_contract_duration = "N/A";
                if (!empty($contract)) {
                    $new_contract = $contract[0];
                    $contract_contract_duration = $new_contract["contract_duration"];
                }

                $mlc = $this->contracts->getCrewMlcById($row['crew_code']);
                if (!empty($mlc)) {
                    $new_mlc = $mlc[0];
                    if ($new_mlc['mlc_type'] === 1) {
                        $mlc_type = "KOREAN FLAG";
                    } else if ($new_mlc['mlc_type'] === 2) {
                        $mlc_type = "PANAMA FLAG";
                    } else {
                        $mlc_type = "MARSHALL FLAG";
                    }
                    $mlc_duration = date('Y-m-d', strtotime($new_mlc['date_created']));
                }


                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['crew_code']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['full_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$status}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$address}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$position_name}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$vsl_name}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$contract_contract_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$mlc_duration}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$mlc_type}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"9\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }
        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('crew_contracts.pdf', 'I');
    }


    public function print_medical_crews()
    {
        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');
        $arr_search['search']['contract_search'] = $this->session->userdata('contract_search');
        $arr_search['search']['flight_search'] = $this->session->userdata('flight_search');
        $arr_search['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $arr_search['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $medical_crews = $this->medical->getMedicalReportGeneral($arr_search);
        $count_medical_crews = count($medical_crews);
        $nobr = $count_medical_crews >= 7 ? "true" : "";


        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('CREW MEDICAL SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "CREW MEDICAL SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>RANK</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>LAST VESSEL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ASSIGNED VESSEL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CLINIC</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE OF MEDICAL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE OF FITNESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>BMI</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>WL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>MEDICAL RESULT</b></th>
                    </tr>";

        if ($medical_crews) {
            $count = 1;
            foreach ($medical_crews as $row) {
                $last_vessel = $this->m_crew_arc->get_last_vessel($row['monitor_code']);
                $lst_vsl = $last_vessel ? $last_vessel['last_vessel'] : "-";
                $medical_exm_date = date('F j, Y', strtotime($row['date_med_exam']));

                $position_name = $row['position_name'] ? $row['position_name'] : "-";

                $medical_date = strtotime($row['date_medical_fit']);
                $onboard_date = strtotime($row['embark_date']);

                $diff =  $onboard_date - $medical_date;
                $date_diff = round($diff / (60 * 60 * 24));

                $status = "";
                if ($row['medical_status'] === "2") {
                    $status = "FIT FOR SEA DUTY";
                } else if ($row['medical_status'] === "1") {
                    $status = "PENDING";
                } else if ($row['medical_status'] === "3") {
                    $status = "W/APPROVAL";
                } else {
                    $status = "REJECTED";
                }

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$count}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$position_name}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['full_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$lst_vsl}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$row['vsl_name']}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\"> - </td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\">{$medical_exm_date}</td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\"> - </td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\"> {$row['medical_bmi']} </td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\"> {$row['remarks']} </td>";
                $html .= "<td align=\"center\" style=\"font-weight: normal; font-size:7px;\"> {$status} </td>";
                $html .= "</tr>";

                $count++;
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"11\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }


        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('crew_medical.pdf', 'I');
    }

    // CREW MONITORING - END

    // FLIGHT MONITORING - START

    public function print_flight_monitoring()
    {
        $flights = $this->global->getAllFlights();

        $count_flights = count($flights);
        $nobr = $count_flights >= 7 ? "true" : "";


        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('FLIGHT MONITORING SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "FLIGHT MONITORING SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>VESSEL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FLIGHT NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DEPARTURE COUNTRY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DEPARTURE DATE/TIME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DESTINATION COUNTRY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DESTINATION DATE/TIME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>AIRFARE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>AIRLINES</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>OPTION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NO. OF CREW ASSIGNED</b></th>
                    </tr>";

        if ($flights) {
            $count = 1;
            foreach ($flights as $row) {

                $vsl_name = !$row['vessel_id'] ? "-" : $this->global->getVesselById($row['vessel_id'])['vsl_name'];
                $flight_number = !$row['flight_number'] ? "-" : $row['flight_number'];
                $departure_country = !$row['departure_country'] ? "-" : $row['departure_country'];
                $departure_datetime = !$row['departure_datetime'] ? "-" : date('M j, Y h:m A', strtotime($row['departure_datetime']));
                $destination_country = !$row['destination_country'] ? "-" : $row['destination_country'];
                $destination_datetime = !$row['destination_datetime'] ? "-" : date('M j, Y h:m A', strtotime($row['destination_datetime']));
                $airfare = !$row['airfare'] ? "-" : $row['airfare'];
                $airline = !$row['airline'] ? "-" : $row['airline'];
                $option = !$row['option'] ? "-" : date('M j, Y h:m A', strtotime($row['option']));

                $count_crew = count($this->all_crew->NoOfCrewAssigned($row['flight_code']));
                $total_crew_assigned = !$count_crew ? $count_crew : $count_crew;

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$count}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$vsl_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$flight_number}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$departure_country}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$departure_datetime}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$destination_country}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$destination_datetime}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$airfare}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$airline}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$option}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$total_crew_assigned}</td>";
                $html .= "</tr>";

                $count++;
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"11\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('flight_monitoring.pdf', 'I');
    }

    // FLIGHT MONITORING - END

    // FOR ONBOARDING - START


    public function print_for_onboarding()
    {

        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('FOR ONBOARDING SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "FOR ONBOARDING SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);


        $for_onboarding_crews = $this->onboarding->getOnboardingCrew($conditions);
        $count_for_onboarding_crews = count($for_onboarding_crews);
        $nobr = $count_for_onboarding_crews >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CREW CODE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ADDRESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>VESSEL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ONBOARDING DATE</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FLIGHT CODE</b></th>
                    </tr>";


        if ($for_onboarding_crews) {
            foreach ($for_onboarding_crews as $row) {

                $status = $this->global->getCrewStatusForReport($row['status']);
                $address = $row['province_name'] . ' ' . $row['city_name'];
                $position_name = $row['position_name'] != NULL ? $row['position_name'] : "-";
                $vsl_name = $row['vsl_name'] != NULL ? $row['vsl_name'] : "-";
                $embark_date = $row['embark_date'] != NULL ? $row['embark_date'] : "-";
                $flight_code = $row['flight_code'] != NULL ? $row['flight_code'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$row['crew_code']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$row['full_name']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$status}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$address}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$position_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$vsl_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$embark_date}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$flight_code}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"7\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('onboarding.pdf', 'I');
    }

    // FOR ONBOARDING - END

    // EMBARKED - START

    public function print_embarked_crews()
    {
        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $crews_embarked = $this->embark->getCrewEmbarked($conditions);
        $count_crews_embarked = count($crews_embarked);
        $nobr = $count_crews_embarked >= 7 ? "true" : "";


        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('EMBARKED CREWS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "EMBARKED CREWS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CREW ID</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVED POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>VESSEL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>OFFSIGNER</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>EMBARK DATE</b></th>
                    </tr>";
        if ($crews_embarked) {
            foreach ($crews_embarked as $row) {

                $status = $this->global->getCrewStatusForReport($row['status']);
                $crew = $this->global->getCrew($row['offsigner']);
                $offsigner_name = $crew['crew_code'] != NULL ? $this->global->GetCrewFullName($crew['crew_code'])->full_name : "-";

                $address = $row['province_name'] . ', ' . $row['city_name'];
                $position_name = $row['position_name'] != NULL ? $row['position_name'] : "-";
                $vsl_name = $row['vsl_name'] != NULL ? $row['vsl_name'] : "-";
                $embark = $row['embark'] != NULL ? $row['embark'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$row['crew_code']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$row['full_name']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$status}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$address}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$position_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$vsl_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$offsigner_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$embark}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"7\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('embarked_crews.pdf', 'I');
    }

    // EMBARKED - END

    // DISEMBARKED - START


    public function print_disembarked_crews()
    {
        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('EMBARKED CREWS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "EMBARKED CREWS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');
        $arr_search['search']['contract_search'] = $this->session->userdata('contract_search');
        $arr_search['search']['flight_search'] = $this->session->userdata('flight_search');
        $arr_search['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $arr_search['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $crews_disembark = $this->disembark->getCrewDisembark($arr_search);
        $count_crews_disembark = count($crews_disembark);
        $nobr = $count_crews_disembark >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"5\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>CREW ID</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ADDRESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVED POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>VESSEL</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>INSIGNER</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DISEMBARK DATE</b></th>
                    </tr>";

        if ($crews_disembark) {
            foreach ($crews_disembark as $row) {

                $status = $this->global->getCrewStatusForReport($row['status']);

                $insigner_name = "-";
                $crew = $this->global->getCrew($row['insigner']);
                if ($crew) {
                    $insigner_name = $crew['crew_code'] != NULL ? $this->global->GetCrewFullName($crew['crew_code'])->full_name : "-";
                }

                $address = $row['province_name'] . ', ' . $row['city_name'];
                $position_name = $row['position_name'] != NULL ? $row['position_name'] : "-";
                $vsl_name = $row['vsl_name'] != NULL ? $row['vsl_name'] : "-";
                $disembark = $row['disembark'] != NULL ? $row['disembark'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$row['crew_code']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$row['full_name']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$status}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$address}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$position_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$vsl_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$insigner_name}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px\" align=\"center\">{$disembark}</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:9px;\" align=\"center\" colspan=\"7\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('disembarked_crews.pdf', 'I');
    }

    // DISEMBARKED - END
}
