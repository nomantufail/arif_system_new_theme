<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 3:41 AM
 */

class App_voucher_Entry {
    //properties
    public $id;
    public $voucher_id;
    public $ac_title;
    public $ac_sub_title;
    public $ac_type;
    public $related_customer;
    public $related_supplier;
    public $related_business;
    public $related_other_agent;
    public $related_tanker;
    public $quantity;
    public $cost_per_item;
    public $dr_cr;
    public $amount;
    public $description;
    public $inserted_at;
    public $updated_at;
    public $deleted_at;
    public $deleted;

    public $container;

    public function __construct(&$container = null)
    {
        $this->container = $container;
    }

} 