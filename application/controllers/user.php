<?php

class User extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model'));
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
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
    
    public function do_register()
    {
        $userName = $this->input->post('userName');
        $password = $this->input->post('password');
        
        $this->user_model->register($userName, $password);
        header('Location:'. base_url(). "login");
    }
    
    public function do_logout()
    {
        $this->session->unset_userdata('uid');
        header('Location:'. base_url());
    }
    
}