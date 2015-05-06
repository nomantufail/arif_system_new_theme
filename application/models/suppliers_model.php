<?php
class suppliers_model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        $this->table = "suppliers";
    }

    public function get($orderby = 'asc'){
        $this->db->order_by("name", $orderby);
        $this->active();
        $suppliers = $this->db->get($this->table)->result();
        return $suppliers;
    }
    public function get_limited($limit, $start, $keys, $sort) {

        $this->db->order_by($sort['sort_by'], $sort['order']);

        $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function count() {
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function find($id){
        $this->db->where(array(
            'id'=>$id,
            'deleted'=>0,
        ));
        $result = $this->db->get($this->table)->result();
        if($result){
            $supplier = $result[0];
            return $supplier;
        }else{
            return null;
        }
    }

    public function find_where($where)
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->where('deleted',0);
        $result = $this->db->get($this->table)->result();
        return $result;
    }

    public function insert(){
        $data = array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'address'=>$this->input->post('address'),
        );
        $result = $this->db->insert($this->table, $data);
        if($result == true){
            return true;
        }else{
            return false;
        }
    }

}