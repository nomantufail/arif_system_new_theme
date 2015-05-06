<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 5/6/15
 * Time: 8:22 AM
 */

class Withdraw_Entry {

    public $voucher_id;
    public $amount;
    public $voucher_date;
    public $bank_ac;
    public $withdraw_account;
    public $summary;

    public function __construct($voucher)
    {
        $this->set_voucher($voucher);
    }

    public function set_voucher($voucher)
    {
        $credit_entry = null;
        $debit_entry = null;

        foreach($voucher->entries as $entry)
        {
            if($entry->dr_cr == 1)
            {
                $debit_entry = $entry;
            }
            else if($entry->dr_cr == 0)
            {
                $credit_entry = $entry;
            }
        }

        $this->amount = $debit_entry->amount;
        $this->withdraw_account = $debit_entry->ac_title;
        $this->voucher_date = $voucher->voucher_date;
        $this->summary = $voucher->summary;
        $this->bank_ac = $credit_entry->ac_title;
        $this->voucher_id = $voucher->id;
    }

} 