<?php
/**
 * Created by zhuangjiayu.
 * Date: 2018/2/11
 * Time: 下午5:18
 */

class DB_table
{

    private static $TYPE_SELECT = '_SELECT_';
    private static $TYPE_UPDATE = '_UPDATE_';
    private static $TYPE_INSERT = '_INSERT_';
    private static $TYPE_DELETE = '_DELETE_';
    private static $QUERY_TYPE = 'query_type';
    private static $QUERY_FIELD = 'query_field';
    private static $QUERY_WHREE = 'query_whree';
    private static $QUERY_GROUP = 'query_group';
    private static $QUERY_ORDER = 'query_order';

    /**
     * @var null|Sql_tool
     */
    private $sql_tool = null;

    /**
     * @var array
     */
    private $cur_sql_pieces = [];
    /**
     * @var array
     */
    private $sql_cache = [];

    /**
     * @var null|Table
     */
    private $table = null;

    /**
     * DB_table constructor.
     * @param Sql_tool $sql_tool
     * @param $table
     * @param string $asname
     */
    public function __construct($sql_tool, $table, $asname = '')
    {
        $this->sql_tool = $sql_tool;
        if (is_string($table))
            $this->table = $table;
        elseif ($table instanceof DB_table)
            $this->table = '(' . $table->install_select_sql() . ') ' . $asname;

    }

    /**
     * @param string $piecename
     * @param string $value
     */
    private function set_cur_sql_pieces($piecename, $value)
    {
        $this->cur_sql_pieces[$piecename] = $value;
    }

    private function get_cur_sql_pieces($piecename)
    {
        if (array_key_exists($piecename, $this->cur_sql_pieces)) {
            return $this->cur_sql_pieces[$piecename];
        }
        return '';
    }

    /**
     * @param array|string $fields
     * @return DB_table
     */
    public function select($fields)
    {
        $this->cur_sql_pieces[self::$QUERY_TYPE] = self::$TYPE_SELECT;
        if (is_string($fields)) {
            $this->set_cur_sql_pieces(self::$QUERY_FIELD, $fields);
        } elseif (is_array($fields)) {
            $this->set_cur_sql_pieces(self::$QUERY_FIELD, Sql_tool::format_field($fields));
        } else {
            //TODO:exception_handel
        }
        return $this;
    }

    /**
     * @param array|string $fields
     * @param bool $quote
     * @return DB_table
     */
    public function where($fields, $quote = true)
    {
        if (is_string($fields)) {
            $this->set_cur_sql_pieces(self::$QUERY_WHREE, $fields);
        } elseif (is_array($fields)) {
            $this->set_cur_sql_pieces(self::$QUERY_WHREE, Sql_tool::WHERE($fields, $quote));
        } else {
            //TODO:exception_handel
        }
        return $this;
    }

    /**
     * @param array|string $fields
     * @return DB_table
     */
    public function group_by($fields)
    {
        if (is_string($fields)) {
            $this->set_cur_sql_pieces(self::$QUERY_GROUP, $fields);
        } elseif (is_array($fields)) {
            $this->set_cur_sql_pieces(self::$QUERY_GROUP, Sql_tool::GROUP($fields));
        } else {
            //TODO:exception_handel
        }
        return $this;
    }

    public function query()
    {
        if (($sql = $this->install_sql()) != null) {
            return $this->sql_tool->execute_dql_res($sql);
        }
        return null;
    }

    protected function install_sql($sql_handel = null)
    {
        $sql = null;
        if ($this->get_cur_sql_pieces(DB_table::$QUERY_TYPE) == self::$TYPE_SELECT) {
            return $sql = $this->install_select_sql();
        }
        if (is_callable($sql_handel)) {
            $sql_handel($sql);
        }
    }

    protected function install_select_sql()
    {
        return 'SELECT '
            . $this->get_cur_sql_pieces(DB_table::$QUERY_FIELD)
            . ' FROM ' . $this->table . ' '
            . $this->get_cur_sql_pieces(DB_table::$QUERY_WHREE) . ' '
            . $this->get_cur_sql_pieces(DB_table::$QUERY_GROUP);
    }
}