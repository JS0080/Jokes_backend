<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quotes extends CI_Controller {
    
    private $PAGE_COUNT = 10;
    private $errMsg = array(
        "Successfully!",    "Failed!" , 
        "You haven't permission.",
        "Bad Request!",
        "Already Exist Sku ID.",
    );

    public function __construct() {
        parent::__construct();
        $this->load->model('edu_model');
        $this->load->model('utility_model');
    }

    public function index() {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . "user/login.html");
        }
        
       $page_data['page_name'] = 'quotes';
       $this->load->view('quotes_list', $page_data);
    }

    public function likes() {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . "user/login.html");
        }
        
       $page_data['page_name'] = 'likes';
       $this->load->view('quotes_likes', $page_data);
    }
    
    public function load(){
        $cols = array("a.url", "a.rv", "a.created_at");
        $table = "fq_quotes a"; 
        
        $result = array();
        
        $amount = 10;
        $start = 0;
        $col = 5;
	 
	$dir = "desc";
        
        $sStart = $this->input->get_post('start');
        $sAmount = $this->input->get_post('length');
//	$sCol = $this->input->get_post('iSortCol_0'); 
//      $sdir = $this->input->get_post('sSortDir_0');  
        $sCol = "";
        $sdir = "";
        
        $sCol = $this->input->get_post("order");
        foreach ($sCol as $row) {
            foreach ($row as $key => $value) {
                if ($key=='column')
                    $sCol = $value;
                if ($key=='dir')
                    $sdir = $value;
            }
        }
        
        $searchTerm = "";
//        $search = $this->input->get_post("search");
//        foreach ($search as $key => $value) {
//            if ($key=='value')
//                $searchTerm = $value;
//        }
        
        if ($sStart!==false && strlen($sStart)>0){
            $start = intval($sStart);
            if ($start<0){
                $start=0;
            }
        }
        
        if ($sAmount!==false && strlen($sAmount)>0){
            $amount = intval($sAmount);
            if ($amount<10 || $amount>100){
                $amount = 10;
            }
        }
        
        if ($sCol!==false && strlen($sCol)>0){
            $col = intval($sCol);
            if ($col<1 || $col>2){
                $col=1;
            }
        }
        
        if ($sdir && strlen($sdir)>0){
            if ($sdir!="desc"){
                $dir="asc";
            }
        }
        
        $colName = $cols[$col];
        $total = 0;
        $totalAfterFilter = 0;
        
        $sql = " select count(*) from " . $table ;
        $total = $this->edu_model->get_count_for_table($sql);
        $totalAfterFilter = $total;
        
        $sql = " select  a.*, '' as additional, '' as action from " . $table . "  ";
        $searchSQL = "";
        
        $sql .= " order by " . $colName . " " . $dir . " ";
        $sql .= " limit " . $start . ", " . $amount . " ";
        $data = $this->edu_model->get_content_for_table($sql);
        
        $sql = " select count(*) from " . $table . " ";
        
        if (!$this->session->userdata('user_id')) {
            
        } else {
            $result["recordsTotal"] = $total;
            $result["recordsFiltered"] = $totalAfterFilter;
            $result["data"] = $data;
        }
        
        print_r(json_encode($result));
    }

    public function delete() {
        $msg = array('errCode' => 1, 'errMsg' => $this->errMsg[1] );

        if (!$this->session->userdata('user_id')) {
            
        } else {
            $quotes_id = $this->input->get_post('quotes_id');
            
            if ($quotes_id){
                $this->utility_model->delete('fq_quotes', array('id'=>$quotes_id));
                $this->utility_model->delete('fq_likes', array('quotes_id'=>$quotes_id));
                $this->utility_model->delete('fq_category', array('quotes_id'=>$quotes_id));

                $msg['errCode'] = 0;
                $msg['errMsg'] = $this->errMsg[0];
            }
        }
        
        print_r(json_encode($msg));
    }
    
    public function edit(){
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . "user/login.html");
        }
        
        $kind = $this->input->get_post('kind');
        $quotes_id = $this->input->get_post('quotes_id');
        
        $page_data['page_name'] = 'quotes';
        $page_data['quotes_id'] = $quotes_id;
        $page_data['kind'] = $kind;
        
        if ($kind=='add'){
            $page_data['page_title'] = 'Add Quotes';
            $page_data['quotes']=array( 'url'=>'blank.png', 'rv'=>0 );
            
        } else if ($kind=='edit'){
            if ($quotes_id==''){
                redirect(base_url() . "quotes/index.html");
            }
            
            $page_data['page_title'] = 'Edit Quotes';
            $page_data['quotes']=$this->utility_model->get('fq_quotes', array('id'=>$quotes_id));
        }
                
        $this->load->view('quotes_edit', $page_data);
    }
    
    public function update() {
        $msg = array('errCode' => 1, 'errMsg' => $this->errMsg[1] );
        
        if (!$this->session->userdata('user_id')) {
            $msg['errMsg'] = $this->errMsg[3];
            
        } else {
            $kind = $this->input->get_post('kind');
            $quotes_id = $this->input->get_post('quotes_id');
            $logo = $this->input->get_post('image');
            $likes = $this->input->get_post('likes');

                $t = mdate('%Y%m%d%H%i%s', time());

                $data = array('url'=>$logo, 'rv'=>$likes );
                if ($kind=='add'){
                    $data['created_at']=$t;
                    $data['updated_at']=$t;
                    
                    if ( $this->utility_model->insert('fq_quotes', $data) ){
                        $msg['errCode'] = 0;
                        $msg['errMsg'] = $this->errMsg[0];
                    } 
                }
                
                if ($kind=='edit'){
                    $data['created_at']=$t;
                    $data['updated_at']=$t;
                    
                    if ( $this->utility_model->update('fq_quotes', $data, array('id'=>$quotes_id)) ){
                        $msg['errCode'] = 0;
                        $msg['errMsg'] = $this->errMsg[0];
                    } 
                }
        }
        
        print_r(json_encode($msg));
    }


    public function load_likes(){
        $cols = array("a.user_id", "a.rv", "a.created_at");
        $table = "fq_likes a"; 
        
        $result = array();
        
        $amount = 10;
        $start = 0;
        $col = 5;
	 
	$dir = "desc";
        
        $sStart = $this->input->get_post('start');
        $sAmount = $this->input->get_post('length');
//	$sCol = $this->input->get_post('iSortCol_0'); 
//      $sdir = $this->input->get_post('sSortDir_0');  
        $sCol = "";
        $sdir = "";
        
        $sCol = $this->input->get_post("order");
        foreach ($sCol as $row) {
            foreach ($row as $key => $value) {
                if ($key=='column')
                    $sCol = $value;
                if ($key=='dir')
                    $sdir = $value;
            }
        }
        
        $searchTerm = "";
//        $search = $this->input->get_post("search");
//        foreach ($search as $key => $value) {
//            if ($key=='value')
//                $searchTerm = $value;
//        }
        
        if ($sStart!==false && strlen($sStart)>0){
            $start = intval($sStart);
            if ($start<0){
                $start=0;
            }
        }
        
        if ($sAmount!==false && strlen($sAmount)>0){
            $amount = intval($sAmount);
            if ($amount<10 || $amount>100){
                $amount = 10;
            }
        }
        
        if ($sCol!==false && strlen($sCol)>0){
            $col = intval($sCol);
            if ($col<0 || $col>1){
                $col=0;
            }
        }
        
        if ($sdir && strlen($sdir)>0){
            if ($sdir!="desc"){
                $dir="asc";
            }
        }
        
        $colName = $cols[$col];
        $total = 0;
        $totalAfterFilter = 0;
        
        $sql = " select count(*) from " . $table . ", fq_quotes b where a.quotes_id=b.id and a.rv<>0 " ;
        $total = $this->edu_model->get_count_for_table($sql);
        $totalAfterFilter = $total;
        
        $sql = " select  a.*, b.url, '' as additional, '' as action from " . $table . ", fq_quotes b where a.quotes_id=b.id and a.rv<>0 " ;
        $searchSQL = "";
        
        $sql .= " order by " . $colName . " " . $dir . " ";
        $sql .= " limit " . $start . ", " . $amount . " ";
        $data = $this->edu_model->get_content_for_table($sql);
        
        $sql = " select count(*) from " . $table . " ";
        
        if (!$this->session->userdata('user_id')) {
            
        } else {
            $result["recordsTotal"] = $total;
            $result["recordsFiltered"] = $totalAfterFilter;
            $result["data"] = $data;
        }
        
        print_r(json_encode($result));
    }

    public function import() {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . "user/login.html");
        }
        
       $page_data['page_name'] = 'quotes';
       $this->load->view('quotes_import', $page_data);
    }
    
    
}
