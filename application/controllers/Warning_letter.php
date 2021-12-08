<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warning_letter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }
    }
    
    public function validate_select($select)
    {
        if (empty($select)) {
            $this->form_validation->set_message('validate_select', 'Please Select %s.');
            return false;
        } else {
            return true;
        }
    }

    public function index()
    {
        $data = [
            'position_list' => $this->global->getAllPosition(),
            'department_list' => $this->global->getAllDeparment(),
            'vessel_list' => $this->global->getAllVessel(),
            'crews'       => $this->all_crew->getAllCrew(),
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Warning Letter | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/crew/e_warning_letter');
        $this->load->view('crew/warning_letter');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function search_warningletter_by_id()
    {

        $crew_code = $this->input->post('app_code');
        $data = $this->all_crew->searchCrewById($crew_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    // public function search_warningletter_edit()
    // {

    //     $crew_id = $this->input->post('crew_id');
    //     $data = $this->warning_letter->getWarningLetterById($crew_id);

    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode($data));
    // }

    public function get_warningletter_crew()
    {

        $crew = $this->warning_letter->getCrewWarningLetter();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length =  intval($this->input->post('length'));
        $count = 1;
        $data = [];

        foreach ($crew as $app) {
            $position = $this->global->getPosition($app['rank']);
            $vessel = $this->global->getVesselById($app['vessel']);
            $department = $this->global->getDepartmentById($app['department']);

            $action = '<button type="button" class="btn btn-outline-danger btn-xs" onclick="deleteWatchlistedCrew(\'' . $app['id'] . '\')">Remove</button>';
            $data[] = array(
                $count,
                htmlentities($app['crew_name'], ENT_QUOTES, 'UTF-8'),
                htmlentities($position['position_name'], ENT_QUOTES, 'UTF-8'),
                htmlentities($vessel['vsl_name'], ENT_QUOTES, 'UTF-8'),
                date('M j, Y', strtotime($app['date_created'])),
                htmlentities((($app['issued_by'] === null) ? "Something Went Wrong" : $this->global->getAccountDetails($app['issued_by']))['full_name'], ENT_QUOTES, 'UTF-8'),
                $this->global->getWatchlistStatus($app['remarks'], 'warningletter'),
                $action
            );

            $count++;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        );

        echo json_encode($result);
    }

    public function get_warningletter_details()
    {
        $crew_code = $this->input->post('crew_code');

        $crew = $this->warning_letter->getCrewWarningLetterByCode($crew_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($crew));
    }

    public function search_crew_warning_letter()
    {

        $crews = $this->db->select("
        c.crew_code,
        c.applicant_code,
        c.date_available,
        c.status,
        c.vessel_assign,
        c.position,
        ap.type_of_department,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        ap.position_code,
        ap.position_name,
        av.vsl_name,
        ad.department_name")
            ->from("crews c")
            ->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code")
            ->join("a_position ap", "c.position = ap.id", "LEFT")
            ->join("a_vessels av", "c.vessel_assign = av.id", "LEFT")
            ->join("a_type_of_department ad", "ap.type_of_department = ad.id", "LEFT")
            ->order_by('c.crew_code', 'ASC')
            ->group_by('c.crew_code')
            ->get()->result_array();

        $data = [];

        if ($crews) {
            foreach ($crews as $crew) {

                $data[] = [
                    'id' => $crew['crew_code'],
                    'text' => $crew['full_name']
                ];
            }
        } else {
            $data[] = [
                'id' => 0,
                'text' => "No Crew Found"
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function save_warningletter_crew()
    {

        $add_warning_leter = $this->validations->rules['add_warning_letter_form'];
        $this->form_validation->set_rules($add_warning_leter);

        if ($this->form_validation->run() === false) {
            $data = [
                'w_crew_name'        => form_error('w_crew_name'),
                'w_rank'             => form_error('w_rank'),
                'w_department'       => form_error('w_department'),
                'w_vessel'           => form_error('w_vessel'),
                'w_remarks'     => form_error('w_remarks'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->warning_letter->saveCrewWarningLetter();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Added Successfully!'
                ];
            } else if ($result === 'early_disembark') {
                $data = [
                    'type' => 'success',
                    'title' => 'Added Successfully!',
                    'text' => 'This crew received a warning letter due to early disembarkation.'
                ];
            } else if ($result === 'to_nre') {
                $data = [
                    'type' => 'success',
                    'title' => 'Added Successfully!',
                    'text' => 'This crew is automatically Not For Rehire (NRE) due to multiple number of warning letter.'
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Oops, something went wrong!'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function early_disembark_warning_letter()
    {

        $add_dis_warning_leter = $this->validations->rules['add_dis_warning_leter'];
        $this->form_validation->set_rules($add_dis_warning_leter);

        if ($this->form_validation->run() === false) {
            $data = [
                'awlm_rank'        => form_error('awlm_rank'),
                'awlm_vessel'       => form_error('awlm_vessel'),
                'awlm_remarks'           => form_error('awlm_remarks'),
                'awlm_type_of_nre'     => form_error('awlm_type_of_nre'),
                'awlm_department'             => form_error('awlm_department'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->warning_letter->saveEarlyDisembarkCrewWarningLetter();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Added Successfully!'
                ];
            } else if ($result === 'to_nre') {
                $data = [
                    'type' => 'success',
                    'title' => 'Added Successfully!',
                    'text' => 'This crew is automatically added for Not For Rehire (NRE) due to multiple number of warning letter.'
                ];
            } else if ($result === 'early_disembark') {
                $data = [
                    'type' => 'success',
                    'title' => 'Added Successfully!',
                    'text' => 'This crew received a warning letter due to early disembarkation.'
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Oops, something went wrong!'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function delete_warningletter_crew()
    {
        $id = $this->input->post('id');

        $result = $this->warning_letter->deleteCrewWarningLetter($id);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Removed Successfully!'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Oops, something went wrong!'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    // public function edit_warning_letter_crew()
    // {

    //     $id = $this->input->post('e_crew_id');
    //     $result = $this->warning_letter->updateCrewWarningLetter($id);
    //     if ($result == true) {
    //         $data = [
    //             'type' => 'success',
    //             'title' => 'Update Successfully!'
    //         ];
    //     } else {
    //         $data = [
    //             'type' => 'failed',
    //             'title' => 'Oops, something went wrong!'
    //         ];
    //     }

    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode($data));
    // }
}
