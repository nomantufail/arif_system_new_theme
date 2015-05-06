<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Withdrawls extends ParentController {
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
                $this->bodyData['section'] = 'withdraw';
            }
            $this->withdraw();
        }
    }

    public function withdraw()
    {
        $headerData = array(
            'title' => 'Withdraw Amount',
        );
        $this->bodyData['someMessage'] = '';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();
        $this->bodyData['withdraw_accounts'] = $this->withdrawls_model->accounts();

        if(isset($_POST['withdraw'])){
            if($this->form_validation->run('withdraw') == true){
                if( $this->withdrawls_model->withdraw() == true){
                    $this->bodyData['someMessage'] = array('message'=>'Request Successfully Completed! ', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }
        $this->bodyData['few_withdrawls'] = $this->withdrawls_model->few_withdrawls();

        $this->load->view('components/header', $headerData);
        $this->load->view('withdrawls/withdraw', $this->bodyData);
        $this->load->view('components/footer');

    }

    public function history()
    {
        $headerData['title']='Withdrawls History';
        $this->bodyData['section'] = 'history';
        $this->bodyData['withdraw_history'] = $this->withdrawls_model->withdraw_history();

        $this->load->view('components/header',$headerData);
        $this->load->view('withdrawls/history', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function accounts()
    {
        $headerData = array(
            'title' => 'Withdraw Accounts',
        );
        $this->bodyData['someMessage'] = '';

        if(isset($_POST['addAccount'])){
            if($this->form_validation->run('addWithdrawAccount') == true){
                if( $this->withdrawls_model->add_account() == true){
                    $this->bodyData['someMessage'] = array('message'=>'Account Added Successfully!', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }

        $this->bodyData['accounts'] = $this->withdrawls_model->accounts();

        $this->load->view('components/header', $headerData);
        $this->load->view('withdrawls/accounts', $this->bodyData);
        $this->load->view('components/footer');
    }
}
