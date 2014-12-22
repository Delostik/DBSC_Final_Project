<?php

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model', 'book_model'));
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        
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
        if (!$this->data['uid'])
        {
            header('Location:./');
        }
    }
    
    public function index()
    {
        $this->data['page'] = 'index';
        
        $this->load->view('admin/header', $this->data);
    }
    
    public function bookManage()
    {
        $data = $this->data;
        $data['page'] = 'bookManage';
        $data['category'] = $this->book_model->getCategoryList();
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/bookManage_page');
        $this->load->view('admin/footer');
    }
    
    public function userManage()
    {
        $this->data['page'] = 'userManage';
        
        $this->load->view('admin/header', $this->data);
    }
    
}