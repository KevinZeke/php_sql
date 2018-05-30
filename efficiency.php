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

    Efficiency::set_clbz($sqltool);

//    print_r(Efficiency::$coef);

    $dadui_huizong_sql = '';

    $xzcf_sql = '';
    $bacc_sql = '';
    $hzdc_sql = '';
    $hzdc_hz_sql = '';
    $jsys_sql = '';
    $aqjc_sql = '';
    $jdjc_sql = '';
    $xzqz_sql = '';
    $hz_sql   = '';
//$row_handle = function ($row, &$sql, $type) {
//
//};

    Efficiency::count_xzcf_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$xzcf_sql, &$hz_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $xzcf_sql, $hz_sql, 'xzcf');
    });

    Efficiency::count_jdjc_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$jdjc_sql, &$hz_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $jdjc_sql, $hz_sql, 'jdjc');
    });

    Efficiency::count_xzqz_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$xzqz_sql, &$hz_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $xzqz_sql, $hz_sql, 'xzqz');
    });

    Efficiency::count_hzdc_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$hzdc_sql, &$hz_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $hzdc_sql, $hz_sql, 'hzdc');
    });

    Efficiency::count_hzdc_fh_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$hzdc_hz_sql, &$hz_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $hzdc_hz_sql, $hz_sql, 'hzdc_fh');
    });

    Efficiency::count_shys_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$jsys_sql, &$hz_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $jsys_sql, $hz_sql, 'jsys');
    });

    Efficiency::count_aqjc_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$aqjc_sql, &$hz_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $aqjc_sql, $hz_sql, 'aqjc');
    });

    Efficiency::count_bacc_by_date($sqltool, $data_arr, function ($row) use (&$dadui_huizong_sql, &$bacc_sql, &$hz_sql) {
        Efficiency::row_handel($row, $dadui_huizong_sql, $bacc_sql, $hz_sql, 'bacc');
    });


    Efficiency::xzcf_clear($mysqli_zxpg, $data_arr);
    if ($xzcf_sql != '') {
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
                Zfxl_xzcf_map::$ffbzgl_zfxl_1,
                Zfxl_xzcf_map::$CompleteTimeCount,
                Zfxl_xzcf_map::$ffbzgl_zfxl_cbr2,
                Zfxl_xzcf_map::$SendToCBRCount,
                Zfxl_xzcf_map::$ffbzgl_zfxl_ld3,
                Zfxl_xzcf_map::$SendToCBRJLDCount,
                Zfxl_xzcf_map::$ffbzgl_zfxl_zg4,
                Zfxl_xzcf_map::$SendToDDZDZGCount,
                Zfxl_xzcf_map::$KP_SCORE,
                Zfxl_xzcf_map::$KP_TRUE_SCORE,
                Zfxl_xzcf_map::$cbr_qz
            ],
            substr($xzcf_sql, 1)
        );
    }

    Efficiency::jdjc_clear($mysqli_zxpg, $data_arr);
    if ($jdjc_sql != '') {
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
                Zfxl_jdjc_map::$ffbzgl_zfxl_1,
                Zfxl_jdjc_map::$CompleteTimeCount,
                Zfxl_jdjc_map::$ffbzgl_zfxl_cbr2,
                Zfxl_jdjc_map::$SendToCBRCount,
                Zfxl_jdjc_map::$ffbzgl_zfxl_ld3,
                Zfxl_jdjc_map::$SendToCBRJLDCount,
                Zfxl_jdjc_map::$ffbzgl_zfxl_zg4,
                Zfxl_jdjc_map::$SendToDDZDZGCount,
                Zfxl_jdjc_map::$KP_SCORE,
                Zfxl_jdjc_map::$KP_TRUE_SCORE,
                Zfxl_jdjc_map::$zl_qz,
                Zfxl_jdjc_map::$cbr_qz
            ],
            substr($jdjc_sql, 1)
        );
    }

    Efficiency::xzqz_clear($mysqli_zxpg, $data_arr);
    if ($xzqz_sql != '') {
        (new Table(Zfxl_xzqz_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfxl_xzqz_map::$name,
                Zfxl_xzqz_map::$dadui,
                Zfxl_xzqz_map::$XMBH,
                Zfxl_xzqz_map::$xmlx,
                Zfxl_xzqz_map::$DWMC,
                Zfxl_xzqz_map::$JCQX,
                Zfxl_xzqz_map::$JCQK,
                Zfxl_xzqz_map::$OVERTIME,
                Zfxl_xzqz_map::$CBR,
                Zfxl_xzqz_map::$ffbzgl_zfxl_1,
                Zfxl_xzqz_map::$CompleteTimeCount,
                Zfxl_xzqz_map::$ffbzgl_zfxl_cbr2,
                Zfxl_xzqz_map::$SendToCBRCount,
                Zfxl_xzqz_map::$ffbzgl_zfxl_ld3,
                Zfxl_xzqz_map::$SendToCBRJLDCount,
                Zfxl_xzqz_map::$ffbzgl_zfxl_zg4,
                Zfxl_xzqz_map::$SendToDDZDZGCount,
                Zfxl_xzqz_map::$KP_SCORE,
                Zfxl_xzqz_map::$KP_TRUE_SCORE,
                Zfxl_xzqz_map::$zl_qz,
                Zfxl_xzqz_map::$cbr_qz,
                Zfxl_xzqz_map::$sonType,
            ],
            substr($xzqz_sql, 1)
        );
    }

    Efficiency::hzdc_clear($mysqli_zxpg, $data_arr);
    if ($hzdc_sql != '') {
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
                Zfxl_hzdc_map::$ffbzgl_zfxl_1,
                Zfxl_hzdc_map::$CompleteTimeCount,
                Zfxl_hzdc_map::$ffbzgl_zfxl_cbr2,
                Zfxl_hzdc_map::$SendToCBRCount,
                Zfxl_hzdc_map::$ffbzgl_zfxl_ld3,
                Zfxl_hzdc_map::$SendToCBRJLDCount,
                Zfxl_hzdc_map::$ffbzgl_zfxl_zg4,
                Zfxl_hzdc_map::$SendToDDZDZGCount,
                Zfxl_hzdc_map::$KP_SCORE,
                Zfxl_hzdc_map::$KP_TRUE_SCORE,
                Zfxl_hzdc_map::$zl_qz,
                Zfxl_hzdc_map::$cbr_qz
            ],
            substr($hzdc_sql, 1)
        );
    }
    if ($hzdc_hz_sql != '') {
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
                Zfxl_hzdc_map::$ffbzgl_zfxl_1,
                Zfxl_hzdc_map::$CompleteTimeCount,
                Zfxl_hzdc_map::$ffbzgl_zfxl_cbr2,
                Zfxl_hzdc_map::$SendToCBRCount,
                Zfxl_hzdc_map::$ffbzgl_zfxl_ld3,
                Zfxl_hzdc_map::$SendToCBRJLDCount,
                Zfxl_hzdc_map::$ffbzgl_zfxl_zg4,
                Zfxl_hzdc_map::$SendToDDZDZGCount,
                Zfxl_hzdc_map::$KP_SCORE,
                Zfxl_hzdc_map::$KP_TRUE_SCORE,
                Zfxl_hzdc_map::$zl_qz,
                Zfxl_hzdc_map::$cbr_qz
            ],
            substr($hzdc_hz_sql, 1)
        );
    }

//    if ($jdjc_sql != '') {
//        Efficiency::jdjc_clear($mysqli_zxpg, $data_arr);
//        (new Table(Zfxl_jdjc_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
//            [
//                Zfxl_jdjc_map::$name,
//                Zfxl_jdjc_map::$dadui,
//                Zfxl_jdjc_map::$XMBH,
//                Zfxl_jdjc_map::$xmlx,
//                Zfxl_jdjc_map::$DWMC,
//                Zfxl_jdjc_map::$JCQX,
//                Zfxl_jdjc_map::$JCQK,
//                Zfxl_jdjc_map::$OVERTIME,
//                Zfxl_jdjc_map::$CBR,
//                Zfxl_jdjc_map::$CompleteTimeSCORE,
//                Zfxl_jdjc_map::$CompleteTimeCount,
//                Zfxl_jdjc_map::$SendToCBR,
//                Zfxl_jdjc_map::$SendToCBRCount,
//                Zfxl_jdjc_map::$SendToCBRJLDSCORE,
//                Zfxl_jdjc_map::$SendToCBRJLDCount,
//                Zfxl_jdjc_map::$SendToDDZDZGSCORE,
//                Zfxl_jdjc_map::$SendToDDZDZGCount,
//                Zfxl_jdjc_map::$KP_SCORE,
//                Zfxl_jdjc_map::$KP_TRUE_SCORE
//            ],
//            substr($jdjc_sql, 1)
//        );
//    }
    Efficiency::bacc_clear($mysqli_zxpg, $data_arr);
    if ($bacc_sql != '') {
        (new Table(Zfxl_bacc_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfxl_bacc_map::$name,
                Zfxl_bacc_map::$dadui,
                Zfxl_bacc_map::$XMBH,
                Zfxl_bacc_map::$overtime,
                Zfxl_bacc_map::$GCMC,
                Zfxl_bacc_map::$XMJG,
                Zfxl_bacc_map::$SLSJ,
                Zfxl_bacc_map::$JGYS,
                Zfxl_bacc_map::$CBR,
                Zfxl_bacc_map::$ffbzgl_zfxl_1,
                Zfxl_bacc_map::$CompleteTimeCount,
                Zfxl_bacc_map::$ffbzgl_zfxl_cbr2,
                Zfxl_bacc_map::$SendToCBRCount,
                Zfxl_bacc_map::$ffbzgl_zfxl_ld3,
                Zfxl_bacc_map::$SendToCBRJLDCount,
                Zfxl_bacc_map::$ffbzgl_zfxl_zg4,
                Zfxl_bacc_map::$SendToDDZDZGCount,
                Zfxl_bacc_map::$KP_SCORE,
                Zfxl_bacc_map::$KP_TRUE_SCORE,
                Zfxl_bacc_map::$cbr_qz
            ],
            substr($bacc_sql, 1)
        );
    }

    Efficiency::jsys_clear($mysqli_zxpg, $data_arr);
    if ($jsys_sql != '') {
        (new Table(Zfxl_jsys_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfxl_jsys_map::$name,
                Zfxl_jsys_map::$dadui,
                Zfxl_jsys_map::$XMBH,
                Zfxl_jsys_map::$GCMC,
                Zfxl_jsys_map::$XMZT,
                Zfxl_jsys_map::$overtime,
                Zfxl_jsys_map::$SLSJ,
                Zfxl_jsys_map::$CBR,
                Zfxl_jsys_map::$ffbzgl_zfxl_1,
                Zfxl_jsys_map::$CompleteTimeCount,
                Zfxl_jsys_map::$ffbzgl_zfxl_cbr2,
                Zfxl_jsys_map::$SendToCBRCount,
                Zfxl_jsys_map::$ffbzgl_zfxl_ld3,
                Zfxl_jsys_map::$SendToCBRJLDCount,
                Zfxl_jsys_map::$ffbzgl_zfxl_zg4,
                Zfxl_jsys_map::$SendToDDZDZGCount,
                Zfxl_jsys_map::$KP_SCORE,
                Zfxl_jsys_map::$KP_TRUE_SCORE,
                Zfxl_jsys_map::$cbr_qz
            ],
            substr($jsys_sql, 1)
        );
    }

    Efficiency::aqjc_clear($mysqli_zxpg, $data_arr);
    if ($aqjc_sql != '') {
        (new Table(Zfxl_aqjc_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfxl_aqjc_map::$name,
                Zfxl_aqjc_map::$dadui,
                Zfxl_aqjc_map::$XMBH,
                Zfxl_aqjc_map::$DWMC,
                Zfxl_aqjc_map::$JCQK,
                Zfxl_aqjc_map::$JCQX,
                Zfxl_aqjc_map::$OVERTIME,
                Zfxl_aqjc_map::$CBR,
                Zfxl_aqjc_map::$ffbzgl_zfxl_1,
                Zfxl_aqjc_map::$CompleteTimeCount,
                Zfxl_aqjc_map::$ffbzgl_zfxl_cbr2,
                Zfxl_aqjc_map::$SendToCBRCount,
                Zfxl_aqjc_map::$ffbzgl_zfxl_ld3,
                Zfxl_aqjc_map::$SendToCBRJLDCount,
                Zfxl_aqjc_map::$ffbzgl_zfxl_zg4,
                Zfxl_aqjc_map::$SendToDDZDZGCount,
                Zfxl_aqjc_map::$KP_SCORE,
                Zfxl_aqjc_map::$KP_TRUE_SCORE,
                Zfxl_aqjc_map::$cbr_qz
            ],
            substr($aqjc_sql, 1)
        );
    }

    Efficiency::hz_clear($mysqli_zxpg, $data_arr);
    if ($hz_sql != '') {
        (new Table(Zfxl_hz_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfxl_hz_map::$name,
                Zfxl_hz_map::$dadui,
                Zfxl_hz_map::$SJ,
                //new
                Zfxl_hz_map::$zfxl_xzqz,
                Zfxl_hz_map::$zfxl_xzqz_truescore,

                Zfxl_hz_map::$zfxl_jdjc,
                Zfxl_hz_map::$zfxl_jdjc_truescore,
                Zfxl_hz_map::$zfxl_hzdcc,
                Zfxl_hz_map::$zfxl_hzdc_truescore,
                Zfxl_hz_map::$zfxl_jsys,
                Zfxl_hz_map::$zfxl_jsys_truescore,
                Zfxl_hz_map::$zfxl_bacc,
                Zfxl_hz_map::$zfxl_bacc_truescore,
                Zfxl_hz_map::$zfxl_xzcf,
                Zfxl_hz_map::$zfxl_xzcf_truescore,

                Zfxl_hz_map::$zfxl_hz,
                Zfxl_hz_map::$jdjc_lxqz,
                Zfxl_hz_map::$jsys_lxqz,
                Zfxl_hz_map::$xzcf_lxqz,
                Zfxl_hz_map::$bacc_lxqz,
                Zfxl_hz_map::$hzdc_lxqz,
                //new
                Zfxl_hz_map::$xzqz_lxqz,

                Zfxl_hz_map::$hzdc_count,
                Zfxl_hz_map::$xzcf_count,
                Zfxl_hz_map::$bacc_count,
                Zfxl_hz_map::$jdjc_count,
                Zfxl_hz_map::$jsys_count,
                //new
                Zfxl_hz_map::$xzqz_count

            ],
            substr($hz_sql, 1)
        );
    }

    Efficiency::group_insert($mysqli_zxpg, $data_arr);
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