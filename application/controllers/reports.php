<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Reports extends ParentController {
    //public variables...
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {$target_function = $this->intelligent_router_model->get_last_saved_route_for_current_controller();

        if($target_function != 'index')
        {
            //setting section
            $this->bodyData['section'] = $target_function;
            //and there we go...
            $this->$target_function();
        }else{
            if($this->bodyData['section'] == 'index')
            {
                $this->bodyData['section'] = 'daily';
            }
            $this->daily();
        }
    }

    public function daily()
    {
        $headerData['title']="Accounts";
        $this->load->view('components/header', $headerData);
        $this->load->view('reports/welcome', $this->bodyData);
        $this->load->view('components/footer');
    }

}
