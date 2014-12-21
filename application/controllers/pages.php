<?php

class Pages extends CI_Controller {

    public $uid;
    public $userInfo;
    public $data;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model'));
        $this->load->library(array('session'));
        $uid = $this->session->userdata('uid');
        if ($this->uid) {
            $this->userInfo = $this->user_model->getUserInfoById($uid);
        }
        $this->data = array(
            'userName'  => isset($userInfo['userName'])? $userInfo['userName']: 0,
            'uid'       => isset($this->userInfo['uid'])? $this->userInfo['uid']: 'aaa',
            'userType'  => isset($this->userInfo['userType'])? $this->userInfo['userType']: 0
        );
    }
    
    public function index()
    {
    	$this->load->view('pages/header', $this->data);
    	$this->load->view('pages/index');
    	$this->load->view('pages/footer');
    }
    
    public function login()
    {
        if ($this->uid)
        {
            header('Location:./');
        }
        $this->load->view('pages/header', $this->data);
        $this->load->view('pages/login_page');
        $this->load->view('pages/footer');
    }
}
