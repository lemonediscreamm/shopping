<?php
/*
*ファイルパス:C:\xampp\htdocs\DT\shopping\lib\Session.class.php
*ファイル名:Session.class.php
*アクセスURL:http://localhost/DT/shopping/lib/Session.class.php
*/
namespace shopping\lib;
class Session
{
    public $session_key = '';
    public $db = NULL;

    public function __construct($db)
    {
        session_start();
        $this->session_key = session_id();
        $this->db = $db;
    }

    public function checkSession()
    {
        $customer_no = $this->selectSession();
        //username表示
        if(isset($_SESSION['username'])){
            echo 'こんにちは     '.$_SESSION['username'].'     さん';
        }
        //session idがある
        if ($customer_no !== false) {
            $_SESSION['customer_no'] = $customer_no;
        //session idがない
        } else {
            $res= $this->insertSession();
            if ($res === true) {
                $_SESSION['customer_no'] = $this->db->getLastId();
            } else {
                $_SESSION['customer_no'] = '';
            }
        }
    }

    private function selectSession()
    {
        $table = ' session ';
        $col = ' customer_no ';
        $where = ' session_key = ? ';
        $arrVal = [$this->session_key];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res[0]['customer_no'] : false;
    }
    
    private function insertSession()
    {
        $table = ' session ';
        $insData = ['session_key ' => $this->session_key];
        $res = $this->db->insert($table, $insData);
        return $res;
    }
}