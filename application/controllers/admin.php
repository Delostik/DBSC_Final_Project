<?php

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model'));
        $this->load->library(array('session'));
    }
    
    public function check_privilege()
    {
        if (!$this->session->userdata('uid'))
        {
            header('Location:./');
        }
        $userInfo = $this->user_model->getUserInfoById($this->session->userdata('uid'));
        if (!$userInfo || $userInfo['userType'] != 2)
        {
            header('Location:./');
        }
    }
    
    public function index()
    {
        $this->check_privilege();
        
        
    }
    
}