<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/18
 * Time: 0:21
 */

require_once __DIR__ . '/Formula.class.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_basic_coef.map.php';

class XZCF_formula extends Formula
{
    static $nbr_2_subscore;
    static $subscore_to_huizong;
}

XZCF_formula::$nbr_2_subscore = Formula::formatFormula([
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
]);

class XZCF_trans_model extends Trans_model
{
    static function subscore_update($xzcf_sub_table, $param)
    {
        return $xzcf_sub_table->unionUpdate(
            [
                Quantity_xzcf_gr_basic_coef_map::$table_name,
                Quantity_xzcf_gr_nbr_map::$table_name,
                Quantity_xzcf_gr_sub_coef_map::$table_name
            ],
            XZCF_formula::$nbr_2_subscore,
            $param
        );
    }

    static function subscore_update_between($xzcf_sub_table, $arr)
    {
        $param = SqlTool::WHERE([
                Quantity_xzcf_gr_nbr_map::$number_id => Quantity_xzcf_gr_sub_score_map::$number_id
            ], false) .
            SqlTool::BETWEEN(Quantity_xzcf_gr_nbr_map::$year_month_show, $arr);
//        echo $param;
        return self::subscore_update($xzcf_sub_table, $param);
    }

    static function subscore_update_by_id($xzcf_sub_table,$number_id){
        $param = SqlTool::WHERE([
                Quantity_xzcf_gr_nbr_map::$number_id => Quantity_xzcf_gr_sub_score_map::$number_id
            ], false) .
            SqlTool::ANDC([Quantity_xzcf_gr_nbr_map::$number_id=>$number_id],false);
//        echo $param;
        return self::subscore_update($xzcf_sub_table, $param);
    }
}
