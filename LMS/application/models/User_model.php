<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

  // Get DataTable data
  function getUsers($postData=null){

      $response = array();

      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value

      // Custom search filter 
      $searchSemester = $postData['searchSemester'];
      $searchNamas = $postData['searchNamas'];
      $searchKelas = $postData['searchKelas'];
      $searchProgram = $postData['searchProgram'];
      $searchActivity = $postData['searchActivity'];
      $searchTotal = $postData['searchTotal'];
  

      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
      }
      if($searchProgram != ''){
        $search_arr[] = " program_id='".$searchProgram."' ";
    }
      if($searchSemester != ''){
          $search_arr[] = " semester_id='".$searchSemester."' ";
      }
      if($searchNamas != ''){
        $search_arr[] = " nama='".$searchNamas."' ";
    }
    if($searchKelas != ''){
        $search_arr[] = " kelas='".$searchKelas."' ";
    }
    if($searchActivity != ''){
        $search_arr[] = " activity='".$searchActivity."' ";
    }
    if($searchTotal != ''){
        $search_arr[] = " total='".$searchTotal."' ";
    }
      
      if(count($search_arr) > 0){
          $searchQuery = implode(" and ",$search_arr);
      }

      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $records = $this->db->get('tb_kelas')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $records = $this->db->get('tb_kelas')->result();
      $totalRecordwithFilter = $records[0]->allcount;

      ## Fetch records
      $this->db->select('*');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get('tb_kelas')->result();

      $data = array();

      foreach($records as $record ){
         
          $data[] = array( 
              "faculty_id"=>$record->faculty_id,
              "program_id"=>$record->program_id,
              "semester_id"=>$record->semester_id,
              "nama"=>$record->nama,
              "kelas"=>$record->kelas,
              "activity"=>$record->activity,
              "total"=>$record->total,


          ); 
      }

      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );

      return $response; 
  }

  // Get cities array
  
  public function getProgram(){

    ## Fetch records
    $this->db->distinct();
    $this->db->select('program_id');
    $this->db->order_by('program_id','asc');
    $records = $this->db->get('tb_kelas')->result();

    $data = array();

    foreach($records as $record ){
       
        $data[] = $record->program_id;
    }

    return $data;

    }

    public function getSemester(){

        ## Fetch records
        $this->db->distinct();
        $this->db->select('semester_id');
        $this->db->order_by('semester_id','asc');
        $records = $this->db->get('tb_kelas')->result();
    
        $data = array();
    
        foreach($records as $record ){
           
            $data[] = $record->semester_id;
        }
    
        return $data;
    
        }
        public function getName(){

            ## Fetch records
            $this->db->distinct();
            $this->db->select('nama');
            $this->db->order_by('nama','asc');
            $records = $this->db->get('tb_kelas')->result();
        
            $data = array();
        
            foreach($records as $record ){
               
                $data[] = $record->nama;
            }
        
            return $data;
        
            }
            public function getKelas(){

                ## Fetch records
                $this->db->distinct();
                $this->db->select('kelas');
                $this->db->order_by('kelas','asc');
                $records = $this->db->get('tb_kelas')->result();
            
                $data = array();
            
                foreach($records as $record ){
                   
                    $data[] = $record->kelas;
                }
            
                return $data;
            
                }
                public function getActivity(){

                    ## Fetch records
                    $this->db->distinct();
                    $this->db->select('activity');
                    $this->db->order_by('activity','asc');
                    $records = $this->db->get('tb_kelas')->result();
                
                    $data = array();
                
                    foreach($records as $record ){
                       
                        $data[] = $record->activity;
                    }
                
                    return $data;
                
                    }
                    public function getTotal(){

                        ## Fetch records
                        $this->db->distinct();
                        $this->db->select('total');
                        $this->db->order_by('total','asc');
                        $records = $this->db->get('tb_kelas')->result();
                    
                        $data = array();
                    
                        foreach($records as $record ){
                           
                            $data[] = $record->total;
                        }
                    
                        return $data;
                    
                        }
}