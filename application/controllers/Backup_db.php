<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backup_db extends CI_Controller
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
        // init params
        $params = array();
        $limit_per_page = 10;
        $page = ($this->uri->segment(2)) ? ($this->uri->segment(2) - 1) : 0;
        $total_records = $this->m_backup_db->get_archived_count();

        if ($total_records > 0) {
            // get current page records
            $params["results"] = $this->m_backup_db->get_current_page_records($limit_per_page, $page * $limit_per_page);

            $config['base_url'] = base_url('backup-db');
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

            $config['prev_link'] = 'Prev';
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
                $params["results"] = $this->m_backup_db->get_current_page_records($limit_per_page, $page * $limit_per_page);
            } else {
                $params["results"] = $this->m_backup_db->get_current_page_records();
            }

            if ($params['start'] === 0) {
                $start_count = 1;
            } else {
                $start_count = $params['start'] + 1;
            }

            $params['record_count'] = $start_count;
            $end_count = ($params['start'] + count($params['results']));

            $params['backup_count'] = 'Showing ' . $start_count . ' to ' . $end_count . ' of ' . $config['total_rows'] . ' entries';
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }

        $data = [
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Backup Database | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('settings/backup_database', $params);
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function DB_archived()
    {
        $this->load->dbutil();
        $prefs = array(
            'format'      => 'zip',
            'filename'    => 'alphera_backup.sql'
        );


        $backup = $this->dbutil->backup($prefs);

        $db_name = 'alphera-backup-on-' . date("Y-m-d-H-i-s") . '.zip';
        $save = FCPATH . 'backup_db/' . $db_name;

        $backup_file = $this->m_backup_db->archiveDatabase($db_name);

        if ($backup_file === true) {
            $this->load->helper('file');
            write_file($save, $backup);


            $this->load->helper('download');
            force_download($db_name, $backup);
        } else {
            return false;
        }
    }

    public function Delete_db()
    {
        if ($_POST['id'] != NULL) {
            $delete = $this->m_backup_db->deleteArchivedDB($_POST['id']);
            if ($delete === true) {
                $alert = ["title" => 'Deleted Successfully!', "type" => "success"];
            } else {
                $alert = ["title" => 'File Deleted to path, Error deleting on database archives', "type" => "error"];
            }
        } else {
            // Set status
            $alert = ["title" => 'An error occurred when deleting the file', "type" => "error"];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($alert));
    }
}
