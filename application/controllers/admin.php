<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");

class Admin extends ParentController {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $target_function = $this->intelligent_router_model->get_last_saved_route_for_current_controller();

        if($target_function != 'index' && $target_function != 'login')
        {
            //setting section
            $this->bodyData['section'] = $target_function;
            //and there we go...
            $this->$target_function();
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'home';
            }
            $this->home();
        }
    }

    public function under_development($for="")
    {
        $headerData = array(
            'title' => 'Inventory | Home',
        );
        $this->load->view('components/header', $headerData);
        $this->load->view('admin/under_development');
        $this->load->view('components/footer');
    }

    public function home()
    {
        $headerData['title']='Home';
        $this->bodyData['section'] = 'home';

        $this->bodyData['total_sales'] = $this->sales_model->total_sales();
        $this->bodyData['total_purchases'] = $this->purchases_model->total_purchases();
        $this->bodyData['total_payables'] = $this->payments_model->total_payables();
        $this->bodyData['total_receivables'] = $this->receipts_model->total_receivables();

        $this->bodyData['bank_accounts'] = $this->accounts_model->bank_accounts_status();
        $this->load->view('components/header',$headerData);
        $this->load->view('admin/home', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function update_bank_entries()
    {
        $this->db->select('id');
        $this->db->where('ac_type','bank');
        $result = $this->db->get('voucher_entries')->result();
        $entry_ids = array();
        foreach($result as $record)
        {
            array_push($entry_ids, $record->id);
        }

        $bank_1 = "Yasir Ali (Al-Falah 12****789)";
        $bank_2 = "Mukhtar Shah (Standard Charted 98****321)";
        $this->db->where_in('id',$entry_ids);
        $this->db->where('id >',39);
        $data = array(
            'ac_title'=>$bank_1,
        );
        $this->db->update('voucher_entries',$data);

        $this->db->where_in('id',$entry_ids);
        $this->db->where('id <=',39);
        $data = array(
            'ac_title'=>$bank_2,
        );
        $this->db->update('voucher_entries',$data);
    }

}
