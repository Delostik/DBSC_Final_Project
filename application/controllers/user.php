<?php

class User extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model'));
        $this->load->library(array('session'));
    }
    
    public function do_login()
    {
        $userName = $this->input->post('userName');
        $password = $this->input->post('password');
        
        $query = $this->user_model->login($userName, $password);
        
        if ($query)
        {
            $this->session->set_userdata('uid', $query['uid']);
            header('Location:../');
        }
        else
        {
            echo "False";
        }
    }
    
    public function getUid()
    {
        $result = $this->db->from('user')->order_by("uid DESC")->limit(1,0)->get()->result_array();
        if (!$result) return 1;
        return $result[0]['uid'] + 1;
    }
    
    public function do_register()
    {
        $userName = $this->input->post('userName');
        $password = $this->input->post('password');
        
        $data = array(
            'uid'       =>  $this->getUid(),
            'userName'  =>  $userName,
            'password'  =>  sha1($password)
        );
        $this->db->insert('user', $data);
        header('Location:../');
    }
    
    public function do_logout()
    {
        $this->session->unset_userdata('uid');
        header('Location:../');
    }
    
}