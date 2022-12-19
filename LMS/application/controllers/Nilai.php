<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nilai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->get_datasess = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->load->model('M_Front');
        $this->load->model('M_Admin');
        $this->get_datasetupapp = $this->M_Front->fetchsetupapp();
        $this->load->model("Nilai_model"); //load model mahasiswa
    }
    //method pertama yang akan di eksekusi
    public function index()
    {
        $data = [
            'title' => 'Nilai',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        //ambil fungsi getAll untuk menampilkan semua data mahasiswa
        $data["data_mahasiswa"] = $this->Nilai_model->getAll();
        //load view header.php pada folder views/templates
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/header', $data);
        $this->load->view('layout-e-learning/sidebar',$data);
        //load view index.php pada folder views/mahasiswa
        $this->load->view('nilai/nilai_view', $data);
        $this->load->view('layout/footer',$data);
    }

    //method add digunakan untuk menampilkan form tambah data mahasiswa
    public function add()
    {
        $Nilai = $this->Nilai_model; //objek model
        $validation = $this->form_validation; //objek form validation
        $validation->set_rules($Nilai->rules()); //menerapkan rules validasi pada Nilai_model
        //kondisi jika semua kolom telah divalidasi, maka akan menjalankan method save pada Nilai_model
        if ($validation->run()) {
            $Nilai->save();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Nilai berhasil disimpan. 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>');
            redirect("Nilai/Index");
        }

        $data = [
            'title' => 'Add Data',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/header', $data);
        $this->load->view('layout-e-learning/sidebar',$data);
        $this->load->view('nilai/add', $data);
        $this->load->view('layout/footer',$data);
    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('Nilai');

        $Nilai = $this->Nilai_model;
        $validation = $this->form_validation;
        $validation->set_rules($Nilai->rules());

        if ($validation->run()) {
            $Nilai->update();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Nilai berhasil disimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>');
            redirect("Nilai/Index");
        }
        $data = [
            'title' => 'Edit Data',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $data["data_mahasiswa"] = $Nilai->getById($id);
        if (!$data["data_mahasiswa"]) show_404();
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout-e-learning/sidebar', $data);
        $this->load->view('layout/header', $data);
        $this->load->view('nilai/edit', $data);
        $this->load->view('layout/footer');
    }

    public function delete()
    {
        $id = $this->input->get('id');
        if (!isset($id)) show_404();
        $this->Nilai_model->delete($id);
        $msg['success'] = true;
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data Nilai berhasil dihapus.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>');
        $this->output->set_output(json_encode($msg));
    }
}