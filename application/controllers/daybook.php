<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class DayBook extends ParentController {
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
                $this->bodyData['section'] = 'summary';
            }
            $this->summary();
        }
    }

    public function summary()
    {
        $headerData['title'] = 'DayBook | '.Carbon::now()->toFormattedDateString();
        $this->bodyData['section'] = 'summary';
        $this->bodyData['sales'] = $this->sales_model->today_sales();
        $this->bodyData['purchases'] = $this->purchases_model->today_purchases();
        $this->bodyData['payments'] = $this->payments_model->today_payments();
        $this->bodyData['receipts'] = $this->receipts_model->today_receipts();
        $this->load->view('components/header',$headerData);
        $this->load->view('daybook/welcome', $this->bodyData);
        $this->load->view('components/footer');
    }

}
