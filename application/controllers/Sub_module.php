<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sub_module extends CI_Controller
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
                "module" => $this->global->getAllModule(),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Sub Module | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('developer/sub_module');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_sub_module_table()
    {
        $sub_module = $this->global->getAllSubModule();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($sub_module as $key) {

            $action = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_sub_module_modal" data-backdrop="static" data-keyboard="false" onclick="editSubModule(\'' . $key['id'] . '\')">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeSubModule(\'' . $key['id'] . '\')">Remove</button>';

            $data[] = [
                $count,
                $this->global->getModuleById($key['form_module_id'])['description'],
                $key['description'],
                $key['url'],
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

    public function add_sub_module()
    {
        $add_sub_module = $this->validations->rules['add_sub_module_form'];

        $this->form_validation->set_rules($add_sub_module);

        if ($this->form_validation->run() === false) {
            $data = [
                'module'            => form_error('module'),
                'sub_module'        => form_error('sub_module'),
                'target_link'       => form_error('target_link'),
                'sub_module_url'    => form_error('sub_module_url')
            ];
        } else {

            $result = $this->sub_module->addSubModule();

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

    public function save_edit_sub_module()
    {
        $save_edit_sub_module = $this->validations->rules['edit_sub_module_form'];

        $this->form_validation->set_rules($save_edit_sub_module);

        if ($this->form_validation->run() === false) {
            $data = [
                'e_module'            => form_error('e_module'),
                'e_sub_module'        => form_error('e_sub_module'),
                'e_target_link'       => form_error('e_target_link'),
                'e_sub_module_url'    => form_error('e_sub_module_url')
            ];
        } else {

            $id = $this->input->post('e_sub_module_id');

            $result = $this->sub_module->saveEditSubModule($id);

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

    public function remove_sub_module()
    {
        $id = $this->input->post('id');

        $result = $this->sub_module->removeSubModule($id);

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
