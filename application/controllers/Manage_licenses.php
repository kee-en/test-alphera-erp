<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_licenses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url() . 'dashboard', 'refresh');
        }
    }

    public function index()
    {
        $data = [
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Manage Licenses | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('settings/position/manage_licenses');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }


    public function save_licenses_by_position()
    {
        $position_licenses_form_rules = $this->validations->rules['position_licenses_form'];
        $this->form_validation->set_rules($position_licenses_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'position_list'  => form_error('position_list'),
                'type' => 'warning',
                'title' => 'Please fill all the required fields.'
            ];
        } else {
            $result = $this->position->updateLicensesPerPosition();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Update Successfully!'
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

    public function validate_select($select)
    {
        if (empty($select)) {
            $this->form_validation->set_message('validate_select', 'The %s field is required.');
            return false;
        } else {
            return true;
        }
    }


    public function get_selected_licenses_per_position()
    {
        $return_positions = $this->position->getSelectedLicensesPerPosition();

        $data['positions'] = json_decode($return_positions['position_licenses']);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
