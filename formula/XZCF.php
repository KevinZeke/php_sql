<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/18
 * Time: 0:21
 */

require_once __DIR__ . '/Formula.class.php';
require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/Table_gropu.interface.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_basic_coef.map.php';

class XZCF_formula extends Formula
{
    static $nbr_2_subscore;
}

XZCF_formula::$nbr_2_subscore = [
    Quantity_xzcf_gr_sub_score_map::$fks_sub_score
    =>
        Formula::mul(
            [
                Formula::plus(
                    [
                        Formula::mul(
                            [Quantity_xzcf_gr_nbr_map::$fks_feizddw_xiebr,
                                Quantity_xzcf_gr_basic_coef_map::$fks_feizddw_xiebr_xxqz]
                        ),
                        Formula::mul(
                            [Quantity_xzcf_gr_nbr_map::$fks_feizddw_zhubr,
                                Quantity_xzcf_gr_basic_coef_map::$fks_feizddw_zhubr_xxqz]
                        ),
                        Formula::mul(
                            [Quantity_xzcf_gr_nbr_map::$jls_feizddw_xiebr,
                                Quantity_xzcf_gr_basic_coef_map::$jls_feizddw_xiebr_xxqz]
                        ),
                        Formula::mul(
                            [Quantity_xzcf_gr_nbr_map::$fks_zddw_zhubr,
                                Quantity_xzcf_gr_basic_coef_map::$fks_zddw_zhubr_xxqz]
                        )]
                ),
                Quantity_xzcf_gr_sub_coef_map::$fks_zxqz
            ]
        ),

    Quantity_xzcf_gr_sub_score_map::$jls_sub_score
    =>
        Formula::mul(
            [
                Formula::plus(
                    [Formula::mul(
                        [Quantity_xzcf_gr_nbr_map::$jls_feizddw_zhubr,
                            Quantity_xzcf_gr_basic_coef_map::$jls_feizddw_zhubr_xxqz]
                    ),
                        Formula::mul(
                            [Quantity_xzcf_gr_nbr_map::$jls_feizddw_xiebr,
                                Quantity_xzcf_gr_basic_coef_map::$jls_feizddw_xiebr_xxqz]
                        ),
                        Formula::mul(
                            [Quantity_xzcf_gr_nbr_map::$jls_zddw_zhubr,
                                Quantity_xzcf_gr_basic_coef_map::$jls_zddw_zhubr_xxqz]
                        ),
                        Formula::mul(
                            [Quantity_xzcf_gr_nbr_map::$jls_zddw_xiebr,
                                Quantity_xzcf_gr_basic_coef_map::$jls_zddw_xiebr_xxqz]
                        )]
                ),
                Quantity_xzcf_gr_sub_coef_map::$jls_zxqz
            ]
        ),

    Quantity_xzcf_gr_sub_score_map::$zlstdws_sub_score
    => Formula::mul(
        [
            Formula::plus(
                [Formula::mul(
                    [Quantity_xzcf_gr_nbr_map::$zlstdws_feizddw_zhubr,
                        Quantity_xzcf_gr_basic_coef_map::$zlstdws_feizddw_zhubr_xxqz]
                ),
                    Formula::mul(
                        [Quantity_xzcf_gr_nbr_map::$zlstdws_feizddw_xiebr,
                            Quantity_xzcf_gr_basic_coef_map::$zlstdws_feizddw_xiebr_xxqz]
                    ),
                    Formula::mul(
                        [Quantity_xzcf_gr_nbr_map::$zlstdws_zddw_zhubr,
                            Quantity_xzcf_gr_basic_coef_map::$zlstdws_zddw_zhubr_xxqz]
                    ),
                    Formula::mul(
                        [Quantity_xzcf_gr_nbr_map::$zlstdws_zddw_xiebr,
                            Quantity_xzcf_gr_basic_coef_map::$zlstdws_zddw_xiebr_xxqz]
                    )]
            ),
            Quantity_xzcf_gr_sub_coef_map::$zlstdws_zxqz
        ]
    ),
    Quantity_xzcf_gr_sub_score_map::$xzcf_zdf =>
        Formula::plus([
            Quantity_xzcf_gr_sub_score_map::$zlstdws_sub_score,
            Quantity_xzcf_gr_sub_score_map::$jls_sub_score,
            Quantity_xzcf_gr_sub_score_map::$fks_sub_score
        ])
];

/**
 * Class XZCF_group
 * 行政处罚表格组类 : 该类用于行政处罚项目的关联更新，使用关联更新函数将会自动根据上一级表计算公式得到更新后的结果，非自定义参数更新
 */
class XZCF_group extends Table_group
{
    /**
     * Table的类的union_update方法的包装函数，预设了配置
     * xzcf_gr_nbr => xzcf_gr_sub_score 更新函数
     * @param $mysqli
     * @param $param
     * @return mixed
     */
    static function group_update($mysqli, $param)
    {
        return (new Table(Quantity_xzcf_gr_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_xzcf_gr_basic_coef_map::$table_name,
                    Quantity_xzcf_gr_nbr_map::$table_name,
                    Quantity_xzcf_gr_sub_coef_map::$table_name
                ],
                XZCF_formula::$nbr_2_subscore,
                $param
            );
    }

    /**
     * group_update的包装函数，只需要给定日期区间则自动更新
     * @param $mysqli
     * @param $date_arr
     * @return mixed
     */
    static function group_update_date_in($mysqli, $date_arr)
    {
        $param = SqlTool::WHERE([
                Quantity_xzcf_gr_nbr_map::$number_id => Quantity_xzcf_gr_sub_score_map::$number_id
            ], false) .
            SqlTool::BETWEEN(Quantity_xzcf_gr_nbr_map::$year_month_show, $date_arr);
//        echo $param;
        return self::group_update($mysqli, $param);
    }

    /**
     * group_update的包装函数，只需要给定number_id则自动更新
     * @param $mysqli
     * @param $number_id
     * @return mixed
     */
    static function group_update_by_id($mysqli, $number_id)
    {
        $param = SqlTool::WHERE([
                Quantity_xzcf_gr_nbr_map::$number_id => Quantity_xzcf_gr_sub_score_map::$number_id
            ], false) .
            SqlTool::ANDC([Quantity_xzcf_gr_nbr_map::$number_id => $number_id], false);
//        echo $param;
        return self::group_update($mysqli, $param);
    }
}
