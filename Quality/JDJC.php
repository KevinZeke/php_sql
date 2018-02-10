<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/3
 * Time: 17:14
 */


require_once __DIR__ . '/../map/Gzpc_flws_jdjc.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_jdjc.map.php';
require_once __DIR__ . '/../map/Kpdf_huizong.map.php';
require_once __DIR__ . '/../map/Zfzl_jdjc_score.map.php';
require_once __DIR__ . '/../map/Zfzl_jdjc_flws.map.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/Quantity.php';

class Quantity_JDJC
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

        $real_score = Quantity::coef_count(
            'jdjc',
            $item_info[Q_field::$item_total_score],
            $item_info[Q_field::$proeject_type]
        );

        $sql .= ',' . Table::format_insert_value([
                $directors->zhu,
                Quantity::$police_dd_map[$directors->zhu],
                $director,
                $item_id,
                $item_info[Q_field::$over_time],
                $item_info[Q_field::$time_limit],
//                $item_info[Q_field::$unit_name],
                $item_info[Q_field::$status],
                $item_info[Q_field::$proeject_type],
                $item_info[Q_field::$item_total_score],
                $real_score['zhu'],
//                $item_info[Q_field::$real_item_total_score]['zhu'],
                $item_info[Q_field::$count_flwses]
            ]);

        foreach ($directors->xie as $name) {
            $sql .= ',' . Table::format_insert_value([
                    $name,
                    Quantity::$police_dd_map[$name],
                    $director,
                    $item_id,
                    $item_info[Q_field::$over_time],
                    $item_info[Q_field::$time_limit],
//                $item_info[Q_field::$unit_name],
                    $item_info[Q_field::$status],
                    $item_info[Q_field::$proeject_type],
                    $item_info[Q_field::$item_total_score],
                    $real_score['xie'],
//                    $item_info[Q_field::$real_item_total_score]['xie'],
                    $item_info[Q_field::$count_flwses]
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
        $jdjc_score = new Table(Zfzl_jdjc_score_map::$table_name, $sqltool);

        //清空目标表 TODO：修改清理范围
        $jdjc_score->truncate();

        //进行插入操作
        $afr = $jdjc_score->multi_insert(
            [
                Zfzl_jdjc_score_map::$name,
                Zfzl_jdjc_score_map::$dadui,
                Zfzl_jdjc_score_map::$CBR,
                Zfzl_jdjc_score_map::$XMBH,
                Zfzl_jdjc_score_map::$OVERTIME,
                Zfzl_jdjc_score_map::$JCQX,
                Zfzl_jdjc_score_map::$JCQK,
                Zfzl_jdjc_score_map::$xmlx,
                Zfzl_jdjc_score_map::$KP_SCORE,
                Zfzl_jdjc_score_map::$KP_TRUE_SCORE,
                Zfzl_jdjc_score_map::$WS_num
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
        $jdjc_res = $sqltool->execute_dql_res('
            SELECT
            projectId    AS ' . Q_field::$taskId . ',
            projectType  AS ' . Q_field::$proeject_type . ',
            unitName     AS ' . Q_field::$unit_name . ',
            director     AS ' . Q_field::$director . ' ,
            timeLimit    AS ' . Q_field::$time_limit . ' , 
            status       AS ' . Q_field::$status . ' ,
            createTime,
            overTime     AS ' . Q_field::$over_time . ',
            updateTime,
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
                FROM gzpc_xmxx_jdjc A LEFT JOIN (SELECT * FROM kpdf_huizong WHERE kpdf_huizong.Item_Type = \'jdjc\') B 
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
                'jdjc'
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
              projectId    ,
              flwsID       ,
              kplb         ,
              kp_name      ,
              result       ,
              kp_name      ,
              name         ,
              creatorPerson,
              createTime   ,
              checkPerson  ,
              checkTime    ,
              status       ,
              recordTime   ,
              kptime
            FROM (SELECT * FROM kpdf_huizong WHERE kpdf_huizong.Item_Type = \'jdjc\') A
              RIGHT JOIN gzpc_flws_jdjc ON A.flwsID = gzpc_flws_jdjc.itemId
              AND A.Item_BH = gzpc_flws_jdjc.projectId
              ; 
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
        $flws_table = (new Table(Zfzl_jdjc_flws_map::$table_name, $sqltool));
        $flws_table->truncate();
        if ($flws_sql != '')
            return $flws_table->multi_insert(
                [
                    Zfzl_jdjc_flws_map::$FLWS,
                    Zfzl_jdjc_flws_map::$ItemId,
                    Zfzl_jdjc_flws_map::$kplb,
                    Zfzl_jdjc_flws_map::$CJR,
                    Zfzl_jdjc_flws_map::$CJRQ,
                    Zfzl_jdjc_flws_map::$SPR,
                    Zfzl_jdjc_flws_map::$SPSJ,
                    Zfzl_jdjc_flws_map::$STATUS,
                    Zfzl_jdjc_flws_map::$KP_FLWSSCORE,
                    Zfzl_jdjc_flws_map::$xmbh,
                    Zfzl_jdjc_flws_map::$KP_TIME
                ],
                substr($flws_sql, 1)
            );
        return 0;
    }
}

