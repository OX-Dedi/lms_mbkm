<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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
        $this->table 		=('calendar');
		$this->load->model('Globalmodel','modeldb'); 
    }

    public function calendar() 
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
		$data['get_data']			= json_encode($calendar);
        $data = [
            'title' => 'Agenda',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout-e-learning/sidebar', $data);
		$this->load->view('calendar/calendar', $data);
        $this->load->view('layout/footer', $data);
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
				$where 		= [ 'id'  => $calendar_id];
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



    public function settingapp()
    {
        is_admin();
        $data = [
            'title' => 'Setting Aplikasi',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin_oasis/settingapp', $data);
        $this->load->view('layout/footer', $data);
    }

    public function dashboard()
    {
        is_admin();
        $data = [
            'title' => 'Dashboard Absensi',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $data['jmlpegawai'] = $this->M_Admin->hitungjumlahdata('jmlpgw');
        $data['pegawaitelat'] = $this->M_Admin->hitungjumlahdata('pgwtrl');
        $data['pegawaimasuk'] = $this->M_Admin->hitungjumlahdata('pgwmsk');
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin_oasis/dashboard', $data);
        $this->load->view('layout/footer', $data);
    }

    public function datapegawai()
    {
        is_admin();
        $data = [
            'title' => 'Data Mahasiswa',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp,
            'fetchdbpegawai' => $this->M_Admin->fetchlistpegawai()
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin_oasis/datapegawai', $data);
        $this->load->view('layout/footer', $data);
    }

    public function absensi()
    {
        is_moderator();
        $data = [
            'title' => 'Kehadiran Mahasiswa',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout-e-learning/sidebar', $data);
        $this->load->view('admin_oasis/absenpegawai', $data);
        $this
        ->load->view('layout/footer', $data);
    }

    public function kelasku()
    {
        $data = [
            'title' => 'E-Learning',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout-e-learning/sidebar', $data);
        $this->load->view('daftar_kelas/e-learning');
        $this->load->view('layout/footer', $data);
    }

    public function laporan()
    {
        $data = [
            'title' => 'Laporan',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $data['Laporan'] = $this->Laporan_model->get_datatables();
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout-e-learning/sidebar', $data);
        $this->load->view('laporan/laporan_view');
        $this->load->view('layout/footer', $data);
    }

     public function Kelas_jaringan()
    {
        $data = [
            'title' => 'Kelas_Jaringan',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout-e-learning/sidebar', $data);
        $this->load->view('kelas/kelas_jaringan');
        $this->load->view('layout/footer', $data);
    }

    public function nilai()
    {
        $data = [
            'title' => 'Nilai',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout-e-learning/sidebar', $data);
        $this->load->view('nilai/nilai_view');
        $this->load->view('layout/footer', $data);
    }

    public function chart()
    {
        $data = [
            'title' => 'Chart',
            'user' => $this->get_datasess,
            'dataapp' => $this->get_datasetupapp
        ];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('custom/bar');
        $this->load->view('layout/footer', $data);
    }    
}
