<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/3
 * Time: 17:14
 */


require_once __DIR__ . '/../map/Gzpc_flws_bacc.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_bacc.map.php';
require_once __DIR__ . '/../map/Kpdf_huizong.map.php';
require_once __DIR__ . '/../map/Zfzl_bacc_score.map.php';
require_once __DIR__ . '/../map/Zfzl_bacc_flws.map.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/Quantity.php';

class Quantity_BACC
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
//                需要字段名
//                Zfzl_bacc_flws_map::$FLWS,
//                Zfzl_bacc_flws_map::$ItemId,
//                Zfzl_bacc_flws_map::$kplb,
//                Zfzl_bacc_flws_map::$CJR,
//                Zfzl_bacc_flws_map::$CJRQ,
//                Zfzl_bacc_flws_map::$SPR,
//                Zfzl_bacc_flws_map::$SPSJ,
//                Zfzl_bacc_flws_map::$STATUS,
//                Zfzl_bacc_flws_map::$KP_FLWSSCORE,
//                Zfzl_bacc_flws_map::$xmbh


    {

        $real_score = Quantity::coef_count(
            'bacc',
            $item_info[Q_field::$item_total_score]
        );
        $coef_info = Quantity::field_coef_get('bacc');

        $dd = array_key_exists($directors->zhu, Quantity::$police_dd_map) ? Quantity::$police_dd_map[$directors->zhu] : '';
        $sql .= ',' . Table::format_insert_value([
                $directors->zhu,
//                Quantity::$police_dd_map[$directors->zhu],
                $dd,
                $item_info[Q_field::$task_name],
                $item_id,
                $item_info[Q_field::$over_time],
                $item_info[Q_field::$xm_result],
//                $item_info[Q_field::$cj_time],
                $item_info[Q_field::$item_total_score],
                $real_score['zhu'],
                $item_info[Q_field::$count_flwses],
                $director,
                $coef_info['zhu']
            ]);

        foreach ($directors->xie as $name) {
            $dd = array_key_exists($name, Quantity::$police_dd_map) ? Quantity::$police_dd_map[$name] : '';
            $sql .= ',' . Table::format_insert_value([
                    $name,
                    //Quantity::$police_dd_map[$name],
                    $dd,
                    $item_info[Q_field::$task_name],
                    $item_id,
                    $item_info[Q_field::$over_time],
                    $item_info[Q_field::$xm_result],
//                $item_info[Q_field::$cj_time],
                    $item_info[Q_field::$item_total_score],
                    $real_score['xie'],
                    $item_info[Q_field::$count_flwses],
                    $director,
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
        $bacc_score = new Table(Zfzl_bacc_score_map::$table_name, $sqltool);

        //清空目标表 TODO：修改清理范围
        $bacc_score->truncate();

        //进行插入操作
        $afr = $bacc_score->multi_insert(
            [
                Zfzl_bacc_score_map::$name,
                Zfzl_bacc_score_map::$dadui,
                Zfzl_bacc_score_map::$gcmc,
                Zfzl_bacc_score_map::$xmbh,
                Zfzl_bacc_score_map::$overtime,
                Zfzl_bacc_score_map::$xmjg,
                Zfzl_bacc_score_map::$kp_score,
                Zfzl_bacc_score_map::$kp_true_score,
                Zfzl_bacc_score_map::$WS_num,
                Zfzl_bacc_score_map::$cbr,
                Zfzl_bacc_score_map::$cbr_qz
            ],
            substr($sql, 1)
        );

        echo Zfzl_bacc_score_map::$table_name . " affect rows: " . $afr . "\n";
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
        $jdjc_res = $sqltool->execute_dql_res('
            SELECT
            projectId    AS ' . Q_field::$taskId . ',
            projectName  AS ' . Q_field::$task_name . ',
            unitName     AS ' . Q_field::$unit_name . ',
            director     AS ' . Q_field::$director . ' ,
            status       AS ' . Q_field::$status . ' ,
            createTime,
            ' . Q_field::$xm_result . ' ,
            overTime     AS ' . Q_field::$over_time . ',
            flwsID       AS ' . Q_field::$flws_id . ',
            kplb         AS ' . Q_field::$kpld . ',
            CONCAT(\'kpdf_\',kplb) AS ' . Q_field::$kpld_table . '  ,
            kp_name,
            result AS ' . Q_field::$ws_total_score . ',
            kptime
            FROM
            (
                SELECT
                  B.*,
                  A.result AS ' . Q_field::$xm_result . ',
                  A.overTime,
                  A.recordTime,
                  A.status,
                  A.createTime,
                  A.director,
                  A.unitName,
                  A.projectId,
                  A.projectName
                FROM gzpc_xmxx_bacc A LEFT JOIN 
                (SELECT * FROM kpdf_huizong WHERE Item_Type = \'bacc\') B
                    ON A.projectId = B.Item_BH
                WHERE A.overTime IS NOT NULL
            ) C
            WHERE kplb IS NOT NULL
        ');

        //结果数组
        $result_array = [];

        //对结果集进行格式化
        $jdjc_res->each_row(
            Quantity::format_item_flws_func(
                $result_array,
                'bacc'
            )
        );

//        print_r($result_array);

        $jdjc_res->close();

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
              flwsID,
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
            FROM (SELECT * FROM kpdf_huizong WHERE kpdf_huizong.Item_Type = \'bacc\') A
            RIGHT JOIN gzpc_flws_bacc ON A.flwsID = gzpc_flws_bacc.itemId
            AND A.Item_BH = gzpc_flws_bacc.projectId
        ');
        $flws_sql = '';
        $flws_info->each_row(function ($row) use (&$flws_sql) {
            $flws_sql .= ',(
                \'' . $row['name'] . '\',
                \'' . $row['flwsID'] . '\',
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
        $flws_table = (new Table(Zfzl_bacc_flws_map::$table_name, $sqltool));
        $flws_table->truncate();
        if ($flws_sql != '')
            return $flws_table->multi_insert(
                [
                    Zfzl_bacc_flws_map::$FLWS,
                    Zfzl_bacc_flws_map::$ItemId,
                    Zfzl_bacc_flws_map::$kplb,
                    Zfzl_bacc_flws_map::$CJR,
                    Zfzl_bacc_flws_map::$CJRQ,
                    Zfzl_bacc_flws_map::$SPR,
                    Zfzl_bacc_flws_map::$SPSJ,
                    Zfzl_bacc_flws_map::$STATUS,
                    Zfzl_bacc_flws_map::$KP_FLWSSCORE,
                    Zfzl_bacc_flws_map::$xmbh,
                    Zfzl_bacc_flws_map::$KP_TIME
                ],
                substr($flws_sql, 1)
            );
        return 0;
    }
}

