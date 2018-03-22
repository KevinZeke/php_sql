<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/3
 * Time: 17:14
 */


require_once __DIR__ . '/../map/Gzpc_flws_shys.map.php';
require_once __DIR__ . '/../map/Gzpc_flws_aqjc.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_shys.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_aqjc.map.php';
require_once __DIR__ . '/../map/Zfzl_jsys_score.map.php';
require_once __DIR__ . '/../map/Kpdf_huizong.map.php';
require_once __DIR__ . '/../map/Zfzl_jsys_flws.map.php';
require_once __DIR__ . '/../map/Zfzl_jsys_flws.map.php';
require_once __DIR__ . '/../map/Zfzl_aqjc_score.map.php';
require_once __DIR__ . '/../map/Zfzl_aqjc_flws.map.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/Quantity.php';

class Quantity_SHYS
{

    /**
     * @param Sql_tool $sqltool
     */
    public static function clear($sqltool)
    {
        //TODO
    }

    /**
     * 获取插入表数据的value拼接
     * @param string $sql
     * @param stdClass $directors
     * @param array $item_info
     * @param string $item_id
     * @param string $director
     */
    protected static function score_insert_sql(&$sql,
                                               $directors,
                                               $item_id,
                                               $item_info,
                                               $director)
    {
//        Zfzl_jsys_score_map::$name,
//                Zfzl_jsys_score_map::$dadui,
//                Zfzl_jsys_score_map::$CBR,
//                Zfzl_jsys_score_map::$XMBH,
//                Zfzl_jsys_score_map::$SLSJ,
//                Zfzl_jsys_score_map::$GCMC,
//                Zfzl_jsys_score_map::$OVERTIME,
//                Zfzl_jsys_score_map::$KP_SCORE,
//                Zfzl_jsys_score_map::$KP_TRUE_SCORE,
//                Zfzl_jsys_score_map::$WS_num
        $real_score = Quantity::coef_count(
            'shys',
            $item_info[Q_field::$item_total_score]
        );
        $coef_info = Quantity::field_coef_get('shys');

        $sql .= ',' . Table::format_insert_value([
                $directors->zhu,
                Quantity::$police_dd_map[$directors->zhu],
                $director,
                $item_id,
                $item_info[Q_field::$cj_time],
                $item_info[Q_field::$task_name],
//                $item_info[Q_field::$status],
                $item_info[Q_field::$over_time],
                $item_info[Q_field::$item_total_score],
                $real_score['zhu'],
                $item_info[Q_field::$count_flwses],
                $item_info[Q_field::$status],
                $coef_info['zhu']
            ]);

        foreach ($directors->xie as $name) {
            $sql .= ',' . Table::format_insert_value([
                    $name,
                    Quantity::$police_dd_map[$name],
                    $director,
                    $item_id,
                    $item_info[Q_field::$cj_time],
                    $item_info[Q_field::$task_name],
//                $item_info[Q_field::$status],
                    $item_info[Q_field::$over_time],
                    $item_info[Q_field::$item_total_score],
                    $real_score['xie'],
                    $item_info[Q_field::$count_flwses],
                    $item_info[Q_field::$status],
                    $coef_info['xie']
                ]);
        }
    }

    /**
     * 完成表的插入
     * @param Sql_tool $sqltool
     * @param string $sql
     */
    public static function score_insert($sqltool, $sql)
    {
        //得分表
        $jdjc_score = new Table(Zfzl_jsys_score_map::$table_name, $sqltool);

        //清空目标表 TODO：修改清理范围
//        $jdjc_score->truncate();

        //进行插入操作
        $afr = $jdjc_score->multi_insert(
            [
                Zfzl_jsys_score_map::$name,
                Zfzl_jsys_score_map::$dadui,
                Zfzl_jsys_score_map::$CBR,
                Zfzl_jsys_score_map::$XMBH,
                Zfzl_jsys_score_map::$SLSJ,
                Zfzl_jsys_score_map::$GCMC,
//                Zfzl_jsys_score_map::$JCQX,
                Zfzl_jsys_score_map::$OVERTIME,
                Zfzl_jsys_score_map::$KP_SCORE,
                Zfzl_jsys_score_map::$KP_TRUE_SCORE,
                Zfzl_jsys_score_map::$WS_num,
                Zfzl_jsys_score_map::$Status,
                Zfzl_jsys_score_map::$cbr_qz
            ],
            substr($sql, 1)
        );

        echo Zfzl_jdjc_score_map::$table_name . " affect rows: " . $afr;
    }

    /**
     * @param Sql_tool $sqltool
     * @return array
     */
    public static function get_project_info($sqltool)
    {
        //获取权重信息
//        $jdjc_coef = Quantity::get_coef($sqltool, 'jdjc');

        //获取分值计算相关字段以及项目信息
        $shys_res = $sqltool->execute_dql_res('
            SELECT
            projectId    AS ' . Q_field::$taskId . ',
            projectName    AS ' . Q_field::$task_name . ',
            unitName     AS ' . Q_field::$unit_name . ',
            director     AS ' . Q_field::$director . ' ,
            status       AS ' . Q_field::$status . ' ,
            createTime   AS ' . Q_field::$cj_time . ',
            overTime     AS ' . Q_field::$over_time . ',
            recordTime,
            flwsID       AS ' . Q_field::$flws_id . ',
            kplb         AS ' . Q_field::$kpld . ',
            CONCAT(\'kpdf_\',kplb) AS ' . Q_field::$kpld_table . '  ,
            kp_name,
            result AS ' . Q_field::$ws_total_score . ',
            kptime
            FROM
            (
                SELECT *
                FROM gzpc_xmxx_shys A LEFT JOIN (SELECT * FROM kpdf_huizong WHERE kpdf_huizong.Item_Type = \'shys\') B 
                ON A.projectId = B.Item_BH
                WHERE A.overTime IS NOT NULL
            ) C
            WHERE kplb IS NOT NULL
        ');

        //结果数组
        $result_array = [];

        //对结果集进行格式化
        $shys_res->each_row(
            Quantity::format_item_flws_func(
                $result_array,
                'shys'
            )
        );

        $shys_res->close();

        return $result_array;
    }

    /**
     * @param Sql_tool $sqltool
     */
    public static function insert_score($sqltool)
    {
        //项目信息及法律文书数组
        $result_array = self::get_project_info($sqltool);

        //插入得分表的sql语句
        $score_insert_values = '';

        //遍历结果数组组装sql语句
        foreach ($result_array as $director => $items) {

            $directors = Quantity::format_zhu_xie($director);

            foreach ($items as $item_id => $item_info) {
                //拼接sql语句
                self::score_insert_sql(
                    $score_insert_values,
                    $directors,
                    $item_id,
                    $item_info,
                    $director
                );
            }

        }

        if ($score_insert_values != '')
            self::score_insert($sqltool, $score_insert_values);

    }

    /**
     * @param Sql_tool $sqltool
     * @return int
     */
    public static function insert_flws($sqltool)
    {
        $flws_info = $sqltool->execute_dql_res('
            SELECT
              projectId,
              itemId,
              kplb,
              kp_name,
              result,
              kp_name,
              name,
              creatorPerson,
              createTime,
              checkPerson,
              checkTime,
              status,
              recordTime,
              kptime
            FROM (SELECT * FROM kpdf_huizong WHERE kpdf_huizong.Item_Type = \'shys\') A
              LEFT JOIN gzpc_flws_shys ON A.flwsID = gzpc_flws_shys.itemId
              AND A.Item_BH = gzpc_flws_shys.projectId WHERE projectId IS NOT NULL 
              ; 
        ');
        $flws_sql = '';
        $flws_info->each_row(function ($row) use (&$flws_sql) {
            $flws_sql .= ',(
                \'' . $row['name'] . '\',
                \'' . $row['itemId'] . '\',
                \'' . $row['kplb'] . '\',
                \'' . $row['creatorPerson'] . '\',
                \'' . $row['createTime'] . '\',
                \'' . $row['checkPerson'] . '\',
                \'' . $row['checkTime'] . '\',
                \'' . $row['status'] . '\',
                \'' . $row['result'] . '\',
                \'' . $row['projectId'] . '\',
                \'' . $row['kptime'] . '\'
            )';
        });
        if ($flws_sql != '')
            return (new Table(Zfzl_jsys_flws_map::$table_name, $sqltool))->multi_insert(
                [
                    Zfzl_jsys_flws_map::$FLWS,
                    Zfzl_jsys_flws_map::$ItemId,
                    Zfzl_jsys_flws_map::$kplb,
                    Zfzl_jsys_flws_map::$CJR,
                    Zfzl_jsys_flws_map::$CJRQ,
                    Zfzl_jsys_flws_map::$SPR,
                    Zfzl_jsys_flws_map::$SPSJ,
                    Zfzl_jsys_flws_map::$STATUS,
                    Zfzl_jsys_flws_map::$KP_FLWSSCORE,
                    Zfzl_jsys_flws_map::$xmbh,
                    Zfzl_jsys_flws_map::$KP_TIME
                ],
                substr($flws_sql, 1)
            );
        return 0;
    }
}


class Quantity_AQJC
{

    /**
     * @param Sql_tool $sqltool
     */
    public static function clear($sqltool)
    {
        //得分表
        $aqjc_score = new Table(Zfzl_aqjc_score_map::$table_name, $sqltool);

        //清空目标表 TODO：修改清理范围
        $aqjc_score->truncate();
    }

    /**
     * 获取插入表数据的value拼接
     * @param string $sql
     * @param stdClass $directors
     * @param array $item_info
     * @param string $item_id
     * @param string $director
     */
    protected static function score_insert_sql(&$sql,
                                               $directors,
                                               $item_id,
                                               $item_info,
                                               $director)
    {
//        Zfzl_jsys_score_map::$name,
//                Zfzl_jsys_score_map::$dadui,
//                Zfzl_jsys_score_map::$CBR,
//                Zfzl_jsys_score_map::$XMBH,
//                Zfzl_jsys_score_map::$SLSJ,
//                Zfzl_jsys_score_map::$GCMC,
//                Zfzl_jsys_score_map::$OVERTIME,
//                Zfzl_jsys_score_map::$KP_SCORE,
//                Zfzl_jsys_score_map::$KP_TRUE_SCORE,
//                Zfzl_jsys_score_map::$WS_num
        $real_score = Quantity::coef_count(
            'aqjc',
            $item_info[Q_field::$item_total_score]
        );
        $coef_info = Quantity::field_coef_get('aqjc');

        $sql .= ',' . Table::format_insert_value([
                $directors->zhu,
                Quantity::$police_dd_map[$directors->zhu],
                $director,
                $item_id,
                $item_info[Q_field::$unit_name],
                $item_info[Q_field::$time_limit],
//                $item_info[Q_field::$task_name],
//                $item_info[Q_field::$status],
                $item_info[Q_field::$over_time],
                $item_info[Q_field::$item_total_score],
                $real_score['zhu'],
                $item_info[Q_field::$count_flwses],
                $item_info[Q_field::$status],
                $coef_info['zhu']
            ]);

        foreach ($directors->xie as $name) {
            $sql .= ',' . Table::format_insert_value([
                    $name,
                    Quantity::$police_dd_map[$name],
                    $director,
                    $item_id,
                    $item_info[Q_field::$unit_name],
                    $item_info[Q_field::$time_limit],
//                    $item_info[Q_field::$task_name],
//                $item_info[Q_field::$status],
                    $item_info[Q_field::$over_time],
                    $item_info[Q_field::$item_total_score],
                    $real_score['xie'],
                    $item_info[Q_field::$count_flwses],
                    $item_info[Q_field::$status],
                    $coef_info['xie']
                ]);
        }
    }

    /**
     * 完成表的插入
     * @param Sql_tool $sqltool
     * @param string $sql
     */
    public static function score_insert($sqltool, $sql)
    {
        //得分表
        $jdjc_score = new Table(Zfzl_aqjc_score_map::$table_name, $sqltool);

//        $jdjc_score->truncate();

        //进行插入操作
        $afr = $jdjc_score->multi_insert(
            [
                Zfzl_aqjc_score_map::$name,
                Zfzl_aqjc_score_map::$dadui,
                Zfzl_aqjc_score_map::$CBR,
                Zfzl_aqjc_score_map::$XMBH,
                Zfzl_aqjc_score_map::$DWMC,
                Zfzl_aqjc_score_map::$JCQX,
//                Zfzl_jsys_score_map::$GCMC,
//                Zfzl_jsys_score_map::$JCQX,
                Zfzl_aqjc_score_map::$OVERTIME,
                Zfzl_aqjc_score_map::$KP_SCORE,
                Zfzl_aqjc_score_map::$KP_TRUE_SCORE,
                Zfzl_aqjc_score_map::$WS_num,
                Zfzl_aqjc_score_map::$JCQK,
                Zfzl_aqjc_score_map::$cbr_qz
            ],
            substr($sql, 1)
        );

        echo Zfzl_jsys_score_map::$table_name . " affect rows: " . $afr;
    }

    /**
     * @param Sql_tool $sqltool
     * @return array
     */
    public static function get_project_info($sqltool)
    {
        //获取权重信息
//        $jdjc_coef = Quantity::get_coef($sqltool, 'jdjc');

        //获取分值计算相关字段以及项目信息
        $shys_res = $sqltool->execute_dql_res('
            SELECT
            projectId    AS ' . Q_field::$taskId . ',
            unitName     AS ' . Q_field::$unit_name . ',
            director     AS ' . Q_field::$director . ' ,
            status       AS ' . Q_field::$status . ' ,
            timeLimit       AS ' . Q_field::$time_limit . ' ,
            createTime   AS ' . Q_field::$cj_time . ',
            overTime     AS ' . Q_field::$over_time . ',
            recordTime,
            flwsID       AS ' . Q_field::$flws_id . ',
            kplb         AS ' . Q_field::$kpld . ',
            CONCAT(\'kpdf_\',kplb) AS ' . Q_field::$kpld_table . '  ,
            kp_name,
            result AS ' . Q_field::$ws_total_score . ',
            kptime
            FROM
            (
                SELECT *
                FROM gzpc_xmxx_aqjc A LEFT JOIN (SELECT * FROM kpdf_huizong WHERE kpdf_huizong.Item_Type = \'aqjc\') B 
                ON A.projectId = B.Item_BH
                WHERE A.overTime IS NOT NULL
            ) C
            WHERE kplb IS NOT NULL
        ');

        //结果数组
        $result_array = [];

        //对结果集进行格式化
        $shys_res->each_row(
            Quantity::format_item_flws_func(
                $result_array,
                'aqjc'
            )
        );

        $shys_res->close();

        return $result_array;
    }

    /**
     * @param Sql_tool $sqltool
     */
    public static function insert_score($sqltool)
    {
        //项目信息及法律文书数组
        $result_array = self::get_project_info($sqltool);

        //插入得分表的sql语句
        $score_insert_values = '';

        //遍历结果数组组装sql语句
        foreach ($result_array as $director => $items) {

            $directors = Quantity::format_zhu_xie($director);

            foreach ($items as $item_id => $item_info) {
                //拼接sql语句
                self::score_insert_sql(
                    $score_insert_values,
                    $directors,
                    $item_id,
                    $item_info,
                    $director
                );
            }
        }
        self::clear($sqltool);
        if ($score_insert_values != '')
            self::score_insert($sqltool, $score_insert_values);
    }


    /**
     * @param Sql_tool $sqltool
     * @return int
     */
    public static function insert_flws($sqltool)
    {
        $flws_info = $sqltool->execute_dql_res('
            SELECT
              projectId,
              itemId,
              kplb,
              kp_name,
              result,
              kp_name,
              name,
              creatorPerson,
              createTime,
              checkPerson,
              checkTime,
              status,
              recordTime,
              A.kptime AS kptime
            FROM (SELECT * FROM kpdf_huizong WHERE kpdf_huizong.Item_Type = \'aqjc\') A
              LEFT JOIN gzpc_flws_aqjc ON A.flwsID = gzpc_flws_aqjc.itemId
              WHERE projectId IS NOT NULL 
              ; 
        ');
        $flws_sql = '';
        $flws_info->each_row(function ($row) use (&$flws_sql) {
            $flws_sql .= ',(
                \'' . $row['name'] . '\',
                \'' . $row['itemId'] . '\',
                \'' . $row['kplb'] . '\',
                \'' . $row['creatorPerson'] . '\',
                \'' . $row['createTime'] . '\',
                \'' . $row['checkPerson'] . '\',
                \'' . $row['checkTime'] . '\',
                \'' . $row['status'] . '\',
                \'' . $row['result'] . '\',
                \'' . $row['projectId'] . '\',
                \'' . $row['kptime'] . '\'
            )';
        });
        $aqjc_table = (new Table(Zfzl_aqjc_flws_map::$table_name, $sqltool));
        $aqjc_table->truncate();
        if ($flws_sql && $flws_sql != '')
            return $aqjc_table->multi_insert(
                [
                    Zfzl_aqjc_flws_map::$FLWS,
                    Zfzl_aqjc_flws_map::$ItemId,
                    Zfzl_aqjc_flws_map::$kplb,
                    Zfzl_aqjc_flws_map::$CJR,
                    Zfzl_aqjc_flws_map::$CJRQ,
                    Zfzl_aqjc_flws_map::$SPR,
                    Zfzl_aqjc_flws_map::$SPSJ,
                    Zfzl_aqjc_flws_map::$STATUS,
                    Zfzl_aqjc_flws_map::$KP_FLWSSCORE,
                    Zfzl_aqjc_flws_map::$xmbh,
                    Zfzl_aqjc_flws_map::$KP_TIME
                ],
                substr($flws_sql, 1)
            );
        return 0;
    }
}


class Quantity_JSYS
{
    public static function insert_flws($sqltool)
    {
        (new Table(Zfzl_jsys_flws_map::$table_name, $sqltool))->truncate();
        Quantity_SHYS::insert_flws($sqltool);
        Quantity_AQJC::insert_flws($sqltool);
    }

    public static function insert_score($sqltool)
    {
        (new Table(Zfzl_jsys_score_map::$table_name, $sqltool))->truncate();
        Quantity_SHYS::insert_score($sqltool);
        Quantity_AQJC::insert_score($sqltool);
    }
}
