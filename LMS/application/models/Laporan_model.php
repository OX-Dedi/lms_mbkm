<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

	var $table = 'tb_kelas';
	var $column_order = array(null, 'faculty_id','program_id','semester_id','nama','kelas','activity');
	var $column_search = array('faculty_id','program_id','semester_id','nama','kelas','activity'); 
	var $order = array('id' => 'asc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function chart_database(){
        return $this->db->get('tb_kelas')->result();
    }

	private function _get_datatables_query()
	{

		//add custom filter here
		if($this->input->post('activity'))
		{
			$this->db->where('activity', $this->input->post('activity'));
		}
		if($this->input->post('faculty_id'))
		{
			$this->db->like('faculty_id', $this->input->post('faculty_id'));
		}
		if($this->input->post('program_id'))
		{
			$this->db->like('program_id', $this->input->post('program_id'));
		}
		if($this->input->post('semester_id'))
		{ 
			$this->db->like('semester_id', $this->input->post('semester_id'));
		}
		if($this->input->post('kelas'))
		{           
			$this->db->like('kelas', $this->input->post('kelas'));
		}

		$this->db->from($this->table);
		$i = 0;
	
		foreach ($this->column_search as $item)
		{
			if($_POST['search']['value'])
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
         
	public function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_list_countries()
	{
		$this->db->select('activity');
		$this->db->from($this->table);
		$this->db->order_by('activity','asc');
		$query = $this->db->get();
		$result = $query->result();

		$activities = array();
		foreach ($result as $row) 
		{
			$activities[] = $row->activity;
		}
		return $activities;
	}

	public function get_list_codes()
	{
		$this->db->select('program_id');
		$this->db->from($this->table);
		$this->db->order_by('program_id','asc');
		$query = $this->db->get();
		$result = $query->result();

		$codes = array();
		foreach ($result as $row) 
		{
			$codes[] = $row->program_id;
		}
		return $codes;
	}

	public function get_list_address()
	{
		$this->db->select('kelas');
		$this->db->from($this->table);
		$this->db->order_by('kelas','asc');
		$query = $this->db->get();
		$result = $query->result();

		$classes = array();
		foreach ($result as $row) 
		{
			$classes[] = $row->kelas;
		}
		return $classes;
	}
	public function get_list_semester()
	{
		$this->db->select('semester_id');
		$this->db->from($this->table);
		$this->db->order_by('semester_id','asc');
		$query = $this->db->get();
		$result = $query->result();

		$semester = array();
		foreach ($result as $row) 
		{
			$semester[] = $row->semester_id;
		}
		return $semester;
    }

	public function chart_data(){
        return $this->db->get('tb_kelas')->result();
    }

	
	function model_activity(){
        $hasil = $this->db->query("SELECT * FROM tb_kelas order by faculty_id asc");
        return $hasil;
    }


}