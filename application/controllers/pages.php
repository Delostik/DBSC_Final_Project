<?php

class Pages extends CI_Controller {

    public $uid;
    public $userInfo;
    public $data;
    
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
    }
    
    public function index()
    {
        $this->data['page'] = 'index';
        
    	$this->load->view('pages/header', $this->data);
    	$this->load->view('pages/index');
    	$this->load->view('pages/footer');
    }
    
    public function fresh()
    {
        $data = $this->data;
        $data['page'] = 'fresh';
        
        $data['newBook'] = $this->book_model->getFreshBook(20);
        
        $this->load->view('pages/header', $data);
        $this->load->view('pages/fresh');
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
    
    public function register()
    {
        if ($this->uid) {
            header('Location:./');
        }
        $this->load->view('pages/header', $this->data);
        $this->load->view('pages/register_page');
        $this->load->view('pages/footer');
    }
}
