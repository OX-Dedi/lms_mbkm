<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		 is_logged_in();
        $this->get_datasess = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $this->load->model('M_Front');
        $this->load->model('M_Admin');
        $this->get_datasetupapp = $this->M_Front->fetchsetupapp();
		$this->load->model('Laporan_model','tb_kelas');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		
		$activities = $this->tb_kelas->get_list_countries();

		$opt = array('' => 'All Activity');
		foreach ($activities as $activity) {
			$opt[$activity] = $activity;

		}
		
		$this->load->helper('url');
		$this->load->helper('form');

		$codes = $this->tb_kelas->get_list_codes();

		$opt1 = array('' => 'All Program');
		foreach ($codes as $program_id) {
			$opt1[$program_id] = $program_id;

		}
                                     
		$this->load->helper('url'); 
		$this->load->helper('form');

		$classes = $this->tb_kelas->get_list_address();

		$opt2 = array('' => 'All Class');
		foreach ($classes as $kelas) {
			$opt2[$kelas] = $kelas;

		}

		$this->load->helper('url'); 
		$this->load->helper('form');

		$semester = $this->tb_kelas->get_list_semester();

		$opt3 = array('' => 'All Semester');
		foreach ($semester as $semester_id) {
			$opt3[$semester_id] = $semester_id;

		}
		

		$data = [
            'title' => 'Laporan',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];

		$data['form_activity'] = form_dropdown('',$opt,'','id="activity" class="form-control"');
		$data['form_program_id'] = form_dropdown('',$opt1,'','id="program_id" class="form-control"');
		$data['form_kelas'] = form_dropdown('',$opt2,'','id="kelas" class="form-control"');
		$data['form_semester_id'] = form_dropdown('',$opt3,'','id="semester_id" class="form-control"');
		
		$this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
		$this->load->view('laporan/laporan_view',$data);
        $this->load->view('layout/footer', $data);



	}

	

	public function ajax_list()
	{
		$list = $this->tb_kelas->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tb_kelas) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $tb_kelas->faculty_id;
			$row[] = $tb_kelas->program_id;
			$row[] = $tb_kelas->semester_id;
			$row[] = $tb_kelas->nama;
			$row[] = $tb_kelas->kelas;
			$row[] = $tb_kelas->activity;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->tb_kelas->count_all(),
						"recordsFiltered" => $this->tb_kelas->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function chart_data()
    {
        $data = $this->Customers_model->chart_db();
        echo json_encode($data);
    }
	public function test(){
		$data['data']=$this->Customers_model->model_activity();

	}

} 