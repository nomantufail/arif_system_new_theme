<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/7/15
 * Time: 6:42 AM
 */

class Purchase_Invoice {

    public $id;
    public $supplier;
    public $date;
    public $summary;
    public $tanker;
    public $entries;
    public $paid;

    public function __construct()
    {
        $this->entries = array();
    }

    public function summary_simplified()
    {
        $summary = $this->summary;
        if(strlen($summary) > 50)
        {
            $summary = substr($summary, 0,50);
            $summary.="...";
        }
        return $summary;
    }

    public function grand_total_purchase_price()
    {
        $grand_total = 0;
        foreach($this->entries as $entry)
        {
            $grand_total += round($entry->costPerItem * $entry->quantity, 3);
        }
        return $grand_total;
    }

    public function remaining()
    {
        return $this->grand_total_purchase_price() - $this->paid;
    }

} 