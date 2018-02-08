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
     * @var string
     */
    protected static $zhu_key = "\(主\)";
    protected static $zhu_key2 = "（主）";

    /**
     * @param string $names
     * @return stdClass
     */
    public static function format_zhu_xie($names)
    {
        $names_arr = explode('、', $names);
        $zhuxie = new stdClass();
        $zhuxie->zhu = remove_preg($names_arr[0], self::$zhu_key, '');
        $zhuxie->zhu = remove_preg($zhuxie->zhu, self::$zhu_key2, '');
        if (count($names_arr) > 1)
            $zhuxie->xie = explode('、', $names_arr[1]);
        else
            $zhuxie->xie = [];
        return $zhuxie;
    }

    /**
     * 判断当前数据表是否存在符合日期和警员名的数据
     * @param Sql_tool|mysqli $db
     * @param string $table_name
     * @param string $name 警员名
     * @param string $date 日期
     * @return bool 返回布尔值
     */
    public static function _is_row_ext($db, $table_name, $name, $date)
    {
        $sql = "SELECT 1 AS num
	        FROM $table_name
	        WHERE year_month_show = '$date'
	        AND police_name = '$name' LIMIT 1";
        if ($db instanceof Sql_tool)
            $res = $db->execute_dql($sql)->fetch_array();
        else if ($db instanceof mysqli)
            $res = Sql_tool::build_by_mysqli($db)->execute_dql($sql)->fetch_array();
        else
            die("the first argument must be instanceof SqlTool or mysqli");
        if ($res[0] > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param mysqli|Sql_tool $db
     * @return Sql_tool
     */
    public final static function sqlTool_build($db)
    {
        if ($db instanceof Sql_tool)
            return $db;
        else if ($db instanceof mysqli)
            return Sql_tool::build_by_mysqli($db);

        die("sqlTool_build函数必须接受一个SqlTool实例或者mysqli实例作为参数");

    }

    public final static function format_date($date_field_name, $date, $no_prefix = false)
    {
        if (!$date) return '';

        if (is_array($date))
            return ($no_prefix ? '' : Sql_tool::WHERE()) . Sql_tool::BETWEEN(
                    $date_field_name, $date
                );
        else if (is_string($date))
            return
                $no_prefix?Sql_tool::ANDC([$date_field_name => $date])
                :
                Sql_tool::WHERE([$date_field_name => $date]);

    }

    /**
     * @param array $tables
     * @param string $date_field_name
     * @param null|string|array $date
     */
    public final static function group_clear($tables, $date_field_name, $date = null)
    {

        if ($date) {
            $param = self::format_date($date_field_name, $date);
            foreach ($tables as $table) {
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