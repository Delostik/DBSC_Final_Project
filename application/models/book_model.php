<?php

class Book_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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
    
    public function getBookNumberByCategoryId($cid)
    {
        $this->db->from('book');
        if ($cid)
        {
            $query = $this->db->where('cid', $cid)->get();
        }
        else {
            $query = $this->db->get();
        }
        return $query->num_rows;
    }
    
}