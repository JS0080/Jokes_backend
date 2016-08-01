<?php

$basePath = base_url();
$resPath = $basePath . "resource/";
$message = '';
$user_permission='0';

if ($this->session->userdata('message')){
    $message = $this->session->userdata('message');
    $this->session->set_userdata('message', '');
}

if ($this->session->userdata('type')){
    $user_permission=$this->session->userdata('type');
}
