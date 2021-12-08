<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Points_interview_form extends CI_Controller
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
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Points of Interview | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('settings/points/points_interview_form');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_interview_form_table()
    {
        $position = $this->global->getAllInterviewFormPoints();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($position as $key) {

            $actions = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_points_of_interview_modal" onclick="editInterviewForm(\'' . $key['id'] . '\')" data-backdrop="static" data-keyboard="false">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeInterviewForm(\'' . $key['id'] . '\')">Remove</button>';

            $data[] = [
                $count,
                $key['pti_description'],
                ($key['general_form'] == 1 ? '<span class="badge badge-primary badge-status">FOR GENERAL</span>' : '<span class="badge badge-danger badge-status">FOR TECHNICAL</span>'),
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

    public function add_points_interview_form()
    {
        $interview_form_rules = $this->validations->rules['interview_form'];
        $this->form_validation->set_rules($interview_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'points_of_interview'  => form_error('points_of_interview'),
                'type' => 'warning',
                'title' => 'Please complete all the required fields.'
            ];
        } else {
            $result = $this->points_of_interview->addPointsInterviewForm();

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

    public function save_edit_points_interview()
    {
        $e_interview_form_rules = $this->validations->rules['e_interview_form'];
        $this->form_validation->set_rules($e_interview_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_points_of_interview'  => form_error('e_points_of_interview'),
                'type' => 'warning',
                'title' => 'Please complete all the required fields.'
            ];
        } else {

            $id = $this->input->post('e_points_of_interview_id');

            $result = $this->points_of_interview->saveEditPointsInterview($id);

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

    public function remove_interview_form()
    {
        $id = $this->input->post('id');

        $result = $this->points_of_interview->removeInterviewForm($id);

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

    public function manage_points_of_interview()
    {
        $data = [
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Manage Points of Interview | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('settings/points/manage_points');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function display_points_list()
    {
        $result = $this->global->getAllInterviewFormPoints();
        $row = "";
        if ($result) {
            foreach ($result as $key) {
                $row .= '<div class="col-lg-6">';
                $row .= '<div class="form-group">';
                $row .= '<div class="checkbox checkbox-alphera">';
                $row .= '<input type="checkbox" name="points_interview[]" id="points_interview' . $key['id'] . '" value="' . $key['id'] . '">';
                $row .= '<label for="points_interview' . $key['id'] . '"> ' . $key['pti_description'] . ' </label>';
                $row .= '</div>';
                $row .= '</div>';
                $row .= '</div>';
            }
        }
        $this->output->set_output($row);
    }

    public function update_position_points()
    {
        $position_points_form_rules = $this->validations->rules['position_points_form'];
        $this->form_validation->set_rules($position_points_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'position_list'  => form_error('position_list'),
                'type' => 'warning',
                'title' => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->points_of_interview->updatePositionPoints();
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
