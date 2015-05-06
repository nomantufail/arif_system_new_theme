<?php
class Source_Destination_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        
        $this->table = "cities";
    }

    public function get(){
        $records = $this->db->get($this->table)->result();
        return $records;
    }
    public function get_limited($limit, $start, $keys, $sort) {

        $this->db->order_by($sort['sort_by'], $sort['order']);
        
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        return $query->result();
    }
    public function count($keys = "") {
        if($keys != "")
        {
            //search queries here
        }
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function find($id){
        $result = $this->db->get_where($this->table, array('id'=>$id))->result();
        if($result){
            $record = $result[0];
            return $record;
        }else{
            return null;
        }
    }

    public function insert(){
       $data = array(
            'name'=>$this->input->post('name'),
        );

        $this->db->trans_start();
        $this->db->insert($this->table, $data);
        return $this->db->trans_complete();
    }

}