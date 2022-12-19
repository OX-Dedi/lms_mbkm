<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->table 		= 'calendar';
		$this->load->model('Globalmodel','modeldb'); 
	}

    public function chart_data()
    {
        $data = $this->chart_model->chart_database();
        echo json_encode($data);
    }

}