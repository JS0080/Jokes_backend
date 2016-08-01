<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    private $errMsg = array(
        "Success!",
        "Failed!",
        "Already exist!",
        "Non Exist User!",
        "Please Active User. <br> Click to \"Reset it\"",
        "Wrong Password!",
        "Bad Crediential!",
        "Expired!",
        "Your Account has been activated!"
    );

    public function __construct() {
        parent::__construct();
//        $this->load->library('user_agent');

        $this->load->model('user_model');
        $this->load->model('utility_model');
        $this->load->model('edu_model');
    }

    public function login() {
        $page_data['page_name'] = 'login';
        $page_data['login_email'] = '';
//        $page_data['facebook_url'] = $this->facebook->login_url();
        $this->load->view('login', $page_data);
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('email');

        redirect(base_url() . "welcome/index.html");
    }

    public function signin() {
        $email = $this->input->get_post('email');
        $password = $this->input->get_post('password');

        $result = $this->user_model->get_user__by_email('user', $email);
        if ($result) {
            if ($result['password'] != sha1($password)) {
                $this->session->set_userdata('message', sha1($password) . ">>>" . $this->errMsg[5]);
                
            } else {
                $this->session->set_userdata('user_id', $result['id']);
                $this->session->set_userdata('email', $result['email']);

                redirect(base_url() . "user/profile.html");
//                if ($this->agent->is_mobile()){
//                }else{
//                }
            }
        } else {
            $this->session->set_userdata('message', $this->errMsg[3]);
        }

        $page_data['page_name'] = 'login';
        $page_data['login_email'] = $email;
//        $page_data['facebook_url'] = $this->facebook->login_url();
        $this->load->view('login', $page_data);
    }

    public function profile() {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . "user/login.html");
        }

        $user_id = $this->session->userdata('user_id');

        $page_data['page_name'] = 'profile';
        $page_data['account'] = $this->user_model->get_user__by_id('user', $user_id);
        $this->load->view('profile', $page_data);
    }

    public function update_profile() {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . "user/login.html");
        }

        $email = $this->input->get_post('email');
        $password = $this->input->get_post('password');

        $ret = false;
        $user_id = $this->session->userdata('user_id');
        if ($user_id){
            $user = $this->user_model->get_user__by_email('user', $email);
            if ($user){
                if ($user_id == $user['id']){
                    $ret = true;
                } else {
                    $this->session->set_userdata('message', $this->errMsg[2]);
                }
            } else {
                $ret = true;
            }
        } else {
            $this->session->set_userdata('message', $this->errMsg[3]);
        }
        
        if ($ret){
            $t = mdate('%Y%m%d%H%i%s', time());
            $data = array('email' => $email, 'password' => sha1($password), 'updated_at' => $t);

            if ($this->user_model->update_user__by_id('user', $user_id, $data)) {
                $this->session->set_userdata('email', $email);
                $this->session->set_userdata('message', $this->errMsg[0]);
            } else {
                $this->session->set_userdata('message', $this->errMsg[1]);
            }
        }

        redirect(base_url() . "user/profile.html");
    }


    public function admob() {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . "user/login.html");
        }

        $user_id = $this->session->userdata('user_id');

        $page_data['page_name'] = 'admob';
        $page_data['admob'] = $this->utility_model->get_list('fq_admob', array());
        $this->load->view('admob', $page_data);
    }    
    
    public function update_admob() {
        $msg = array('errCode' => 1, 'errMsg' => $this->errMsg[1] );
        
        if (!$this->session->userdata('user_id')) {
            $msg['errMsg'] = $this->errMsg[3];
            
        } else {
            $data = $this->input->get_post('data');
            
            if ($data && is_array($data)) {
                foreach ($data as $row) {
                    $this->utility_model->update('fq_admob', array('status'=>$row['status'], 'frequency'=>$row['frequency']) , array('kind'=>$row['kind']));
                }
            }
        }
        
        print_r(json_encode($msg));
    }    
}
