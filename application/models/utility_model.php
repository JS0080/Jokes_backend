<?php

class Utility_model extends CI_Model    {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_language_list(){
        $query = $this->db->get("edu_language");
        return $query->result_array();
    }
    
    public function get_language_name($code){
        $query = $this->db->get_where("edu_language", array('id'=>$code));
        $result = $query->row_array();
        if ($result && isset($result['name'])){
            return $result['name'];
        }
        
        return '';
    }

    
    public function insert($table, $data){
        return $this->db->insert($table, $data);
    }
    public function update($table, $data, $cond){
        return $this->db->update($table, $data, $cond);
    }
    public function get($table, $cond){
        $query = $this->db->get_where($table, $cond);
        return $query->row_array();
    }
    public function get__by_sql($sql){
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    public function get_list($table, $cond=''){
        $query=null;
        if (is_array($cond)){
            $query = $this->db->get_where($table, $cond);
        } else {
            $query = $this->db->get($table);
        }
        return $query->result_array();
    }
    public function get_count($table, $cond){
        $query = $this->db->get_where($table, $cond);
        return $query->num_rows();
    }
    public function get_count__by_sql($sql){
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    
    public function get_list__by_order($table, $cond, $order){
        foreach ($order as $row) {
            $this->db->order_by($row['name'], $row['order']);
        }
        
        $query = $this->db->get_where($table, $cond);
        return $query->result_array();
    }
    
    public function get_list__by_sql($sql){
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function delete($table, $cond){
       return $this->db->delete($table , $cond);
    }
 
    public function get_field__by_sql($sql, $field){
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if ($row){
            return isset($row[$field]) ? $row[$field] : '';
        }
        
        return '';
    }
    
}