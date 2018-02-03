<?php

require_once __DIR__ . '/../log/Log.class.php';

class Sql_tool
{
    /**
     * @var bool 是否开发坏境，调试用
     */
    static $isDev = false;

    static function devopen()
    {
        self::$isDev = true;
    }

    static function devclose()
    {
        self::$isDev = false;
    }

    /**
     * @var mysqli|null
     */
    private $mysqli = null;
    /**
     * @var string
     */
    private $host;
    /**
     * @var string
     */
    private $user;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
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
        return (new Sql_tool())->connect($host, $user, $password, $database);
    }

    /**
     * 该函数会通过传入一个mysqli实例进行实例化SqlTool
     * @param $mysqli
     * @return Sql_tool
     */
    static function build_by_mysqli($mysqli)
    {
        return new Sql_tool($mysqli);
    }

    /**
     * Sql_tool类禁止实例化，需要使用静态构造方法 build*
     * Sql_tool constructor.
     * @param null|mysqli $mysqli
     */
    private function __construct($mysqli = null)
    {
        $this->mysqli = $mysqli;
//        if ($mysqli)
//            $this->mysqli->query('SET NAMES UTF8');
    }

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     * @return Sql_tool $this
     */
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
        return $this;
    }

    /**
     * @return mysqli
     */
    public function get_mysqli()
    {

        return $this->mysqli;

    }

    /**
     * @param string $sql
     * @return mysqli_result
     */
    public function execute_dql($sql)
    {
        self::$isDev and Log::write('_test.sql', $sql);

//        return;

        $res = $this->mysqli->query($sql) or die('sql语句出错 : ' . $this->mysqli->error);
        return $res;
    }

    /**
     * @param string $sql
     * @return SqlResult
     */
    public function execute_dql_res($sql)
    {
        return new SqlResult($this->execute_dql($sql));
    }

    /**
     * @param string $sql
     * @return int
     */
    public function execute_dml($sql)
    {
        self::$isDev and Log::write('_test.sql', $sql);

//        return;

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

    /**
     * 对mysql的全局变量进行修改避免其处理长sql语句（>1m）时出现超时和拒绝的问题
     */
    public function do_not_gone_away()
    {
        $this->execute_dml("set global max_allowed_packet=268435456;");
        $this->execute_dml("set global wait_timeout = 2880000;");
        $this->execute_dml("set global interactive_timeout = 2880000;");
//        $this->execute_dml("FLUSH PRIVILEGES;");

//        return $this->mysqli->multi_query(
//            'set global max_allowed_packet=268435456;
//            set global wait_timeout = 2880000;
//            set global interactive_timeout = 2880000;'
//        );

    }

    /**
     * 关闭mysqli句柄
     */
    public function close()
    {
        if ($this->mysqli != null) {
            $this->mysqli->close();
            $this->mysqli = null;
        }
    }

    /*
     *
     * 静态函数用于生成sql条件语句
     *
     */
    /**
     * @param array $arr
     * @param bool $quote
     * @return string
     */
    static function WHERE($arr = [], $quote = true)
    {
        $str = ' WHERE 1 = 1 ';
        return self::test($arr, $str, $quote);
    }

    /**
     * @param array $arr
     * @return string
     */
    static function GROUP($arr)
    {
        return ' GROUP BY ' . implode(',', $arr) . ' ';
    }

    /**
     * @param array $arr
     * @param bool $quote
     * @return string
     */
    static function ON($arr = [], $quote = false)
    {
        $str = ' ON 1 = 1 ';
        return self::test($arr, $str, $quote);
    }

    /**
     * @param array $arr
     * @param bool $quote
     * @return string
     */
    static function ANDC($arr, $quote = true)
    {
        return self::test($arr, '', $quote);
    }

    /**
     * @param array $arr
     * @param bool $quote
     * @return string
     */
    static function ORC($arr, $quote = true)
    {
        return '(' . self::test($arr, '', $quote, true) . ')';
    }

    /**
     * @param string $field
     * @param array $arr
     * @return string
     */
    static function BETWEEN($field, $arr)
    {
        return ' AND ' . $field . ' BETWEEN \'' . $arr[0] . '\' AND \'' . $arr[1] . '\'';
    }

    /**
     * @param string $value
     * @return string
     */
    static function QUOTE($value)
    {
        return "'$value'";
    }

    /**
     * @param string $table
     * @param string $as_name
     * @return string
     */
    static function CHILD($table, $as_name)
    {
        return " ($table) $as_name ";
    }

    /**
     * @param array $str_arr
     * @param string $as_name
     * @return string
     */
    static function CONCAT($str_arr, $as_name)
    {
        return ' CONCAT(' . implode(',', $str_arr) . ')' . " AS $as_name ";
    }

    /**
     * @param string $field
     * @param string $c_name 列别名
     * @return string
     */
    static function SUM($field, $c_name = '')
    {
        return " SUM($field) " . ($c_name == '' ? '' : "AS $c_name");
    }

    /**
     * @param array $arr
     * @param string $str
     * @param bool $quote
     * @param bool $or
     * @param null|string $default_key
     * @return string
     */
    static public function test($arr, $str, $quote, $or = false, $default_key = null)
    {
        if (!is_array($arr) || count($arr) == 0) return $str;
        if (!$or)
            $key = 'AND';
        else
            $key = 'OR';
        foreach ($arr as $field => $value) {

            if (is_array($value)) {
                //TODO
                //$str .= $key . ' (' + self::test($value, '', $quote, true, $field) + ') ';
            } else {
                if (is_numeric($field) && !!$default_key) {
                    $field = $default_key;
                }
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
        }
        return $str;
    }
}

class SqlResult
{

    /**
     * @var mysqli_result
     */
    private $sql_res = null;


    /**
     * SqlResult constructor.
     * @param mysqli $res
     */
    public function __construct($res)
    {
        $this->sql_res = $res;
    }

//    public function __destruct()
//    {
//        $this->close();
//    }

    public function close()
    {
        if ($this->sql_res != null) {
            $this->sql_res->close();
            $this->sql_res = null;
        }
    }

    /**
     * @param string $fetch_style
     * @param $callback
     * @return null
     */
    public function each_row($callback, $fetch_style = 'fetch_array')
    {
        if ($this->sql_res == null) return null;
        while (!!$row = call_user_func_array(array($this->sql_res, $fetch_style), [])) {
            $callback($row);
        }
    }

    /**
     * @param string $fetch_style
     * @return mixed
     */
    public function fetch($fetch_style = 'fetch_array')
    {
        return call_user_func_array(array($this->sql_res, $fetch_style),[]);
    }

    /**
     * @param $filter
     * @param string $fetch_style
     * @return array
     */
    public function to_list($filter = null, $fetch_style = 'fetch_array')
    {
        $res_arr = array();
        if ($filter && is_callable($filter)) {
            $this->each_row(function ($row) use (&$res_arr, $filter) {
                if ($filter($row))
                    array_push($res_arr, $row);
            }, $fetch_style);
            return $res_arr;
        }
        $this->each_row(function ($row) use (&$res_arr) {
            array_push($res_arr, $row);
        }, $fetch_style);
        return $res_arr;
    }

    /**
     * @param $filter
     * @return array
     */
    public function to_objetc_list($filter = null)
    {
        return $this->to_list($filter, 'fetch_object');
    }

    /**
     * @param $filter
     * @return array
     */
    public function to_array_list($filter = null)
    {
        return $this->to_list($filter);
    }

    /**
     * @param $filter
     * @return string
     */
    public function to_json($filter = null)
    {
        return json_encode($this->to_objetc_list($filter));
    }
}

/**
 * @param string $source
 * @param string $target
 * @return bool
 */
function hasstring($source, $target)
{
    preg_match_all("/$target/sim", $source, $strResult, PREG_PATTERN_ORDER);
    return !empty($strResult[0]);
}

function remove_preg($str, $preg, $replace = "")
{
    return preg_replace("/$preg/i", $replace, $str);
}

function cmd_iconv($say, $in = 'UTF-8', $out = 'GB2312')
{
    echo iconv($in, $out, $say);
    echo "\n";
}