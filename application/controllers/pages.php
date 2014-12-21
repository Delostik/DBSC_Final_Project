<?php

class Pages extends CI_Controller {

    public function index()
    {
        $data = '';
    	$this->load->view('pages/header', $data);
    	$this->load->view('pages/index' , $data);
    	$this->load->view('pages/footer', $data);
    }
}
