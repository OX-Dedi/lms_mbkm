<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

  public function __construct(){

    parent::__construct();
    is_logged_in();
        $this->get_datasess = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->load->model('M_Front');
        $this->load->model('M_Admin');
        $this->get_datasetupapp = $this->M_Front->fetchsetupapp();
    $this->load->helper('url');

    // Load model
    $this->load->model('User_model');

  }

  public function index(){


    $data = [
      'title' => 'Laporan',
      'user' => $this->get_datasess,
      'dataapp' => $this->get_datasetupapp
  ];
    $programs = $this->User_model->getProgram();
    $data['programs'] = $programs;

    $semesters = $this->User_model->getSemester();
    $data['semesters'] = $semesters;

    $namas = $this->User_model->getName();
    $data['namas'] = $namas;

    $kelass = $this->User_model->getKelas();
    $data['kelass'] = $kelass;

    $activitys = $this->User_model->getActivity();
    $data['activitys'] = $activitys;
    
    $totals = $this->User_model->getTotal();
    $data['totals'] = $totals;
    
    // load view
    $this->load->view('layout/header', $data);
    $this->load->view('layout/navbar', $data);
    $this->load->view('layout/sidebar', $data);
    $this->load->view('laporan/user_view',$data);
    $this->load->view('layout/footer', $data);


  }

  public function userList(){

    // POST data
    $postData = $this->input->post();

    // Get data
    $data = $this->User_model->getUsers($postData);

    echo json_encode($data);
  }

}