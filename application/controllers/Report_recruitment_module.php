<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_recruitment_module extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->load->library('pdf');
    }

    // REGISTERED APPLICANTS - START
    public function print_registered_applicants()
    {

        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('name_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('REGISTERED APPLICANTS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "REGISTERED APPLICANTS SUMMARY", $XBORDER, 1, 0, true, 'C', true);


        $pdf->ln(5);

        $registered_applicants = $this->applicant_registered->getApplicantRegistered($conditions);
        $count_registered_applicants = count($registered_applicants);

        $nobr = $count_registered_applicants >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"4\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICANT ID</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ADDRESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FIRST POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>SECOND POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVED POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>BMI</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICATION STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ASSESSED BY</b></th>
                    </tr>";
        if ($registered_applicants) {
            $count = 1;
            foreach ($registered_applicants as $row) {

                $address = $row['province_name'] . ', ' . $row['city_name'];
                $position1 = $row['position_name1'] ? $row['position_name1'] : "-";
                $position2 = $row['position_name2'] ? $row['position_name2'] : "-";
                $bmi = round($row['weight'] / $row['height'] / $row['height'] * 10000, 2);
                $date_available = $row['date_available'] ? date('F j, Y', strtotime($row['date_available'])) : "-";
                $status = $this->global->getApplicantStatusForReports($row['status']);
                $assesor = $row['f_assessor_name'] ? $row['f_assessor_name'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$count}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['applicant_code']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['full_name']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$address}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position1}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position2}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">N/A</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$bmi}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$date_available}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$status}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$assesor}</td>";
                $html .= "</tr>";

                $count++;
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:7px;\" align=\"center\" colspan=\"11\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('registered_applicants.pdf', 'I');
    }
    // REGISTERED APPLICANTS - END


    // PENDING APPLICANTS - START
    public function print_pending_applicants()
    {

        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('name_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('PENDING APPLICANTS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "PENDING APPLICANTS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $pending_applicants = $this->applicant_pending->getApplicantPending($conditions);
        $count_pending_applicants = count($pending_applicants);

        $nobr = $count_pending_applicants >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"4\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICANT ID</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ADDRESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FIRST POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>SECOND POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVED POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>BMI</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAT RESULT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICATION STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ASSESSED BY</b></th>
                    </tr>";

        if ($pending_applicants) {
            $count = 1;
            foreach ($pending_applicants as $row) {

                $address = $row['province'] . ', ' . $row['city'];
                $position1 = $row['position_name1'] ? $row['position_name1'] : "-";
                $position2 = $row['position_name2'] ? $row['position_name2'] : "-";
                $bmi = round($row['weight'] / $row['height'] / $row['height'] * 10000, 2);
                $date_available = $row['date_available'] ? date('F j, Y', strtotime($row['date_available'])) : "-";
                $nat_result = $row['nat_result'] ?  $row['nat_result'] . "%" : "-";
                $status = $this->global->getApplicantStatusForReports($row['status']);
                $assesor = $row['f_assessor_name'] ? $row['f_assessor_name'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$count}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['applicant_code']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['full_name']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$address}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position1}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position2}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">N/A</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$bmi}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$date_available}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$nat_result}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$status}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$assesor}</td>";
                $html .= "</tr>";

                $count++;
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:7px;\" align=\"center\" colspan=\"12\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";


        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('pending_applicants.pdf', 'I');
    }
    // PENDING APPLICANTS - END


    // FOR INTERVIEW APPLICANTS - START
    public function print_for_interview_applicants()
    {

        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('name_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('FOR INTERVIEW APPLICANTS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "FOR INTERVIEW APPLICANTS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);


        $interview_applicants = $this->applicant_interview->getApplicantInterview($conditions);
        $count_interview_applicants = count($interview_applicants);
        $nobr = $count_interview_applicants >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"4\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICANT ID</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ADDRESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FIRST POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>SECOND POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVED POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>BMI</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICATION STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ASSESSED BY</b></th>
                    </tr>";

        if ($interview_applicants) {
            $count = 1;
            foreach ($interview_applicants as $row) {

                $address = $row['province'] . ', ' . $row['city'];
                $position1 = $row['position_name1'] ? $row['position_name1'] : "-";
                $position2 = $row['position_name2'] ? $row['position_name2'] : "-";
                $bmi = round($row['weight'] / $row['height'] / $row['height'] * 10000, 2);
                $date_available = $row['date_available'] ? date('F j, Y', strtotime($row['date_available'])) : "-";
                $status = $this->global->getApplicantStatusForReports($row['status']);
                $assesor = $row['f_assessor_name'] ? $row['f_assessor_name'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$count}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['applicant_code']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['full_name']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$address}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position1}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position2}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">N/A</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$bmi}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$date_available}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$status}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$assesor}</td>";
                $html .= "</tr>";

                $count++;
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:7px;\" align=\"center\" colspan=\"11\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->ln(5);

        $pdf->Output('for_interview_applicants.pdf', 'I');
    }
    // FOR INTERVIEW APPLICANTS - END


    // PRINCIPAL APPROVAL APPLICANTS - START
    public function print_principal_approval_applicants()
    {

        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('name_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('PRINCIPAL APPROVAL APPLICANTS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "PRINCIPAL APPROVAL APPLICANTS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $applicant_approvals = $this->applicant_approval->getApplicantApproval($conditions);
        $count_applicant_approvals = count($applicant_approvals);
        $nobr = $count_applicant_approvals >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"4\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICANT ID</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ADDRESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FIRST POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>SECOND POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVED POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>BMI</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAT RESULT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICATION STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ASSESSED BY</b></th>
                    </tr>";

        if ($applicant_approvals) {
            $count = 1;
            foreach ($applicant_approvals as $row) {

                $address = $row['province_name'] . ', ' . $row['city_name'];
                $position1 = $row['position_name1'] ? $row['position_name1'] : "-";
                $position2 = $row['position_name2'] ? $row['position_name2'] : "-";
                $approved_position = $row['approved_position_name'] ? $row['approved_position_name'] : "-";
                $bmi = round($row['weight'] / $row['height'] / $row['height'] * 10000, 2);
                $date_available = $row['date_available'] ? date('F j, Y', strtotime($row['date_available'])) : "-";
                $nat_result = $row['nat_result'] ?  $row['nat_result'] . "%" : "-";
                $status = $this->global->getApplicantStatusForReports($row['status']);
                $assesor = $row['f_assessor_name'] ? $row['f_assessor_name'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$count}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['applicant_code']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['full_name']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$address}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position1}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position2}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$approved_position}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$bmi}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$date_available}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$nat_result}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$status}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$assesor}</td>";
                $html .= "</tr>";

                $count++;
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:7px;\" align=\"center\" colspan=\"12\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";


        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Output('principal_approval_applicants.pdf', 'I');
    }
    // PRINCIPAL APPROVAL APPLICANTS - END


    // PASSED APPLICANTS - START
    public function print_passed_applicants()
    {

        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('name_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');


        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('PASSED APPLICANTS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "PASSED APPLICANTS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $passed_applicants = $this->applicant_passed->getApplicantPassed($conditions);
        $count_passed_applicants = count($passed_applicants);
        $nobr = $count_passed_applicants >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"4\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICANT ID</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ADDRESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVED POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>BMI</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAT RESULT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICATION STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ASSESSED BY</b></th>
                    </tr>";


        if ($passed_applicants) {
            $count = 1;
            foreach ($passed_applicants as $row) {

                $address = $row['province_name'] . ', ' . $row['city_name'];
                $approved_position = $row['approved_position_name'] ? $row['approved_position_name'] : "-";
                $bmi = round($row['weight'] / $row['height'] / $row['height'] * 10000, 2);
                $date_available = $row['date_available'] ? date('F j, Y', strtotime($row['date_available'])) : "-";
                $nat_result = $row['nat_result'] ?  $row['nat_result'] . "%" : "-";
                $status = $this->global->getApplicantStatusForReports($row['status']);
                $assesor = $row['f_assessor_name'] ? $row['f_assessor_name'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$count}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['applicant_code']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['full_name']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$address}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$approved_position}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$bmi}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$date_available}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$nat_result}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$status}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$assesor}</td>";
                $html .= "</tr>";

                $count++;
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:7px;\" align=\"center\" colspan=\"10\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }


        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('passed_applicants.pdf', 'I');
    }
    // PASSED APPLICANTS - END


    // NOT QUALIFIED APPLICANTS - START
    public function print_not_qualified_applicants()
    {

        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('name_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');
        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('NOT QUALIFIED SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "NOT QUALIFIED SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $failed_applicants = $this->applicant_failed->getApplicantFailed($conditions);
        $count_failed_applicants = count($failed_applicants);
        $nobr = $count_failed_applicants >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"4\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICANT ID</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ADDRESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FIRST POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>SECOND POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVED POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>BMI</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAT RESULT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICATION STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ASSESSED BY</b></th>
                    </tr>";

        if ($failed_applicants) {
            $count = 1;
            foreach ($failed_applicants as $row) {

                $address = $row['province_name'] . ', ' . $row['city_name'];
                $position1 = $row['position_name1'] ? $row['position_name1'] : "-";
                $position2 = $row['position_name2'] ? $row['position_name2'] : "-";
                $approved_position = $row['approved_position_name'] ? $row['approved_position_name'] : "-";
                $bmi = round($row['weight'] / $row['height'] / $row['height'] * 10000, 2);
                $date_available = $row['date_available'] ? date('F j, Y', strtotime($row['date_available'])) : "-";
                $nat_result = $row['nat_result'] ?  $row['nat_result'] . "%" : "-";
                $status = $this->global->getApplicantStatusForReports($row['status']);
                $assesor = $row['f_assessor_name'] ? $row['f_assessor_name'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$count}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['applicant_code']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['full_name']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$address}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position1}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position2}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$approved_position}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$bmi}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$date_available}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$nat_result}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$status}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$assesor}</td>";
                $html .= "</tr>";

                $count++;
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:7px;\" align=\"center\" colspan=\"12\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('not_qualified_applicants.pdf', 'I');
    }
    // NOT QUALIFIED APPLICANTS - END


    // RESERVED APPLICANTS - START
    public function print_reserved_applicants()
    {
        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('name_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $pdf = new CUSTOMPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
        $pdf->SetTitle('RESERVED APPLICANTS SUMMARY');

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 25;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "RESERVED APPLICANTS SUMMARY", $XBORDER, 1, 0, true, 'C', true);

        $pdf->ln(5);

        $reserved_applicants = $this->applicant_reserved->getApplicantReserved($conditions);
        $count_reserved_applicants = count($reserved_applicants);
        $nobr = $count_reserved_applicants >= 7 ? "true" : "";

        $html = "<table border=\"1\" cellpadding=\"4\">
                    <tr>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NO.</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICANT ID</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FULL NAME</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ADDRESS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>FIRST POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>SECOND POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPROVED POSITION</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>BMI</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>DATE AVAILABILITY</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>NAT RESULT</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>APPLICATION STATUS</b></th>
                        <th style=\"font-size:8px;\" align=\"center\"><b>ASSESSED BY</b></th>
                    </tr>";

        if ($reserved_applicants) {
            $count = 1;
            foreach ($reserved_applicants as $row) {

                $address = $row['province_name'] . ', ' . $row['city_name'];
                $position1 = $row['position_name1'] ? $row['position_name1'] : "-";
                $position2 = $row['position_name2'] ? $row['position_name2'] : "-";
                $approved_position = $row['approved_position_name'] ? $row['approved_position_name'] : "-";
                $bmi = round($row['weight'] / $row['height'] / $row['height'] * 10000, 2);
                $date_available = $row['date_available'] ? date('F j, Y', strtotime($row['date_available'])) : "-";
                $nat_result = $row['nat_result'] ?  $row['nat_result'] . "%" : "-";
                $status = $this->global->getApplicantStatusForReports($row['status']);
                $assesor = $row['f_assessor_name'] ? $row['f_assessor_name'] : "-";

                $html .= "<tr nobr=\"{$nobr}\">";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$count}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['applicant_code']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$row['full_name']}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$address}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position1}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$position2}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$approved_position}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$bmi}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$date_available}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$nat_result}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$status}</td>";
                $html .= "<td style=\"font-weight: normal; font-size:7px;\" align=\"center\">{$assesor}</td>";
                $html .= "</tr>";

                $count++;
            }
        } else {
            $html .= "<tr>";
            $html .= "<td style=\"font-size:7px;\" align=\"center\" colspan=\"12\"><i>NO DATA AVAILABLE.</i></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('reserved_applicants.pdf', 'I');
    }
    // RESERVED APPLICANTS - END
}
