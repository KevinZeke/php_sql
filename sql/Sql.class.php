<?php

class SqlTool
{
    static $rowChange = 1;
    public $mysqli = null;
    private $host;
    private $user;
    private $password;
    private $database;

    function __construct($host = 'localhost', $user = 'root', $password = '123456', $database = 'huaianzhd_db')
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->mysqli = new mysqli($host, $user, $password, $database);
        if ($err = $this->mysqli->connect_error) {
            die("数据库连接失败 : " . $err);
        }
        $this->mysqli->query('SET NAMES UTF8');
    }

    public function __destruct()
    {
        if ($this->mysqli != null)
            $this->mysqli->close();
    }

    public function execute_dql($sql)
    {
        $res = $this->mysqli->query($sql) or die('sql语句出错 : ' . $this->mysqli->error);
        return $res;
    }

    public function execute_dml($sql)
    {
        $res = $this->mysqli->query($sql) or die('sql语句出错 : ' . $this->mysqli->error);
        if (!$res) {
            return -1;
        } else {
            return $this->mysqli->affected_rows;
//            if ($this->mysqli->affected_rows > 0) {
//                return 1;//成功
//            } else {
//                return 2;//表示没有行受到影响
//            }
        }
    }

    static function WHERE($arr = [], $quote = true)
    {
        $str = 'WHERE 1 = 1 ';
        return self::test($arr, $str, $quote);
    }

    static function ON($arr = [], $quote = false)
    {
        $str = 'ON 1 = 1 ';
        return self::test($arr, $str, $quote);
    }

    static function ANDC($arr, $quote = true)
    {
        return self::test($arr, '', $quote);
    }

    static function ORC($arr, $quote = true)
    {
        return self::test($arr, '', $quote, true);
    }

    static function BETWEEN($field, $arr)
    {
        return ' AND ' . $field . ' BETWEEN \'' . $arr[0] . '\' AND \'' . $arr[1] . '\'';
    }

    static private function test($arr, $str, $quote, $or = false)
    {
        if (!is_array($arr) || count($arr) == 0) return $str;
        if (!$or)
            $key = 'AND';
        else
            $key = 'OR';
        foreach ($arr as $field => $value) {
//            echo "$field : $value \n";
            if (hasstring($value, '%'))
                if ($quote)
                    $str .= " $key $field LIKE '$value'  ";
                else
                    $str .= " $key $field LIKE $value  ";
            else
                if ($quote)
                    $str .= " $key $field = '$value' ";
                else
                    $str .= " $key $field = $value ";
        }
        return $str;
    }
}

function hasstring($source, $target)
{
    preg_match_all("/$target/sim", $source, $strResult, PREG_PATTERN_ORDER);
    return !empty($strResult[0]);
}