<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH."controllers/parentController.php");
class Expenses extends ParentController {
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
                $this->bodyData['section'] = 'add';
            }
            $this->add();
        }
    }

    public function add()
    {
        $headerData = array(
            'title' => 'Add New Expense',
        );
        $this->bodyData['someMessage'] = '';
        $this->bodyData['tankers'] = $this->tankers_model->get();
        $this->bodyData['titles'] = $this->expense_titles_model->get();

        if(isset($_POST['addExpense'])){
            if($this->form_validation->run('addExpense') == true){
                if( $this->expenses_model->insert() == true){
                    $this->bodyData['someMessage'] = array('message'=>'Expense Added Successfully!', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }
        $this->bodyData['few_expenses'] = $this->expenses_model->few_expenses();

        $this->load->view('components/header', $headerData);
        $this->load->view('expenses/add', $this->bodyData);
        $this->load->view('components/footer');

    }

    public function add_payment()
    {
        $headerData = array(
            'title' => 'Expense Payment',
        );
        $this->bodyData['someMessage'] = '';
        $this->bodyData['bank_accounts'] = $this->bank_ac_model->get();

        if(isset($_POST['savePayment'])){
            if($this->form_validation->run('saveExpensePayment') == true){
                $saved_payment = $this->expenses_model->insert_payment();
                if($saved_payment != 0){
                    $this->bodyData['someMessage'] = array('message'=>'Payment Saved Successfully! Voucher# was <b>'.$saved_payment.'</b>', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }
        $this->bodyData['few_payments'] = $this->expenses_model->few_payments();

        $this->load->view('components/header', $headerData);
        $this->load->view('expenses/add_payment', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function payment_history()
    {
        $headerData['title']='Expense Payment History';
        $this->bodyData['section'] = 'history';
        $this->bodyData['payment_history'] = $this->expenses_model->payment_history();

        $this->load->view('components/header',$headerData);
        $this->load->view('expenses/payment_history', $this->bodyData);
        $this->load->view('components/footer');
    }

    public function show()
    {
        $headerData = array(
            'title' => 'Expense History',
        );
        $this->bodyData['expense_history'] = $this->expenses_model->get();

        $this->load->view('components/header', $headerData);
        $this->load->view('expenses/expense_history', $this->bodyData);
        $this->load->view('components/footer');
    }
    public function titles()
    {
        $headerData = array(
            'title' => 'Expense Titles',
        );
        $this->bodyData['someMessage'] = '';

        if(isset($_POST['addTitle'])){
            if($this->form_validation->run('add_expense_title') == true){
                if( $this->expense_titles_model->insert() == true){
                    $this->bodyData['someMessage'] = array('message'=>'Expense Title Added Successfully!', 'type'=>'alert-success');
                }else{
                    $this->bodyData['someMessage'] = array('message'=>'Some Unknown database fault happened. please try again a few moments later. Or you can contact your system provider.<br>Thank You', 'type'=>'alert-warning');
                }
            }
        }

        $this->bodyData['titles'] = $this->expense_titles_model->get();

        $this->load->view('components/header', $headerData);
        $this->load->view('expenses/expense_titles', $this->bodyData);
        $this->load->view('components/footer');
    }
}
