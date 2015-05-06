<?php
class Payments_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();

        $this->table = "vouchers";
    }

    public function total_payables()
    {
        $this->db->select('SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr');
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active();
        $this->payables();
        $this->db->group_by('voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $total_debit = 0;
        $total_credit = 0;

        if(sizeof($result) > 0)
        {
            foreach($result as $record)
            {
                if($record->dr_cr == 1)
                {
                    $total_debit = $record->total_amount;
                }
                else if($record->dr_cr == 0)
                {
                    $total_credit = $record->total_amount;
                }
            }
        }

        return round($total_credit - $total_debit, 3);
    }

    public function insert_payment()
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");

        $voucher = new App_Voucher();
        $voucher->voucher_date = $this->input->post('voucher_date');
        $voucher->summary = $this->input->post('summary');
        $voucher->voucher_type = 'payment';

        $voucher_entries = array();

        $bank_account = $this->input->post('bank_ac');
        $bank_account_parts = explode('_&&_',$bank_account);
        $account_title = $bank_account_parts[0];
        $sub_title = $bank_account_parts[1];

        /*---------First ENTRY--------*/
        $voucher_entry_1 = new App_voucher_Entry();
        $voucher_entry_1->ac_title = 'cash';
        $voucher_entry_1->ac_sub_title = '';
        $voucher_entry_1->ac_type = 'payable';
        $voucher_entry_1->related_supplier = $this->input->post('supplier');
        $voucher_entry_1->amount = $this->input->post('amount');
        $voucher_entry_1->dr_cr = 1;

        array_push($voucher_entries, $voucher_entry_1);
        /*----------------------------------*/

        /*---------Second ENTRY--------*/
        $voucher_entry_2 = new App_voucher_Entry();
        $voucher_entry_2->ac_title = $account_title;
        $voucher_entry_2->ac_sub_title = $sub_title;
        $voucher_entry_2->ac_type = 'bank';
        $voucher_entry_2->related_business = $this->admin_model->business_name();
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

    public function payment_history()
    {
        $this->select_payment_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active();
        $this->payment_vouchers();
        $this->latest($this->table);
        $result = $this->db->get()->result();

        $journal = $this->accounts_model->make_vouchers_from_raw($result);
        return $journal;
    }

    public function few_payments()
    {
        $this->select_payment_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active();
        $this->payment_vouchers();
        $this->db->limit(10);
        $this->latest($this->table);
        $result = $this->db->get()->result();

        $journal = $this->accounts_model->make_vouchers_from_raw($result);
        return $journal;
    }

    public function today_payments() //paid vouchers
    {
        $this->select_payment_content();
        $this->db->from($this->table);
        $this->join_vouchers();
        $this->active();
        $this->payment_vouchers();
        $this->today_vouchers();
        $this->latest($this->table);
        $result = $this->db->get()->result();

        $journal = $this->accounts_model->make_vouchers_from_raw($result);
        return $journal;
    }

}

?>