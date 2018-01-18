<?php

class SqlTool{
    public  $mysqli = null;
    private  $host ;
    private  $user ;
    private  $password ;
    private  $database ;
    function __construct($host = 'localhost',$user = 'root',$password = '123456',$database = 'huaianzhd_db')
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->mysqli = new mysqli($host,$user,$password,$database);
        if($err = $this->mysqli->connect_error){
            die("数据库连接失败 : ".$err);
        }
        $this->mysqli->query('SET NAMES UTF8');
    }
    public function __destruct()
    {
        if($this->mysqli!=null)
            $this->mysqli->close();
    }

    public function execute_dql($sql){
        $res = $this->mysqli->query($sql) or die('sql语句出错 : '.$this->mysqli->error);
        return $res;
    }
    public function  execute_dml($sql){
        $res = $this->mysqli->query($sql) or die('sql语句出错 : '.$this->mysqli->error);
        if(!$res){
            return 0;
        }else{
            if($this->mysqli->affected_rows>0){
                return 1;//没有成功
            }else{
                return 2;//表示没有行受到影响
            }
        }
    }

    static function WHERE($arr){
        $str = 'WHERE 1 = 1 ';
        if(!is_array($arr) || count($arr) == 0) return '';
        foreach ($arr as $field=>$value){
            if(hasstring($value,'%'))
                $str.=" AND $field LIKE '$value'  ";
            else
                $str.=" AND $field = '$value' ";
        }
        return $str;
    }
}

function hasstring($source,$target){
    preg_match_all("/$target/sim", $source, $strResult, PREG_PATTERN_ORDER);
    return !empty($strResult[0]);
}