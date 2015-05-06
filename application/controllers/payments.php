<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Payments extends ParentController {
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
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();
        $this->bodyData['suppliers'] = $this->suppliers_model->get();

        if(isset($_POST['savePayment']))
        {
            $saved_payment = $this->payments_model->insert_payment();
            if($saved_payment != 0){
                $this->bodyData['someMessage'] = array('message'=>'Payment Saved Successfully! Invoice# was <b>'.$saved_payment.'</b>', 'type'=>'alert-success');
            }else{
                $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
            }

        }
        $this->bodyData['payment_history'] = $this->payments_model->few_payments();
        $this->load->view('components/header',$headerData);
        $this->load->view('payments/make', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function history()
    {
        $headerData['title']='Payment New*';
        $this->bodyData['section'] = 'history';
        $this->bodyData['payment_history'] = $this->payments_model->payment_history();

        $this->load->view('components/header',$headerData);
        $this->load->view('payments/history', $this->bodyData);
        $this->load->view('components/footer');
    }
}
