<?php
class Chart_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function chart_database(){
        return $this->db->get('tb_kelas')->result();
    }
    function siswa_model(){
        $hasil = $this->db->query("SELECT * FROM tb_supplier order by nama asc");
        return $hasil;
    }

    function model_act(){
        $hasil = $this->db->query("SELECT * FROM tb_kelas order by nama asc");
        return $hasil;
    }
    public function getAllUser(){
        return$this->db->get('pengguna')->result_array();
    }
    public function inputData(){
        $data = [
            "username" => $this->input->post('username', true), //mengamankan data dengan parameter true, pake XSS filter seperti binding
            "email" => $this->input->post('email', true),
            "password" => $this->input->post('password', true)
        ];
        $this->db->insert('pengguna', $data);
    }
}
?>