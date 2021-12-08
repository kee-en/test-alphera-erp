<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit_trail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }
        
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index()
    {

        $params = array();
        $limit_per_page = 10;
        $page = ($this->uri->segment(2)) ? ($this->uri->segment(2) - 1) : 0;
        $total_records = $this->audit_trail->get_audit_trail_count();

        if ($total_records > 0)
        {
            // get current page records
            $params["results"] = $this->audit_trail->get_audit_trail_records($limit_per_page, $page*$limit_per_page);

            $config['base_url'] = base_url('audit-trail');
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 2;

            // custom paging configuration
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;

            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';

            $config['first_link'] = 'First';
            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';

            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = 'Previous';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript: void(0);" tabindex="-1">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';

            $config['attributes'] = array('class' => 'page-link');
            $this->pagination->initialize($config);

            $page = $this->uri->segment($config['uri_segment']);

            $offset = !$page ? 0 : $page;

            if ($offset === 0) {
                $params['start'] = ($offset);
            } else {
                $params['start'] = ($offset * $limit_per_page) - $limit_per_page;
            }

            $params['limit'] = $limit_per_page;

            if ($params) {
                $data['results'] = $this->audit_trail->get_audit_trail_records($limit_per_page, $page*$limit_per_page);
            }

            if ($params['start'] === 0) {
                $start_count = 1;
            } else {
                $start_count = $params['start'] + 1;
            }
            $end_count = ($params['start'] + count($params['results']));

            $params['audit_count'] = 'Showing ' . $start_count . ' to ' . $end_count . ' of ' . $config['total_rows'] . ' entries';
            $params['record_count'] = $start_count;
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }

        $data = [
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Audit Trail | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('settings/audit_trail',$params);
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }
}
