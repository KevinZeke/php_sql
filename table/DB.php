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
    private $host = 'localhost';
    /**
     * @var null|string
     */
    private $username = 'root';
    /**
     * @var null|string
     */
    private $password = '123456';
    /**
     * @var null|mysqli
     */
    private $connection = null;

    /**
     * @param string $host
     * @param string $username
     * @param string $password
     * @return $this
     */
    public function set_access($host = 'localhost', $username = 'root', $password = '123456')
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        return $this;
    }

    /**
     * @param string|mysqli|Sql_tool $db
     * @return $this
     */
    public function connect($db)
    {
        $sqltool = null;
        if (is_string($db)) {
            $sqltool = Sql_tool::build_by_mysqli(new mysqli(
                $this->host, $this->username, $this->password, $db
            ));
        } else {
            $sqltool = Sql_tool::mysqli_resolve($db);
        }
        if ($sqltool == null) {
            //TODO:exception_handeller
        };
        $this->connection = $sqltool;
        return $this;
    }

    /**
     * @param $table
     * @param string $table_name
     * @return DB_table
     */
    public function use_table($table, $table_name = '')
    {
        return new DB_table($this->connection, $table, $table_name);
    }

    public function close()
    {
        if (self::$connection != null) {
            $this->connection->close();
            $this->connection = null;
        }
    }

    /**
     * @return mysqli|null
     */
    public function get_connection()
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function get_host()
    {
        return $this->host;
    }

    /**
     * @return null|string
     */
    public function get_username()
    {
        return $this->username;
    }

    /**
     * @return null|string
     */
    public function get_password()
    {
        return $this->password;
    }

}