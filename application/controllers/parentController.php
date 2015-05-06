<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ParentController extends CI_Controller {

    //public variables...
    public $login;
    public $bodyData;

    public function __construct()
    {
        parent::__construct();


        /*
         * --------------------------------------
         * Prevent Cashing
         * --------------------------------------
         *
         * */
            header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        /*--------------------------------------------------------------*/

        include_once("libraries/php/helper.php");

        $this->load->helper(array('form', 'url', 'captcha'));
        $this->load->library(array('form_validation','email','Carbon','Helper','pagination'));
        $this->load->model(array(
            'parent_model',
            'admin_model',
            'helper_model',
            'privilege_model',
            'customers_model',
            'suppliers_model',
            'products_model',
            'tankers_model',
            'purchases_model',
            'sales_model',
            'stock_model',
            'bank_ac_model',
            'accounts_model',
            'payments_model',
            'receipts_model',
            'expenses_model',
            'expense_titles_model',
            'withdrawls_model',
            'source_destination_model',
            'intelligent_router_model',
        ));

        //saving the latest route
        $this->intelligent_router_model->save_latest_route();

        //checking the login state below...
        $this->login = $this->helper_model->is_login();

        $this->set_bodyData();
    }

    function _remap($method){
        if($this->login == false){
            $this->login();
        }
        else if($this->privilege_model->is_authenticated() == false)
        {
            $this->privilege_model->check_privileges();
        }
        else
        {
            $this->_call_with_args($method);
        }
    }


    public function login($msg = "")
    {

        if($this->login == true){
            $this->index();
        }else{
            $headerData = array(

            );
            $captcha = $this->helper_model->_create_captcha();
            $bodyData = array(
                'captcha' =>$captcha["image"],
                'captcha_word' =>$captcha['word'],

            );

            if ($this->form_validation->run('login') == true)
            {
                //logging in...
                $this->_LOGIN();
                if($this->login == false){
                    $data['message'] = "Login Failed!";
                    $data['type']="alert-danger";
                    $this->load->view('admin/login', $data);
                }else{
                    $this->index();
                }
            }
            else
            {
                $this->load->view('admin/login', $bodyData);
            }
        }
    }
    function _LOGIN(){
        $this->helper_model->login($this->input->post('username'));
        $this->login = $this->helper_model->is_login();
    }
    function logout(){
        $this->helper_model->logout();
        $this->login = $this->helper_model->is_login();
        $this->index();
    }

    private function set_bodyData()
    {
        $this->bodyData['section'] = $this->router->fetch_method();
    }
    private function _loggedIn(){
        /*if($this->admin_model->loggedIn() == 1){
            return true;
        }else{
            return false;
        }*/
    }

    function _create_captcha(){
        /*$words = array( '2', '3', '4', '5', '6','7', '8', '9','0', 'a', 'b','z', 'n', 'b','x', 'y', 'v');
        $count = 1;
        $word = "";
        while($count < 3){
            $word = $word.$words[mt_rand(0, 16)];
            $count++;
        }
        $vals = array(
            'word'      => strtolower($word),
            'img_path'	=> './captcha/',
            'img_url'	=> base_url().'captcha/',
            'font_path'	=> 'fonts/DENMARK.ttf',
            'img_width'	=> '210',
            'img_height' => 40,
            'expiration' => 20
        );
        $cap = create_captcha($vals);
        return $cap;*/
    }

    function _check_credentials($str, $data){
        /*list($table, $userField, $passField)=explode('.', $data);
        //You have to change this line below
        if($this->input->post('username') != "" && $this->input->post('password') != "" && $this->input->post('confirmCaptcha') != "" && $this->form_validation->captcha_check($this->input->post('confirmCaptcha'), 'captcha') == true){
            //////////////////////////////////////////////////////////////////////////////////////////////////
            $userName = $userField.".".$this->input->post('username');
            $password = $passField.".".$this->input->post('password');
            $credentials = $this->admin_model->check_credentials($table, $userName, $password);
            if($credentials == false){
                $this->form_validation->set_message('_check_credentials','Invalid Username/Password. Please try again');
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }*/
    }



    private function _call_with_args($method, $args=""){
        if($args == ""){
            $args = array_slice($this->uri->rsegments,2);
        }
        if(method_exists($this,$method)){
            return call_user_func_array(array(&$this,$method),$args);
        }
    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */