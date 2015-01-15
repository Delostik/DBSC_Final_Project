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
        if (!$this->data['uid'] || $this->data['userType'] != 2)
        {
            header('Location:'. base_url());
        }
    }
    
    public function index()
    {
        $data = $this->data;
        $data['page'] = 'index';
        
        $key = 'gerhasrwetasta';
        
        $key = $this->input->get('key');
        $data['record'] = $this->book_model->getRecordByUsername($key);
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/index');
        $this->load->view('admin/footer');
    }
    
    public function bookManage($cid = 0)
    {
        $data = $this->data;
        $data['page'] = 'bookManage';
        $data['category'] = $this->book_model->getCategoryList();
        $data['books']    = $this->book_model->getBookListByCategoryId($cid);
        $data['pageCid']  = $cid;
        $this->load->view('admin/header', $data);
        $this->load->view('admin/bookManage_page');
        $this->load->view('admin/footer');
    }
    
    public function userManage($userType = 0)
    {
        $data = $this->data;
        $data['page'] = 'userManage';
        $data['typeList'] = $this->user_model->getUserTypeList();
        $data['users']    = $this->user_model->getUserListByType($userType);
        $data['pageType']  = $userType;
        $this->load->view('admin/header', $data);
        $this->load->view('admin/userManage_page');
        $this->load->view('admin/footer');
    }
    
    public function record($bid = 0) 
    {
        $data = $this->data;
        $data['record'] = $this->book_model->getRecordByBookId($bid);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/record_page');
        $this->load->view('admin/footer');
    }
    
    public function do_addBook() 
    {
        $this->book_model->addBook($_POST);
        header("Location:". base_url(). "admin/bookManage");
    }
    
    public function do_addCategory()
    {
        $name = $this->input->post('name');
        $this->book_model->addCategory($name);
        header("Location:". base_url(). "admin/bookManage");
    }
    
    public function do_addAdmin()
    {
        $uid = $this->input->post('uid');
        $this->user_model->addAdmin($uid);
        header("Location:". base_url(). "admin/userManage");
    }
    
    function do_addCover()
    {
        $bid = $this->input->post('bid');
        $config['upload_path'] = './cover/';
        $config['allowed_types'] = 'jpg';
        $config['file_name'] = $bid. ".jpg";
        $config['overwrite'] = true;
    
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload())
        {
            //$error = array('error' => $this->upload->display_errors());
             
            //$this->load->view('upload_form', $error);
        }
        else
        {
            $this->book_model->addCover($bid);
            header("Location:". base_url(). "admin/bookManage");
        }
    }
    
    public function modify($bid = 0)
    {
        if (!$bid)
        {
            header("Location:". base_url(). "admin/bookManage");
            return;
        }
        $data = $this->data;
        $data['page'] = '';
        $data['info'] = $this->book_model->getBookInfoById($bid);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/modify');
        $this->load->view('admin/footer');
    }
    
    public function updateInfo()
    {
        $this->book_model->updateInfo($_POST);
        header("Location:". base_url(). "admin/bookManage");
    }
    
    public function success()
    {
        $data = $this->data;
        $data['page'] = '';
        $this->load->view('admin/header', $data);
        $this->load->view('admin/success');
        $this->load->view('admin/footer');
    }
    
    public function returnBook($serial)
    {
        $this->book_model->returnBook($serial);
        header('Location:'. base_url(). "admin/success");
    }
    
    public function record_user()
    {
        $data = $this->data;
        $data['page'] = '';
        $data['record'] = $this->book_model->getRecordByUidAll($data['uid']);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/record_user');
        $this->load->view('admin/footer');
    }
    
}