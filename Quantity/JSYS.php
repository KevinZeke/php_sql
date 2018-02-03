<?php
/**
 * User: zhuangjiayu
 * @author: zhuangjiayu
 * Date: 2018/1/21
 * Time: 17:14
 */

require_once __DIR__ . '/Formula.class.php';
require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/Table_gropu.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../map/Jianshenyanshou_sub_score.map.php';
require_once __DIR__ . '/../map/Jianshenyanshou_gr_score.map.php';
require_once __DIR__ . '/../map/Jianshenyanshou_gr_coef.map.php';
require_once __DIR__ . '/../map/Quantity_xfjgys_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_xfjgys_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfjgys_gr_basic_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfjgys_gr_basic_coef.map.php';
require_once __DIR__ . '/../map/Quantity_xfjgys_gr_sub_coef.map.php';

require_once __DIR__ . '/../map/Quantity_xfyss_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_xfyss_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfyss_gr_basic_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfyss_gr_basic_coef.map.php';
require_once __DIR__ . '/../map/Quantity_xfyss_gr_sub_coef.map.php';

require_once __DIR__ . '/../map/Quantity_xfsjbas_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_xfsjbas_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfsjbas_gr_basic_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfsjbas_gr_basic_coef.map.php';
require_once __DIR__ . '/../map/Quantity_xfsjbas_gr_sub_coef.map.php';

require_once __DIR__ . '/../map/Quantity_xfsjshs_gr_nbr.map.php';
require_once __DIR__ . '/../map/Quantity_xfsjshs_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfsjshs_gr_basic_coef.map.php';
require_once __DIR__ . '/../map/Quantity_xfsjshs_gr_basic_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfsjshs_gr_sub_coef.map.php';


class JSYS_formula extends Formula
{

    /**
     * @var array 竣工nbr表 => 竣工basic表 计算公式
     */
    static $jg_nbr_2_basic;
    /**
     * @var array 竣工basic表 => 竣工sub表 计算公式
     */
    static $jg_basic_2_sub;

    /**
     * @var array 审核nbr表 => 审核basic表 计算公式
     */
    static $sh_nbr_2_basic;
    /**
     * @var array 审核basic表 => 审核sub表 计算公式
     */
    static $sh_basic_2_sub;

    /**
     * @var array 验收nbr表 => 验收basic表 计算公式
     */
    static $ys_nbr_2_basic;
    /**
     * @var array 验收basic表 => 验收sub表 计算公式
     */
    static $ys_basic_2_sub;

    /**
     * @var array 备案nbr表 => 备案basic表 计算公式
     */
    static $ba_nbr_2_basic;
    /**
     * @var array 备案basic表 => 备案sub表 计算公式
     */
    static $ba_basic_2_sub;

    /**
     * @var array 字段对照：竣工 => 建审总表sub
     */
    static $jg_2_sub;
    /**
     * @var array 字段对照：备案 => 建审总表sub
     */
    static $ba_2_sub;
    /**
     * @var array 字段对照：验收 => 备案总表sub
     */
    static $ys_2_sub;
    /**
     * @var array 字段对照：审核 => 验收总表sub
     */
    static $sh_2_sub;

    /**
     * @var array
     */
    static $jsys_sub_2_gr;
}

JSYS_formula::$jg_nbr_2_basic = [
    Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_qtdw_xiebr_score => Formula::mul([
        Quantity_xfjgys_gr_nbr_map::$jsysbabuhg_qtdw_xiebr,
        Quantity_xfjgys_gr_basic_coef_map::$jsysbabuhg_qtdw_xiebr_xxqz
    ]),
    Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_qtdw_zhubr_score => Formula::mul([
        Quantity_xfjgys_gr_nbr_map::$jsysbabuhg_qtdw_zhubr,
        Quantity_xfjgys_gr_basic_coef_map::$jsysbabuhg_qtdw_zhubr_xxqz
    ]),
    Quantity_xfjgys_gr_basic_score_map::$jsysbahg_qtdw_xiebr_score => Formula::mul([
        Quantity_xfjgys_gr_nbr_map::$jsysbahg_qtdw_xiebr,
        Quantity_xfjgys_gr_basic_coef_map::$jsysbahg_qtdw_xiebr_xxqz
    ]),
    Quantity_xfjgys_gr_basic_score_map::$jsysbahg_qtdw_zhubr_score => Formula::mul([
        Quantity_xfjgys_gr_nbr_map::$jsysbahg_qtdw_zhubr,
        Quantity_xfjgys_gr_basic_coef_map::$jsysbabuhg_qtdw_zhubr_xxqz
    ]),


    Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_zddw_xiebr_score => Formula::mul([
        Quantity_xfjgys_gr_nbr_map::$jsysbabuhg_zddw_xiebr,
        Quantity_xfjgys_gr_basic_coef_map::$jsysbabuhg_zddw_xiebr_xxqz
    ]),
    Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_zddw_zhubr_score => Formula::mul([
        Quantity_xfjgys_gr_nbr_map::$jsysbabuhg_zddw_zhubr,
        Quantity_xfjgys_gr_basic_coef_map::$jsysbabuhg_zddw_zhubr_xxqz
    ]),
    Quantity_xfjgys_gr_basic_score_map::$jsysbahg_zddw_xiebr_score => Formula::mul([
        Quantity_xfjgys_gr_nbr_map::$jsysbahg_zddw_xiebr,
        Quantity_xfjgys_gr_basic_coef_map::$jsysbahg_zddw_xiebr_xxqz
    ]),
    Quantity_xfjgys_gr_basic_score_map::$jsysbahg_zddw_zhubr_score => Formula::mul([
        Quantity_xfjgys_gr_nbr_map::$jsysbahg_zddw_zhubr,
        Quantity_xfjgys_gr_basic_coef_map::$jsysbabuhg_zddw_zhubr_xxqz
    ])

];

JSYS_formula::$jg_basic_2_sub = [
    Quantity_xfjgys_gr_sub_score_map::$jgysbabuhg_sub_score => Formula::mul([

        Formula::plus([
            JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_qtdw_xiebr_score],
            JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_qtdw_zhubr_score],
            JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_zddw_xiebr_score],
            JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_zddw_zhubr_score],
        ]),

        Quantity_xfjgys_gr_sub_coef_map::$jgysbabuhg_zxqz

    ]),
    Quantity_xfjgys_gr_sub_score_map::$jgysbahg_sub_score => Formula::mul([

        Formula::plus([
            JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbahg_qtdw_xiebr_score],
            JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbahg_qtdw_zhubr_score],
            JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbahg_zddw_xiebr_score],
            JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbahg_zddw_zhubr_score],
        ]),

        Quantity_xfjgys_gr_sub_coef_map::$jgysbahg_zxqz

    ]),
    Quantity_xfjgys_gr_sub_score_map::$jgysbacc_total_score => Formula::plus([
        Formula::mul([

            Formula::plus([
                JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbahg_qtdw_xiebr_score],
                JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbahg_qtdw_zhubr_score],
                JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbahg_zddw_xiebr_score],
                JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbahg_zddw_zhubr_score],
            ]),

            Quantity_xfjgys_gr_sub_coef_map::$jgysbahg_zxqz

        ]),
        Formula::mul([

            Formula::plus([
                JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_qtdw_xiebr_score],
                JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_qtdw_zhubr_score],
                JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_zddw_xiebr_score],
                JSYS_formula::$jg_nbr_2_basic[Quantity_xfjgys_gr_basic_score_map::$jsysbabuhg_zddw_zhubr_score],
            ]),

            Quantity_xfjgys_gr_sub_coef_map::$jgysbabuhg_zxqz

        ])
    ])
];


JSYS_formula::$sh_nbr_2_basic = [
    Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_qtdw_xiebr_score => Formula::mul([
        Quantity_xfsjshs_gr_nbr_map::$sjshbuhg_qtdw_xiebr,
        Quantity_xfsjshs_gr_basic_coef_map::$sjshbuhg_qtdw_xiebr_xxqz
    ]),
    Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_qtdw_zhubr_score => Formula::mul([
        Quantity_xfsjshs_gr_nbr_map::$sjshbuhg_qtdw_zhubr,
        Quantity_xfsjshs_gr_basic_coef_map::$sjshbuhg_qtdw_zhubr_xxqz
    ]),
    Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_zddw_xiebr_score => Formula::mul([
        Quantity_xfsjshs_gr_nbr_map::$sjshbuhg_zddw_xiebr,
        Quantity_xfsjshs_gr_basic_coef_map::$sjshbuhg_zddw_xiebr_xxqz
    ]),
    Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_zddw_zhubr_score => Formula::mul([
        Quantity_xfsjshs_gr_nbr_map::$sjshbuhg_zddw_zhubr,
        Quantity_xfsjshs_gr_basic_coef_map::$sjshbuhg_zddw_zhubr_xxqz
    ]),


    Quantity_xfsjshs_gr_basic_score_map::$sjshhg_qtdw_xiebr_score => Formula::mul([
        Quantity_xfsjshs_gr_nbr_map::$sjshhg_qtdw_xiebr,
        Quantity_xfsjshs_gr_basic_coef_map::$sjshhg_qtdw_xiebr_xxqz
    ]),
    Quantity_xfsjshs_gr_basic_score_map::$sjshhg_qtdw_zhubr_score => Formula::mul([
        Quantity_xfsjshs_gr_nbr_map::$sjshhg_qtdw_zhubr,
        Quantity_xfsjshs_gr_basic_coef_map::$sjshhg_qtdw_zhubr_xxqz
    ]),
    Quantity_xfsjshs_gr_basic_score_map::$sjshhg_zddw_xiebr_score => Formula::mul([
        Quantity_xfsjshs_gr_nbr_map::$sjshhg_zddw_xiebr,
        Quantity_xfsjshs_gr_basic_coef_map::$sjshhg_zddw_xiebr_xxqz
    ]),
    Quantity_xfsjshs_gr_basic_score_map::$sjshhg_zddw_zhubr_score => Formula::mul([
        Quantity_xfsjshs_gr_nbr_map::$sjshhg_zddw_zhubr,
        Quantity_xfsjshs_gr_basic_coef_map::$sjshhg_zddw_zhubr_xxqz
    ])

];

JSYS_formula::$sh_basic_2_sub = [
    Quantity_xfsjshs_gr_sub_score_map::$sjshbuhg_sub_score => Formula::mul([

        Formula::plus([
            JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_qtdw_xiebr_score],
            JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_qtdw_zhubr_score],
            JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_zddw_xiebr_score],
            JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_zddw_zhubr_score],
        ]),

        Quantity_xfsjshs_gr_sub_coef_map::$sjshbuhg_zxqz

    ]),
    Quantity_xfsjshs_gr_sub_score_map::$sjshhg_sub_score => Formula::mul([

        Formula::plus([
            JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshhg_qtdw_xiebr_score],
            JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshhg_qtdw_zhubr_score],
            JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshhg_zddw_xiebr_score],
            JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshhg_zddw_zhubr_score],
        ]),

        Quantity_xfsjshs_gr_sub_coef_map::$sjshhg_zxqz

    ]),
    Quantity_xfsjshs_gr_sub_score_map::$sjshs_total_score => Formula::plus([
        Formula::mul([

            Formula::plus([
                JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshhg_qtdw_xiebr_score],
                JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshhg_qtdw_zhubr_score],
                JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshhg_zddw_xiebr_score],
                JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshhg_zddw_zhubr_score],
            ]),

            Quantity_xfsjshs_gr_sub_coef_map::$sjshhg_zxqz

        ]),
        Formula::mul([

            Formula::plus([
                JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_qtdw_xiebr_score],
                JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_qtdw_zhubr_score],
                JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_zddw_xiebr_score],
                JSYS_formula::$sh_nbr_2_basic[Quantity_xfsjshs_gr_basic_score_map::$sjshbuhg_zddw_zhubr_score],
            ]),

            Quantity_xfsjshs_gr_sub_coef_map::$sjshbuhg_zxqz

        ])
    ])
];


JSYS_formula::$ba_nbr_2_basic = [
    Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_qtdw_xiebr_score => Formula::mul([
        Quantity_xfsjbas_gr_nbr_map::$sjbaccbuhg_qtdw_xiebr,
        Quantity_xfsjbas_gr_basic_coef_map::$sjbaccbuhg_qtdw_xiebr_xxqz
    ]),
    Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_qtdw_zhubr_score => Formula::mul([
        Quantity_xfsjbas_gr_nbr_map::$sjbaccbuhg_qtdw_zhubr,
        Quantity_xfsjbas_gr_basic_coef_map::$sjbaccbuhg_qtdw_zhubr_xxqz
    ]),
    Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_zddw_xiebr_score => Formula::mul([
        Quantity_xfsjbas_gr_nbr_map::$sjbaccbuhg_zddw_xiebr,
        Quantity_xfsjbas_gr_basic_coef_map::$sjbaccbuhg_zddw_xiebr_xxqz
    ]),
    Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_zddw_zhubr_score => Formula::mul([
        Quantity_xfsjbas_gr_nbr_map::$sjbaccbuhg_zddw_zhubr,
        Quantity_xfsjbas_gr_basic_coef_map::$sjbaccbuhg_zddw_zhubr_xxqz
    ]),


    Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_zddw_xiebr_score => Formula::mul([
        Quantity_xfsjbas_gr_nbr_map::$sjbacchg_zddw_xiebr,
        Quantity_xfsjbas_gr_basic_coef_map::$sjbacchg_zddw_xiebr_xxqz
    ]),
    Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_zddw_zhubr_score => Formula::mul([
        Quantity_xfsjbas_gr_nbr_map::$sjbacchg_zddw_zhubr,
        Quantity_xfsjbas_gr_basic_coef_map::$sjbacchg_zddw_zhubr_xxqz
    ]),
    Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_qtdw_xiebr_score => Formula::mul([
        Quantity_xfsjbas_gr_nbr_map::$sjbacchg_qtdw_xiebr,
        Quantity_xfsjbas_gr_basic_coef_map::$sjbacchg_qtdw_xiebr_xxqz
    ]),
    Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_qtdw_zhubr_score => Formula::mul([
        Quantity_xfsjbas_gr_nbr_map::$sjbacchg_qtdw_zhubr,
        Quantity_xfsjbas_gr_basic_coef_map::$sjbacchg_qtdw_zhubr_xxqz
    ])

];

JSYS_formula::$ba_basic_2_sub = [
    Quantity_xfsjbas_gr_sub_score_map::$sjbaccbuhg_sub_score => Formula::mul([

        Formula::plus([
            JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_qtdw_xiebr_score],
            JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_qtdw_zhubr_score],
            JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_zddw_xiebr_score],
            JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_zddw_zhubr_score],
        ]),

        Quantity_xfsjbas_gr_sub_coef_map::$sjbaccbuhg_zxqz

    ]),
    Quantity_xfsjbas_gr_sub_score_map::$sjbacchg_sub_score => Formula::mul([

        Formula::plus([
            JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_qtdw_xiebr_score],
            JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_qtdw_zhubr_score],
            JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_zddw_xiebr_score],
            JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_zddw_zhubr_score],
        ]),

        Quantity_xfsjbas_gr_sub_coef_map::$sjbacchg_zxqz

    ]),
    Quantity_xfsjbas_gr_sub_score_map::$sjbabacc_total_score => Formula::plus([
        Formula::mul([

            Formula::plus([
                JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_qtdw_xiebr_score],
                JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_qtdw_zhubr_score],
                JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_zddw_xiebr_score],
                JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbaccbuhg_zddw_zhubr_score],
            ]),

            Quantity_xfsjbas_gr_sub_coef_map::$sjbaccbuhg_zxqz

        ]),
        Formula::mul([

            Formula::plus([
                JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_qtdw_xiebr_score],
                JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_qtdw_zhubr_score],
                JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_zddw_xiebr_score],
                JSYS_formula::$ba_nbr_2_basic[Quantity_xfsjbas_gr_basic_score_map::$sjbacchg_zddw_zhubr_score],
            ]),

            Quantity_xfsjbas_gr_sub_coef_map::$sjbacchg_zxqz

        ])
    ])
];


JSYS_formula::$ys_nbr_2_basic = [
    Quantity_xfyss_gr_basic_score_map::$gcysbuhg_qtdw_xiebr_score => Formula::mul([
        Quantity_xfyss_gr_nbr_map::$gcysbuhg_qtdw_xiebr,
        Quantity_xfyss_gr_basic_coef_map::$gcysbuhg_qtdw_xiebr_xxqz
    ]),
    Quantity_xfyss_gr_basic_score_map::$gcysbuhg_qtdw_zhubr_score => Formula::mul([
        Quantity_xfyss_gr_nbr_map::$gcysbuhg_qtdw_zhubr,
        Quantity_xfyss_gr_basic_coef_map::$gcysbuhg_qtdw_zhubr_xxqz
    ]),
    Quantity_xfyss_gr_basic_score_map::$gcysbuhg_zddw_xiebr_score => Formula::mul([
        Quantity_xfyss_gr_nbr_map::$gcysbuhg_zddw_xiebr,
        Quantity_xfyss_gr_basic_coef_map::$gcysbuhg_zddw_xiebr_xxqz
    ]),
    Quantity_xfyss_gr_basic_score_map::$gcysbuhg_zddw_zhubr_score => Formula::mul([
        Quantity_xfyss_gr_nbr_map::$gcysbuhg_zddw_zhubr,
        Quantity_xfyss_gr_basic_coef_map::$gcysbuhg_zddw_zhubr_xxqz
    ]),


    Quantity_xfyss_gr_basic_score_map::$gcyshg_zddw_xiebr_score => Formula::mul([
        Quantity_xfyss_gr_nbr_map::$gcyshg_zddw_xiebr,
        Quantity_xfyss_gr_basic_coef_map::$gcyshg_zddw_xiebr_xxqz
    ]),
    Quantity_xfyss_gr_basic_score_map::$gcyshg_zddw_zhubr_score => Formula::mul([
        Quantity_xfyss_gr_nbr_map::$gcyshg_zddw_zhubr,
        Quantity_xfyss_gr_basic_coef_map::$gcyshg_zddw_zhubr_xxqz
    ]),
    Quantity_xfyss_gr_basic_score_map::$gcyshg_qtdw_xiebr_score => Formula::mul([
        Quantity_xfyss_gr_nbr_map::$gcyshg_qtdw_xiebr,
        Quantity_xfyss_gr_basic_coef_map::$gcyshg_qtdw_xiebr_xxqz
    ]),
    Quantity_xfyss_gr_basic_score_map::$gcyshg_qtdw_zhubr_score => Formula::mul([
        Quantity_xfyss_gr_nbr_map::$gcyshg_qtdw_zhubr,
        Quantity_xfyss_gr_basic_coef_map::$gcyshg_qtdw_zhubr_xxqz
    ])

];

JSYS_formula::$ys_basic_2_sub = [
    Quantity_xfyss_gr_sub_score_map::$gcysbuhg_sub_score => Formula::mul([

        Formula::plus([
            JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcysbuhg_qtdw_xiebr_score],
            JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcysbuhg_qtdw_zhubr_score],
            JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcysbuhg_zddw_xiebr_score],
            JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcysbuhg_zddw_zhubr_score],
        ]),

        Quantity_xfyss_gr_sub_coef_map::$gcysbuhg_zxqz

    ]),
    Quantity_xfyss_gr_sub_score_map::$gcyshg_sub_score => Formula::mul([

        Formula::plus([
            JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcyshg_qtdw_xiebr_score],
            JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcyshg_qtdw_zhubr_score],
            JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcyshg_zddw_xiebr_score],
            JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcyshg_zddw_zhubr_score],
        ]),

        Quantity_xfyss_gr_sub_coef_map::$gcyshg_zxqz

    ]),
    Quantity_xfyss_gr_sub_score_map::$gcys_total_score => Formula::plus([
        Formula::mul([

            Formula::plus([
                JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcysbuhg_qtdw_xiebr_score],
                JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcysbuhg_qtdw_zhubr_score],
                JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcysbuhg_zddw_xiebr_score],
                JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcysbuhg_zddw_zhubr_score],
            ]),

            Quantity_xfyss_gr_sub_coef_map::$gcysbuhg_zxqz

        ]),
        Formula::mul([

            Formula::plus([
                JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcyshg_qtdw_xiebr_score],
                JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcyshg_qtdw_zhubr_score],
                JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcyshg_zddw_xiebr_score],
                JSYS_formula::$ys_nbr_2_basic[Quantity_xfyss_gr_basic_score_map::$gcyshg_zddw_zhubr_score],
            ]),

            Quantity_xfyss_gr_sub_coef_map::$gcyshg_zxqz

        ])
    ])
];


//竣工 => 健身验收
JSYS_formula::$jg_2_sub = [
    Jianshenyanshou_sub_score_map::$police_name => Quantity_xfjgys_gr_sub_score_map::$police_name,
    Jianshenyanshou_sub_score_map::$year_month_show => Quantity_xfjgys_gr_sub_score_map::$year_month_show,
    Jianshenyanshou_sub_score_map::$dd_name => Quantity_xfjgys_gr_sub_score_map::$dadui_name,
    Jianshenyanshou_sub_score_map::$jgysbas_score => Quantity_xfjgys_gr_sub_score_map::$jgysbacc_total_score

];

//备案 => 健身验收
JSYS_formula::$ba_2_sub = [
    Jianshenyanshou_sub_score_map::$police_name => Quantity_xfsjbas_gr_sub_score_map::$police_name,
    Jianshenyanshou_sub_score_map::$year_month_show => Quantity_xfsjbas_gr_sub_score_map::$year_month_show,
    Jianshenyanshou_sub_score_map::$dd_name => Quantity_xfsjbas_gr_sub_score_map::$dadui_name,
    Jianshenyanshou_sub_score_map::$sjbas_score => Quantity_xfsjbas_gr_sub_score_map::$sjbabacc_total_score
];

//验收 => 健身验收
JSYS_formula::$ys_2_sub = [
    Jianshenyanshou_sub_score_map::$police_name => Quantity_xfyss_gr_sub_score_map::$police_name,
    Jianshenyanshou_sub_score_map::$year_month_show => Quantity_xfyss_gr_sub_score_map::$year_month_show,
    Jianshenyanshou_sub_score_map::$dd_name => Quantity_xfyss_gr_sub_score_map::$dadui_name,
    Jianshenyanshou_sub_score_map::$xfyss_score => Quantity_xfyss_gr_sub_score_map::$gcys_total_score
];

//审核 => 健身验收
JSYS_formula::$sh_2_sub = [
    Jianshenyanshou_sub_score_map::$police_name => Quantity_xfsjshs_gr_sub_score_map::$police_name,
    Jianshenyanshou_sub_score_map::$year_month_show => Quantity_xfsjshs_gr_sub_score_map::$year_month_show,
    Jianshenyanshou_sub_score_map::$dd_name => Quantity_xfsjshs_gr_sub_score_map::$dadui_name,
    Jianshenyanshou_sub_score_map::$sjshs_score => Quantity_xfsjshs_gr_sub_score_map::$sjshs_total_score
];


JSYS_formula::$jsys_sub_2_gr = [
    Jianshenyanshou_gr_score_map::$jgysbas_df => Formula::mul([
        Jianshenyanshou_sub_score_map::$jgysbas_score,
        Jianshenyanshou_gr_coef_map::$jgysbas_coef
    ]),
    Jianshenyanshou_gr_score_map::$sjbas_df => Formula::mul([
        Jianshenyanshou_sub_score_map::$sjbas_score,
        Jianshenyanshou_gr_coef_map::$sjbas_coef
    ]),
    Jianshenyanshou_gr_score_map::$sjshs_df => Formula::mul([
        Jianshenyanshou_sub_score_map::$sjshs_score,
        Jianshenyanshou_gr_coef_map::$sjshs_coef
    ]),
    Jianshenyanshou_gr_score_map::$xfyss_df => Formula::mul([
        Jianshenyanshou_sub_score_map::$xfyss_score,
        Jianshenyanshou_gr_coef_map::$xfyss_coef
    ])
];

JSYS_formula::$jsys_sub_2_gr[Jianshenyanshou_gr_score_map::$jsys_zdf] = Formula::plus([
    JSYS_formula::$jsys_sub_2_gr[Jianshenyanshou_gr_score_map::$xfyss_df],
    JSYS_formula::$jsys_sub_2_gr[Jianshenyanshou_gr_score_map::$sjbas_df],
    JSYS_formula::$jsys_sub_2_gr[Jianshenyanshou_gr_score_map::$jgysbas_df],
    JSYS_formula::$jsys_sub_2_gr[Jianshenyanshou_gr_score_map::$sjshs_df]
]);


/**
 * Class JSYS_group 建审验收相关表格组类
 */
//TODO:代码重构 ，DRY
class JSYS_group extends Table_group
{

    /**
     * 竣工sub表更新
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function jg_sub_update($mysqli, $param)
    {
        if (!$param || $param == '') die("更新必须提供有效参数");

        return (new Table(Quantity_xfjgys_gr_sub_score_map::$table_name,
            Sql_tool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_xfjgys_gr_basic_coef_map::$table_name,
                    Quantity_xfjgys_gr_basic_score_map::$table_name,
                    Quantity_xfjgys_gr_sub_coef_map::$table_name,
                    Quantity_xfjgys_gr_nbr_map::$table_name
                ],
                array_merge(JSYS_formula::$jg_nbr_2_basic, JSYS_formula::$jg_basic_2_sub),
                $param
            );
    }

    /**
     * 备案sub表更新
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function ba_sub_update($mysqli, $param)
    {
        if (!$param || $param == '') die("更新必须提供有效参数");

        return (new Table(Quantity_xfsjbas_gr_sub_score_map::$table_name,
            Sql_tool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_xfsjbas_gr_basic_coef_map::$table_name,
                    Quantity_xfsjbas_gr_basic_score_map::$table_name,
                    Quantity_xfsjbas_gr_sub_coef_map::$table_name,
                    Quantity_xfsjbas_gr_nbr_map::$table_name
                ],
                array_merge(JSYS_formula::$ba_nbr_2_basic, JSYS_formula::$ba_basic_2_sub),
                $param
            );
    }

    /**
     * 审核sub表更新
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function sh_sub_update($mysqli, $param)
    {
        if (!$param || $param == '') die("更新必须提供有效参数");

        return (new Table(Quantity_xfsjshs_gr_sub_score_map::$table_name,
            Sql_tool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_xfsjshs_gr_basic_coef_map::$table_name,
                    Quantity_xfsjshs_gr_basic_score_map::$table_name,
                    Quantity_xfsjshs_gr_sub_coef_map::$table_name,
                    Quantity_xfsjshs_gr_nbr_map::$table_name
                ],
                array_merge(JSYS_formula::$sh_nbr_2_basic, JSYS_formula::$sh_basic_2_sub),
                $param
            );
    }

    /**
     * 验收sub表更新
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    public static function ys_sub_update($mysqli, $param)
    {
        if (!$param || $param == '') die("更新必须提供有效参数");

        return (new Table(Quantity_xfyss_gr_sub_score_map::$table_name,
            Sql_tool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    Quantity_xfyss_gr_basic_coef_map::$table_name,
                    Quantity_xfyss_gr_basic_score_map::$table_name,
                    Quantity_xfyss_gr_sub_coef_map::$table_name,
                    Quantity_xfyss_gr_nbr_map::$table_name
                ],
                array_merge(JSYS_formula::$ys_nbr_2_basic, JSYS_formula::$ys_basic_2_sub),
                $param
            );
    }

    /**
     * 竣工sub表更新（通过number_id）
     * @param mysqli $mysqli
     * @param int $id
     * @param string $other_param
     * @return int
     */
    public static function jg_sub_update_by_id($mysqli, $id, $other_param = '')
    {
        return self::jg_sub_update(
            $mysqli,
            Sql_tool::WHERE([
                Quantity_xfjgys_gr_basic_score_map::$number_id
                => Quantity_xfjgys_gr_nbr_map::$number_id,
                Quantity_xfjgys_gr_sub_score_map::$number_id
                => Quantity_xfjgys_gr_nbr_map::$number_id,
                Quantity_xfjgys_gr_nbr_map::$number_id => $id
            ], false) . $other_param
        );
    }

    /**
     * 备案sub更新（通过number_id）
     * @param mysqli $mysqli
     * @param int $id
     * @param string $other_param
     * @return int
     */
    public static function ba_sub_update_by_id($mysqli, $id, $other_param = '')
    {
        return self::ba_sub_update($mysqli,
            Sql_tool::WHERE([
                Quantity_xfsjbas_gr_basic_score_map::$number_id
                => Quantity_xfsjbas_gr_nbr_map::$number_id,
                Quantity_xfsjbas_gr_sub_score_map::$number_id
                => Quantity_xfsjbas_gr_nbr_map::$number_id,
                Quantity_xfsjbas_gr_nbr_map::$number_id => $id
            ], false) . $other_param
        );
    }

    /**
     * 审核sub更新（通过number_id）
     * @param mysqli $mysqli
     * @param int $id
     * @param string $other_param
     * @return int
     */
    public static function sh_sub_update_by_id($mysqli, $id, $other_param = '')
    {
        return self::sh_sub_update($mysqli,
            Sql_tool::WHERE([
                Quantity_xfsjshs_gr_basic_score_map::$number_id
                => Quantity_xfsjshs_gr_nbr_map::$number_id,
                Quantity_xfsjshs_gr_sub_score_map::$number_id
                => Quantity_xfsjshs_gr_nbr_map::$number_id,
                Quantity_xfsjshs_gr_nbr_map::$number_id => $id
            ], false) . $other_param
        );
    }

    /**
     * 验收sub表更新（通过number_id）
     * @param mysqli $mysqli
     * @param int $id
     * @param string $other_param
     * @return int
     */
    public static function ys_sub_update_by_id($mysqli, $id, $other_param = '')
    {
        return self::ys_sub_update($mysqli,
            Sql_tool::WHERE([
                Quantity_xfyss_gr_basic_score_map::$number_id
                => Quantity_xfyss_gr_nbr_map::$number_id,
                Quantity_xfyss_gr_sub_score_map::$number_id
                => Quantity_xfyss_gr_nbr_map::$number_id,
                Quantity_xfyss_gr_nbr_map::$number_id => $id
            ], false) . $other_param
        );
    }

    /**
     * 竣工sub表更新（通过日期区间，左闭右闭）
     * @param mysqli $mysqli
     * @param array $date_arr
     * @param string $other_param
     * @return int
     */
    public static function jg_sub_update_date_in($mysqli, $date_arr, $other_param = '')
    {
        return self::jg_sub_update(
            $mysqli,
            Sql_tool::WHERE([
                Quantity_xfjgys_gr_basic_score_map::$number_id
                => Quantity_xfjgys_gr_nbr_map::$number_id,
                Quantity_xfjgys_gr_sub_score_map::$number_id
                => Quantity_xfjgys_gr_nbr_map::$number_id
            ], false) . Sql_tool::BETWEEN(
                Quantity_xfjgys_gr_nbr_map::$year_month_show,
                $date_arr
            ) . $other_param
        );
    }

    /**
     * 备案sub表更新（通过日期区间，左闭右闭）
     * @param mysqli $mysqli
     * @param array $date_arr
     * @param string $other_param
     * @return int
     */
    public static function ba_sub_update_date_in($mysqli, $date_arr, $other_param = '')
    {
        return self::ba_sub_update($mysqli,
            Sql_tool::WHERE([
                Quantity_xfsjbas_gr_basic_score_map::$number_id
                => Quantity_xfsjbas_gr_nbr_map::$number_id,
                Quantity_xfsjbas_gr_sub_score_map::$number_id
                => Quantity_xfsjbas_gr_nbr_map::$number_id
            ], false) . Sql_tool::BETWEEN(
                Quantity_xfsjbas_gr_nbr_map::$year_month_show,
                $date_arr
            ) . $other_param
        );
    }


    /**
     * 审核sub表更新（通过日期区间，左闭右闭）
     * @param mysqli $mysqli
     * @param array $date_arr
     * @param string $other_param
     * @return int
     */
    public static function sh_sub_update_date_in($mysqli, $date_arr, $other_param = '')
    {
        return self::sh_sub_update($mysqli,
            Sql_tool::WHERE([
                Quantity_xfsjshs_gr_basic_score_map::$number_id
                => Quantity_xfsjshs_gr_nbr_map::$number_id,
                Quantity_xfsjshs_gr_sub_score_map::$number_id
                => Quantity_xfsjshs_gr_nbr_map::$number_id
            ], false) . Sql_tool::BETWEEN(
                Quantity_xfsjshs_gr_nbr_map::$year_month_show,
                $date_arr
            ) . $other_param
        );
    }


    /**
     * 验收sub表更新（通过日期区间，左闭右闭）
     * @param mysqli $mysqli
     * @param array $date_arr
     * @param string $other_param
     * @return int
     */
    public static function ys_sub_update_date_in($mysqli, $date_arr, $other_param = '')
    {
        return self::ys_sub_update($mysqli,
            Sql_tool::WHERE([
                Quantity_xfyss_gr_basic_score_map::$number_id
                => Quantity_xfyss_gr_nbr_map::$number_id,
                Quantity_xfyss_gr_sub_score_map::$number_id
                => Quantity_xfyss_gr_nbr_map::$number_id
            ], false) . Sql_tool::BETWEEN(
                Quantity_xfyss_gr_nbr_map::$year_month_show,
                $date_arr
            ) . $other_param
        );
    }


    /**
     * 判断建审验收总表该人该日是否存在数据
     * @param mysqli|Sql_tool $db
     * @param string $name
     * @param string $date
     * @return bool
     */
    public static function is_row_ext($db, $name, $date)
    {
        return parent::_is_row_ext(
            $db, Jianshenyanshou_sub_score_map::$table_name, $name, $date
        );
    }

    /**
     * 建审验收表插入审核分项
     * @param $mysqli
     * @param string $param
     * @return int
     */
    static function jianshen_insert_sh($mysqli, $param = '')
    {
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xfsjshs_gr_sub_score_map::$table_name
                ],
                JSYS_formula::$sh_2_sub,
                $param . Sql_tool::GROUP([
                    Quantity_xfsjshs_gr_sub_score_map::$year_month_show,
                    Quantity_xfsjshs_gr_sub_score_map::$police_name
                ])
            );
    }

    /**
     * 建审验收表插入竣工分项
     * @param $mysqli
     * @param string $param
     * @return int
     */
    static function jianshen_insert_jg($mysqli, $param = '')
    {
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xfjgys_gr_sub_score_map::$table_name
                ],
                JSYS_formula::$jg_2_sub,
                $param . Sql_tool::GROUP([
                    Quantity_xfjgys_gr_sub_score_map::$year_month_show,
                    Quantity_xfjgys_gr_sub_score_map::$police_name
                ])
            );
    }

    /**
     * 建审验收表插入备案分项
     * @param $mysqli
     * @param string $param
     * @return int
     */
    static function jianshen_insert_ba($mysqli, $param = '')
    {
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xfsjbas_gr_sub_score_map::$table_name
                ],
                JSYS_formula::$ba_2_sub,
                $param . Sql_tool::GROUP([
                    Quantity_xfsjbas_gr_sub_score_map::$year_month_show,
                    Quantity_xfsjbas_gr_sub_score_map::$police_name
                ])
            );
    }

    /**
     * 建审验收表插入验收分项
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    static function jianshen_insert_ys($mysqli, $param = '')
    {
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xfyss_gr_sub_score_map::$table_name
                ],
                JSYS_formula::$ys_2_sub,
                $param . Sql_tool::GROUP([
                    Quantity_xfyss_gr_sub_score_map::$year_month_show,
                    Quantity_xfyss_gr_sub_score_map::$police_name
                ])
            );
    }

    /**
     * 建审验收表插入审核分项（通过警员名，日期）
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    static function jianshen_insert_sh_item($mysqli, $police_name, $date)
    {
        return self::jianshen_insert_sh(
            $mysqli,
//            SqlTool::WHERE([
//                Quantity_xfsjshs_gr_sub_score_map::$police_name => $police_name,
//                Quantity_xfsjshs_gr_sub_score_map::$year_month_show => $date
//            ])
            parent::format_date(Quantity_xfsjshs_gr_sub_score_map::$year_month_show, $date)
            . Sql_tool::ANDC([Quantity_xfsjshs_gr_sub_score_map::$police_name => $police_name])
        );
    }

    /**
     * 建审验收表插入备案分项（通过警员名，日期）
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    static function jianshen_insert_ba_item($mysqli, $police_name, $date)
    {
        return self::jianshen_insert_ba(
            $mysqli,
//            SqlTool::WHERE([
//                Quantity_xfsjbas_gr_sub_score_map::$police_name => $police_name,
//                Quantity_xfsjbas_gr_sub_score_map::$year_month_show => $date
//            ])
            parent::format_date(Quantity_xfsjbas_gr_sub_score_map::$year_month_show, $date)
            . Sql_tool::ANDC([Quantity_xfsjbas_gr_sub_score_map::$police_name => $police_name])
        );
    }

    /**
     * 建审验收表插入竣工分项（通过警员名，日期）
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    static function jianshen_insert_jg_item($mysqli, $police_name, $date)
    {
        return self::jianshen_insert_jg(
            $mysqli,
//            SqlTool::WHERE([
//                Quantity_xfjgys_gr_sub_score_map::$police_name => $police_name,
//                Quantity_xfjgys_gr_sub_score_map::$year_month_show => $date
//            ])
            parent::format_date(Quantity_xfjgys_gr_sub_score_map::$year_month_show, $date)
            . Sql_tool::ANDC([Quantity_xfjgys_gr_sub_score_map::$police_name => $police_name])
        );
    }

    /**
     * 建审验收表插入验收分项（通过警员名，日期）
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    static function jianshen_insert_ys_item($mysqli, $police_name, $date)
    {
        return self::jianshen_insert_ys(
            $mysqli,
//            SqlTool::WHERE([
//                Quantity_xfyss_gr_sub_score_map::$police_name => $police_name,
//                Quantity_xfyss_gr_sub_score_map::$year_month_show => $date
//            ])
            parent::format_date(Quantity_xfyss_gr_sub_score_map::$year_month_show, $date)
            . Sql_tool::ANDC([Quantity_xfyss_gr_sub_score_map::$police_name => $police_name])
        );
    }

    /**
     * 建审验收表更新审核分项（通过警员名，日期）
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static function jianshen_update_sh_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = Sql_tool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::jianshen_insert_sh_item($db, $police_name, $date);
            }
        }
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Quantity_xfsjshs_gr_sub_score_map::$sjshs_total_score . "),0) AS res , police_name,year_month_show FROM " . Quantity_xfsjshs_gr_sub_score_map::$table_name .
                    Sql_tool::WHERE([
                        Quantity_xfsjshs_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xfsjshs_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$sjshs_score => 'A.res'
                ],
                Sql_tool::WHERE([
                    Jianshenyanshou_sub_score_map::$year_month_show => $date,
                    Jianshenyanshou_sub_score_map::$police_name => $police_name
                ], true)
            );
    }

    public static function jianshen_update_sh($db, $ba_table_param, $jsys_table_param)
    {
        $sqlTool = parent::sqlTool_build($db);

        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $sqlTool))
            ->union_update(
                [
                    "(SELECT 
                    ifnull(SUM(" . Quantity_xfsjshs_gr_sub_score_map::$sjshs_total_score . "),0) 
                    AS res , police_name,year_month_show FROM " .
                    Quantity_xfsjshs_gr_sub_score_map::$table_name
                    . $ba_table_param . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$sjshs_score => 'A.res'
                ],
                $jsys_table_param
            );
    }

    public static function jianshen_update_sh_by_date($db, $date)
    {
        return self::jianshen_update_sh(
            $db,
            parent::format_date(
                Quantity_xfsjshs_gr_sub_score_map::$year_month_show,
                $date
            ) .
            Sql_tool::GROUP([
                Quantity_xfsjshs_gr_sub_score_map::$year_month_show,
                Quantity_xfsjshs_gr_sub_score_map::$police_name
            ]),
            Sql_tool::WHERE([
                Jianshenyanshou_sub_score_map::$year_month_show => 'A.year_month_show',
                Jianshenyanshou_sub_score_map::$police_name => 'A.police_name',
            ], false)
        );
    }

    /**
     * 建审验收表更新验收分项（通过警员名，日期）
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static function jianshen_update_ys_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = Sql_tool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::jianshen_insert_ys_item($db, $police_name, $date);
            }
        }
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Quantity_xfyss_gr_sub_score_map::$gcys_total_score . "),0) AS res , police_name,year_month_show FROM " . Quantity_xfyss_gr_sub_score_map::$table_name .
                    Sql_tool::WHERE([
                        Quantity_xfyss_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xfyss_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$xfyss_score => 'A.res'
                ],
                Sql_tool::WHERE([
                    Jianshenyanshou_sub_score_map::$year_month_show => $date,
                    Jianshenyanshou_sub_score_map::$police_name => $police_name
                ])
            );
    }

    public static function jianshen_update_ys($db, $ba_table_param, $jsys_table_param)
    {
        $sqlTool = parent::sqlTool_build($db);

        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $sqlTool))
            ->union_update(
                [
                    "(SELECT 
                    ifnull(SUM(" . Quantity_xfyss_gr_sub_score_map::$gcys_total_score . "),0) 
                    AS res , police_name,year_month_show FROM " .
                    Quantity_xfyss_gr_sub_score_map::$table_name
                    . $ba_table_param . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$xfyss_score => 'A.res'
                ],
                $jsys_table_param
            );
    }

    public static function jianshen_update_ys_by_date($db, $date)
    {
        return self::jianshen_update_ys(
            $db,
            parent::format_date(
                Quantity_xfyss_gr_sub_score_map::$year_month_show,
                $date
            ) .
            Sql_tool::GROUP([
                Quantity_xfyss_gr_sub_score_map::$year_month_show,
                Quantity_xfyss_gr_sub_score_map::$police_name
            ]),
            Sql_tool::WHERE([
                Jianshenyanshou_sub_score_map::$year_month_show => 'A.year_month_show',
                Jianshenyanshou_sub_score_map::$police_name => 'A.police_name',
            ], false)
        );
    }

    /**
     * 建审验收表更新竣工分项
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static function jianshen_update_jg_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = Sql_tool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::jianshen_insert_jg_item($db, $police_name, $date);
            }
        }
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Quantity_xfjgys_gr_sub_score_map::$jgysbacc_total_score . "),0) AS res , police_name,year_month_show FROM " . Quantity_xfjgys_gr_sub_score_map::$table_name .
                    Sql_tool::WHERE([
                        Quantity_xfjgys_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xfjgys_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$jgysbas_score => 'A.res'
                ],
                Sql_tool::WHERE([
                    Jianshenyanshou_sub_score_map::$year_month_show => $date,
                    Jianshenyanshou_sub_score_map::$police_name => $police_name
                ])
            );
    }

    public static function jianshen_update_jg($db, $ba_table_param, $jsys_table_param)
    {
        $sqlTool = parent::sqlTool_build($db);

        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $sqlTool))
            ->union_update(
                [
                    "(SELECT 
                    ifnull(SUM(" . Quantity_xfjgys_gr_sub_score_map::$jgysbacc_total_score . "),0) 
                    AS res , police_name,year_month_show FROM " .
                    Quantity_xfjgys_gr_sub_score_map::$table_name
                    . $ba_table_param . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$jgysbas_score => 'A.res'
                ],
                $jsys_table_param
            );
    }

    public static function jianshen_update_jg_by_date($db, $date)
    {
        return self::jianshen_update_jg(
            $db,
            parent::format_date(
                Quantity_xfjgys_gr_sub_score_map::$year_month_show,
                $date
            ) .
            Sql_tool::GROUP([
                Quantity_xfjgys_gr_sub_score_map::$year_month_show,
                Quantity_xfjgys_gr_sub_score_map::$police_name
            ]),
            Sql_tool::WHERE([
                Jianshenyanshou_sub_score_map::$year_month_show => 'A.year_month_show',
                Jianshenyanshou_sub_score_map::$police_name => 'A.police_name',
            ], false)
        );
    }

    /**
     * 建审验收表更新备案分项（通过警员名，日期）
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static function jianshen_update_ba_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = Sql_tool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::jianshen_insert_ba_item($db, $police_name, $date);
            }
        }
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Quantity_xfsjbas_gr_sub_score_map::$sjbabacc_total_score . "),0) AS res , police_name,year_month_show FROM " . Quantity_xfsjbas_gr_sub_score_map::$table_name .
                    Sql_tool::WHERE([
                        Quantity_xfsjbas_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xfsjbas_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$sjbas_score => 'A.res'
                ],
                Sql_tool::WHERE([
                    Jianshenyanshou_sub_score_map::$year_month_show => $date,
                    Jianshenyanshou_sub_score_map::$police_name => $police_name
                ])
            );
    }

    public static function jianshen_update_ba($db, $ba_table_param, $jsys_table_param)
    {
        $sqlTool = parent::sqlTool_build($db);

        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $sqlTool))
            ->union_update(
                [
                    "(SELECT 
                    ifnull(SUM(" . Quantity_xfsjbas_gr_sub_score_map::$sjbabacc_total_score . "),0) 
                    AS res , police_name,year_month_show FROM " .
                    Quantity_xfsjbas_gr_sub_score_map::$table_name
                    . $ba_table_param . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$sjbas_score => 'A.res'
                ],
                $jsys_table_param
            );
    }

    public static function jianshen_update_ba_by_date($db, $date)
    {
        return self::jianshen_update_ba(
            $db,
            parent::format_date(
                Quantity_xfsjbas_gr_sub_score_map::$year_month_show,
                $date
            ) .
            Sql_tool::GROUP([
                Quantity_xfsjbas_gr_sub_score_map::$year_month_show,
                Quantity_xfsjbas_gr_sub_score_map::$police_name
            ]),
            Sql_tool::WHERE([
                Jianshenyanshou_sub_score_map::$year_month_show => 'A.year_month_show',
                Jianshenyanshou_sub_score_map::$police_name => 'A.police_name',
            ], false)
        );
    }

    public static function jianshen_update_sub_2_gr_by_date($db, $date = null)
    {
        $sqltool = parent::sqlTool_build($db);
        return (new Table(Jianshenyanshou_gr_score_map::$table_name, $sqltool))
            ->union_update(
                [
                    Jianshenyanshou_sub_score_map::$table_name,
                    Jianshenyanshou_gr_coef_map::$table_name
                ],
                JSYS_formula::$jsys_sub_2_gr,
                Sql_tool::WHERE([
                    Jianshenyanshou_gr_score_map::$number_id => Jianshenyanshou_sub_score_map::$number_id
                ], false) .
                parent::format_date(
                    Jianshenyanshou_sub_score_map::$year_month_show,
                    $date,
                    true
                )
            );
    }

    /**
     * @param mysqli|Sql_tool $db
     * @param null|string|array $date
     */
    public static function jsys_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [new Table(Jianshenyanshou_sub_score_map::$table_name, $sqlTool)];

        if (!$date) {
            array_push($tables, new Table(Jianshenyanshou_gr_score_map::$table_name, $sqlTool));
        }

        parent::group_clear(
            $tables,
            'year_month_show',
            $date
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string|array $date
     */
    static function group_insert($mysqli, $date = null)
    {
        $sqlTool = Sql_tool::build_by_mysqli($mysqli);


        $sqlTool->do_not_gone_away();

        Sql_tool::devopen();

        self::jsys_clear($sqlTool, $date);

        $afr = self::jianshen_insert_sh(
            $mysqli,
            parent::format_date(
                Quantity_xfsjshs_gr_sub_score_map::$year_month_show,
                $date
            )
        );

        echo '      *sh finished , affect rows : ' . "$afr | ";

        $afr = self::jianshen_insert_jg(
            $mysqli,
            parent::format_date(
                Quantity_xfjgys_gr_sub_score_map::$year_month_show,
                $date
            )
        );

        echo '*jg finished , affect rows : ' . "$afr | ";


        $afr = self::jianshen_insert_ba(
            $mysqli,
            parent::format_date(
                Quantity_xfsjbas_gr_sub_score_map::$year_month_show,
                $date
            )
        );

        echo '*ba finished , affect rows : ' . "$afr | ";

        $afr = self::jianshen_insert_ys(
            $mysqli,
            parent::format_date(
                Quantity_xfyss_gr_sub_score_map::$year_month_show,
                $date
            )
        );

        echo '*ys finished , affect rows : ' . "$afr\n";


        $hz_table = (new Table(Jianshenyanshou_sub_score_map::$table_name, $sqlTool));
        $res = $hz_table
            ->group_query(
                [
                    Sql_tool::SUM(Jianshenyanshou_sub_score_map::$sjshs_score) => 'sh',
                    Sql_tool::SUM(Jianshenyanshou_sub_score_map::$sjbas_score) => 'ba',
                    Sql_tool::SUM(Jianshenyanshou_sub_score_map::$jgysbas_score) => 'jg',
                    Sql_tool::SUM(Jianshenyanshou_sub_score_map::$xfyss_score) => 'ys',
                    Jianshenyanshou_sub_score_map::$police_name => 'n',
                    Jianshenyanshou_sub_score_map::$year_month_show => 'y',
                    Jianshenyanshou_sub_score_map::$dd_name => 'd'
                ],
                [
                    Jianshenyanshou_sub_score_map::$police_name,
                    Jianshenyanshou_sub_score_map::$year_month_show,
                ],
                parent::format_date(
                    Jianshenyanshou_sub_score_map::$year_month_show,
                    $date,
                    true
                )
            );

        self::jsys_clear($sqlTool, $date);

        Sql_tool::devclose();

        echo 'JSYS : insert finished' . "\n";

        $sql = '';
        $res->each_row(function ($row) use (&$sql) {
            $sql .= ',(' . $row['sh'] . ',' .
                $row['ba'] . ',' .
                $row['jg'] . ',' .
                $row['ys'] . ',' .
                Sql_tool::QUOTE($row['n']) . ',' .
                Sql_tool::QUOTE($row['y']) . ',' .
                Sql_tool::QUOTE($row['d']) . ')';
        });

        if ($sql != '')
            $hz_table->multi_insert(
                [
                    Jianshenyanshou_sub_score_map::$sjshs_score,
                    Jianshenyanshou_sub_score_map::$sjbas_score,
                    Jianshenyanshou_sub_score_map::$jgysbas_score,
                    Jianshenyanshou_sub_score_map::$xfyss_score,
                    Jianshenyanshou_sub_score_map::$police_name,
                    Jianshenyanshou_sub_score_map::$year_month_show,
                    Jianshenyanshou_sub_score_map::$dd_name
                ],
                substr($sql, 1)
            );


        return;
////        $sub_table = new Table(Jianshenyanshou_sub_score_map::$table_name, $sqlTool);
//        $jg_table = new Table(Quantity_xfjgys_gr_sub_score_map::$table_name, $sqlTool);
////        $sh_table = new Table(Quantity_xfsjshs_gr_sub_score_map::$table_name,$sqlTool);
//        $ba_table = new Table(Quantity_xfsjbas_gr_sub_score_map::$table_name, $sqlTool);
//        $ys_table = new Table(Quantity_xfyss_gr_sub_score_map::$table_name, $sqlTool);
//
////        $result = ['jg' => 0, 'ys' => '0', 'ba' => 0, 'sh' => '0'];
//
//        //TODO
//        $res = $jg_table->group_query(
//            [
//                Quantity_xfjgys_gr_sub_score_map::$police_name => 'n',
//                Quantity_xfjgys_gr_sub_score_map::$year_month_show => 'd',
//            ], [
//            Quantity_xfjgys_gr_sub_score_map::$year_month_show,
//            Quantity_xfjgys_gr_sub_score_map::$police_name
//        ],
//            parent::format_date(Quantity_xfjgys_gr_sub_score_map::$year_month_show, $date)
//        );
//
//        $res->each_row(function ($row) use ($mysqli) {
//            self::jianshen_update_jg_item($mysqli, $row['n'], $row['d'], true);
//        });
//
//        $res = $ba_table->group_query(
//            [
//                Quantity_xfsjbas_gr_sub_score_map::$police_name => 'n',
//                Quantity_xfsjbas_gr_sub_score_map::$year_month_show => 'd',
//            ], [
//            Quantity_xfsjbas_gr_sub_score_map::$year_month_show,
//            Quantity_xfsjbas_gr_sub_score_map::$police_name
//        ],
//            parent::format_date(Quantity_xfsjbas_gr_sub_score_map::$year_month_show, $date)
//        );
//
//        $res->each_row(function ($row) use ($mysqli) {
//            self::jianshen_update_ba_item($mysqli, $row['n'], $row['d'], true);
//        });
//
//        $res = $ys_table->group_query(
//            [
//                Quantity_xfyss_gr_sub_score_map::$police_name => 'n',
//                Quantity_xfyss_gr_sub_score_map::$year_month_show => 'd',
//            ],
//            [
//                Quantity_xfyss_gr_sub_score_map::$year_month_show,
//                Quantity_xfyss_gr_sub_score_map::$police_name
//            ],
//            parent::format_date(Quantity_xfyss_gr_sub_score_map::$year_month_show, $date)
//        );
//
//
//        $res->each_row(function ($row) use ($mysqli) {
//            self::jianshen_update_ys_item($mysqli, $row['n'], $row['d'], true);
//        });


    }


    static function sh_group_update($mysqli, $date = null)
    {
        JSYS_group::sh_sub_update_date_in($mysqli, $date);
        JSYS_group::jianshen_update_sh_by_date($mysqli, $date);
    }


    static function jg_group_update($mysqli, $date = null)
    {
        JSYS_group::jg_sub_update_date_in($mysqli, $date);
        JSYS_group::jianshen_update_jg_by_date($mysqli, $date);

    }

    static function ba_group_update($mysqli, $date = null)
    {
        JSYS_group::ba_sub_update_date_in($mysqli, $date);
        JSYS_group::jianshen_update_ba_by_date($mysqli, $date);

    }

    static function ys_group_update($mysqli, $date = null)
    {
        JSYS_group::ys_sub_update_date_in($mysqli, $date);
        JSYS_group::jianshen_update_ys_by_date($mysqli, $date);

    }

    static function group_update($mysqli, $date = null)
    {
        self::ys_group_update($mysqli,$date);
        self::sh_group_update($mysqli,$date);
        self::jg_group_update($mysqli,$date);
        self::ba_group_update($mysqli,$date);
    }


}