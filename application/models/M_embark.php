<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_embark extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }


    function getCrewEmbarked2($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.monitor_code,
            c.date_available,
            cc.contract_duration,
            c.status,
            cm.insigner,
            cm.offsigner,
            cm.embark,
            cm.disembark,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
        ");

        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("(SELECT * FROM crew_poea ORDER BY id DESC LIMIT 1) cc", "c.monitor_code = cc.crew_monitor", "LEFT");
        $this->db->join("cm_plan cm", "c.monitor_code = cm.offsigner", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");

        $this->db->where("c.status", 3);

        if (!empty($params['search']['contract_search'])) {
            $this->db->group_start();

            $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
            $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");

            if ($params['search']['contract_search'] === "+30 days") {
                // LESS THAN 30 DAYS
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else if ($params['search']['contract_search'] === "+60 days") {
                // LESS THAN 60 DAYS
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else if ($params['search']['contract_search'] === "+90 days") {
                // LESS THAN 90 DAYS
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else {
                // 90 ABOVE
                $this->db->where('cp.contract_duration >=', $NewDate);
            }
            $this->db->group_end();
        }


        if (!empty($params['search']['name_search'])) {
            $this->db->group_start();
            $this->db->like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.middle_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->group_end();
        }

        if (!empty($params['search']['vessel_search'])) {
            $this->db->group_start();
            $this->db->where('c.vessel_assign', $params['search']['vessel_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->group_start();
            $this->db->where('c.position', $params['search']['rank_search']);
            $this->db->group_end();
        }


        // if (!empty($params['search']['name_search'])) {
        //     $this->db->group_start();
        //     $this->db->or_like('acpi.middle_name', $params['search']['name_search']);
        //     $this->db->group_end();
        // }
        // if (!empty($params['search']['name_search'])) {
        //     $this->db->group_start();
        //     $this->db->or_like('acpi.last_name', $params['search']['name_search']);
        //     $this->db->group_end();
        // }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
            $this->db->where('cmp.embark >=', $params['search']['month_search_from']);
            $this->db->where('cmp.embark <=', $params['search']['month_search_to']);
        }


        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->order_by("c.date_created", "DESC");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function getCrewEmbarked($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.monitor_code,
            c.date_available,
            c.status,
            cm.insigner,
            cm.offsigner,
            cm.embark,
            cm.disembark,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
        ");

        $this->db->from("crews c");
        $this->db->join("cm_plan cm", "c.monitor_code = cm.offsigner", "LEFT");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");

        $this->db->where("c.status", 3);

        if (!empty($params['search']['contract_search'])) {
            $this->db->group_start();
            $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
            $this->db->where('cm.disembark >=', $NewDate);
            $this->db->group_end();
        }


        if (!empty($params['search']['name_search'])) {
            $this->db->group_start();
            $this->db->like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.middle_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.last_name, acpi.first_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->group_end();
        }

        if (!empty($params['search']['vessel_search'])) {
            $this->db->group_start();
            $this->db->where('c.vessel_assign', $params['search']['vessel_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->group_start();
            $this->db->where('c.position', $params['search']['rank_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
            $this->db->group_start();
            $this->db->where('cmp.embark >=', $params['search']['month_search_from']);
            $this->db->where('cmp.embark <=', $params['search']['month_search_to']);
            $this->db->group_end();
        }


        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->order_by("c.date_created", "DESC");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_contract_validity($crew_code)
    {
        $contract = $this->contracts->getCrewContract($crew_code);
        $contract_validity = "";

        if ($contract) {
            foreach ($contract as $row) {
                $contract_duration = strtotime($row['contract_duration']);
                $current_date = strtotime(date('Y-m-d'));

                $diff = $contract_duration - $current_date;

                $date_diff = round($diff / (60 * 60 * 24));

                if ($date_diff > 31 && $date_diff <= 60) {
                    $contract_validity .= '<li class="list-group-item" style="background: #fffeca">';
                } else if ($date_diff <= 30) {
                    $contract_validity .= '<li class="list-group-item" style="background: #ffcfca">';
                } else {
                    $contract_validity .= '<li class="list-group-item">';
                }
            }
        } else {
            $contract_validity .= '<li class="list-group-item">';
        }

        return $contract_validity;
    }


    public function getOffSignerDisembark($offsigner_monitor_code)
    {
        return $this->db->select("disembark")->where("offsigner", $offsigner_monitor_code)->get("cm_plan")->row_array();
    }

    public function getOnSignerDisembark($onsigner_monitor_code)
    {
        return $this->db->select("disembark")->where("offsigner", $onsigner_monitor_code)->get("cm_plan")->row_array();
    }


    public function selectOnsignerForEmbark()
    {
        $offsigner_mnt_code = $this->input->post("a_offsigner");
        $embark_date = $this->input->post("a_embarked_date");
        $disembark_date = $this->input->post("a_disembarked_date");
        $onsigner_mnt_code = $this->input->post("onsigner_mnt_code");

        $crew = $this->db->where('monitor_code', $onsigner_mnt_code)->get('crews')->row_array();
        $cm_plan = $this->db->where('offsigner', $offsigner_mnt_code)->get('cm_plan')->row_array();

        $crew_history = [
            'crew_code' => $crew['crew_code'],
            'monitor_code' => $crew['monitor_code'],
            'crew_status' => $crew['status'],
            'issued_by' => $this->global->ecdc('ec', $this->session->userdata('user_code')),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->insert('crew_history', $crew_history);
        $this->db->where('offsigner', $offsigner_mnt_code)->set('insigner', $onsigner_mnt_code)->update('cm_plan');
        $this->db->where('monitor_code', $onsigner_mnt_code)->set('offsigner', $offsigner_mnt_code)->set("embark_date", $embark_date)->update('crews');
        $this->db->where('offsigner', $onsigner_mnt_code)->set("disembark", $disembark_date)->update('cm_plan');
        $this->db->where(array("crew_code" => $crew['crew_code'], "status" => "2"))->set("contract_duration", $disembark_date)->order_by("date_created DESC")->limit(1)->update('crew_poea');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}

/* End of file M_embark.php */
