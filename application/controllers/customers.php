<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Customers extends ParentController {
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
                $this->bodyData['section'] = 'all';
            }
            $this->all();
        }
    }
    
    public function all()
    {
        $headerData['title'] = 'Customers';
        $this->bodyData['someMessage'] = '';


        if(isset($_POST['addCustomer'])){
            if($this->form_validation->run('add_customer') == true){
                if( $this->customers_model->insert() == true){
                    $this->bodyData['someMessage'] = array('message'=>'customer Added Successfully!', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }

        $this->bodyData['customers'] = $this->customers_model->get();
        $this->load->view('components/header', $headerData);
        $this->load->view('customers/welcome', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function _check_unique_customer()
    {
        $where = "name = '".$this->input->post('name')."'";
        $existing_customers = $this->customers_model->find_where($where);

        if(sizeof($existing_customers) > 0)
        {
            $this->form_validation->set_message('_check_unique_customer','Customer already exist. Please try again');
            return false;
        }
        return true;
    }
    
}
