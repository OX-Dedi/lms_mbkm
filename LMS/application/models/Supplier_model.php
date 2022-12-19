<?php
class Supplier_model extends CI_Model{
    ///AJAX
    var $table = 'tb_supplier';     
    var $column_order = array(null,'nip','nama','kode_dosen','course_view','resource','activity','sra',null); 
    //set column field database for datatable orderable    
    var $column_search = array('nip','nama','kode_dosen','course_view','resource','activity','sra'); 
    //set column field database for datatable searchable just firstname , lastname , address are searchable     
    var $order = array('id_supplier' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
      
        $this->db->from($this->table);

        $i = 0;
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
              
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }else{
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
        else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
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

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_supplier',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('id_supplier', $id);
        $this->db->delete($this->table);
    }




//<!---------------------------------------------------->
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
        $searchKodeDosen = $postData['searchKodeDosen'];
        $searchGender = $postData['searchGender'];
        $searchName = $postData['searchName'];
        $searchEmail = $postData['searchEmail'];
   
        ## Search 
        $search_arr = array();
        $searchQuery = "";
        if($searchValue != ''){
           $search_arr[] = " (name like '%".$searchValue."%' or 
            email like '%".$searchValue."%' or 
            city like'%".$searchValue."%' ) ";
        }
        if($searchKodeDosen != ''){
           $search_arr[] = " city='".$searchKodeDosen."' ";
        }
        if($searchGender != ''){
           $search_arr[] = " gender='".$searchGender."' ";
        }
        if($searchName != ''){
           $search_arr[] = " name like '%".$searchName."%' ";
        }
        if(count($search_arr) > 0){
           $searchQuery = implode(" and ",$search_arr);
        }
   
        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get('users')->result();
        $totalRecords = $records[0]->allcount;
   
        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $records = $this->db->get('users')->result();
        $totalRecordwithFilter = $records[0]->allcount;
   
        ## Fetch records
        $this->db->select('*');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get('users')->result();
   
        $data = array();
   
        foreach($records as $record ){
   
          $data[] = array( 
            "username"=>$record->username,
            "name"=>$record->name,
            "email"=>$record->email,
            "gender"=>$record->gender,
            "city"=>$record->city
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
      public function getCities(){
   
        ## Fetch records
        $this->db->distinct();
        $this->db->select('city');
        $this->db->order_by('city','asc');
        $records = $this->db->get('users')->result();
   
        $data = array();
   
        foreach($records as $record ){
           $data[] = $record->city;
        }
   
        return $data;
      }
    ///END OF AJAX MODEL
}