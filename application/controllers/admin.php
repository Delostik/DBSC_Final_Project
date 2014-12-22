<?php

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model'));
        $this->load->library(array('session'));
        
        $this->uid = $this->session->userdata('uid');
        if ($this->uid) {
            $this->userInfo = $this->user_model->getUserInfoById($this->uid);
        }
        $this->data = array(
            'userName'  => isset($this->userInfo['userName'])?  $this->userInfo['userName'] : '',
            'uid'       => isset($this->userInfo['uid'])?       $this->userInfo['uid']      : 0,
            'userType'  => isset($this->userInfo['userType'])?  $this->userInfo['userType'] : 0,
            'page'      => ''
        );
    }
    
    public function check_privilege()
    {
        if (!$this->data['uid'])
        {
            header('Location:./');
        }
    }
    
    public function index()
    {
        $this->check_privilege();
        
        $this->load->view('admin/header', $this->data);
    }
    
}