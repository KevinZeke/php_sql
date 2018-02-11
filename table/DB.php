<?php
/**
 * Created by zhuangjiayu.
 * Date: 2018/2/11
 * Time: 下午5:17
 */

require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/DB_table.php';

class DB
{
    /**
     * @var string
     */
    private static $host = 'localhost';
    /**
     * @var null|string
     */
    private static $username = 'root';
    /**
     * @var null|string
     */
    private static $password = '123456';
    /**
     * @var null|mysqli
     */
    private static $connection = null;

    /**
     * @param string $host
     * @param string $username
     * @param string $password
     */
    public static function set_access($host = 'localhost', $username = 'root', $password = '123456')
    {
        self::$host = $host;
        self::$username = $username;
        self::$password = $password;
    }

    /**
     * @param string|mysqli|Sql_tool $db
     * @return DB_table
     */
    public static function connect($db)
    {
        $sqltool = null;
        if (is_string($db)) {
            $sqltool = Sql_tool::build_by_mysqli(new mysqli(
                self::$host, self::$username, self::$password, $db
            ));
        } else {
            $sqltool = Sql_tool::mysqli_resolve($db);
        }
        if ($sqltool == null) {
            //TODO:exception_handeller
        };
        self::$connection = $sqltool->get_mysqli();
        return new DB_table($sqltool);
    }

    public static function close()
    {
        if (self::$connection != null) {
            self::$connection->close();
            self::$connection = null;
        }
    }

    /**
     * @return mysqli|null
     */
    public static function get_connection()
    {
        return self::$connection;
    }

    /**
     * @return string
     */
    public static function get_host()
    {
        return self::$host;
    }

    /**
     * @return null|string
     */
    public static function get_username()
    {
        return self::$username;
    }

    /**
     * @return null|string
     */
    public static function get_password()
    {
        return self::$password;
    }

}