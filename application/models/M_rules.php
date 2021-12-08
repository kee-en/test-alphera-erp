<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rules extends CI_Model
{

    public $rules = [
        'create_applicant' => [
            ['field' => 's_first_position', 'label' => 'First Position', 'rules' => 'trim|callback_checkSelect'],
            ['field' => 's_second_position', 'label' => 'Second Position', 'rules' => 'trim|callback_checkSelect'],
        ]
    ];
}

/* End of file M_rules.php */
