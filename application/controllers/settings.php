<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Settings extends ParentController {
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
                $this->bodyData['section'] = 'accounts';
            }
            $this->accounts();
        }
    }
    
    public function accounts()
    {

        $headerData = array(
            'title' => 'Settings ! Accounts',
        );
        $this->bodyData['someMessage'] = '';
        if(isset($_POST['addBankAc'])){
            if($this->form_validation->run('add_bank_ac') == true){
                if( $this->bank_ac_model->insert() == true){
                    $this->bodyData['someMessage'] = array('message'=>'Bank Account Added Successfully!', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }
        $this->bodyData['banks'] = $this->bank_ac_model->get();

        $this->load->view('components/header', $headerData);
        $this->load->view('settings/accounts', $this->bodyData);
        $this->load->view('components/footer');
    }

    /**
    * This callback is used to validate new bank account
    **/
    public function _check_bank_title_unique()
    {
        $where = "title = '".$this->input->post('title')."' AND type = '".$this->input->post('type')."'";
        $existing_bank_accounts = $this->bank_ac_model->find_where($where);

        if(sizeof($existing_bank_accounts) > 0)
        {
            $this->form_validation->set_message('_check_bank_title_unique','Bank Account already exist. Please try again');
            return false;
        }
        return true;
    }
}
