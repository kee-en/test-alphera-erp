<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Watchlisted extends CI_Controller
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
            "title_tag" => "Watchlisted | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('crew/watchlisted');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function search_crew_by_id()
    {
        $crew_code = $this->input->post('app_code');
        $data = $this->all_crew->searchCrewById($crew_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function search_crew_by_select()
    {

        $app_code = $this->input->get('searchTerm');

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
            ->like("CONCAT_WS(' ', acpi.first_name, acpi.middle_name, acpi.last_name)", $app_code)
            ->order_by('c.crew_code', 'ASC')
            ->limit(5)
            ->get()->result_array();

        $data = [];

        foreach ($crews as $crew) {

            $data[] = [
                'id' => $crew['crew_code'],
                'text' => $crew['full_name']
            ];
        }


        echo json_encode($data);
    }

    public function save_watchlisted_crew()
    {

        $add_watchlisted = $this->validations->rules['add_watchlisted_form'];
        $this->form_validation->set_rules($add_watchlisted);

        if ($this->form_validation->run() === false) {
            $data = [
                'w_crew_name'        => form_error('w_crew_name'),
                'w_rank'             => form_error('w_rank'),
                'w_department'       => form_error('w_department'),
                'w_vessel'           => form_error('w_vessel'),
                'w_certificates'     => form_error('w_certificates'),
                'w_registration_no'  => form_error('w_registration_no'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->watchlisted->SaveWatchListCrew();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Added Successfully!'
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


    public function get_watchlisted_crew()
    {

        $crew = $this->watchlisted->getWatchlistedCrew();

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
                htmlentities($app['certificates'], ENT_QUOTES, 'UTF-8'),
                htmlentities($app['e_registration'], ENT_QUOTES, 'UTF-8'),
                date('M j, Y', strtotime($app['date_created'])),
                htmlentities((($app['issued_by'] === null) ? "Something Went Wrong" : $this->global->getAccountDetails($app['issued_by']))['full_name'], ENT_QUOTES, 'UTF-8'),
                htmlentities($app['remarks'], ENT_QUOTES, 'UTF-8'),
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

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function delete_watchlisted_crew()
    {

        $id = $this->input->post('id');
        $result = $this->watchlisted->deleteWatchlistedCrew($id);
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
}
