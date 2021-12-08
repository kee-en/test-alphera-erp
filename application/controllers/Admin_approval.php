<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_approval extends CI_Controller
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

    public function index()
    {
        $data = [];
        $conditions = [];

        $conditions['status'] = $this->input->get('sort');

        if ($conditions) {
            $total_crew = count($this->approval->getApprovals($conditions));
        } else {
            $total_crew = count($this->approval->getApprovals());
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('admin-approval');
        $config['use_page_numbers'] = true;
        $config['total_rows'] = $total_crew;
        $config['per_page'] = $this->perPage;
        $config['uri_segment'] = 2;
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<div class="pagination pagination-sm">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript: void(0);" tabindex="-1">';
        $config['cur_tag_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = $this->uri->segment($config['uri_segment']);

        $offset = !$page ? 0 : (($this->perPage * $page) - $this->perPage);

        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        if ($conditions) {
            $data['pending'] = $this->approval->getApprovals($conditions);
        } else {
            $data['pending'] = $this->approval->getApprovals();
        }

        if ($conditions['start'] === 0) {
            $start_count = 1;
        } else {
            $start_count = $conditions['start'];
        }

        $end_count = ($conditions['start'] + count($data['pending']));

        $data['showing_entries'] = 'Showing ' . $start_count . ' to ' . $end_count . ' of ' . $config['total_rows'] . ' entries';

        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "Admin Approval | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";
        $data['approval_count'] = empty($conditions) ? count($this->approval->getApprovals()) : count($this->approval->getApprovals($conditions));

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/approval/v_medical_pending');
        $this->load->view('modal/approval/v_promotion');
        $this->load->view('modal/approval/v_crew_lineup');
        $this->load->view('crew/admin_approval');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_approval_request()
    {
        $approval_code = $this->input->post('code');
        $result = $this->approval->get_approval_details($approval_code);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function approve_medical_request()
    {
        $result = $this->approval->approve_medical_request();

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Medical Approval.',
                'text'  => 'Medical approval request approved.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Medical Approval.',
                'text'  => 'Something went wrong when approving the request.'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function reject_medical_request()
    {
        $approval_code = $this->input->post('code');
        $crew_code = $this->input->post('crew_code');

        $result = $this->approval->reject_medical_request($approval_code, $crew_code);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Reject Medical Approval.',
                'text'  => 'Medical approval request rejected.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Reject Medical Approval.',
                'text'  => 'Something went wrong when rejecting the request.'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function approve_toc_request()
    {
        $approval_code = $this->input->post('code');
        $crew_code  = $this->input->post('crew_code');
        $request_type   = $this->input->post('request_type');

        $result = $this->approval->approve_toc_request($approval_code, $crew_code, $request_type);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Approve Crew TOC.',
                'text'  => 'Crew TOC approval request approved.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Approve Crew TOC.',
                'text'  => 'Something went wrong when approving the request.'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function reject_toc_request()
    {
        $approval_code = $this->input->post('code');
        $crew_code  = $this->input->post('crew_code');
        $request_type   = $this->input->post('request_type');

        $result = $this->approval->reject_untoc_request($approval_code, $crew_code, $request_type);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Reject Crew TOC.',
                'text'  => 'Crew TOC approval request rejected.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Reject Crew TOC.',
                'text'  => 'Something went wrong when rejecting the request.'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function view_promotion_request()
    {
        $approval_code = $this->input->post('approval_code');
        $crew_code = $this->input->post('crew_code');

        $result = $this->promotions->get_promotion_request_details($approval_code, $crew_code);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function approve_promotion_request()
    {
        $result = $this->approval->approve_promotion();

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Approve Crew Promotion.',
                'text'  => 'Crew promotion request approved, Crew will now be promoted.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Approve Crew Promotion.',
                'text'  => 'Something went wrong went when approving crew promotion.'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function reject_promotion_request()
    {
        $result = $this->approval->reject_promotion();

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Reject Crew Promotion.',
                'text'  => 'Crew promotion request rejected.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Reject Crew Promotion.',
                'text'  => 'Something went wrong went when rejecting crew promotion.'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
