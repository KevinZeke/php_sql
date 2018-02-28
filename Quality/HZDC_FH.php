<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/3
 * Time: 17:14
 */


require_once __DIR__ . '/../map/Gzpc_flws_hzdc.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_hzdc.map.php';
require_once __DIR__ . '/../map/Kpdf_huizong.map.php';
require_once __DIR__ . '/../map/Zfzl_hzdc_score.map.php';
require_once __DIR__ . '/../map/Zfzl_hzdc_flws.map.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/Quantity.php';

class Quantity_HZDC_FH
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
        //对应字段
//                Zfzl_hzdc_score_map::$name,
//                Zfzl_hzdc_score_map::$dadui,
//                Zfzl_hzdc_score_map::$XMBH,
//                Zfzl_hzdc_score_map::$xmlx,
//                Zfzl_hzdc_score_map::$QHDX,
//                Zfzl_hzdc_score_map::$BJSJ,
//                Zfzl_hzdc_score_map::$JZTIME,
//                Zfzl_hzdc_score_map::$CLTIME,
//                Zfzl_hzdc_score_map::$OVERTIME,
//                Zfzl_hzdc_score_map::$Status,
//                Zfzl_hzdc_score_map::$CBR,
//                Zfzl_hzdc_score_map::$WS_num,
//                Zfzl_hzdc_score_map::$KP_SCORE,
//                Zfzl_hzdc_score_map::$KP_TRUE_SCORE

        $real_score = Quantity::coef_count(
            'hzdc',
            $item_info[Q_field::$item_total_score],
            $item_info[Q_field::$hz_type]
        );
        $coef_info = Quantity::field_coef_get(
            'hzdc',
            $item_info[Q_field::$hz_type]
        );

        $sql .= ',' . Table::format_insert_value([
                $directors->zhu,
                Quantity::$police_dd_map[$directors->zhu],
                $item_id . ';原项目id:' . $item_info[Q_field::$old_taskId],
                $item_info[Q_field::$hz_type],
                $item_info[Q_field::$hz_fire_object],
                $item_info[Q_field::$hz_call_time],
                '0000-00-00',//$item_info[Q_field::$hz_end_date],
                $item_info[Q_field::$hz_handel_date],
                $item_info[Q_field::$hz_complete_date],
                $item_info[Q_field::$hz_now_status],
                $director,
                $item_info[Q_field::$count_flwses],
                $item_info[Q_field::$item_total_score],
                $real_score['zhu'],
                $coef_info['zhu'],
                $coef_info['zl']
            ]);

        foreach ($directors->xie as $name) {
            $sql .= ',' . Table::format_insert_value([
                    $name,
                    Quantity::$police_dd_map[$name],
                    $item_id . ';原项目id:' . $item_info[Q_field::$old_taskId],
                    $item_info[Q_field::$hz_type],
                    $item_info[Q_field::$hz_fire_object],
                    $item_info[Q_field::$hz_call_time],
                    '0000-00-00',//$item_info[Q_field::$hz_end_date],
                    $item_info[Q_field::$hz_handel_date],
                    $item_info[Q_field::$hz_complete_date],
                    $item_info[Q_field::$hz_now_status],
                    $director,
                    $item_info[Q_field::$count_flwses],
                    $item_info[Q_field::$item_total_score],
                    $real_score['xie'],
                    $coef_info['xie'],
                    $coef_info['zl']
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
        $hzdc_score = new Table(Zfzl_hzdc_score_map::$table_name, $sqltool);

        //清空目标表 TODO：修改清理范围
//        $hzdc_score->truncate();

        //进行插入操作
        $afr = $hzdc_score->multi_insert(
            [
                Zfzl_hzdc_score_map::$name,
                Zfzl_hzdc_score_map::$dadui,
                Zfzl_hzdc_score_map::$XMBH,
                Zfzl_hzdc_score_map::$xmlx,
                Zfzl_hzdc_score_map::$QHDX,
                Zfzl_hzdc_score_map::$BJSJ,
                Zfzl_hzdc_score_map::$JZTIME,
                Zfzl_hzdc_score_map::$CLTIME,
                Zfzl_hzdc_score_map::$OVERTIME,
                Zfzl_hzdc_score_map::$Status,
                Zfzl_hzdc_score_map::$CBR,
                Zfzl_hzdc_score_map::$WS_num,
                Zfzl_hzdc_score_map::$KP_SCORE,
                Zfzl_hzdc_score_map::$KP_TRUE_SCORE,
                Zfzl_hzdc_score_map::$zl_qz,
                Zfzl_hzdc_score_map::$cbr_qz
            ],
            substr($sql, 1)
        );

        echo Zfzl_hzdc_score_map::$table_name . " affect rows: " . $afr;
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
        $hzdc_res = $sqltool->execute_dql_res('
            SELECT
            taskId AS ' . Q_field::$taskId . ',
            OldtaskId AS ' . Q_field::$old_taskId . ',
            HzdcType AS ' . Q_field::$hz_type . ',
            FirePart AS ' . Q_field::$hz_fire_object . ',
            FireAddress AS ' . Q_field::$hz_fire_addr . ',
            Director AS ' . Q_field::$director . ',
            CreatDate AS ' . Q_field::$hz_call_time . ',
            HandleDate AS ' . Q_field::$hz_handel_date . ',
            NowStatus AS ' . Q_field::$hz_now_status . ',
            CompleteDate AS ' . Q_field::$hz_complete_date . ',
            RecordTime,
            UpdateTime,
            Item_Type,
            flwsID AS ' . Q_field::$flws_id . ',
            kplb AS ' . Q_field::$kpld . ',
            kp_name,
            result AS ' . Q_field::$ws_total_score . ',
            CONCAT(\'kpdf_\',kplb) AS ' . Q_field::$kpld_table . ' ,
            kptime
            FROM
            (
            SELECT *
            FROM gzpc_xmxx_hzdc_fh A 
            LEFT JOIN (SELECT * FROM kpdf_huizong WHERE Item_Type = \'hzdc\') B
            ON A.taskId = B.Item_BH
            ) C
            WHERE kplb IS NOT NULL
        ');

        //结果数组
        $result_array = [];

        //对结果集进行格式化
        $hzdc_res->each_row(
            Quantity::format_item_flws_func(
                $result_array,
                'hzdc'
            )
        );

//        print_r($result_array);

        $hzdc_res->close();

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
        $flws_table = (new Table(Zfzl_hzdc_flws_map::$table_name, $sqltool));
        //TODO
        $flws_table->truncate();
        $flws_info = $sqltool->execute_dql_res('
            SELECT
              taskId,
              flwsID,
              kplb,
              kp_name,
              result,
              kp_name,
              nodeName,
              name,
              creatorPerson,
              createTime,
              checkPerson,
              checkTime,
              status,
              recordTime,
              kptime
            FROM (SELECT * FROM kpdf_huizong WHERE kpdf_huizong.Item_Type = \'hzdc\') A
              RIGHT JOIN gzpc_flws_hzdc ON A.flwsID = gzpc_flws_hzdc.itemId
        ');
        $flws_sql = '';
        $flws_info->each_row(function ($row) use (&$flws_sql) {
            $flws_sql .= ',(
                \'' . $row['nodeName'] . '\',
                \'' . $row['name'] . '\',
                \'' . $row['flwsID'] . '\',
                \'' . $row['kplb'] . '\',
                \'' . $row['creatorPerson'] . '\',
                \'' . $row['createTime'] . '\',
                \'' . $row['checkPerson'] . '\',
                \'' . $row['checkTime'] . '\',
                \'' . $row['status'] . '\',
                \'' . $row['result'] . '\',
                \'' . $row['taskId'] . '\',
                \'' . $row['kptime'] . '\'
            )';
        });
        if ($flws_sql != '')
            return $flws_table->multi_insert(
                [
                    Zfzl_hzdc_flws_map::$JD,
                    Zfzl_hzdc_flws_map::$FLWS,
                    Zfzl_hzdc_flws_map::$ItemId,
                    Zfzl_hzdc_flws_map::$kplb,
                    Zfzl_hzdc_flws_map::$CJR,
                    Zfzl_hzdc_flws_map::$CJRQ,
                    Zfzl_hzdc_flws_map::$SPR,
                    Zfzl_hzdc_flws_map::$SPSJ,
                    Zfzl_hzdc_flws_map::$STATUS,
                    Zfzl_hzdc_flws_map::$KP_FLWSSCORE,
                    Zfzl_hzdc_flws_map::$xmbh,
                    Zfzl_hzdc_flws_map::$kp
                ],
                substr($flws_sql, 1)
            );
        return 0;
    }
}

