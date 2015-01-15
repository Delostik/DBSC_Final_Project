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
        $data = $this->data;
        $data['page'] = 'index';
        $data['newBook'] = $this->book_model->getFreshBook(6);
    	$this->load->view('pages/header', $data);
    	$this->load->view('pages/index');
    	$this->load->view('pages/footer');
    }
    
    public function fresh()
    {
        $data = $this->data;
        $data['page'] = 'fresh';
        
        $data['newBook'] = $this->book_model->getFreshBook(20);
        
        $this->load->view('pages/header', $data);
        $this->load->view('pages/fresh', $data);
        $this->load->view('pages/footer');
    }
    
    public function search()
    {
        $data = $this->data;
        $data['page'] = 'search';
        
        if (isset($_GET['key']))
        {
            $key = $_GET['key'];
            $data['html'] = $this->searchapi_inner($key);
        }
        else
        {
            $data['html'] = null;
        }
        
        $this->load->view('pages/header', $data);
        $this->load->view('pages/search');
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
    
    private function searchapi_inner($keyword = null)
    {
        $data = $this->book_model->search($keyword);
        $html = '';
        foreach ($data as $row)
        {
            $html .= "<div class='book-grid'>
                        <div class='book-cover'>";
            if ($row['pic']) $html .= "<img src='". base_url(). "cover/". $row['pic']. "'/>";
            else             $html .= "<img src='". base_url(). "cover/0.jpg'/>";
            
            $html .=   "</div>
                        <div class='book-intro'>
                            <div class='book-title'>". $row['name']. "</div>
                            <hr />
                                <div class='book-info-detail-line'>". $row['author']. "</div>
                                    <div class='book-info-detail-line'>". $row['press']. "</div>
                                    <div class='book-info-detail-line'>库存：". $row['stock']. "本</div>
                                    <div class='book-info-detail-line'>借阅：". $row['borrow']. "次</div>
                                    <div class='book-info-detail-line'>评分</div>
                                    <div class='book-borrow'>";
            if (!$this->userInfo)
            {
                $html .=                "<button type='button' class='btn btn-info'><strong>请先登录</strong></button>";
            }
            else
            {
                if ($row['stock'])
                {
                    $html .=            "<a href='". base_url(). "confirm/". $row['bid']. "'><button type='button' class='btn btn-primary'><strong>　借阅　</strong></button></a>";
                }
                else
                {
                    $html .=            "<button type='button' class='btn btn-danger'><strong>可借日期</strong></button>";
                }
            }
            $html .=            "</div>
                        </div>
                    </div>";
        }
        return $html;
    }
    
    public function searchapi()
    {
        $keyword = $this->input->get('key');
        $data = $this->book_model->search($keyword);
        $html = '';
        foreach ($data as $row)
        {
            echo    "<div class='book-grid'>
                        <div class='book-cover'>";
            if ($row['pic']) echo "<img src='". base_url(). "cover/". $row['pic']. "'/>";
            else             echo "<img src='". base_url(). "cover/0.jpg'/>";
            echo       "</div>
                        <div class='book-intro'>
                            <div class='book-title'>". $row['name']. "</div>
                            <hr />
                                <div class='book-info-detail-line'>". $row['author']. "</div>
                                    <div class='book-info-detail-line'>". $row['press']. "</div>
                                    <div class='book-info-detail-line'>库存：". $row['stock']. "本</div>
                                    <div class='book-info-detail-line'>借阅：". $row['borrow']. "次</div>
                                    <div class='book-info-detail-line'>评分</div>
                                    <div class='book-borrow'>";
            if (!$this->userInfo)
            {
                echo                    "<button type='button' class='btn btn-info'><strong>请先登录</strong></button>";
            }
            else
            {
                if ($row['stock'])
                {
                    echo                "<a href='". base_url(). "confirm/". $row['bid']. "'><button type='button' class='btn btn-primary'><strong>　借阅　</strong></button></a>";
                }
                else
                {
                    echo                "<button type='button' class='btn btn-danger'><strong>可借日期</strong></button>";
                }
            }
            echo                "</div>
                        </div>
                    </div>";
        }
    }
    
    public function confirm($bid = 0)
    {
        if (!$this->uid || !$this->book_model->exist($bid)) 
        {
            header('Location:'. base_url());
        }
        $data = $this->data;
        $data['book'] = $this->book_model->getBookInfoById($bid);
        $this->load->view('pages/header', $data);
        $this->load->view('pages/confirm');
        $this->load->view('pages/footer');
    }
    
    public function do_borrow($bid)
    {
        if (!$this->uid || !$this->book_model->exist($bid))
        {
            header('Location:'. base_url());
        }
        $res = $this->book_model->borrow($this->uid, $bid);
        echo $res == 1;
    }
    
}
