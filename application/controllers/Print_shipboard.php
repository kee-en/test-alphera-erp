<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Print_shipboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->load->library('pdf');
    }

    public function print_shipboard_application2($applicant_code)
    {

        $applicant_data = $this->applicant_registered->getApplicantPersonalData($applicant_code);

        $first_position = !empty($applicant_data['position_first']) ?  $this->global->getPositionById($applicant_data['position_first'])['position_name'] : "-";
        $second_position = !empty($applicant_data['position_second']) ? $this->global->getPositionById($applicant_data['position_second'])['position_name'] : "-";

        $city_address = trim($applicant_data['street_address'] . " " . $applicant_data['barangay'] . " " . $applicant_data['cty']);

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage();

        $XTOP = $pdf->getY() + 28;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));


        // SHIPBOARD EMPLOYMENT APPLICATION
        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "SHIPBOARD EMPLOYEMENT APPLICATION", $XBORDER, 1, 0, true, 'C', true);

        // set JPEG quality
        $pdf->setJPEGQuality(75);

        $applicant_photo = $this->applicant_registered->getApplicantPhoto($this->global->ecdc('ec', $applicant_code));
        $pdf->Image($applicant_photo, $XLEFT + 210, $XTOP - 30, 70, 70, '', '', 'T', false, 300, '', false, false, 1, false, false, false);

        $XTOP += 10;

        $pdf->SetFont("helvetica", "", 10);

        // POSITION
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "POSITION APPLIED: ", $XBORDER, 1, 0, true, 'L', true);

        // FIRST POSITION
        $pdf->writeHTMLCell(0, 0, $XLEFT - 140, $XTOP, strtoupper($first_position), $XBORDER, 1, 0, true, 'C', true);
        $pdf->Line($XLEFT + 100, $XTOP + 5, $XLEFT + 37, $XTOP + 5, $style);
        $pdf->writeHTMLCell(0, 0, $XLEFT - 140, $XTOP + 6, "(1ST CHOICE)", $XBORDER, 1, 0, true, 'C', true);

        // SECOND POSITION
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, strtoupper($second_position), $XBORDER, 1, 0, true, 'C', true);
        $pdf->Line($XLEFT + 170, $XTOP + 5, $XLEFT + 107, $XTOP + 5, $style);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP + 6, "(2ND CHOICE)", $XBORDER, 1, 0, true, 'C', true);


        // DATE APPLIED
        $XTOP = $XTOP + 15;
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "DATE APPLIED: ", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(0, 0, $XLEFT - 140, $XTOP, $applicant_data["date_created"] ? date('F d, Y', strtotime($applicant_data["date_created"])) : "-", $XBORDER, 1, 0, true, 'C', true);
        $pdf->Line($XLEFT + 100, $XTOP + 5, $XLEFT + 37, $XTOP + 5, $style);

        // DATE AVAILABLE
        $pdf->writeHTMLCell(0, 0, $XLEFT + 105, $XTOP, "DATE AVAILABLE: ", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(0, 0, $XLEFT + 32, $XTOP, $applicant_data["date_available"] ? date('F d, Y', strtotime($applicant_data["date_available"])) : "-", $XBORDER, 1, 0, true, 'C', true);
        $pdf->Line($XLEFT + 170, $XTOP + 5, $XLEFT + 138, $XTOP + 5, $style);

        $XTOP = $XTOP + 10;

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "I. PERSONAL INFORMATION", $XBORDER, 1, 0, true, 'L', true);

        $XTOP += 7;

        $pdf->SetFont("helvetica", "", 10);

        // // NAME
        $pdf->writeHTMLCell(20, 0, $XLEFT, $XTOP, "NAME", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(150, 0, $XLEFT + 20, $XTOP, "", $XBORDER + 1, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(150, 0, $XLEFT + 25, $XTOP, $applicant_data["last_name"] ? $applicant_data["last_name"] : "-", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(150, 0, $XLEFT + 75, $XTOP, $applicant_data["first_name"] ? $applicant_data["first_name"] : "-", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(150, 0, $XLEFT + 135, $XTOP, $applicant_data["middle_name"] ? $applicant_data["middle_name"] : "-", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(150, 0, $XLEFT + 25, $XTOP + 5, "(LAST NAME)", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(150, 0, $XLEFT + 75, $XTOP + 5, "(FIRST NAME)", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(150, 0, $XLEFT + 135, $XTOP + 5, "(MIDDLE NAME)", $XBORDER, 1, 0, true, 'L', true);

        // BIRTHDATE & BIRTHPLACE
        $pdf->writeHTMLCell(25, 0, $XLEFT + 170, $XTOP, "BIRTH DATE", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(85, 0, $XLEFT + 195, $XTOP, $applicant_data["birth_date"] ? date('F d, Y', strtotime($applicant_data["birth_date"])) : "-", $XBORDER + 1, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(30, 0, $XLEFT + 170, $XTOP + 5, "BIRTH PLACE", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(80, 0, $XLEFT + 200, $XTOP + 5, $applicant_data["birth_place"] ? $applicant_data["birth_place"] : "-", $XBORDER + 1, 1, 0, true, 'L', true);

        $XTOP += 10;

        // EMAIL ADDRESS
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "EMAIL ADDRESS: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(50, 0, $XLEFT + 35, $XTOP, "", $XBORDER + 1, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(50, 0, $XLEFT + 35, $XTOP, $applicant_data["email_address"] ? $applicant_data["email_address"] : "-", $XBORDER, 1, 0, true, 'C', true);

        //SSS
        $pdf->writeHTMLCell(20, 0, $XLEFT + 85, $XTOP, "SSS NO.", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(45, 0, $XLEFT + 105, $XTOP, $applicant_data["sss_no"] ? $applicant_data["sss_no"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        //AGE
        $pdf->writeHTMLCell(20, 0, $XLEFT + 150, $XTOP, "AGE", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(30, 0, $XLEFT + 170, $XTOP, $applicant_data["birth_date"] ? $this->global->getAge($applicant_data["birth_date"]) : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // STATUS
        $pdf->writeHTMLCell(20, 0, $XLEFT + 200, $XTOP, "STATUS: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 220, $XTOP, $applicant_data['civil_status'] ? $this->global->getCivilStatus($applicant_data['civil_status'])['description'] : "-", $XBORDER + 1, 1, 0, true, 'C', true);


        $XTOP += 5;
        // CITY ADDRESS
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "CITY ADDRESS: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(135, 0, $XLEFT + 35, $XTOP, $applicant_data['next_kin_address'], $XBORDER + 1, 1, 0, true, 'C', true);

        // TEL NO.
        $pdf->writeHTMLCell(25, 0, $XLEFT + 170, $XTOP, "TEL NO: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(85, 0, $XLEFT + 195, $XTOP, $applicant_data["telephone_number"] ? $applicant_data["telephone_number"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // PROVINCIAL
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "PROVINCIAL: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(135, 0, $XLEFT + 35, $XTOP, $applicant_data["prvince"] ? $applicant_data["prvince"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // CEL NO.
        $pdf->writeHTMLCell(25, 0, $XLEFT + 170, $XTOP, "MOBILE NO:", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(85, 0, $XLEFT + 195, $XTOP, $applicant_data["mobile_number"] ? $applicant_data["mobile_number"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // RELIGION
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "RELIGION: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(80, 0, $XLEFT + 35, $XTOP, $applicant_data['religion'] ? $this->global->getReligion($applicant_data['religion'])['description'] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // HEIGHT
        $pdf->SetFont("helvetica", "", 10);
        $pdf->writeHTMLCell(35, 0, $XLEFT + 115, $XTOP, "HEIGHT: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(25, 0, $XLEFT + 150, $XTOP, $applicant_data["height"] ? $applicant_data["height"] . "cm" : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // WEIGHT
        $pdf->writeHTMLCell(35, 0, $XLEFT + 175, $XTOP, "WEIGHT: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(15, 0, $XLEFT + 210, $XTOP, $applicant_data["weight"] ? $applicant_data["weight"] . "kg" : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // BMI
        $pdf->writeHTMLCell(35, 0, $XLEFT + 225, $XTOP, "BMI: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(20, 0, $XLEFT + 260, $XTOP, $applicant_data['height'] && $applicant_data['weight'] ? $this->global->getBMI($applicant_data['height'], $applicant_data['weight']) : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // PHILHEALTH
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "PHILHEALTH NO: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 35, $XTOP, $applicant_data["philhealth_no"] ? $applicant_data["philhealth_no"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // PAGIBIG
        $pdf->writeHTMLCell(35, 0, $XLEFT + 95, $XTOP, "PAG-IBIG NO: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 130, $XTOP, $applicant_data["pag_ibig_no"] ? $applicant_data["pag_ibig_no"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // TIN NO
        $pdf->writeHTMLCell(35, 0, $XLEFT + 190, $XTOP, "TIN NO: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(55, 0, $XLEFT + 225, $XTOP, $applicant_data["tin_number"] ? $applicant_data["tin_number"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(280, 0, $XLEFT, $XTOP, "NEXT OF KIN: ", $XBORDER, 1, 0, true, 'l', true);

        $pdf->SetFont("helvetica", "", 10);

        $XTOP += 5;

        // SPOUSE NAME
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "SPOUSE NAME: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 35, $XTOP, $applicant_data["spouse_name"] ? $applicant_data["spouse_name"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // FATHER'S NAME
        $pdf->writeHTMLCell(35, 0, $XLEFT + 140, $XTOP, "FATHER'S NAME: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 175, $XTOP, $applicant_data["father_name"] ? $applicant_data["father_name"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // OCCUPATION
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "OCCUPATION: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 35, $XTOP, $applicant_data["occupation"] ? $applicant_data["occupation"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // MOTHER'S NAME
        $pdf->writeHTMLCell(35, 0, $XLEFT + 140, $XTOP, "MOTHER'S NAME: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 175, $XTOP, $applicant_data["mother_name"] ? $applicant_data["mother_name"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // NO OF CHILDREN
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "NO OF CHILDREN: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 35, $XTOP, $applicant_data["no_of_children"] ? $applicant_data["no_of_children"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // ADDRESS
        $pdf->writeHTMLCell(35, 0, $XLEFT + 140, $XTOP, "ADDRESS: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 175, $XTOP, $applicant_data["next_kin_address"] ? $applicant_data["next_kin_address"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        $pdf->SetFont("helvetica", "B", 11);
        $pdf->writeHTMLCell(140, 0, $XLEFT, $XTOP, "EDUCATIONAL ATTAINMENT: ", $XBORDER, 1, 0, true, 'l', true);
        $pdf->writeHTMLCell(70, 0, $XLEFT + 140, $XTOP, "WORKING GEARS", $XBORDER, 1, 0, true, 'l', true);
        $pdf->SetFont("helvetica", "B", 9);
        $pdf->writeHTMLCell(205, 0, $XLEFT + 175, $XTOP + 1, "(SPECIFY SIZES IF S/M/L/Xl/XXL...)", $XBORDER, 1, 0, true, 'l', true);

        $pdf->SetFont("helvetica", "", 10);


        $XTOP += 5;

        // COURSE
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "COURSE: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 35, $XTOP, $applicant_data["course"] ? $applicant_data["course"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // COVER ALL
        $pdf->writeHTMLCell(35, 0, $XLEFT + 140, $XTOP, "COVER ALL: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 175, $XTOP, $applicant_data["cover_all"] ? $applicant_data["cover_all"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // SCHOOL
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "SCHOOL: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 35, $XTOP, $applicant_data["school"] ? $applicant_data["school"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // WINTER JACKET
        $pdf->writeHTMLCell(35, 0, $XLEFT + 140, $XTOP, "WINTER JACKET: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 175, $XTOP, $applicant_data["winter_jacket"] ? $applicant_data["winter_jacket"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);


        $XTOP += 5;

        // SCHOOL ADDRESS
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "SCHOOL ADD: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 35, $XTOP, $applicant_data["school_address"] ? $applicant_data["school_address"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // SHOES
        $pdf->writeHTMLCell(35, 0, $XLEFT + 140, $XTOP, "SHOES (IN CMS): ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 175, $XTOP, $applicant_data["shoes"] ? $applicant_data["shoes"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;
        $pdf->writeHTMLCell(50, 0, $XLEFT + 70, $XTOP, "(CITY & PROVINCE)", $XBORDER, 1, 0, true, 'L', true);

        // WINTER BOOTS
        $pdf->writeHTMLCell(50, 0, $XLEFT + 140, $XTOP, "WINTER BOOTS(CMS):", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(90, 0, $XLEFT + 190, $XTOP, $applicant_data["winter_boots"] ? $applicant_data["winter_boots"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // INCLUSIVE YEARS
        $inclusive_years = json_decode($applicant_data["inclusive_years"]);

        $pdf->writeHTMLCell(40, 0, $XLEFT, $XTOP, "INCLUSIVE YEARS:", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(100, 0, $XLEFT + 40, $XTOP, $applicant_data["inclusive_years"] ? date('Y-m-d', strtotime($inclusive_years[0])) . " - " . date('Y-m-d', strtotime($inclusive_years[1])) : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $pdf->writeHTMLCell(35, 0, $XLEFT + 140, $XTOP, "", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(105, 0, $XLEFT + 175, $XTOP, "", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;
        $pdf->writeHTMLCell(50, 0, $XLEFT + 70, $XTOP, "(YY/MM/DD - YY/MM/DD)", $XBORDER, 1, 0, true, 'L', true);


        // LICENSES
        $XTOP += 10;
        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "II. LICENSES / ENDORSEMENT / BOOK / ID", $XBORDER, 1, 0, true, 'L', true);

        $XTOP += 5;
        $pdf->SetFont("helvetica", "B", 10);

        // LICENSES HEADER
        $pdf->writeHTMLCell(150, 0, $XLEFT, $XTOP, "LICENSES", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(30, 0, $XLEFT + 150, $XTOP, "GRADE", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(30, 0, $XLEFT + 180, $XTOP, "NUMBER", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(40, 0, $XLEFT + 210, $XTOP, "DATE ISSUED", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(30, 0, $XLEFT + 250, $XTOP, "EXPIRY DATE", $XBORDER + 1, 1, 0, true, 'C', true);

        $licenses = $this->global->getListLicenses($applicant_code);

        if ($licenses) {
            $license_name = json_decode($licenses['lebi']);
            $grade = json_decode($licenses['grade']);
            $number = json_decode($licenses['number']);
            $date_issued = json_decode($licenses['date_issued']);
            $expiry_date = json_decode($licenses['expiry_date']);
            $pdf->SetFont("helvetica", "", 10);

            for ($i = 0; $i < count($license_name); $i++) {
                $XTOP += 5;
                $licenseName = $this->global->getLicenseById($license_name[$i])['license_name'];
                $pdf->writeHTMLCell(150, 0, $XLEFT, $XTOP, $this->global->textEllipsis($licenseName, 35), $XBORDER + 1, 1, 0, true, 'L', true);
                $pdf->writeHTMLCell(30, 0, $XLEFT + 150, $XTOP, (!$grade[$i] ? ' - ' : $grade[$i]), $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(30, 0, $XLEFT + 180, $XTOP, (!$number[$i] ? ' - ' : $number[$i]), $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(40, 0, $XLEFT + 210, $XTOP, (!$date_issued[$i] ? ' - ' : date('M j, Y', strtotime($date_issued[$i]))), $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(30, 0, $XLEFT + 250, $XTOP, (!$expiry_date[$i] ? ' - ' : date('M j, Y', strtotime($expiry_date[$i]))), $XBORDER + 1, 1, 0, true, 'C', true);



                if ($XTOP > 380) {
                    $pdf->AddPage();
                    $XTOP = 38;
                    $pdf->SetFont("helvetica", "B", 10);
                    $pdf->writeHTMLCell(150, 0, $XLEFT, $XTOP, "LICENSES", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(30, 0, $XLEFT + 150, $XTOP, "GRADE", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(30, 0, $XLEFT + 180, $XTOP, "NUMBER", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(40, 0, $XLEFT + 210, $XTOP, "DATE ISSUED", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(30, 0, $XLEFT + 250, $XTOP, "EXPIRY DATE", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->SetFont("helvetica", "", 10);
                }
            }
        }

        // CERTIFICATES
        $XTOP += 10;
        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "III. TRAINING AND CERTIFICATES", $XBORDER, 1, 0, true, 'L', true);

        $XTOP += 5;
        $certificates = $this->global->getListCertificates($applicant_code);

        // CERTIFICATES HEADER

        $pdf->SetFont("helvetica", "B", 10);
        $pdf->writeHTMLCell(150, 0, $XLEFT, $XTOP, "CERTIFICATES", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(30, 0, $XLEFT + 150, $XTOP, "NUMBER", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(30, 0, $XLEFT + 180, $XTOP, "DATE ISSUED", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(40, 0, $XLEFT + 210, $XTOP, "ISSUED BY", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(30, 0, $XLEFT + 250, $XTOP, "COP NUMBER", $XBORDER + 1, 1, 0, true, 'C', true);


        if ($certificates) {
            $cert_name = json_decode($certificates['certificates']);
            $numbers = json_decode($certificates['number']);
            $date_issued = json_decode($certificates['date_issued']);
            $date_expired = json_decode($certificates['expiration_date']);
            $issued_by = json_decode($certificates['issued_by']);
            $cop_number = json_decode($certificates['with_cop_number']);

            $cert_tbl = "";
            for ($i = 0; $i < count($license_name); $i++) {
                $pdf->SetFont("helvetica", "", 10);

                $certName = $this->global->getTrainingCertificate($cert_name[$i])["cert_name"];
                $certNumber = !$numbers[$i] ? ' - ' : $numbers[$i];
                $new_date_issued = !empty($date_issued[$i]) ? date('M j, Y', strtotime($date_issued[$i])) : "-";
                $new_issued_by = !empty($issued_by[$i]) ? $issued_by[$i] : ' - ';
                $new_cop_number = !$cop_number[$i] ? ' - ' : $cop_number[$i];

                $XTOP += 5;
                $pdf->writeHTMLCell(150, 0, $XLEFT, $XTOP, $this->global->textEllipsis($certName, 80), $XBORDER + 1, 1, 0, true, 'L', true);
                $pdf->writeHTMLCell(30, 0, $XLEFT + 150, $XTOP, $certNumber, $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(30, 0, $XLEFT + 180, $XTOP, $new_date_issued, $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(40, 0, $XLEFT + 210, $XTOP, $new_issued_by, $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(30, 0, $XLEFT + 250, $XTOP, $new_cop_number, $XBORDER + 1, 1, 0, true, 'C', true);


                if ($XTOP > 380) {
                    $pdf->AddPage();
                    $XTOP = 38;
                    $pdf->SetFont("helvetica", "B", 10);
                    $pdf->writeHTMLCell(150, 0, $XLEFT, $XTOP, "CERTIFICATES", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(30, 0, $XLEFT + 150, $XTOP, "NUMBER", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(30, 0, $XLEFT + 180, $XTOP, "DATE ISSUED", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(40, 0, $XLEFT + 210, $XTOP, "ISSUED BY", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(30, 0, $XLEFT + 250, $XTOP, "COP NUMBER", $XBORDER + 1, 1, 0, true, 'C', true);

                    $pdf->SetFont("helvetica", "", 10);
                }
            }
        }


        // SEA SERVICE RECORD
        $XTOP += 10;
        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "IV. SEA SERVICE RECORD", $XBORDER, 1, 0, true, 'L', true);


        $XTOP += 5;
        $pdf->SetFont("helvetica", "B", 10);
        $pdf->writeHTMLCell(25, 0, $XLEFT, $XTOP, "VESSEL", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(25, 0, $XLEFT + 25, $XTOP, "FLAG", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(25, 0, $XLEFT + 50, $XTOP, "SALARY US$", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(25, 0, $XLEFT + 75, $XTOP, "RANK", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(35, 0, $XLEFT + 100, $XTOP, "TYPE OF VSL/ENG", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(25, 0, $XLEFT + 135, $XTOP, "GRT", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(25, 0, $XLEFT + 160, $XTOP, "EMBARKED", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(27, 0, $XLEFT + 185, $XTOP, "DISEMBARK", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(28, 0, $XLEFT + 212, $XTOP, "TOT. SERVICE", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(20, 0, $XLEFT + 240, $XTOP, "AGENCY", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(20, 0, $XLEFT + 260, $XTOP, "REMARKS", $XBORDER + 1, 1, 0, true, 'C', true);

        $sea_service_rec = $this->global->getListSeaServiceRecord($applicant_code);

        if ($sea_service_rec) {
            $vessel = json_decode($sea_service_rec['name_of_vessel']);
            $flag = json_decode($sea_service_rec['flag']);
            $rank = json_decode($sea_service_rec['rank']);
            $salary = json_decode($sea_service_rec['salary']);
            $type_vessel = json_decode($sea_service_rec['type_of_vsl_eng']);
            $grt_power = json_decode($sea_service_rec['grt_power']);
            $embarked = json_decode($sea_service_rec['embarked']);
            $disembarked = json_decode($sea_service_rec['disembarked']);
            $total_service = json_decode($sea_service_rec['total_service']);
            $agency = json_decode($sea_service_rec['agency']);
            $remarks = json_decode($sea_service_rec['remarks']);

            $count = 1;


            for ($i = 0; $i < count($vessel); $i++) {
                $pdf->SetFont("helvetica", "", 9);

                $embarkedDate = (!$embarked[$i] ? ' - ' : date('M j, Y', strtotime($embarked[$i])));
                $disembarkDate = (!$disembarked[$i] ? ' - ' : date('M j, Y', strtotime($disembarked[$i])));

                $sea_service = $this->global->getTotalSeaService($embarkedDate, $disembarkDate);

                $sea_service_year = !empty($sea_service["years"]) ? $sea_service["years"] . "yr" : "";
                $sea_service_month = !empty($sea_service["months"]) ? $sea_service["months"] . "m" : "";
                $sea_service_day = !empty($sea_service["days"]) ? $sea_service["days"] . "dy" : "";
                $total_sea_service = !empty(trim($sea_service_year . " " . $sea_service_month . " " . $sea_service_day)) ? trim($sea_service_year . " " . $sea_service_month . " " . $sea_service_day) : "-";


                $XTOP += 5;
                $pdf->writeHTMLCell(25, 0, $XLEFT, $XTOP, (!$vessel[$i] ? ' - ' : $this->global->textEllipsis($vessel[$i], 15)), $XBORDER + 1, 1, 0, true, 'L', true);
                $pdf->writeHTMLCell(25, 0, $XLEFT + 25, $XTOP, (!$flag[$i] ? ' - ' : $this->global->textEllipsis($flag[$i], 15)), $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(25, 0, $XLEFT + 75, $XTOP, (!$salary[$i] ? ' - ' : $salary[$i]), $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(25, 0, $XLEFT + 50, $XTOP, !empty($this->global->getPosition($rank[$i])['position_name']) ? $this->global->getPosition($rank[$i])['position_name'] : "-", $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(35, 0, $XLEFT + 100, $XTOP, (!$type_vessel[$i] ? ' - ' : $this->global->textEllipsis($type_vessel[$i], 15)), $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(25, 0, $XLEFT + 135, $XTOP, (!$grt_power[$i] ? ' - ' : $this->global->textEllipsis($grt_power[$i], 15)), $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(25, 0, $XLEFT + 160, $XTOP, $embarkedDate, $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(27, 0, $XLEFT + 185, $XTOP, $disembarkDate, $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(28, 0, $XLEFT + 212, $XTOP, "{$total_sea_service}", $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(20, 0, $XLEFT + 240, $XTOP, (!$agency[$i] ? ' - ' : $this->global->textEllipsis($agency[$i], 15)), $XBORDER + 1, 1, 0, true, 'C', true);
                $pdf->writeHTMLCell(20, 0, $XLEFT + 260, $XTOP, (!$remarks[$i] ? ' - ' : $this->global->textEllipsis($remarks[$i], 15)), $XBORDER + 1, 1, 0, true, 'C', true);


                if ($XTOP > 380) {
                    $pdf->AddPage();
                    $XTOP = 38;
                    $pdf->SetFont("helvetica", "B", 10);
                    $pdf->writeHTMLCell(25, 0, $XLEFT, $XTOP, "VESSEL", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(25, 0, $XLEFT + 25, $XTOP, "FLAG", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(25, 0, $XLEFT + 50, $XTOP, "SALARY US$", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(25, 0, $XLEFT + 75, $XTOP, "RANK", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(35, 0, $XLEFT + 100, $XTOP, "TYPE OF VSL/ENG", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(25, 0, $XLEFT + 135, $XTOP, "GRT", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(25, 0, $XLEFT + 160, $XTOP, "EMBARKED", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(27, 0, $XLEFT + 185, $XTOP, "DISEMBARK", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(28, 0, $XLEFT + 212, $XTOP, "TOT. SERVICE", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(20, 0, $XLEFT + 240, $XTOP, "AGENCY", $XBORDER + 1, 1, 0, true, 'C', true);
                    $pdf->writeHTMLCell(20, 0, $XLEFT + 260, $XTOP, "REMARKS", $XBORDER + 1, 1, 0, true, 'C', true);

                    $pdf->SetFont("helvetica", "", 9);
                }
            }
        }

        $pdf->Output('shipboard_application.pdf', 'I');
    }

    public function print_shipboard_application($applicant_code)
    {
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "A4", true, 'UTF-8', false);

        $pdf->AddPage();

        $applicant_data = $this->applicant_registered->getApplicantPersonalData($applicant_code);

        $first_position = !empty($applicant_data['position_first']) ?  $this->global->getPositionById($applicant_data['position_first'])['position_name'] : "-";
        $second_position = !empty($applicant_data['position_second']) ? $this->global->getPositionById($applicant_data['position_second'])['position_name'] : "-";

        $city_address = trim($applicant_data['street_address'] . " " . $applicant_data['barangay'] . " " . $applicant_data['cty']);

        $XTOP = $pdf->getY() + 30;
        $XLEFT = 10;
        $XBORDER = 0;
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

        // SHIPBOARD EMPLOYMENT APPLICATION
        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT + 15, $XTOP, "SHIPBOARD EMPLOYEMENT APPLICATION", $XBORDER, 1, 0, true, 'L', true);


        // set JPEG quality
        $pdf->setJPEGQuality(75);

        $applicant_photo = $this->applicant_registered->getApplicantPhoto($this->global->ecdc('ec', $applicant_code));
        $pdf->Image($applicant_photo, $XLEFT, $XTOP - 10, 50, 50, '', '', 'T', false, 300, 'R', false, false, 1, false, false, false);

        $XTOP += 10;

        $pdf->SetFont("helvetica", "", 10);

        // POSITION
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "POSITION APPLIED: ", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(0, 0, $XLEFT + 40, $XTOP, strtoupper($first_position), $XBORDER, 1, 0, true, 'L', true);
        $pdf->Line($XLEFT + 75, $XTOP + 5, $XLEFT + 37, $XTOP + 5, $style);
        $pdf->writeHTMLCell(0, 0, $XLEFT + 42, $XTOP + 6, "(1ST CHOICE)", $XBORDER, 1, 0, true, 'L', true);

        // SECOND POSITION
        $pdf->writeHTMLCell(0, 0, $XLEFT + 95, $XTOP, strtoupper($second_position), $XBORDER, 1, 0, true, 'L', true);
        $pdf->Line($XLEFT + 118, $XTOP + 5, $XLEFT + 80, $XTOP + 5, $style);
        $pdf->writeHTMLCell(0, 0, $XLEFT + 85, $XTOP + 6, "(2ND CHOICE)", $XBORDER, 1, 0, true, 'L', true);

        $XTOP = $XTOP + 15;

        // DATE APPLIED
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "DATE APPLIED: ", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(0, 0, $XLEFT + 30, $XTOP, $applicant_data["date_created"] ? date('M d, Y', strtotime($applicant_data["date_created"])) : "-", $XBORDER, 1, 0, true, 'L', true);
        $pdf->Line($XLEFT + 55, $XTOP + 5, $XLEFT + 28, $XTOP + 5, $style);

        // DATE AVAILABLE
        $pdf->writeHTMLCell(0, 0, $XLEFT + 58, $XTOP, "DATE AVAILABLE: ", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(0, 0, $XLEFT + 90, $XTOP, $applicant_data["date_available"] ? date('M d, Y', strtotime($applicant_data["date_available"])) : "-", $XBORDER, 1, 0, true, 'L', true);
        $pdf->Line($XLEFT + 118, $XTOP + 5, $XLEFT + 90, $XTOP + 5, $style);

        $XTOP = $XTOP + 10;

        $pdf->SetFont("helvetica", "B", 10);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "I. PERSONAL INFORMATION", $XBORDER, 1, 0, true, 'L', true);

        $XTOP += 7;

        $pdf->SetFont("helvetica", "", 10);

        // // NAME
        $pdf->writeHTMLCell(15, 0, $XLEFT, $XTOP, "NAME", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(110, 0, $XLEFT + 15, $XTOP, "", $XBORDER + 1, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(110, 0, $XLEFT + 20, $XTOP, $applicant_data["last_name"] ? $applicant_data["last_name"] : "-", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(110, 0, $XLEFT + 60, $XTOP, $applicant_data["first_name"] ? $applicant_data["first_name"] : "-", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(110, 0, $XLEFT + 100, $XTOP, $applicant_data["middle_name"] ? $applicant_data["middle_name"] : "-", $XBORDER, 1, 0, true, 'L', true);

        $pdf->writeHTMLCell(110, 0, $XLEFT + 17, $XTOP + 5, "(LAST NAME)", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(110, 0, $XLEFT + 53, $XTOP + 5, "(FIRST NAME)", $XBORDER, 1, 0, true, 'L', true);
        $pdf->writeHTMLCell(110, 0, $XLEFT + 95, $XTOP + 5, "(MIDDLE NAME)", $XBORDER, 1, 0, true, 'L', true);

        // BIRTHDATE & BIRTHPLACE
        $pdf->writeHTMLCell(25, 0, $XLEFT + 125, $XTOP, "BIRTH DATE", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(40, 0, $XLEFT + 150, $XTOP, $applicant_data["birth_date"] ? date('F d, Y', strtotime($applicant_data["birth_date"])) : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $pdf->writeHTMLCell(30, 0, $XLEFT + 125, $XTOP + 5, "BIRTH PLACE", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(35, 0, $XLEFT + 155, $XTOP + 5, $applicant_data["birth_place"] ? $applicant_data["birth_place"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 10;

        // EMAIL ADDRESS
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "EMAIL ADDRESS: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(50, 0, $XLEFT + 35, $XTOP, $applicant_data["email_address"] ? $applicant_data["email_address"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        //SSS
        $pdf->writeHTMLCell(20, 0, $XLEFT + 85, $XTOP, "SSS NO.", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(45, 0, $XLEFT + 105, $XTOP, $applicant_data["sss_no"] ? $applicant_data["sss_no"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        //AGE
        $pdf->writeHTMLCell(20, 0, $XLEFT + 150, $XTOP, "AGE", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(20, 0, $XLEFT + 170, $XTOP, $applicant_data["birth_date"] ? $this->global->getAge($applicant_data["birth_date"]) : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // CITY ADDRESS
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "CITY ADDRESS: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(80, 0, $XLEFT + 35, $XTOP, $applicant_data['next_kin_address'], $XBORDER + 1, 1, 0, true, 'C', true);


        // STATUS
        $pdf->writeHTMLCell(35, 0, $XLEFT + 115, $XTOP, "STATUS: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(40, 0, $XLEFT + 150, $XTOP, $applicant_data['civil_status'] ? $this->global->getCivilStatus($applicant_data['civil_status'])['description'] : "-", $XBORDER + 1, 1, 0, true, 'C', true);


        $XTOP += 5;

        // PROVINCIAL
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "PROVINCIAL: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(45, 0, $XLEFT + 35, $XTOP, $applicant_data["prvince"] ? $applicant_data["prvince"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // CEL NO.
        $pdf->writeHTMLCell(25, 0, $XLEFT + 80, $XTOP, "MOBILE NO:", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(30, 0, $XLEFT + 105, $XTOP, $applicant_data["mobile_number"] ? $applicant_data["mobile_number"] : "09386134057", $XBORDER + 1, 1, 0, true, 'C', true);

        // TEL NO.
        $pdf->writeHTMLCell(25, 0, $XLEFT + 135, $XTOP, "TEL NO: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(30, 0, $XLEFT + 160, $XTOP, $applicant_data["telephone_number"] ? $applicant_data["telephone_number"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // RELIGION
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "RELIGION: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(45, 0, $XLEFT + 35, $XTOP, $applicant_data['religion'] ? $this->global->getReligion($applicant_data['religion'])['description'] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // HEIGHT
        $pdf->SetFont("helvetica", "", 10);
        $pdf->writeHTMLCell(20, 0, $XLEFT + 80, $XTOP, "HEIGHT: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(15, 0, $XLEFT + 100, $XTOP, $applicant_data["height"] ? $applicant_data["height"] . "cm" : "-", $XBORDER + 1, 1, 0, true, 'C', true);


        // WEIGHT
        $pdf->writeHTMLCell(20, 0, $XLEFT + 115, $XTOP, "WEIGHT: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(15, 0, $XLEFT + 135, $XTOP, $applicant_data["weight"] ? $applicant_data["weight"] . "kg" : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // BMI
        $pdf->writeHTMLCell(20, 0, $XLEFT + 150, $XTOP, "BMI: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(20, 0, $XLEFT + 170, $XTOP, $applicant_data['height'] && $applicant_data['weight'] ? $this->global->getBMI($applicant_data['height'], $applicant_data['weight']) : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // PHILHEALTH
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "PHILHEALTH NO: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(35, 0, $XLEFT + 35, $XTOP, $applicant_data["philhealth_no"] ? $applicant_data["philhealth_no"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // PAGIBIG
        $pdf->writeHTMLCell(35, 0, $XLEFT + 70, $XTOP, "PAG-IBIG NO: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(35, 0, $XLEFT + 105, $XTOP, $applicant_data["pag_ibig_no"] ? $applicant_data["pag_ibig_no"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // TIN NO
        $pdf->writeHTMLCell(18, 0, $XLEFT + 140, $XTOP, "TIN NO: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(32, 0, $XLEFT + 158, $XTOP, $applicant_data["tin_number"] ? $applicant_data["tin_number"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $pdf->SetFont("helvetica", "", 10);

        $XTOP += 5;

        // SPOUSE NAME
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "SPOUSE NAME: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 35, $XTOP, $applicant_data["spouse_name"] ? $applicant_data["spouse_name"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // FATHER'S NAME
        $pdf->writeHTMLCell(35, 0, $XLEFT + 95, $XTOP, "FATHER'S NAME: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 130, $XTOP, $applicant_data["father_name"] ? $applicant_data["father_name"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // OCCUPATION
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "OCCUPATION: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 35, $XTOP, $applicant_data["occupation"] ? $applicant_data["occupation"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // MOTHER'S NAME
        $pdf->writeHTMLCell(35, 0, $XLEFT + 95, $XTOP, "MOTHER'S NAME: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 130, $XTOP, $applicant_data["mother_name"] ? $applicant_data["mother_name"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;
        // NO OF CHILDREN
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "NO OF CHILDREN: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(40, 0, $XLEFT + 35, $XTOP, $applicant_data["no_of_children"] ? $applicant_data["no_of_children"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // ADDRESS
        $pdf->writeHTMLCell(35, 0, $XLEFT + 75, $XTOP, "ADDRESS: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(80, 0, $XLEFT + 110, $XTOP, $applicant_data["next_kin_address"] ? $applicant_data["next_kin_address"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        $pdf->SetFont("helvetica", "B", 11);
        $pdf->writeHTMLCell(95, 0, $XLEFT, $XTOP, "EDUCATIONAL ATTAINMENT: ", $XBORDER, 1, 0, true, 'l', true);
        $pdf->writeHTMLCell(70, 0, $XLEFT + 95, $XTOP, "WORKING GEARS", $XBORDER, 1, 0, true, 'l', true);

        $pdf->SetFont("helvetica", "B", 9);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 130, $XTOP + 1, "(SPECIFY SIZES IF S/M/L/Xl/XXL...)", $XBORDER, 1, 0, true, 'l', true);

        $XTOP += 5;

        $pdf->SetFont("helvetica", "", 10);
        // COURSE
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "COURSE: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 35, $XTOP, $applicant_data["course"] ? $applicant_data["course"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // COVER ALL
        $pdf->writeHTMLCell(35, 0, $XLEFT + 95, $XTOP, "COVER ALL: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 130, $XTOP, $applicant_data["cover_all"] ? $applicant_data["cover_all"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // SCHOOL
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "SCHOOL: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 35, $XTOP, $applicant_data["school"] ? $applicant_data["school"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // WINTER JACKET
        $pdf->writeHTMLCell(35, 0, $XLEFT + 95, $XTOP, "WINTER JACKET: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 130, $XTOP, $applicant_data["winter_jacket"] ? $applicant_data["winter_jacket"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // SCHOOL ADDRESS
        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "SCHOOL ADD: ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 35, $XTOP, $applicant_data["school_address"] ? $applicant_data["school_address"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        // SHOES
        $pdf->writeHTMLCell(35, 0, $XLEFT + 95, $XTOP, "SHOES (IN CMS): ", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 130, $XTOP, $applicant_data["shoes"] ? $applicant_data["shoes"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;
        $pdf->writeHTMLCell(50, 0, $XLEFT + 50, $XTOP, "(CITY & PROVINCE)", $XBORDER, 1, 0, true, 'L', true);

        // WINTER BOOTS
        $pdf->writeHTMLCell(43, 0, $XLEFT + 95, $XTOP, "WINTER BOOTS(CMS):", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(52, 0, $XLEFT + 138, $XTOP, $applicant_data["winter_boots"] ? $applicant_data["winter_boots"] : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;

        // INCLUSIVE YEARS
        $inclusive_years = json_decode($applicant_data["inclusive_years"]);

        $pdf->writeHTMLCell(35, 0, $XLEFT, $XTOP, "INCLUSIVE YEARS:", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 35, $XTOP, $applicant_data["inclusive_years"] ? date('Y-m-d', strtotime($inclusive_years[0])) . " - " . date('Y-m-d', strtotime($inclusive_years[1])) : "-", $XBORDER + 1, 1, 0, true, 'C', true);

        $pdf->writeHTMLCell(35, 0, $XLEFT + 95, $XTOP, "", $XBORDER + 1, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(60, 0, $XLEFT + 130, $XTOP, "", $XBORDER + 1, 1, 0, true, 'C', true);

        $XTOP += 5;
        $pdf->writeHTMLCell(50, 0, $XLEFT + 43, $XTOP, "(YY/MM/DD - YY/MM/DD)", $XBORDER, 1, 0, true, 'L', true);

        // LICENSES
        $XTOP += 10;
        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(190, 0, $XLEFT, $XTOP, "II. LICENSES / ENDORSEMENT / BOOK / ID", $XBORDER, 1, 0, true, 'L', true);

        $pdf->SetFont("helvetica", "B", 10);

        // set color for background


        $pdf->Cell(38, 0, 'LICENSES', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(38, 0, 'GRADE', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(38, 0, 'NUMBER', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(38, 0, 'DATE ISSUED', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(38, 0, 'EXPIRY DATE', 1, 0, 'L', 0, '', 1);

        $licenses = $this->global->getListLicenses($applicant_code);

        if ($licenses) {
            $license_name = json_decode($licenses['lebi']);
            $grade = json_decode($licenses['grade']);
            $number = json_decode($licenses['number']);
            $date_issued = json_decode($licenses['date_issued']);
            $expiry_date = json_decode($licenses['expiry_date']);
            $pdf->SetFont("helvetica", "", 10);

            for ($i = 0; $i < count($license_name); $i++) {
                $licenseName = $this->global->getLicenseById($license_name[$i])['license_name'];
                $grde = (!$grade[$i] ? ' - ' : $grade[$i]);
                $numbr = (!$number[$i] ? ' - ' : $number[$i]);
                $dateIssued = !$date_issued[$i] ? ' - ' : date('M j, Y', strtotime($date_issued[$i]));
                $expiryDate = !$expiry_date[$i] ? ' - ' : date('M j, Y', strtotime($expiry_date[$i]));

                //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
                $pdf->Ln(5);
                $pdf->Cell(38, 0, $licenseName, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(38, 0, $grde, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(38, 0, $numbr, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(38, 0, $dateIssued, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(38, 0, $expiryDate, 1, 0, 'L', 0, '', 1);

                if ($pdf->getY() > 250) {
                    $pdf->AddPage();
                    $pdf->setY(35);

                    $pdf->Cell(38, 0, 'LICENSES', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(38, 0, 'GRADE', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(38, 0, 'NUMBER', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(38, 0, 'DATE ISSUED', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(38, 0, 'EXPIRY DATE', 1, 0, 'L', 0, '', 1);
                }
            }
        } else {
            $pdf->ln(5);
            $pdf->Cell(38, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(38, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(38, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(38, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(38, 0, '-', 1, 0, 'L', 0, '', 1);
        }

        $XTOP = $pdf->getY();

        if ($XTOP > 247) {
            $pdf->AddPage();
            $XTOP = 25;
        }

        // CERTIFICATES
        $XTOP += 10;
        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "III. TRAINING AND CERTIFICATES", $XBORDER, 1, 0, true, 'L', true);

        $pdf->SetFont("helvetica", "B", 10);
        $pdf->Cell(38, 0, 'CERTIFICATES', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(38, 0, 'NUMBER', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(38, 0, 'DATE ISSUED', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(38, 0, 'ISSUED BY', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(38, 0, 'COP NUMBER', 1, 0, 'L', 0, '', 1);

        $certificates = $this->global->getListCertificates($applicant_code);

        if ($certificates) {
            $cert_name = json_decode($certificates['certificates']);
            $numbers = json_decode($certificates['number']);
            $date_issued = json_decode($certificates['date_issued']);
            $date_expired = json_decode($certificates['expiration_date']);
            $issued_by = json_decode($certificates['issued_by']);
            $cop_number = json_decode($certificates['with_cop_number']);

            $cert_tbl = "";
            for ($i = 0; $i < count($license_name); $i++) {
                $pdf->SetFont("helvetica", "", 10);

                $certName = $this->global->getTrainingCertificate($cert_name[$i])["cert_name"];
                $certCode = $this->global->getTrainingCertificate($cert_name[$i])["cert_code"];
                $certNumber = !$numbers[$i] ? ' - ' : $numbers[$i];
                $new_date_issued = !empty($date_issued[$i]) ? date('M j, Y', strtotime($date_issued[$i])) : "-";
                $new_issued_by = !empty($issued_by[$i]) ? $issued_by[$i] : ' - ';
                $new_cop_number = !$cop_number[$i] ? ' - ' : $cop_number[$i];

                $pdf->Ln(5);
                $pdf->Cell(38, 0, $certCode, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(38, 0, $certNumber, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(38, 0, $new_date_issued, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(38, 0, $new_issued_by, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(38, 0, $new_cop_number, 1, 0, 'L', 0, '', 1);

                if ($pdf->getY() > 250) {
                    $pdf->AddPage();
                    $pdf->setY(35);
                    $pdf->SetFont("helvetica", "B", 10);
                    $pdf->Cell(38, 0, 'CERTIFICATES', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(38, 0, 'NUMBER', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(38, 0, 'DATE ISSUED', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(38, 0, 'ISSUED BY', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(38, 0, 'COP NUMBER', 1, 0, 'L', 0, '', 1);
                }
            }
        } else {
            $pdf->ln(5);
            $pdf->Cell(38, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(38, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(38, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(38, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(38, 0, '-', 1, 0, 'L', 0, '', 1);
        }

        $XTOP = $pdf->getY();

        if ($XTOP > 247) {
            $pdf->AddPage();
            $XTOP = 25;
        }

        // SEA SERVICE RECORD
        $XTOP += 10;
        $pdf->SetFont("helvetica", "B", 12);
        $pdf->writeHTMLCell(0, 0, $XLEFT, $XTOP, "IV. SEA SERVICE RECORD", $XBORDER, 1, 0, true, 'L', true);

        $pdf->SetFont("helvetica", "B", 10);
        $pdf->Cell(17, 0, 'VESSEL', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(17, 0, 'FLAG', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(17, 0, 'SALARY US$', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(17, 0, 'RANK', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(20, 0, 'TYPE OF VSL/ENG', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(17, 0, 'GRT', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(17, 0, 'EMBARKED', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(17, 0, 'DISEMBARK', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(17, 0, 'TOT. SERVICE', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(17, 0, 'AGENCY', 1, 0, 'L', 0, '', 1);
        $pdf->Cell(17, 0, 'REMARKS', 1, 0, 'L', 0, '', 1);

        $sea_service_rec = $this->global->getListSeaServiceRecord($applicant_code);

        if ($sea_service_rec) {
            $vessel = json_decode($sea_service_rec['name_of_vessel']);
            $flag = json_decode($sea_service_rec['flag']);
            $rank = json_decode($sea_service_rec['rank']);
            $salary = json_decode($sea_service_rec['salary']);
            $type_vessel = json_decode($sea_service_rec['type_of_vsl_eng']);
            $grt_power = json_decode($sea_service_rec['grt_power']);
            $embarked = json_decode($sea_service_rec['embarked']);
            $disembarked = json_decode($sea_service_rec['disembarked']);
            $total_service = json_decode($sea_service_rec['total_service']);
            $agency = json_decode($sea_service_rec['agency']);
            $remarks = json_decode($sea_service_rec['remarks']);

            $count = 1;

            for ($i = 0; $i < count($vessel); $i++) {
                $pdf->SetFont("helvetica", "", 10);

                $embarkedDate = (!$embarked[$i] ? ' - ' : date('M j, Y', strtotime($embarked[$i])));
                $disembarkDate = (!$disembarked[$i] ? ' - ' : date('M j, Y', strtotime($disembarked[$i])));

                if (trim($embarkedDate) != "-" && trim($disembarkDate) != "-") {

                    $sea_service = $this->global->getTotalSeaService($embarkedDate, $disembarkDate);

                    $sea_service_year = !empty($sea_service["years"]) ? $sea_service["years"] . "yr" : "";
                    $sea_service_month = !empty($sea_service["months"]) ? $sea_service["months"] . "mos" : "";
                    $sea_service_day = !empty($sea_service["days"]) ? $sea_service["days"] . "day" : "";
                    $total_sea_service = !empty(trim($sea_service_year . " " . $sea_service_month . " " . $sea_service_day)) ? trim($sea_service_year . " " . $sea_service_month . " " . $sea_service_day) : "-";
                } else {
                    $total_sea_service = " - ";
                }

                $pdf->Ln(5);
                $pdf->Cell(17, 0, (!$vessel[$i] ? ' - ' : $vessel[$i]), 1, 0, 'L', 0, '', 1);
                $pdf->Cell(17, 0, (!$flag[$i] ? ' - ' : $flag[$i]), 1, 0, 'L', 0, '', 1);
                $pdf->Cell(17, 0, (!$salary[$i] ? ' - ' : $salary[$i]), 1, 0, 'L', 0, '', 1);
                $pdf->Cell(17, 0, !empty($this->global->getPosition($rank[$i])['position_name']) ? $this->global->getPosition($rank[$i])['position_name'] : "-", 1, 0, 'L', 0, '', 1);
                $pdf->Cell(20, 0, (!$type_vessel[$i] ? ' - ' : $type_vessel[$i]), 1, 0, 'L', 0, '', 1);
                $pdf->Cell(17, 0, (!$grt_power[$i] ? ' - ' : $grt_power[$i]), 1, 0, 'L', 0, '', 1);
                $pdf->Cell(17, 0, $embarkedDate, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(17, 0, $disembarkDate, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(17, 0, $total_sea_service, 1, 0, 'L', 0, '', 1);
                $pdf->Cell(17, 0, (!$agency[$i] ? ' - ' : $agency[$i]), 1, 0, 'L', 0, '', 1);
                $pdf->Cell(17, 0, (!$remarks[$i] ? ' - ' : $remarks[$i]), 1, 0, 'L', 0, '', 1);

                if ($pdf->getY() > 250) {
                    $pdf->AddPage();
                    $pdf->setY(35);

                    $pdf->SetFont("helvetica", "B", 10);
                    $pdf->Cell(17, 0, 'VESSEL', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(17, 0, 'FLAG', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(17, 0, 'SALARY US$', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(17, 0, 'RANK', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(20, 0, 'TYPE OF VSL/ENG', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(17, 0, 'GRT', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(17, 0, 'EMBARKED', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(17, 0, 'DISEMBARK', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(17, 0, 'TOT. SERVICE', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(17, 0, 'AGENCY', 1, 0, 'L', 0, '', 1);
                    $pdf->Cell(17, 0, 'REMARKS', 1, 0, 'L', 0, '', 1);
                }
            }
        } else {
            $pdf->ln(5);
            $pdf->Cell(17, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(17, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(17, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(17, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(20, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(17, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(17, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(17, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(17, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(17, 0, '-', 1, 0, 'L', 0, '', 1);
            $pdf->Cell(17, 0, '-', 1, 0, 'L', 0, '', 1);
        }

        $pdf->Output('shipboard_application.pdf', 'I');
    }
}
