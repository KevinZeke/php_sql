<?php

require_once __DIR__ . '/../log/Log.class.php';

class SqlTool
{
    static $isDev = true;
    public $mysqli = null;
    private $host;
    private $user;
    private $password;
    private $database;

    /**
     * SqlTool类构造函数私有，需要通过静态构造类实例化，该函数通过配置用户名等信息会新建一个mysqli实例
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     * @return $this
     */
    static function build($host = 'localhost', $user = 'root', $password = '123456', $database = 'huaianzhd_db')
    {
        return (new SqlTool())->connect($host, $user, $password, $database);
    }

    /**
     * 该函数会通过传入一个mysqli实例进行实例化SqlTool
     * @param $mysqli
     * @return SqlTool
     */
    static function build_by_mysqli($mysqli)
    {
        return new SqlTool($mysqli);
    }

    private function __construct($mysqli = null)
    {
        $this->mysqli = $mysqli;
//        if ($mysqli)
//            $this->mysqli->query('SET NAMES UTF8');
    }

    private function connect($host, $user, $password, $database)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->mysqli = new mysqli($host, $user, $password, $database);
        if ($err = $this->mysqli->connect_error) {
            Log::write('error', $err);
            die("数据库连接失败 : " . $err);
        }
//        $this->mysqli->query('SET NAMES UTF8');
        return $this;
    }

    public function __destruct()
    {
        $this->close();
    }

    public function execute_dql($sql)
    {
        self::$isDev and Log::write('sql', $sql);
        $res = $this->mysqli->query($sql) or die('sql语句出错 : ' . $this->mysqli->error);
        return $res;
    }

    public function execute_dml($sql)
    {
        self::$isDev and Log::write('sql', $sql);
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

    public function close()
    {
        if ($this->mysqli != null)
            $this->mysqli->close();
    }

    /*
     *
     * 静态函数用于生成sql条件语句
     *
     */
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

    /**
     * 判断当前数据表是否存在符合日期和警员名的数据
     * @param $table   当前数据实例
     * @param $date    日期
     * @param $name    警员名
     * @return bool    返回布尔值
     */
    public function is_row_ext($table, $date, $name)
    {
        $sql = "SELECT COUNT(police_name) AS num
	        FROM $table
	        WHERE year_month_show = '$date'
	        AND police_name = '$name' LIMIT 1";
        $res = $this->execute_dql($sql)->fetch_array();
        if ($res[0] > 0) {
            return true;
        } else {
            return false;
        }
    }
}

function hasstring($source, $target)
{
    preg_match_all("/$target/sim", $source, $strResult, PREG_PATTERN_ORDER);
    return !empty($strResult[0]);
}