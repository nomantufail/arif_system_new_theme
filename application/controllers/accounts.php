<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Accounts extends ParentController {
    //public variables...

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $target_function = $this->intelligent_router_model->get_last_saved_route_for_current_controller();

        if($target_function != 'index')
        {
            //setting section
            $this->bodyData['section'] = $target_function;
            //and there we go...
            $this->$target_function();
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'ledger';
            }
            $this->ledger();
        }
    }

    public function customers_ledger()
    {

        $this->bodyData['customers'] = $this->customers_model->get();

        $from = '';
        $to ='';
        $customer = '';
        if(isset($_GET['from']))
        {
            $from = $_GET['from'];
        }
        else
        {
            $date = Carbon::now()->toDateString();
            $from = first_day_of_month($date);
        }

        if(isset($_GET['to']))
        {
            $to = $_GET['to'];
        }
        else
        {
            $date = Carbon::now()->toDateString();
            $to = $date;
        }

        if(isset($_GET['customer']))
        {
            $customer = $_GET['customer'];
        }
        else
        {
            $current_customer = $this->bodyData['customers'][0];
            $customer = $current_customer->name;
        }

        $keys = array(
            'from'=>$from,
            'to'=>$to,
            'customer'=>$customer,
        );
        $this->bodyData['from'] = $from;
        $this->bodyData['selected_customer'] = $customer;
        $this->bodyData['to'] = $to;

        $headerData['title']="Accounts";
        $this->bodyData['opening_balance'] = $this->accounts_model->opening_balance_for_customer_ledger($keys);
        $this->bodyData['ledger'] = $this->accounts_model->customer_ledger($keys);
        $this->load->view('components/header', $headerData);
        $this->load->view('accounts/ledgers/customer', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function suppliers_ledger()
    {

        $this->bodyData['suppliers'] = $this->suppliers_model->get();

        $from = '';
        $to ='';
        $supplier = '';
        if(isset($_GET['from']))
        {
            $from = $_GET['from'];
        }
        else
        {
            $date = Carbon::now()->toDateString();
            $from = first_day_of_month($date);
        }

        if(isset($_GET['to']))
        {
            $to = $_GET['to'];
        }
        else
        {
            $date = Carbon::now()->toDateString();
            $to = $date;
        }

        if(isset($_GET['supplier']))
        {
            $supplier = $_GET['supplier'];
        }
        else
        {
            $current_supplier = $this->bodyData['suppliers'][0];
            $supplier = $current_supplier->name;
        }

        $keys = array(
            'from'=>$from,
            'to'=>$to,
            'supplier'=>$supplier,
        );
        $this->bodyData['from'] = $from;
        $this->bodyData['selected_supplier'] = $supplier;
        $this->bodyData['to'] = $to;

        $headerData['title']="Accounts";
        $this->bodyData['opening_balance'] = $this->accounts_model->opening_balance_for_supplier_ledger($keys);
        $this->bodyData['ledger'] = $this->accounts_model->supplier_ledger($keys);
        $this->load->view('components/header', $headerData);
        $this->load->view('accounts/ledgers/supplier', $this->bodyData);
        $this->load->view('components/footer');
    }
}
