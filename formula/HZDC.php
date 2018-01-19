<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/19
 * Time: 下午8:59
 */

require_once __DIR__ . '/Formula.class.php';
require_once __DIR__ . '/Table_gropu.interface.php';
require_once __DIR__ . '/../map/Quantity_hzdc_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_hzdc_gr_basic_coef.map.php';
require_once __DIR__ . '/../map/Quantity_hzdc_gr_sub_coef.map.php';
require_once __DIR__ . '/../map/Quantity_hzdc_gr_basic_score.map.php';
require_once __DIR__ . '/../map/Quantity_hzdc_gr_sub_score.map.php';

class HZDC_formula extends Formula
{
    static $nbr_2_basicscore;
    static $basic_2_sub;
    static $zzhzyydc_jydc_xiebr_basic;
    static $zzhzyydc_jydc_zhubr_basic;
    static $zzhzyydc_ybdc_xiebr_basic;
    static $zzhzyydc_ybdc_zhubr_basic;
}

HZDC_formula::$zzhzyydc_jydc_xiebr_basic = Formula::mul(
    [
        Quantity_hzdc_gr_nbr_map::$zzhzyydc_jydc_xiebr,
        Quantity_hzdc_gr_basic_coef_map::$zzhzyydc_jydc_xiebr_xxqz
    ]
);

HZDC_formula::$zzhzyydc_jydc_zhubr_basic = Formula::mul(
    [
        Quantity_hzdc_gr_nbr_map::$zzhzyydc_jydc_zhubr,
        Quantity_hzdc_gr_basic_coef_map::$zzhzyydc_jydc_zhubr_xxqz
    ]
);

HZDC_formula::$zzhzyydc_ybdc_xiebr_basic = Formula::mul(
    [
        Quantity_hzdc_gr_nbr_map::$zzhzyydc_ybdc_xiebr,
        Quantity_hzdc_gr_basic_coef_map::$zzhzyydc_ybdc_xiebr_xxqz
    ]
);

HZDC_formula::$zzhzyydc_ybdc_zhubr_basic = Formula::mul(
    [
        Quantity_hzdc_gr_nbr_map::$zzhzyydc_ybdc_zhubr,
        Quantity_hzdc_gr_basic_coef_map::$zzhzyydc_ybdc_zhubr_xxqz
    ]
);

HZDC_formula::$nbr_2_basicscore = [

    Quantity_hzdc_gr_basic_score_map::$zzhzyydc_jydc_xiebr_score = HZDC_formula::$zzhzyydc_jydc_xiebr_basic
    ,
    Quantity_hzdc_gr_basic_score_map::$zzhzyydc_jydc_zhubr_score => HZDC_formula::$zzhzyydc_jydc_zhubr_basic
    ,
    Quantity_hzdc_gr_basic_score_map::$zzhzyydc_ybdc_xiebr_score => HZDC_formula::$zzhzyydc_ybdc_xiebr_basic
    ,
    Quantity_hzdc_gr_basic_score_map::$zzhzyydc_ybdc_zhubr_score => HZDC_formula::$zzhzyydc_ybdc_zhubr_basic

];

HZDC_formula::$basic_2_sub = [
    Quantity_hzdc_gr_sub_score_map::$hzdcs_sub_score => Formula::mul([
        Formula::plus(
            [
                Quantity_hzdc_gr_basic_score_map::$zzhzyydc_jydc_xiebr_score,
                Quantity_hzdc_gr_basic_score_map::$zzhzyydc_jydc_zhubr_score,
                Quantity_hzdc_gr_basic_score_map::$zzhzyydc_ybdc_xiebr_score,
                Quantity_hzdc_gr_basic_score_map::$zzhzyydc_ybdc_zhubr_score
            ]
        ),
        Quantity_hzdc_gr_sub_coef_map::$zzhzyydc_zxqz
    ])
];


class HZDC_group implements Table_group
{

    static function basicscore_update($mysqli, $param)
    {
        return (new Table(Quantity_hzdc_gr_basic_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_hzdc_gr_nbr_map::$table_name,
                    Quantity_hzdc_gr_basic_coef_map::$table_name
                ],
                HZDC_formula::$nbr_2_basicscore,
                $param
            );
    }

    static function subscore_update($mysqli, $param)
    {
        return (new Table(Quantity_hzdc_gr_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_hzdc_gr_basic_score_map::$table_name,
                    Quantity_hzdc_gr_sub_coef_map::$table_name
                ],
                HZDC_formula::$basic_2_sub,
                $param
            );
    }

    static function group_update($mysqli, $param)
    {

        return (new Table(Quantity_hzdc_gr_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_hzdc_gr_nbr_map::$table_name,
                    Quantity_hzdc_gr_basic_coef_map::$table_name,
                    Quantity_hzdc_gr_basic_score_map::$table_name,
                    Quantity_hzdc_gr_sub_coef_map::$table_name
                ],
                array_merge(HZDC_formula::$nbr_2_basicscore, HZDC_formula::$basic_2_sub),
                $param
            );


    }

    static function group_update_date_in($mysqli, $date_arr)
    {
        $param = SqlTool::WHERE([
                Quantity_hzdc_gr_sub_score_map::$number_id => Quantity_hzdc_gr_nbr_map::$number_id,
                Quantity_hzdc_gr_basic_score_map::$number_id => Quantity_hzdc_gr_nbr_map::$number_id
            ], false) .
            SqlTool::BETWEEN(Quantity_hzdc_gr_nbr_map::$year_month_show, $date_arr);

        return self::group_update($mysqli, $param);

    }

    static function group_update_by_id($mysqli, $number_id)
    {
        $param = SqlTool::WHERE([
                Quantity_hzdc_gr_sub_score_map::$number_id => Quantity_hzdc_gr_nbr_map::$number_id,
                Quantity_hzdc_gr_basic_score_map::$number_id => Quantity_hzdc_gr_nbr_map::$number_id
            ], false) .
            SqlTool::BETWEEN(Quantity_hzdc_gr_nbr_map::$number_id, $number_id);

        return self::group_update($mysqli, $param);
    }
}

