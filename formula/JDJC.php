<?php
/**
 * @author zhuangjiayu
 * User: zhuangjiayu
 * Date: 2018/1/24
 * Time: 22:11
 */


require_once __DIR__ . '/../map/Jiancha_and_jiangduo_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_dczghzyhwf_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_dczghzyhwf_gr_score.map.php';
require_once __DIR__ . '/../map/Quantity_dczghzyhwf_gr_basic_coef.map.php';

require_once __DIR__ . '/../map/Quantity_xflscf_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_xflscf_gr_basic_coef.map.php';
require_once __DIR__ . '/../map/Quantity_xflscf_gr_score.map.php';

require_once __DIR__ . '/../map/Quantity_fxhzyh_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_fxhzyh_gr_basic_coef.map.php';
require_once __DIR__ . '/../map/Quantity_fxhzyh_gr_score.map.php';

require_once __DIR__ . '/../map/Quantity_jcdw_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_jcdw_gr_basic_coef.map.php';
require_once __DIR__ . '/../map/Quantity_jcdw_gr_score.map.php';
require_once __DIR__ . '/../map/Quantity_jcdw_gr_sub_coef.map.php';


/**
 * 监督检查公式类
 * Class JDJC_formula
 */
class JDJC_formula extends Formula
{
    /**
     * @var array 敦促整改nbr表 => basic 计算公式
     */
    static $dczg_nbr_2_basic;
    /**
     * @var array 敦促整改basic表 => 该分项汇总 计算公式
     */
    static $dczg_basic_2_sub;

    /**
     * @var array 发现火灾nbr表 => basic 计算公式
     */
    static $fxhz_nbr_2_basic;
    /**
     * @var array 发现火灾basic表 => 该分项汇总 计算公式
     */
    static $fxhz_basic_2_sub;

    /**
     * @var array 检查单位nbr表 => basic 计算公式
     */
    static $jcdw_nbr_2_basic;
    /**
     * @var array 检查单位basic表 => 该分项汇总 计算公式
     */
    static $jcdw_basic_2_sub;

    /**
     * @var array 下发临时nbr表 => basic 计算公式
     */
    static $xfls_nbr_2_basic;
    /**
     * @var array 下发临时basic表 => 该分项汇总 计算公式
     */
    static $xfls_basic_2_sub;


    static $xfls_2_jcdc;
    static $fxhz_2_jcdc;
    static $dczg_2_jcdc;
    static $jcdw_2_jcdc;
}

//督促整改
JDJC_formula::$dczg_nbr_2_basic = Formula::plus([
    Formula::mul([
        Quantity_dczghzyhwf_gr_nbr_map::$dczghzyhwf_feizddw_xiebr,
        Quantity_dczghzyhwf_gr_basic_coef_map::$dczghzyhwf_feizddw_xiebr_xxqz
    ]),
    Formula::mul([
        Quantity_dczghzyhwf_gr_nbr_map::$dczghzyhwf_feizddw_zhubr,
        Quantity_dczghzyhwf_gr_basic_coef_map::$dczghzyhwf_feizddw_zhubr_xxqz
    ]),
    Formula::mul([
        Quantity_dczghzyhwf_gr_nbr_map::$dczghzyhwf_zddw_xiebr,
        Quantity_dczghzyhwf_gr_basic_coef_map::$dczghzyhwf_zddw_xiebr_xxqz
    ]),
    Formula::mul([
        Quantity_dczghzyhwf_gr_nbr_map::$dczghzyhwf_zddw_zhubr,
        Quantity_dczghzyhwf_gr_basic_coef_map::$dczghzyhwf_zddw_zhubr_xxqz
    ])
]);

JDJC_formula::$dczg_basic_2_sub = [
    Quantity_dczghzyhwf_gr_score_map::$dczghzyhwf_score =>
        JDJC_formula::$dczg_nbr_2_basic,
];

//发现火灾
JDJC_formula::$fxhz_nbr_2_basic = Formula::plus([
    Formula::mul([
        Quantity_fxhzyh_gr_nbr_map::$fxhzyh_feizddw_xiebr,
        Quantity_fxhzyh_gr_basic_coef_map::$fxhzyh_feizddw_xiebr_xxqz
    ]),
    Formula::mul([
        Quantity_fxhzyh_gr_nbr_map::$fxhzyh_feizddw_zhubr,
        Quantity_fxhzyh_gr_basic_coef_map::$fxhzyh_feizddw_zhubr_xxqz
    ]),
    Formula::mul([
        Quantity_fxhzyh_gr_nbr_map::$fxhzyh_zddw_xiebr,
        Quantity_fxhzyh_gr_basic_coef_map::$fxhzyh_zddw_xiebr_xxqz
    ]),
    Formula::mul([
        Quantity_fxhzyh_gr_nbr_map::$fxhzyh_zddw_zhubr,
        Quantity_fxhzyh_gr_basic_coef_map::$fxhzyh_zddw_zhubr_xxqz
    ])
]);

JDJC_formula::$fxhz_basic_2_sub = [
    Quantity_fxhzyh_gr_score_map::$fxhzyh_score =>
        JDJC_formula::$fxhz_nbr_2_basic,
];

//监督检查
JDJC_formula::$jcdw_basic_2_sub = [
    Quantity_jcdw_gr_score_map::$fc_jc_xxdf =>
        Formula::plus([
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$fc_jc_feizddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$fc_jc_feizddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$fc_jc_feizddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$fc_jc_feizddw_zhubr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$fc_jc_zddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$fc_jc_zddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$fc_jc_zddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$fc_jc_zddw_zhubr_xxqz
            ])
        ]),
    Quantity_jcdw_gr_score_map::$fc_jc_zxdf =>
        Formula::mul([
            Quantity_jcdw_gr_score_map::$fc_jc_xxdf,
            Quantity_jcdw_gr_sub_coef_map::$fc_jc_zxqz
        ]),

    Quantity_jcdw_gr_score_map::$qt_jc_xxdf =>
        Formula::plus([
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$qt_jc_feizddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$qt_jc_feizddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$qt_jc_feizddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$qt_jc_feizddw_zhubr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$qt_jc_zddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$qt_jc_zddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$qt_jc_zddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$qt_jc_zddw_zhubr_xxqz
            ])
        ]),
    Quantity_jcdw_gr_score_map::$qt_jc_zxdf =>
        Formula::mul([
            Quantity_jcdw_gr_score_map::$qt_jc_xxdf,
            Quantity_jcdw_gr_sub_coef_map::$qt_jc_zxqz
        ]),

    Quantity_jcdw_gr_score_map::$sggd_jc_xxdf =>
        Formula::plus([
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$sggd_jc_feizddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$sggd_jc_feizddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$sggd_jc_feizddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$sggd_jc_feizddw_zhubr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$sggd_jc_zddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$sggd_jc_zddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$sggd_jc_zddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$sggd_jc_zddw_zhubr_xxqz
            ])
        ]),
    Quantity_jcdw_gr_score_map::$sggd_jc_zxdf =>
        Formula::mul([
            Quantity_jcdw_gr_score_map::$sggd_jc_xxdf,
            Quantity_jcdw_gr_sub_coef_map::$sggd_jc_zxqz
        ]),

    Quantity_jcdw_gr_score_map::$jbts_jc_xxdf =>
        Formula::plus([
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$jbts_jc_feizddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$jbts_jc_feizddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$jbts_jc_feizddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$jbts_jc_feizddw_zhubr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$jbts_jc_zddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$jbts_jc_zddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$jbts_jc_zddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$jbts_jc_zddw_zhubr_xxqz
            ])
        ]),
    Quantity_jcdw_gr_score_map::$jbts_jc_zxdf =>
        Formula::mul([
            Quantity_jcdw_gr_score_map::$jbts_jc_xxdf,
            Quantity_jcdw_gr_sub_coef_map::$jbts_jc_zxqz
        ]),

    Quantity_jcdw_gr_score_map::$jbq_aqjc_xxdf =>
        Formula::plus([
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$jbq_aqjc_feizddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$jbq_aqjc_feizddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$jbq_aqjc_feizddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$jbq_aqjc_feizddw_zhubr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$jbq_aqjc_zddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$jbq_aqjc_zddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$jbq_aqjc_zddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$jbq_aqjc_zddw_zhubr_xxqz
            ])
        ]),
    Quantity_jcdw_gr_score_map::$jbq_aqjc_zxdf =>
        Formula::mul([
            Quantity_jcdw_gr_score_map::$jbq_aqjc_xxdf,
            Quantity_jcdw_gr_sub_coef_map::$jbq_aqjc_zxqz
        ]),

    Quantity_jcdw_gr_score_map::$yyq_aqjc_xxdf =>
        Formula::plus([
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$yyq_aqjc_feizddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$yyq_aqjc_feizddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$yyq_aqjc_feizddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$yyq_aqjc_feizddw_zhubr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$yyq_aqjc_zddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$yyq_aqjc_zddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$yyq_aqjc_zddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$yyq_aqjc_zddw_zhubr_xxqz
            ])
        ]),
    Quantity_jcdw_gr_score_map::$yyq_aqjc_zxdf =>
        Formula::mul([
            Quantity_jcdw_gr_score_map::$yyq_aqjc_xxdf,
            Quantity_jcdw_gr_sub_coef_map::$yyq_aqjc_zxqz
        ]),

    Quantity_jcdw_gr_score_map::$rcjdjc_xxdf =>
        Formula::plus([
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$rcjdjc_feizddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$rcjdjc_feizddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$rcjdjc_feizddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$rcjdjc_feizddw_zhubr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$rcjdjc_zddw_xiebr,
                Quantity_jcdw_gr_basic_coef_map::$rcjdjc_zddw_xiebr_xxqz
            ]),
            Formula::plus([
                Quantity_jcdw_gr_nbr_map::$rcjdjc_zddw_zhubr,
                Quantity_jcdw_gr_basic_coef_map::$rcjdjc_zddw_zhubr_xxqz
            ])
        ]),
    Quantity_jcdw_gr_score_map::$rcjdjc_zxdf =>
        Formula::mul([
            Quantity_jcdw_gr_score_map::$rcjdjc_xxdf,
            Quantity_jcdw_gr_sub_coef_map::$rcjdjc_zxqz
        ]),
    Quantity_jcdw_gr_score_map::$jcdw_tol_score => Formula::plus([
        Quantity_jcdw_gr_score_map::$rcjdjc_zxdf,
        Quantity_jcdw_gr_score_map::$yyq_aqjc_zxdf,
        Quantity_jcdw_gr_score_map::$jbq_aqjc_zxdf,
        Quantity_jcdw_gr_score_map::$jbts_jc_zxdf,
        Quantity_jcdw_gr_score_map::$sggd_jc_zxdf,
        Quantity_jcdw_gr_score_map::$qt_jc_zxdf,
        Quantity_jcdw_gr_score_map::$fc_jc_zxdf
    ])
];

//下发临时查封
JDJC_formula::$xfls_nbr_2_basic = Formula::plus([
    Formula::mul([
        Quantity_xflscf_gr_nbr_map::$xflscf_feizddw_xiebr,
        Quantity_xflscf_gr_basic_coef_map::$xflscf_feizddw_xiebr_xxqz
    ]),
    Formula::mul([
        Quantity_xflscf_gr_nbr_map::$xflscf_feizddw_zhubr,
        Quantity_xflscf_gr_basic_coef_map::$xflscf_feizddw_zhubr_xxqz
    ]),
    Formula::mul([
        Quantity_xflscf_gr_nbr_map::$xflscf_zddw_xiebr,
        Quantity_xflscf_gr_basic_coef_map::$xflscf_zddw_xiebr_xxqz
    ]),
    Formula::mul([
        Quantity_xflscf_gr_nbr_map::$xflscf_zddw_zhubr,
        Quantity_xflscf_gr_basic_coef_map::$xflscf_zddw_zhubr_xxqz
    ])
]);

JDJC_formula::$xfls_basic_2_sub = [
    Quantity_xflscf_gr_score_map::$xflscf_score =>
        JDJC_formula::$xfls_nbr_2_basic,
];


JDJC_formula::$dczg_2_jcdc = [
    Jiancha_and_jiangduo_gr_nbr_map::$police_name =>
        Quantity_dczghzyhwf_gr_score_map::$police_name,
    Jiancha_and_jiangduo_gr_nbr_map::$dd_name =>
        Quantity_dczghzyhwf_gr_score_map::$dadui_name,
    Jiancha_and_jiangduo_gr_nbr_map::$year_month_show =>
        Quantity_dczghzyhwf_gr_score_map::$year_month_show,
    Jiancha_and_jiangduo_gr_nbr_map::$DCZGHZYHS_DF =>
        Quantity_dczghzyhwf_gr_score_map::$dczghzyhwf_score
];

JDJC_formula::$fxhz_2_jcdc = [
    Jiancha_and_jiangduo_gr_nbr_map::$police_name =>
        Quantity_fxhzyh_gr_score_map::$police_name,
    Jiancha_and_jiangduo_gr_nbr_map::$dd_name =>
        Quantity_fxhzyh_gr_score_map::$dadui_name,
    Jiancha_and_jiangduo_gr_nbr_map::$year_month_show =>
        Quantity_fxhzyh_gr_score_map::$year_month_show,
    Jiancha_and_jiangduo_gr_nbr_map::$FXHZYHWFXWS_DF =>
        Quantity_fxhzyh_gr_score_map::$fxhzyh_score
];

JDJC_formula::$xfls_2_jcdc = [
    Jiancha_and_jiangduo_gr_nbr_map::$police_name =>
        Quantity_xflscf_gr_score_map::$police_name,
    Jiancha_and_jiangduo_gr_nbr_map::$dd_name =>
        Quantity_xflscf_gr_score_map::$dadui_name,
    Jiancha_and_jiangduo_gr_nbr_map::$year_month_show =>
        Quantity_xflscf_gr_score_map::$year_month_show,
    Jiancha_and_jiangduo_gr_nbr_map::$XFLSCFJDSS_DF =>
        Quantity_xflscf_gr_score_map::$xflscf_score
];

JDJC_formula::$jcdw_2_jcdc = [
    Jiancha_and_jiangduo_gr_nbr_map::$police_name =>
        Quantity_jcdw_gr_score_map::$police_name,
    Jiancha_and_jiangduo_gr_nbr_map::$dd_name =>
        Quantity_jcdw_gr_score_map::$dd_name,
    Jiancha_and_jiangduo_gr_nbr_map::$year_month_show =>
        Quantity_jcdw_gr_score_map::$year_month_show,
    Jiancha_and_jiangduo_gr_nbr_map::$JCDWS_DF =>
        Quantity_jcdw_gr_score_map::$jcdw_tol_score
];


/**
 * 监督检查表格组管理类
 * Class JDJC_group
 */
class JDJC_group extends Table_group
{

    /**
     * 判断监督检查总表该人该日是否存在数据
     * @param mysqli|SqlTool $db
     * @param string $name
     * @param string $date
     * @return bool
     */
    public static function is_row_ext($db, $name, $date)
    {
        return parent::is_row_ext(
            $db, Jiancha_and_jiangduo_gr_nbr_map::$table_name, $name, $date
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function dczg_sub_update($mysqli, $param)
    {
        if (!$param || $param == '') die("更新必须提供有效参数");

        return (new Table(Quantity_dczghzyhwf_gr_score_map::$table_name,
            SqlTool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_dczghzyhwf_gr_basic_coef_map::$table_name,
                    Quantity_dczghzyhwf_gr_nbr_map::$table_name,
                ],
                JDJC_formula::$dczg_basic_2_sub,
                $param
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function fxhz_sub_update($mysqli, $param)
    {
        if (!$param || $param == '') die("更新必须提供有效参数");

        return (new Table(Quantity_fxhzyh_gr_score_map::$table_name,
            SqlTool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_fxhzyh_gr_basic_coef_map::$table_name,
                    Quantity_fxhzyh_gr_nbr_map::$table_name,
                ],
                JDJC_formula::$fxhz_basic_2_sub,
                $param
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function xfls_sub_update($mysqli, $param)
    {
        if (!$param || $param == '') die("更新必须提供有效参数");

        return (new Table(Quantity_xflscf_gr_score_map::$table_name,
            SqlTool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_xflscf_gr_basic_coef_map::$table_name,
                    Quantity_xflscf_gr_nbr_map::$table_name,
                ],
                JDJC_formula::$xfls_basic_2_sub,
                $param
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function jcdw_sub_update($mysqli, $param)
    {
        if (!$param || $param == '') die("更新必须提供有效参数");
        return (new Table(Quantity_jcdw_gr_score_map::$table_name,
            SqlTool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_jcdw_gr_basic_coef_map::$table_name,
                    Quantity_jcdw_gr_nbr_map::$table_name,
                ],
                JDJC_formula::$jcdw_basic_2_sub,
                $param
            );
    }

    /**
     * @param mysqli $mysqli
     * @param int $id
     * @param string $other_param
     * @return int
     */
    public static function dczg_sub_update_by_id($mysqli, $id, $other_param = '')
    {
        return self::dczg_sub_update(
            $mysqli,
            SqlTool::WHERE([
                Quantity_dczghzyhwf_gr_score_map::$number_id
                => Quantity_dczghzyhwf_gr_nbr_map::$number_id,
                Quantity_dczghzyhwf_gr_nbr_map::$number_id => $id
            ], false) . $other_param
        );
    }

    /**
     * @param mysqli $mysqli
     * @param int $id
     * @param string $other_param
     * @return int
     */
    public static function fxhz_sub_update_by_id($mysqli, $id, $other_param = '')
    {
        return self::fxhz_sub_update(
            $mysqli,
            SqlTool::WHERE([
                Quantity_fxhzyh_gr_score_map::$number_id
                => Quantity_fxhzyh_gr_nbr_map::$number_id,
                Quantity_fxhzyh_gr_nbr_map::$number_id => $id
            ], false) . $other_param
        );
    }

    /**
     * @param mysqli $mysqli
     * @param int $id
     * @param string $other_param
     * @return int
     */
    public static function xfls_sub_update_by_id($mysqli, $id, $other_param = '')
    {
        return self::xfls_sub_update(
            $mysqli,
            SqlTool::WHERE([
                Quantity_xflscf_gr_score_map::$number_id
                => Quantity_xflscf_gr_nbr_map::$number_id,
                Quantity_xflscf_gr_nbr_map::$number_id => $id
            ], false) . $other_param
        );
    }

    /**
     * @param mysqli $mysqli
     * @param int $id
     * @param string $other_param
     * @return int
     */
    public static function jcdw_sub_update_by_id($mysqli, $id, $other_param = '')
    {
        return self::jcdw_sub_update(
            $mysqli,
            SqlTool::WHERE([
                Quantity_jcdw_gr_score_map::$number_id
                => Quantity_jcdw_gr_nbr_map::$number_id,
                Quantity_jcdw_gr_nbr_map::$number_id => $id
            ], false) . $other_param
        );
    }

    /**
     * @param mysqli $mysqli
     * @param $date_arr
     * @param string $other_param
     * @return int
     * @internal param int $id
     */
    public static function dczg_sub_update_date_in($mysqli, $date_arr, $other_param = '')
    {
        return self::dczg_sub_update(
            $mysqli,
            SqlTool::WHERE([
                Quantity_dczghzyhwf_gr_score_map::$number_id
                => Quantity_dczghzyhwf_gr_nbr_map::$number_id
            ], false) .
            SqlTool::BETWEEN(
                Quantity_dczghzyhwf_gr_nbr_map::$year_month_show,
                $date_arr
            )
            . $other_param
        );
    }

    /**
     * @param mysqli $mysqli
     * @param $date_arr
     * @param string $other_param
     * @return int
     * @internal param int $id
     */
    public static function fxhz_sub_update_date_in($mysqli, $date_arr, $other_param = '')
    {
        return self::fxhz_sub_update(
            $mysqli,
            SqlTool::WHERE([
                Quantity_fxhzyh_gr_score_map::$number_id
                => Quantity_fxhzyh_gr_nbr_map::$number_id
            ], false) .
            SqlTool::BETWEEN(
                Quantity_fxhzyh_gr_nbr_map::$year_month_show,
                $date_arr
            ) . $other_param
        );
    }

    /**
     * @param mysqli $mysqli
     * @param $date_arr
     * @param string $other_param
     * @return int
     * @internal param int $id
     */
    public static function xfls_sub_update_date_in($mysqli, $date_arr, $other_param = '')
    {
        return self::xfls_sub_update(
            $mysqli,
            SqlTool::WHERE([
                Quantity_xflscf_gr_score_map::$number_id
                => Quantity_xflscf_gr_nbr_map::$number_id
            ], false) .
            SqlTool::BETWEEN(
                Quantity_xflscf_gr_nbr_map::$year_month_show,
                $date_arr
            ) . $other_param
        );
    }

    /**
     * @param mysqli $mysqli
     * @param $date_arr
     * @param string $other_param
     * @return int
     * @internal param int $id
     */
    public static function jcdw_sub_update_date_in($mysqli, $date_arr, $other_param = '')
    {
        return self::jcdw_sub_update(
            $mysqli,
            SqlTool::WHERE([
                Quantity_jcdw_gr_score_map::$number_id
                => Quantity_jcdw_gr_nbr_map::$number_id
            ], false) .
            SqlTool::BETWEEN(
                Quantity_jcdw_gr_nbr_map::$year_month_show,
                $date_arr
            ) . $other_param
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function jdjc_insert_jcdw($mysqli, $param = '')
    {
        return (new Table(Jiancha_and_jiangduo_gr_nbr_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_jcdw_gr_score_map::$table_name
                ],
                JDJC_formula::$jcdw_2_jcdc,
                $param . SqlTool::GROUP([
                    Quantity_jcdw_gr_score_map::$year_month_show,
                    Quantity_jcdw_gr_score_map::$police_name
                ])
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    public static function jdjc_insert_jcdw_item($mysqli, $police_name, $date)
    {
        return self::jdjc_insert_jcdw(
            $mysqli,
//            SqlTool::WHERE([
//                Quantity_jcdw_gr_score_map::$year_month_show => $date,
//                Quantity_jcdw_gr_score_map::$police_name => $police_name
//            ])
            parent::format_date(Quantity_jcdw_gr_score_map::$year_month_show, $date)
            . SqlTool::ANDC([Quantity_jcdw_gr_score_map::$police_name => $police_name])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    public static function jdjc_update_jcdw_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = SqlTool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::jdjc_insert_jcdw_item($db, $police_name, $date);
            }
        }
        return (new Table(Jiancha_and_jiangduo_gr_nbr_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Quantity_jcdw_gr_score_map::$jcdw_tol_score . "),0) AS res , police_name,year_month_show FROM " . Quantity_jcdw_gr_score_map::$table_name .
                    SqlTool::WHERE([
                        Quantity_jcdw_gr_score_map::$year_month_show => $date,
                        Quantity_jcdw_gr_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jiancha_and_jiangduo_gr_nbr_map::$JCDWS_DF => 'A.res'
                ],
                SqlTool::WHERE([
                    Jiancha_and_jiangduo_gr_nbr_map::$year_month_show => 'A.year_month_show',
                    Jiancha_and_jiangduo_gr_nbr_map::$police_name => 'A.police_name'
                ], true)
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function jdjc_insert_fxhz($mysqli, $param = '')
    {
        return (new Table(Jiancha_and_jiangduo_gr_nbr_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_fxhzyh_gr_score_map::$table_name
                ],
                JDJC_formula::$fxhz_2_jcdc,
                $param . SqlTool::GROUP([
                    Quantity_fxhzyh_gr_score_map::$year_month_show,
                    Quantity_fxhzyh_gr_score_map::$police_name
                ])
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    public static function jdjc_insert_fxhz_item($mysqli, $police_name, $date)
    {
        return self::jdjc_insert_jcdw(
            $mysqli,
//            SqlTool::WHERE([
//                Quantity_jcdw_gr_score_map::$year_month_show => $date,
//                Quantity_jcdw_gr_score_map::$police_name => $police_name
//            ])
            parent::format_date(Quantity_fxhzyh_gr_score_map::$year_month_show, $date)
            . SqlTool::ANDC([Quantity_fxhzyh_gr_score_map::$police_name => $police_name])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    public static function jdjc_update_fxhz_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = SqlTool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::jdjc_insert_fxhz_item($db, $police_name, $date);
            }
        }
        return (new Table(Jiancha_and_jiangduo_gr_nbr_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Quantity_fxhzyh_gr_score_map::$fxhzyh_score . "),0) AS res , police_name,year_month_show FROM " . Quantity_fxhzyh_gr_score_map::$table_name .
                    SqlTool::WHERE([
                        Quantity_fxhzyh_gr_score_map::$year_month_show => $date,
                        Quantity_fxhzyh_gr_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jiancha_and_jiangduo_gr_nbr_map::$FXHZYHWFXWS_DF => 'A.res'
                ],
                SqlTool::WHERE([
                    Jiancha_and_jiangduo_gr_nbr_map::$year_month_show => $date,
                    Jiancha_and_jiangduo_gr_nbr_map::$police_name => $police_name
                ], true)
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function jdjc_insert_xfls($mysqli, $param = '')
    {
        return (new Table(Jiancha_and_jiangduo_gr_nbr_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xflscf_gr_score_map::$table_name
                ],
                JDJC_formula::$xfls_2_jcdc,
                $param . SqlTool::GROUP([
                    Quantity_xflscf_gr_score_map::$year_month_show,
                    Quantity_xflscf_gr_score_map::$police_name
                ])
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    public static function jdjc_insert_xfls_item($mysqli, $police_name, $date)
    {
        return self::jdjc_insert_xfls(
            $mysqli,
//            SqlTool::WHERE([
//                Quantity_xflscf_gr_score_map::$year_month_show => $date,
//                Quantity_xflscf_gr_score_map::$police_name => $police_name
//            ])
            parent::format_date(Quantity_xflscf_gr_score_map::$year_month_show, $date)
            . SqlTool::ANDC([Quantity_xflscf_gr_score_map::$police_name => $police_name])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    public static function jdjc_update_xfls_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = SqlTool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::jdjc_insert_xfls_item($db, $police_name, $date);
            }
        }
        return (new Table(Jiancha_and_jiangduo_gr_nbr_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Quantity_xflscf_gr_score_map::$xflscf_score . "),0) AS res , police_name,year_month_show FROM " . Quantity_xflscf_gr_score_map::$table_name .
                    SqlTool::WHERE([
                        Quantity_xflscf_gr_score_map::$year_month_show => $date,
                        Quantity_xflscf_gr_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jiancha_and_jiangduo_gr_nbr_map::$XFLSCFJDSS_DF => 'A.res'
                ],
                SqlTool::WHERE([
                    Jiancha_and_jiangduo_gr_nbr_map::$year_month_show => $date,
                    Jiancha_and_jiangduo_gr_nbr_map::$police_name => $police_name
                ], true)
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function jdjc_insert_dczg($mysqli, $param = '')

    {
        return (new Table(Jiancha_and_jiangduo_gr_nbr_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_dczghzyhwf_gr_score_map::$table_name
                ],
                JDJC_formula::$dczg_2_jcdc,
                $param . SqlTool::GROUP([
                    Quantity_dczghzyhwf_gr_score_map::$year_month_show,
                    Quantity_dczghzyhwf_gr_score_map::$police_name
                ])
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    public static function jdjc_insert_dczg_item($mysqli, $police_name, $date)
    {
        return self::jdjc_insert_dczg(
            $mysqli,
//            SqlTool::WHERE([
//                Quantity_dczghzyhwf_gr_score_map::$year_month_show => $date,
//                Quantity_dczghzyhwf_gr_score_map::$police_name => $police_name
//            ])
            parent::format_date(Quantity_dczghzyhwf_gr_score_map::$year_month_show, $date)
            . SqlTool::ANDC([Quantity_dczghzyhwf_gr_score_map::$police_name => $police_name])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    public static function jdjc_update_dczg_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = SqlTool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::jdjc_insert_xfls_item($db, $police_name, $date);
            }
        }
        return (new Table(Jiancha_and_jiangduo_gr_nbr_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Quantity_dczghzyhwf_gr_score_map::$dczghzyhwf_score . "),0) 
                    AS res , police_name,year_month_show FROM " .
                    Quantity_dczghzyhwf_gr_score_map::$table_name .
                    SqlTool::WHERE([
                        Quantity_dczghzyhwf_gr_score_map::$year_month_show => $date,
                        Quantity_dczghzyhwf_gr_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jiancha_and_jiangduo_gr_nbr_map::$DCZGHZYHS_DF => 'A.res'
                ],
                SqlTool::WHERE([
                    Jiancha_and_jiangduo_gr_nbr_map::$year_month_show => $date,
                    Jiancha_and_jiangduo_gr_nbr_map::$police_name => $police_name
                ], true)
            );
    }

    /**
     * @param mysqli|SqlTool $db
     * @param null|string|array $date
     */
    public static function jdjc_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [new Table(Jiancha_and_jiangduo_gr_nbr_map::$table_name, $sqlTool)];

        if (!$date) {
            array_push($tables, new Table(Jiancha_and_jiangduo_gr_score_map::$table_name, $sqlTool));
        }

        parent::group_clear(
            $tables,
            Jiancha_and_jiangduo_gr_nbr_map::$year_month_show,
            $date
        );
    }

    /**
     * @param mysqli $mysqli
     * @param array|null|string $date
     */
    public
    static function group_insert($mysqli, $date = null)
    {

        $sqlTool = SqlTool::build_by_mysqli($mysqli);

        self::jdjc_clear($sqlTool, $date);

        self::jdjc_insert_jcdw($mysqli, parent::format_date(
            Jiancha_and_jiangduo_gr_score_map::$year_month_show,
            $date
        ));
        $xfls = new Table(Quantity_xflscf_gr_score_map::$table_name, $sqlTool);
        $dczg = new Table(Quantity_dczghzyhwf_gr_score_map::$table_name, $sqlTool);
        $fxhz = new Table(Quantity_fxhzyh_gr_score_map::$table_name, $sqlTool);


        $res = $dczg->group_query(
            [
                Quantity_dczghzyhwf_gr_score_map::$police_name => 'n',
                Quantity_dczghzyhwf_gr_score_map::$year_month_show => 'd',
            ], [
            Quantity_dczghzyhwf_gr_score_map::$year_month_show,
            Quantity_dczghzyhwf_gr_score_map::$police_name
        ],
            parent::format_date(Quantity_dczghzyhwf_gr_score_map::$year_month_show, $date)
        );

        $res->each_row(function ($row) use ($mysqli) {
            self::jdjc_update_dczg_item($mysqli, $row['n'], $row['d'], true);
        });

        $res = $xfls->group_query(
            [
                Quantity_xflscf_gr_score_map::$police_name => 'n',
                Quantity_xflscf_gr_score_map::$year_month_show => 'd',
            ], [
            Quantity_xflscf_gr_score_map::$year_month_show,
            Quantity_xflscf_gr_score_map::$police_name
        ],
            parent::format_date(Quantity_xflscf_gr_score_map::$year_month_show, $date)
        );

        $res->each_row(function ($row) use ($mysqli) {
            self::jdjc_update_xfls_item($mysqli, $row['n'], $row['d'], true);
        });


        $res = $fxhz->group_query(
            [
                Quantity_fxhzyh_gr_score_map::$police_name => 'n',
                Quantity_fxhzyh_gr_score_map::$year_month_show => 'd',
            ], [
            Quantity_fxhzyh_gr_score_map::$year_month_show,
            Quantity_fxhzyh_gr_score_map::$police_name
        ],
            parent::format_date(Quantity_fxhzyh_gr_score_map::$year_month_show, $date)
        );

        $res->each_row(function ($row) use ($mysqli) {
            self::jdjc_update_fxhz_item($mysqli, $row['n'], $row['d'], true);
        });


    }
}
