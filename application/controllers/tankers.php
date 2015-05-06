<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Tankers extends ParentController {
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
        $headerData['title'] = 'tankers';
        $this->bodyData['someMessage'] = '';


        if(isset($_POST['addtanker'])){
            if($this->form_validation->run('add_tanker') == true){
                if( $this->tankers_model->insert() == true){
                    $this->bodyData['someMessage'] = array('message'=>'tanker Added Successfully!', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }

        $this->bodyData['tankers'] = $this->tankers_model->get();
        $this->load->view('components/header', $headerData);
        $this->load->view('tankers/welcome', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function _check_unique_tanker()
    {
        $where = "name = '".$this->input->post('name')."'";
        $existing_tankers = $this->tankers_model->find_where($where);

        if(sizeof($existing_tankers) > 0)
        {
            $this->form_validation->set_message('_check_unique_tanker','tanker already exist. Please try again');
            return false;
        }
        return true;
    }
    
}
