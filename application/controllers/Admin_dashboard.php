<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_dashboard extends CI_Controller
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
        $new_applicant = $this->new_applicant->get_new_applicants();
        $on_vacation = $this->ex_crew->get_on_vacation_count();
        $ex_crew = $this->ex_crew->get_ex_crew_count();
        $medical = $this->medical->get_nre_medical_count();
        $nre = $this->nre_crew->get_nre_count();
        $embarked = count($this->embark->getCrewEmbarked());

        foreach ($new_applicant as $key) {
            if ($key['total_count'] <= 1) {
                $new_total = $key['total_count'];
            }else{
                $new_total = 0;
            }
        }

        foreach ($medical as $key) {
            if ($key['total_count'] <= 1) {
                $med_total = $key['total_count'];
            }else{
                $med_total = 0;
            }
        }

        foreach ($nre as $key) {
            if ($key['total_count'] <= 1) {
                $nre_total = $key['total_count'];
            }else{
                $nre_total = 0;
            }
        }

        $data = [
            'new_applicant' => ((!empty($new_total)) ? $new_total : 0),
            'on_vacation'   => ((!empty($on_vacation)) ? count($on_vacation) : 0),
            'ex_crew'       => ((!empty($ex_crew)) ? count($ex_crew) : 0),
            'medical'       => ((!empty($medical)) ? $med_total : 0),
            'nre'           => ((!empty($nre)) ? $nre_total : 0),
            'embark'        => $embarked,
            'author' => "Alphera Marine Services, Inc.",
            'title_tag' => "Dashboard | Alphera Marine Services, Inc.",
            'meta_description' => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('admin/dashboard');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function dashboard_donut()
    {
        $onboard_crew = $this->contracts->get_contract_count();
        $contract_count3 = 0;
        $contract_count2 = 0;
        $contract_count1 = 0;
        $contract_expired = 0;

        if ($onboard_crew) {
            foreach ($onboard_crew as $row) {
                $contract_duration = strtotime($row['contract_duration']);
                $current_date = strtotime(date('Y-m-d'));

                $diff = $contract_duration - $current_date;
                $date_diff = round($diff / (60 * 60 * 24));

                if ($date_diff > 90) {
                    $contract_count3 = count($onboard_crew);
                } else if ($date_diff >= 60 && $date_diff <= 90) {
                    $contract_count3 = count($onboard_crew);
                } else if ($date_diff >= 31 && $date_diff <= 60) {
                    $contract_count2 = count($onboard_crew);
                } else if ($date_diff <= 30 && $date_diff >= 1) {
                    $contract_count1 = count($onboard_crew);
                } else if ($date_diff <= 0) {
                    $contract_expired = count($onboard_crew);
                }
            }
        }

        $data = [
            'contract_green'    => (int)$contract_count3,
            'contract_yellow'   => $contract_count2,
            'contract_red'      => $contract_count1,
            'contract_expired'  => $contract_expired,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function dashboard_peme_donut()
    {
        $medical = $this->medical->get_all_medical();
        $medical_count3 = 0;
        $medical_count2 = 0;
        $medical_count1 = 0;
        $medical_expired = 0;

        if ($medical) {
            foreach ($medical as $row) {
                $contract_duration = strtotime($row['date_med_exam']);
                $current_date = strtotime(date('Y-m-d'));

                $diff = $contract_duration - $current_date;
                $date_diff = round($diff / (60 * 60 * 24));

                if ($date_diff > 90) {
                    $medical_count3 = count($medical);
                } else if ($date_diff >= 60 && $date_diff <= 90) {
                    $medical_count3 = count($medical);
                } else if ($date_diff >= 31 && $date_diff <= 60) {
                    $medical_count2 = count($medical);
                } else if ($date_diff <= 30 && $date_diff >= 1) {
                    $medical_count1 = count($medical);
                } else if ($date_diff <= 0) {
                    $medical_expired = count($medical);
                }
            }
        }

        $data = [
            'medical_green'    => $medical_count3,
            'medical_yellow'   => $medical_count2,
            'medical_red'      => $medical_count1,
            'medical_expired'  => $medical_expired,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_all_expired_certs()
    {
        $result = $this->training_certificate->getAllCrewTrainingCertificates();
        $date = date_create(date('Y-m-d'));
        $expired = 0;
        $valid = 0;
        $days60 = 0;
        $days30 = 0;

        foreach ($result as $key => $value) {
            $expirations = json_decode($value['expiration_date'], true);
            foreach ($expirations as $row) {
                if (!empty($row)) {
                    $expiration = date_create($row);
                    $interval =  date_diff($date, $expiration);
                    $duration = $interval->format('%a');
                    if($date > $row){
                        $expired++;
                    }elseif($interval <= 30 && $interval > 0){
                        $days30++;
                    }elseif ($interval <= 60 && $interval > 30) {
                        $days60++;
                    }elseif ($interval > 60) {
                        $valid++;
                    }
                }
            }
        }

        $data = ['valid' => $valid, 'expired' => $expired, 'sxtydays' => $days60, 'thrtydays' => $days30];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_all_expired_licenses()
    {
        $result = $this->license->getAllLicenses();
        $date = date_create(date('Y-m-d'));
        $expired = 0;
        $valid = 0;
        $days60 = 0;
        $days30 = 0;

        foreach ($result as $key => $value) {
            $expirations = json_decode($value['expiry_date'], true);
            foreach ($expirations as $row) {
                if (!empty($row)) {
                    $expiration = date_create($row);
                    $interval =  date_diff($date, $expiration);
                    $duration = $interval->format('%a');
                    if($row > $date){
                        $expired++;
                    }elseif($duration <= 30 && $duration > 0){
                        $days30++;
                    }elseif ($duration <= 60 && $duration > 30) {
                        $days60++;
                    }elseif ($duration > 60) {
                        $valid++;
                    }
                }
            }
        }

        $data = ['valid' => $valid, 'expired' => $expired, 'sxtydays' => $days60, 'thrtydays' => $days30];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_recruitment_performance_report()
    {
        $total_new_hire = $this->applicant_registered->get_total_newhire();
        $accepted_count = $this->applicant_passed->get_total_passed();
        $per_rank_count = $this->applicant_passed->get_count_per_rank();

        $data = ['total_new_hire' => $total_new_hire, 'accepted_count' => $accepted_count, 'per_rank_count' => $per_rank_count];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
