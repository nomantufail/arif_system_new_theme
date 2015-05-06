<?php

/*
 * --------------------------------------
 * Parent Model For Query Scopes
 * --------------------------------------
 * This model is used for query scopes
 * which scopes are global and can be
 * used in any model..
 * */

class Parent_Model extends CI_Model {

    //protected properties
    protected $table;

    public function __construct(){
        parent::__construct();

    }

    /**
     * Used to fetch only active records
     */
    public function active()
    {
        $this->db->where('deleted',0);
    }

    /**
     * Used to fetch only deleted records
     */
    public function deleted()
    {
        $this->db->where('deleted',1);
    }

    /**
     * Used to fetch latest records first
     */
    public function latest($table = null)
    {

        if($table != null)
        {
            $this->db->order_by($table.".id",'desc');
        }else{
            $this->db->order_by('id','desc');
        }
    }

    /**
     * Used to fetch only debit entries
     */
    public function with_debit_entries_only()
    {
        $this->db->where('voucher_entries.dr_cr',1);
    }

    /**
     * Used to fetch only credit etnries
     */
    public function with_credit_entries_only()
    {
        $this->db->where('voucher_entries.dr_cr',0);
    }

    /**
     * Used to fetch only purchase vouchers
     */
    public function purchase_vouchers()
    {
        $this->db->where('vouchers.voucher_type','purchase');
    }

    /**
     * Used to fetch only sale vouchers
     */
    public function sale_vouchers()
    {
        $this->db->where('vouchers.voucher_type','sale');
    }

    /**
     * Used to fetch only payment vouchers
     */
    public function payment_vouchers()
    {
        $this->db->where('vouchers.voucher_type','payment');
    }

    /**
     * Used to fetch only receipt vouchers
     */
    public function receipt_vouchers()
    {
        $this->db->where('vouchers.voucher_type','receipt');
    }

    /**
     * Used to fetch only receipt vouchers
     */
    public function expense_payable_vouchers()
    {
        $this->db->where('vouchers.voucher_type','expense_payable');
    }

    /**
     * Used to fetch only receipt vouchers
     */
    public function expense_payment_vouchers()
    {
        $this->db->where('vouchers.voucher_type','expense payment');
    }
    /**
     * Used to fetch only receipt vouchers
     */
    public function withdraw_vouchers()
    {
        $this->db->where('vouchers.voucher_type','withdraw');
    }

    /**
     * Used to join vouchers table with voucher_entries table
     */
    public function join_vouchers()
    {
        $this->db->join('voucher_entries','voucher_entries.voucher_id = vouchers.id','left');
    }

    /**
     * Used to select all the sale contents which are needed
     */
    public function select_sale_content()
    {
        $this->db->select("
            vouchers.id as invoice_id, vouchers.voucher_date as invoice_date, vouchers.summary as invoice_summary,
            vouchers.tanker,
            voucher_entries.related_customer, voucher_entries.ac_title as product_name, voucher_entries.quantity,
            voucher_entries.cost_per_item, voucher_entries.amount,
            voucher_entries.id as entry_id,

        ");
    }

    /**
     * Used to select all the purchases contents which are needed
     */
    public function select_purchases_content()
    {
        $this->db->select("
            vouchers.id as invoice_id, vouchers.voucher_date as invoice_date, vouchers.summary as invoice_summary,
            vouchers.tanker,
            voucher_entries.related_supplier, voucher_entries.ac_title as product_name, voucher_entries.quantity,
            voucher_entries.cost_per_item, voucher_entries.amount,
            voucher_entries.id as entry_id,

        ");
    }

    /**
     * Used to select all the payment(paid) contents which are needed
     */
    public function select_payment_content()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.summary, voucher_entries.ac_title,
            vouchers.tanker,
            voucher_entries.ac_sub_title, voucher_entries.amount, vouchers.voucher_date,
            voucher_entries.id as entry_id,
            voucher_entries.dr_cr,
            voucher_entries.related_supplier, voucher_entries.related_customer,
            voucher_entries.related_business, voucher_entries.related_other_agent,
        ");
    }

    /**
     * Used to select all the receipt contents which are needed
     */
    public function select_receipt_content()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.summary, voucher_entries.ac_title,
            vouchers.tanker,
            voucher_entries.ac_sub_title, voucher_entries.amount, vouchers.voucher_date,
            voucher_entries.id as entry_id,
            voucher_entries.dr_cr,
            voucher_entries.related_supplier, voucher_entries.related_customer,
            voucher_entries.related_business, voucher_entries.related_other_agent,
        ");
    }

    /**
     * Used to select all the expense contents which are needed
     */
    public function select_expense_content()
    {
        $this->db->select("
            vouchers.id as invoice_id, vouchers.voucher_date as expense_date, vouchers.summary as invoice_summary,
            voucher_entries.related_tanker as tanker, voucher_entries.ac_title as expense_title,
            voucher_entries.amount,
        ");
    }

    /**
     * Used to select all the withdraw accounts contents which are needed
     */
    public function select_withdraw_accounts_content()
    {
        $this->db->select('withdraw_accounts.title, withdraw_accounts.description, withdraw_accounts.id');
    }

    /**
     * Used to select all the expense payment contents which are needed
     */
    public function select_expense_payment_content()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.voucher_date as voucher_date, vouchers.summary as summary,
            voucher_entries.ac_title as bank_ac, voucher_entries.amount,
        ");
    }

    /**
     * Used to fetch only today vouchers
     */
    public function today_vouchers()
    {
        $this->db->where(array(
            'vouchers.voucher_date'=>date('Y-m-d'),
        ));
    }

    /**
    * used to select id column in vouchers table.
    **/
    public function select_voucher_ids()
    {
        $this->db->select("vouchers.id as voucher_id");
    }

    /**
     * used to select vouchers in which account type is payable
     **/
    public function payables()
    {
        $this->db->where('ac_type', 'payable');
    }
    /**
     * used to select vouchers in which account type is Receivable
     **/
    public function receivables()
    {
        $this->db->where('ac_type', 'receivable');
    }
    /**
     * used to select vouchers in which account type is asset
     **/
    public function assets()
    {
        $this->db->where('ac_type', 'asset');
    }
    /**
     * used to select vouchers in which account type is revenue
     **/
    public function revenue()
    {
        $this->db->where('ac_type', 'revenue');
    }
    /**
     * used to select vouchers in which account type is bank
     **/
    public function bank_entries()
    {
        $this->db->where('ac_type', 'bank');
    }

    public function get_customer_vouchers()
    {
        $this->db->where('voucher_entries.related_customer !=','');
    }
    public function get_supplier_vouchers()
    {
        $this->db->where('voucher_entries.related_supplier !=','');
    }
    public function where_customer($customerName)
    {
        $this->db->where('voucher_entries.related_customer',$customerName);
    }
    public function where_supplier($customerName)
    {
        $this->db->where('voucher_entries.related_supplier',$customerName);
    }

    public function select_whole_voucher_content()
    {
        $this->db->select("
            vouchers.id as voucher_id, vouchers.summary, voucher_entries.ac_title,
            vouchers.tanker,
            voucher_entries.ac_sub_title, voucher_entries.amount, vouchers.voucher_date,
            voucher_entries.id as entry_id, voucher_entries.ac_type,
            voucher_entries.dr_cr,
            voucher_entries.related_supplier, voucher_entries.related_customer,
            voucher_entries.related_business, voucher_entries.related_other_agent,
        ");
    }

    public function fetch_opening_balance($rows)
    {
        $total_debit = 0;
        $total_credit = 0;
        if($rows != null)
        {
            foreach($rows as $row)
            {
                if($row->dr_cr == 0)
                {
                    $total_credit += $row->total_amount;
                }
                if($row->dr_cr == 1)
                {
                    $total_debit += $row->total_amount;
                }
            }
        }
        return round($total_debit - $total_credit, 3);
    }

    public function voucher_duration($from, $to)
    {
        $this->db->where(array(
            'vouchers.voucher_date >='=>$from,
            'vouchers.voucher_date <='=>$to,
        ));
    }
}

?>