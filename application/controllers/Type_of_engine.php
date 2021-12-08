<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Type_of_engine extends CI_Controller
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
                "title_tag" => "Type of Engine | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('vessels/type_of_engine');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function engine_type_table()
    {
        $engine_type = $this->global->getAllEngineType();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($engine_type as $key) {

            $actions = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_engine_vessel_modal" data-backdrop="static" data-keyboard="false" onclick="editVesselEngine(\'' . $key['id'] . '\')">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeVesselEngine(\'' . $key['id'] . '\')">Remove</button>';

            $data[] = [
                $count,
                $key['engine_code'],
                $key['engine_name'],
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

    public function add_vessel_engine()
    {
        $vessel_engine_form_rules = $this->validations->rules['vessel_engine_form'];
        $this->form_validation->set_rules($vessel_engine_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'engine_code'  => form_error('engine_code'),
                'engine_name' => form_error('engine_name')
            ];
            
        }else{

            $result = $this->vessel_engine->addVesselEngine();

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

    public function save_edit_vessel_engine()
    {
        $e_vessel_engine_form_rules = $this->validations->rules['e_vessel_engine_form'];
        $this->form_validation->set_rules($e_vessel_engine_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_engine_code'  => form_error('e_engine_code'),
                'e_engine_name' => form_error('e_engine_name')
            ];
            
        }else{

            $id = $this->input->post('e_engine_id');

            $result = $this->vessel_engine->saveEditVesselEngine($id);

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

    public function remove_vessel_engine()
    {
        $id = $this->input->post('id');

        $result = $this->vessel_engine->removeVesselEngine($id);

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
