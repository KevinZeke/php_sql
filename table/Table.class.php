<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/17
 * Time: 18:49
 */


require_once __DIR__ . '/../formula/Formula.class.php';

/**
 * Class Table 数据表操作类
 */
class Table
{
    /**
     * @var string 表名
     */
    var $tableName;
    /**
     * @var null|SqlTool 工具类实例
     */
    private $sqlTool = null;

    /**
     * 将列名数组转化为字符换 ， 若数组的项为键值对形式则转化为 'A AS B'的形式，若未使用键值对的数组项，则不做别名处理
     * @param array $field [列名 => 别名， 列名2 ，.....]
     * @return string
     */
    static function format_field($field)
    {
        $res = array();
        foreach ($field as $k => $v) {
            if (is_numeric($k))
                array_push($res, $v);
            else
                array_push($res, " $k AS $v ");
        }
//        print_r($res);
        return implode(',', $res);
    }

    /**
     * Table constructor.
     * @param $tableName 表名
     * @param $sqlTool SqlTool工具类实例
     */
    public function __construct($tableName, $sqlTool)
    {
        $this->tableName = $tableName;
        $this->sqlTool = $sqlTool;
    }

    //以下两个函数为自定义sql语句查询，接收完整的sql语句字符串作为参数

    /**
     * @param string $sqlstr
     * @return mysqli_result
     */
    public function dql($sqlstr)
    {
        return $this->sqlTool->execute_dql($sqlstr);
    }

    /**
     * @param string $sqlstr
     * @return int
     */
    public function dml($sqlstr)
    {
        return $this->sqlTool->execute_dml($sqlstr);
    }

    /**
     * @param array $field 更新的列名和值键值对 [列名 => 值]
     * @param string $param 查询参数
     * @param bool $isToList 是否需要转换成数组返回
     * @return array|mysqli_result|null
     */
    public function query($field, $param = '', $isToList = false)
    {
        $sql = "SELECT " . Table::format_field($field) . " FROM " . $this->tableName . " $param";
        $resList = null;
        $res = null;
        if ($this->sqlTool != null) {
            $res = $this->sqlTool->execute_dql($sql);
            if (!$isToList) return new SqlResult($res);
            $resList = array();
            while (!!$row = $res->fetch_array()) {
                array_push($resList, $row);
            }
        }
        $res->close();
        return $resList;
    }

    /**
     * @param $field 插入字段数组
     * @param $value 插入值数组，若一维数组则插入一组数据，若二维数组则插入多组数据
     * @return int
     */
    public function multi_insert($field, $value)
    {
        $sql = "INSERT INTO " . $this->tableName . "( " . implode(',', $field) . " ) VALUES ";
        if (!is_array($value) || count($value) == 0) return -1;
        if (is_array($value[0])) {

            $valarr = array();
            foreach ($value as $val) {
                array_push($valarr, '( \'' . implode('\' , \'', $val) . '\' )');
            }
            $sql .= implode(',', $valarr);

        } else {
            $sql .= '(' . implode(',', $value) . ')';
        }
        return $this->sqlTool->execute_dml($sql);
    }

    /**
     * @param array $tables
     * @param array $formula
     * @param string $param
     * @return int
     */
    public function union_insert($tables, $formula, $param)
    {
        $sql = "INSERT INTO $this->tableName (" . implode(',', array_keys($formula))
            . ') SELECT ' . implode(',', $formula) . ' FROM ' . implode(',', $tables) . "  $param";
//        echo $sql;
        return $this->sqlTool->execute_dml($sql);
    }

    /**
     * @param array $fields 更新的列名和值键值对 [列名 => 值]
     * @param string $param 查询参数
     * @param bool $quote 是否需要对新的值添加 '' 参数
     * @return int
     */
    public function update($fields, $param, $quote = true)
    {
        $sql = "UPDATE $this->tableName SET " . Formula::format_formula($fields, $quote) . " $param";
        return $this->sqlTool->execute_dml($sql);
    }

    /**
     * @param Table $tables 关联的Table实例
     * @param array $formula 关联更新公式 [列名 => 值] ， 可使用表格公式类现成公式
     * @param string $param 更新行查询条件
     * @return int
     */
    public function union_update($tables, $formula, $param)
    {
        $sql = "UPDATE $this->tableName , " . implode(',', $tables) . "
        SET " . Formula::format_formula($formula) . " $param";
//        echo $sql;
        return $this->sqlTool->execute_dml($sql);
    }

    /**
     * 删除该表行
     * @param $param
     * @return int
     */
    public function delete($param)
    {
        if (!is_array($param) || count($param) == 0) return -1;
        return $this->sqlTool->execute_dml(
            "DELETE FROM $this->tableName $param"
        );
    }

    /**
     * 左联查询
     * @param Table $table 关联的Table实例
     * @param array $field 查询的两表字段
     * @param string $param 查询条件
     * @param bool $isToList 是否自动将结果转化为数组返回
     * @return array|int|mysqli_result|null
     */
    public function left_join($table, $field, $param, $isToList = false)
    {
        if (!is_array($field) || count($field) == 0) return -1;
        $sql = 'SELECT ' . Table::format_field($field)
            . ' FROM ' . $this->tableName . ' LEFT JOIN ' . $table . " $param";
        $res = null;
        $resList = null;
        if ($this->sqlTool != null) {
            $res = $this->sqlTool->execute_dql($sql);
            if (!$isToList) return $res;
            $resList = array();
            while (!!$row = $res->fetch_array()) {
                array_push($resList, $row);
            }
        }
        $res->close();
        return $resList;
    }

    /**
     * @param $get_field
     * @param $group_field
     * @param bool $isToLsit
     * @return array|mysqli_result
     */
    public function group_query($get_field, $group_field, $isToLsit = false)
    {
        $group = array();
        $where = array();
        foreach ($group_field as $key => $value) {
            if (is_numeric($key)) {
                array_push($group, $value);
            } else {
                array_push($group, $key);
                $where[$key] = $value;
            }
        }
        return $this->query(
            $get_field,
            SqlTool::WHERE($where) . SqlTool::GROUP($group),
            $isToLsit
        );

    }
}