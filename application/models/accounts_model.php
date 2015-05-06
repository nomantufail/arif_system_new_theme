<?php
class Accounts_Model extends Parent_Model {

    public function __construct(){
        parent::__construct();

        $this->table = 'vouchers';
    }

    /**
    * Ledgers Area
    **/

    public function opening_balance_for_customer_ledger($keys)
    {
        $this->db->select('SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active();
        $this->db->where('vouchers.voucher_date <',$keys['from']);
        $this->get_customer_vouchers();
        $this->where_customer($keys['customer']);
        $this->db->group_by('voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $opening_balance = $this->fetch_opening_balance($result);
        return $opening_balance;
        return $result;
    }
    public function customer_ledger($keys)
    {
        $this->select_whole_voucher_content();
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active();
        $this->voucher_duration($keys['from'], $keys['to']);
        $this->get_customer_vouchers();
        $this->where_customer($keys['customer']);
        $result = $this->db->get()->result();
        return $result;
    }

    public function opening_balance_for_supplier_ledger($keys)
    {
        $this->db->select('SUM(voucher_entries.amount) as total_amount, voucher_entries.dr_cr');
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active();
        $this->db->where('vouchers.voucher_date <',$keys['from']);
        $this->get_supplier_vouchers();
        $this->where_supplier($keys['supplier']);
        $this->db->group_by('voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $opening_balance = $this->fetch_opening_balance($result);
        return $opening_balance;
        return $result;
    }
    public function supplier_ledger($keys)
    {
        $this->select_whole_voucher_content();
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active();
        $this->voucher_duration($keys['from'], $keys['to']);
        $this->get_supplier_vouchers();
        $this->where_supplier($keys['supplier']);
        $result = $this->db->get()->result();
        return $result;
    }
    /*********************************/
    public function bank_accounts_status()
    {
        $this->db->select("voucher_entries.ac_title, voucher_entries.ac_sub_title,
                  voucher_entries.dr_cr, SUM(voucher_entries.amount) as total_amount,
                  ");
        $this->db->from('vouchers');
        $this->join_vouchers();
        $this->active();
        $this->bank_entries();
        $this->db->group_by('voucher_entries.ac_title, voucher_entries.ac_sub_title,
                voucher_entries.dr_cr');
        $result = $this->db->get()->result();
        $bank_accounts_status_temp = array();

        if(sizeof($result) > 0)
        {
            foreach($result as $record)
            {
                $found = 0;

                if(sizeof($bank_accounts_status_temp) >0)
                {
                    foreach($bank_accounts_status_temp as $account)
                    {

                        if($account['title'] == $record->ac_title && $account['sub_title'] == $record->ac_sub_title){

                            $found = 1;
                            /*if($record->dr_cr == 1)
                            {
                                $account['debit'] = $record->total_amount;

                            }
                            else if($record->dr_cr == 0)
                            {
                                $account['credit'] = $record->total_amount;
                            }
                            array_push($bank_accounts_status, $account);*/
                        }

                    }
                }

                if($found == 0)
                {
                    $bank_account = array(
                        'title'=>$record->ac_title,
                        'sub_title'=>$record->ac_sub_title,
                        'debit'=>0,
                        'credit'=>0,
                    );
                    array_push($bank_accounts_status_temp, $bank_account);
                }

            }
            foreach($result as $record)
            {
                foreach($bank_accounts_status_temp as &$bank_account)
                {
                    if($bank_account['title'] == $record->ac_title && $bank_account['sub_title'] == $record->ac_sub_title){
                        if($record->dr_cr == 1)
                        {
                            $bank_account['debit'] = $record->total_amount;
                        }
                        if($record->dr_cr == 0)
                        {
                            $bank_account['credit'] = $record->total_amount;
                        }
                    }
                }
            }


        }

         return $bank_accounts_status_temp;
    }
    public function insert_voucher($voucher)
    {
        $this->db->trans_begin();

        $voucher_data = array(
            'voucher_date'=>$voucher->voucher_date,
            'summary'=>$voucher->summary,
            'tanker'=>$voucher->tanker,
            'voucher_type'=>$voucher->voucher_type,
        );
        $this->db->insert('vouchers',$voucher_data);
        $voucher_id = $this->db->insert_id();

        $voucher_entries = array();
        foreach($voucher->entries as $entry)
        {
            $voucher_entry = array(
                'voucher_id'=>$voucher_id,
                'ac_title'=>$entry->ac_title,
                'ac_sub_title'=>$entry->ac_sub_title,
                'ac_type'=>$entry->ac_type,
                'related_customer'=>$entry->related_customer,
                'related_business'=>$entry->related_business,
                'related_other_agent'=>$entry->related_other_agent,
                'related_supplier'=>$entry->related_supplier,
                'related_tanker'=>$entry->related_tanker,
                'quantity'=>$entry->quantity,
                'cost_per_item'=>$entry->cost_per_item,
                'amount'=>$entry->amount,
                'dr_cr'=>$entry->dr_cr,
                'description'=>$entry->description,
            );
            array_push($voucher_entries, $voucher_entry);
        }

        /**
        * Checking voucher entries are validated or not!
        **/
        if($this->db->trans_status() == false
            || sizeof($voucher_entries)%2 != 0
            || sizeof($voucher_entries) == 0
            || $voucher->balance() != 0)
        {
            $this->db->trans_rollback();
            return false;
        }
        /*----------Check Complete--------------*/

        /*--------Inserting The Voucher Entries-----------*/
        $this->db->insert_batch('voucher_entries',$voucher_entries);
        /*------------------------------------------------*/

        if($this->db->trans_status() == false)
        {
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return $voucher_id;
        }

        return false;
    }

    public function make_vouchers_from_raw($raw_entries)
    {
        include_once(APPPATH."models/helperClasses/App_Voucher.php");
        include_once(APPPATH."models/helperClasses/App_Voucher_Entry.php");
        include_once(APPPATH."models/helperClasses/Supplier.php");

        $final_voucher_array = array();

        $previous_voucher_id = -1;
        $previous_entry_id = -1;

        $temp_voucher = new App_Voucher();
        $temp_voucher_entry = new App_voucher_Entry($temp_voucher);

        $count = 0;
        foreach($raw_entries as $record){
            $count++;

            //setting the parent details
            if($record->voucher_id != $previous_voucher_id)
            {
                $previous_voucher_id = $record->voucher_id;

                $temp_voucher = new App_voucher();

                //setting data in the parent object
                $temp_voucher->id = $record->voucher_id;
                $temp_voucher->voucher_date = $record->voucher_date;
                $temp_voucher->summary = $record->summary;

            }/////////////////////////////////////////////////

            /////////////////////////////////////////////////
            if($record->entry_id != $previous_entry_id)
            {
                $previous_entry_id = $record->entry_id;

                $temp_voucher_entry = new App_voucher_Entry($temp_voucher);

                //setting data in the Trip_Product_Data object
                $temp_voucher_entry->id = $record->entry_id;
                $temp_voucher_entry->ac_title = $record->ac_title;
                $temp_voucher_entry->ac_sub_title = $record->ac_sub_title;
                $temp_voucher_entry->related_supplier = $record->related_supplier;
                $temp_voucher_entry->related_customer = $record->related_customer;
                $temp_voucher_entry->related_business = $record->related_business;
                $temp_voucher_entry->related_other_agent = $record->related_other_agent;
                $temp_voucher_entry->amount = $record->amount;
                $temp_voucher_entry->dr_cr = $record->dr_cr;
            }/////////////////////////////////////////////////

            //pushing particals
            if($count != sizeof($raw_entries)){
                if($raw_entries[$count]->entry_id != $record->entry_id){
                    array_push($temp_voucher->entries, $temp_voucher_entry);
                }
                if($raw_entries[$count]->voucher_id != $record->voucher_id){
                    array_push($final_voucher_array, $temp_voucher);
                }
            }else{
                array_push($temp_voucher->entries, $temp_voucher_entry);
                array_push($final_voucher_array, $temp_voucher);
            }
        }
        return $final_voucher_array;
    }
}

?>