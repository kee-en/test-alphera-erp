<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_training_certificate extends CI_Model
{

    function addTrainingCertificate()
    {
        $data = [
            'cert_code' => $this->input->post('cert_code'),
            'cert_name' => $this->input->post('cert_name'),
            'with_cop' => $this->input->post('with_cop'),
            'required' => $this->input->post('required'),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('a_certificates', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function removeTrainingCertificate($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('a_certificates');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditTrainingCertificate()
    {
        $id = $this->input->post('e_certificate_id');

        $data = [
            'cert_code' => $this->input->post('e_cert_code'),
            'cert_name' => $this->input->post('e_cert_name'),
            'with_cop' => $this->input->post('e_with_cop'),
            'required' => $this->input->post('e_required')
        ];

        $this->db->where('id', $id)->set($data)->update('a_certificates');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllCrewTrainingCertificates()
    {
        return $this->db->where('status', 1)->order_by('date_created', 'DESC')->get('ac_training_certificates')->result_array();
    }
}

/* End of file M_training_certificate.php */
