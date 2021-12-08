<?php
/*
* Author: onlinecode
* start Pdf.php file
* Location: ./application/libraries/Pdf.php
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}

class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {
        $XTOP = 6;
        $XLEFT = 6;
        $XBORDER = 0;

        $image_file = base_url() . "assets/images/alphera/alphera_logo.png";
        $this->Image($image_file, $XTOP, $XLEFT, 50, '', 'PNG', '', 'T', TRUE, 300, '', false, false, 0, false, false, false);

        //SetFont first parameter set font-family, second font-style, third font-size
        $XTOP = $XTOP - 2;
        $this->SetFont("helvetica", "B", 15);
        $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "ALPHERA MARINE SERVICES INC.", $XBORDER, 1, 0, true, 'C', true);

        $this->SetTextColor(0, 114, 196);
        $this->SetFont("helvetica", "B", 8);

        $XTOP += 6;
        $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "(Formerly POS-PHIL SHIP MANAGEMENT CORPORATION)", $XBORDER, 1, 0, true, 'C', true);
        $XTOP += 4;

        $this->SetFont("helvetica", "B", 7);
        $this->SetTextColor(0, 0, 0);

        $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "7th Floor Jemarsons Place, 1626 Pilar Hidalgo Lim Street,", $XBORDER, 1, 0, true, 'C', true);
        $XTOP += 4;
        $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "Malate, Manila Philippines 1004", $XBORDER, 1, 0, true, 'C', true);
        $XTOP += 4;
        $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "Tel No.: 516-8800 to 02  Fax No.: 310-8720", $XBORDER, 1, 0, true, 'C', true);
        $XTOP += 4;
        $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "E-mail: amsi@alpheramarine.com", $XBORDER, 1, 0, true, 'C', true);
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('times', 'I', 8);
        // Page number
        // $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
class CUSTOMPDF extends TCPDF
{

    //Page header
    public function Header()
    {
        if ($this->page == 1) {
            $XTOP = 6;
            $XLEFT = 6;
            $XBORDER = 0;

            $image_file = base_url() . "assets/images/alphera/alphera_logo.png";
            $this->Image($image_file, $XTOP, $XLEFT, 50, '', 'PNG', '', 'T', TRUE, 300, '', false, false, 0, false, false, false);

            //SetFont first parameter set font-family, second font-style, third font-size
            $XTOP = $XTOP - 2;
            $this->SetFont("helvetica", "B", 15);
            $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "ALPHERA MARINE SERVICES INC.", $XBORDER, 1, 0, true, 'C', true);

            $this->SetTextColor(0, 114, 196);
            $this->SetFont("helvetica", "B", 8);

            $XTOP += 6;
            $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "(Formerly POS-PHIL SHIP MANAGEMENT CORPORATION)", $XBORDER, 1, 0, true, 'C', true);
            $XTOP += 4;

            $this->SetFont("helvetica", "B", 7);
            $this->SetTextColor(0, 0, 0);

            $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "7th Floor Jemarsons Place, 1626 Pilar Hidalgo Lim Street,", $XBORDER, 1, 0, true, 'C', true);
            $XTOP += 4;
            $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "Malate, Manila Philippines 1004", $XBORDER, 1, 0, true, 'C', true);
            $XTOP += 4;
            $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "Tel No.: 516-8800 to 02  Fax No.: 310-8720", $XBORDER, 1, 0, true, 'C', true);
            $XTOP += 4;
            $this->writeHTMLCell(0, 0, $XLEFT, $XTOP, "E-mail: amsi@alpheramarine.com", $XBORDER, 1, 0, true, 'C', true);
        }
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('times', 'I', 8);
        // Page number
        // $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
/* end Pdf.php file */