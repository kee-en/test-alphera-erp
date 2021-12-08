<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crew_lineup extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;

    }

    public function generate_crew_lineup()
    {
        $data = [];
        $condition = [];
        $condition['search']['vessel'] = $this->input->post('vsl');
        $condition['search']['joining_port'] = $this->input->post('jp');
        $condition['search']['embark_date'] = $this->input->post('date');
        
        $lineup = $this->crew_management->generate_crew_lineup($condition);
        
        $count = 1;
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length =  intval($this->input->post('length'));

        if ($lineup) {
            foreach ($lineup as $row) {
                $data[] = array(
                    $count++,
                    $row['full_name'],
                    $row['position_name'],
                    $row['vsl_name'],
                    date('M j, Y h:m A', strtotime($row['embark'])),
                    $row['status']
                );
            }
            $count++;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function transfer_lineup_toga()
    {
        $condition = [];
        $condition['search']['vessel'] = $this->input->post('vsl');
        $condition['search']['embark_date'] = $this->input->post('date');
        
        $lineup = $this->crew_management->generate_crew_lineup($condition);
        
        $result = $this->crew_management->transfer_lineup_to_ga($lineup);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Crew Lineup transferred successfull.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Crew Lineup transferred failed.'
            ];
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function crew_lineup_for_approval()
    {
        $result = $this->approval->crew_lineup_for_approval();

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Crew Lineup sent for approval successfull.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Crew Lineup sent for approval failed.'
            ];
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function view_crewlineup_approval()
    {
        $approval_code = $this->input->post('approval_code');
        $lineup = $this->approval->view_crewlineup_approval($approval_code);
        
        $data = [];
        $count = 1;
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length =  intval($this->input->post('length'));

        if ($lineup) {
            foreach ($lineup as $row) {
                $data[] = array(
                    $count++,
                    $row['full_name'],
                    $row['position_name'],
                    $row['vsl_name'],
                    date('M j, Y h:m A', strtotime($row['embark'])),
                    $row['status']
                );
            }
            $count++;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        );
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function approve_crew_lineup()
    {
        $approval_code = $this->input->post('approval_code');
        $result = $this->approval->approve_crew_lineup($approval_code);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Crew Lineup transferred successfull.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Crew Lineup transferred failed.'
            ];
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function reject_crew_lineup()
    {
        $approval_code = $this->input->post('approval_code');
        $result = $this->approval->reject_crew_lineup($approval_code);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Crew Lineup rejected.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Crew Lineup rejection failed.'
            ];
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}