<?php
class Withdrawls_model extends Parent_Model {

    public function __construct(){
        parent::__construct();
        
        $this->table = "vouchers";
    }

    public function get(){
        $this->select_expense_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active();
        $this->expense_payable_vouchers();
        $this->with_debit_entries_only();
        $this->latest($this->table);
        $result = $this->db->get()->result();

        return $result;
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

    public function withdraw(){
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");

        $voucher = new App_Voucher();
        $voucher->voucher_date = $this->input->post('voucher_date');
        $voucher->summary = $this->input->post('summary');
        $voucher->voucher_type = 'withdraw';

        $bank_account = $this->input->post('bank_ac');
        $bank_account_parts = explode('_&&_',$bank_account);
        $account_title = $bank_account_parts[0];
        $sub_title = $bank_account_parts[1];

        $voucher_entries = array();


        /*---------First ENTRY--------*/
        $voucher_entry_1 = new App_voucher_Entry();
        $voucher_entry_1->ac_title = $this->input->post('withdraw_account');
        $voucher_entry_1->ac_sub_title = '';
        $voucher_entry_1->ac_type = 'dividend';
        $voucher_entry_1->amount = $this->input->post('amount');
        $voucher_entry_1->dr_cr = 1;

        array_push($voucher_entries, $voucher_entry_1);
        /*----------------------------------*/

        /*---------Second ENTRY--------*/
        $voucher_entry_2 = new App_voucher_Entry();
        $voucher_entry_2->ac_title = $account_title;
        $voucher_entry_2->ac_sub_title = $sub_title;
        $voucher_entry_2->ac_type = 'bank';
        $voucher_entry_2->amount = $this->input->post('amount');
        $voucher_entry_2->dr_cr = 0;

        array_push($voucher_entries, $voucher_entry_2);
        /*----------------------------------*/


        /*------------inserting voucher entries in the voucher container---------*/
        $voucher->entries = $voucher_entries;
        /*---------------------------------------------------------------------*/

        /*--------------Lets the game begin---------------*/
        $this->db->trans_begin();

        $voucher_inserted = $this->accounts_model->insert_voucher($voucher);


        if($this->db->trans_status() == false || $voucher_inserted == false)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return $voucher_inserted;
        }
        return false;
    }

    public function withdraw_history()
    {
        include_once(APPPATH."models/helperClasses/Withdraw_Entry.php");

        $this->select_whole_voucher_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active();
        $this->withdraw_vouchers();
        $this->latest($this->table);
        $result = $this->db->get()->result();

        $journal = $this->accounts_model->make_vouchers_from_raw($result);
        $withdrawls = array();
        foreach($journal as $voucher)
        {
            array_push($withdrawls, new Withdraw_Entry($voucher));
        }
        return $withdrawls;
    }

    public function few_withdrawls()
    {
        include_once(APPPATH."models/helperClasses/Withdraw_Entry.php");

        $this->select_whole_voucher_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active();
        $this->withdraw_vouchers();
        $this->db->limit(10);
        $this->latest($this->table);
        $result = $this->db->get()->result();

        $journal = $this->accounts_model->make_vouchers_from_raw($result);
        $withdrawls = array();
        foreach($journal as $voucher)
        {
            array_push($withdrawls, new Withdraw_Entry($voucher));
        }
        return $withdrawls;
    }

    public function accounts()
    {
        $this->select_withdraw_accounts_content();
        $this->db->from('withdraw_accounts');
        $this->db->order_by('title','asc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function add_account()
    {
        $data = array(
            'title'=>$this->input->post('title'),
            'description'=>$this->input->post('description'),
        );
        $result = $this->db->insert('withdraw_accounts', $data);
        return $result;
    }
}