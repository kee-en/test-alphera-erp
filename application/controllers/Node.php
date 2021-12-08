<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Node extends CI_Controller
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
                "sub_module" => $this->global->getAllSubModule(),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Node | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('developer/node');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_node_table()
    {
        $node = $this->global->getAllNode();
        
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($node as $key) {

            $action = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_node_modal" data-backdrop="static" data-keyboard="false" onclick="editNode(\'' . $key['id'] . '\')">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeNode(\'' . $key['id'] . '\')">Remove</button>';

            $data[] = [
                $count,
                $key['description'],
                $this->global->getSubModuleById($key['form_sub_module_id'])['description'],
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

    public function add_node()
    {
        $add_node = $this->validations->rules['add_node_form'];

        $this->form_validation->set_rules($add_node);

        if ($this->form_validation->run() == false) {
            $data = [
                'sub_module' => form_error('sub_module'),
                'node'       => form_error('node'),
                'node_url'   => form_error('node_url')
            ];
        } else {

            $result = $this->node->addNode();

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

    public function save_edit_node()
    {
        $save_edit_node = $this->validations->rules['edit_node_form'];

        $this->form_validation->set_rules($save_edit_node);

        if ($this->form_validation->run() == false) {
            $data = [
                'e_sub_module' => form_error('e_sub_module'),
                'e_node_name'  => form_error('e_node_name'),
                'e_node_url'   => form_error('e_node_url')
            ];
        } else {

            $id = $this->input->post('e_node_id');

            $result = $this->node->saveEditNode($id);

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

    public function remove_node()
    {
        $id = $this->input->post('id');

        $result = $this->node->removeNode($id);

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
