<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_group extends CI_Controller
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
                "title_tag" => "User Group | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('users/user_group');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_user_group_table()
    {
        $user_group = $this->global->getAllUserGroup();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($user_group as $key) {

            $action = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_user_group_modal" data-backdrop="static" data-keyboard="false" onclick="editUserGroup(\'' . $key['id'] . '\')">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeUserGroup(\'' . $key['id'] . '\')">Remove</button>';

            $data[] = [
                $count,
                $key['code'],
                $key['description'],
                $action
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

    public function add_user_group()
    {
        $result = $this->user_group->addUserGroup();

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

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function save_edit_user_group()
    {
        $id = $this->input->post('e_user_group_id');

        $result = $this->user_group->saveEditUserGroup($id);

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

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function remove_user_group()
    {
        $id = $this->input->post('id');

        $result = $this->user_group->removeUserGroup($id);

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

    public function add_user_usertype()
    {
        $add_user_type_form_rules = $this->validations->rules['add_user_type_form'];
        $this->form_validation->set_rules($add_user_type_form_rules);

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'full_name'  => form_error('full_name'),
                'username'  => form_error('username'),
                'email_address'  => form_error('email_address'),
                'phone_number'  => form_error('phone_number'),
                'password'  => form_error('password'),
                'confirm_password'  => form_error('confirm_password'),
                'user_type'  => form_error('user_type'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {
            $result = $this->user_group->addUserUserType();

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
}
