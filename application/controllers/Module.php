<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Module extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }
    }
    
    public function index()
    {
        $data = [
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Module | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('developer/module');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_module_table()
    {
        $module = $this->global->getAllModule();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($module as $key) {

            $action = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_module_modal" data-backdrop="static" data-keyboard="false" onclick="editModule(\'' . $key['id'] . '\')">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeModule(\'' . $key['id'] . '\')">Remove</button>';

            $data[] = [
                $count,
                $key['description'],
                $key['url'],
                $key['icon'],
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


    public function add_module()
    {
        $add_module = $this->validations->rules['add_module_form'];

        $this->form_validation->set_rules($add_module);

        if ($this->form_validation->run() == false) {
            $data = [
                'module_name' => form_error('module_name'),
                'url'         => form_error('url'),
                'icon'        => form_error('icon')
            ];
        } else {

            $result = $this->module->addModule();

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

    public function save_edit_module()
    {

        $save_edit_module = $this->validations->rules['edit_module_form'];

        $this->form_validation->set_rules($save_edit_module);

        if ($this->form_validation->run() == false) {
            $data = [
                'e_module_name' => form_error('e_module_name'),
                'e_module_url'  => form_error('e_module_url'),
                'e_module_icon' => form_error('e_module_icon')
            ];
        } else {

            $id = $this->input->post('e_module_id');

            $result = $this->module->saveEditModule($id);

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Updated Successfully!'
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

    public function remove_module()
    {
        $id = $this->input->post('id');

        $result = $this->module->removeModule($id);

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
