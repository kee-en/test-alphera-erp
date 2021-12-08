<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Writer\Pdf;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use Mpdf\Mpdf;

class Print_contract extends CI_Controller
{
    public function Print_POEA($contract_code)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/POEA/POEAContractForm.xlsx');
        $contract = $this->contracts->getCrewContractByContractCode($contract_code);
        $sheet = $spreadsheet->getActiveSheet();
        $emp_count = 1;
        foreach ($contract as $row) {
            $sheet->setCellValue('C7', $row['full_name']);
            $sheet->setCellValue('C8', date('F j, Y' , strtotime($row['birth_date'])));
            $sheet->setCellValue('G8', $row['birth_place']);
            $sheet->setCellValue('C9', $row['address'].', '.$this->global->getCity($row['city'])['description'].', '.$this->global->getProvince($row['region'])['description'].' '.$row['zip_code'] );
            $sheet->setCellValue('B10', $row['sirb_no']);
            $sheet->setCellValue('E10', $row['src_no']);
            $sheet->setCellValue('H10', $row['license']);
            $sheet->setCellValue('D14', $row['agent_name']);
            $sheet->setCellValue('D15', $row['ps_name']);
            $sheet->setCellValue('D16', $row['ps_address']);
            $sheet->setCellValue('C19', $row['vsl_name']);
            $sheet->setCellValue('B20', $row['imo_no']);
            $sheet->setCellValue('E20', $row['grt']);
            $sheet->setCellValue('H20', date('F j, Y' , strtotime($row['year_build'])));
            $sheet->setCellValue('B21', $row['flag']);
            $sheet->setCellValue('E21', $this->global->getVesselTypeById($row['vessel_type'])['tv_name']);
            $sheet->setCellValue('H21', $row['society_classification']);
            $sheet->setCellValue('D26', date('F j, Y' , strtotime($row['contract_duration'])));
            $sheet->setCellValue('D27', $this->global->getPosition($row['position'])['position_name']);
            $sheet->setCellValue('D28', number_format($row['monthly_salary'], 2));
            $sheet->setCellValue('D29', $row['work_hours']);
            $sheet->setCellValue('D30', $row['ot']);
            $sheet->setCellValue('D31', $row['vl_pay']);
            $sheet->setCellValue('D32', $row['others']);
            $sheet->setCellValue('D33', $row['total_salary']);
            $sheet->setCellValue('D34', $row['hire_point']);
            $sheet->setCellValue('D35', $row['collective_agreement']);
            $sheet->setCellValue('A50', $row['full_name']);

            $emp_count++;
            $filename = ucfirst($row['full_name']).'_'.'poea_contract'; // set filename for excel file to be exported
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet); // instantiate Pdf

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function Print_MLC_korean($monitor_code)
    {   
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/MLC/MLC_KoreanFlag_Form.xlsx');
            $sheet = $spreadsheet->getActiveSheet();

            $mlc = $this->contracts->getCrewMlcByMonCode($monitor_code);

            foreach ($mlc as $row) {
                $agreement_details = json_decode($row['agreement_details'], true);
                $wage = json_decode($row['wage'], true);
                $period_employment = json_decode($row['employment_period'], true);
                $vsl = $this->global->getVesselById($row['vessel_assign']);
                $license = json_decode($row['number'], true);
    
                $sheet->setCellValue('C10', $vsl['vsl_name']);
                $sheet->setCellValue('G10', $this->global->getVesselTypeById($vsl['vsl_type'])['tv_name']);
                $sheet->setCellValue('C11', $row['full_name']);
                $sheet->setCellValue('G11', $this->global->getPositionById($row['position'])['position_name']);
                $sheet->setCellValue('C12', $license[5]);
                $sheet->setCellValue('E12', $license[6]);
                $sheet->setCellValue('G12', $license[0]);
                $sheet->setCellValue('C13', $row['gender']);
                $sheet->setCellValue('E13', $this->global->getNationalityById($row['nationality'])['description']);
                $sheet->setCellValue('G13', date('F j, Y' , strtotime($row['birth_date'])));
                $sheet->setCellValue('B16', $agreement_details[0]);
                $sheet->setCellValue('F16', date('F j, Y' , strtotime($agreement_details[1])));
                $sheet->setCellValue('D19', $wage[0]);
                $sheet->setCellValue('D20', $wage[1]);
                $sheet->setCellValue('D21', $wage[2]);
                $sheet->setCellValue('D22', $wage[3]);
                $sheet->setCellValue('D23', $wage[4]);
                $sheet->setCellValue('D24', $wage[5]);
                $sheet->setCellValue('D25', $wage[6]);
                $sheet->setCellValue('D26', $wage[7]);
                $sheet->setCellValue('D29', date('F j, Y' , strtotime($period_employment[0])));
                $sheet->setCellValue('F29', date('F j, Y' , strtotime($period_employment[1])));
                $sheet->setCellValue('F56', $row['full_name']);
                $sheet->setCellValue('F57', $row['shipowner_vessel']); 
                $sheet->setCellValue('F58', $row['name_of_vp']); 

                $filename = ucfirst($row['full_name']).'_'.'poea_contract'; // set filename for excel file to be exported
            }
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet); // instantiate Pdf
    
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
    }

    public function Print_MLC_panama($monitor_code)
    {   
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/MLC/MLC_PanamaFlag_Form.xlsx');
            $sheet = $spreadsheet->getActiveSheet();

            $mlc = $this->contracts->getCrewMlcByMonCode($monitor_code);

            foreach ($mlc as $row) {
                $agreement_details = json_decode($row['agreement_details'], true);
                $wage = json_decode($row['wage'], true);
                $period_employment = json_decode($row['employment_period'], true);
                $vsl = $this->global->getVesselById($row['vessel_assign']);
                $license = json_decode($row['number'], true);
    
                $sheet->setCellValue('C10', $vsl['vsl_name']);
                $sheet->setCellValue('G10', $this->global->getVesselTypeById($vsl['vsl_type'])['tv_name']);
                $sheet->setCellValue('C11', $row['full_name']);
                $sheet->setCellValue('G11', $this->global->getPositionById($row['position'])['position_name']);
                $sheet->setCellValue('C12', $license[5]);
                $sheet->setCellValue('E12', $license[6]);
                $sheet->setCellValue('G12', $license[0]);
                $sheet->setCellValue('C13', $row['gender']);
                $sheet->setCellValue('E13', $this->global->getNationalityById($row['nationality'])['description']);
                $sheet->setCellValue('G13', date('F j, Y' , strtotime($row['birth_date'])));
                $sheet->setCellValue('B16', $agreement_details[0]);
                $sheet->setCellValue('F16', date('F j, Y' , strtotime($agreement_details[1])));
                $sheet->setCellValue('D19', $wage[0]);
                $sheet->setCellValue('D20', $wage[1]);
                $sheet->setCellValue('D21', $wage[2]);
                $sheet->setCellValue('D22', $wage[3]);
                $sheet->setCellValue('D23', $wage[4]);
                $sheet->setCellValue('D24', $wage[5]);
                $sheet->setCellValue('D25', $wage[6]);
                $sheet->setCellValue('D26', $wage[7]);
                $sheet->setCellValue('D29', date('F j, Y' , strtotime($period_employment[0])));
                $sheet->setCellValue('F29', date('F j, Y' , strtotime($period_employment[1])));
                $sheet->setCellValue('F56', $row['full_name']);

                $filename = ucfirst($row['full_name']).'_'.'poea_contract'; // set filename for excel file to be exported
            }
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet); // instantiate Pdf
    
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
    }

    public function Print_MLC_marshall($monitor_code)
    {   
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/MLC/MLC_MarshallFlag_Form.xlsx');
            $sheet = $spreadsheet->getActiveSheet();

            $mlc = $this->contracts->getCrewMlcByMonCode($monitor_code);

            foreach ($mlc as $row) {
                $agreement_details = json_decode($row['agreement_details'], true);
                $wage = json_decode($row['wage'], true);
                $period_employment = json_decode($row['employment_period'], true);
                $vsl = $this->global->getVesselById($row['vessel_assign']);
                $license = json_decode($row['number'], true);
    
                $sheet->setCellValue('C10', $vsl['vsl_name']);
                $sheet->setCellValue('G10', $this->global->getVesselTypeById($vsl['vsl_type'])['tv_name']);
                $sheet->setCellValue('C11', $row['full_name']);
                $sheet->setCellValue('G11', $this->global->getPositionById($row['position'])['position_name']);
                $sheet->setCellValue('C12', $license[5]);
                $sheet->setCellValue('E12', $license[6]);
                $sheet->setCellValue('G12', $license[0]);
                $sheet->setCellValue('C13', $row['gender']);
                $sheet->setCellValue('E13', $this->global->getNationalityById($row['nationality'])['description']);
                $sheet->setCellValue('G13', date('F j, Y' , strtotime($row['birth_date'])));
                $sheet->setCellValue('B16', $agreement_details[0]);
                $sheet->setCellValue('F16', date('F j, Y' , strtotime($agreement_details[1])));
                $sheet->setCellValue('D19', $wage[0]);
                $sheet->setCellValue('D20', $wage[1]);
                $sheet->setCellValue('D21', $wage[2]);
                $sheet->setCellValue('D22', $wage[3]);
                $sheet->setCellValue('D23', $wage[4]);
                $sheet->setCellValue('D24', $wage[5]);
                $sheet->setCellValue('D25', $wage[6]);
                $sheet->setCellValue('D26', $wage[7]);
                $sheet->setCellValue('D29', date('F j, Y' , strtotime($period_employment[0])));
                $sheet->setCellValue('F29', date('F j, Y' , strtotime($period_employment[1])));
                $sheet->setCellValue('F56', $row['full_name']);

                $filename = ucfirst($row['full_name']).'_'.'poea_contract'; // set filename for excel file to be exported
            }
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet); // instantiate Pdf
    
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
    }
}
