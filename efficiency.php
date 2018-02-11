<?php
/**
 * User: zhuangjiayu
 * Date: 2018/2/8
 * Time: 19:17
 */

require_once __DIR__ . '/Efficiency/Efficiency.php';
require_once __DIR__ . '/common/common.php';
require_once __DIR__ . '/map/Dadui_huizong_query_day.map.php';

Sql_tool::devopen();
$data_arr = ['2017-01-01', '2018-02-08'];
//efficiency($data_arr);
function efficiency($mysqli_zxpg, $mysqli_hazd, $data_arr)
{
    $sqltool = Table_group::sqlTool_build($mysqli_zxpg);

    Efficiency::$police_dd_map = get_police_dadui_map();

    Efficiency::set_coef($sqltool);

    $dadui_huizong_sql = '';

    $xzcf_sql = '';
    $bacc_sql = '';
    $hzdc_sql = '';
    $jsys_sql = '';
    $jdjc_sql = '';
//$row_handle = function ($row, &$sql, $type) {
//
//};

    Efficiency::count_xzcf_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$xzcf_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $xzcf_sql, 'xzcf');
    });

    Efficiency::count_jdjc_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$jdjc_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $jdjc_sql, 'jdjc');
    });

    Efficiency::count_hzdc_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$hzdc_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $hzdc_sql, 'hzdc');
    });

    Efficiency::count_shys_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$jsys_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $jsys_sql, 'jsys');
    });

    Efficiency::count_aqjc_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$jsys_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $jsys_sql, 'jsys');
    });

    Efficiency::count_bacc_by_date($sqltool, $data_arr, function ($row) use (&$sql, &$bacc_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $bacc_sql, 'bacc');
    });


    if ($xzcf_sql != '') {
        Efficiency::xzcf_clear($mysqli_zxpg, $data_arr);
        (new Table(Zfxl_xzcf_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfxl_xzcf_map::$name,
                Zfxl_xzcf_map::$dadui,
                Zfxl_xzcf_map::$XMBH,
                Zfxl_xzcf_map::$CFDX,
                Zfxl_xzcf_map::$BAQX,
                Zfxl_xzcf_map::$CJTIME,
                Zfxl_xzcf_map::$CFJG,
                Zfxl_xzcf_map::$OVERTIME,
                Zfxl_xzcf_map::$CBR,
                Zfxl_xzcf_map::$CompleteTimeSCORE,
                Zfxl_xzcf_map::$CompleteTimeCount,
                Zfxl_xzcf_map::$SendToCBR,
                Zfxl_xzcf_map::$SendToCBRCount,
                Zfxl_xzcf_map::$SendToCBRJLDSCORE,
                Zfxl_xzcf_map::$SendToCBRJLDCount,
                Zfxl_xzcf_map::$SendToDDZDZGSCORE,
                Zfxl_xzcf_map::$SendToDDZDZGCount,
                Zfxl_xzcf_map::$KP_SCORE,
                Zfxl_xzcf_map::$KP_TRUE_SCORE
            ],
            substr($xzcf_sql, 1)
        );
    }

    if ($jdjc_sql != '') {
        Efficiency::jdjc_clear($mysqli_zxpg, $data_arr);
        (new Table(Zfxl_jdjc_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfxl_jdjc_map::$name,
                Zfxl_jdjc_map::$dadui,
                Zfxl_jdjc_map::$XMBH,
                Zfxl_jdjc_map::$xmlx,
                Zfxl_jdjc_map::$DWMC,
                Zfxl_jdjc_map::$JCQX,
                Zfxl_jdjc_map::$JCQK,
                Zfxl_jdjc_map::$OVERTIME,
                Zfxl_jdjc_map::$CBR,
                Zfxl_jdjc_map::$CompleteTimeSCORE,
                Zfxl_jdjc_map::$CompleteTimeCount,
                Zfxl_jdjc_map::$SendToCBR,
                Zfxl_jdjc_map::$SendToCBRCount,
                Zfxl_jdjc_map::$SendToCBRJLDSCORE,
                Zfxl_jdjc_map::$SendToCBRJLDCount,
                Zfxl_jdjc_map::$SendToDDZDZGSCORE,
                Zfxl_jdjc_map::$SendToDDZDZGCount,
                Zfxl_jdjc_map::$KP_SCORE,
                Zfxl_jdjc_map::$KP_TRUE_SCORE
            ],
            substr($xzcf_sql, 1)
        );
    }

    if (false) {
        Efficiency::hzdc_clear($mysqli_zxpg, $data_arr);
        (new Table(Zfxl_hzdc_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfxl_hzdc_map::$name,
                Zfxl_hzdc_map::$dadui,
                Zfxl_hzdc_map::$XMBH,
                Zfxl_hzdc_map::$xmlx,
                Zfxl_hzdc_map::$QHSJ,
                Zfxl_hzdc_map::$BJSJ,
                Zfxl_hzdc_map::$JZTIME,
                Zfxl_hzdc_map::$CLTIME,
                Zfxl_hzdc_map::$Status,
                Zfxl_hzdc_map::$OVERTIME,
                Zfxl_hzdc_map::$CBR,
                Zfxl_hzdc_map::$CompleteTimeSCORE,
                Zfxl_hzdc_map::$CompleteTimeCount,
                Zfxl_hzdc_map::$SendToCBR,
                Zfxl_hzdc_map::$SendToCBRCount,
                Zfxl_hzdc_map::$SendToCBRJLDSCORE,
                Zfxl_hzdc_map::$SendToCBRJLDCount,
                Zfxl_hzdc_map::$SendToDDZDZGSCORE,
                Zfxl_hzdc_map::$SendToDDZDZGCount,
                Zfxl_hzdc_map::$KP_SCORE,
                Zfxl_hzdc_map::$KP_TRUE_SCORE
            ],
            substr($xzcf_sql, 1)
        );
    }

    if (false) {
        Efficiency::bacc_clear($mysqli_zxpg, $data_arr);
        (new Table(Zfxl_bacc_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfxl_bacc_map::$name,
                Zfxl_bacc_map::$dadui,
                Zfxl_bacc_map::$XMBH,
                Zfxl_bacc_map::$GCMC,
                Zfxl_bacc_map::$XMJG,
                Zfxl_bacc_map::$SLSJ,
                Zfxl_bacc_map::$JGYS,
                Zfxl_bacc_map::$CBR,
                Zfxl_bacc_map::$CompleteTimeSCORE,
                Zfxl_bacc_map::$CompleteTimeCount,
                Zfxl_bacc_map::$SendToCBR,
                Zfxl_bacc_map::$SendToCBRCount,
                Zfxl_bacc_map::$SendToCBRJLDSCORE,
                Zfxl_bacc_map::$SendToCBRJLDCount,
                Zfxl_bacc_map::$SendToDDZDZGSCORE,
                Zfxl_bacc_map::$SendToDDZDZGCount,
                Zfxl_bacc_map::$KP_SCORE,
                Zfxl_bacc_map::$KP_TRUE_SCORE
            ],
            substr($xzcf_sql, 1)
        );
    }

    if ($dadui_huizong_sql == '')
        return 0;
    return (new Table(Dadui_huizong_query_day_map::$table_name, Table_group::sqlTool_build($mysqli_hazd)))->multi_insert(
        [
            Dadui_huizong_query_day_map::$efficiency_score,
            Dadui_huizong_query_day_map::$efficiency_count,
            Dadui_huizong_query_day_map::$year_month_show,
            Dadui_huizong_query_day_map::$dd_name,
            Dadui_huizong_query_day_map::$police_name
        ],
        substr($dadui_huizong_sql, 1)
    );
}