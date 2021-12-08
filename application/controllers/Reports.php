<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Writer\Pdf;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use Mpdf\Mpdf;

class Reports extends CI_Controller
{
    //Applicants Report
    //Registered Applicant Report
    public function print_registered_applicant_xl()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_global_applicant_report.xlsx');
        $applicant = $this->applicant_registered->getApplicantRegistered();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', 'N/A');
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);

            $count++;
            $emp_count++;
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'list-of-registered-applicants'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_registered_applicant_csv()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_global_applicant_report.xlsx');
        $applicant = $this->applicant_registered->getApplicantRegistered();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', 'N/A');
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);

            $count++;
            $emp_count++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        $filename = 'list-of-registered-applicants'; // set filename for excel file to be exported
        header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');    // download file
    }

    public function print_registered_applicant_pdf()
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_global_applicant_report.xlsx');
        $applicant = $this->applicant_registered->getApplicantRegistered();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', 'N/A');
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);

            $count++;
            $emp_count++;
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet); // instantiate Xlsx
        $filename = 'list-of-registered-applicants'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        // $applicant = $this->applicant_registered->getApplicantRegistered();
        // $employee_row = [];
        // $count = 1;
        //   foreach ($applicant as $row) {
        //     $status = $this->global->getApplicantStatusForReports($row['status']);
        //       $data = [
        //         "applicant_no" => $count,
        //         "applicant_code"  => $row['applicant_code'],
        //         "fullname"  => $row['full_name'],
        //         "address"   => $row['province_name'].''.$row['city_name'],
        //         "position_1"  => $row['position_name1'] === null ? "NA" : $row['position_name1'],
        //         "position_2"  => $row['position_name2'] === null ? "NA" : $row['position_name2'],
        //         "approved_position_name" => "NA",
        //         "bmi" => round($row['weight'] / $row['height'] / $row['height'] * 10000, 2),
        //         "date_available"  => date('F j, Y', strtotime($row['date_available'])),
        //         "nat_result" => $row['nat_result'] === null ? "NA" : $row['nat_result'],
        //         "status"  => $status,
        //         "assessor_name"  => $row['f_assessor_name'] === null ? "NA" : $row['f_assessor_name']
        //       ];
        //       array_push($employee_row,$data);
        //       $count++;
        //     }
        //   $data = ['employee_row' => $employee_row];
        //   $filename = 'list-of-registered-applicants'; // set filename for excel file to be exported
        //   $mpdf = new \Mpdf\Mpdf([
        //     'mode' => 'utf-8',
        //     'format' => [190, 236],
        //     'orientation' => 'P',
        // ]);
        // $html = $this->load->view('pdf/r_global_reports', $data, true);
        //   $mpdf->WriteHTML($html);
        //   $mpdf->Output('' . $filename . '.pdf', "D"); // it downloads the file into the user system, with give name
    }
    //Registered Applicants Report End

    //Pending Apllicants Report
    public function print_pending_applicant_xl()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_applicant_report_pending.xlsx');
        $applicant = $this->applicant_pending->getApplicantPending();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province'] . '' . $row['city']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('H' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('I' . $count . '', $row['nat_result']);
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);
            $count++;
            $emp_count++;
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'list-of-pending-applicants'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_pending_applicant_csv()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_applicant_report_pending.xlsx');
        $applicant = $this->applicant_pending->getApplicantPending();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province'] . '' . $row['city']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('H' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('I' . $count . '', $row['nat_result']);
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);
            $count++;
            $emp_count++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        $filename = 'list-of-pending-applicants'; // set filename for excel file to be exported
        header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');    // download file
    }

    public function print_pending_applicant_pdf()
    {
        $applicant = $this->applicant_pending->getApplicantPending();
        $employee_row = [];
        $count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $data = [
                "applicant_no" => $count,
                "applicant_code"  => $row['applicant_code'],
                "fullname"  => $row['full_name'],
                "address"   => $row['province'] . '' . $row['city'],
                "position_1"  => $row['position_name1'] === null ? "NA" : $row['position_name1'],
                "position_2"  => $row['position_name2'] === null ? "NA" : $row['position_name2'],
                "approved_position_name" => "NA",
                "bmi" => round($row['weight'] / $row['height'] / $row['height'] * 10000, 2),
                "date_available"  => date('F j, Y', strtotime($row['date_available'])),
                "nat_result" => $row['nat_result'] === null ? "NA" : $row['nat_result'],
                "status"  => $status,
                "assessor_name"  => $row['f_assessor_name'] === null ? "NA" : $row['f_assessor_name']
            ];
            array_push($employee_row, $data);
            $count++;
        }
        $data = ['employee_row' => $employee_row];
        $filename = 'list-of-pending-applicants'; // set filename for excel file to be exported
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [190, 236],
            'orientation' => 'P'
        ]);
        $html = $this->load->view('pdf/r_global_reports', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('' . $filename . '.pdf', "D");
    }
    //Pending Applicants Report End

    //Interview General Report
    public function print_general_applicant($app_code, $print_type)
    {
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '228B22'),
                'size'  => 20,
                'name'  => 'Wingdings'
            )
        );

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_general_form_report.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $info = $this->applicant_interview->getApplicantInterviewReport($app_code);
        $info_general = $this->applicant_interview->getInterviewGeneralValue($app_code);
        $count = 3;
        $remark_count = 3;

        if ($info_general['scores']) {
            $scores = json_decode($info_general['scores']);
        }
        if ($info_general['remarks']) {
            $remarks = json_decode($info_general['remarks']);
        }

        $position = $info['approved_position'] === null ? "N/A" : $info['approved_position'];
        $vessel = $info['vsl_name'] === null ? "N/A" : $info['vsl_name'];
        $bmi = $info['weight'] === null ? "N/A" : round($info['weight'] / $info['height'] / $info['height'] * 10000, 2);
        $date_available = $info['date_available'] === null ? "N/A" : $info['date_available'];

        $sheet->setCellValue('A1', $info['full_name']);
        $sheet->setCellValue('B1', strtoupper($position));
        $sheet->setCellValue('D1', $vessel);

        if ($info_general) {
            $sheet->setCellValue('F1', 'BMI: ' . $bmi);
            $sheet->setCellValue('G1', 'Date Available:' . date('F j, Y', strtotime($date_available)));
            if ($scores) {
                foreach ($scores as $row) {
                    $sheet->setCellValue('B' . $count . '', $row);
                    if ($row === '10') {
                        $sheet->setCellValue('C' . $count . '', '✓');
                        $sheet->getStyle('C' . $count . '')->applyFromArray($styleArray);
                    } else if ($row === '5') {
                        $sheet->setCellValue('F' . $count . '', '✓');
                        $sheet->getStyle('F' . $count . '')->applyFromArray($styleArray);
                    } else if ($row === '8.5') {
                        $sheet->setCellValue('D' . $count . '', '✓');
                        $sheet->getStyle('D' . $count . '')->applyFromArray($styleArray);
                    } else if ($row === '7') {
                        $sheet->setCellValue('E' . $count . '', '✓');
                        $sheet->getStyle('E' . $count . '')->applyFromArray($styleArray);
                    }
                    $count++;
                }
            }

            if ($remarks) {
                foreach ($remarks as $rem) {
                    $sheet->setCellValue('G' . $remark_count . '', $rem);
                    $remark_count++;
                }
            }
            $sheet->setCellValue('B13', $info_general['total_score']);
            $sheet->setCellValue('B15', $info_general['final_result']);
        }

        $filename = $info['full_name'] . '_General_Interview'; // set filename for excel file to be exported

        if ($print_type === "xl") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
        }
        $writer->save('php://output');    // download file

    }

    public function print_interview_sheet($app_code)
    {
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '228B22'),
                'size'  => 20,
                'name'  => 'Wingdings'
            )
        );

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_general_form_report.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $info = $this->applicant_interview->getInterviewSheetData($app_code);
        $info_general = $this->applicant_interview->getInterviewGeneralValue($app_code);

        $scores = json_decode($info_general['scores']);
        $remarks = json_decode($info_general['remarks']);

        $interview_data = [
            "fullname"  => $info['full_name'],
            "req_position" => $info['approved_position'],
            "vessel_type"  => $info['tv_name'],
            "req_no_crew"  => $info['req_no_crew'],
            "present_no_crew" => $info['present_no_crew'],
            "excess_shortage" => $info['excess_shortage'],
            "chinese_name"    => $info['chinese_name'],
            "korean_name"     => $info['korean_name'],
            "kind_coc"        => $info['kind_coc'],
            "position_last_vessel" => $info['position_last_vessel'],
        ];

        $filename = 'list-of-interviewed-applicants'; // set filename for excel file to be exported
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [190, 236],
            'orientation' => 'P'
        ]);
        $html = $this->load->view('pdf/registered_applicants_report', $interview_data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('' . $filename . '.pdf', "D");
    }
    //Interview General Report End

    //For Interview Report
    public function print_interview_applicant_xl()
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_global_applicant_report.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $applicant = $this->applicant_interview->getApplicantInterview();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province'] . '' . $row['city']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', 'N/A');
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);

            $count++;
            $emp_count++;
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'list-of-interview-applicants'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_interview_applicant_csv()
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_global_applicant_report.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $applicant = $this->applicant_interview->getApplicantInterview();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province'] . '' . $row['city']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', 'N/A');
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);

            $count++;
            $emp_count++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        $filename = 'list-of-interview-applicants'; // set filename for excel file to be exported
        header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');    // download file
    }

    public function print_interview_applicant_pdf()
    {
        $applicant = $this->applicant_interview->getApplicantInterview();
        $employee_row = [];
        $count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $data = [
                "applicant_no" => $count,
                "applicant_code"  => $row['applicant_code'],
                "fullname"  => $row['full_name'],
                "address"   => $row['province'] . '' . $row['city'],
                "position_1"  => $row['position_name1'] === null ? "NA" : $row['position_name1'],
                "position_2"  => $row['position_name2'] === null ? "NA" : $row['position_name2'],
                "approved_position_name" => "NA",
                "bmi" => round($row['weight'] / $row['height'] / $row['height'] * 10000, 2),
                "date_available"  => date('F j, Y', strtotime($row['date_available'])),
                "nat_result" => $row['nat_result'] === null ? "NA" : $row['nat_result'],
                "status"  => $status,
                "assessor_name"  => $row['f_assessor_name'] === null ? "NA" : $row['f_assessor_name']
            ];
            array_push($employee_row, $data);
            $count++;
        }
        $data = ['employee_row' => $employee_row];
        $filename = 'list-of-interview-applicants'; // set filename for excel file to be exported
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [190, 236],
            'orientation' => 'P'
        ]);
        $html = $this->load->view('pdf/r_global_reports', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('' . $filename . '.pdf', "D");
    }
    //For Interview Report End

    //Approval Applicants Report
    public function print_approval_applicant_xl()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_applicant_report_approval.xlsx');
        $applicant = $this->applicant_approval->getApplicantApproval();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', $row['approved_position_name']);
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('J' . $count . '', $row['nat_result']);
            $sheet->setCellValue('K' . $count . '', $status);
            $sheet->setCellValue('L' . $count . '', $row['f_assessor_name']);
            $count++;
            $emp_count++;
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'list-of-approval-applicants'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_approval_applicant_csv()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_applicant_report_approval.xlsx');
        $applicant = $this->applicant_approval->getApplicantApproval();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', $row['approved_position_name']);
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('J' . $count . '', $row['nat_result']);
            $sheet->setCellValue('K' . $count . '', $status);
            $sheet->setCellValue('L' . $count . '', $row['f_assessor_name']);
            $count++;
            $emp_count++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        $filename = 'list-of-approval-applicants'; // set filename for excel file to be exported
        header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');    // download file
    }

    public function print_approval_applicant_pdf()
    {
        $applicant = $this->applicant_approval->getApplicantApproval();
        $employee_row = [];
        $count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $data = [
                "applicant_no" => $count,
                "applicant_code"  => $row['applicant_code'],
                "fullname"  => $row['full_name'],
                "address"   => $row['province_name'] . '' . $row['city_name'],
                "position_1"  => $row['position_name1'] === null ? "NA" : $row['position_name1'],
                "position_2"  => $row['position_name2'] === null ? "NA" : $row['position_name2'],
                "approved_position_name" => $row['approved_position_name'] === null ? "NA" : $row['approved_position_name'],
                "bmi" => round($row['weight'] / $row['height'] / $row['height'] * 10000, 2),
                "date_available"  => date('F j, Y', strtotime($row['date_available'])),
                "nat_result" => $row['nat_result'] === null ? "NA" : $row['nat_result'],
                "status"  => $status,
                "assessor_name"  => $row['f_assessor_name'] === null ? "NA" : $row['f_assessor_name']
            ];
            array_push($employee_row, $data);
            $count++;
        }
        $data = ['employee_row' => $employee_row];
        $filename = 'list-of-approval-applicants'; // set filename for excel file to be exported
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [190, 236],
            'orientation' => 'P'
        ]);
        $html = $this->load->view('pdf/r_global_reports', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('' . $filename . '.pdf', "D");
    }
    //Approval Applicants Report End

    //Passed Applicants Report
    public function print_passed_applicant_xl()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_applicant_report_passed.xlsx');
        $applicant = $this->applicant_passed->getApplicantPassed();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['approved_position_name']);
            $sheet->setCellValue('F' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('G' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('H' . $count . '', $row['nat_result']);
            $sheet->setCellValue('I' . $count . '', $status);
            $sheet->setCellValue('J' . $count . '', $row['f_assessor_name']);
            $count++;
            $emp_count++;
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'list-of-passed-applicants'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_passed_applicant_csv()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_applicant_report_passed.xlsx');
        $applicant = $this->applicant_passed->getApplicantPassed();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['approved_position_name']);
            $sheet->setCellValue('F' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('G' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('H' . $count . '', $row['nat_result']);
            $sheet->setCellValue('I' . $count . '', $status);
            $sheet->setCellValue('J' . $count . '', $row['f_assessor_name']);
            $count++;
            $emp_count++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        $filename = 'list-of-passed-applicants'; // set filename for excel file to be exported
        header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');    // download file
    }

    public function print_passed_applicant_pdf()
    {
        $applicant = $this->applicant_passed->getApplicantPassed();
        $employee_row = [];
        $count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $data = [
                "applicant_no" => $count,
                "applicant_code"  => $row['applicant_code'],
                "fullname"  => $row['full_name'],
                "address"   => $row['province_name'] . '' . $row['city_name'],
                "position_1"  => $row['position_name1'] === null ? "NA" : $row['position_name1'],
                "position_2"  => $row['position_name2'] === null ? "NA" : $row['position_name2'],
                "approved_position_name" => $row['approved_position_name'] === null ? "NA" : $row['approved_position_name'],
                "bmi" => round($row['weight'] / $row['height'] / $row['height'] * 10000, 2),
                "date_available"  => date('F j, Y', strtotime($row['date_available'])),
                "nat_result" => $row['nat_result'] === null ? "NA" : $row['nat_result'],
                "status"  => $status,
                "assessor_name"  => $row['f_assessor_name'] === null ? "NA" : $row['f_assessor_name']
            ];
            array_push($employee_row, $data);
            $count++;
        }
        $data = ['employee_row' => $employee_row];
        $filename = 'list-of-passed-applicants'; // set filename for excel file to be exported
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [190, 236],
            'orientation' => 'P'
        ]);
        $html = $this->load->view('pdf/r_global_reports', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('' . $filename . '.pdf', "D");
    }
    //Passed Applicants Report End

    //Not Qualified Applicants Report
    public function print_notqualified_applicant_xl()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_applicant_report_failed.xlsx');
        $applicant = $this->applicant_failed->getApplicantFailed();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', 'N/A');
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('I' . $count . '', $row['nat_result']);
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);

            $count++;
            $emp_count++;
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'list-of-failed-applicants'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_notqualified_applicant_csv()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_global_applicant_report.xlsx');
        $applicant = $this->applicant_failed->getApplicantFailed();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', 'N/A');
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('I' . $count . '', $row['nat_result']);
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);

            $count++;
            $emp_count++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        $filename = 'list-of-failed-applicants'; // set filename for excel file to be exported
        header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');    // download file
    }

    public function print_notqualified_applicant_pdf()
    {

        $applicant = $this->applicant_failed->getApplicantFailed();
        $employee_row = [];
        $count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $data = [
                "applicant_no" => $count,
                "applicant_code"  => $row['applicant_code'],
                "fullname"  => $row['full_name'],
                "address"   => $row['province_name'] . '' . $row['city_name'],
                "position_1"  => $row['position_name1'] === null ? "NA" : $row['position_name1'],
                "position_2"  => $row['position_name2'] === null ? "NA" : $row['position_name2'],
                "approved_position_name" => "NA",
                "bmi" => round($row['weight'] / $row['height'] / $row['height'] * 10000, 2),
                "date_available"  => date('F j, Y', strtotime($row['date_available'])),
                "nat_result" => $row['nat_result'] === null ? "NA" : $row['nat_result'],
                "status"  => $status,
                "assessor_name"  => $row['f_assessor_name'] === null ? "NA" : $row['f_assessor_name']
            ];
            array_push($employee_row, $data);
            $count++;
        }
        $data = ['employee_row' => $employee_row];
        $filename = 'list-of-failed-applicants'; // set filename for excel file to be exported
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [190, 236],
            'orientation' => 'P'
        ]);
        $html = $this->load->view('pdf/r_global_reports', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('' . $filename . '.pdf', "D");
    }
    //Not Qualified Applicants Report End

    //Reserved Applicants Report
    public function print_reserved_applicant_xl()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_global_applicant_report.xlsx');
        $applicant = $this->applicant_reserved->getApplicantReserved();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $approved = $row['approved_position_name'] === null ? "N/A" : $row['approved_position_name'];

            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', $approved);
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('I' . $count . '', $row['nat_result']);
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);

            $count++;
            $emp_count++;
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'list-of-reserved-applicants'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_reserved_applicant_csv()
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_global_applicant_report.xlsx');
        $applicant = $this->applicant_reserved->getApplicantReserved();
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;
        $emp_count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $approved = $row['approved_position_name'] === null ? "N/A" : $row['approved_position_name'];

            $sheet->setCellValue('A' . $count . '', $emp_count);
            $sheet->setCellValue('B' . $count . '', $row['applicant_code']);
            $sheet->setCellValue('C' . $count . '', $row['full_name']);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name1']);
            $sheet->setCellValue('F' . $count . '', $row['position_name2']);
            $sheet->setCellValue('G' . $count . '', $approved);
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $sheet->setCellValue('I' . $count . '', date('F j, Y', strtotime($row['date_available'])));
            $sheet->setCellValue('I' . $count . '', $row['nat_result']);
            $sheet->setCellValue('J' . $count . '', $status);
            $sheet->setCellValue('K' . $count . '', $row['f_assessor_name']);

            $count++;
            $emp_count++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        $filename = 'list-of-reserved-applicants'; // set filename for excel file to be exported
        header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');    // download file
    }

    public function print_reserved_applicant_pdf()
    {
        $applicant = $this->applicant_reserved->getApplicantReserved();
        $employee_row = [];
        $count = 1;
        foreach ($applicant as $row) {
            $status = $this->global->getApplicantStatusForReports($row['status']);
            $approved = $row['approved_position_name'] === null ? "N/A" : $row['approved_position_name'];
            $nat_result = $row['nat_result'] === null ? "N/A" : $row['nat_result'];
            $data = [
                "applicant_no" => $count,
                "applicant_code"  => $row['applicant_code'],
                "fullname"  => $row['full_name'],
                "address"   => $row['province_name'] . '' . $row['city_name'],
                "position_1"  => $row['position_name1'] === null ? "NA" : $row['position_name1'],
                "position_2"  => $row['position_name2'] === null ? "NA" : $row['position_name2'],
                "approved_position_name" => $approved,
                "bmi" => round($row['weight'] / $row['height'] / $row['height'] * 10000, 2),
                "date_available"  => date('F j, Y', strtotime($row['date_available'])),
                "nat_result" => $nat_result,
                "status"  => $status,
                "assessor_name"  => $row['f_assessor_name'] === null ? "NA" : $row['f_assessor_name']
            ];
            array_push($employee_row, $data);
            $count++;
        }
        $data = ['employee_row' => $employee_row];
        $filename = 'list-of-reserved-applicants'; // set filename for excel file to be exported
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [190, 236],
            'orientation' => 'P'
        ]);
        $html = $this->load->view('pdf/r_global_reports', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('' . $filename . '.pdf', "D");
    }
    //Reserved Applicant Report End


    //All Crew Report
    public function print_crew_xl($c_type)
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


        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/all_crew_report.xlsx');

        if ($c_type === "all") {
            $crew = $this->all_crew->getAllCrew($conditions);
        } elseif ($c_type === "new") {
            $crew = $this->new_crew->getNewCrew($conditions);
        } elseif ($c_type === "ex-crew") {
            $crew = $this->ex_crew->getExCrew($conditions);
        } elseif ($c_type === "nre") {
            $crew = $this->nre_crew->getCrewNotForRehire($conditions);
        }
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;

        foreach ($crew as $row) {

            $date_available = $row['date_available'] ? date("Y-m-d", strtotime($row['date_available'])) : "-";
            $contract_duration = $row['contract_duration'] ? date("Y-m-d", strtotime($row['contract_duration'])) : "-";

            $passport_validity = $this->crew_management->validate_passport_report($row['crew_code']);
            $licenses_validity = $this->crew_management->get_license_validity_report($row['crew_code']);
            $cert_validity = $this->crew_management->validate_certificates_report($row['crew_code']);

            $contract = $this->contracts->getCrewContract($row['crew_code']);
            $contract_contract_duration = "N/A";
            if (!empty($contract)) {
                $new_contract = $contract[0];
                $contract_contract_duration = $new_contract["contract_duration"];
            }
            $mlc_validity = $this->crew_management->get_mlc_validity_report($row['crew_code']);
            $medical_validity = $this->medical->get_medical_validity_report($row['crew_code']);
            $crew_status = $this->global->getCrewStatusReport($row['crew_status']);

            $sign_on = $row['sign_on'] ? date("Y-m-d", strtotime($row['sign_on'])) : "-";

            $sheet->setCellValue('A' . $count . '', $row['crew_code']);
            $sheet->setCellValue('B' . $count . '', $row['full_name']);
            $sheet->setCellValue('C' . $count . '', $row['position_name']);
            $sheet->setCellValue('D' . $count . '', $date_available);
            $sheet->setCellValue('E' . $count . '', $sign_on);
            $sheet->setCellValue('F' . $count . '', $contract_duration);
            $sheet->setCellValue('G' . $count . '', $passport_validity);
            $sheet->setCellValue('H' . $count . '', $licenses_validity);
            $sheet->setCellValue('I' . $count . '', $cert_validity);
            $sheet->setCellValue('J' . $count . '', $contract_contract_duration);
            $sheet->setCellValue('K' . $count . '', $mlc_validity);
            $sheet->setCellValue('L' . $count . '', $medical_validity);
            $sheet->setCellValue('M' . $count . '', $crew_status['status']);

            $count++;
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx

        $filename = 'list-of-' . $c_type . '-crews'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_crew_csv($c_type)
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


        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/all_crew_report.xlsx');

        if ($c_type === "all") {
            $crew = $this->all_crew->getAllCrew($conditions);
        } elseif ($c_type === "new") {
            $crew = $this->new_crew->getNewCrew($conditions);
        } elseif ($c_type === "ex-crew") {
            $crew = $this->ex_crew->getExCrew($conditions);
        } elseif ($c_type === "nre") {
            $crew = $this->nre_crew->getCrewNotForRehire($conditions);
        }

        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;

        foreach ($crew as $row) {

            $date_available = $row['date_available'] ? date("Y-m-d", strtotime($row['date_available'])) : "-";
            $sign_on = $row['sign_on'] ? date("Y-m-d", strtotime($row['sign_on'])) : "-";
            $contract_duration = $row['contract_duration'] ? date("Y-m-d", strtotime($row['contract_duration'])) : "-";

            $passport_validity = $this->crew_management->validate_passport_report($row['crew_code']);
            $licenses_validity = $this->crew_management->get_license_validity_report($row['crew_code']);
            $cert_validity = $this->crew_management->validate_certificates_report($row['crew_code']);

            $contract = $this->contracts->getCrewContract($row['crew_code']);
            $contract_contract_duration = "N/A";
            if (!empty($contract)) {
                $new_contract = $contract[0];
                $contract_contract_duration = $new_contract["contract_duration"];
            }
            $mlc_validity = $this->crew_management->get_mlc_validity_report($row['crew_code']);
            $medical_validity = $this->medical->get_medical_validity_report($row['crew_code']);
            $crew_status = $this->global->getCrewStatusReport($row['crew_status']);

            $sheet->setCellValue('A' . $count . '', $row['crew_code']);
            $sheet->setCellValue('B' . $count . '', $row['full_name']);
            $sheet->setCellValue('C' . $count . '', $row['position_name']);
            $sheet->setCellValue('D' . $count . '', $date_available);
            $sheet->setCellValue('E' . $count . '', $sign_on);
            $sheet->setCellValue('F' . $count . '', $contract_duration);
            $sheet->setCellValue('G' . $count . '', $passport_validity);
            $sheet->setCellValue('H' . $count . '', $licenses_validity);
            $sheet->setCellValue('I' . $count . '', $cert_validity);
            $sheet->setCellValue('J' . $count . '', $contract_contract_duration);
            $sheet->setCellValue('K' . $count . '', $mlc_validity);
            $sheet->setCellValue('L' . $count . '', $medical_validity);
            $sheet->setCellValue('M' . $count . '', $crew_status['status']);

            $count++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        $filename = 'list-of-' . $c_type . '-crews'; // set filename for excel file to be exported
        header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_all_crew_pdf($c_type)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/all_crew_report.xlsx');

        $sheet = $spreadsheet->getActiveSheet();

        if ($c_type === "all") {
            $crew = $this->all_crew->getAllCrew();
        } elseif ($c_type === "new") {
            $crew = $this->new_crew->getNewCrew();
        } elseif ($c_type === "withdrawal") {
            $crew = $this->withdrawal_crew->getWithdrawalCrew();
        } elseif ($c_type === "nre") {
            $crew = $this->nre_crew->getCrewNotForRehire();
        }

        $count = 2;

        foreach ($crew as $row) {
            $status = $this->global->getCrewStatusForReport($row['crew_status']);
            $sheet->setCellValue('A' . $count . '', $row['crew_code']);
            $sheet->setCellValue('B' . $count . '', $row['full_name']);
            $sheet->setCellValue('C' . $count . '', $status);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['date_available'] != NULL ? $row['date_available'] : "-");
            $sheet->setCellValue('F' . $count . '', $row['position_name'] != NULL ? $row['position_name'] : "-");
            $sheet->setCellValue('G' . $count . '', $row['vsl_name'] != NULL ? $row['vsl_name'] : "-");
            $sheet->setCellValue('H' . $count . '', round($row['weight'] / $row['height'] / $row['height'] * 10000, 2));
            $count++;
        }

        $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
        \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

        $filename = 'list-of-all-crews'; // set filename for excel file to be exported
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file 
    }
    //All Crew Report End

    //Onboarding
    public function print_onboarding_report($type)
    {
        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');
        $arr_search['search']['contract_search'] = $this->session->userdata('contract_search');
        $arr_search['search']['flight_search'] = $this->session->userdata('flight_search');
        $arr_search['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $arr_search['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/onboarding_crew_report.xlsx');
        $contract = $this->onboarding->getOnboardingCrew($arr_search);
        $this->m_backup_db->backup_reports("Onboarding Crew", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;

        foreach ($contract as $row) {
            $status = $this->global->getCrewStatusForReport($row['status']);

            $sheet->setCellValue('A' . $count . '', $row['crew_code']);
            $sheet->setCellValue('B' . $count . '', $row['full_name']);
            $sheet->setCellValue('C' . $count . '', $status);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . ' ' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name'] != NULL ? $row['position_name'] : "-");
            $sheet->setCellValue('F' . $count . '', $row['vsl_name'] != NULL ? $row['vsl_name'] : "-");
            $sheet->setCellValue('G' . $count . '', $row['embark_date'] != NULL ? $row['embark_date'] : "-");
            $sheet->setCellValue('H' . $count . '', $row['flight_code'] != NULL ? $row['flight_code'] : "-");
            $count++;
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Onboarding' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Onboarding' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Onboarding' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }
    //Onboarding End

    //For Reporting
    public function print_for_reporting_report($type)
    {
        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/all_crew_report.xlsx');
        $contract = $this->reporting->gerCrewReporting($arr_search);
        $this->m_backup_db->backup_reports("For Reporting", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;

        foreach ($contract as $row) {
            $status = $this->global->getCrewStatusForReport($row['status']);

            $sheet->setCellValue('A' . $count . '', $row['crew_code']);
            $sheet->setCellValue('B' . $count . '', $row['full_name']);
            $sheet->setCellValue('C' . $count . '', $row['position_name']);
            $sheet->setCellValue('D' . $count . '', $row['date_available'] != NULL ? $row['date_available'] : "-");
            $sheet->setCellValue('E' . $count . '', $row['sign_on'] != NULL ? $row['sign_on'] : "-");
            $sheet->setCellValue('F' . $count . '', $row['disembark'] != NULL ? $row['disembark'] : "-");
            $sheet->setCellValue('G' . $count . '', $this->validity_passport($row['crew_code']));
            $sheet->setCellValue('H' . $count . '', $this->crew_management->license_validity_text($row['crew_code']));
            $sheet->setCellValue('I' . $count . '', $this->validate_certificates($row['crew_code']));
            $sheet->setCellValue('J' . $count . '', $this->get_contract_validity($row['crew_code']));
            $sheet->setCellValue('K' . $count . '', $this->get_mlc_validity($row['crew_code']));
            $sheet->setCellValue('L' . $count . '', $this->medical->get_medical_validity_text($row['crew_code']));
            $sheet->setCellValue('L' . $count . '', $status);

            $count++;
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'For Reporting' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'For Reporting' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'For Reporting' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }
    //For Reporting End

    //Flight Monitoring
    public function print_flightmonitoring_report($type)
    {
        $arr_search = [];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/flight_monitoring_report.xlsx');
        // $contract = $this->flight_monitoring->Filterflights($arr_search);

        $flights = $this->global->getAllFlights();

        $this->m_backup_db->backup_reports("Flight Monitoring", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;

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

            $sheet->setCellValue('A' . $count . '', $count);
            $sheet->setCellValue('B' . $count . '', $vsl_name);
            $sheet->setCellValue('C' . $count . '', $flight_number);
            $sheet->setCellValue('D' . $count . '', $departure_country);
            $sheet->setCellValue('E' . $count . '', $departure_datetime);
            $sheet->setCellValue('F' . $count . '', $destination_country);
            $sheet->setCellValue('G' . $count . '', $destination_datetime);
            $sheet->setCellValue('H' . $count . '', $airfare);
            $sheet->setCellValue('I' . $count . '', $airline);
            $sheet->setCellValue('J' . $count . '', $option);
            $sheet->setCellValue('K' . $count . '', $total_crew_assigned);

            $count++;
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Flight Monitoring' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Flight Monitoring' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Flight Monitoring' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }
    //Flight Monitoring End

    //Watchlisted
    public function print_watchlisted_report($type)
    {
        $arr_search = [];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/flight_monitoring_report.xlsx');
        $contract = $this->watchlisted->getWatchlistReporting($arr_search);
        $this->m_backup_db->backup_reports("Watchlisted", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;

        foreach ($contract as $row) {

            $sheet->setCellValue('A' . $count . '', $row['crew_code']);
            $sheet->setCellValue('B' . $count . '', $row['full_name']);
            $sheet->setCellValue('C' . $count . '', $row['position_name'] != NULL ? $row['position_name'] : "-");
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['e_registration'] != NULL ? $row['e_registration'] : "-");
            $sheet->setCellValue('F' . $count . '', $row['vsl_name'] != NULL ? $row['vsl_name'] : "-");
            $sheet->setCellValue('G' . $count . '', $row['issued_by'] != NULL ? $row['issued_by'] : "-");
            $sheet->setCellValue('H' . $count . '', $row['remarks'] != NULL ? $row['remarks'] : "-");
            $sheet->setCellValue('I' . $count . '', $row['date_created'] != NULL ? $row['date_created'] : "-");

            $count++;
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Watchlisted' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Watchlisted' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Watchlisted' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }
    //Watchlisted End


    //Withdrawal Crew Report
    public function print_withdraw_crew($type)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/withdraw_crew_reports.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $crew = $this->withdrawal_crew->getTransferCompanyCrew();
        $count = 2;

        foreach ($crew as $row) {

            $sheet->setCellValue('A' . $count . '', $row['crew_code']);
            $sheet->setCellValue('B' . $count . '', $row['full_name']);
            $sheet->setCellValue('C' . $count . '', $row['position_name']);
            $sheet->setCellValue('D' . $count . '', $row['vsl_name']);
            $sheet->setCellValue('E' . $count . '', $row['date_created']);
            $sheet->setCellValue('F' . $count . '', $row['issued_by']);
            $sheet->setCellValue('G' . $count . '', $row['remarks']);

            $count++;
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Withdrawal' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Withdrawal' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Withdrawal' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }
    //Withdrawal Crew Report End

    //Warning Letter Crew Report
    public function print_warning_letter_crew($type)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/withdraw_crew_reports.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $crew = $this->withdrawal_crew->getTransferCompanyCrew();
        $count = 2;

        foreach ($crew as $row) {

            $sheet->setCellValue('A' . $count . '', $row['crew_code']);
            $sheet->setCellValue('B' . $count . '', $row['full_name']);
            $sheet->setCellValue('C' . $count . '', $row['position_name']);
            $sheet->setCellValue('D' . $count . '', $row['vsl_name']);
            $sheet->setCellValue('E' . $count . '', $row['date_created']);
            $sheet->setCellValue('F' . $count . '', $row['issued_by']);
            $sheet->setCellValue('G' . $count . '', $row['remarks']);

            $count++;
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Warning Letter' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Warning Letter' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Warning Letter' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }
    //Warning Letter Report End

    //Evaluation Report
    public function print_evaluation_applicant_pdf($applicant_code)
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_evaluation_form_report.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $info = $this->applicant_interview->getApplicantInterviewReport($applicant_code);
        $count = 13;
        $details_count = 13;
        $sheet_info = $this->applicant_interview->getEvaluationSheet($applicant_code);
        $crewInfo = $this->global->getApplicantInformation($applicant_code);

        if (!empty($sheet_info)) {
            $details = json_decode($sheet_info['details']);
            $scores = json_decode($sheet_info['scores']);
            $vessel = $info['vsl_name'] === null ? "--" : $info['vsl_name'];

            $sheet->setCellValue('B3', $vessel);
            $sheet->setCellValue('B4', strtoupper($info['approved_position']));
            $sheet->setCellValue('B5', $info['full_name']);
            $sheet->setCellValue('B6', $info['nationality']);
            $sheet->setCellValue('A10', $this->global->getAge($crewInfo['birth_date']));
            $sheet->setCellValue('B10', $sheet_info['total_board']);
            $sheet->setCellValue('C10', $sheet_info['same_ship']);
            $sheet->setCellValue('D10', $sheet_info['short_board']);
            $sheet->setCellValue('E10', $sheet_info['mixed_crew']);
            $sheet->setCellValue('F10', round($crewInfo['weight'] / $crewInfo['height'] / $crewInfo['height'] * 10000, 2));
            $sheet->setCellValue('G10', $sheet_info['interview']);
            $sheet->setCellValue('G36', $sheet_info['additional_score']);
            $sheet->setCellValue('G37', $sheet_info['substract_score']);
            $sheet->setCellValue('G38', $sheet_info['additional_score'] + $sheet_info['substract_score']);

            if ($details) {
                foreach ($details as $key) {
                    $sheet->setCellValue('F' . $details_count . '', $key);
                    $details_count++;
                }
            }
            if ($scores) {
                foreach ($scores as $key) {
                    $sheet->setCellValue('G' . $count . '', $key);
                    $count++;
                }
            }
        }

        $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
        \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

        $filename = $info['full_name'] . '_Evaluation_Sheet'; // set filename for excel file to be exported
        header('Content-Disposition: attachment; filename="' . $filename . '.pdf"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function print_evaluation_applicant_xl($applicant_code)
    {
        $info = $this->applicant_interview->getApplicantInterviewReport($applicant_code);
        $count = 13;
        $detailscount = 13;
        $sheet_info = $this->applicant_interview->getEvaluationSheet($applicant_code);
        $crewInfo = $this->global->getApplicantInformation($applicant_code);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/r_evaluation_form_report.xlsx');
        $sheet = $spreadsheet->getActiveSheet();

        if (!empty($sheet_info)) {
            $details = json_decode($sheet_info['details']);
            $scores = json_decode($sheet_info['scores']);
            $vessel = $info['vsl_name'] === null ? "--" : $info['vsl_name'];

            $sheet->setCellValue('B3',  $vessel);
            $sheet->setCellValue('B4',  strtoupper($info['approved_position']));
            $sheet->setCellValue('B5',  $info['full_name']);
            $sheet->setCellValue('B6',  $this->global->getNationalityById($info['nationality'])['description']);
            $sheet->setCellValue('A10', $this->global->getAge($crewInfo['birth_date']));
            $sheet->setCellValue('B10', $sheet_info['total_board']);
            $sheet->setCellValue('C10', $sheet_info['same_ship']);
            $sheet->setCellValue('D10', $sheet_info['short_board']);
            $sheet->setCellValue('E10', $sheet_info['mixed_crew']);
            $sheet->setCellValue('F10', round($crewInfo['weight'] / $crewInfo['height'] / $crewInfo['height'] * 10000, 2));
            $sheet->setCellValue('G10', $sheet_info['interview']);
            $sheet->setCellValue('G36', $sheet_info['additional_score']);
            $sheet->setCellValue('G37', $sheet_info['substract_score']);
            $sheet->setCellValue('G38', $sheet_info['additional_score'] + $sheet_info['substract_score']);

            if ($details) {
                foreach ($details as $key) {
                    $sheet->setCellValue('F' . $detailscount . '', $key);
                    $detailscount++;
                }
            }
            if ($scores) {
                foreach ($scores as $key) {
                    $sheet->setCellValue('G' . $count . '', $key);
                    $count++;
                }
            }
        }

        /*  */
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = $info['full_name'] . '_Evaluation_Sheet'; // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');    // download file

    }

    //Evaluation Report End


    //Warning Letter Report
    public function print_xl_report($code = null, $search = null)
    {

        $conditions = [];

        $conditions['search']['search_table'] = $code;
        $conditions['search']['search_filter'] = $search;

        if ($code === "watch_listed") {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('assets/reports/watch_list.xlsx');
        } else {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('assets/reports/warning_letter.xlsx');
        }

        $crew = $this->report->getGeneralReport($conditions);

        $sheet = $spreadsheet->getActiveSheet();

        $count = 3;
        if (!empty($crew)) {
            foreach ($crew as $row) {

                $position = $this->global->getPosition($row['rank']);
                $vessel = $this->global->getVesselById($row['vessel']);
                $department = $this->global->getDepartmentById($row['department']);

                $sheet->setCellValue('A' . $count . '', $row['id']);
                $sheet->setCellValue('B' . $count . '', $row['crew_name']);
                $sheet->setCellValue('C' . $count . '', $position['position_name']);
                $sheet->setCellValue('D' . $count . '', $vessel['vsl_name']);
                if ($code === "watch_listed") {
                    $sheet->setCellValue('E' . $count . '', $row['certificates']);
                    $sheet->setCellValue('F' . $count . '', $row['e_registration']);
                    $sheet->setCellValue('G' . $count . '', date('M j, Y', strtotime($row['date_created'])));
                    $sheet->setCellValue('H' . $count . '', (($row['issued_by'] === null) ? "Something Went Wrong" : $this->global->getAccountDetails($row['issued_by']))['full_name']);
                    $sheet->setCellValue('I' . $count . '', $row['remarks']);
                } else {
                    $sheet->setCellValue('E' . $count . '', date('M j, Y', strtotime($row['date_created'])));
                    $sheet->setCellValue('F' . $count . '', (($row['issued_by'] === null) ? "Something Went Wrong" : $this->global->getAccountDetails($row['issued_by']))['full_name']);
                    $sheet->setCellValue('G' . $count . '', $this->global->getWatchlistStatus($row['remarks'], "warning_letter"));
                }
                $count++;
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx

            $filename = $code . '_report'; // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.Xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');    // download file
        } else {
            return false;
        }
    }

    public function print_csv_report($code = null, $search = null)
    {
        $conditions = [];

        $conditions['search']['search_table'] = $code;
        $conditions['search']['search_filter'] = $search;

        if ($code === "watch_listed") {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('assets/reports/watch_list.xlsx');
        } else {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('assets/reports/warning_letter.xlsx');
        }
        $crew = $this->report->getGeneralReport($conditions);
        $sheet = $spreadsheet->getActiveSheet();

        $count = 3;
        if (!empty($crew)) { //Condition if not value is fetched
            foreach ($crew as $row) {

                $position = $this->global->getPosition($row['rank']);
                $vessel = $this->global->getVesselById($row['vessel']);
                $department = $this->global->getDepartmentById($row['department']);

                $sheet->setCellValue('A' . $count . '', $row['id']);
                $sheet->setCellValue('B' . $count . '', $row['crew_name']);
                $sheet->setCellValue('C' . $count . '', $position['position_name']);
                $sheet->setCellValue('D' . $count . '', $vessel['vsl_name']);
                if ($code === "watch_listed") {
                    $sheet->setCellValue('E' . $count . '', $row['certificates']);
                    $sheet->setCellValue('F' . $count . '', $row['e_registration']);
                    $sheet->setCellValue('G' . $count . '', date('M j, Y', strtotime($row['date_created'])));
                    $sheet->setCellValue('H' . $count . '', (($row['issued_by'] === null) ? "Something Went Wrong" : $this->global->getAccountDetails($row['issued_by']))['full_name']);
                    $sheet->setCellValue('I' . $count . '', $row['remarks']);
                } else {
                    $sheet->setCellValue('E' . $count . '', date('M j, Y', strtotime($row['date_created'])));
                    $sheet->setCellValue('F' . $count . '', (($row['issued_by'] === null) ? "Something Went Wrong" : $this->global->getAccountDetails($row['issued_by']))['full_name']);
                    $sheet->setCellValue('G' . $count . '', $this->global->getWatchlistStatus($row['remarks'], "warning_letter"));
                }
                $count++;
            }
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setSheetIndex(0);

            $filename = $code . '_report'; // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');    // download file
        } else {
?>
            <script type="text/javascript">
                $(document).ready(function() {
                    swal({
                        title: "Done",
                        text: "test",
                        timer: 1500,
                        showConfirmButton: false,
                        type: 'success'
                    });
                });
            </script>
<?php
            redirect(base_url() . 'crew-watchlisted');
        }
    }

    public function print_pdf_report($code = null, $search = null)
    {
        $conditions = [];

        $conditions['search']['search_table'] = $code;
        $conditions['search']['search_filter'] = $search;

        if ($code === "watch_listed") {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('assets/reports/watch_list.xlsx');
        } else {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('assets/reports/warning_letter.xlsx');
        }
        $crew = $this->report->getGeneralReport($conditions);

        $sheet = $spreadsheet->getActiveSheet();

        $count = 3;
        if (!empty($crew)) {
            foreach ($crew as $row) {

                $position = $this->global->getPosition($row['rank']);
                $vessel = $this->global->getVesselById($row['vessel']);
                $department = $this->global->getDepartmentById($row['department']);

                $sheet->setCellValue('A' . $count . '', $row['id']);
                $sheet->setCellValue('B' . $count . '', $row['crew_name']);
                $sheet->setCellValue('C' . $count . '', $position['position_name']);
                $sheet->setCellValue('D' . $count . '', $vessel['vsl_name']);
                if ($code === "watch_listed") {
                    $sheet->setCellValue('E' . $count . '', $row['certificates']);
                    $sheet->setCellValue('F' . $count . '', $row['e_registration']);
                    $sheet->setCellValue('G' . $count . '', date('M j, Y', strtotime($row['date_created'])));
                    $sheet->setCellValue('H' . $count . '', (($row['issued_by'] === null) ? "Something Went Wrong" : $this->global->getAccountDetails($row['issued_by']))['full_name']);
                    $sheet->setCellValue('I' . $count . '', $row['remarks']);
                } else {
                    $sheet->setCellValue('E' . $count . '', date('M j, Y', strtotime($row['date_created'])));
                    $sheet->setCellValue('F' . $count . '', (($row['issued_by'] === null) ? "Something Went Wrong" : $this->global->getAccountDetails($row['issued_by']))['full_name']);
                    $sheet->setCellValue('G' . $count . '', $this->global->getWatchlistStatus($row['remarks'], "warning_letter"));
                }
                $count++;
            }

            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = $code . '_report'; // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');    // download file
        } else {
            return false;
        }
    }
    //Warning Letter Report End


    //Technical Report
    public function print_technical_form($app_code, $print_type)
    {
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '228B22'),
                'size'  => 20,
                'name'  => 'Wingdings'
            )
        );

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/R_TECHNICAL_FORM_NEW.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $info = $this->applicant_interview->getApplicantInterviewReport($app_code);
        $info_general = $this->global->getTechnicalInterviews($app_code);
        $count = 3;
        $remark_count = 3;

        if ($info_general['scores']) {
            $scores = json_decode($info_general['scores']);
        }
        if ($info_general['remarks']) {
            $remarks = json_decode($info_general['remarks']);
        }

        $position = $info['approved_position'] === null ? "N/A" : $info['approved_position'];
        $vessel = $info['vsl_name'] === null ? "N/A" : $info['vsl_name'];
        $bmi = $info['weight'] === null ? "N/A" : round($info['weight'] / $info['height'] / $info['height'] * 10000, 2);
        $date_available = $info['date_available'] === null ? "N/A" : $info['date_available'];

        $sheet->setCellValue('A1', $info['full_name']);
        $sheet->setCellValue('B1', strtoupper($position));
        $sheet->setCellValue('D1', $vessel);

        if ($info_general) {
            $sheet->setCellValue('F1', 'BMI: ' . $bmi);
            $sheet->setCellValue('G1', 'Date Available:' . date('F j, Y', strtotime($date_available)));
            if ($scores) {
                foreach ($scores as $row) {
                    $sheet->setCellValue('B' . $count . '', $row);
                    if ($row === 10) {
                        $sheet->setCellValue('C' . $count . '', '✓');
                        $sheet->getStyle('C' . $count . '')->applyFromArray($styleArray);
                    } else if ($row === 5) {
                        $sheet->setCellValue('E' . $count . '', '✓');
                        $sheet->getStyle('E' . $count . '')->applyFromArray($styleArray);
                    } else if ($row === 8) {
                        $sheet->setCellValue('E' . $count . '', '✓');
                        $sheet->getStyle('E' . $count . '')->applyFromArray($styleArray);
                    } else if ($row === 5) {
                        $sheet->setCellValue('E' . $count . '', '✓');
                        $sheet->getStyle('E' . $count . '')->applyFromArray($styleArray);
                    }
                    $count++;
                }
            }

            if ($remarks) {
                foreach ($remarks as $rem) {
                    $sheet->setCellValue('G' . $remark_count . '', $rem);
                    $remark_count++;
                }
            }
            $sheet->setCellValue('C23', $info_general['total_score']);
            $sheet->setCellValue('C25', $info_general['final_result']);
        }

        $filename = $info['full_name'] . '_Technical_Interview'; // set filename for excel file to be exported

        if ($print_type === "xl") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
        }
        $writer->save('php://output');    // download file

    }

    public function print_employed_form($app_code, $print_type)
    {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/FORM_FOR_NEWLY_EMPLOYED_CREW.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $info = $this->applicant_interview->getApplicantInterviewReport($app_code);
        $info_general = $this->global->getEmployedCrew($app_code);
        $education = $this->global->getEducationalAttainment($app_code);
        $kin = $this->global->getNextOfKin($app_code);

        $position = $info['approved_position'] === null ? "N/A" : $info['approved_position'];
        $vessel = $info['vsl_name'] === null ? "N/A" : $info['vsl_name'];
        $bmi = $info['weight'] === null ? "N/A" : round($info['weight'] / $info['height'] / $info['height'] * 10000, 2);
        $date_available = $info['date_available'] === null ? "N/A" : $info['date_available'];
        $status = $info['civil_status'] === 2 || $info['civil_status'] === 5 ? "YES" : "NO";

        $sheet->setCellValue('C3', $info['full_name']);
        $sheet->setCellValue('B3', strtoupper($position));
        $sheet->setCellValue('A3', $vessel);
        if ($info_general) {
            $sheet->setCellValue('B5', strtoupper($info_general['check_point']));
            $sheet->setCellValue('B6', strtoupper($info_general['service_record_ttl']));
            $sheet->setCellValue('B7', strtoupper($info_general['service_record_rank']));
            $sheet->setCellValue('B8', strtoupper($info_general['previous_manning_company']));
            $sheet->setCellValue('B9', $info_general['reputation']);
            $sheet->setCellValue('B10', date('F j, Y', strtotime($info['birth_date'])));
            $sheet->setCellValue('B11', $info_general['transfer']);
            $sheet->setCellValue('B12', $info_general['carrier']);
            $sheet->setCellValue('B13', $info_general['experience_with_korean_crew']);
            $sheet->setCellValue('B14', $bmi);
            $sheet->setCellValue('B15', $info_general['history_of_past_injuries']);
            $sheet->setCellValue('B16', $info_general['history_of_past_diseases']);
            $sheet->setCellValue('B17', $info_general['leave_of_absence']);
            $sheet->setCellValue('B18', $info_general['short_contract']);
            $sheet->setCellValue('B19', $education['school']);
            $sheet->setCellValue('B20', $status);
            $sheet->setCellValue('B21', $kin['no_of_children']);
            $sheet->setCellValue('B22', $info_general['appearance']);
            $sheet->setCellValue('B23', $info_general['first_interview_result']);
            $sheet->setCellValue('B24', $info_general['second_interview_result']);
        }

        $filename = $info['full_name'] . '_New_Employed_Form'; // set filename for excel file to be exported

        if ($print_type === "xl") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
        }
        ob_end_clean();
        $writer->save('php://output');    // download file

    }

    public function print_interview_form($app_code, $print_type)
    {
        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '228B22'),
                'size'  => 20,
                'name'  => 'Wingdings'
            )
        );

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/recruitment/INTERVIEW_SHEET_FORM.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $info = $this->applicant_interview->getApplicantInterviewReport($app_code);
        $sea_service = $this->global->getSeaServiceRecord($app_code);
        $technical_score = $this->global->getTechnicalInterviews($app_code);
        $general_score = $this->global->getGeneralInterviews($app_code);

        $exp_vt = "";
        $position = $info['approved_position'] === null ? "N/A" : $info['approved_position'];
        $vessel = $info['vsl_name'] === null ? "N/A" : $info['vsl_name'];
        $bmi = $info['weight'] === null ? "N/A" : round($info['weight'] / $info['height'] / $info['height'] * 10000, 2);
        $date_available = $info['date_available'] === null ? "N/A" : $info['date_available'];
        $status = $info['civil_status'] === 2 || $info['civil_status'] === 5 ? "YES" : "NO";
        $age_limit = $info['age_limit'] === 1 ? "Suitable" : "Not Suitable";
        $license_certification = $info['license_certification'] === 1 ? "Suitable" : "Not Suitable";
        $physical_exam = $info['physical_exam'] === 1 ? "Suitable" : "Not Suitable";
        $ability_eng = $info['ability_eng'] === 1 ? "Suitable" : "Not Suitable";
        if ($info['exp_analysis_vt'] === 1) {
            $exp_vt = "Suitable";
        } else if ($info['exp_analysis_vt'] === 2) {
            $exp_vt = "Not Suitable";
        } else {
            $exp_vt = "Not Applicable";
        }

        $previous_position = json_decode($sea_service['rank'], 'true');
        $type_vessel = json_decode($sea_service['type_of_vsl_eng'], 'true');
        $embarked = json_decode($sea_service['embarked'], 'true');
        $disembarked = json_decode($sea_service['disembarked'], 'true');
        $total_service = json_decode($sea_service['total_service'], 'true');

        if ($info) {
            $sheet->setCellValue('A8', $info['req_no_crew']);
            $sheet->setCellValue('D8', $info['present_no_crew']);
            $sheet->setCellValue('G8', $info['excess_shortage']);
            $sheet->setCellValue('A12', $info['korean_name']);
            $sheet->setCellValue('D12', $info['chinese_name']);
            $sheet->setCellValue('C4', strtoupper($position));
            $sheet->setCellValue('C5', $vessel);
            $sheet->setCellValue('G12', $info['full_name']);
            $sheet->setCellValue('A14', date('F j, Y', strtotime($info['birth_date'])));
            $sheet->setCellValue('G14', $previous_position[0]);
            $sheet->setCellValue('H19', $total_service[0]);
            $sheet->setCellValue('D22', $exp_vt);
            $sheet->setCellValue('D23', $age_limit);
            $sheet->setCellValue('D24', $license_certification);
            $sheet->setCellValue('D25', $physical_exam);
            $sheet->setCellValue('D26', $ability_eng);
            $sheet->setCellValue('D27', $info ? $info['assess_prev_company'] : "-");
            $sheet->setCellValue('C31', $general_score ? $general_score['total_score'] : "-");
            $sheet->setCellValue('D31', $general_score ? $general_score['final_result'] : "-");
            $sheet->setCellValue('E31', $general_score ? $general_score['final_remark'] : "-");
            $sheet->setCellValue('H31', $general_score != null ? $this->global->GetAsessorFullName($general_score['assessed_by'])->fullname : "- -");
            $sheet->setCellValue('C32', $technical_score ? $technical_score['total_score'] : "-");
            $sheet->setCellValue('D32', $technical_score ? $technical_score['final_result'] : "-");
            $sheet->setCellValue('E32', $technical_score ? $technical_score['final_remark'] : "-");
            $sheet->setCellValue('H32', $technical_score['assessed_by'] != null ? $this->global->GetAsessorFullName($technical_score['assessed_by'])->fullname : "- -");
            $sheet->setCellValue('A36', $position ? strtoupper($position) : "-");
            $sheet->setCellValue('D36', $info['seniority'] ? $info['seniority'] : "-");
            $sheet->setCellValue('G36', $vessel ? $vessel : "-");

            $sheet->setCellValue('C39', $info['first_assessor'] != null ? $this->global->GetAsessorFullName($info['first_assessor'])->fullname : "- -");
            $sheet->setCellValue('D39', $info['first_decision']) === "1" ? "Approved" : "Disapproved";
            $sheet->setCellValue('G39', $info['first_remarks'] ? $info['first_remarks'] : "-");
            $sheet->setCellValue('C40', $info['second_assessor'] != null ? $this->global->GetAsessorFullName($info['second_assessor'])->fullname : "- -");
            $sheet->setCellValue('D40', $info['second_decision']) === "1" ? "Approved" : "Disapproved";
            $sheet->setCellValue('G40', $info['second_remarks'] ? $info['second_remarks'] : "-");
            $sheet->setCellValue('C41', $info['final_assessor'] != null ? $this->global->GetAsessorFullName($info['final_assessor'])->fullname : "- -");
            $sheet->setCellValue('D41', $info['final_decision'] ? $info['final_decision'] : "-");
            $sheet->setCellValue('G41', $info['final_remarks'] ? $info['final_remarks'] : "-");

            if ($type_vessel) {
                foreach ($type_vessel as $key) {
                    $sheet->setCellValue('C17', $key);
                    $sheet->setCellValue('D17', $key);
                    $sheet->setCellValue('E17', $key);
                    $sheet->setCellValue('F17', $key);
                }
            } else {
                $sheet->setCellValue('G17', '✓');
                $sheet->getStyle('G17')->applyFromArray($styleArray);
            }
            if ($previous_position) {
                foreach ($previous_position as $key) {
                    $sheet->setCellValue('C18', $key);
                    $sheet->setCellValue('D18', $key);
                    $sheet->setCellValue('E18', $key);
                    $sheet->setCellValue('F18', $key);
                }
            } else {
                $sheet->setCellValue('G18', '✓');
                $sheet->getStyle('G18')->applyFromArray($styleArray);
            }

            if ($embarked && $disembarked) {
                foreach ($embarked as $key) {
                    foreach ($disembarked as $row) {
                        $sheet->setCellValue('C19', $this->global->getDateDuration($key, $row));
                        $sheet->setCellValue('D19', $this->global->getDateDuration($key, $row));
                        $sheet->setCellValue('E19', $this->global->getDateDuration($key, $row));
                        $sheet->setCellValue('F19', $this->global->getDateDuration($key, $row));
                    }
                }
            } else {
                $sheet->setCellValue('G19', '✓');
                $sheet->getStyle('G19')->applyFromArray($styleArray);
            }
        }

        $filename = $info['full_name'] . '_New_Employed_Form'; // set filename for excel file to be exported

        if ($print_type === "xl") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
        }
        ob_end_clean();
        $writer->save('php://output');    // download file

    }
    //Report End


    public function validity_passport($crew_code)
    {
        $passport = $this->global->getListLicenses($crew_code);
        $name = $this->global->getApplicantInformation($crew_code);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];

        $passport_validity = "";


        if ($passport) {
            $lebi = json_decode($passport['lebi']);
            $expiry_date = json_decode($passport['expiry_date']);

            for ($i = 0; $i < count($lebi); $i++) {
                if ($lebi[$i] === "6") {
                    $index = array_search($lebi[$i], $lebi);

                    if (empty($expiry_date[$index])) {
                        $passport_validity .= 'N/A';
                    } else {
                        $passport_date = date('Y-m-d', strtotime($expiry_date[$index]));
                        $pass_date = strtotime($passport_date);
                        $curr_date = strtotime(date('Y-m-d'));
                        if ($pass_date > $curr_date) {
                            $passport_validity .= 'VALID';
                        } else {
                            $passport_validity .= 'EXPIRED';
                        }
                    }
                }
            }
        } else {
            $passport_validity .= 'N/A';
        }
        return $passport_validity;
    }

    public function validate_certificates($crew_code)
    {
        $certificates = $this->global->getCertificates($crew_code);
        $cerificate_validity = "";

        if (!$certificates) {
            $cerificate_validity .= 'N/A';
        } else {
            $cop_number = json_decode($certificates['number']);
            $cerificate_count = array_map(function ($x) {
                if ($x) {
                    return 1;
                } else {
                    return 0;
                }
            }, $cop_number);
            if (empty(array_count_values($cerificate_count)[0])) {
                $cerificate_validity = 'COMPLETED';
            } else {
                if (array_count_values($cerificate_count)[0] > 0) {
                    $cerificate_validity = 'INCOMPLETE';
                }
            }
        }
        return $cerificate_validity;
    }

    public function get_contract_validity($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];

        $contract = $this->contracts->getCrewContract($crew_code);
        $contract_validity = "";

        if ($contract) {
            foreach ($contract as $row) {
                $contract_duration = strtotime($row['contract_duration']);
                if (!empty($contract_duration)) {
                    $current_date = strtotime(date('Y-m-d'));

                    $diff = $contract_duration - $current_date;
                    $date_diff = round($diff / (60 * 60 * 24));

                    if ($date_diff >= 60) {
                        $contract_validity .= 'VALID';
                    } else if ($date_diff >= 1 && $date_diff <= 60) {
                        $contract_validity .= 'NEAR TO EXPIRE';
                    } else if ($date_diff <= 0) {
                        $contract_validity .= 'EXPIRED';
                    }
                } else {
                    $contract_validity .= 'N/A';
                }
            }
        } else {
            $contract_validity .= 'N/A';
        }

        return $contract_validity;
    }

    public function get_mlc_validity($crew_code)
    {
        $mlc = $this->contracts->getCrewMlcById($crew_code);
        $name = $this->global->getApplicantInformation($crew_code);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];

        $contract_validity = "";

        if ($mlc) {
            $contract_validity .= "VALID";
        } else {
            $contract_validity .= "N/A";
        }

        return $contract_validity;
    }
}
 /* End of file Reports.php */
