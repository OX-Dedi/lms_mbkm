<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->get_datasess = $this->db->get_where('user', ['username' =>
		$this->session->userdata('username')])->row_array();
		$this->load->model('M_Front');
		$this->get_datasetupapp = $this->M_Front->fetchsetupapp();
		$timezone_all = $this->get_datasetupapp;
		date_default_timezone_set($timezone_all['timezone']);
		$this->load->model('Laporan_model','tb_kelas');
	}


	public function index()
	{
		if (date("H") < 4) {
			$greet = 'Selamat Malam';
		} elseif (date("H") < 11) {
			$greet = 'Selamat Pagi';
		} elseif (date("H") < 16) {
			$greet = 'Selamat Siang';
		} elseif (date("H") < 18) {
			$greet = 'Selamat Sore';
		} else {
			$greet = 'Selamat Malam';
		}
		$data = [
			'title' => $this->get_datasetupapp['nama_app_absensi'],
			'user' => $this->get_datasess,
			'dataapp' => $this->get_datasetupapp,
			'dbabsensi' => $this->M_Front->fetchdbabsen($this->get_datasess['kode_pegawai']),
			'greeting' => $greet
		];
		$this->load->view('layout/header', $data);
		$this->load->view('layout/navbar', $data);
		$this->load->view('layout/sidebar', $data);
		$this->load->view('front/home', $data);
		$this->load->view('layout/footer', $data);
	}







	//script LMS
	public function date() 
	{
		$data_calendar = $this->modeldb->get_list($this->table);
		$calendar = array();
		foreach ($data_calendar as $key => $val) 
		{
			$calendar[] = array(
							'id' 	=> intval($val->id), 
							'title' => $val->title, 
							'description' => trim($val->description), 
							'start' => date_format( date_create($val->start_date) ,"Y-m-d H:i:s"),
							'end' 	=> date_format( date_create($val->end_date) ,"Y-m-d H:i:s"),
							'color' => $val->color,
							);
		}

		$data = array();
		$data['get_data']= json_encode($calendar);
		$this->load->view('header');
		$this->load->view('Calendar/sidebar');
		$this->load->view('calendar/calendar', $data);
	}

	public function save()
	{
		$response = array();
		$this->form_validation->set_rules('title', 'Title cant be empty ', 'required');
	    if ($this->form_validation->run() == TRUE)
      	{
			$param = $this->input->post();
			$calendar_id = $param['calendar_id'];
			unset($param['calendar_id']);

			if($calendar_id == 0)
			{
		        $param['create_at']   	= date('Y-m-d H:i:s');
		        $insert = $this->modeldb->insert($this->table, $param);

		        if ($insert > 0) 
		        {
		        	
					$response['status'] = TRUE;
		    		$response['notif']	= 'Success add calendar';
		    		$response['id']		= $insert;
		        }
		        else
		        {
		        	$response['status'] = FALSE;
		    		$response['notif']	= 'Server wrong, please save again';
		        }
			}
			else
			{	
				$where = [ 'id'  => $calendar_id];
	            $param['modified_at']   	= date('Y-m-d H:i:s');
	            $update = $this->modeldb->update($this->table, $param, $where);

	            if ($update > 0) 
	            {
	            	$response['status'] = TRUE;
		    		$response['notif']	= 'Success add calendar';
		    		$response['id']		= $calendar_id;
	            }
	            else
		        {
		        	$response['status'] = FALSE;
		    		$response['notif']	= 'Server wrong, please save again';
		        }

			}
	    }
	    else
	    {
	    	$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
	    }
		echo json_encode($response);
	}
	public function delete()
	{
		$response 		= array();
		$calendar_id 	= $this->input->post('id');
		if(!empty($calendar_id))
		{
			$where = ['id' => $calendar_id];
	        $delete = $this->modeldb->delete($this->table, $where);

	        if ($delete > 0) 
	        {
	        	$response['status'] = TRUE;
	    		$response['notif']	= 'Success delete calendar';
	        }
	        else
	        {
	        	$response['status'] = FALSE;
	    		$response['notif']	= 'Server wrong, please save again';
	        }
		}
		else
		{
			$response['status'] = FALSE;
	    	$response['notif']	= 'Data not found';
		}

		echo json_encode($response);
	}


	public function Home()
    {
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('dashboard');
		$data['data']=$this->chart_model->model_act();
        $this->load->view('morris/tabel',$data);
        $this->load->view('morris/trafficbar');
        $this->load->view('dokument/doc');
        $this->load->view('mapping/map');

        $this->load->view('footer');

    }

	public function galery()
    {
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('login/galery');
        $this->load->view('footer'); 
    } 

	public function tabel_mahasiswa(){
        $this->load->view('morris/header');
        $this->load->view('morris/sidebar');
        $data['data']=$this->chart_model->siswa_model();
        $this->load->view('tabel_siswa/mahasiswa',$data);
        $this->load->view('morris/trafficbar');
    }
    public function chart_data()
    {
        $data = $this->chart_model->chart_database();
        echo json_encode($data);
    }

	public function reset()
    {
        $this->load->view('login/reset_password');
    }
    public function in()
    {
        $this->load->view('login/index');
    }
    public function logout()
    {
        $this->load->view('login/logout');
    }
    public function daftar()
    {
        $this->load->view('login/daftar');
    }
    public function kelas_jaringan()
    {
        $this->load->view('kelas/header');
        $this->load->view('kelas/sidebar');
        $this->load->view('kelas/Kelas_Jaringan');
        $this->load->view('footer');;
    }
	
	public function list_mahasiswa(){
		$this->load->view('header');
		$this->load->view('sidebar');
		$data['data']=$this->chart_model->siswa_model();
		$this->load->view('tabel_siswa/mahasiswa',$data);
		$this->load->view('morris/trafficbar');
		$this->load->view('footer');
        
	}
	public function profile(){
		$this->load->view('Profile/header');
		$this->load->view('Profile/sidebar');
		$this->load->view('Profile/Profile');
		$this->load->view('Profile/footer');
	}

	public function tes(){
		$data['data']=$this->chart_model->model_activity();
		$this->load->view('morris/tabel',$data);
	}
	public function user(){
		$this->load->view('header');
		$this->load->view('calendar/sidebar');
		$this->load->model('chart_model');
		$data['pengguna'] = $this->chart_model->getAllUser();
        $this->load->view('pengguna/user', $data);
	}
	public function formTambah()
    {
        $this->load->view('pengguna/form_tambah');
    }
    public function simpanData()
    {
        $this->chart_model->inputData();
        redirect('pengguna/user');
    }
	public function chart_tes()
    {
        $data = $this->chart_model->chart_database();
        echo json_encode($data);
    }
    

}
