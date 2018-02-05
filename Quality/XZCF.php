<?php
/**
 * @author: zhuangjiayu
 * Date: 2018/2/2
 * Time: 14:27
 */

require_once __DIR__ . '/../map/Gzpc_flws_xzcf.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_xzcf.map.php';
require_once __DIR__ . '/../map/Kpdf_huizong.map.php';
require_once __DIR__ . '/../map/Zfzl_xzcf_score.map.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/Quantity.php';
require_once __DIR__ . '/../common/common.php';


class Quantity_XZCF
{
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
    protected static function score_insert_sql(&$sql, $directors, $item_id, $item_info, $director)
    {
        $sql .= ',' . Table::format_insert_value([
                $directors->zhu,
                Quantity::$police_dd_map[$directors->zhu],
                $item_info[Q_field::$time_limit],
                $item_info[Q_field::$unit_name],
                $item_info[Q_field::$status],
                $item_info[Q_field::$over_time],
                $item_info[Q_field::$cj_time],
                $item_id,
                $item_info[Q_field::$item_total_score],
                $item_info[Q_field::$real_item_total_score]['zhu'],
                $director
            ]);

        foreach ($directors->xie as $name) {
            $sql .= ',' . Table::format_insert_value([
                    $name,
                    Quantity::$police_dd_map[$name],
                    $item_info[Q_field::$time_limit],
                    $item_info[Q_field::$unit_name],
                    $item_info[Q_field::$status],
                    $item_info[Q_field::$over_time],
                    $item_info[Q_field::$cj_time],
                    $item_id,
                    $item_info[Q_field::$item_total_score],
                    $item_info[Q_field::$real_item_total_score]['xie'],
                    $director
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
        $xzcf_score = new Table(Zfzl_xzcf_score_map::$table_name, $sqltool);

        //清空目标表 TODO：修改清理范围
        $xzcf_score->truncate();

        //进行插入操作
        $afr = $xzcf_score->multi_insert(
            [
                Zfzl_xzcf_score_map::$name,
                Zfzl_xzcf_score_map::$dadui,
                Zfzl_xzcf_score_map::$BAQX,
                Zfzl_xzcf_score_map::$CFDX,
                Zfzl_xzcf_score_map::$CFJG,
                Zfzl_xzcf_score_map::$OVERTIME,
                Zfzl_xzcf_score_map::$CJTIME,
                Zfzl_xzcf_score_map::$XMBH,
                Zfzl_xzcf_score_map::$KP_SCORE,
                Zfzl_xzcf_score_map::$KP_TRUE_SCORE,
                Zfzl_xzcf_score_map::$CBR
            ],
            substr($sql, 1)
        );

        echo Zfzl_xzcf_score_map::$table_name . " affect rows: " . $afr;
    }

    /**
     * @param Sql_tool $sqltool
     * @return array
     */
    public static function get_project_info($sqltool)
    {
        //获取权重信息
        $xzcf_coef = Quantity::get_coef($sqltool, 'xzcf');

        //获取分值计算相关字段以及项目信息
        $xzcf_res = $sqltool->execute_dql_res('
            SELECT
            taskId       AS ' . Q_field::$taskId . ',
            unitName     AS ' . Q_field::$unit_name . ',
            reason,
            director     AS ' . Q_field::$director . ' ,
            timeLimit    AS ' . Q_field::$time_limit . ' , 
            status       AS ' . Q_field::$status . ' ,
            createTime,
            cjTime       AS ' . Q_field::$cj_time . ',
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
            FROM gzpc_xmxx_xzcf A LEFT JOIN kpdf_huizong B ON A.taskId = B.Item_BH
            WHERE A.overTime IS NOT NULL
            ) C
            WHERE kplb IS NOT NULL
        ');

        //结果数组
        $result_array = [];

        //对结果集进行格式化
        $xzcf_res->each_row(
            Quantity::format_item_flws_func(
                $result_array,
                $xzcf_coef
            )
        );

        $xzcf_res->close();

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

            //分离主办人和协办人
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
        //完成数据的插入
        self::score_insert($sqltool, $score_insert_values);
    }
}

/**
 * 暂时废弃
 */

//function format_res_array($result_array, $sqltool)
//{
//    foreach ($result_array as $directors => $xm_info) {
//
//        cmd_iconv($directors);
//
//        foreach ($xm_info as $itemId => $kplb_list) {
//
//            echo '  ' . $itemId . "\n";
//
//            foreach ($kplb_list as $kplb) {
//
//                $res_score = $sqltool->execute_dql(
//                    "SELECT SUM($kplb[1].$kplb[0]_Result) AS result
//                      FROM $kplb[1]
//                      WHERE $kplb[1].Item_num
//                      = '$itemId'"
//                );
//
//                echo '     ' . (new SqlResult($res_score))->to_json();
//
//            }
//            echo "\n";
//        }
//    }
//}

//function old()
//{
//    $mysqli = new mysqli(
//        'localhost', 'root', '123456', 'zxpg_gzpc_db'
//    );
//    $sqltool = Sql_tool::build_by_mysqli($mysqli);
//
////记录sql语句
//    Sql_tool::devopen();
//
//    $xmxx_xzcf = new Table(Gzpc_xmxx_xzcf_map::$table_name, $sqltool);
//    $kpdf_hz = new Table(Kpdf_huizong_map::$table_name, $sqltool);
//
////行政处罚项目通过关联taskId（项目id）查找法律文书id
//    $flws_table = $xmxx_xzcf->left_join(
//        Gzpc_flws_xzcf_map::$table_name,
//        [
//            Gzpc_xmxx_xzcf_map::$timeLimit => Q_field::$timeLimit,
//            Gzpc_xmxx_xzcf_map::$director => Q_field::$director,
//            Gzpc_xmxx_xzcf_map::$taskId => Q_field::$taskId,
//            Gzpc_flws_xzcf_map::$itemId => Q_field::$itemId
//
//        ],
//        Sql_tool::ON([
//            Gzpc_xmxx_xzcf_map::$taskId => Gzpc_flws_xzcf_map::$taskId
//        ]),
//        true
//    );
//
////获取法律文书id后关联法律文书id从kpdf中查找法律文书扣分明细表
//    $res = $kpdf_hz->right_join(
//        Sql_tool::CHILD($flws_table, 'A'),
//        [
//            Sql_tool::CONCAT(
//                [Quantity::$kpld_prefix, Kpdf_huizong_map::$kplb],
//                Q_field::$kpld_table
//            ),
//            Kpdf_huizong_map::$kplb => Q_field::$kpld,
//            Kpdf_huizong_map::$flwsID,
//            'A.' . Q_field::$taskId,
//            'A.' . Q_field::$director,
//            'A.' . Q_field::$timeLimit,
//            'A.' . Q_field::$itemId,
//        ],
//        Sql_tool::ON([
//            Kpdf_huizong_map::$flwsID => 'A.' . Q_field::$itemId
//        ], false)
//    );
//
//
//    $result_array = [];
//    $valid_data = $res->each_row(Quantity::format_item_flws_func($result_array));
//
//
//    foreach ($result_array as $directors => $xm_info) {
//
//        cmd_iconv($directors);
////    $sql_array = [];
//        foreach ($xm_info as $itemId => $kplb_list) {
//
//            echo '  ' . $itemId . "\n";
//
//            foreach ($kplb_list as $kplb) {
//
//                $res_score = $sqltool->execute_dql(
//                    "SELECT SUM($kplb[1].$kplb[0]_Result) AS result
//                FROM $kplb[1]
//                WHERE $kplb[1].Item_num
//                = '$itemId'"
//                );
//
//                echo '     ' . (new SqlResult($res_score))->to_json();
//
//            }
////        var_dump(
////            $kplb_list
////        );
////        echo implode(' UNION ', $sql_array);
//            echo "\n";
//        }
//    }
//
//
////print_r($result_array);
////var_dump(
////    $valid_data[0]
////);
////
////$flws_kf_info = new Table($valid_data[0][Q_field::$kpld_table], $sqltool);
////
////$res = $flws_kf_info->query(
////    [
////        Sql_tool::SUM($valid_data[0]['kplb'] . '_Result', 'score')
////    ],
////    Sql_tool::WHERE([
//////        'Wenshu_id' => $valid_data[0][Q_field::$itemId],
////        'Item_num' => $valid_data[0][Q_field::$taskId]
////    ])
////);
//
//
////echo $res->to_json();
//}

/**
 * 暂时废弃
 */