<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Type_of_vessel extends CI_Controller
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
                "title_tag" => "Type of Vessels | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('vessels/type_of_vessel');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function vessel_type_table()
    {
        $vessel_type = $this->global->getAllVesselType();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($vessel_type as $key) {

            $actions = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_vessel_type_modal" onclick="editVesselType(\'' . $key['id'] . '\')" data-backdrop="static" data-keyboard="false">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeVesselType(\'' . $key['id'] . '\')">Remove</button>';

            $data[] = [
                $count,
                $key['tv_code'],
                $key['tv_name'],
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

    public function add_vessel_type()
    {
        $vessel_type_form_rules = $this->validations->rules['vessel_type_form'];
        $this->form_validation->set_rules($vessel_type_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'vessel_code'  => form_error('vessel_code'),
                'vessel_name' => form_error('vessel_name')
            ];
            
        }else{
            $result = $this->vessel_type->addVesselType();

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

    public function save_edit_vessel_type()
    {
        $e_vessel_type_form_rules = $this->validations->rules['e_vessel_type_form'];
        $this->form_validation->set_rules($e_vessel_type_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_vessel_code'  => form_error('e_vessel_code'),
                'e_vessel_name' => form_error('e_vessel_name')
            ];
            
        }else{

            $id = $this->input->post('e_vessel_id');

            $result = $this->vessel_type->saveEditVesselType($id);

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Update Successfully!'
                ];
            } else {
                $data = [
                    'type' => 'warning',
                    'title' => 'No changes had been made.'
                ];
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function remove_vessel_type()
    {
        $id = $this->input->post('id');

        $result = $this->vessel_type->removeVesselType($id);

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
