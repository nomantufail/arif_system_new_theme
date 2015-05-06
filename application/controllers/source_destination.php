<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Source_Destination extends ParentController {
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
                $this->bodyData['section'] = 'show';
            }
            $this->show();
        }
    }

    public function show()
    {
        $headerData = array(
            'title' => 'Source / Destination',
        );
        $this->bodyData['someMessage'] = '';
        if(isset($_POST['addCity'])){
            if($this->form_validation->run('add_city') == true){
                if( $this->source_destination_model->insert() == true){
                    $this->bodyData['someMessage'] = array('message'=>'Freight Point Added Successfully!', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }
        $this->bodyData['cities'] = $this->source_destination_model->get();

        $this->load->view('components/header', $headerData);
        $this->load->view('source_destination/show', $this->bodyData);
        $this->load->view('components/footer');

    }
}
