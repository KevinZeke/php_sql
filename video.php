<?php
/**
 * User: zhuangjiayu
 * Date: 2018/2/8
 * Time: 19:17
 */

require_once __DIR__ . '/Video/Video.php';
require_once __DIR__ . '/common/common.php';
require_once __DIR__ . '/map/Dadui_huizong_query_day.map.php';
Sql_tool::devopen();
//$data_arr = ['2017-01-01', '2018-02-08'];


//$sqltool_hazd = Sql_tool::build();
////质效跟踪数据库
//$sqltool_zxpg = Sql_tool::build(
//    'localhost', 'root', '123456', 'zxpg_gzpc_db'
//);


//efficiency($data_arr);
function video($mysqli_zxpg, $mysqli_hazd, $data_arr)
{
    $sqltool = Table_group::sqlTool_build($mysqli_zxpg);

    Video::$police_dd_map = get_police_dadui_map();

    Video::set_coef($sqltool);

    $dd_huizong_sql = '';

    $xzcf_sql = '';
    $bacc_sql = '';
    $hzdc_sql = '';
    $hzdc_hz_sql = '';
    $jsys_sql = '';
    $aqjc_sql = '';
    $jdjc_sql = '';
    $xzqz_sql = '';
    $hz_sql = '';

//$row_handle = function ($row, &$sql, $type) {
//
//};

    Video::count_xzcf_by_date($sqltool, $data_arr, function ($row) use (&$dd_huizong_sql, &$xzcf_sql, &$hz_sql) {
        Video::row_handel($row, $dd_huizong_sql, $xzcf_sql, $hz_sql, 'xzcf');
    });

    Video::count_jdjc_by_date($sqltool, $data_arr, function ($row) use (&$dd_huizong_sql, &$jdjc_sql, &$hz_sql) {
        Video::row_handel($row, $dd_huizong_sql, $jdjc_sql, $hz_sql, 'jdjc');
    });

    Video::count_xzqz_by_date($sqltool, $data_arr, function ($row) use (&$dd_huizong_sql, &$xzqz_sql, &$hz_sql) {
        Video::row_handel($row, $dd_huizong_sql, $xzqz_sql, $hz_sql, 'xzqz');
    });

    Video::count_hzdc_by_date($sqltool, $data_arr, function ($row) use (&$dd_huizong_sql, &$hzdc_sql, &$hz_sql) {
        Video::row_handel($row, $dd_huizong_sql, $hzdc_sql, $hz_sql, 'hzdc');
    });

    Video::count_hzdc_fh_by_date($sqltool, $data_arr, function ($row) use (&$dd_huizong_sql, &$hzdc_hz_sql, &$hz_sql) {
        Video::row_handel($row, $dd_huizong_sql, $hzdc_hz_sql, $hz_sql, 'hzdc_fh');
    });

    Video::count_shys_by_date($sqltool, $data_arr, function ($row) use (&$dd_huizong_sql, &$jsys_sql, &$hz_sql) {
        Video::row_handel($row, $dd_huizong_sql, $jsys_sql, $hz_sql, 'jsys');
    });

    Video::count_aqjc_by_date($sqltool, $data_arr, function ($row) use (&$dd_huizong_sql, &$aqjc_sql, &$hz_sql) {
        Video::row_handel($row, $dd_huizong_sql, $aqjc_sql, $hz_sql, 'aqjc');
    });

    Video::count_bacc_by_date($sqltool, $data_arr, function ($row) use (&$dd_huizong_sql, &$bacc_sql, &$hz_sql) {
        Video::row_handel($row, $dd_huizong_sql, $bacc_sql, $hz_sql, 'bacc');
    });

    Video::xzcf_clear($mysqli_zxpg, $data_arr);
    if ($xzcf_sql != '') {
        (new Table(Zfsp_xzcf_score_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfsp_xzcf_score_map::$name,
                Zfsp_xzcf_score_map::$dadui,
                Zfsp_xzcf_score_map::$xmbh,
                Zfsp_xzcf_score_map::$CFDX,
                Zfsp_xzcf_score_map::$BAQX,
                Zfsp_xzcf_score_map::$CJTIME,
                Zfsp_xzcf_score_map::$CFJG,
                Zfsp_xzcf_score_map::$OVERTIME,
                Zfsp_xzcf_score_map::$cbr,
                Zfsp_xzcf_score_map::$spsl,
                Zfsp_xzcf_score_map::$kp_score,
                Zfsp_xzcf_score_map::$kp_true_score,
                Zfsp_xzcf_score_map::$cbrqz,
            ],
            substr($xzcf_sql, 1)
        );
    }

    Video::jdjc_clear($mysqli_zxpg, $data_arr);
    if ($jdjc_sql != '') {
        (new Table(Zfsp_jdjc_score_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfsp_jdjc_score_map::$name,
                Zfsp_jdjc_score_map::$dadui,
                Zfsp_jdjc_score_map::$CBR,
                Zfsp_jdjc_score_map::$XMBH,
                Zfsp_jdjc_score_map::$OVERTIME,
                Zfsp_jdjc_score_map::$JCQX,
                Zfsp_jdjc_score_map::$JCQK,
                Zfsp_jdjc_score_map::$xmlx,
                Zfsp_jdjc_score_map::$DWMC,
                Zfsp_jdjc_score_map::$KP_SCORE,
                Zfsp_jdjc_score_map::$KP_TRUE_SCORE,
                Zfsp_jdjc_score_map::$SPSL,
                Zfsp_jdjc_score_map::$CBRQZ,
                Zfsp_jdjc_score_map::$ZLQZ
            ],
            substr($jdjc_sql, 1)
        );
    }

    Video::xzqz_clear($mysqli_zxpg, $data_arr);
    if ($xzqz_sql != '') {
        (new Table(Zfsp_xzqz_score_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfsp_xzqz_score_map::$name,
                Zfsp_xzqz_score_map::$dadui,
                Zfsp_xzqz_score_map::$CBR,
                Zfsp_xzqz_score_map::$XMBH,
                Zfsp_xzqz_score_map::$OVERTIME,
                Zfsp_xzqz_score_map::$JCQX,
                Zfsp_xzqz_score_map::$JCQK,
                Zfsp_xzqz_score_map::$xmlx,
                Zfsp_xzqz_score_map::$DWMC,
                Zfsp_xzqz_score_map::$KP_SCORE,
                Zfsp_xzqz_score_map::$KP_TRUE_SCORE,
                Zfsp_xzqz_score_map::$SPSL,
                Zfsp_xzqz_score_map::$CBRQZ,
                Zfsp_xzqz_score_map::$ZLQZ,
                Zfsp_xzqz_score_map::$sonType
            ],
            substr($xzqz_sql, 1)
        );
    }

    Video::hzdc_clear($mysqli_zxpg, $data_arr);
    if ($hzdc_sql != '') {
        (new Table(Zfsp_hzdc_score_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfsp_hzdc_score_map::$name,
                Zfsp_hzdc_score_map::$dadui,
                Zfsp_hzdc_score_map::$XMBH,
                Zfsp_hzdc_score_map::$xmlx,
                Zfsp_hzdc_score_map::$QHSJ,
                Zfsp_hzdc_score_map::$BJSJ,
                Zfsp_hzdc_score_map::$JZTIME,
                Zfsp_hzdc_score_map::$CLTIME,
                Zfsp_hzdc_score_map::$OVERTIME,
                Zfsp_hzdc_score_map::$Status,
                Zfsp_hzdc_score_map::$CBR,
                Zfsp_hzdc_score_map::$SPSL,
                Zfsp_hzdc_score_map::$KP_SCORE,
                Zfsp_hzdc_score_map::$KP_TRUE_SCORE,
                Zfsp_hzdc_score_map::$CBRQZ,
                Zfsp_hzdc_score_map::$ZLQZ
            ],
            substr($hzdc_sql, 1)
        );
    }
    if ($hzdc_hz_sql != '') {
        (new Table(Zfsp_hzdc_score_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfsp_hzdc_score_map::$name,
                Zfsp_hzdc_score_map::$dadui,
                Zfsp_hzdc_score_map::$XMBH,
                Zfsp_hzdc_score_map::$xmlx,
                Zfsp_hzdc_score_map::$QHSJ,
                Zfsp_hzdc_score_map::$BJSJ,
                Zfsp_hzdc_score_map::$JZTIME,
                Zfsp_hzdc_score_map::$CLTIME,
                Zfsp_hzdc_score_map::$OVERTIME,
                Zfsp_hzdc_score_map::$Status,
                Zfsp_hzdc_score_map::$CBR,
                Zfsp_hzdc_score_map::$SPSL,
                Zfsp_hzdc_score_map::$KP_SCORE,
                Zfsp_hzdc_score_map::$KP_TRUE_SCORE,
                Zfsp_hzdc_score_map::$CBRQZ,
                Zfsp_hzdc_score_map::$ZLQZ
            ],
            substr($hzdc_hz_sql, 1)
        );
    }

    Video::bacc_clear($mysqli_zxpg, $data_arr);
    if ($bacc_sql != '') {
        (new Table(Zfsp_bacc_score_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfsp_bacc_score_map::$name,
                Zfsp_bacc_score_map::$dadui,
                Zfsp_bacc_score_map::$CBR,
                Zfsp_bacc_score_map::$XMBH,
                Zfsp_bacc_score_map::$SLSJ,
                Zfsp_bacc_score_map::$XMJG,
                Zfsp_bacc_score_map::$GCMC,
                Zfsp_bacc_score_map::$JGYS,
                Zfsp_bacc_score_map::$KP_SCORE,
                Zfsp_bacc_score_map::$KP_TRUE_SCORE,
                Zfsp_bacc_score_map::$SPSL,
                Zfsp_bacc_score_map::$CBRQZ,
                Zfsp_bacc_score_map::$OVER_TIME
            ],
            substr($bacc_sql, 1)
        );
    }

    Video::jsys_clear($mysqli_zxpg, $data_arr);
    if ($jsys_sql != '') {
        (new Table(Zfsp_jsys_score_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfsp_jsys_score_map::$name,
                Zfsp_jsys_score_map::$dadui,
                Zfsp_jsys_score_map::$cbr,
                Zfsp_jsys_score_map::$xmbh,
                Zfsp_jsys_score_map::$gcmc,
                Zfsp_jsys_score_map::$xmzt,
                Zfsp_jsys_score_map::$slsj,
                Zfsp_jsys_score_map::$kp_score,
                Zfsp_jsys_score_map::$kp_true_score,
                Zfsp_jsys_score_map::$spsl,
                Zfsp_jsys_score_map::$cbrqz,
                Zfsp_jsys_score_map::$over_time
            ],
            substr($jsys_sql, 1)
        );
    }

    Video::aqjc_clear($mysqli_zxpg, $data_arr);
    if ($aqjc_sql != '') {
        (new Table(Zfsp_aqjc_score_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfsp_aqjc_score_map::$name,
                Zfsp_aqjc_score_map::$dadui,
                Zfsp_aqjc_score_map::$CBR,
                Zfsp_aqjc_score_map::$XMBH,
                Zfsp_aqjc_score_map::$xmlx,
                Zfsp_aqjc_score_map::$DWMC,
                Zfsp_aqjc_score_map::$JCQX,
                Zfsp_aqjc_score_map::$JCQK,
                Zfsp_aqjc_score_map::$KP_SCORE,
                Zfsp_aqjc_score_map::$KP_TRUE_SCORE,
                Zfsp_aqjc_score_map::$SPSL,
                Zfsp_aqjc_score_map::$CBRQZ,
                Zfsp_aqjc_score_map::$ZLQZ,
                Zfsp_aqjc_score_map::$OVERTIME
            ],
            substr($aqjc_sql, 1)
        );
    }

    Video::hz_clear($mysqli_zxpg, $data_arr);
    if ($hz_sql != '') {
        (new Table(Zfsp_hz_map::$table_name, Table_group::sqlTool_build($mysqli_zxpg)))->multi_insert(
            [
                Zfsp_hz_map::$name,
                Zfsp_hz_map::$dd_name,
                Zfsp_hz_map::$SJ,

                Zfsp_hz_map::$zfsp_xzqz,
                Zfsp_hz_map::$zfsp_xzqz_truescore,

                Zfsp_hz_map::$zfsp_jdjc,
                Zfsp_hz_map::$zfsp_jdjc_truescore,
                Zfsp_hz_map::$zfsp_hzdcc,
                Zfsp_hz_map::$zfsp_hzdc_truescore,
                Zfsp_hz_map::$zfsp_jsys,
                Zfsp_hz_map::$zfsp_jsys_truescore,
                Zfsp_hz_map::$zfsp_bacc,
                Zfsp_hz_map::$zfsp_bacc_truescore,
                Zfsp_hz_map::$zfsp_xzcf,
                Zfsp_hz_map::$zfsp_xzcf_truescore,
                Zfsp_hz_map::$zfsp_hz,

                Zfsp_hz_map::$jdjc_lxqz,
                Zfsp_hz_map::$jsys_lxqz,
                Zfsp_hz_map::$xzcf_lxqz,
                Zfsp_hz_map::$bacc_lxqz,
                Zfsp_hz_map::$hzdc_lxqz,
                Zfsp_hz_map::$xzqz_lxqz,

                Zfsp_hz_map::$jdjc_count,
                Zfsp_hz_map::$jsys_count,
                Zfsp_hz_map::$xzcf_count,
                Zfsp_hz_map::$bacc_count,
                Zfsp_hz_map::$hzdc_count,
                Zfsp_hz_map::$xzqz_count

            ],
            substr($hz_sql, 1)
        );
    }

    Video::sp_insert($sqltool);

    if ($dd_huizong_sql == '')
        return 0;
    (new Table(Dadui_huizong_query_day_map::$table_name, Table_group::sqlTool_build($mysqli_hazd)))->multi_insert(
        [
            Dadui_huizong_query_day_map::$video_score,
            Dadui_huizong_query_day_map::$video_count,
            Dadui_huizong_query_day_map::$year_month_show,
            Dadui_huizong_query_day_map::$dd_name,
            Dadui_huizong_query_day_map::$police_name
        ],
        substr($dd_huizong_sql, 1)
    );
    return Video::group_insert($mysqli_zxpg, $data_arr);
}