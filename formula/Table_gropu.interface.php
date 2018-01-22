<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/19
 * Time: 下午10:17
 */

/**
 * Class Table_group
 * 表格组
 */
class Table_group
{
    /**
     * 判断当前数据表是否存在符合日期和警员名的数据
     * @param SqlTool|mysqli $db
     * @param string $table_name
     * @param string $name 警员名
     * @param string $date 日期
     * @return bool 返回布尔值
     */
    public static function is_row_ext($db,$table_name, $name, $date)
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

    static function group_update($mysqli, $param){}

    static function group_update_date_in($mysqli, $date_arr){}

    static function group_update_by_id($mysqli, $id){}
}