<?php

class Book_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(array('user_model'));
        date_default_timezone_set('PRC');
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
    
    public function getRecordByUsername($username)
    {
        if (!$username) return null;
        $uid = 0;
        $query = $this->db->from('user')->where('userName', $username)->get();
        if ($query->num_rows)
        {
            $uid = $query->result_array();
            $uid = $uid[0]['uid'];
        }
        $this->db->flush_cache();
        $query = $this->db->from('borrow')->where('uid', $uid)->where('state != 0')->get();
        if ($query->num_rows)
        {
            $query = $query->result_array();
            for ($i = 0; $i < count($query); $i++)
            {
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
    
    public function getRecordByUidAll($uid)
    {
        $query = $this->db->from('borrow')->where('uid', $uid)->get();
        if ($query->num_rows)
        {
            $query = $query->result_array();
            for ($i = 0; $i < count($query); $i++)
            {
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
    
    public function search($key)
    {
        $query = array();
        $query = $this->search_base($key);
        $arr = explode(' ', $key);
        foreach ($arr as $item)
        {
            $temp = $this->search_base($item);
            $query = array_merge($query, $temp);
            $query = $this->unique($query);
        }
        return $query;
    }
    
    private function search_base($key)
    {
        $query = $this->db->from('book')->where("name like '%". $key. "%' or author like '%". $key. "%' or press like '%". $key. "%'")->get();
            
        if ($query->num_rows)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }
    
    private function unique($data = array())
    {
        $tmp = array();
        foreach ($data as $key => $value)
        {
            foreach ($value as $key1 => $value1)
            {
                $value[$key1] = $key1 . '_|_' . $value1;
            }
            $tmp[$key] = implode(',|,', $value);
        }
        $tmp = array_unique($tmp);

        $newArr = array();
        foreach ($tmp as $k => $tmp_v)
        {
            $tmp_v2 = explode(',|,', $tmp_v);
            foreach ($tmp_v2 as $k2 => $v2)
            {
                $v2 = explode('_|_', $v2);
                $tmp_v3[$v2[0]] = $v2[1];
            }
            $newArr[$k] = $tmp_v3;
        }
        return $newArr;
    }
    
    public function exist($bid)
    {
        $query = $this->db->from('book')->where('bid', $bid)->get()->num_rows;
        return $query == 1;
    }

    public function borrow($uid, $bid)
    {
        $data = $this->getBookInfoById($bid);
        if ($data['stock'] <= 0)
        {
            return 0;
        }
        $data['stock'] = $data['stock'] - 1;
        $data['borrow'] = $data['borrow'] + 1;
        $this->db->update('book', $data, array('bid' => $bid));
        
        $serial = $this->db->from('borrow')->limit(1, 0)->order_by('serial', 'DESC')->get();
        if (!$serial) $serial = 1;
        else 
        {
            $serial = $serial->result_array(); 
            $serial = $serial[0]['serial'] + 1;
        }
        $data = array(
            'serial'     => $serial,
            'bid'        => $bid,
            'uid'        => $uid,
            'borrowtime' => date('Y-m-d h:i:s'),
            'returntime' => date('Y-m-d h:i:s',strtotime('+30 day')),
            'state'      => 1
        );
        $this->db->insert('borrow', $data);
       
        return 1;
    }
    
    private function getBid()
    {
        $query = $this->db->from('book')->order_by('bid', 'DESC')->limit(1, 0)->get();
        if ($query->num_rows)
        {
            $query = $query->result_array();
            return $query[0]['bid'] + 1;
        }        
        else 
        {
            return 1;
        }
    }
    
    public function addBook($arr) 
    {
        $data = array(
            'bid'       => $this->getBid(),
            'cid'       => $arr['category'],
            'name'      => $arr['name'],
            'author'    => $arr['author'],
            'press'     => $arr['press'],
            'ISBN'      => $arr['ISBN'],
            'price'     => $arr['price'],
            'stock'     => $arr['stock'],
            'borrow'    =>  0,
            'pic'       => ''
        );
        $this->db->insert('book', $data);
    }
    
    private function getCid()
    {
        $query = $this->db->from('category')->order_by('cid', 'DESC')->limit(1, 0)->get();
        if ($query->num_rows)
        {
            $query = $query->result_array();
            return $query[0]['cid'] + 1;
        }
        else
        {
            return 1;
        }
    }
    
    public function addCategory($name)
    {
        $data = array(
            'cid'   => $this->getCid(),
            'name'  => $name
        );
        $this->db->insert('category', $data);
    }
    
    public function addCover($bid)
    {
        $this->db->set('pic', $bid. ".jpg")->where('bid', $bid)->update('book');
    }
    
    public function updateInfo($arr)
    {
        $data = array(
            "bid"   => $arr['bid'],
            "cid"   => $arr['cid'],
            "name"   => $arr['name'],
            "author"   => $arr['author'],
            "press"   => $arr['press'],
            "ISBN"   => $arr['ISBN'],
            "price"   => $arr['price'],
            "stock"   => $arr['stock'],
            "borrow"   => $arr['borrow'],
            "pic"   => $arr['pic']
        );
        $this->db->update('book', $data, array('bid' => $arr['bid']));
    }
    
    public function returnBook($serial)
    {
        $this->db->set('state', 0)->where('serial', $serial)->update('borrow');
        $this->db->flush_cache();
        $bid = $this->db->from('borrow')->where('serial', $serial)->get()->result_array();
        $bid = $bid[0]['bid'];
        $this->db->flush_cache();
        $stock = $this->db->from('book')->where('bid', $bid)->get()->result_array();
        $stock = $stock[0]['stock'];
        echo $bid, $stock;
        $this->db->flush_cache();
        $this->db->set('stock', $stock+1)->where('bid', $bid)->update('book');
    }
    
}