<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Position extends CI_Controller
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
            $this->form_validation->set_message('validate_select', 'The %s field is required.');
            return false;
        } else {
            return true;
        }
    }

    public function index()
    {
        $data = [
            "department_list" => $this->global->getAllDeparment(),
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Position | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('settings/position/position');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_position_table()
    {
        $position = $this->global->getAllPosition();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($position as $key) {

            $actions = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_position_form" onclick="editPosition(\'' . $key['id'] . '\')" data-backdrop="static" data-keyboard="false">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removePosition(\'' . $key['id'] . '\');">Remove</button>';

            $data[] = [
                $count,
                $key['position_code'],
                $key['position_name'],
                $key['nc_max_age'] . ' - ' . $key['ec_max_age'],
                $key['min_experience'] . ' - ' . $key['max_experience'] . ' months',
                $this->global->getDepartmentById($key['type_of_department'])['department_name'],
                $actions
            ];

            $count++;
        }

        $result = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $data
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function add_position()
    {
        $position_form_rules = $this->validations->rules['position_form'];
        $this->form_validation->set_rules($position_form_rules);

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'position_code'  => form_error('position_code'),
                'position_name' => form_error('position_name'),
                'department' => form_error('department'),
                'maximum_age_new' => form_error('maximum_age_new'),
                'maximum_age_ex' => form_error('maximum_age_ex'),
                'minimum_exp' => form_error('minimum_exp'),
                'maximum_exp' => form_error('maximum_exp'),
                'type' => 'warning',
                'title' => 'Please complete all the required fields.'
            ];
        } else {
            $result = $this->position->addPosition();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Saved Successfully!'
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

    public function save_edit_position()
    {
        $e_position_form_rules = $this->validations->rules['e_position_form'];
        $this->form_validation->set_rules($e_position_form_rules);

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'e_position_code'  => form_error('e_position_code'),
                'e_position_name' => form_error('e_position_name'),
                'e_department' => form_error('e_department'),
                'e_maximum_age_new' => form_error('e_maximum_age_new'),
                'e_maximum_age_ex' => form_error('e_maximum_age_ex'),
                'e_minimum_exp' => form_error('e_minimum_exp'),
                'e_maximum_exp' => form_error('e_maximum_exp'),
                'type' => 'warning',
                'title' => 'Please complete all the required fields.'
            ];
        } else {
            $id = $this->input->post('e_position_id');

            $result = $this->position->saveEditPosition($id);

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Update Successfully!'
                ];
            } else {
                $data = [
                    'type' => 'warning',
                    'title' => 'No changes have been made.'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function remove_position()
    {
        $id = $this->input->post('id');

        $result = $this->position->removePosition($id);

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

    public function manage_requirements()
    {
        $data = [
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Manage Requirements | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('settings/position/manage_requirements');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function update_position_certificates()
    {

        $position_requirements_form_rules = $this->validations->rules['position_requirements_form'];
        $this->form_validation->set_rules($position_requirements_form_rules);

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'position_list'  => form_error('position_list'),
                'type' => 'warning',
                'title' => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->position->updatePosition();

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
}
