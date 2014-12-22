<?php

class Book_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(array('user_model'));
    }

    public function getCategoryList()
    {
        $query = $this->db->from('category')->get();
        if ($query->num_rows)
        {
            $data = $query->result_array();
            array_unshift($data, array('name' => '全部', 'cid' => 0));
            for ($i = 0; $i < count($data); $i++)
            {
                $data[$i]['num'] = $this->getBookNumberByCategoryId($data[$i]['cid']);
            }
            return $data;
        }
        else 
        {
            return null;
        }
    }
    
    public function getBookNumberByCategoryId($cid = 0)
    {
        if ($cid)
        {
            $query = $this->db->from('book')->where('cid', $cid)->get();
        }
        else {
            $query = $this->db->from('book')->get();
        }
        return $query->num_rows;
    }
    
    public function getBookListByCategoryId($cid = 0)
    {
        if ($cid)
        {
            $query = $this->db->from('book')->where('cid', $cid)->get();
        }
        else {
            $query = $this->db->from('book')->get();
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
    
    public function getBookInfoById($bid)
    {
        $query = $this->db->from('book')->where('bid', $bid)->get();
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
    
    public function getRecordByBookId($bid = 0)
    {
        if ($bid)
        {
            $query = $this->db->from('borrow')->where('bid', $bid)->get();
        }
        else 
        {
            $query = $this->db->from('borrow')->get();
        }
        if ($query->num_rows)
        {
            $query = $query->result_array();
            for ($i = 0; $i < count($query); $i++)
            {
                $userInfo = $this->user_model->getUserInfoById($query[$i]['uid']);
                $query[$i]['userName'] = $userInfo['userName'];
                $bookInfo = $this->getBookInfoById($query[$i]['bid']);
                $query[$i]['bookName'] = $bookInfo['name'];
            }
            return $query;
        }
        else
        {
            return null;
        }
    }
    
    public function getFreshBook($num)
    {
        $query = $this->db->from('book')->order_by('bid', 'DESC')->limit($num)->get();
        return $query->result_array();
    }
}