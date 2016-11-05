<?php

/**
 * Created by PhpStorm.
 * User: mix
 * Date: 06.09.2015
 * Time: 20:31
 */
class mysqliDb
{
    private $db;
    private $dblocation = 'localhost';
    private $dbuser = 'root';
    private $dbpasswd = '';

    public function __construct($dbname)
    {

        $this->db = mysqli_connect($this->dblocation, $this->dbuser, $this->dbpasswd);
        if (mysqli_errno($this->db)) // Если дескриптор равен 0 соединение не установлено
        {
            echo("<P>В настоящий момент сервер базы данных не доступен, поэтому
           корректное отображение страницы невозможно.</P> ");
            exit;
        } else {
            mysqli_select_db($this->db, $dbname);
            mysqli_query($this->db, 'SET NAMES utf8');
            mysqli_query($this->db, 'SET SQL_BIG_SELECTS=1');
            //return $db;
        }


    }
    public function updQuery($table,$data)
    {
        $upd = '';
        $wh = '';
        foreach ($data['upd'] as $key => $value) {
            $upd .= "`$key`='" . mysqli_real_escape_string($this->db, $value) . "',";
        }
        foreach ($data['whr'] as $key => $value) {
            $wh.= "`$key`='" . mysqli_real_escape_string($this->db, $value) . "' AND ";
        }
        $upd = substr($upd, 0, strlen($upd) - 1);
        $wh = substr($wh, 0, strlen($wh) - 4);
        $sql = "UPDATE $table SET $upd WHERE $wh";
        return $this->dbQuery($sql);
    }
    public function existsRow($table,$data){
        $where='';
        foreach($data as $key=>$value){
            $where.="`$key`='".mysqli_real_escape_string($this->db,$value)."' AND";
        }
        $where = substr($where,0,strlen($where)-3);
        $sql = "SELECT count(*) as counter FROM `$table` WHERE $where";
        $rezult = $this->dbQuery($sql);
        $rezult = mysqli_fetch_assoc($rezult);
        if($rezult['counter']>0) return true;
        return false;
    }
    public function addQuery($table,$data){
        $into='';
        $values = '';
        foreach($data as $key=>$value){
            $into.="`$key`,";
            $values.="'".mysqli_real_escape_string($this->db,$value)."',";
        }
        $into = substr($into,0,strlen($into)-1);
        $values = substr($values,0,strlen($values)-1);
        $sql = "INSERT INTO $table($into) VALUES ($values)";
        return $this->dbQuery($sql);
    }
    public function dbQuery($sql){
        $q = $sql;
        $sql = mysqli_query($this->db,$sql);
        if(mysqli_errno($this->db)){
            echo '<div>'.mysqli_errno($this->db).' '.mysqli_error($this->db).'<br>'.$q.'</div>';
            exit();
        }
        return $sql;
    }
} 