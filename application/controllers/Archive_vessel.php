<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Archive_vessel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }
    }

    public function index()
    {
        $data = [
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Archive Vessels | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('vessels/archive_vessel');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_archive_vessel_table()
    {
        $archive_vessel = $this->global->getAllArchiveVessel();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($archive_vessel as $key) {

            $actions = '<button type="button" class="btn btn-outline-primary btn-xs" onclick="restoreVessel(\'' . $key['id'] . '\')">Restore</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="permanentlyDelete(\'' . $key['id'] . '\')">Permanently Delete</button>';
            $status = $this->global->getVesselStatus($key['status']);

            $data[] = [
                $count,
                $key['vsl_code'],
                $key['vsl_name'],
                (!$key['vsl_type'] ? ' - ' : $this->global->getVesselTypeById($key['vsl_type'])['tv_name']),
                (!$key['vsl_engine'] ? ' - ' : $this->global->getEngineTypeById($key['vsl_engine'])['engine_name']),
                $status,
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

    public function restore_vessel()
    {

        $id = $this->input->post('id');

        $result = $this->restore_vessel->restoreVessel($id);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Restore Successfully!'
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

    public function permanently_delete_vessel()
    {

        $id = $this->input->post('id');

        $result = $this->restore_vessel->permanentlyDeleteVessel($id);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Deleted Successfully'
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
