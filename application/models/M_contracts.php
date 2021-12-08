<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_contracts extends CI_Model
{
    function getContractCrew($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.date_available,
            c.status,
            c.offsigner,
            c.monitor_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.weight,
            acpi.height,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
            ad.department_name
        ");

        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("a_type_of_department ad", "ap.type_of_department = ad.id", "LEFT");

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
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.last_name, acpi.first_name))", strtolower(trim($params['search']['name_search'])));
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

        if (!empty($params['search']['vessel_search'])) {
            $this->db->group_start();
            $this->db->where('c.vessel_assign', $params['search']['vessel_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->group_start();
            $this->db->like('c.position', $params['search']['rank_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['flight_search'])) {
            if ($params['search']['flight_search'] === "1") {
                $this->db->where('c.flight_code !=', NULL);
            } else if ($params['search']['flight_search'] === "0") {
                $this->db->where('c.flight_code !=', NULL);
            }
        }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
            if ($params['search']['status_search'] === '3') {
                $this->db->where('cmp.embark >=', $params['search']['month_search_from']);
                $this->db->where('cmp.embark <=', $params['search']['month_search_to']);
            } else if ($params['search']['status_search'] === '4') {
                $this->db->where('cmp.disembark >=', $params['search']['month_search_from']);
                $this->db->where('cmp.disembark <=', $params['search']['month_search_to']);
            } else if ($params['search']['status_search'] === '7') {
                $this->db->where('c.date_available >=', $params['search']['month_search_from']);
                $this->db->where('c.date_available <=', $params['search']['month_search_to']);
            }
        }

        $this->db->where("c.status", "2");
        $this->db->order_by("c.date_created", "DESC");

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function addPOEAContract()
    {
        $data = [
            'contract_code'         => $this->global->generateID("CRT"),
            'crew_code'             => $this->input->post('c_crew_code'),
            'crew_monitor'          => $this->input->post('c_monitor_code'),
            'sirb_no'               => $this->input->post('c_sirb_no'),
            'src_no'                => $this->input->post('c_src_no'),
            'license'               => $this->input->post('c_license_no'),
            'agent_name'            => $this->input->post('c_name_of_agent'),
            'ps_name'               => $this->input->post('c_name_of_principal'),
            'ps_address'            => $this->input->post('c_address_of_principal'),
            'vessel_name'           => $this->input->post('c_vessel_name'),
            'imo_no'                => $this->input->post('c_imo_number'),
            'grt'                   => $this->input->post('c_gross_tonnage'),
            'year_build'            => date('Y-m-d', strtotime($this->input->post('c_year_built'))),
            'flag'                  => $this->input->post('c_flag'),
            'vessel_type'           => $this->input->post('c_vessel_type'),
            'society_classification' => $this->input->post('c_classification_society'),
            'contract_duration'     => date('Y-m-d', strtotime($this->input->post('c_duration_contract'))),
            'position'              => $this->input->post('c_position'),
            'monthly_salary'        => $this->input->post('c_monthly_salary'),
            'work_hours'            => $this->input->post('c_hours_of_work'),
            'ot'                    => $this->input->post('c_overtime'),
            'vl_pay'                => $this->input->post('c_vacation_leave_with_pay'),
            'others'                => $this->input->post('c_others'),
            'total_salary'          => $this->input->post('c_total_salary'),
            'hire_point'            => $this->input->post('c_point_of_hire'),
            'collective_agreement'  => $this->input->post('c_collective_agreement'),
            'date_created'          => date('Y-m-d H:i:s'),
            'issued_by'             => $this->global->ecdc('dc', $this->session->userdata('user_code')),
            'status'                => 1
        ];

        $crew_data = [
            'disembark' => $this->input->post('c_duration_contract')
        ];

        $this->db->trans_begin();

        $this->db->insert('crew_poea', $data);
        $this->db->where('offsigner', $this->input->post('c_monitor_code'))->update('cm_plan', $crew_data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function addMLCContract()
    {
        $wage = [
            $this->input->post('mlc_bw'), $this->input->post('mlc_ot'), $this->input->post('mlc_pl'), $this->input->post('mlc_sa'),
            $this->input->post('mlc_rb'), $this->input->post('mlc_mts'), $this->input->post('mlc_fksu'), $this->input->post('mlc_mt')
        ];

        $agreement_details = [$this->input->post('mlc_sign_place'), date('Y-m-d', strtotime($this->input->post('mlc_sign_date')))];
        $employment_period = [$this->input->post('mlc_employment_period_from'), $this->input->post('mlc_employment_period_to')];

        $data = [
            'vessel_name'               => $this->input->post('mlc_vessel_name'),
            'vessel_type'               => $this->input->post('mlc_vessel_type'),
            'crew_name'                 => $this->input->post('mlc_farer_name'),
            'duty'                      => $this->input->post('mlc_farer_duty'),
            'birthdate'                 => $this->input->post('mlc_farer_birthdate'),
            'nationality'               => $this->input->post('mlc_farer_nationality'),
            'passport_no'               => $this->input->post('mlc_farer_passport'),
            'mlc_contract_code'         => $this->global->generateID("MLC"),
            'monitor_code'              => $this->input->post('mlc_monitor_code'),
            'crew_code'                 => $this->input->post('mlc_crew_code'),
            'mlc_type'                  => $this->input->post('c_mlc_contract'),
            'form_no'                   => $this->input->post('mlc_form_number'),
            'revision_no'               => $this->input->post('mlc_revision_number'),
            'gender'                    => $this->input->post('mlc_farer_sex'),
            'seamans_book'              => $this->input->post('mlc_farer_book'),
            'license_no'                => $this->input->post('mlc_farer_license'),
            'agreement_details'         => json_encode($agreement_details),
            'wage'                      => json_encode($wage),
            'employment_period'         => json_encode($employment_period),
            'shipowner_vessel'          => $this->input->post('mlc_shipowner_vessel'),
            'name_of_vp'                => $this->input->post('mlc_vp_alphera'),
            'date_created'              => date('Y-m-d H:i:s'),
            'issued_by'                 => $this->global->ecdc('dc', $this->session->userdata('user_code')),
            'status'                    => 1
        ];
        $this->db->insert('crew_mlc', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getCrewContract($crew_code)
    {
        $this->db->select("
        c.*,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        acpi.birth_date,
        acpi.birth_place,
        CONCAT(acpi.street_address, ' ', acpi.barangay) full_address,
        ");
        $this->db->from("crew_poea c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        if ($crew_code) {
            $this->db->where('c.crew_code', $crew_code);
        }
        $this->db->where_not_in('c.status', ['0', '3']);

        $this->db->order_by("c.date_created", "DESC");
        $this->db->group_by('c.crew_code');

        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            $this->db->select("
                c.crew_code,
                c.vessel_assign,
                c.position as c_position,
                CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
                acpi.birth_date,
                acpi.birth_place,
                CONCAT(acpi.street_address, ' ', acpi.barangay) full_address,
                cp.*,
            ");

            $this->db->from("crews c");
            $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
            $this->db->join("crew_poea cp", "c.crew_code = cp.crew_code", "LEFT");
            $this->db->where('c.crew_code', $crew_code);
            $this->db->where_not_in('cp.status', ['0', '3']);
            $this->db->order_by("cp.date_created", "DESC");

            $query = $this->db->get();

            return ($query->num_rows() > 0) ? $query->result_array() : [];
        }
    }


    public function getViewCrewContracts($crew_code, $contract_code)
    {
        $this->db->select("
        c.*,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        acpi.birth_date,
        acpi.birth_place,
        CONCAT(acpi.street_address, ' ', acpi.barangay) full_address,
        ");
        $this->db->from("crew_poea c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
        $this->db->group_by('c.crew_code');
        $this->db->order_by("c.date_created", "DESC");

        if ($crew_code) {
            $this->db->where('c.crew_code', $crew_code);
        }
        if (!empty($contract_code)) {
            $this->db->where('c.contract_code', $contract_code);
        }
        $this->db->where_not_in('c.status', ['0']);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            $this->db->select("
                c.crew_code,
                c.vessel_assign,
                c.position as c_position,
                CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
                acpi.birth_date,
                acpi.birth_place,
                CONCAT(acpi.street_address, ' ', acpi.barangay) full_address,
                cp.*,
            ");

            $this->db->from("crews c");
            $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
            $this->db->join("crew_poea cp", "c.crew_code = cp.crew_code", "LEFT");
            $this->db->where('c.crew_code', $crew_code);
            if (!empty($contract_code)) {
                $this->db->where('cp.contract_code', $contract_code);
            }
            $this->db->where_not_in('cp.status', ['0']);
            $this->db->order_by("cp.date_created", "DESC");

            $query = $this->db->get();

            return ($query->num_rows() > 0) ? $query->result_array() : [];
        }
    }

    public function getCrewContractById($crew_code)
    {

        $this->db->select("
            c.*,
        ");
        $this->db->from("crew_poea c");
        $this->db->where('c.crew_code', $crew_code);
        $this->db->where('c.status', 1);

        return $this->db->get()->row_array();
    }

    public function getCrewContractByContractCode($contract_code)
    {
        $this->db->select("
            c.*,
            v.vsl_name,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.birth_date,
            acpi.birth_place,
            CONCAT(acpi.street_address, ', ', acpi.barangay) address,
            acpi.city,
            acpi.region,
            acpi.country,
            acpi.zip_code
        ");
        $this->db->from("crew_poea c");
        $this->db->join("ac_personal_info acpi", "acpi.crew_code = c.crew_code", "LEFT");
        $this->db->join("a_vessels v", "v.id = c.vessel_name", "LEFT");


        $this->db->where(array('c.contract_code' => $contract_code, 'c.status' => 1));
        $this->db->group_by('c.contract_code');
        $this->db->order_by("c.date_created", "DESC");

        $query = $this->db->get();

        return (($query->num_rows() > 0) ? $query->result_array() : []);
    }

    public function getCrewContractTable($params = array())
    {
        $this->db->select("
        c.*,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        acpi.birth_date,
        acpi.birth_place,
        ");
        $this->db->from("crew_poea c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
        // $this->db->where('c.status', 1);
        $this->db->order_by("c.date_created", "DESC");

        if ($params['crew_code']) {
            $this->db->where('c.crew_code', $params['crew_code']);
        }

        $this->db->where('c.status !=', 0);

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
    public function getMLCTable($params = array())
    {
        $this->db->select("
        mlc.*,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        acpi.birth_date,
        acpi.birth_place,
        ");
        $this->db->from("crew_mlc mlc");
        $this->db->join("ac_personal_info acpi", "mlc.crew_code = acpi.crew_code");

        if ($params['crew_code']) {
            $this->db->where('mlc.crew_code', $params['crew_code']);
        }
        $this->db->where('mlc.status !=', 0);
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->order_by("mlc.date_created", "DESC");
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }


    public function getCrewMlcById($crew_code)
    {

        $this->db->select("
            c.*,
        ");
        $this->db->from("crew_mlc c");
        $this->db->where('c.crew_code', $crew_code);
        $this->db->where_in('c.status', [1, 2]);

        return $this->db->get()->result_array();
    }

    public function getCrewMlcByMonCode($monitor_code)
    {
        $this->db->select("
            mlc.*,
            c.vessel_assign,
            c.position,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.birth_date,
            acpi.birth_place,
            CONCAT(acpi.street_address, ', ', acpi.barangay) address,
            acpi.city,
            acpi.region,
            acpi.country,
            acpi.zip_code,
            acpi.nationality,
            acle.number,
            acpc.position as p_position,
            acpc.vessel as p_vessel
        ");
        $this->db->from("ac_personal_info acpi");
        $this->db->join("crews c", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("crew_mlc mlc", "acpi.crew_code = mlc.crew_code", "LEFT");
        $this->db->join("ac_promoted_crew_onboard acpc", "acpc.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_licenses_endorsement_book_id acle", "acle.crew_code = mlc.crew_code", "LEFT");

        $this->db->where(array('mlc.monitor_code' => $monitor_code, 'mlc.status' => 1));
        $this->db->group_by('mlc.monitor_code');
        $this->db->order_by("mlc.date_created", "DESC");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {
            $this->db->select("
                mlc.*,
                c.vessel_assign,
                c.position,
                CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
                acpi.birth_date,
                acpi.birth_place,
                CONCAT(acpi.street_address, ', ', acpi.barangay) address,
                acpi.city,
                acpi.region,
                acpi.country,
                acpi.zip_code,
                acpi.nationality,
                acle.number,
                acpc.position as p_position,
                acpc.vessel as p_vessel
            ");
            $this->db->from("crews  c");
            $this->db->join("crew_mlc mlc", "c.crew_code = mlc.crew_code", "LEFT");
            $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
            $this->db->join("ac_licenses_endorsement_book_id acle", "acle.crew_code = c.crew_code", "LEFT");
            $this->db->join("ac_promoted_crew_onboard acpc", "acpc.crew_code = c.crew_code", "LEFT");

            $this->db->where(array('c.monitor_code' => $monitor_code));
            $this->db->group_by('c.monitor_code');
            $this->db->order_by("c.date_created", "DESC");

            $query = $this->db->get();

            return $query->result_array();
        }
    }

    public function get_crew_mlc_for_promotion($monitor_code)
    {
        $this->db->select("
            c.position,
            c.vessel_assign,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.birth_date,
            acpi.birth_place,
            CONCAT(acpi.street_address, ', ', acpi.barangay) address,
            acpi.city,
            acpi.region,
            acpi.country,
            acpi.zip_code,
            acpi.nationality,
            acle.number,
            acpc.position as p_position,
            acpc.vessel as p_vessel
        ");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "acpi.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_promoted_crew_onboard acpc", "acpc.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_licenses_endorsement_book_id acle", "acle.crew_code = c.crew_code", "LEFT");

        $this->db->where('c.monitor_code', $monitor_code);
        $this->db->or_where('c.crew_code', $monitor_code);
        $this->db->group_by('c.monitor_code');
        $this->db->order_by("c.date_created", "DESC");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function remove_poe_contract($contract_code)
    {
        $this->db->where('contract_code', $contract_code)->set('status', 0)->update('crew_poea');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function remove_mlc_contract($mlc_code)
    {
        $this->db->where('monitor_code', $mlc_code)->set('status', 0)->update('crew_mlc');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_contract_count()
    {
        $this->db->select("
        cp.*,
        c.crew_code
        ");
        $this->db->from("crew_poea cp");
        $this->db->join("crews c", "c.crew_code = cp.crew_code");
        $this->db->where('c.status', 3);
        $this->db->group_by('c.position');
        $this->db->order_by("c.date_created", "DESC");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function addMLCContractPromotion()
    {
        $crew_code = $this->input->post('crew_code');

        $wage = [
            $this->input->post('edit_mlc_bw'), $this->input->post('edit_mlc_ot'), $this->input->post('edit_mlc_pl'), $this->input->post('edit_mlc_sa'),
            $this->input->post('edit_mlc_rb'), $this->input->post('edit_mlc_mts'), $this->input->post('edit_mlc_fksu'), $this->input->post('edit_mlc_mt')
        ];

        $agreement_details = [$this->input->post('edit_mlc_sign_place'), date('Y-m-d', strtotime($this->input->post('edit_mlc_sign_date')))];
        $employment_period = [$this->input->post('edit_mlc_employment_period_from'), $this->input->post('edit_mlc_employment_period_to')];

        $data = [
            'agreement_details'         => json_encode($agreement_details),
            'wage'                      => json_encode($wage),
            'employment_period'         => json_encode($employment_period),
            'shipowner_vessel'          => $this->input->post("edit_mlc_shipowner_vessel"),
            'name_of_vp'                => $this->input->post("edit_mlc_vp_alphera"),
            'passport_no'               => $this->input->post("edit_mlc_farer_passport"),
            'license_no'                => $this->input->post("edit_mlc_farer_license"),
            'date_updated'              => date('Y-m-d')
        ];

        $this->db->trans_begin();

        $this->db->where(array('crew_code' => $crew_code, 'status' => 1))->update('crew_mlc', $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_poea_promotion()
    {
        $crew_code = $this->input->post('hid_crew_code');
        $monitor_code = $this->global->getCrew($crew_code)['monitor_code'];

        $data = [
            'sirb_no'               => $this->input->post('e_sirb_no'),
            'src_no'                => $this->input->post('e_src_no'),
            'license'               => $this->input->post('e_license_no'),
            'agent_name'            => $this->input->post('e_name_of_agent'),
            'ps_name'               => $this->input->post('e_name_of_principal'),
            'ps_address'            => $this->input->post('e_address_of_principal'),
            'vessel_name'           => $this->input->post('e_vessel_name'),
            'imo_no'                => $this->input->post('e_imo_number'),
            'grt'                   => $this->input->post('e_gross_tonnage'),
            'year_build'            => date('Y-m-d', strtotime($this->input->post('e_year_built'))),
            'flag'                  => $this->input->post('e_flag'),
            'vessel_type'           => $this->input->post('e_vessel_type'),
            'society_classification' => $this->input->post('e_classification_society'),
            'contract_duration'     => date('Y-m-d', strtotime($this->input->post('e_duration_contract'))),
            'position'              => $this->input->post('e_position'),
            'monthly_salary'        => $this->input->post('e_monthly_salary'),
            'work_hours'            => $this->input->post('e_hours_of_work'),
            'ot'                    => $this->input->post('e_overtime'),
            'vl_pay'                => $this->input->post('e_vacation_leave_with_pay'),
            'others'                => $this->input->post('e_others'),
            'total_salary'          => $this->input->post('e_total_salary'),
            'hire_point'            => $this->input->post('e_point_of_hire'),
            'collective_agreement'  => $this->input->post('e_collective_agreement'),
            'date_updated'          => date('Y-m-d H:i:s'),
        ];

        $crew_data = [
            'disembark' => $this->input->post('e_duration_contract')
        ];
        $this->db->trans_begin();

        $this->db->where(array('crew_monitor' => $monitor_code, 'status' => 1))->update('crew_poea', $data);
        $this->db->where('offsigner', $monitor_code)->update('cm_plan', $crew_data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }


    public function updateDisemContDateCMPlan($monitor_code)
    {
        $this->db->where('offsigner', $monitor_code)->set('disembark', NULL)->update('cm_plan');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function getCrewPOEA($crew_code)
    {
        return $this->db->where(array("crew_code" => $crew_code, "status !=" => 0))->order_by("date_created DESC")->limit(1)->get("crew_poea")->row_array();
    }


    public function updateContractOngoing()
    {
        $crew_code = $this->input->post("crew_code");

        $contract = $this->db->where(array("crew_code" => $crew_code, "status =" => 1))->order_by("date_created", "DESC")->limit(1)->get("crew_poea")->row_array();

        $mlc = $this->db->where(array("crew_code" => $crew_code, "status =" => 1))->order_by("date_created", "DESC")->limit(1)->get("crew_mlc")->row_array();

        if (!empty($contract) && !is_null($contract) || !empty($mlc) && !is_null($mlc)) {

            $contract_code = $contract["contract_code"];
            $mlc_contract_code = $mlc["mlc_contract_code"];

            $this->db->trans_begin();

            $this->db->where("contract_code", $contract_code)->set("status", 2)->update('crew_poea');
            $this->db->where("mlc_contract_code", $mlc_contract_code)->set("status", 2)->update('crew_mlc');

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } else {
            return false;
        }
    }
}
