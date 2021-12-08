<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Writer\Pdf;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use Mpdf\Mpdf;

class Report_Manager extends CI_Controller
{

    public function print_cmp_report($searches)
    {
        $decoded = urldecode($searches);
        $arr_search = json_decode($decoded, true);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/Crew Management Plan.xlsx');
        $cmp = $this->crew_management->FilterCMP($arr_search);
        $this->m_backup_db->backup_reports("Crew Management Plan (Summary)", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $nr = 1;
        $cell_count = 4;

        if ($cmp) {
            foreach ($cmp as $row) {

                $reliever_code = $this->global->getCrew($row['insigner']);
                $reliever_name = $reliever_code['crew_code'] != NULL ? $this->global->GetCrewFullName($reliever_code['crew_code'])->full_name : "-";

                $sheet->setCellValue('A' . $cell_count . '', $nr);
                $sheet->setCellValue('B' . $cell_count . '', $row['cmp_code']);
                $sheet->setCellValue('C' . $cell_count . '', $row['vsl_name']);
                $sheet->setCellValue('D' . $cell_count . '', $row['position_name']);
                $sheet->setCellValue('E' . $cell_count . '', $row['full_name']);
                $sheet->setCellValue('F' . $cell_count . '', $row['sign_on']);
                $sheet->setCellValue('G' . $cell_count . '', $row['contract_duration']);
                $sheet->setCellValue('H' . $cell_count . '', $row['months_onboard']);
                $sheet->setCellValue('I' . $cell_count . '', $row['date_x']);
                $sheet->setCellValue('J' . $cell_count . '', $row['x_port']);
                $sheet->setCellValue('M' . $cell_count . '', $reliever_name);
                $sheet->setCellValue('N' . $cell_count . '', $row['remarks']);
                $cell_count++;
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'CrewManagementPlan(Summary)' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_daily_departure($searches)
    {
        $decoded = urldecode($searches);
        $arr_search = json_decode($decoded, true);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/Crew Daily Departure Report.xlsx');
        $daily = $this->flight_monitoring->Filterflights($arr_search);
        $this->m_backup_db->backup_reports("Crew Daily Departure", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $cell_count = 3;
        $on_signer_pos = "-";
        $reliever_name = "-";

        if ($daily) {
            foreach ($daily as $row) {
                if ($row['insigner']) {
                    $reliever_code = $this->global->getCrew($row['insigner']);
                    $reliever_name = $reliever_code['crew_code'] != NULL ? $this->global->GetCrewFullName($reliever_code['crew_code'])->full_name : "-";
                    $on_signer_pos = $reliever_code['crew_code'] != NULL ? $this->global->getPosition($reliever_code['position'])['position_name'] : "-";
                }
                $coc = json_decode($row['number'], true);

                $sheet->setCellValue('A' . $cell_count . '', $row['vsl_name'] ? $row['vsl_name'] : "-");
                $sheet->setCellValue('B' . $cell_count . '', $on_signer_pos);
                $sheet->setCellValue('C' . $cell_count . '', $reliever_name);
                $sheet->setCellValue('D' . $cell_count . '', $row['birth_date'] ? date('F j, Y', strtotime($row['birth_date'])) : "-");
                $sheet->setCellValue('E' . $cell_count . '', $row['departure_datetime'] ? date('F j, Y', strtotime($row['departure_datetime'])) : "-");
                $sheet->setCellValue('F' . $cell_count . '', $row['departure_country']);
                $sheet->setCellValue('G' . $cell_count . '', $row['position_name'] ? $row['position_name'] : "-");
                $sheet->setCellValue('H' . $cell_count . '', $row['full_name']);
                $sheet->setCellValue('I' . $cell_count . '', $coc[1]);
                $sheet->setCellValue('J' . $cell_count . '', $row['remarks']);
                $cell_count++;
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'Crew Daily Departure' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_us_visa_report()
    {
        $arr_search['search']['type'] = $this->input->post('r_filter_by_type');
        $arr_search['search']['position'] = $this->input->post('r_filter_by_pos');
        $arr_search['search']['vessel'] = $this->input->post('r_filter_by_vessel');
        $arr_search['search']['disembarked_from'] = $this->input->post('r_date_from');
        $arr_search['search']['disembarked_to'] = $this->input->post('r_date_to');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/US_VISA_STATUS_OF_CREW_ON_VACATION.xlsx');
        $usvisa = $this->m_crew_arc->FilterLicenses($arr_search);
        $this->m_backup_db->backup_reports("US VISA STATUS", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $cell_count = 4;
        $status = "";
        $test = json_decode($usvisa, true);
        $count = 1;

        if ($usvisa) {
            foreach ($test as $value) {
                $eto[$count] = $value;
                foreach ($eto[$count] as $v) {

                    $positions = $this->position->getPositionID($v['position']);

                    $disembark = $this->m_crew_arc->getCrewArcCMP($v['monitor_code']);
                    if ($disembark) {
                        $disembark_date = $disembark['disembark'];
                    }
                    $visa = $this->m_crew_arc->getCrewArcLicense($v['crew_code']);
                    if ($visa) {
                        $expiry_date = $visa['expiry_date'];
                        if ($expiry_date[8] <= date('Y-m-d')) {
                            $status = "Expired" . '' . date('F j, Y', strtotime($expiry_date[8]));
                        } else {
                            $status = "Valid" . '' . date('F j, Y', strtotime($expiry_date[8]));
                        }
                    }

                    $sheet->setCellValue('A' . $cell_count . '', $count);
                    $sheet->setCellValue('B' . $cell_count . '', $this->global->GetCrewFullName($v['crew_code'])->full_name);
                    $sheet->setCellValue('C' . $cell_count . '', $this->global->getVesselById($v['vessel_assign'])['vsl_name']);
                    $sheet->setCellValue('D' . $cell_count . '', $disembark_date ? date('F j, Y', strtotime($disembark_date)) : "-");
                    $sheet->setCellValue('E' . $cell_count . '', $status ? $status : " - ");
                    $sheet->setCellValue('F' . $cell_count . '', $positions['position_name']);

                    $cell_count++;
                    $count++;
                }
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'US Visa Status' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_on_off_signer_report()
    {
        $arr_search['search']['type'] = $this->input->post('r_filter_by_type');
        $arr_search['search']['position'] = $this->input->post('r_filter_by_pos');
        $arr_search['search']['vessel'] = $this->input->post('r_filter_by_vessel');
        $arr_search['search']['signon_date'] = $this->input->post('r_signon_date');
        $arr_search['search']['signoff_date'] = $this->input->post('r_signoff_date');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/ON_OFF_SIGNERS.xlsx');
        $onoff = $this->crew_management->FilterCMP($arr_search);
        $this->m_backup_db->backup_reports("ON_OFF Signer", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $cell_count = 3;

        if ($onoff) {
            foreach ($onoff as $key) {
                $sheet->setCellValue('A' . $cell_count . '', $key['offsigner']);
                $sheet->setCellValue('B' . $cell_count . '', $key['cmp_code']);
                $sheet->setCellValue('C' . $cell_count . '', $key['full_name']);
                $sheet->setCellValue('D' . $cell_count . '', $key['position_name']);
                $sheet->setCellValue('E' . $cell_count . '', $key['vsl_name']);
                $sheet->setCellValue('F' . $cell_count . '', date('F j, Y', strtotime($key['embark'])));
                $sheet->setCellValue('G' . $cell_count . '', date('F j, Y', strtotime($key['disembark'])));
                $sheet->setCellValue('H' . $cell_count . '', $key['remarks']);
                $cell_count++;
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'ON_OFF Signer' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_panama_monitoring_report()
    {
        $arr_search['search']['type'] = $this->input->post('r_filter_by_type');
        $arr_search['search']['position'] = $this->input->post('r_filter_by_pos');
        $arr_search['search']['vessel'] = $this->input->post('r_filter_by_vessel');
        $arr_search['search']['license'] = $this->input->post('r_type_of_license');
        $arr_search['search']['joining_date_from'] = $this->input->post('r_expiry_date_from');
        $arr_search['search']['joining_date_to'] = $this->input->post('r_expiry_date_to');


        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/PANAMA_MONITORING_RECORD.xlsx');
        $panama = $this->license->getPanamaReport($arr_search);
        $this->m_backup_db->backup_reports("PANAMA Monitoring", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $cell_count = 7;
        $count = 1;

        if ($panama) {
            foreach ($panama as $key) {

                $numbers = json_decode($key['number'], true);
                $expiry = json_decode($key['expiry_date'], true);

                if (!empty($arr_search[0]['expiry_date_from']) && !empty($arr_search[0]['expiry_date_to'])) {
                    if (strtotime($expiry[2]) >= $arr_search[0]['expiry_date_from'] || strtotime($expiry[2]) <= $arr_search[0]['expiry_date_to'] || strtotime($expiry[3]) >= $arr_search[0]['expiry_date_from'] || strtotime($expiry[3]) <= $arr_search[0]['expiry_date_to']) {
                        $sheet->setCellValue('A' . $cell_count . '', $count);
                        $sheet->setCellValue('B' . $cell_count . '', $key['position_name']);
                        $sheet->setCellValue('C' . $cell_count . '', $key['full_name']);
                        $sheet->setCellValue('D' . $cell_count . '', $numbers ? $numbers[2] : " - ");
                        $sheet->setCellValue('E' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[2])) : " - ");
                        $sheet->setCellValue('F' . $cell_count . '', $numbers ? $numbers[3] : " - ");
                        $sheet->setCellValue('G' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[3])) : " - ");
                        $sheet->setCellValue('H' . $cell_count . '', $key['vsl_name']);
                        $cell_count++;
                        $count++;
                    } else {
                        $sheet->setCellValue('A' . $cell_count . '', $count);
                        $sheet->setCellValue('B' . $cell_count . '', $key['position_name']);
                        $sheet->setCellValue('C' . $cell_count . '', $key['full_name']);
                        $sheet->setCellValue('D' . $cell_count . '', $numbers ? $numbers[2] : " - ");
                        $sheet->setCellValue('E' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[2])) : " - ");
                        $sheet->setCellValue('F' . $cell_count . '', $numbers ? $numbers[3] : " - ");
                        $sheet->setCellValue('G' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[3])) : " - ");
                        $sheet->setCellValue('H' . $cell_count . '', $key['vsl_name']);
                        $cell_count++;
                        $count++;
                    }
                } else {

                    $sheet->setCellValue('A' . $cell_count . '', $count);
                    $sheet->setCellValue('B' . $cell_count . '', $key['position_name']);
                    $sheet->setCellValue('C' . $cell_count . '', $key['full_name']);
                    $sheet->setCellValue('D' . $cell_count . '', $numbers ? $numbers[2] : " - ");
                    $sheet->setCellValue('E' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[2])) : " - ");
                    $sheet->setCellValue('F' . $cell_count . '', $numbers ? $numbers[3] : " - ");
                    $sheet->setCellValue('G' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[3])) : " - ");
                    $sheet->setCellValue('H' . $cell_count . '', $key['vsl_name']);
                    $cell_count++;
                    $count++;
                }
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'PANAMA Monitor_' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_marshall_report()
    {
        $arr_search['search']['type'] = $this->input->post('r_filter_by_type');
        $arr_search['search']['position'] = $this->input->post('r_filter_by_pos');
        $arr_search['search']['vessel'] = $this->input->post('r_filter_by_vessel');
        $arr_search['search']['license'] = $this->input->post('r_type_of_license');
        $arr_search['search']['joining_date_from'] = $this->input->post('r_expiry_date_from');
        $arr_search['search']['joining_date_to'] = $this->input->post('r_expiry_date_to');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/MARSHALL_MONITORING_RECORD.xlsx');
        $marshall = $this->license->getPanamaReport($arr_search);
        $this->m_backup_db->backup_reports("MARSHALL Monitoring", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $cell_count = 7;
        $count = 1;

        if ($marshall) {
            foreach ($marshall as $key) {

                $numbers = json_decode($key['number'], true);
                $expiry = json_decode($key['expiry_date'], true);

                if (!empty($arr_search[0]['expiry_date_from']) && !empty($arr_search[0]['expiry_date_to'])) {
                    if (strtotime($expiry[2]) >= $arr_search[0]['expiry_date_from'] || strtotime($expiry[2]) <= $arr_search[0]['expiry_date_to'] || strtotime($expiry[3]) >= $arr_search[0]['expiry_date_from'] || strtotime($expiry[3]) <= $arr_search[0]['expiry_date_to']) {

                        $sheet->setCellValue('A' . $cell_count . '', $count);
                        $sheet->setCellValue('B' . $cell_count . '', $key['position_name']);
                        $sheet->setCellValue('C' . $cell_count . '', $key['vsl_name']);
                        $sheet->setCellValue('D' . $cell_count . '', $key['full_name']);
                        $sheet->setCellValue('E' . $cell_count . '', $numbers ? $numbers[2] : " - ");
                        $sheet->setCellValue('F' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[2])) : " - ");
                        $sheet->setCellValue('G' . $cell_count . '', $numbers ? $numbers[1] : " - ");
                        $sheet->setCellValue('H' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[1])) : " - ");
                        $sheet->setCellValue('I' . $cell_count . '', $numbers ? $numbers[3] : " - ");
                        $sheet->setCellValue('J' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[3])) : " - ");
                        $cell_count++;
                        $count++;
                    } else {

                        $sheet->setCellValue('A' . $cell_count . '', $count);
                        $sheet->setCellValue('B' . $cell_count . '', $key['position_name']);
                        $sheet->setCellValue('C' . $cell_count . '', $key['vsl_name']);
                        $sheet->setCellValue('D' . $cell_count . '', $key['full_name']);
                        $sheet->setCellValue('E' . $cell_count . '', $numbers ? $numbers[2] : " - ");
                        $sheet->setCellValue('F' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[2])) : " - ");
                        $sheet->setCellValue('G' . $cell_count . '', $numbers ? $numbers[1] : " - ");
                        $sheet->setCellValue('H' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[1])) : " - ");
                        $sheet->setCellValue('I' . $cell_count . '', $numbers ? $numbers[3] : " - ");
                        $sheet->setCellValue('J' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[3])) : " - ");
                        $cell_count++;
                        $count++;
                    }
                } else {

                    $sheet->setCellValue('A' . $cell_count . '', $count);
                    $sheet->setCellValue('B' . $cell_count . '', $key['position_name']);
                    $sheet->setCellValue('C' . $cell_count . '', $key['vsl_name']);
                    $sheet->setCellValue('D' . $cell_count . '', $key['full_name']);
                    $sheet->setCellValue('E' . $cell_count . '', $numbers ? $numbers[2] : " - ");
                    $sheet->setCellValue('F' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[2])) : " - ");
                    $sheet->setCellValue('G' . $cell_count . '', $numbers ? $numbers[1] : " - ");
                    $sheet->setCellValue('H' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[1])) : " - ");
                    $sheet->setCellValue('I' . $cell_count . '', $numbers ? $numbers[3] : " - ");
                    $sheet->setCellValue('J' . $cell_count . '', $expiry ? date('F j, Y', strtotime($expiry[3])) : " - ");
                    $cell_count++;
                    $count++;
                }
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'MARSHALL Monitor_' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_prejoining_report()
    {
        $arr_search['search']['type'] = $this->input->post('r_filter_by_type');
        $arr_search['search']['position'] = $this->input->post('r_filter_by_pos');
        $arr_search['search']['vessel'] = $this->input->post('r_filter_by_vessel');
        $arr_search['search']['joining_date_from'] = $this->input->post('r_date_from');
        $arr_search['search']['joining_date_to'] = $this->input->post('r_date_to');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/Prejoining-Monitoring.xlsx');
        $prejoining = $this->crew_management->FilterPrejoining($arr_search);
        $this->m_backup_db->backup_reports("Prejoining", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $cell_count = 3;


        if ($prejoining) {
            foreach ($prejoining as $key) {

                $offsigner_code = $this->global->getCrew($key['offsigner']);
                $offsigner_name = $offsigner_code['crew_code'] != NULL ? $this->global->GetCrewFullName($offsigner_code['crew_code'])->full_name : "-";
                $offsigner_pos = $this->global->getPosition($offsigner_code['position']);

                if ($key['medical_status'] != 2) {
                    $a_status = "Approved";
                } else {
                    $a_status = "Pending";
                }
                $expiry_date = json_decode($key['expiry_date'], true);
                $certificate = json_decode($key['number'], true);
                $cert_count = count($certificate);

                $sheet->setCellValue('A' . $cell_count . '', $key['vsl_name']);
                $sheet->setCellValue('B' . $cell_count . '', $offsigner_pos['position_name']);
                $sheet->setCellValue('C' . $cell_count . '', $offsigner_name);
                $sheet->setCellValue('D' . $cell_count . '', $key['position_name']);
                $sheet->setCellValue('E' . $cell_count . '', $key['full_name']);
                $sheet->setCellValue('F' . $cell_count . '', $key['mobile_number']);
                $sheet->setCellValue('G' . $cell_count . '', $key['x_port']);
                $sheet->setCellValue('H' . $cell_count . '', $key['date_x'] ? date('F j, Y', strtotime($key['date_x'])) : "-");
                $sheet->setCellValue('I' . $cell_count . '', $a_status);
                $sheet->setCellValue('J' . $cell_count . '', $key['medical_status'] === 1 ? "Fit to work" : "Pending");
                $sheet->setCellValue('K' . $cell_count . '', "Valid until" . '' . $expiry_date[2]);
                $sheet->setCellValue('L' . $cell_count . '', "Valid until" . '' . $expiry_date[1]);
                $sheet->setCellValue('M' . $cell_count . '', "Valid until" . '' . $expiry_date[4]);
                $sheet->setCellValue('N' . $cell_count . '', "-");
                $sheet->setCellValue('O' . $cell_count . '', "Valid until" . '' . $expiry_date[3]);
                $sheet->setCellValue('P' . $cell_count . '', "Valid until" . '' . $expiry_date[5]);
                $sheet->setCellValue('Q' . $cell_count . '', "Valid until" . '' . $expiry_date[8]);
                $sheet->setCellValue('R' . $cell_count . '', $cert_count >= 23 ? "Completed" : "Incomplete");
                $sheet->setCellValue('S' . $cell_count . '', "Valid Until" . $key['contract_duration']);
                $sheet->setCellValue('T' . $cell_count . '', "Date Created " . $key['mlc_created']);
                $sheet->setCellValue('U' . $cell_count . '', $key['remarks']);
                $cell_count++;
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'Prejoining-Monitoring' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    public function print_medical_report()
    {
        $arr_search['search']['type'] = $this->input->post('r_filter_by_type');
        $arr_search['search']['position'] = $this->input->post('r_filter_by_pos');
        $arr_search['search']['vessel'] = $this->input->post('r_filter_by_vessel');
        $arr_search['search']['m_date_from'] = $this->input->post('m_date_from');
        $arr_search['search']['m_date_to'] = $this->input->post('m_date_to');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/Medical-Monitoring.xlsx');
        $medical = $this->medical->getMedicalReport($arr_search);
        $this->m_backup_db->backup_reports("MEDICAL MONITORING", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $cell_count = 3;
        $count = 1;

        if ($medical) {
            foreach ($medical as $key) {
                $last_vessel = $this->m_crew_arc->get_last_vessel($key['monitor_code']);
                $medical_date = strtotime($key['date_medical_fit']);
                $onboard_date = strtotime($key['embark_date']);

                $diff =  $onboard_date - $medical_date;
                $date_diff = round($diff / (60 * 60 * 24));



                $sheet->setCellValue('A' . $cell_count . '', $count);
                $sheet->setCellValue('B' . $cell_count . '', $key['position_name']);
                $sheet->setCellValue('C' . $cell_count . '', $key['full_name']);
                $sheet->setCellValue('D' . $cell_count . '', $last_vessel ? $last_vessel['last_vessel'] : "-");
                $sheet->setCellValue('E' . $cell_count . '', $key['vsl_name']);
                $sheet->setCellValue('F' . $cell_count . '', "-");
                $sheet->setCellValue('G' . $cell_count . '', date('F j, Y', strtotime($key['date_med_exam'])));
                if ($date_diff > 90) {
                    $sheet->getStyle('H' . $cell_count . '')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
                } else if ($date_diff >= 60 && $date_diff <= 90) {
                    $sheet->getStyle('H' . $cell_count . '')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
                } else if ($date_diff >= 31 && $date_diff <= 60) {
                    $sheet->getStyle('H' . $cell_count . '')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKYELLOW);
                } else if ($date_diff <= 30 && $date_diff >= 1) {
                    $sheet->getStyle('H' . $cell_count . '')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                }
                $sheet->setCellValue('I' . $cell_count . '', $key['medical_bmi']);
                $sheet->setCellValue('J' . $cell_count . '', $key['remarks']);
                $sheet->setCellValue('K' . $cell_count . '', $key['status'] === 2 ? "Fit to work with medication" : "Not Fit to work");
                $cell_count++;
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
        $filename = 'MEDICAL MONITORING' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');    // download file
    }

    //

    public function PrintCMPGeneral($type)
    {
        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');
        $arr_search['search']['status_search'] = $this->session->userdata('status_search');
        $arr_search['search']['contract_search'] = $this->session->userdata('contract_search');
        $arr_search['search']['flight_search'] = $this->session->userdata('flight_search');
        $arr_search['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $arr_search['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/Crew Management Plan Report.xlsx');
        $cmp = $this->crew_management->FilterCMP($arr_search);
        $this->m_backup_db->backup_reports("Crew Management Plan (Summary)", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $nr = 1;
        $cell_count = 4;

        if ($cmp) {
            foreach ($cmp as $row) {
                $reliever_name = "";
                $reliever_code = $this->global->getCrew($row['insigner']);
                if (!empty($reliever_code)) {
                    $reliever_name = $reliever_code['crew_code'] != NULL ? $this->global->GetCrewFullName($reliever_code['crew_code'])->full_name : "-";
                }

                $sheet->setCellValue('A' . $cell_count . '', $nr);
                $sheet->setCellValue('B' . $cell_count . '', $row['cmp_code']);
                $sheet->setCellValue('C' . $cell_count . '', $row['vsl_name']);
                $sheet->setCellValue('D' . $cell_count . '', $row['position_name']);
                $sheet->setCellValue('E' . $cell_count . '', $row['full_name']);
                $sheet->setCellValue('F' . $cell_count . '', $row['sign_on']);
                $sheet->setCellValue('G' . $cell_count . '', $row['contract_duration']);
                $sheet->setCellValue('H' . $cell_count . '', $row['months_onboard']);
                $sheet->setCellValue('I' . $cell_count . '', $row['date_x']);
                $sheet->setCellValue('J' . $cell_count . '', $row['x_port']);
                $sheet->setCellValue('K' . $cell_count . '', $reliever_name);
                $sheet->setCellValue('L' . $cell_count . '', $row['remarks']);
                $cell_count++;
            }
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Crew Management Plan'; // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Crew Management Plan'; // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Crew Management Plan (Summary)' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }

    public function printCMPlanReport($type)
    {

        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');
        $arr_search['search']['status_search'] = $this->session->userdata('status_search');
        $arr_search['search']['contract_search'] = $this->session->userdata('contract_search');
        $arr_search['search']['flight_search'] = $this->session->userdata('flight_search');
        $arr_search['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $arr_search['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/2 CREW LINE-UP CHECKLIST.xlsx');
        $cmp = $this->crew_management->getOffSignerCrew($arr_search);
        $cmp_count = count($cmp);
        $this->m_backup_db->backup_reports("Crew Management Plan (Summary)", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $nr = 1;
        $cell_count = 17;

        if ($cmp) {
            foreach ($cmp as $row) {

                $reliever_code = $this->global->getCrew($row['insigner']);
                if ($reliever_code) {
                    $reliever_name = $reliever_code['crew_code'] != NULL ? $this->global->GetCrewFullName($reliever_code['crew_code'])->full_name : "-";
                }
                $position_history = $this->db->where('crew_code', $row['crew_code'])->get('last_position_history')->row_array();

                $sheet->setCellValue('B11', date('Y-m-d'));
                $sheet->setCellValue('C13', $this->session->userdata('rank_search') ? $this->session->userdata('rank_search') : "");
                $sheet->setCellValue('C14', $row['embark'] ? $row['embark'] : "");
                $sheet->setCellValue('F14', $row['x_port'] ? $row['x_port'] : "");
                $sheet->setCellValue('A' . $cell_count . '', ++$nr);
                $sheet->setCellValue('B' . $cell_count . '', $row['position_code']);
                $sheet->setCellValue('C' . $cell_count . '', ucfirst($row['full_name']));
                $sheet->setCellValue('D' . $cell_count . '', $position_history ? $this->global->getVesselById($position_history['1'])['vsl_code'] : "");
                $sheet->setCellValue('E' . $cell_count . '', $this->crew_management->license_validity_text($row['crew_code']));
                $sheet->setCellValue('F' . $cell_count . '', $this->medical->get_medical_validity_text($row['crew_code']));

                if ($cell_count == $cmp_count - 1) {
                    $cnt = $cell_count + 1;
                    $cnt2 = $cell_count + 2;
                    $cnt3 = $cell_count + 3;

                    $sheet->setCellValue('A' . $cnt . '', "Prepared by:");
                    $sheet->setCellValue('C' . $cnt . '', "DP OFFICER IN CHARGE");
                    $sheet->setCellValue('A' . $cnt2 . '', "Noted by :");
                    $sheet->setCellValue('C' . $cnt2 . '', "DP MANAGER");
                    $sheet->setCellValue('A' . $cnt3 . '', "Approved by: ");
                    $sheet->setCellValue('C' . $cnt3 . '', "CREW OPERATIONS MANAGER");
                }
                $cell_count++;
            }
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Crew Management Plan (Summary)' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Crew Management Plan (Summary)' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Crew Management Plan (Summary)' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        }
    }

    public function PrejoiningReportGeneral($type)
    {
        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/Prejoining-Monitoring.xlsx');
        $prejoining = $this->crew_management->FilterPrejoining($conditions);



        $this->m_backup_db->backup_reports("Prejoining", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $cell_count = 3;

        if ($prejoining) {
            foreach ($prejoining as $row) {


                $offsigner_code = $this->global->getCrew($row['offsigner']);
                $offsigner_name = $offsigner_code['crew_code'] != NULL ? $this->global->GetCrewFullName($offsigner_code['crew_code'])->full_name : "-";
                $offsigner_pos = $this->global->getPosition($offsigner_code['position']);

                $insigner_position = $row['insigner'] != NULL ? $this->global->getCrewNameByMonitorCode($row['insigner'])['position_code'] : "-";
                $insigner_name = $row['insigner'] != NULL ? $this->global->getCrewNameByMonitorCode($row['insigner'])['full_name'] : "-";
                $insigner_mobile_no = $row['insigner'] != NULL ? $this->global->getCrewNameByMonitorCode($row['insigner'])['mobile_number'] : "-";
                $x_port = $row['x_port'] ? $row['x_port'] : '-';
                $embark = $row['embark'] ? date('M j, Y', strtotime($row['embark'])) : '-';
                $remarks = $row['remarks'] ? $row['remarks'] : '-';

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

                $sheet->setCellValue('A' . $cell_count . '', $row['vsl_name']);
                $sheet->setCellValue('B' . $cell_count . '', $row['position_name']);
                $sheet->setCellValue('C' . $cell_count . '', $row['full_name']);
                $sheet->setCellValue('D' . $cell_count . '', $insigner_position);
                $sheet->setCellValue('E' . $cell_count . '', $insigner_name);
                $sheet->setCellValue('F' . $cell_count . '', $insigner_mobile_no);
                $sheet->setCellValue('G' . $cell_count . '', $row['x_port']);
                $sheet->setCellValue('H' . $cell_count . '', $row['date_x'] ? date('F j, Y', strtotime($row['date_x'])) : "-");
                $sheet->setCellValue('I' . $cell_count . '', "APPROVED");
                $sheet->setCellValue('J' . $cell_count . '', $medical_validity);
                $sheet->setCellValue('K' . $cell_count . '', $licenses_validity);
                $sheet->setCellValue('L' . $cell_count . '', $cert_validity);
                $sheet->setCellValue('M' . $cell_count . '', $contract_contract_duration);
                $sheet->setCellValue('N' . $cell_count . '', $mlc_validity);
                $sheet->setCellValue('O' . $cell_count . '', $remarks);
                $cell_count++;
            }
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Prejoining-Monitoring' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Prejoining-Monitoring' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Prejoining-Monitoring' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }

    public function PrejoiningVisaReport($type)
    {
        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/pre_joining_visa_crews.xlsx');
        $prejoining = $this->pre_joining->getPreJoiningCrew($conditions);


        $this->m_backup_db->backup_reports("Prejoining", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $cell_count = 2;

        if ($prejoining) {
            foreach ($prejoining as $row) {

                $date_available = $row['date_available'] ? date("Y-m-d", strtotime($row['date_available'])) : "-";
                $bmi =  strip_tags($this->global->getBMIScore($row['height'], $row['weight']));

                $passport_validity = $this->crew_management->validate_passport_report($row['crew_code']);
                $licenses_validity = $this->crew_management->get_license_validity_report($row['crew_code']);
                $cert_validity = $this->crew_management->validate_certificates_report($row['crew_code']);

                $sheet->setCellValue('A' . $cell_count . '', $row['crew_code']);
                $sheet->setCellValue('B' . $cell_count . '', $row['vsl_name']);
                $sheet->setCellValue('C' . $cell_count . '', $row['position_name']);
                $sheet->setCellValue('D' . $cell_count . '', $row['full_name']);
                $sheet->setCellValue('E' . $cell_count . '', $date_available);
                $sheet->setCellValue('F' . $cell_count . '', $bmi);
                $sheet->setCellValue('G' . $cell_count . '', $passport_validity);
                $sheet->setCellValue('H' . $cell_count . '', $licenses_validity);
                $sheet->setCellValue('I' . $cell_count . '', $cert_validity);

                $cell_count++;
            }
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Prejoining-Visa-Monitoring' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Prejoining-Visa-Monitoring' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        }
    }

    public function ContractReportGeneral($type)
    {
        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');
        $arr_search['search']['contract_search'] = $this->session->userdata('contract_search');
        $arr_search['search']['flight_search'] = $this->session->userdata('flight_search');
        $arr_search['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $arr_search['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/crew_contract_report.xlsx');
        $contract = $this->contracts->getContractCrew($arr_search);
        $this->m_backup_db->backup_reports("Contracts", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;

        foreach ($contract as $row) {
            $status = $this->global->getCrewStatusForReport($row['status']);

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

            $sheet->setCellValue('A' . $count . '', $row['crew_code']);
            $sheet->setCellValue('B' . $count . '', $row['full_name']);
            $sheet->setCellValue('C' . $count . '', $status);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name'] != NULL ? $row['position_name'] : "-");
            $sheet->setCellValue('F' . $count . '', $row['vsl_name'] != NULL ? $row['vsl_name'] : "-");
            $sheet->setCellValue('G' . $count . '', $contract_contract_duration);
            $sheet->setCellValue('H' . $count . '', $mlc_duration);
            $sheet->setCellValue('I' . $count . '', $mlc_type);
            $count++;
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Contract' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Contract' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Contract' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }

    public function printMedicalGeneral($type)
    {
        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');
        $arr_search['search']['contract_search'] = $this->session->userdata('contract_search');
        $arr_search['search']['flight_search'] = $this->session->userdata('flight_search');
        $arr_search['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $arr_search['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/general/Medical-Monitoring.xlsx');
        $medical = $this->medical->getMedicalReportGeneral($arr_search);
        $this->m_backup_db->backup_reports("MEDICAL MONITORING", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $cell_count = 3;
        $count = 1;

        if ($medical) {
            foreach ($medical as $key) {

                $last_vessel = $this->m_crew_arc->get_last_vessel($key['monitor_code']);
                $medical_date = strtotime($key['date_medical_fit']);
                $onboard_date = strtotime($key['embark_date']);

                $diff =  $onboard_date - $medical_date;
                $date_diff = round($diff / (60 * 60 * 24));

                $status = "";
                if ($key['medical_status'] === "2") {
                    $status = "FIT FOR SEA DUTY";
                } else if ($key['medical_status'] === "1") {
                    $status = "PENDING";
                } else if ($key['medical_status'] === "3") {
                    $status = "W/APPROVAL";
                } else {
                    $status = "REJECTED";
                }



                $sheet->setCellValue('A' . $cell_count . '', $count);
                $sheet->setCellValue('B' . $cell_count . '', $key['position_name']);
                $sheet->setCellValue('C' . $cell_count . '', $key['full_name']);
                $sheet->setCellValue('D' . $cell_count . '', $last_vessel ? $last_vessel['last_vessel'] : "-");
                $sheet->setCellValue('E' . $cell_count . '', $key['vsl_name']);
                $sheet->setCellValue('F' . $cell_count . '', "-");
                $sheet->setCellValue('G' . $cell_count . '', date('F j, Y', strtotime($key['date_med_exam'])));
                if ($date_diff > 90) {
                    $sheet->getStyle('H' . $cell_count . '')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
                } else if ($date_diff >= 60 && $date_diff <= 90) {
                    $sheet->getStyle('H' . $cell_count . '')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
                } else if ($date_diff >= 31 && $date_diff <= 60) {
                    $sheet->getStyle('H' . $cell_count . '')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKYELLOW);
                } else if ($date_diff <= 30 && $date_diff >= 1) {
                    $sheet->getStyle('H' . $cell_count . '')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                }
                $sheet->setCellValue('I' . $cell_count . '', $key['medical_bmi']);
                $sheet->setCellValue('J' . $cell_count . '', $key['remarks']);
                $sheet->setCellValue('K' . $cell_count . '', $status);
                $cell_count++;
            }
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'MEDICAL MONITORING' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'MEDICAL MONITORING' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'MEDICAL MONITORING' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }

    public function EmbarkedCrew($type)
    {
        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');
        $arr_search['search']['contract_search'] = $this->session->userdata('contract_search');
        $arr_search['search']['flight_search'] = $this->session->userdata('flight_search');
        $arr_search['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $arr_search['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/embarked_crew_report.xlsx');
        $contract = $this->embark->getCrewEmbarked($arr_search);
        $this->m_backup_db->backup_reports("Embarked", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;

        foreach ($contract as $row) {
            $status = $this->global->getCrewStatusForReport($row['status']);
            $crew = $this->global->getCrew($row['offsigner']);
            $offsigner_name = $crew['crew_code'] != NULL ? $this->global->GetCrewFullName($crew['crew_code'])->full_name : "-";

            $sheet->setCellValue('A' . $count . '', $row['crew_code']);
            $sheet->setCellValue('B' . $count . '', $row['full_name']);
            $sheet->setCellValue('C' . $count . '', $status);
            $sheet->setCellValue('D' . $count . '', $row['province_name'] . ', ' . $row['city_name']);
            $sheet->setCellValue('E' . $count . '', $row['position_name'] != NULL ? $row['position_name'] : "-");
            $sheet->setCellValue('F' . $count . '', $row['vsl_name'] != NULL ? $row['vsl_name'] : "-");
            $sheet->setCellValue('G' . $count . '', $offsigner_name);
            $sheet->setCellValue('H' . $count . '', $row['embark'] != NULL ? $row['embark'] : "-");
            $count++;
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Embarked' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Embarked' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Embarked' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }

    public function DisembarkedCrew($type)
    {
        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');
        $arr_search['search']['contract_search'] = $this->session->userdata('contract_search');
        $arr_search['search']['flight_search'] = $this->session->userdata('flight_search');
        $arr_search['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $arr_search['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/disembarked_crew_report.xlsx');
        $contract = $this->disembark->getCrewDisembark($arr_search);
        $this->m_backup_db->backup_reports("Embarked", $this->session->userdata('user_code'));
        $sheet = $spreadsheet->getActiveSheet();
        $count = 2;

        if ($contract) {
            foreach ($contract as $row) {
                $insigner_name = "";
                $status = $this->global->getCrewStatusForReport($row['status']);
                $crew = $this->global->getCrew($row['insigner']);
                if ($crew) {
                    $insigner_name = $crew['crew_code'] != NULL ? $this->global->GetCrewFullName($crew['crew_code'])->full_name : "-";
                }

                $sheet->setCellValue('A' . $count . '', $row['crew_code']);
                $sheet->setCellValue('B' . $count . '', $row['full_name']);
                $sheet->setCellValue('C' . $count . '', $status);
                $sheet->setCellValue('D' . $count . '', $row['province_name'] . '' . $row['city_name']);
                $sheet->setCellValue('E' . $count . '', $row['position_name'] != NULL ? $row['position_name'] : "-");
                $sheet->setCellValue('F' . $count . '', $row['vsl_name'] != NULL ? $row['vsl_name'] : "-");
                $sheet->setCellValue('G' . $count . '', $insigner_name);
                $sheet->setCellValue('H' . $count . '', $row['disembark'] != NULL ? $row['disembark'] : "-");
                $count++;
            }
        }

        if ($type === "csv") {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);

            $filename = 'Disembarked' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else if ($type === "excel") {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // instantiate Xlsx
            $filename = 'Disembarked' . date('Y-m-d H:i:s'); // set filename for excel file to be exported

            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file
        } else {
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

            $filename = 'Disembarkede' . date('Y-m-d H:i:s'); // set filename for excel file to be exported
            header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');    // download file 
        }
    }

    public function print_crew_promotion_report($type)
    {
        $arr_search['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $arr_search['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $arr_search['search']['rank_search'] = $this->session->userdata('rank_search');
        $arr_search['search']['status_search'] = $this->session->userdata('status_search');
        $arr_search['search']['contract_search'] = $this->session->userdata('contract_search');
        $arr_search['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $arr_search['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('application/views/reports/crew/all_crew_report.xlsx');
        $contract = $this->promotions->get_crew_promotion($arr_search);
        $this->m_backup_db->backup_reports("Crew Promotion", $this->session->userdata('user_code'));
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
