<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nilai_model extends CI_Model
{
    private $table = 'tb_nilai';

    //validasi form, method ini akan mengembailkan data berupa rules validasi form       
    public function rules()
    {
        return [
            [
                'field' => 'Nama',  //samakan dengan atribute name pada tags input
                'label' => 'Nama',  // label yang kan ditampilkan pada pesan error
                'rules' => 'trim|required' //rules validasi
            ],
            [
                'field' => 'UTS',
                'label' => 'UTS',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'UAS',
                'label' => 'UAS',
                'rules' => 'trim|required'
            ]
        ];
    }

    //menampilkan data tb_nilai berdasarkan id tb_nilai
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["IdMhsw" => $id])->row();
        //query diatas seperti halnya query pada mysql 
        //select * from tb_nilai where IdMhsw='$id'
    }

    //menampilkan semua data tb_nilai
    public function getAll()
    {
        $this->db->from($this->table);
        $this->db->order_by("IdMhsw", "desc");
        $query = $this->db->get();
        return $query->result();
        //fungsi diatas seperti halnya query 
        //select * from tb_nilai order by IdMhsw desc
    }

    //menyimpan data tb_nilai
    public function save()
    {
        $data = array(
            "Nama" => $this->input->post('Nama'),
            "UTS" => $this->input->post('UTS'),
            "UAS" => $this->input->post('UAS')
        );
        return $this->db->insert($this->table, $data);
    }

    //edit data tb_nilai
    public function update()
    {
        $data = array(
            "Nama" => $this->input->post('Nama'),
            "UTS" => $this->input->post('UTS'),
            "UAS" => $this->input->post('UAS')
        );
        return $this->db->update($this->table, $data, array('IdMhsw' => $this->input->post('IdMhsw')));
    }

    //hapus data tb_nilai
    public function delete($id)
    {
        return $this->db->delete($this->table, array("IdMhsw" => $id));
    }
}