<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Licenses extends CI_Controller
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
            "title_tag" => "Licenses | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('settings/requirements/licenses');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_license_table()
    {
        $licenses = $this->global->getAllLicenses();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($licenses as $key) {

            $actions = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_license_modal" onclick="editLicense(\'' . $key['id'] . '\')" data-backdrop="static" data-keyboard="false">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeLicense(\'' . $key['id'] . '\')">Remove</button>';

            $data[] = [
                $count,
                $key['license_code'],
                $key['license_name'],
                ($key['required'] == 1 ? "YES" : "NO"),
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

    public function add_license()
    {
        $license_form_rules = $this->validations->rules['license_form'];
        $this->form_validation->set_rules($license_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'license_code'  => form_error('license_code'),
                'license_name' => form_error('license_name'),
            ];
        } else {
            $result = $this->license->addLicense();

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

    public function save_edit_license()
    {
        $e_license_form_rules = $this->validations->rules['e_license_form'];
        $this->form_validation->set_rules($e_license_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_license_code'  => form_error('e_license_code'),
                'e_license_name' => form_error('e_license_name'),
            ];
        } else {

            $id = $this->input->post('e_license_id');

            $result = $this->license->saveEditLicense($id);

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

    public function remove_license()
    {
        $id = $this->input->post('id');

        $result = $this->license->removeLicense($id);

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

    public function get_document_numbers()
    {
        $crew_code = $this->input->post('crew_code');
        $result = $this->global->getListLicenses($crew_code);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
