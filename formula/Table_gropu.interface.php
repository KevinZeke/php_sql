<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/19
 * Time: 下午10:17
 */

require_once __DIR__ . "/../sql/Sql.class.php";

/**
 * Class Table_group
 * 表格组
 */
class Table_group
{

    private function __construct()
    {
        //禁止实例化
    }

    /**
     * 判断当前数据表是否存在符合日期和警员名的数据
     * @param SqlTool|mysqli $db
     * @param string $table_name
     * @param string $name 警员名
     * @param string $date 日期
     * @return bool 返回布尔值
     */
    public static function is_row_ext($db, $table_name, $name, $date)
    {
        $sql = "SELECT 1 AS num
	        FROM $table_name
	        WHERE year_month_show = '$date'
	        AND police_name = '$name' LIMIT 1";
        if ($db instanceof SqlTool)
            $res = $db->execute_dql($sql)->fetch_array();
        else if ($db instanceof mysqli)
            $res = SqlTool::build_by_mysqli($db)->execute_dql($sql)->fetch_array();
        else
            die("the first argument must be instanceof SqlTool or mysqli");
        if ($res[0] > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param mysqli|SqlTool $db
     * @return SqlTool
     */
    public final static function sqlTool_build($db)
    {
        if ($db instanceof SqlTool)
            return $db;
        else if ($db instanceof mysqli)
            return SqlTool::build_by_mysqli($db);

        die("sqlTool_build函数必须接受一个SqlTool实例或者mysqli实例作为参数");

    }

    /**
     * @param array $tables
     * @param string $date_field_name
     * @param null|string|array $date
     */
    public final static function group_clear($tables, $date_field_name, $date = null)
    {

        if ($date) {
            $param = '';
            if (is_array($date))
                $param = SqlTool::WHERE() . SqlTool::BETWEEN(
                        $date_field_name, $date
                    );
            else if (is_string($date))
                $param = SqlTool::WHERE([$date_field_name => $date]);

            foreach ($tables as $table){
                $table->delete($param);
            }
        } else {
            foreach ($tables as $table) {
                $table->truncate();
            }
        }
    }

    static function group_update($mysqli, $param)
    {
    }

    static function group_update_date_in($mysqli, $date_arr)
    {
    }

    static function group_update_by_id($mysqli, $id)
    {
    }
}