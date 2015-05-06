<?php
class Bank_Ac_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        
        $this->table = "user_bank_accounts";
    }

    public function get(){
        $this->active();
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
            if($keys['agent_id'] != '')
            {
                $this->db->where('id',$keys['agent_id']);
            }
        }
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function find($id){
        $this->active();
        $result = $this->db->get_where($this->table, array('id'=>$id))->result();
        if($result){
            $record = $result[0];
            return $record;
        }else{
            return null;
        }
    }

    public function find_where($where)
    {
        $this->active();
        $this->db->where($where);
        $result = $this->db->get($this->table)->result();
        return $result;
    }

    public function insert(){
       $data = array(
           'title'=>$this->input->post('title'),
           'account_number'=>$this->input->post('account_number'),
           'bank'=>$this->input->post('bank'),
           'type'=>$this->input->post('type'),
        );
        $result = $this->db->insert($this->table, $data);
        if($result == true){
            return true;
        }else{
            return false;
        }
    }

}