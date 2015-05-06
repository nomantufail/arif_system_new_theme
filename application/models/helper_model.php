<?phpclass Helper_model extends Parent_Model {    public function __construct(){        parent::__construct();    }    public function is_login(){        @session_start();        if(isset($_SESSION["username"])){            return true;        }        return false;    }    public function user_role()    {        @session_start();        if(isset($_SESSION["role"])){            return $_SESSION["role"];        }        return false;    }    public function next_id($table)    {        $this->db->select_max('id');        $result = $this->db->get($table)->result();        return $result[0]->id +1;    }    public function journal($agent, $agent_id, $voucher_ids, $sort, $where='')    {        include_once(APPPATH."models/helperClasses/Universal_Voucher.php");        include_once(APPPATH."models/helperClasses/Voucher_Entry.php");        $this->db->select("voucher_journal.id as voucher_id, voucher_journal.ignored, voucher_entry.id as voucher_entry_id,                            voucher_journal.voucher_date, voucher_journal.detail, voucher_journal.person_tid,                            voucher_journal.trip_id,voucher_journal.trip_product_detail_id, voucher_journal.tanker_id, tankers.truck_number as tanker_number,                            voucher_journal.entryDate,                            voucher_entry.id as voucher_entry_id, voucher_entry.related_other_agent,                             voucher_entry.related_customer, voucher_entry.related_contractor,                            voucher_entry.description, account_titles.title, account_titles.id as account_title_id,                             account_titles.type as ac_type, voucher_entry.debit_amount,                            voucher_entry.credit_amount, voucher_entry.dr_cr,                            companies.name as company_name, voucher_entry.related_company,                            other_agents.name as related_other_agent_name, customers.name as related_customer_name, carriage_contractors.name as related_contractor_name, companies.name as related_company_name,        ");        $this->db->from('voucher_journal');        $this->db->join('voucher_entry','voucher_entry.journal_voucher_id = voucher_journal.id', 'left');        $this->db->join('other_agents','other_agents.id = voucher_entry.related_other_agent','left');        $this->db->join('customers','customers.id = voucher_entry.related_customer','left');        $this->db->join('carriage_contractors','carriage_contractors.id = voucher_entry.related_contractor','left');        $this->db->join('companies','companies.id = voucher_entry.related_company','left');        $this->db->join('account_titles','account_titles.id = voucher_entry.account_title_id','left');        $this->db->join('tankers','tankers.id = voucher_journal.tanker_id','left');        if($voucher_ids != ""){            $this->db->where_in('voucher_journal.id',$voucher_ids);        }        //sorting        if($sort != ''){            $this->db->order_by('voucher_journal.id',$sort['order']);        }else{            $this->db->order_by('voucher_journal.id','asc');        }        $this->db->order_by('voucher_entry.dr_cr','asc');        $result = $this->db->get()->result();        $previous_voucher_id = -1;        $temp_voucher = new Universal_Voucher();        $final_journal = array();        $count = 0;        foreach($result as $voucher){            $count++;            if($voucher->voucher_id != $previous_voucher_id)            {                if($previous_voucher_id != -1){                    array_push($final_journal, $temp_voucher);                }                $previous_voucher_id = $voucher->voucher_id;                $temp_voucher = new Universal_Voucher();                //setting data in the parent object                $temp_voucher->voucher_id = $voucher->voucher_id;                $temp_voucher->ignore = $voucher->ignored;                $temp_voucher->voucher_details = $voucher->detail;                $temp_voucher->voucher_date = $voucher->voucher_date;                $temp_voucher->tanker_id = $voucher->tanker_id;                $temp_voucher->tanker_number = $voucher->tanker_number;                $temp_voucher->trip_id = $voucher->trip_id;                $temp_voucher->trip_detail_id = $voucher->trip_product_detail_id;                $person = explode('.',$voucher->person_tid);                $temp_voucher->person_id = $person[1];                $temp_voucher->person = $person[0];            }            //making a voucher Entry            $temp_voucher_entry = new Voucher_Entry();            //setting data in temp_voucher_entry            $temp_voucher_entry->setId($voucher->voucher_entry_id);            $temp_voucher_entry->setAc_type($voucher->ac_type);            $temp_voucher_entry->setTitle($voucher->title);            $temp_voucher_entry->setAccount_title_id($voucher->account_title_id);            $temp_voucher_entry->setDescription($voucher->description);            //finding the related agent            $related_agent = ''; $related_agent_id=''; $related_agent_name='';            if($voucher->related_other_agent != 0){                $related_agent = "other_agents";                $related_agent_id = $voucher->related_other_agent;                $related_agent_name = $voucher->related_other_agent_name;            }else if($voucher->related_customer != 0){                $related_agent = "customers";                $related_agent_id = $voucher->related_customer;                $related_agent_name = $voucher->related_customer_name;            }else if($voucher->related_contractor != 0){                $related_agent = "carriage_contractors";                $related_agent_id = $voucher->related_contractor;                $related_agent_name = $voucher->related_contractor_name;            }else if($voucher->related_company != 0){                $related_agent = "companies";                $related_agent_id = $voucher->related_company;                $related_agent_name = $voucher->related_company_name;            }else{                $related_agent = "self";                $related_agent_id = 0;                $related_agent_name = '';            }            $temp_voucher_entry->setRelated_agent($related_agent);            $temp_voucher_entry->setRelated_agent_id($related_agent_id);            $temp_voucher_entry->setRelated_agent_name($related_agent_name);            $temp_voucher_entry->setDebit($voucher->debit_amount);            $temp_voucher_entry->setCredit($voucher->credit_amount);            $dr_cr = ($voucher->dr_cr == 0)?'credit':'debit';            $temp_voucher_entry->setDr_cr($dr_cr);            $temp_voucher_entry->setJournal_voucher_id($voucher->voucher_id);            //insert voucher entry into the voucher            array_unshift($temp_voucher->entries,$temp_voucher_entry);            //checking if the record is final            if($count == sizeof($result))            {                array_push($final_journal, $temp_voucher);            }        }        return $final_journal;    }    public function login(){        $username = $this->input->post('username');        $password = $this->input->post('password');        $user = $this->db->get_where('admin', array('username'=>$username, 'password'=>$password))->result();        if(sizeof($user) >= 1){            @session_start();            $_SESSION["username"] = $username;            $_SESSION["password"] = $password;            $_SESSION["role"] = $user[0]->role;            return true;        }        return false;    }    function logout(){        @session_start();        unset($_SESSION["username"]);        unset($_SESSION["password"]);    }    function _create_captcha(){        /*$words = array( '2', '3', '4', '5', '6','7', '8', '9','0', 'a', 'b','z', 'n', 'b','x', 'y', 'v');        $count = 1;        $word = "";        while($count < 3){            $word = $word.$words[mt_rand(0, 16)];            $count++;        }        $vals = array(            'word'      => strtolower($word),            'img_path'	=> './captcha/',            'img_url'	=> base_url().'captcha/',            'font_path'	=> 'fonts/DENMARK.ttf',            'img_width'	=> '210',            'img_height' => 40,            'expiration' => 20        );        $cap = create_captcha($vals);        return $cap;*/    }    public function delete_record($table, $id){        $this->db->where('id',$id);        return $this->db->delete($table);    }    public function safe_delete($table, $id){        $this->db->where('id',$id);        return $this->db->update($table,array('active'=>0));    }    public function last_id($table){        $this->db->select_max('id');        $result = $this->db->get($table)->result();        if($result[0]->id == null){            return 0;        }else{            return $result[0]->id;        }    }    public function re_submission($table, $id){        $result = $this->db->get_where($table, array('id'=>$id))->result();        if($result){            return true;        }else{            return false;        }    }    public function rows_in($table){        return $this->db->count_all($table);    }    public function bigger_date($from, $to){        $from_date = new DateTime($from);        $to_date = new DateTime($to);        if($from_date > $to_date){            return true;        }        return false;    }    public function datecmp($date_1, $date_2){        $from_date = new DateTime($date_1);        $to_date = new DateTime($date_2);        if($from_date > $to_date){            return 1;        }else if($from_date < $to_date){            return -1;        }        return 0;    }    public function  pagination_configs($url, $table, $total_rows='',$records_per_page ='false'){        $config["base_url"] = base_url() . $url;        $config["total_rows"] = ($total_rows == '')?$this->helper_model->rows_in($table):$total_rows;        $config["per_page"] = ($records_per_page != 'false')?$records_per_page:30;        $config["uri_segment"] = 5;        $config['query_string_segment'] = 'page';        $config['full_tag_open'] = "<nav><ul class='pagination'>";        $config['full_tag_close'] = "</ul></nav>";        $config['cur_tag_open'] = '<li class="active"><a>';        $config['cur_tag_close'] = '</a></li>';        $config['num_tag_open'] = '<li>';        $config['num_tag_close'] = '</li>';        $config['next_link'] = '<span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>';        $config['prev_tag_open'] = '<li>';        $config['prev_tag_close'] = '</li>';        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>';        $config['next_tag_open'] = '<li>';        $config['next_tag_close'] = '</li>';        $config['first_tag_open'] = '<li>';        $config['first_tag_close'] = '</li>';        $config['last_tag_open'] = '<li>';        $config['last_tag_close'] = '</li>';        return $config;    }    public function is_single($table, $column, $value, $record_id){        $query = $this->db->get_where($table, array($column=>$value));        if($query->num_rows() < 1){            return true;        }else{            $records = $query->result();            foreach($records as $record){                if($record->id != $record_id){                    return false;                }            }            return true;        }    }    public function record_exists($table, $where){        $query = $this->db->get_where($table,$where);        if($query->num_rows() >= 1){            return true;        }else{            return false;        }    }    function money($num){        $sign = "";        if($num < 0){ $sign = "-"; $num *= -1;}        $numParts = explode('.', $num);        $num = $numParts[0];        $explrestunits = "" ;        if(strlen($num)>3){            $lastthree = substr($num, strlen($num)-3, strlen($num));            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.            $expunit = str_split($restunits, 2);            for($i=0; $i<sizeof($expunit); $i++){                // creates each of the 2's group and adds a comma to the end                if($i==0)                {                    $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer                }else{                    $explrestunits .= $expunit[$i].",";                }            }            $thecash = $explrestunits.$lastthree;        } else {            $thecash = $num;        }        //attaching the fractional part        $thecash = (sizeof($numParts)>1)?$thecash.".".$numParts[1]:$thecash;        return $sign."".$thecash; // writes the final format where $currency is the currency symbol.    }    public function page_url(){        $pageURL = 'http';        $pageURL .= "://";        if ($_SERVER["SERVER_PORT"] != "80") {            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];        } else {            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];        }        return $pageURL;    }    public function filter_records($source, $keys, $key)    {        $selected_records = $keys;        $refined_records = array();        foreach($source as $record){            if(in_array($record->$key, $selected_records)){                array_push($refined_records, $record);            }        }        return $refined_records;    }    public function first_day_of_month($date = ''){        $date = ($date == '')?date('Y-m-d'):$date;        $parts_of_date = explode('-',$date);        return $parts_of_date[0]."-".$parts_of_date[1]."-"."01";    }    public function last_day_of_month($date = ''){        $date = ($date == '')?date('Y-m-d'):$date;        $parts_of_date = explode('-',$date);        $total_days_in_month=cal_days_in_month(CAL_GREGORIAN,$parts_of_date[1],$parts_of_date[0]);        return $parts_of_date[0]."-".$parts_of_date[1]."-".$total_days_in_month;    }    public function url_path(){       $url_parts = explode('?',$this->page_url());        return $url_parts[0];    }    public function sorting_info($columnName)    {        //just testing       $sort_by = (isset($_GET['sort_by']))?$_GET['sort_by']:'';       $order = (isset($_GET['order']))?$_GET['order']:'';       if($sort_by == $columnName && $order == 'asc')       {           $order = 'desc';       }else{           $order = 'asc';       }        $query_string = $this->helper_model->merge_query($_SERVER['QUERY_STRING'], array('sort_by'=>$columnName,'order'=>$order, 'page'=>0));        $link = $this->url_path()."?".$query_string;       return $link;        //////////////////////////////////    }    public function sorting_icon($columnName, $columnType)    {        $icon = '';        if(isset($_GET['order']) && $_GET['sort_by'] == $columnName)        {            switch($columnType)            {                case 'string':                    $icon = ($_GET['order'] == 'desc')?"fa fa-sort-alpha-desc":"fa fa-sort-alpha-asc";                    break;                case 'numeric':                    $icon = ($_GET['order'] == 'desc')?"fa fa-sort-numeric-desc":"fa fa-sort-numeric-asc";                    break;                case 'amount':                    $icon = ($_GET['order'] == 'desc')?"fa fa-sort-amount-desc":"fa fa-sort-amount-asc";                    break;                case 'date':                    $icon = ($_GET['order'] == 'desc')?"fa fa-sort-numeric-desc":"fa fa-sort-numeric-asc";                    break;            }        }        return $icon;    }    public function merge_query($query_string, $arr)    {        parse_str($query_string, $query_array);        $processed_query = array_merge($query_array, $arr);        $query_string = http_build_query($processed_query);        return $query_string;    }    public function timeDifference($time1, $time2){        $date1 = new DateTime($time1);        $date2 = new DateTime($time2);// The diff-methods returns a new DateInterval-object...        $diff = $date2->diff($date1);// Call the format method on the DateInterval-object        $d = array(            'days' => $diff->format('%a'),            'hours' => $diff->format('%h'),        );        /*echo $diff->format('%a_%h');*/        return $d;    }    public function change_date($date, $duration, $command){        $date = $this->carbon->createFromFormat('Y-m-d',$date);        $date = ($command == 'sub')?$date->subDays($duration):$date->addDays($duration);        return $date->toDateString();    }    public function accounting_year_next_previous($from, $to)    {        $duration_days = $this->helper_model->timeDifference($from, $to);        //$duration_days = $duration_days['days'];        $next_from_date = $this->change_date($to,1,'add');        //subtracting year for creating previous from date        $from_parts = explode('-',$from);        $previous_from_date = (intval($from_parts[0]) - 1)."-".$from_parts[1]."-".$from_parts[2];        //adding year for creating next to date        $to_parts = explode('-',$to);        $next_to_date = (intval($to_parts[0]) + 1)."-".$to_parts[1]."-".$to_parts[2];        $previous_to_date = $this->change_date($from,1,'sub');        $query_string_for_next_accounting_year = $this->helper_model->merge_query($_SERVER['QUERY_STRING'], array('accounting_year_from'=>$next_from_date,'accounting_year_to'=>$next_to_date, 'custom_to'=>'','custom_from'=>'','page'=>0));        $query_string_for_previous_accounting_year = $this->helper_model->merge_query($_SERVER['QUERY_STRING'], array('accounting_year_from'=>$previous_from_date,'accounting_year_to'=>$previous_to_date, 'custom_to'=>'','custom_from'=>'','page'=>0));        $accounting_years = array(            'next' => $query_string_for_next_accounting_year,            'previous' => $query_string_for_previous_accounting_year,        );        return $accounting_years;    }    public function edit_global_record($table, $pk, $name, $value){        $this->db->where('id', $pk);        $data = array(            $name.'' => $value,        );        $this->db->update($table, $data);    }    public function dont_ignore_voucher($voucher_id)    {        $data = array(            'ignored'=>0,        );        $this->db->where('voucher_journal.id',$voucher_id);        $this->db->update('voucher_journal',$data);    }    public function ignore_voucher($voucher_id)    {        $data = array(            'ignored'=>1,        );        $this->db->where('voucher_journal.id',$voucher_id);        $this->db->update('voucher_journal',$data);    }    public function is_editable_title($title)    {        $titles = array();        array_push($titles,'destination shortage');        array_push($titles,'decanding shortage');        array_push($titles,'credit a/c');        array_push($titles,'debit a/c');        array_push($titles,'trip expense');        array_push($titles,'other expense');        array_push($titles,'expense a/c');        array_push($titles,'income a/c');        array_push($titles,'bank a/c');        array_push($titles,'contractor freight a/c from company');        array_push($titles,'contractor freight a/c to customer');        array_push($titles,'contractor commission a/c');        array_push($titles,'contractor service charges');        array_push($titles,'customer freight a/c');        array_push($titles,'company freight a/c');        array_push($titles,'company commission a/c');        array_push($titles,'company w.h.t a/c');        array_push($titles,'company w.h.t a/c');        array_push($titles,'contractor commission to company');        if(!in_array(strtolower($title), $titles)){            return true;        }        return false;    }    public function edit_pin($for='trip')    {        $pass = '';        switch($for)        {            case 'trip':                $pass = '123';            break;            default:                $pass = '123';            break;        }        return $pass;    }    public function dates_limit()    {        $raw_today = date('Y-m-d');        $today = Carbon::createFromFormat('Y-m-d',$raw_today);        $year_after = $today->addYears(1) ->toDateString();        $year_before = $today->subYears(2)->toDateString();        $date_limits = array(            'year_after'=>$year_after,            'year_before'=>$year_before,        );        return $date_limits;    }    public  function trip_ids_from_given_detail_ids($detail_ids)    {        $this->db->select('trip_id');        $this->db->distinct();        $this->db->where_in('trips_details.id', $detail_ids);        $result = $this->db->get('trips_details')->result();        $trip_ids = array();        foreach($result as $record)        {            array_push($trip_ids, $record->trip_id);        }        return $trip_ids;    }    public function controller_path()    {        return base_url().$this->router->fetch_class()."/";    }}