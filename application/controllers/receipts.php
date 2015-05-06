<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Receipts extends ParentController {
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
                $this->bodyData['section'] = 'make';
            }
            $this->make();
        }
    }

    public function make()
    {
        $headerData['title']='Payment New*';
        $this->bodyData['section'] = 'make';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();
        $this->bodyData['customers'] = $this->customers_model->get();

        if(isset($_POST['saveReceipt']))
        {
            $saved_receipt = $this->receipts_model->insert_receipt();
            if($saved_receipt != 0){
                $this->bodyData['someMessage'] = array('message'=>'Receipt Saved Successfully! Invoice# was <b>'.$saved_receipt.'</b>', 'type'=>'alert-success');
            }else{
                $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
            }
        }

        $this->bodyData['receipt_history'] = $this->receipts_model->few_receipts();
        $this->load->view('components/header',$headerData);
        $this->load->view('receipts/make', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function history()
    {
        $headerData['title']='Payment New*';
        $this->bodyData['section'] = 'history';
        $this->bodyData['receipt_history'] = $this->receipts_model->receipt_history();

        $this->load->view('components/header',$headerData);
        $this->load->view('Receipts/history', $this->bodyData);
        $this->load->view('components/footer');
    }
}
