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
    
    public function register($userName, $password)
    {
        $data = array(
            'uid'       =>  $this->getUid(),
            'userName'  =>  $userName,
            'password'  =>  sha1($password),
            'userType'  =>  1
        );
        $this->db->insert('user', $data);
    }
    
    public function getUid()
    {
        $result = $this->db->from('user')->order_by("uid DESC")->limit(1,0)->get()->result_array();
        if (!$result) return 1;
        return $result[0]['uid'] + 1;
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
    
    public function getUserNumberByType($userType)
    {
        if ($userType)
        {
            $query = $this->db->from('user')->where('userType', $userType)->get();
        }
        else
        {
            $query = $this->db->from('user')->get();
        }
        return $query->num_rows;
    }
    
    public function getUserTypeList()
    {
        $data = array(
            0 => array('tid' => 0, 'name' => '全部', 'num' => $this->getUserNumberByType(0)),
            1 => array('tid' => 1, 'name' => '注册用户', 'num' => $this->getUserNumberByType(1)),
            2 => array('tid' => 2, 'name' => '管理用户', 'num' => $this->getUserNumberByType(2))
        );
        return $data;
    }
    
    public function getUserListByType($userType)
    {
        if ($userType)
        {
            $query = $this->db->from('user')->where('userType', $userType)->get();
        }
        else
        {
            $query = $this->db->from('user')->get();
        }
        if ($query->num_rows)
        {
            return $query->result_array();
        }
        else
        {
            return null;
        }
    }
    
}
