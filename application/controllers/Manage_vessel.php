<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_vessel extends CI_Controller
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
            "vessel_type" => $this->global->getAllVesselType(),
            "vessel_engine" => $this->global->getAllEngineType(),
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Manage Vessels | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/remove_vessel');
        $this->load->view('vessels/manage_vessel');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_vessel_table()
    {
        $vessel = $this->global->getAllVessel();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($vessel as $key) {

            $actions = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_vessel_modal" data-backdrop="static" data-keyboard="false" onclick="editVessel(\'' . $key['id'] . '\')">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeVessel(\'' . $key['id'] . '\')">Remove</button>';
    
            $data[] = [
                $count,
                $key['vsl_code'],
                $key['vsl_name'],
                (!$key['vsl_type'] ? ' - ' : $this->global->getVesselTypeById($key['vsl_type'])['tv_name']),
                (!$key['vsl_engine'] ? ' - ' : $this->global->getEngineTypeById($key['vsl_engine'])['engine_name']),
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

    public function add_vessel()
    {
        $add_vessel_form_rules = $this->validations->rules['add_vessel_form'];
        $this->form_validation->set_rules($add_vessel_form_rules);

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'vsl_code'  => form_error('vsl_code'),
                'vsl_name' => form_error('vsl_name'),
                'type_of_vessel' => form_error('type_of_vessel'),
                'type_of_engine' => form_error('type_of_engine')
            ];
        } else {

            $result = $this->manage_vessel->addVessel();

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

    public function save_edit_vessel()
    {
        $edit_vessel_form_rules = $this->validations->rules['edit_vessel_form'];
        $this->form_validation->set_rules($edit_vessel_form_rules);

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'e_vsl_code'  => form_error('e_vsl_code'),
                'e_vsl_name' => form_error('e_vsl_name'),
                'e_type_of_vessel' => form_error('e_type_of_vessel'),
                'e_type_of_engine' => form_error('e_type_of_engine')
            ];
        } else {

            $id = $this->input->post('e_vsl_id');

            $result = $this->manage_vessel->saveEditVessel($id);

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

    public function remove_vessel()
    {
        $id = $this->input->post('vsl_rmv_id');
        $vsl_status = $this->input->post('vsl_rmv_status');

        $result = $this->manage_vessel->removeVessel($id, $vsl_status);

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
