<?php
class Stock_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        
        $this->table = "stock";
    }

    public function get(){
        $this->db->select("stock.id as stock_id, stock.product_id, products.name as product_name,
        stock.quantity, stock.tanker, stock.price_per_unit,
        ");
        $this->db->from('stock');
        $this->db->join('products','products.id = stock.product_id','left');
        $records = $this->db->get()->result();
        $grouped = Arrays::groupBy($records, Functions::extractField('product_name'));
        ksort($grouped);
        return $grouped;
    }
    public function get_limited($limit, $start, $keys, $sort) {

        $this->db->order_by($sort['sort_by'], $sort['order']);
        if($keys['agent_id'] != '')
        {
            $this->db->where('id',$keys['agent_id']);
        }
        
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
        $result = $this->db->get_where($this->table, array('id'=>$id))->result();
        if($result){
            $record = $result[0];
            return $record;
        }else{
            return null;
        }
    }

    public function generate_where_statement_for_updating_stock($stock_entries)
    {
        $where = "(";
        foreach($stock_entries as $entry)
        {
            /**
             * -----------------------
             *Making Where Statement
             * to update stock entries
             *------------------------
             * */
            $where.="(products.name = '".$entry['product_name']."' && stock.tanker = '".$entry['tanker']."') OR";
            /*--------------------------------*/
        }
        $where .="__cut";
        $where_parts = explode(' OR__cut',$where);
        $where = $where_parts[0];
        $where.=')';
        return $where;
    }
    public function process_product_quantities($stock_entries)
    {
        $product_quantities = array();
        foreach($stock_entries as $entry)
        {
            if(isset($product_quantities[$entry['product_name']]))
            {
                $product_quantities[$entry['product_name']] += $entry['quantity'];

            }
            else
            {
                $product_quantities[$entry['product_name']] = $entry['quantity'];
            }
        }
        //var_dump($product_quantities); die();
        return $product_quantities;
    }

    /**
     * Below function is used to generate seperate price per units
     * for each stock entry
     **/
    public function process_price_per_units($stock_entries)
    {
        $price_per_units = array();
        foreach($stock_entries as $entry)
        {
                $price_per_units[$entry['product_name']] = $entry['cost_per_item'];
        }
        return $price_per_units;
    }
    public function increase($stock_entries, $purchase_id)
    {
        $product_quantities = $this->process_product_quantities($stock_entries);
        $price_per_units = $this->process_price_per_units($stock_entries);
        if(sizeof($stock_entries) > 0)
        {
            $this->db->trans_start();

            $where_statement = $this->generate_where_statement_for_updating_stock($stock_entries);
            $this->db->select('stock.id as stock_id, products.id as product_id, products.name as product_name, stock.quantity, stock.tanker,');
            $this->db->from($this->table);
            $this->db->join('products','products.id = stock.product_id', 'left');
            $this->db->where($where_statement);
            $result = $this->db->get()->result();
            $modified_stock_entries = array();
            foreach($result as $record)
            {
                $modified_stock_entry = array(
                    'id' => $record->stock_id,
                    'quantity' => $record->quantity + $product_quantities[$record->product_name],
                    'price_per_unit' =>$price_per_units[$record->product_name],
                    'tanker'=>$stock_entries[0]['tanker'],
                    'purchase_id'=>$purchase_id,
                    'updated_at' => date('Y-m-d h:i:s', time()),
                );
                array_push($modified_stock_entries, $modified_stock_entry);
            }
            if(sizeof($modified_stock_entries) > 0)
            {
                $this->db->update_batch($this->table, $modified_stock_entries, 'id');
            }

            return $this->db->trans_complete();
        }
        return false;


    }
    public function decrease($stock_entries)
    {
        $product_quantities = $this->process_product_quantities($stock_entries);
        if(sizeof($stock_entries) > 0)
        {
            $this->db->trans_start();

            $where_statement = $this->generate_where_statement_for_updating_stock($stock_entries);
            $this->db->select('stock.id as stock_id, products.id as product_id, products.name as product_name, stock.quantity, stock.tanker');
            $this->db->from($this->table);
            $this->db->join('products','products.id = stock.product_id', 'left');
            $this->db->where($where_statement);
            $result = $this->db->get()->result();
            $modified_stock_entries = array();
            foreach($result as $record)
            {
                $modified_stock_entry = array(
                    'id' => $record->stock_id,
                    'quantity' => $record->quantity - $product_quantities[$record->product_name],
                    'updated_at' => date('Y-m-d h:i:s', time()),
                );
                array_push($modified_stock_entries, $modified_stock_entry);
            }
            if(sizeof($modified_stock_entries) > 0)
            {
                $this->db->update_batch($this->table, $modified_stock_entries, 'id');
            }

            return $this->db->trans_complete();
        }
        return false;
    }



    public function insert_product($product_id, $qty){

        /*fetching tankers*/
        $tankers = $this->tankers_model->get();
        if(sizeof($tankers) > 0)
        {
            $stock = array();
            foreach($tankers as $tanker)
            {
                $data = array(
                    'product_id'=>$product_id,
                    'tanker'=>$tanker->number,
                    'quantity'=>$qty,
                );
                array_push($stock, $data);
            }

            $result = $this->db->insert_batch($this->table, $stock);
            if($result == true){
                return true;
            }else{
                return false;
            }
        }
        else
        {
            return true;
        }

    }
    public function insert_tanker($tanker){

        /*fetching tankers*/
        $products = $this->products_model->get();
        if(sizeof($products) > 0)
        {
            $stock = array();
            foreach($products as $product)
            {
                $data = array(
                    'product_id'=>$product->id,
                    'tanker'=>$tanker,
                    'quantity'=>0,
                );
                array_push($stock, $data);
            }

            $result = $this->db->insert_batch($this->table, $stock);
            if($result == true){
                return true;
            }else{
                return false;
            }
        }
        else
        {
            return true;
        }
    }

    public function busy_tankers()
    {
        $this->db->select("stock.tanker");
        $this->db->distinct();
        $this->db->where('stock.quantity >',0);
        $result = $this->db->get($this->table)->result();
        return $result;
    }

}