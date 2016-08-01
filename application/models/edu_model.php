<?php

class Edu_model extends CI_Model    {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_count($table, $cond){
        $query = $this->db->get_where($table, $cond);
        return $query->num_rows();
    }
    public function get_count__by_sql($sql){
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    
    public function get_count_for_table($sql){
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return  $result["count(*)"];
    }
    
    public function get_content_for_table($sql){//, $col, $dir, $start, $amount){
//        $this->db->order_by($col, $dir);
//        $this->db->limit($start, $amount);
        $query = $this->db->query($sql);
        $result = $query->result_array();

        $new_result=array();
        foreach ($result as $row) {
            array_push($new_result, $row);
        }
        
        return $new_result;
    }
 
    public function check_permission($kind, $user_type='0', $user_id, $subject_id='0', $topic_id='0'){
        if ($user_type=='0') {
            return false;
        }
        
        if ($user_type=='1') {
            return true;
        }
        
        if ($kind=='2'){
            if ($user_type=='3') {
                $c = $this->get_count('edu_permission', array('type'=>'3', 'subject_id'=>$subject_id, 'topic_id'=>'0' , 'user_id'=>$user_id ) );
                if ($c>0){
                    return true;
                }
            }
            
            if ($user_type=='2'){
                $c = $this->get_count('edu_permission', array('type'=>'2', 'subject_id'=>$subject_id, 'topic_id'=>'0' , 'user_id'=>$user_id ) );
                if ($c>0){
                    return true;
                }    
            }
        }
        
        if ($kind=='3'){
            if ($user_type=='3'){
                $c = $this->get_count__by_sql(" select a.* from edu_permission a where a.type='3' and a.subject_id='" . $subject_id . "' and a.user_id='" . $user_id . "' and ( a.topic_id='0' or a.topic_id='" . $topic_id . "' ) " );
                if ($c>0){
                    return true;
                } 
            }

            if ($user_type=='2'){
                $c = $this->get_count('edu_permission', array('type'=>'2', 'subject_id'=>$subject_id, 'topic_id'=>'0' , 'user_id'=>$user_id ) );
                if ($c>0){
                    return true;
                } 
            }
        }
        
        if ($kind=='4') {
            $c = $this->get_count('edu_permission', array('subject_id'=>$subject_id, 'type'=>$user_type, 'user_id'=>$user_id ) );
            if ($c>0){
                return true;
            } 
        }
        
        return false;
    }
    
    public function get($table, $condition){
        $query = $this->db->get_where($table, $condition);
        return $query->row_array();
    }
 
    public function get_answer($question_id){
        $this->db->order_by('pos', 'asc');
        $query = $this->db->get_where('edu_topic_answer', array('question_id'=>$question_id));
        return $query->result_array();
    }
    
    public function get_question($topic_id, $language){
        $this->db->order_by('pos', 'asc');
        $query = $this->db->get_where('edu_topic_question', array('topic_id'=>$topic_id, 'language'=>$language));
        $result = $query->result_array();
        
        $new_r = array();
        foreach ($result as $row) {
            $row['answer']=$this->get_answer($row['id']);
            $row['test'] = array(
                'all'=>$this->get_count('log_test', array('question_id'=>$row['id']) ) , 
                'correct'=>$this->get_count('log_test', array('question_id'=>$row['id'], 'status'=>'1' ) )
            );
            array_push($new_r, $row);
        }
        return $new_r;
    }

    public function get_question__by_subject($subject_id){
        $this->db->order_by('subject_id', 'asc');
        $this->db->order_by('topic_id', 'asc');
        $this->db->order_by('pos', 'asc');
        
        $query = $this->db->get_where('edu_topic_question', array('subject_id'=>$subject_id));
        $result = $query->result_array();
        
        $new_r = array();
        foreach ($result as $row) {
            $row['answer']=$this->get_answer($row['id']);
            $row['test'] = array(
                'first'=>array(
                    'all'=>$this->get_count('log_test', array('question_id'=>$row['id'], 'type'=>'0') ) , 
                    'correct'=>$this->get_count('log_test', array('question_id'=>$row['id'], 'type'=>'0', 'status'=>'1') ) , 
                ),
                'all'=>array(
                    'all'=>$this->get_count('log_test', array('question_id'=>$row['id']) ) , 
                    'correct'=>$this->get_count('log_test', array('question_id'=>$row['id'], 'status'=>'1') ) , 
                )
            );
            array_push($new_r, $row);
        }
        return $new_r;
    }
    
    public function get_list__by_sql($sql){
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    
    public function check_purchase($user_id, $subject_id) {
        $purchase_at = "";
        $purchase_type = "";
        
        $sql = " select p.purchase_at from me_purchase_promocode p, me_purchase_promocode_detail d "
               . " where p.user_id='$user_id' and d.purchase_id=p.id and d.subject_id='$subject_id' " 
               . " ";
        $p_promocode = $this->utility_model->get__by_sql($sql);
        if ($p_promocode) {
            $purchase_type = "promocode";
            $purchase_at = $p_promocode['purchase_at'];
        } 
        
        $p_app = $this->utility_model->get('me_purchase_app', array('user_id'=>$user_id, 'subject_id'=>$subject_id));
        if ($p_app) {
            $purchase_type = "in-app";
            $purchase_at = $p_app['purchase_at'];
        } 

        $sql = " select p.purchase_at from me_purchase_web p, me_purchase_web_detail d "
               . " where p.user_id='$user_id' and p.id=d.purchase_id and d.subject_id='$subject_id' " 
               . " ";
        $p_web = $this->utility_model->get__by_sql($sql);
        if ($p_web) {
            $purchase_type = "web";
            $purchase_at = $p_web['purchase_at'];
        } 
        
        $p_admin = $this->utility_model->get('me_purchase_admin', array('user_id'=>$user_id, 'subject_id'=>$subject_id));
        if ($p_admin) {
            $purchase_type = "admin";
            $purchase_at = $p_admin['purchase_at'];
        } 

        return array('type'=>$purchase_type, 'time'=>$purchase_at);
    }
    
    public function get_purchase($user_id, $subject_id) {
        $purchase_at = "";
        $purchase_type = "";

        $sql = " select p.purchase_at from me_purchase_trial p, me_purchase_trial_detail d "
               . " where p.user_id='$user_id' and p.id=d.purchase_id and d.subject_id='$subject_id' " 
               . " ";
        $p_trial = $this->utility_model->get__by_sql($sql);
        if ($p_trial) {
            $purchase_type = "trial";
            $purchase_at = $p_trial['purchase_at'];
        } 

        $sql = " select p.purchase_at from me_purchase_promocode p, me_purchase_promocode_detail d "
               . " where p.user_id='$user_id' and d.purchase_id=p.id and d.subject_id='$subject_id' " 
               . " ";
        $p_promocode = $this->utility_model->get__by_sql($sql);
        if ($p_promocode) {
            $purchase_type = "promocode";
            $purchase_at = $p_promocode['purchase_at'];
        } 
        
        $p_app = $this->utility_model->get('me_purchase_app', array('user_id'=>$user_id, 'subject_id'=>$subject_id));
        if ($p_app) {
            $purchase_type = "in-app";
            $purchase_at = $p_app['purchase_at'];
        } 

        $sql = " select p.purchase_at from me_purchase_web p, me_purchase_web_detail d "
               . " where p.user_id='$user_id' and p.id=d.purchase_id and d.subject_id='$subject_id' " 
               . " ";
        $p_web = $this->utility_model->get__by_sql($sql);
        if ($p_web) {
            $purchase_type = "web";
            $purchase_at = $p_web['purchase_at'];
        } 
        
        $p_admin = $this->utility_model->get('me_purchase_admin', array('user_id'=>$user_id, 'subject_id'=>$subject_id));
        if ($p_admin) {
            $purchase_type = "admin";
            $purchase_at = $p_admin['purchase_at'];
        } 

        return array('type'=>$purchase_type, 'time'=>$purchase_at);
    }
    
    public function init_purchase($user_id, $subject_id) {
        $this->delete('me_purchase_admin', array('user_id'=>$user_id, 'subject_id'=>$subject_id));
        
        $sql = " delete from me_purchase_web_detail where subject_id='$subject_id' and purchase_id in ( select a.id from me_purchase_web a where a.user_id='$user_id' ) ";
        $this->delete__by_sql($sql);
        
        $sql = " delete from me_purchase_promocode_detail where subject_id='$subject_id' and purchase_id in ( select a.id from me_purchase_promocode a where a.user_id='$user_id' ) ";
        $this->delete__by_sql($sql);
    }

    public function delete($table, $cond){
       return $this->db->delete($table , $cond);
    }
    
    public function delete__by_sql($sql){
        return $this->db->query($sql);
    }
}
