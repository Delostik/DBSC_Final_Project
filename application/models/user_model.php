<?php

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function login($userName, $password)
    {
        $query = $this->db->from('user')->where('userName', $userName)->where('password', sha1($password))->get();
        if ($query->num_rows)
        {
            $query = $query->result_array();
            return $query[0];
        }
        else
        {
            return null;
        }
    }
    
    public function getUserInfoById($uid)
    {
        $query = $this->db->from('user')->where('uid', $uid)->get();
        if ($query->num_rows)
        {
            $query = $query->result_array();
            return $query[0];
        }
        else
        {
            return null;
        }
    }
    
}
