<?php
/**
 * Created by PhpStorm.
 * User: zhuangjiayu
 * Date: 2018/3/19
 */

require_once __DIR__ . '/../common/base.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/../Quantity/Table_gropu.php';


class Capacity
{
    public static $db_map = null;

    /**
     * @param Sql_tool $hzdb
     * @param null|string $date
     * @return int
     */
    public static function insert_score($hzdb, $date = null)
    {
        $sql = '';
        $date_sql = Table_group::format_date(
            '`date`',
            $date,
            false
        );
        foreach (self::$db_map as $dd_name => $db) {
            $sql_tool = Sql_tool::build_by_db($db);
            $sql_tool->execute_dql_res(

                'SELECT * FROM `person_enforce_capacity` ' . $date_sql

            )->each_row(function ($row) use (&$sql, $dd_name) {
                //print_r($row);
                $sql .= ',' . Table::format_insert_value([
                        $row['police_name'],
                        $dd_name,
                        $row['date'],
                        $row['score']
                    ]);
            });
            $sql_tool->close();
        }
        //echo $sql;
        if ($sql != '')
            return $hzdb->execute_dml(
                "INSERT INTO dadui_huizong_query_day (police_name,dd_name,year_month_show,capacity_score) VALUES " . substr($sql, 1)
            );
        return 0;
    }
}

Capacity::$db_map = get_all_dd_db_map();