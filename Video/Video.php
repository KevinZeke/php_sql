<?php
/**
 * @author: zhuangjiayu
 * Date: 2018/2/8
 * Time: 18:50
 */

require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/../Quantity/Table_gropu.php';
require_once __DIR__ . '/../map/Field_map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_xzcf.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_hzdc.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_bacc.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_aqjc.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_shys.map.php';
require_once __DIR__ . '/../map/Gzpc_xmxx_jdjc.map.php';
require_once __DIR__ . '/../map/Kpdf_glsp_aqjc.map.php';
require_once __DIR__ . '/../map/Kpdf_glsp_jsys.map.php';
require_once __DIR__ . '/../map/Kpdf_glsp_bacc.map.php';
require_once __DIR__ . '/../map/Kpdf_glsp_hzdc.map.php';
require_once __DIR__ . '/../map/Kpdf_glsp_jdjc.map.php';
require_once __DIR__ . '/../map/Kpdf_glsp_xzcf.map.php';
require_once __DIR__ . '/../map/Zfsp_bacc_score.map.php';
require_once __DIR__ . '/../map/Zfsp_bacc_sp.map.php';
require_once __DIR__ . '/../map/Zfsp_xzcf_score.map.php';
require_once __DIR__ . '/../map/Zfsp_xzcf_sp.map.php';
require_once __DIR__ . '/../map/Zfsp_hzdc_score.map.php';
require_once __DIR__ . '/../map/Zfsp_hzdc_sp.map.php';
require_once __DIR__ . '/../map/Zfsp_jsys_score.map.php';
require_once __DIR__ . '/../map/Zfsp_jsys_sp.map.php';
require_once __DIR__ . '/../map/Zfsp_jdjc_score.map.php';
require_once __DIR__ . '/../map/Zfsp_jdjc_sp.map.php';
require_once __DIR__ . '/../map/Zfsp_aqjc_score.map.php';
require_once __DIR__ . '/../map/Zfsp_xzqz_score.map.php';
require_once __DIR__ . '/../map/Zfsp_aqjc_sp.map.php';
require_once __DIR__ . '/../map/Zfsp_hz.map.php';

class Video extends Table_group
{

    public static $police_dd_map;

    public static $videos = [];

    public static $sql_tool = null;

    public static function row_handel($row, &$dd_hz_sql, &$item_sql, &$sp_hz_sql, $type)
    {
//        $sqltool_zxpg = Sql_tool::build(
//            'localhost', 'root', '123456', 'zxpg_gzpc_db'
//        );
//        $item_coef = $sqltool_zxpg->execute_dql_res(
//            'SELECT xzcf,jdjc,hzdc,bacc,jsys FROM `qz_zfsp`'
//        )->fetch();
//        $sqltool_zxpg->close();
//        $type = ($type == 'hzdc_fh' ? 'hzdc' : $type);
        if (!$row[Field_map::$director] || $row[Field_map::$director] == '') return;
        $directors = Table_group::format_zhu_xie($row[Field_map::$director]);
        $param = '';
        if (array_key_exists(Field_map::$hz_type, $row)) {
            $param = $row[Field_map::$hz_type];
        } elseif (array_key_exists(Field_map::$proeject_type, $row)) {
            $param = $row[Field_map::$proeject_type];
        }
        if (array_key_exists(Field_map::$son_type, $row)) {
            $son = $row[Field_map::$son_type];
        } else {
            $son = '';
        }
        $score = self::coef_count(
            $type == 'hzdc_fh' ? 'hzdc' : $type,
            $row[Field_map::$item_total_score],
            $param, $son
        );
        $lx_coef = Video::field_coef_get(
            $type == 'hzdc_fh' ? 'hzdc' : $type,
            $param, $son
        );
        $dd = array_key_exists($directors->zhu, self::$police_dd_map) ? self::$police_dd_map[$directors->zhu] : '';
        $lx_coef['type'] = $type;

        self::change_type($row);

        /**
         *******
         * 主办人
         *******
         */
        $dd_hz_sql .= Sql_tool::format_insert_value([
            $score['zhu'] * self::$coef[$type == 'hzdc_fh' ? 'hzdc' : $type],
            '1',
            Sql_tool::QUOTE($row[Field_map::$over_time]),
            Sql_tool::QUOTE($dd),
            Sql_tool::QUOTE($directors->zhu)
        ]);
        $videos_num = self::videos_count(
            $type,
            $row[Field_map::$taskId]
        );
        if ($type == 'xzcf') {
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu),//Zfsp_xzcf_score_map::$name,
                Sql_tool::QUOTE($dd),//Zfsp_xzcf_score_map::$dadui,
                Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_xzcf_score_map::$XMBH,
                Sql_tool::QUOTE($row[Field_map::$unit_name]),//Zfsp_xzcf_score_map::$CFDX,
                Sql_tool::QUOTE($row[Field_map::$time_limit]),//Zfsp_xzcf_score_map::$BAQX,
                Sql_tool::QUOTE($row[Field_map::$cj_time]), //Zfsp_xzcf_score_map::$CJTIME,
                Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_xzcf_score_map::$CFJG,
                Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfsp_xzcf_score_map::$OVERTIME,
                Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_xzcf_score_map::$cbr,
                $videos_num,//Zfsp_xzcf_score_map::$spsl,
                $row[Field_map::$item_total_score], //s
                $score['zhu'],                     //true s
                $lx_coef['zhu']
            ]);
            $sp_hz_sql .= Sql_tool::format_insert_value(
                [
                    Sql_tool::QUOTE($directors->zhu),
                    Sql_tool::QUOTE($dd),
                    Sql_tool::QUOTE($row[Field_map::$over_time]),
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    $score['zhu'],                                          //s
                    $score['zhu'] * self::$coef['xzcf'],
                    $score['zhu'] * self::$coef['xzcf'],
                    self::$coef['jdjc'],//Zfsp_hz_map::$jdjc_lxqz,
                    self::$coef['jsys'],//Zfsp_hz_map::$jsys_lxqz,
                    self::$coef['xzcf'],//Zfsp_hz_map::$xzcf_lxqz,
                    self::$coef['bacc'],//Zfsp_hz_map::$bacc_lxqz,
                    self::$coef['hzdc'],//Zfsp_hz_map::$hzdc_lxqz
                    self::$coef['xzqz']//Zfsp_hz_map::$hzdc_lxqz
                    ,
                    0,//Zfsp_hz_map::$jdjc_count,
                    0,//Zfsp_hz_map::$jsys_count,
                    1,//Zfsp_hz_map::$xzcf_count,
                    0,//Zfsp_hz_map::$bacc_count,
                    0,//Zfsp_hz_map::$hzdc_count
                    0,//Zfsp_hz_map::$hzdc_count
                ]
            );
        }
        if ($type == 'jdjc') {
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu),//Zfsp_jdjc_score_map::$name,
                Sql_tool::QUOTE($dd),//Zfsp_jdjc_score_map::$dadui,
                Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_jdjc_score_map::$CBR,
                Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_jdjc_score_map::$XMBH,
                Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfsp_jdjc_score_map::$OVERTIME,
                Sql_tool::QUOTE($row[Field_map::$time_limit]),//Zfsp_jdjc_score_map::$JCQX,
                Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_jdjc_score_map::$JCQK,
                Sql_tool::QUOTE($row[Field_map::$proeject_type]),//Zfsp_jdjc_score_map::$xmlx,
                Sql_tool::QUOTE($row[Field_map::$unit_name]),
                $row[Field_map::$item_total_score],//Zfsp_jdjc_score_map::$KP_SCORE,
                $score['zhu'],//Zfsp_jdjc_score_map::$KP_TRUE_SCORE,
                $videos_num,//Zfsp_jdjc_score_map::$SPSL,
                $lx_coef['zhu'],//Zfsp_jdjc_score_map::$CBRQZ,
                $lx_coef['zl']//Zfsp_jdjc_score_map::$ZLQZ
            ]);
            $sp_hz_sql .= Sql_tool::format_insert_value(
                [
                    Sql_tool::QUOTE($directors->zhu),
                    Sql_tool::QUOTE($dd),
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                    0,
                    0,
                    $score['zhu'],  //Zfxl_hz_map::$zfxl_jdjc,
                    $score['zhu'] * self::$coef['jdjc'],//Zfxl_hz_map::$zfxl_jdjc_truescore,
                    0,//Zfxl_hz_map::$zfxl_hzdcc,
                    0,//Zfxl_hz_map::$zfxl_hzdc_truescore,
                    0,//Zfxl_hz_map::$zfxl_jsys,
                    0,//Zfxl_hz_map::$zfxl_jsys_truescore,
                    0,//Zfxl_hz_map::$zfxl_bacc,
                    0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                    0,//Zfxl_hz_map::$zfxl_xzcf,
                    0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                    $score['zhu'] * self::$coef['jdjc'],
                    self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                    self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                    self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                    self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                    self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                    self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                    ,
                    1,//Zfsp_hz_map::$jdjc_count,
                    0,//Zfsp_hz_map::$jsys_count,
                    0,//Zfsp_hz_map::$xzcf_count,
                    0,//Zfsp_hz_map::$bacc_count,
                    0,//Zfsp_hz_map::$hzdc_count
                    0,//Zfsp_hz_map::$hzdc_count
                ]
            );
        }
        if ($type == 'xzqz') {
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu),//Zfsp_jdjc_score_map::$name,
                Sql_tool::QUOTE($dd),//Zfsp_jdjc_score_map::$dadui,
                Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_jdjc_score_map::$CBR,
                Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_jdjc_score_map::$XMBH,
                Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfsp_jdjc_score_map::$OVERTIME,
                Sql_tool::QUOTE($row[Field_map::$time_limit]),//Zfsp_jdjc_score_map::$JCQX,
                Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_jdjc_score_map::$JCQK,
                Sql_tool::QUOTE($row[Field_map::$proeject_type]),//Zfsp_jdjc_score_map::$xmlx,
                Sql_tool::QUOTE($row[Field_map::$unit_name]),
                $row[Field_map::$item_total_score],//Zfsp_jdjc_score_map::$KP_SCORE,
                $score['zhu'],//Zfsp_jdjc_score_map::$KP_TRUE_SCORE,
                $videos_num,//Zfsp_jdjc_score_map::$SPSL,
                $lx_coef['zhu'],//Zfsp_jdjc_score_map::$CBRQZ,
                $lx_coef['zl'],//Zfsp_jdjc_score_map::$ZLQZ
                Sql_tool::QUOTE($son)
            ]);
            $sp_hz_sql .= Sql_tool::format_insert_value(
                [
                    Sql_tool::QUOTE($directors->zhu),
                    Sql_tool::QUOTE($dd),
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                    $score['zhu'],  //Zfxl_hz_map::$zfxl_jdjc,
                    $score['zhu'] * self::$coef['xzqz'],//Zfxl_hz_map::$zfxl_jdjc_truescore,
                    0,
                    0,
                    0,//Zfxl_hz_map::$zfxl_hzdcc,
                    0,//Zfxl_hz_map::$zfxl_hzdc_truescore,
                    0,//Zfxl_hz_map::$zfxl_jsys,
                    0,//Zfxl_hz_map::$zfxl_jsys_truescore,
                    0,//Zfxl_hz_map::$zfxl_bacc,
                    0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                    0,//Zfxl_hz_map::$zfxl_xzcf,
                    0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                    $score['zhu'] * self::$coef['xzqz'],
                    self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                    self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                    self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                    self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                    self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                    self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                    ,
                    0,//Zfsp_hz_map::$jdjc_count,
                    0,//Zfsp_hz_map::$jsys_count,
                    0,//Zfsp_hz_map::$xzcf_count,
                    0,//Zfsp_hz_map::$bacc_count,
                    0,//Zfsp_hz_map::$hzdc_count
                    1,//Zfsp_hz_map::$hzdc_count
                ]
            );
        }
        if ($type == 'hzdc') {
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu),
                Sql_tool::QUOTE($dd),
                Sql_tool::QUOTE($row[Field_map::$taskId]),
                Sql_tool::QUOTE($row[Q_field::$hz_type]),
                Sql_tool::QUOTE($row[Q_field::$hz_fire_object]),
                Sql_tool::QUOTE($row[Q_field::$hz_call_time]),
                Sql_tool::QUOTE($row[Q_field::$hz_end_date]),
                Sql_tool::QUOTE($row[Q_field::$hz_handel_date]),
                Sql_tool::QUOTE($row[Q_field::$over_time]),
                Sql_tool::QUOTE($row[Q_field::$hz_now_status]),
                Sql_tool::QUOTE($row[Field_map::$director]),
                $videos_num,
                Sql_tool::QUOTE($row[Q_field::$item_total_score]),
                $score['zhu'],
                $lx_coef['zhu'],
                $lx_coef['zl']
            ]);
            $sp_hz_sql .= Sql_tool::format_insert_value(
                [
                    Sql_tool::QUOTE($directors->zhu),
                    Sql_tool::QUOTE($dd),
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                    0,
                    0,
                    0, //Zfxl_hz_map::$zfxl_jdjc,
                    0,//Zfxl_hz_map::$zfxl_jdjc_truescore,
                    $score['zhu'],//Zfxl_hz_map::$zfxl_hzdcc,
                    $score['zhu'] * self::$coef['hzdc'],//Zfxl_hz_map::$zfxl_hzdc_truescore,
                    0,//Zfxl_hz_map::$zfxl_jsys,
                    0,//Zfxl_hz_map::$zfxl_jsys_truescore,
                    0,//Zfxl_hz_map::$zfxl_bacc,
                    0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                    0,//Zfxl_hz_map::$zfxl_xzcf,
                    0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                    $score['zhu'] * self::$coef['hzdc'],
                    self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                    self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                    self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                    self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                    self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                    self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                    ,
                    0,//Zfsp_hz_map::$jdjc_count,
                    0,//Zfsp_hz_map::$jsys_count,
                    0,//Zfsp_hz_map::$xzcf_count,
                    0,//Zfsp_hz_map::$bacc_count,
                    1,//Zfsp_hz_map::$hzdc_count
                    0//Zfsp_hz_map::$hzdc_count
                ]
            );
        }
        if ($type == 'hzdc_fh') {
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu),
                Sql_tool::QUOTE($dd),
                Sql_tool::QUOTE($row[Field_map::$taskId] . ';原项目id:' . $row[Q_field::$old_taskId]),
                Sql_tool::QUOTE($row[Q_field::$hz_type]),
                Sql_tool::QUOTE($row[Q_field::$hz_fire_object]),
                Sql_tool::QUOTE($row[Q_field::$hz_call_time]),
                '0000-00-00',
                Sql_tool::QUOTE($row[Q_field::$hz_handel_date]),
                Sql_tool::QUOTE($row[Q_field::$over_time]),
                Sql_tool::QUOTE($row[Q_field::$hz_now_status]),
                Sql_tool::QUOTE($row[Field_map::$director]),
                $videos_num,
                Sql_tool::QUOTE($row[Q_field::$item_total_score]),
                $score['zhu'],
                $lx_coef['zhu'],
                $lx_coef['zl']
            ]);
            $sp_hz_sql .= Sql_tool::format_insert_value(
                [
                    Sql_tool::QUOTE($directors->zhu),
                    Sql_tool::QUOTE($dd),
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                    0,
                    0,
                    0, //Zfxl_hz_map::$zfxl_jdjc,
                    0,//Zfxl_hz_map::$zfxl_jdjc_truescore,
                    $score['zhu'],//Zfxl_hz_map::$zfxl_hzdcc,
                    $score['zhu'] * self::$coef['hzdc'],//Zfxl_hz_map::$zfxl_hzdc_truescore,
                    0,//Zfxl_hz_map::$zfxl_jsys,
                    0,//Zfxl_hz_map::$zfxl_jsys_truescore,
                    0,//Zfxl_hz_map::$zfxl_bacc,
                    0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                    0,//Zfxl_hz_map::$zfxl_xzcf,
                    0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                    $score['zhu'] * self::$coef['hzdc'],
                    self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                    self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                    self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                    self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                    self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                    self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                    ,
                    0,//Zfsp_hz_map::$jdjc_count,
                    0,//Zfsp_hz_map::$jsys_count,
                    0,//Zfsp_hz_map::$xzcf_count,
                    0,//Zfsp_hz_map::$bacc_count,
                    1,//Zfsp_hz_map::$hzdc_count
                    0//Zfsp_hz_map::$hzdc_count
                ]
            );
        }
        if ($type == 'bacc') {
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu),//Zfsp_bacc_score_map::$name,
                Sql_tool::QUOTE($dd),//Zfsp_bacc_score_map::$dadui,
                Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_bacc_score_map::$CBR,
                Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_bacc_score_map::$XMBH,
                Sql_tool::QUOTE($row[Field_map::$create_time]),//Zfsp_bacc_score_map::$SLSJ,
                Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_bacc_score_map::$XMJG,
                Sql_tool::QUOTE($row[Field_map::$task_name]),//Zfsp_bacc_score_map::$GCMC,
                Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfsp_bacc_score_map::$JGYS,
                $row[Field_map::$item_total_score],//Zfsp_bacc_score_map::$KP_SCORE,
                $score['zhu'],//Zfsp_bacc_score_map::$KP_TRUE_SCORE,
                $videos_num,//Zfsp_bacc_score_map::$SPSL,
                $lx_coef['zhu'],//Zfsp_bacc_score_map::$CBRQZ
                Sql_tool::QUOTE($row[Field_map::$over_time])
            ]);
            $sp_hz_sql .= Sql_tool::format_insert_value(
                [
                    Sql_tool::QUOTE($directors->zhu),
                    Sql_tool::QUOTE($dd),
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                    0,
                    0,
                    0, //Zfxl_hz_map::$zfxl_jdjc,
                    0,//Zfxl_hz_map::$zfxl_jdjc_truescore,
                    0,//Zfxl_hz_map::$zfxl_hzdcc,
                    0,//Zfxl_hz_map::$zfxl_hzdc_truescore,
                    0,//Zfxl_hz_map::$zfxl_jsys,
                    0,//Zfxl_hz_map::$zfxl_jsys_truescore,
                    $score['zhu'],//Zfxl_hz_map::$zfxl_bacc,
                    $score['zhu'] * self::$coef['bacc'],//Zfxl_hz_map::$zfxl_bacc_truescore,
                    0,//Zfxl_hz_map::$zfxl_xzcf,
                    0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                    $score['zhu'] * self::$coef['bacc'],
                    self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                    self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                    self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                    self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                    self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                    self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                    ,
                    0,//Zfsp_hz_map::$jdjc_count,
                    0,//Zfsp_hz_map::$jsys_count,
                    0,//Zfsp_hz_map::$xzcf_count,
                    1,//Zfsp_hz_map::$bacc_count,
                    0,//Zfsp_hz_map::$hzdc_count
                    0//Zfsp_hz_map::$hzdc_count
                ]
            );
        }
        if ($type == 'jsys') {
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu),//Zfsp_jsys_score_map::$name,
                Sql_tool::QUOTE($dd),//Zfsp_jsys_score_map::$dadui,
                Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_jsys_score_map::$cbr,
                Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_jsys_score_map::$xmbh,
                Sql_tool::QUOTE($row[Field_map::$unit_name]),//Zfsp_jsys_score_map::$gcmc,
                Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_jsys_score_map::$xmzt,
                Sql_tool::QUOTE($row[Field_map::$create_time]),//Zfsp_jsys_score_map::$slsj,
                Sql_tool::QUOTE($row[Field_map::$item_total_score]),//Zfsp_jsys_score_map::$kp_score,
                $score['zhu'],//Zfsp_jsys_score_map::$kp_true_score,
                $videos_num,//Zfsp_jsys_score_map::$spsl,
                $lx_coef['zhu'],//Zfsp_jsys_score_map::$cbrqz,
                Sql_tool::QUOTE($row[Field_map::$over_time])//Zfsp_jsys_score_map::$over_time
            ]);
            $sp_hz_sql .= Sql_tool::format_insert_value(
                [
                    Sql_tool::QUOTE($directors->zhu),
                    Sql_tool::QUOTE($dd),
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                    0,
                    0,
                    0, //Zfxl_hz_map::$zfxl_jdjc,
                    0,//Zfxl_hz_map::$zfxl_jdjc_truescore,
                    0,//Zfxl_hz_map::$zfxl_hzdcc,
                    0,//Zfxl_hz_map::$zfxl_hzdc_truescore,
                    $score['zhu'],//Zfxl_hz_map::$zfxl_jsys,
                    $score['zhu'] * self::$coef['jsys'],//Zfxl_hz_map::$zfxl_jsys_truescore,
                    0,//Zfxl_hz_map::$zfxl_bacc,
                    0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                    0,//Zfxl_hz_map::$zfxl_xzcf,
                    0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                    $score['zhu'] * self::$coef['jsys'],
                    self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                    self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                    self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                    self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                    self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                    self::$coef['xzqz'],//Zfxl_hz_map::$hzdc_lxqz
                    0,//Zfsp_hz_map::$jdjc_count,
                    1,//Zfsp_hz_map::$jsys_count,
                    0,//Zfsp_hz_map::$xzcf_count,
                    0,//Zfsp_hz_map::$bacc_count,
                    0//Zfsp_hz_map::$hzdc_count
                    ,
                    0//Zfsp_hz_map::$hzdc_count
                ]
            );
        }
        if ($type == 'aqjc') {
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu),//Zfsp_aqjc_score_map::$name,
                Sql_tool::QUOTE($dd),//Zfsp_aqjc_score_map::$dadui,
                Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_aqjc_score_map::$CBR,
                Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_aqjc_score_map::$XMBH,
                Sql_tool::QUOTE($row[Field_map::$proeject_type]),//Zfsp_aqjc_score_map::$xmlx,
                Sql_tool::QUOTE($row[Field_map::$unit_name]),//Zfsp_aqjc_score_map::$DWMC,
                Sql_tool::QUOTE($row[Field_map::$time_limit]),//Zfsp_aqjc_score_map::$JCQX,
                Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_aqjc_score_map::$JCQK,
                Sql_tool::QUOTE($row[Field_map::$item_total_score]),//Zfsp_aqjc_score_map::$KP_SCORE,
                $score['zhu'],//Zfsp_aqjc_score_map::$KP_TRUE_SCORE,
                $videos_num,//Zfsp_aqjc_score_map::$SPSL,
                $lx_coef['zhu'],//Zfsp_aqjc_score_map::$CBRQZ,
                1,//Zfsp_aqjc_score_map::$ZLQZ,
                Sql_tool::QUOTE($row[Field_map::$over_time])//Zfsp_aqjc_score_map::$OVERTIME
            ]);
            $sp_hz_sql .= Sql_tool::format_insert_value(
                [
                    Sql_tool::QUOTE($directors->zhu),
                    Sql_tool::QUOTE($dd),
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                    0,
                    0,
                    0, //Zfxl_hz_map::$zfxl_jdjc,
                    0,//Zfxl_hz_map::$zfxl_jdjc_truescore,
                    0,//Zfxl_hz_map::$zfxl_hzdcc,
                    0,//Zfxl_hz_map::$zfxl_hzdc_truescore,
                    $score['zhu'],//Zfxl_hz_map::$zfxl_jsys,
                    $score['zhu'] * self::$coef['jsys'],//Zfxl_hz_map::$zfxl_jsys_truescore,
                    0,//Zfxl_hz_map::$zfxl_bacc,
                    0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                    0,//Zfxl_hz_map::$zfxl_xzcf,
                    0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                    $score['zhu'] * self::$coef['jsys'],
                    self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                    self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                    self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                    self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                    self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                    self::$coef['xzqz'],//Zfxl_hz_map::$hzdc_lxqz
                    0,//Zfsp_hz_map::$jdjc_count,
                    1,//Zfsp_hz_map::$jsys_count,
                    0,//Zfsp_hz_map::$xzcf_count,
                    0,//Zfsp_hz_map::$bacc_count,
                    0,//Zfsp_hz_map::$hzdc_count
                    0,//Zfsp_hz_map::$hzdc_count
                ]
            );
        }

        /**
         *******
         * 协办人
         *******
         */
        foreach ($directors->xie as $name) {
            $dd = array_key_exists($name, self::$police_dd_map) ? self::$police_dd_map[$name] : '';
            $dd_hz_sql .= Sql_tool::format_insert_value([
                $score['xie'] * self::$coef[$type == 'hzdc_fh' ? 'hzdc' : $type],
                '1',
                Sql_tool::QUOTE($row[Field_map::$over_time]),
                Sql_tool::QUOTE($dd),
                Sql_tool::QUOTE($name)
            ]);
            if ($type == 'xzcf') {
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name),//Zfsp_xzcf_score_map::$name,
                    Sql_tool::QUOTE($dd),//Zfsp_xzcf_score_map::$dadui,
                    Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_xzcf_score_map::$XMBH,
                    Sql_tool::QUOTE($row[Field_map::$unit_name]),//Zfsp_xzcf_score_map::$CFDX,
                    Sql_tool::QUOTE($row[Field_map::$time_limit]),//Zfsp_xzcf_score_map::$BAQX,
                    Sql_tool::QUOTE($row[Field_map::$cj_time]), //Zfsp_xzcf_score_map::$CJTIME,
                    Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_xzcf_score_map::$CFJG,
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfsp_xzcf_score_map::$OVERTIME,
                    Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_xzcf_score_map::$cbr,
                    $videos_num,//Zfsp_xzcf_score_map::$spsl,
                    $row[Field_map::$item_total_score], //s
                    $score['xie'],                     //true s
                    $lx_coef['xie']
                ]);
                $sp_hz_sql .= Sql_tool::format_insert_value(
                    [
                        Sql_tool::QUOTE($name),
                        Sql_tool::QUOTE($dd),
                        Sql_tool::QUOTE($row[Field_map::$over_time]),
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        $score['xie'],                                          //s
                        $score['xie'] * self::$coef['xzcf'],
                        $score['xie'] * self::$coef['xzcf'],
                        self::$coef['jdjc'],//Zfsp_hz_map::$jdjc_lxqz,
                        self::$coef['jsys'],//Zfsp_hz_map::$jsys_lxqz,
                        self::$coef['xzcf'],//Zfsp_hz_map::$xzcf_lxqz,
                        self::$coef['bacc'],//Zfsp_hz_map::$bacc_lxqz,
                        self::$coef['hzdc'],//Zfsp_hz_map::$hzdc_lxqz
                        self::$coef['xzqz']//Zfsp_hz_map::$hzdc_lxqz
                        ,
                        0,//Zfsp_hz_map::$jdjc_count,
                        0,//Zfsp_hz_map::$jsys_count,
                        1,//Zfsp_hz_map::$xzcf_count,
                        0,//Zfsp_hz_map::$bacc_count,
                        0,//Zfsp_hz_map::$hzdc_count
                        0,//Zfsp_hz_map::$hzdc_count
                    ]
                );
            }
            if ($type == 'jdjc') {
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name),//Zfsp_jdjc_score_map::$name,
                    Sql_tool::QUOTE($dd),//Zfsp_jdjc_score_map::$dadui,
                    Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_jdjc_score_map::$CBR,
                    Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_jdjc_score_map::$XMBH,
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfsp_jdjc_score_map::$OVERTIME,
                    Sql_tool::QUOTE($row[Field_map::$time_limit]),//Zfsp_jdjc_score_map::$JCQX,
                    Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_jdjc_score_map::$JCQK,
                    Sql_tool::QUOTE($row[Field_map::$proeject_type]),//Zfsp_jdjc_score_map::$xmlx,
                    Sql_tool::QUOTE($row[Field_map::$unit_name]),
                    $row[Field_map::$item_total_score],//Zfsp_jdjc_score_map::$KP_SCORE,
                    $score['xie'],//Zfsp_jdjc_score_map::$KP_TRUE_SCORE,
                    $videos_num,//Zfsp_jdjc_score_map::$SPSL,
                    $lx_coef['xie'],//Zfsp_jdjc_score_map::$CBRQZ,
                    $lx_coef['zl']//Zfsp_jdjc_score_map::$ZLQZ
                ]);
                $sp_hz_sql .= Sql_tool::format_insert_value(
                    [
                        Sql_tool::QUOTE($name),
                        Sql_tool::QUOTE($dd),
                        Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                        0,
                        0,
                        $score['xie'],  //Zfxl_hz_map::$zfxl_jdjc,
                        $score['xie'] * self::$coef['jdjc'],//Zfxl_hz_map::$zfxl_jdjc_truescore,
                        0,//Zfxl_hz_map::$zfxl_hzdcc,
                        0,//Zfxl_hz_map::$zfxl_hzdc_truescore,
                        0,//Zfxl_hz_map::$zfxl_jsys,
                        0,//Zfxl_hz_map::$zfxl_jsys_truescore,
                        0,//Zfxl_hz_map::$zfxl_bacc,
                        0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                        0,//Zfxl_hz_map::$zfxl_xzcf,
                        0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                        $score['xie'] * self::$coef['jdjc'],
                        self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                        self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                        self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                        self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                        self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                        self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                        ,
                        1,//Zfsp_hz_map::$jdjc_count,
                        0,//Zfsp_hz_map::$jsys_count,
                        0,//Zfsp_hz_map::$xzcf_count,
                        0,//Zfsp_hz_map::$bacc_count,
                        0,//Zfsp_hz_map::$hzdc_count
                        0,//Zfsp_hz_map::$hzdc_count
                    ]
                );
            }
            if ($type == 'xzqz') {
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name),//Zfsp_jdjc_score_map::$name,
                    Sql_tool::QUOTE($dd),//Zfsp_jdjc_score_map::$dadui,
                    Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_jdjc_score_map::$CBR,
                    Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_jdjc_score_map::$XMBH,
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfsp_jdjc_score_map::$OVERTIME,
                    Sql_tool::QUOTE($row[Field_map::$time_limit]),//Zfsp_jdjc_score_map::$JCQX,
                    Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_jdjc_score_map::$JCQK,
                    Sql_tool::QUOTE($row[Field_map::$proeject_type]),//Zfsp_jdjc_score_map::$xmlx,
                    Sql_tool::QUOTE($row[Field_map::$unit_name]),
                    $row[Field_map::$item_total_score],//Zfsp_jdjc_score_map::$KP_SCORE,
                    $score['xie'],//Zfsp_jdjc_score_map::$KP_TRUE_SCORE,
                    $videos_num,//Zfsp_jdjc_score_map::$SPSL,
                    $lx_coef['xie'],//Zfsp_jdjc_score_map::$CBRQZ,
                    $lx_coef['zl']//Zfsp_jdjc_score_map::$ZLQZ
                    ,
                    Sql_tool::QUOTE($son)

                ]);
                $sp_hz_sql .= Sql_tool::format_insert_value(
                    [
                        Sql_tool::QUOTE($name),
                        Sql_tool::QUOTE($dd),
                        Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                        $score['xie'],  //Zfxl_hz_map::$zfxl_jdjc,
                        $score['xie'] * self::$coef['xzqz'],//Zfxl_hz_map::$zfxl_jdjc_truescore,
                        0,
                        0,
                        0,//Zfxl_hz_map::$zfxl_hzdcc,
                        0,//Zfxl_hz_map::$zfxl_hzdc_truescore,
                        0,//Zfxl_hz_map::$zfxl_jsys,
                        0,//Zfxl_hz_map::$zfxl_jsys_truescore,
                        0,//Zfxl_hz_map::$zfxl_bacc,
                        0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                        0,//Zfxl_hz_map::$zfxl_xzcf,
                        0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                        $score['xie'] * self::$coef['xzqz'],
                        self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                        self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                        self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                        self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                        self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                        self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                        ,
                        0,//Zfsp_hz_map::$jdjc_count,
                        0,//Zfsp_hz_map::$jsys_count,
                        0,//Zfsp_hz_map::$xzcf_count,
                        0,//Zfsp_hz_map::$bacc_count,
                        0,//Zfsp_hz_map::$hzdc_count
                        1//Zfsp_hz_map::$hzdc_count
                    ]
                );
            }
            if ($type == 'hzdc') {
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name),
                    Sql_tool::QUOTE($dd),
                    Sql_tool::QUOTE($row[Field_map::$taskId]),
                    Sql_tool::QUOTE($row[Q_field::$hz_type]),
                    Sql_tool::QUOTE($row[Q_field::$hz_fire_object]),
                    Sql_tool::QUOTE($row[Q_field::$hz_call_time]),
                    Sql_tool::QUOTE($row[Q_field::$hz_end_date]),
                    Sql_tool::QUOTE($row[Q_field::$hz_handel_date]),
                    Sql_tool::QUOTE($row[Q_field::$over_time]),
                    Sql_tool::QUOTE($row[Q_field::$hz_now_status]),
                    Sql_tool::QUOTE($row[Field_map::$director]),
                    $videos_num,
                    Sql_tool::QUOTE($row[Q_field::$item_total_score]),
                    $score['xie'],
                    $lx_coef['xie'],
                    $lx_coef['zl']
                ]);
                $sp_hz_sql .= Sql_tool::format_insert_value(
                    [
                        Sql_tool::QUOTE($name),
                        Sql_tool::QUOTE($dd),
                        Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                        0,
                        0,
                        0, //Zfxl_hz_map::$zfxl_jdjc,
                        0,//Zfxl_hz_map::$zfxl_jdjc_truescore,
                        $score['xie'],//Zfxl_hz_map::$zfxl_hzdcc,
                        $score['xie'] * self::$coef['hzdc'],//Zfxl_hz_map::$zfxl_hzdc_truescore,
                        0,//Zfxl_hz_map::$zfxl_jsys,
                        0,//Zfxl_hz_map::$zfxl_jsys_truescore,
                        0,//Zfxl_hz_map::$zfxl_bacc,
                        0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                        0,//Zfxl_hz_map::$zfxl_xzcf,
                        0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                        $score['xie'] * self::$coef['hzdc'],
                        self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                        self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                        self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                        self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                        self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                        self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                        ,
                        0,//Zfsp_hz_map::$jdjc_count,
                        0,//Zfsp_hz_map::$jsys_count,
                        0,//Zfsp_hz_map::$xzcf_count,
                        0,//Zfsp_hz_map::$bacc_count,
                        1,//Zfsp_hz_map::$hzdc_count
                        0//Zfsp_hz_map::$hzdc_count
                    ]
                );
            }
            if ($type == 'hzdc_fh') {
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name),
                    Sql_tool::QUOTE($dd),
                    Sql_tool::QUOTE($row[Field_map::$taskId] . ';原项目id:' . $row[Q_field::$old_taskId]),
                    Sql_tool::QUOTE($row[Q_field::$hz_type]),
                    Sql_tool::QUOTE($row[Q_field::$hz_fire_object]),
                    Sql_tool::QUOTE($row[Q_field::$hz_call_time]),
                    '0000-00-00',
                    Sql_tool::QUOTE($row[Q_field::$hz_handel_date]),
                    Sql_tool::QUOTE($row[Q_field::$over_time]),
                    Sql_tool::QUOTE($row[Q_field::$hz_now_status]),
                    Sql_tool::QUOTE($row[Field_map::$director]),
                    $videos_num,
                    Sql_tool::QUOTE($row[Q_field::$item_total_score]),
                    $score['xie'],
                    $lx_coef['xie'],
                    $lx_coef['zl']
                ]);
                $sp_hz_sql .= Sql_tool::format_insert_value(
                    [
                        Sql_tool::QUOTE($name),
                        Sql_tool::QUOTE($dd),
                        Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                        0,
                        0,
                        0, //Zfxl_hz_map::$zfxl_jdjc,
                        0,//Zfxl_hz_map::$zfxl_jdjc_truescore,
                        $score['xie'],//Zfxl_hz_map::$zfxl_hzdcc,
                        $score['xie'] * self::$coef['hzdc'],//Zfxl_hz_map::$zfxl_hzdc_truescore,
                        0,//Zfxl_hz_map::$zfxl_jsys,
                        0,//Zfxl_hz_map::$zfxl_jsys_truescore,
                        0,//Zfxl_hz_map::$zfxl_bacc,
                        0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                        0,//Zfxl_hz_map::$zfxl_xzcf,
                        0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                        $score['xie'] * self::$coef['hzdc'],
                        self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                        self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                        self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                        self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                        self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                        self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                        ,
                        0,//Zfsp_hz_map::$jdjc_count,
                        0,//Zfsp_hz_map::$jsys_count,
                        0,//Zfsp_hz_map::$xzcf_count,
                        0,//Zfsp_hz_map::$bacc_count,
                        1,//Zfsp_hz_map::$hzdc_count
                        0//Zfsp_hz_map::$hzdc_count
                    ]
                );
            }
            if ($type == 'bacc') {
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name),//Zfsp_bacc_score_map::$name,
                    Sql_tool::QUOTE($dd),//Zfsp_bacc_score_map::$dadui,
                    Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_bacc_score_map::$CBR,
                    Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_bacc_score_map::$XMBH,
                    Sql_tool::QUOTE($row[Field_map::$create_time]),//Zfsp_bacc_score_map::$SLSJ,
                    Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_bacc_score_map::$XMJG,
                    Sql_tool::QUOTE($row[Field_map::$task_name]),//Zfsp_bacc_score_map::$GCMC,
                    Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfsp_bacc_score_map::$JGYS,
                    $row[Field_map::$item_total_score],//Zfsp_bacc_score_map::$KP_SCORE,
                    $score['xie'],//Zfsp_bacc_score_map::$KP_TRUE_SCORE,
                    $videos_num,//Zfsp_bacc_score_map::$SPSL,
                    $lx_coef['xie'],//Zfsp_bacc_score_map::$CBRQZ
                    Sql_tool::QUOTE($row[Field_map::$over_time])
                ]);
                $sp_hz_sql .= Sql_tool::format_insert_value(
                    [
                        Sql_tool::QUOTE($name),
                        Sql_tool::QUOTE($dd),
                        Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                        0,
                        0,
                        0, //Zfxl_hz_map::$zfxl_jdjc,
                        0,//Zfxl_hz_map::$zfxl_jdjc_truescore,
                        0,//Zfxl_hz_map::$zfxl_hzdcc,
                        0,//Zfxl_hz_map::$zfxl_hzdc_truescore,
                        0,//Zfxl_hz_map::$zfxl_jsys,
                        0,//Zfxl_hz_map::$zfxl_jsys_truescore,
                        $score['xie'],//Zfxl_hz_map::$zfxl_bacc,
                        $score['xie'] * self::$coef['bacc'],//Zfxl_hz_map::$zfxl_bacc_truescore,
                        0,//Zfxl_hz_map::$zfxl_xzcf,
                        0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                        $score['xie'] * self::$coef['bacc'],
                        self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                        self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                        self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                        self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                        self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                        self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                        ,
                        0,//Zfsp_hz_map::$jdjc_count,
                        0,//Zfsp_hz_map::$jsys_count,
                        0,//Zfsp_hz_map::$xzcf_count,
                        1,//Zfsp_hz_map::$bacc_count,
                        0,//Zfsp_hz_map::$hzdc_count
                        0//Zfsp_hz_map::$hzdc_count
                    ]
                );
            }
            if ($type == 'jsys') {
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name),//Zfsp_jsys_score_map::$name,
                    Sql_tool::QUOTE($dd),//Zfsp_jsys_score_map::$dadui,
                    Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_jsys_score_map::$cbr,
                    Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_jsys_score_map::$xmbh,
                    Sql_tool::QUOTE($row[Field_map::$unit_name]),//Zfsp_jsys_score_map::$gcmc,
                    Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_jsys_score_map::$xmzt,
                    Sql_tool::QUOTE($row[Field_map::$create_time]),//Zfsp_jsys_score_map::$slsj,
                    Sql_tool::QUOTE($row[Field_map::$item_total_score]),//Zfsp_jsys_score_map::$kp_score,
                    $score['xie'],//Zfsp_jsys_score_map::$kp_true_score,
                    $videos_num,//Zfsp_jsys_score_map::$spsl,
                    $lx_coef['xie'],//Zfsp_jsys_score_map::$cbrqz,
                    Sql_tool::QUOTE($row[Field_map::$over_time])//Zfsp_jsys_score_map::$over_time
                ]);
                $sp_hz_sql .= Sql_tool::format_insert_value(
                    [
                        Sql_tool::QUOTE($name),
                        Sql_tool::QUOTE($dd),
                        Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                        0,
                        0,
                        0, //Zfxl_hz_map::$zfxl_jdjc,
                        0,//Zfxl_hz_map::$zfxl_jdjc_truescore,
                        0,//Zfxl_hz_map::$zfxl_hzdcc,
                        0,//Zfxl_hz_map::$zfxl_hzdc_truescore,
                        $score['xie'],//Zfxl_hz_map::$zfxl_jsys,
                        $score['xie'] * self::$coef['jsys'],//Zfxl_hz_map::$zfxl_jsys_truescore,
                        0,//Zfxl_hz_map::$zfxl_bacc,
                        0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                        0,//Zfxl_hz_map::$zfxl_xzcf,
                        0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                        $score['xie'] * self::$coef['jsys'],
                        self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                        self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                        self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                        self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                        self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                        self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                        ,
                        0,//Zfsp_hz_map::$jdjc_count,
                        1,//Zfsp_hz_map::$jsys_count,
                        0,//Zfsp_hz_map::$xzcf_count,
                        0,//Zfsp_hz_map::$bacc_count,
                        0,//Zfsp_hz_map::$hzdc_count
                        0//Zfsp_hz_map::$hzdc_count
                    ]
                );
            }
            if ($type == 'aqjc') {
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name),//Zfsp_aqjc_score_map::$name,
                    Sql_tool::QUOTE($dd),//Zfsp_aqjc_score_map::$dadui,
                    Sql_tool::QUOTE($row[Field_map::$director]),//Zfsp_aqjc_score_map::$CBR,
                    Sql_tool::QUOTE($row[Field_map::$taskId]),//Zfsp_aqjc_score_map::$XMBH,
                    Sql_tool::QUOTE($row[Field_map::$proeject_type]),//Zfsp_aqjc_score_map::$xmlx,
                    Sql_tool::QUOTE($row[Field_map::$unit_name]),//Zfsp_aqjc_score_map::$DWMC,
                    Sql_tool::QUOTE($row[Field_map::$time_limit]),//Zfsp_aqjc_score_map::$JCQX,
                    Sql_tool::QUOTE($row[Field_map::$status]),//Zfsp_aqjc_score_map::$JCQK,
                    Sql_tool::QUOTE($row[Field_map::$item_total_score]),//Zfsp_aqjc_score_map::$KP_SCORE,
                    $score['xie'],//Zfsp_aqjc_score_map::$KP_TRUE_SCORE,
                    $videos_num,//Zfsp_aqjc_score_map::$SPSL,
                    $lx_coef['xie'],//Zfsp_aqjc_score_map::$CBRQZ,
                    1,//Zfsp_aqjc_score_map::$ZLQZ,
                    Sql_tool::QUOTE($row[Field_map::$over_time])//Zfsp_aqjc_score_map::$OVERTIME
                ]);
                $sp_hz_sql .= Sql_tool::format_insert_value(
                    [
                        Sql_tool::QUOTE($name),
                        Sql_tool::QUOTE($dd),
                        Sql_tool::QUOTE($row[Field_map::$over_time]),//Zfxl_hz_map::$SJ,
                        0,
                        0,
                        0, //Zfxl_hz_map::$zfxl_jdjc,
                        0,//Zfxl_hz_map::$zfxl_jdjc_truescore,
                        0,//Zfxl_hz_map::$zfxl_hzdcc,
                        0,//Zfxl_hz_map::$zfxl_hzdc_truescore,
                        $score['xie'],//Zfxl_hz_map::$zfxl_jsys,
                        $score['xie'] * self::$coef['jsys'],//Zfxl_hz_map::$zfxl_jsys_truescore,
                        0,//Zfxl_hz_map::$zfxl_bacc,
                        0,//Zfxl_hz_map::$zfxl_bacc_truescore,
                        0,//Zfxl_hz_map::$zfxl_xzcf,
                        0,//Zfxl_hz_map::$zfxl_xzcf_truescore,
                        $score['xie'] * self::$coef['jsys'],
                        self::$coef['jdjc'],//Zfxl_hz_map::$jdjc_lxqz,
                        self::$coef['jsys'],//Zfxl_hz_map::$jsys_lxqz,
                        self::$coef['xzcf'],//Zfxl_hz_map::$xzcf_lxqz,
                        self::$coef['bacc'],//Zfxl_hz_map::$bacc_lxqz,
                        self::$coef['hzdc'],//Zfxl_hz_map::$hzdc_lxqz
                        self::$coef['xzqz']//Zfxl_hz_map::$hzdc_lxqz
                        ,
                        0,//Zfsp_hz_map::$jdjc_count,
                        1,//Zfsp_hz_map::$jsys_count,
                        0,//Zfsp_hz_map::$xzcf_count,
                        0,//Zfsp_hz_map::$bacc_count,
                        0,//Zfsp_hz_map::$hzdc_count
                        0//Zfsp_hz_map::$hzdc_count
                    ]
                );
            }
        }

    }

    /**
     * @var null|array
     */
    public static $coef = null;

    /**
     * @param Sql_tool $sqlTool
     * @internal param null $coef
     */
    public static function set_coef($sqlTool)
    {
        self::$coef = $sqlTool->execute_dql_res(
            'SELECT * FROM `qz_zfsp`'
        )->fetch();
        self::$coef['aqjc'] = self::$coef['jsys'];
        self::$coef['hzdc_fh'] = self::$coef['hzdc'];
    }

    /**
     * @param string $project_type
     * @return float|int
     */
    public static function get_jdjc_xx_coef($project_type)
    {
        $xx_coef = 1;
        if ($project_type == '消防监督抽查') {
            $xx_coef = (double)self::$coef['rcjdjc'];
        } elseif (
            $project_type == '对举报、投诉的检查' ||
            $project_type == '对举报投诉的检查' ||
            $project_type == '对举报投诉的检查(复查)' ||
            $project_type == '对举报投诉的检查（复查）'
        ) {
            $xx_coef = (double)self::$coef['jbts'];
        } elseif (
            $project_type == '大型群众性活动举办前的检查' ||
            $project_type == '大型活动举办前检查'
        ) {
            $xx_coef = (double)self::$coef['jbq'];
        } elseif ($project_type == '建设工程施工工地检查') {
            $xx_coef = (double)self::$coef['sggd'];
        } elseif ($project_type == '派出所日常监督检查') {
            $xx_coef = (double)self::$coef['rcjdjc'];
        } elseif ($project_type == '其他检查') {
            $xx_coef = (double)self::$coef['other'];
        } elseif (
            $project_type == '责令限期改正复查' ||
            $project_type == '申请恢复施工、使用、生产、经营的检查' ||
            $project_type == '申请解除临时查封的检查' ||
            $project_type == '申请解除临时查封的检查(复查)' ||
            $project_type == '申请解除临时查封的检查（复查）' ||
            $project_type == '其他检查(复查)' ||
            $project_type == '其他检查（复查）' ||
            $project_type == '其他检查(三停检查)' ||
            $project_type == '其他检查（三停检查）'
        ) {
            $xx_coef = (double)self::$coef['fc'];
        } elseif ($project_type == '公众聚集场所投入使用、营业前消防安全检查') {
            $xx_coef = (double)self::$coef['trsy'];
        }
        return $xx_coef;
    }

    /**
     * @param string $son_type
     * @return float|int
     */
    public static function get_xzqz_xx_coef($son_type)
    {
        if ($son_type == '强制执行') {
            return self::$coef['qzzx'];
        } elseif ($son_type == '临时查封') {
            return self::$coef['lscf'];
        }
        return 1;
    }

    /**
     * @param string $project_type
     * @return double
     */
    public static function get_hzdc_xx_coef($project_type)
    {
        if ($project_type == '一般' || $project_type == '一般调查') {
            return self::$coef['ybdc'];
        } elseif ($project_type == '认定复核' || $project_type == '复核')
            return self::$coef['rdfh'];
        return self::$coef['jydc'];
    }

    /**
     * @param string $item_name
     * @param string $project_type
     * @return array
     */
    public static function field_coef_get($item_name, $project_type = '', $son_type = '')
    {
        switch ($item_name) {
            case 'xzcf':
//                $res = get_coef($sqltool, $item_name);
                $coef = [
                    'zhu' => (double)self::$coef['zbr'],
                    'xie' => (double)self::$coef['xbr']
                ];
                return $coef;
                break;
            case 'jdjc':
                $xx_coef = self::get_jdjc_xx_coef($project_type);
//                cmd_iconv($project_type);
//                echo $xx_coef;
                $coef = [
                    'zhu' => (double)self::$coef['zbr'],
                    'xie' => (double)self::$coef['xbr'],
                    'zl' => $xx_coef
                ];
//                print_r($score);
                return $coef;
                break;
            case 'xzqz':
                $xx_coef = self::get_xzqz_xx_coef($son_type);
//                cmd_iconv($project_type);
//                echo $xx_coef;
                $coef = [
                    'zhu' => (double)self::$coef['zbr'],
                    'xie' => (double)self::$coef['xbr'],
                    'zl' => $xx_coef
                ];
                return $coef;
                break;
            case 'hzdc':
                $xx_coef = self::get_hzdc_xx_coef($project_type);
                $coef = [
                    'zhu' => (double)self::$coef['zbr'],
                    'xie' => (double)self::$coef['xbr'],
                    'zl' => $xx_coef
                ];
                return $coef;
            default:
                $coef = [
                    'zhu' => (double)self::$coef['zbr'],
                    'xie' => (double)self::$coef['xbr']
                ];
                return $coef;
                break;
        }
    }

    /**
     * @param array $row
     */
    public static function change_type(&$row)
    {
        if (!array_key_exists(Q_field::$proeject_type, $row))
            return;
        if ($row[Q_field::$proeject_type] == '消防监督抽查') {

            $row[Q_field::$proeject_type] = '日常监督检查';

        } elseif (
            $row[Q_field::$proeject_type] == '对举报、投诉的检查' ||
            $row[Q_field::$proeject_type] == '对举报投诉的检查' ||
            $row[Q_field::$proeject_type] == '对举报投诉的检查(复查)' ||
            $row[Q_field::$proeject_type] == '对举报投诉的检查（复查）'
        ) {

            $row[Q_field::$proeject_type] = '举报投诉检查';

        } elseif (
            $row[Q_field::$proeject_type] == '大型群众性活动举办前的检查' ||
            $row[Q_field::$proeject_type] == '大型活动举办前检查'
        ) {

            $row[Q_field::$proeject_type] = '举办前安全检查';

        } elseif ($row[Q_field::$proeject_type] == '建设工程施工工地检查') {

            $row[Q_field::$proeject_type] = '施工工地检查';

        } elseif ($row[Q_field::$proeject_type] == '派出所日常监督检查') {

            $row[Q_field::$proeject_type] = '日常监督检查';

        } elseif ($row[Q_field::$proeject_type] == '其他检查') {

            $row[Q_field::$proeject_type] = '其他检查';

        } elseif (
            $row[Q_field::$proeject_type] == '责令限期改正复查' ||
            $row[Q_field::$proeject_type] == '申请恢复施工、使用、生产、经营的检查' ||
            $row[Q_field::$proeject_type] == '申请解除临时查封的检查' ||
            $row[Q_field::$proeject_type] == '申请解除临时查封的检查(复查)' ||
            $row[Q_field::$proeject_type] == '申请解除临时查封的检查（复查）' ||
            $row[Q_field::$proeject_type] == '其他检查(复查)' ||
            $row[Q_field::$proeject_type] == '其他检查（复查）' ||
            $row[Q_field::$proeject_type] == '其他检查(三停检查)' ||
            $row[Q_field::$proeject_type] == '其他检查（三停检查）'
        ) {

            $row[Q_field::$proeject_type] = '复查';

        } elseif ($row[Q_field::$proeject_type] == '公众聚集场所投入使用、营业前消防安全检查') {
            $row[Q_field::$proeject_type] = '投入使用营业前安全检查';
        }
    }

    /**
     * @param string $item_name
     * @param double $total_score
     * @param string $project_type
     * @return array|bool
     * @internal param float $coef
     */
    public static function coef_count($item_name, $total_score, $project_type = '', $son_type = '')
    {
        switch ($item_name) {
            case 'xzcf':
//                $res = get_coef($sqltool, $item_name);
                $score = [
                    'zhu' => $total_score * (double)self::$coef['zbr'],
//                  'zhu' => $total_score * (double)$coef['xzcf'] * (double)$coef['zbr'],
                    'xie' => $total_score * (double)self::$coef['xbr']
//                  'xie' => $total_score * (double)$coef['xzcf'] * (double)$coef['xbr']
                ];
                return $score;
                break;
            case 'jdjc':
                $xx_coef = self::get_jdjc_xx_coef($project_type);
//                cmd_iconv($project_type);
//                echo $xx_coef;
                $score = [
                    'zhu' => $total_score * (double)self::$coef['zbr'] * $xx_coef,
                    'xie' => $total_score * (double)self::$coef['xbr'] * $xx_coef
                ];
//                print_r($score);
                return $score;
                break;
            case 'xzqz':
                $xx_coef = self::get_xzqz_xx_coef($son_type);
                $score = [
                    'zhu' => $total_score * (double)self::$coef['zbr'] * $xx_coef,
                    'xie' => $total_score * (double)self::$coef['xbr'] * $xx_coef
                ];
                return $score;
                break;
            case 'hzdc':
                $xx_coef = self::get_hzdc_xx_coef($project_type);
                $score = [
                    'zhu' => $total_score * (double)self::$coef['zbr'] * $xx_coef,
                    'xie' => $total_score * (double)self::$coef['xbr'] * $xx_coef
                ];
                return $score;
            case 'hzdc_fh':
                $xx_coef = self::get_hzdc_xx_coef($project_type);
                $score = [
                    'zhu' => $total_score * (double)self::$coef['zbr'] * $xx_coef,
                    'xie' => $total_score * (double)self::$coef['xbr'] * $xx_coef
                ];
                return $score;
            default:
                $score = [
                    'zhu' => $total_score * (double)self::$coef['zbr'],
                    'xie' => $total_score * (double)self::$coef['xbr']
                ];
                return $score;
                break;
        }
    }

    /**
     * @param string $type
     * @param string $taskid
     * @return int
     */
    public static function videos_count($type, $taskid)
    {
        if ($type == 'xzcf') {
            $task_field = Kpdf_glsp_xzcf_map::$Item_num;
            $from_table = Kpdf_glsp_xzcf_map::$table_name;
        } elseif ($type == 'hzdc' || $type == 'hzdc_fh') {
            $task_field = Kpdf_glsp_hzdc_map::$Item_num;
            $from_table = Kpdf_glsp_hzdc_map::$table_name;
        } elseif ($type == 'jdjc' || $type == 'xzqz') {
            $task_field = Kpdf_glsp_jdjc_map::$Item_num;
            $from_table = Kpdf_glsp_jdjc_map::$table_name;
        } elseif ($type == 'bacc') {
            $task_field = Kpdf_glsp_bacc_map::$Item_num;
            $from_table = Kpdf_glsp_bacc_map::$table_name;
        } elseif ($type == 'jsys') {
            $task_field = Kpdf_glsp_jsys_map::$Item_num;
            $from_table = Kpdf_glsp_jsys_map::$table_name;
        } elseif ($type == 'aqjc') {
            $task_field = Kpdf_glsp_aqjc_map::$Item_num;
            $from_table = Kpdf_glsp_aqjc_map::$table_name;
        } else {
            return 0;
        }
        if (!array_key_exists($type, self::$videos)) {
            self::$videos[$type] = [];
        }
        if (array_key_exists($taskid, self::$videos[$type])) {
            return self::$videos[$type][$taskid];
        }
        if (self::$sql_tool == null)
            self::$sql_tool = Sql_tool::build(
                'localhost', 'root', '123456', 'zxpg_gzpc_db'
            );
        $res = self::$sql_tool->execute_dql_res(
            "SELECT COUNT(*) as num FROM $from_table WHERE $task_field = '$taskid' "
        )->fetch();
        self::$videos[$type][$taskid] = $res['num'];
        return self::$videos[$type][$taskid];
    }

    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_xzcf($sql_tool, $callback, $param = '')
    {
        $base_sql = (new Table(Gzpc_xmxx_xzcf_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_glsp_xzcf_map::$table_name,
                [
                    Gzpc_xmxx_xzcf_map::$director => Field_map::$director,
                    Gzpc_xmxx_xzcf_map::$unitName => Field_map::$unit_name,
                    Gzpc_xmxx_xzcf_map::$timeLimit => Field_map::$time_limit,
                    Gzpc_xmxx_xzcf_map::$cjTime => Field_map::$cj_time,
                    Gzpc_xmxx_xzcf_map::$status => Field_map::$status,
                    Gzpc_xmxx_xzcf_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_xzcf_map::$taskId => Field_map::$taskId,
                    Kpdf_glsp_xzcf_map::$glsp_Result => Field_map::$item_total_score,
                    Kpdf_glsp_xzcf_map::$sp_url => Field_map::$sp_url,
                    Kpdf_glsp_xzcf_map::$Most_Kf => Field_map::$most_kf,
                    Kpdf_glsp_xzcf_map::$kptime => Field_map::$kp_time,
                    Kpdf_glsp_xzcf_map::$glsp_a => Field_map::glsp('a'),
                    Kpdf_glsp_xzcf_map::$glsp_b => Field_map::glsp('b'),
                    Kpdf_glsp_xzcf_map::$glsp_c => Field_map::glsp('c'),
                    Kpdf_glsp_xzcf_map::$glsp_d => Field_map::glsp('d'),
                    Kpdf_glsp_xzcf_map::$glsp_e => Field_map::glsp('e'),
                    Kpdf_glsp_xzcf_map::$glsp_f => Field_map::glsp('f'),
                    Kpdf_glsp_xzcf_map::$glsp_g => Field_map::glsp('g'),
                    Kpdf_glsp_xzcf_map::$glsp_h => Field_map::glsp('h'),
                    Kpdf_glsp_xzcf_map::$glsp_i => Field_map::glsp('i')
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_xzcf_map::$taskId
                    => Kpdf_glsp_xzcf_map::$Item_num
                ]) . $param,
                true
            );

        (new Table(
            $base_sql,
            Table_group::sqlTool_build($sql_tool),
            Gzpc_xmxx_xzcf_map::$table_name
        ))->group_query(
            [
                Field_map::$director,
                Field_map::$unit_name,
                Field_map::$time_limit,
                Field_map::$cj_time,
                Field_map::$status,
                Field_map::$over_time,
                Field_map::$taskId,
                Sql_tool::SUM(Field_map::$item_total_score)
                => Field_map::$item_total_score,
                Field_map::$sp_url,
                Sql_tool::SUM(Field_map::$most_kf)
                => Field_map::$most_kf,
                Field_map::$kp_time,
                Sql_tool::SUM(Field_map::glsp('a')),
                Sql_tool::SUM(Field_map::glsp('b')),
                Sql_tool::SUM(Field_map::glsp('c')),
                Sql_tool::SUM(Field_map::glsp('d')),
                Sql_tool::SUM(Field_map::glsp('e')),
                Sql_tool::SUM(Field_map::glsp('f')),
                Sql_tool::SUM(Field_map::glsp('g')),
                Sql_tool::SUM(Field_map::glsp('h')),
                Sql_tool::SUM(Field_map::glsp('i'))
            ],
            [
                Field_map::$director,
                Field_map::$taskId
            ]
        )->each_row($callback);
    }

    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_jdjc($sql_tool, $callback, $param = '')
    {
        $base_sql = (new Table(Gzpc_xmxx_jdjc_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_glsp_jdjc_map::$table_name,
                [
                    Gzpc_xmxx_jdjc_map::$director => Field_map::$director,
                    Gzpc_xmxx_jdjc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_jdjc_map::$projectId => Field_map::$taskId,
                    Gzpc_xmxx_jdjc_map::$projectType => Field_map::$proeject_type,
                    Gzpc_xmxx_jdjc_map::$unitName => Field_map::$unit_name,
                    Gzpc_xmxx_jdjc_map::$status => Field_map::$status,
                    Gzpc_xmxx_jdjc_map::$timeLimit => Field_map::$time_limit,
                    Gzpc_xmxx_jdjc_map::$createTime => Field_map::$cj_time,
                    Kpdf_glsp_jdjc_map::$glsp_Result => Field_map::$item_total_score,
                    Kpdf_glsp_jdjc_map::$sp_url => Field_map::$sp_url,
                    Kpdf_glsp_jdjc_map::$Most_Kf => Field_map::$most_kf,
                    Kpdf_glsp_jdjc_map::$kptime => Field_map::$kp_time,
                    Kpdf_glsp_jdjc_map::$glsp_a => Field_map::glsp('a'),
                    Kpdf_glsp_jdjc_map::$glsp_b => Field_map::glsp('b'),
                    Kpdf_glsp_jdjc_map::$glsp_c => Field_map::glsp('c'),
                    Kpdf_glsp_jdjc_map::$glsp_d => Field_map::glsp('d'),
                    Kpdf_glsp_jdjc_map::$glsp_e => Field_map::glsp('e'),
                    Kpdf_glsp_jdjc_map::$glsp_f => Field_map::glsp('f'),
                    Kpdf_glsp_jdjc_map::$glsp_g => Field_map::glsp('g'),
                    Kpdf_glsp_jdjc_map::$glsp_h => Field_map::glsp('h'),
                    Kpdf_glsp_jdjc_map::$glsp_i => Field_map::glsp('i'),
                    Kpdf_glsp_jdjc_map::$glsp_j => Field_map::glsp('j'),
                    Kpdf_glsp_jdjc_map::$glsp_k => Field_map::glsp('k'),
                    Kpdf_glsp_jdjc_map::$glsp_l => Field_map::glsp('l'),
                    Kpdf_glsp_jdjc_map::$glsp_m => Field_map::glsp('m'),
                    Kpdf_glsp_jdjc_map::$glsp_n => Field_map::glsp('n'),
                    Kpdf_glsp_jdjc_map::$glsp_o => Field_map::glsp('o'),
                    Kpdf_glsp_jdjc_map::$glsp_p => Field_map::glsp('p'),
                    Kpdf_glsp_jdjc_map::$glsp_q => Field_map::glsp('q')
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_jdjc_map::$projectId
                    => Kpdf_glsp_jdjc_map::$Item_num
                ])

                . $param . ' AND sonType = \'\' ',
                true
            );

        (new Table(
            $base_sql,
            Table_group::sqlTool_build($sql_tool),
            Gzpc_xmxx_jdjc_map::$table_name
        ))->group_query(
            [
                Field_map::$director,
                Field_map::$over_time,
                Field_map::$taskId,
                Field_map::$proeject_type,
                Field_map::$unit_name,
                Field_map::$status,
                Field_map::$time_limit,
                Field_map::$cj_time,
                Sql_tool::SUM(Field_map::$item_total_score)
                => Field_map::$item_total_score,
                Field_map::$sp_url,
                Sql_tool::SUM(Field_map::$most_kf)
                => Field_map::$most_kf,
                Field_map::$kp_time,
                Sql_tool::SUM(Field_map::glsp('a')),
                Sql_tool::SUM(Field_map::glsp('b')),
                Sql_tool::SUM(Field_map::glsp('c')),
                Sql_tool::SUM(Field_map::glsp('d')),
                Sql_tool::SUM(Field_map::glsp('e')),
                Sql_tool::SUM(Field_map::glsp('f')),
                Sql_tool::SUM(Field_map::glsp('g')),
                Sql_tool::SUM(Field_map::glsp('h')),
                Sql_tool::SUM(Field_map::glsp('i')),
                Sql_tool::SUM(Field_map::glsp('j')),
                Sql_tool::SUM(Field_map::glsp('k')),
                Sql_tool::SUM(Field_map::glsp('l')),
                Sql_tool::SUM(Field_map::glsp('m')),
                Sql_tool::SUM(Field_map::glsp('n')),
                Sql_tool::SUM(Field_map::glsp('o')),
                Sql_tool::SUM(Field_map::glsp('p')),
                Sql_tool::SUM(Field_map::glsp('q'))
            ],
            [
                Field_map::$director,
                Field_map::$taskId
            ]
        )->each_row($callback);
        //->each_row($callback);
    }


    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_xzqz($sql_tool, $callback, $param = '')
    {
        $base_sql = (new Table(Gzpc_xmxx_jdjc_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_glsp_jdjc_map::$table_name,
                [
                    Gzpc_xmxx_jdjc_map::$director => Field_map::$director,
                    Gzpc_xmxx_jdjc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_jdjc_map::$projectId => Field_map::$taskId,
                    Gzpc_xmxx_jdjc_map::$projectType => Field_map::$proeject_type,
                    Gzpc_xmxx_jdjc_map::$unitName => Field_map::$unit_name,
                    Gzpc_xmxx_jdjc_map::$status => Field_map::$status,
                    Gzpc_xmxx_jdjc_map::$sonType => Field_map::$son_type,
                    Gzpc_xmxx_jdjc_map::$timeLimit => Field_map::$time_limit,
                    Gzpc_xmxx_jdjc_map::$createTime => Field_map::$cj_time,
                    Kpdf_glsp_jdjc_map::$glsp_Result => Field_map::$item_total_score,
                    Kpdf_glsp_jdjc_map::$sp_url => Field_map::$sp_url,
                    Kpdf_glsp_jdjc_map::$Most_Kf => Field_map::$most_kf,
                    Kpdf_glsp_jdjc_map::$kptime => Field_map::$kp_time,
                    Kpdf_glsp_jdjc_map::$glsp_a => Field_map::glsp('a'),
                    Kpdf_glsp_jdjc_map::$glsp_b => Field_map::glsp('b'),
                    Kpdf_glsp_jdjc_map::$glsp_c => Field_map::glsp('c'),
                    Kpdf_glsp_jdjc_map::$glsp_d => Field_map::glsp('d'),
                    Kpdf_glsp_jdjc_map::$glsp_e => Field_map::glsp('e'),
                    Kpdf_glsp_jdjc_map::$glsp_f => Field_map::glsp('f'),
                    Kpdf_glsp_jdjc_map::$glsp_g => Field_map::glsp('g'),
                    Kpdf_glsp_jdjc_map::$glsp_h => Field_map::glsp('h'),
                    Kpdf_glsp_jdjc_map::$glsp_i => Field_map::glsp('i'),
                    Kpdf_glsp_jdjc_map::$glsp_j => Field_map::glsp('j'),
                    Kpdf_glsp_jdjc_map::$glsp_k => Field_map::glsp('k'),
                    Kpdf_glsp_jdjc_map::$glsp_l => Field_map::glsp('l'),
                    Kpdf_glsp_jdjc_map::$glsp_m => Field_map::glsp('m'),
                    Kpdf_glsp_jdjc_map::$glsp_n => Field_map::glsp('n'),
                    Kpdf_glsp_jdjc_map::$glsp_o => Field_map::glsp('o'),
                    Kpdf_glsp_jdjc_map::$glsp_p => Field_map::glsp('p'),
                    Kpdf_glsp_jdjc_map::$glsp_q => Field_map::glsp('q')
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_jdjc_map::$projectId
                    => Kpdf_glsp_jdjc_map::$Item_num
                ])

                . $param . ' AND (sonType = \'强制执行\' or sonType = \'临时查封\') ',
                true
            );

        (new Table(
            $base_sql,
            Table_group::sqlTool_build($sql_tool),
            Gzpc_xmxx_jdjc_map::$table_name
        ))->group_query(
            [
                Field_map::$director,
                Field_map::$over_time,
                Field_map::$taskId,
                Field_map::$proeject_type,
                Field_map::$unit_name,
                Field_map::$status,
                Field_map::$son_type,
                Field_map::$time_limit,
                Field_map::$cj_time,
                Sql_tool::SUM(Field_map::$item_total_score)
                => Field_map::$item_total_score,
                Field_map::$sp_url,
                Sql_tool::SUM(Field_map::$most_kf)
                => Field_map::$most_kf,
                Field_map::$kp_time,
                Sql_tool::SUM(Field_map::glsp('a')),
                Sql_tool::SUM(Field_map::glsp('b')),
                Sql_tool::SUM(Field_map::glsp('c')),
                Sql_tool::SUM(Field_map::glsp('d')),
                Sql_tool::SUM(Field_map::glsp('e')),
                Sql_tool::SUM(Field_map::glsp('f')),
                Sql_tool::SUM(Field_map::glsp('g')),
                Sql_tool::SUM(Field_map::glsp('h')),
                Sql_tool::SUM(Field_map::glsp('i')),
                Sql_tool::SUM(Field_map::glsp('j')),
                Sql_tool::SUM(Field_map::glsp('k')),
                Sql_tool::SUM(Field_map::glsp('l')),
                Sql_tool::SUM(Field_map::glsp('m')),
                Sql_tool::SUM(Field_map::glsp('n')),
                Sql_tool::SUM(Field_map::glsp('o')),
                Sql_tool::SUM(Field_map::glsp('p')),
                Sql_tool::SUM(Field_map::glsp('q'))
            ],
            [
                Field_map::$director,
                Field_map::$taskId
            ]
        )->each_row($callback);
        //->each_row($callback);
    }


    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_hzdc($sql_tool, $callback, $param = '')
    {
        $base_sql = (new Table(Gzpc_xmxx_hzdc_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_glsp_hzdc_map::$table_name,
                [
                    Gzpc_xmxx_hzdc_map::$Director => Field_map::$director,
                    Gzpc_xmxx_hzdc_map::$CompleteDate => Field_map::$over_time,
                    Gzpc_xmxx_hzdc_map::$taskId => Field_map::$taskId,
                    Gzpc_xmxx_hzdc_map::$HzdcType => Field_map::$hz_type,
                    Gzpc_xmxx_hzdc_map::$FireTime => Field_map::$hz_call_time,
                    Gzpc_xmxx_hzdc_map::$EndDate => Field_map::$hz_end_date,
                    Gzpc_xmxx_hzdc_map::$NowStatus => Field_map::$hz_now_status,
                    Gzpc_xmxx_hzdc_map::$HandleDate => Field_map::$hz_handel_date,
                    Gzpc_xmxx_hzdc_map::$FirePart => Field_map::$hz_fire_object,
//                    Gzpc_xmxx_hzdc_map::$CompleteDate => Field_map::$hz_complete_date,
                    Kpdf_glsp_hzdc_map::$glsp_Result => Field_map::$item_total_score,
                    Kpdf_glsp_hzdc_map::$sp_url => Field_map::$sp_url,
                    Kpdf_glsp_hzdc_map::$Most_Kf => Field_map::$most_kf,
                    Kpdf_glsp_hzdc_map::$kptime => Field_map::$kp_time,
                    Kpdf_glsp_hzdc_map::$glsp_a => Field_map::glsp('a'),
                    Kpdf_glsp_hzdc_map::$glsp_b => Field_map::glsp('b'),
                    Kpdf_glsp_hzdc_map::$glsp_c => Field_map::glsp('c'),
                    Kpdf_glsp_hzdc_map::$glsp_d => Field_map::glsp('d'),
                    Kpdf_glsp_hzdc_map::$glsp_e => Field_map::glsp('e'),
                    Kpdf_glsp_hzdc_map::$glsp_f => Field_map::glsp('f'),
                    Kpdf_glsp_hzdc_map::$glsp_g => Field_map::glsp('g'),
                    Kpdf_glsp_hzdc_map::$glsp_h => Field_map::glsp('h'),
                    Kpdf_glsp_hzdc_map::$glsp_i => Field_map::glsp('i'),
                    Kpdf_glsp_hzdc_map::$glsp_j => Field_map::glsp('j'),
                    Kpdf_glsp_hzdc_map::$glsp_k => Field_map::glsp('k'),
                    Kpdf_glsp_hzdc_map::$glsp_l => Field_map::glsp('l'),
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_hzdc_map::$taskId
                    => Kpdf_glsp_hzdc_map::$Item_num
                ])
                . $param,
                true
            );

        (new Table(
            $base_sql,
            Table_group::sqlTool_build($sql_tool),
            Gzpc_xmxx_hzdc_map::$table_name
        ))->group_query(
            [
                Field_map::$director,
                Field_map::$over_time,
                Field_map::$taskId,
                Field_map::$hz_type,
                Field_map::$hz_call_time,
                Field_map::$hz_end_date,
                Field_map::$hz_now_status,
                Field_map::$hz_handel_date,
                Field_map::$hz_fire_object,
//                    Gzpc_xmxx_hzdc_map::$CompleteDate => Field_map::$hz_complete_date,
                Sql_tool::SUM(Field_map::$item_total_score)
                => Field_map::$item_total_score,
                Field_map::$sp_url,
                Sql_tool::SUM(Field_map::$most_kf)
                => Field_map::$most_kf,
                Field_map::$kp_time,
                Sql_tool::SUM(Field_map::glsp('a')),
                Sql_tool::SUM(Field_map::glsp('b')),
                Sql_tool::SUM(Field_map::glsp('c')),
                Sql_tool::SUM(Field_map::glsp('d')),
                Sql_tool::SUM(Field_map::glsp('e')),
                Sql_tool::SUM(Field_map::glsp('f')),
                Sql_tool::SUM(Field_map::glsp('g')),
                Sql_tool::SUM(Field_map::glsp('h')),
                Sql_tool::SUM(Field_map::glsp('i')),
                Sql_tool::SUM(Field_map::glsp('j')),
                Sql_tool::SUM(Field_map::glsp('k')),
                Sql_tool::SUM(Field_map::glsp('l'))
            ],
            [
                Field_map::$director,
                Field_map::$taskId
            ]
        )->each_row($callback);
        //->each_row($callback);
    }

    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_hzdc_fh($sql_tool, $callback, $param = '')
    {
        $base_sql = (new Table(Gzpc_xmxx_hzdc_fh_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_glsp_hzdc_map::$table_name,
                [
                    Gzpc_xmxx_hzdc_fh_map::$Director => Field_map::$director,
                    Gzpc_xmxx_hzdc_fh_map::$CompleteDate => Field_map::$over_time,
                    Gzpc_xmxx_hzdc_fh_map::$taskId => Field_map::$taskId,
                    Gzpc_xmxx_hzdc_fh_map::$OldtaskId => Field_map::$old_taskId,
                    Gzpc_xmxx_hzdc_fh_map::$HzdcType => Field_map::$hz_type,
                    Gzpc_xmxx_hzdc_fh_map::$CreatDate => Field_map::$hz_call_time,
//                    Gzpc_xmxx_hzdc_fh_map::$EndDate => Field_map::$hz_end_date,
                    Gzpc_xmxx_hzdc_fh_map::$NowStatus => Field_map::$hz_now_status,
                    Gzpc_xmxx_hzdc_fh_map::$HandleDate => Field_map::$hz_handel_date,
                    Gzpc_xmxx_hzdc_fh_map::$FirePart => Field_map::$hz_fire_object,
                    Kpdf_glsp_hzdc_map::$glsp_Result => Field_map::$item_total_score,
                    Kpdf_glsp_hzdc_map::$sp_url => Field_map::$sp_url,
                    Kpdf_glsp_hzdc_map::$Most_Kf => Field_map::$most_kf,
                    Kpdf_glsp_hzdc_map::$kptime => Field_map::$kp_time,
                    Kpdf_glsp_hzdc_map::$glsp_a => Field_map::glsp('a'),
                    Kpdf_glsp_hzdc_map::$glsp_b => Field_map::glsp('b'),
                    Kpdf_glsp_hzdc_map::$glsp_c => Field_map::glsp('c'),
                    Kpdf_glsp_hzdc_map::$glsp_d => Field_map::glsp('d'),
                    Kpdf_glsp_hzdc_map::$glsp_e => Field_map::glsp('e'),
                    Kpdf_glsp_hzdc_map::$glsp_f => Field_map::glsp('f'),
                    Kpdf_glsp_hzdc_map::$glsp_g => Field_map::glsp('g'),
                    Kpdf_glsp_hzdc_map::$glsp_h => Field_map::glsp('h'),
                    Kpdf_glsp_hzdc_map::$glsp_i => Field_map::glsp('i'),
                    Kpdf_glsp_hzdc_map::$glsp_j => Field_map::glsp('j'),
                    Kpdf_glsp_hzdc_map::$glsp_k => Field_map::glsp('k'),
                    Kpdf_glsp_hzdc_map::$glsp_l => Field_map::glsp('l')
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_hzdc_fh_map::$taskId
                    => Kpdf_glsp_hzdc_map::$Item_num
                ])
                . $param,
                true
            );

        (new Table(
            $base_sql,
            Table_group::sqlTool_build($sql_tool),
            Gzpc_xmxx_hzdc_fh_map::$table_name
        ))->group_query(
            [
                Field_map::$director,
                Field_map::$over_time,
                Field_map::$taskId,
                Field_map::$old_taskId,
                Field_map::$hz_type,
                Field_map::$hz_call_time,
//                    Gzpc_xmxx_hzdc_fh_map::$EndDate => Field_map::$hz_end_date,
                Field_map::$hz_now_status,
                Field_map::$hz_handel_date,
                Field_map::$hz_fire_object,
                Sql_tool::SUM(Field_map::$item_total_score)
                => Field_map::$item_total_score,
                Field_map::$sp_url,
                Sql_tool::SUM(Field_map::$most_kf)
                => Field_map::$most_kf,
                Field_map::$kp_time,
                Sql_tool::SUM(Field_map::glsp('a')),
                Sql_tool::SUM(Field_map::glsp('b')),
                Sql_tool::SUM(Field_map::glsp('c')),
                Sql_tool::SUM(Field_map::glsp('d')),
                Sql_tool::SUM(Field_map::glsp('e')),
                Sql_tool::SUM(Field_map::glsp('f')),
                Sql_tool::SUM(Field_map::glsp('g')),
                Sql_tool::SUM(Field_map::glsp('h')),
                Sql_tool::SUM(Field_map::glsp('i')),
                Sql_tool::SUM(Field_map::glsp('j')),
                Sql_tool::SUM(Field_map::glsp('k')),
                Sql_tool::SUM(Field_map::glsp('l'))
            ],
            [
                Field_map::$director,
                Field_map::$taskId
            ]
        )->each_row($callback);
        //->each_row($callback);
    }

    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_bacc($sql_tool, $callback, $param = '')
    {
        $base_sql = (new Table(Gzpc_xmxx_bacc_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_glsp_bacc_map::$table_name,
                [
                    Gzpc_xmxx_bacc_map::$director => Field_map::$director,
                    Gzpc_xmxx_bacc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_bacc_map::$projectId => Field_map::$taskId,
                    Gzpc_xmxx_bacc_map::$projectName => Field_map::$task_name,
                    Gzpc_xmxx_bacc_map::$result => Field_map::$xm_result,
                    Gzpc_xmxx_bacc_map::$status => Field_map::$status,
                    Gzpc_xmxx_bacc_map::$createTime => Field_map::$create_time,
                    Kpdf_glsp_bacc_map::$glsp_Result => Field_map::$item_total_score,
                    Kpdf_glsp_bacc_map::$sp_url => Field_map::$sp_url,
                    Kpdf_glsp_bacc_map::$Most_Kf => Field_map::$most_kf,
                    Kpdf_glsp_bacc_map::$kptime => Field_map::$kp_time,
                    Kpdf_glsp_bacc_map::$glsp_a => Field_map::glsp('a'),
                    Kpdf_glsp_bacc_map::$glsp_b => Field_map::glsp('b'),
                    Kpdf_glsp_bacc_map::$glsp_c => Field_map::glsp('c'),
                    Kpdf_glsp_bacc_map::$glsp_d => Field_map::glsp('d'),
                    Kpdf_glsp_bacc_map::$glsp_e => Field_map::glsp('e'),
                    Kpdf_glsp_bacc_map::$glsp_f => Field_map::glsp('f'),
                    Kpdf_glsp_bacc_map::$glsp_g => Field_map::glsp('g'),
                    Kpdf_glsp_bacc_map::$glsp_h => Field_map::glsp('h'),
                    Kpdf_glsp_bacc_map::$glsp_i => Field_map::glsp('i'),
                    Kpdf_glsp_bacc_map::$glsp_j => Field_map::glsp('j'),
                    Kpdf_glsp_bacc_map::$glsp_k => Field_map::glsp('k'),
                    Kpdf_glsp_bacc_map::$glsp_l => Field_map::glsp('l'),
                    Kpdf_glsp_bacc_map::$glsp_m => Field_map::glsp('m'),
                    Kpdf_glsp_bacc_map::$glsp_n => Field_map::glsp('n')
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_bacc_map::$projectId
                    => Kpdf_glsp_bacc_map::$Item_num
                ]) . $param,
                true
            );

        (new Table(
            $base_sql,
            Table_group::sqlTool_build($sql_tool),
            Gzpc_xmxx_bacc_map::$table_name
        ))->group_query(
            [
                Field_map::$director,
                Field_map::$over_time,
                Field_map::$taskId,
                Field_map::$task_name,
                Field_map::$xm_result,
                Field_map::$status,
                Field_map::$create_time,
                Sql_tool::SUM(Field_map::$item_total_score)
                => Field_map::$item_total_score,
                Field_map::$sp_url,
                Sql_tool::SUM(Field_map::$most_kf)
                => Field_map::$most_kf,
                Field_map::$kp_time,
                Sql_tool::SUM(Field_map::glsp('a')),
                Sql_tool::SUM(Field_map::glsp('b')),
                Sql_tool::SUM(Field_map::glsp('c')),
                Sql_tool::SUM(Field_map::glsp('d')),
                Sql_tool::SUM(Field_map::glsp('e')),
                Sql_tool::SUM(Field_map::glsp('f')),
                Sql_tool::SUM(Field_map::glsp('g')),
                Sql_tool::SUM(Field_map::glsp('h')),
                Sql_tool::SUM(Field_map::glsp('i')),
                Sql_tool::SUM(Field_map::glsp('j')),
                Sql_tool::SUM(Field_map::glsp('k')),
                Sql_tool::SUM(Field_map::glsp('l')),
                Sql_tool::SUM(Field_map::glsp('m')),
                Sql_tool::SUM(Field_map::glsp('n'))
            ],
            [
                Field_map::$director,
                Field_map::$taskId
            ]
        )->each_row($callback);


        //->each_row($callback);


    }

    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_shys($sql_tool, $callback, $param = '')
    {
        $base_sql = (new Table(Gzpc_xmxx_shys_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_glsp_jsys_map::$table_name,
                [
                    Gzpc_xmxx_shys_map::$director => Field_map::$director,
                    Gzpc_xmxx_shys_map::$status => Field_map::$status,
                    Gzpc_xmxx_shys_map::$createTime => Field_map::$create_time,
                    Gzpc_xmxx_shys_map::$unitName => Field_map::$unit_name,
                    Gzpc_xmxx_shys_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_shys_map::$projectId => Field_map::$taskId,
                    Kpdf_glsp_jsys_map::$glsp_Result => Field_map::$item_total_score,
                    Kpdf_glsp_jsys_map::$sp_url => Field_map::$sp_url,
                    Kpdf_glsp_jsys_map::$Most_Kf => Field_map::$most_kf,
                    Kpdf_glsp_jsys_map::$kptime => Field_map::$kp_time,
                    Kpdf_glsp_jsys_map::$glsp_a => Field_map::glsp('a'),
                    Kpdf_glsp_jsys_map::$glsp_b => Field_map::glsp('b'),
                    Kpdf_glsp_jsys_map::$glsp_c => Field_map::glsp('c'),
                    Kpdf_glsp_jsys_map::$glsp_d => Field_map::glsp('d'),
                    Kpdf_glsp_jsys_map::$glsp_e => Field_map::glsp('e'),
                    Kpdf_glsp_jsys_map::$glsp_f => Field_map::glsp('f'),
                    Kpdf_glsp_jsys_map::$glsp_g => Field_map::glsp('g'),
                    Kpdf_glsp_jsys_map::$glsp_h => Field_map::glsp('h'),
                    Kpdf_glsp_jsys_map::$glsp_i => Field_map::glsp('i'),
                    Kpdf_glsp_jsys_map::$glsp_j => Field_map::glsp('j'),
                    Kpdf_glsp_jsys_map::$glsp_k => Field_map::glsp('k'),
                    Kpdf_glsp_jsys_map::$glsp_l => Field_map::glsp('l'),
                    Kpdf_glsp_jsys_map::$glsp_m => Field_map::glsp('m'),
                    Kpdf_glsp_jsys_map::$glsp_n => Field_map::glsp('n'),
                    Kpdf_glsp_jsys_map::$glsp_o => Field_map::glsp('o')
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_shys_map::$projectId
                    => Kpdf_glsp_jsys_map::$Item_num
                ]) . $param,
                true
            );

        (new Table(
            $base_sql,
            Table_group::sqlTool_build($sql_tool),
            Gzpc_xmxx_shys_map::$table_name
        ))->group_query(
            [
                Field_map::$director,
                Field_map::$status,
                Field_map::$create_time,
                Field_map::$unit_name,
                Field_map::$over_time,
                Field_map::$taskId,
                Sql_tool::SUM(Field_map::$item_total_score)
                => Field_map::$item_total_score,
                Field_map::$sp_url,
                Sql_tool::SUM(Field_map::$most_kf)
                => Field_map::$most_kf,
                Field_map::$kp_time,
                Sql_tool::SUM(Field_map::glsp('a')),
                Sql_tool::SUM(Field_map::glsp('b')),
                Sql_tool::SUM(Field_map::glsp('c')),
                Sql_tool::SUM(Field_map::glsp('d')),
                Sql_tool::SUM(Field_map::glsp('e')),
                Sql_tool::SUM(Field_map::glsp('f')),
                Sql_tool::SUM(Field_map::glsp('g')),
                Sql_tool::SUM(Field_map::glsp('h')),
                Sql_tool::SUM(Field_map::glsp('i')),
                Sql_tool::SUM(Field_map::glsp('j')),
                Sql_tool::SUM(Field_map::glsp('k')),
                Sql_tool::SUM(Field_map::glsp('l')),
                Sql_tool::SUM(Field_map::glsp('m')),
                Sql_tool::SUM(Field_map::glsp('n')),
                Sql_tool::SUM(Field_map::glsp('o'))
            ],
            [
                Field_map::$director,
                Field_map::$taskId
            ]
        )->each_row($callback);

        //->each_row($callback);
    }

    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_aqjc($sql_tool, $callback, $param = '')
    {
        $base_sql = (new Table(Gzpc_xmxx_aqjc_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_glsp_aqjc_map::$table_name,
                [
                    Gzpc_xmxx_aqjc_map::$director => Field_map::$director,
                    Gzpc_xmxx_aqjc_map::$status => Field_map::$status,
                    Gzpc_xmxx_aqjc_map::$createTime => Field_map::$create_time,
                    Gzpc_xmxx_aqjc_map::$unitName => Field_map::$unit_name,
                    Gzpc_xmxx_aqjc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_aqjc_map::$timeLimit => Field_map::$time_limit,
                    Gzpc_xmxx_aqjc_map::$projectId => Field_map::$taskId,
                    Gzpc_xmxx_aqjc_map::$projectType => Field_map::$proeject_type,
                    Kpdf_glsp_aqjc_map::$glsp_Result => Field_map::$item_total_score,
                    Kpdf_glsp_aqjc_map::$sp_url => Field_map::$sp_url,
                    Kpdf_glsp_aqjc_map::$Most_Kf => Field_map::$most_kf,
                    Kpdf_glsp_aqjc_map::$kptime => Field_map::$kp_time,
                    Kpdf_glsp_aqjc_map::$glsp_a => Field_map::glsp('a'),
                    Kpdf_glsp_aqjc_map::$glsp_b => Field_map::glsp('b'),
                    Kpdf_glsp_aqjc_map::$glsp_c => Field_map::glsp('c'),
                    Kpdf_glsp_aqjc_map::$glsp_d => Field_map::glsp('d'),
                    Kpdf_glsp_aqjc_map::$glsp_e => Field_map::glsp('e'),
                    Kpdf_glsp_aqjc_map::$glsp_f => Field_map::glsp('f'),
                    Kpdf_glsp_aqjc_map::$glsp_g => Field_map::glsp('g'),
                    Kpdf_glsp_aqjc_map::$glsp_h => Field_map::glsp('h'),
                    Kpdf_glsp_aqjc_map::$glsp_i => Field_map::glsp('i')
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_aqjc_map::$projectId
                    => Kpdf_glsp_aqjc_map::$Item_num
                ]) . $param,
                true
            );

        (new Table(
            $base_sql,
            Table_group::sqlTool_build($sql_tool),
            Gzpc_xmxx_aqjc_map::$table_name
        ))->group_query(
            [
                Field_map::$director,
                Field_map::$status,
                Field_map::$create_time,
                Field_map::$unit_name,
                Field_map::$over_time,
                Field_map::$time_limit,
                Field_map::$taskId,
                Field_map::$proeject_type,
                Sql_tool::SUM(Field_map::$item_total_score)
                => Field_map::$item_total_score,
                Field_map::$sp_url,
                Sql_tool::SUM(Field_map::$most_kf)
                => Field_map::$most_kf,
                Field_map::$kp_time,
                Sql_tool::SUM(Field_map::glsp('a')),
                Sql_tool::SUM(Field_map::glsp('b')),
                Sql_tool::SUM(Field_map::glsp('c')),
                Sql_tool::SUM(Field_map::glsp('d')),
                Sql_tool::SUM(Field_map::glsp('e')),
                Sql_tool::SUM(Field_map::glsp('f')),
                Sql_tool::SUM(Field_map::glsp('g')),
                Sql_tool::SUM(Field_map::glsp('h')),
                Sql_tool::SUM(Field_map::glsp('i'))
            ],
            [
                Field_map::$director,
                Field_map::$taskId
            ]
        )->each_row($callback);


        //->each_row($callback);
    }

    public static function count_xzcf_by_date($sqltool, $date_arr, $callback)
    {
        self::count_xzcf($sqltool, $callback,
            Table_group::format_date(
                Gzpc_xmxx_xzcf_map::$overTime,
                $date_arr,
                true
            )
        );
    }

    public static function count_hzdc_by_date($sqltool, $date_arr, $callback)
    {
        self::count_hzdc($sqltool, $callback,
            Table_group::format_date(
                Gzpc_xmxx_hzdc_map::$EndDate,
                $date_arr,
                true
            )
        );
    }

    public static function count_hzdc_fh_by_date($sqltool, $date_arr, $callback)
    {
        self::count_hzdc_fh($sqltool, $callback,
            Table_group::format_date(
                Gzpc_xmxx_hzdc_fh_map::$CompleteDate,
                $date_arr,
                true
            )
        );
    }

    public static function count_bacc_by_date($sqltool, $date_arr, $callback)
    {
        self::count_bacc($sqltool, $callback,
            Table_group::format_date(
                Gzpc_xmxx_bacc_map::$overTime,
                $date_arr,
                true
            )
        );
    }

    public static function count_jdjc_by_date($sqltool, $date_arr, $callback)
    {
        self::count_jdjc($sqltool, $callback,
            Table_group::format_date(
                Gzpc_xmxx_jdjc_map::$overTime,
                $date_arr,
                true
            )
        );
    }

    public static function count_xzqz_by_date($sqltool, $date_arr, $callback)
    {
        self::count_xzqz($sqltool, $callback,
            Table_group::format_date(
                Gzpc_xmxx_jdjc_map::$overTime,
                $date_arr,
                true
            )
        );
    }

    public static function count_aqjc_by_date($sqltool, $date_arr, $callback)
    {
        self::count_aqjc($sqltool, $callback,
            Table_group::format_date(
                Gzpc_xmxx_aqjc_map::$overTime,
                $date_arr,
                true
            )
        );
    }

    public static function count_shys_by_date($sqltool, $date_arr, $callback)
    {
        self::count_shys($sqltool, $callback,
            Table_group::format_date(
                Gzpc_xmxx_shys_map::$overTime,
                $date_arr,
                true
            )
        );
    }

    public static function xzcf_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfsp_xzcf_score_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfsp_xzcf_score_map::$OVERTIME,
            $date
        );
    }

    public static function jdjc_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfsp_jdjc_score_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfsp_jdjc_score_map::$OVERTIME,
            $date
        );
    }

    public static function xzqz_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfsp_xzqz_score_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfsp_xzqz_score_map::$OVERTIME,
            $date
        );
    }

    public static function hzdc_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfsp_hzdc_score_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfsp_hzdc_score_map::$OVERTIME,
            $date
        );
    }

    public static function bacc_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfsp_bacc_score_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfsp_bacc_score_map::$OVER_TIME,
            $date
        );
    }

    public static function jsys_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfsp_jsys_score_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfsp_jsys_score_map::$over_time,
            $date
        );
    }

    public static function aqjc_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfsp_aqjc_score_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfsp_aqjc_score_map::$OVERTIME,
            $date
        );
    }

    public static function hz_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfsp_hz_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfsp_hz_map::$SJ,
            $date
        );
    }

    public static function group_insert($db, $date)
    {
        $sqlTool = Table_group::sqlTool_build($db);
        $hz_table = (new Table(Zfsp_hz_map::$table_name, $sqlTool));
        $res = $hz_table
            ->group_query(
                [
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_jdjc) => 'jdjc_',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_jsys) => 'jsys_',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_hzdcc) => 'hzdc_',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_bacc) => 'bacc_',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_xzcf) => 'xzcf_',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_xzqz) => 'xzqz_',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_jdjc_truescore) => 'jdjc',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_jsys_truescore) => 'jsys',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_hzdc_truescore) => 'hzdc',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_bacc_truescore) => 'bacc',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_xzcf_truescore) => 'xzcf',
                    Sql_tool::SUM(Zfsp_hz_map::$zfsp_xzqz_truescore) => 'xzqz',
                    Zfsp_hz_map::$name => 'n',
                    Zfsp_hz_map::$SJ => 'y',
                    Zfsp_hz_map::$dd_name => 'd',
                    Sql_tool::SUM(Zfsp_hz_map::$xzcf_count) => 'xzcf_c',
                    Sql_tool::SUM(Zfsp_hz_map::$jsys_count) => 'jsys_c',
                    Sql_tool::SUM(Zfsp_hz_map::$hzdc_count) => 'hzdc_c',
                    Sql_tool::SUM(Zfsp_hz_map::$bacc_count) => 'bacc_c',
                    Sql_tool::SUM(Zfsp_hz_map::$jdjc_count) => 'jdjc_c',
                    Sql_tool::SUM(Zfsp_hz_map::$xzqz_count) => 'xzqz_c'
                ],
                [
                    Zfsp_hz_map::$name,
                    Zfsp_hz_map::$SJ,
                ],
                parent::format_date(
                    Zfsp_hz_map::$SJ,
                    $date,
                    true
                )
            );


//        $sqlTool::$isDev = false;

        self::hz_clear($sqlTool, $date);


        echo "\nzfxl_hz : insert finished \n";

        $sql = '';

        $res->each_row(function ($row) use (&$sql) {
            $sql .= ',(' .
                $row['jdjc_'] . ',' .
                $row['jsys_'] . ',' .
                $row['hzdc_'] . ',' .
                $row['bacc_'] . ',' .
                $row['xzcf_'] . ',' .
                $row['xzqz_'] . ',' .

                ($row['jdjc']) . ',' .
                ($row['jsys']) . ',' .
                ($row['hzdc']) . ',' .
                ($row['bacc']) . ',' .
                ($row['xzcf']) . ',' .
                ($row['xzqz']) . ',' .

                (
                    ($row['jdjc']) +
                    ($row['jsys']) +
                    ($row['hzdc']) +
                    ($row['bacc']) +
                    ($row['xzqz']) +
                    ($row['xzcf'])
                ) . ',' .
                Sql_tool::QUOTE($row['n']) . ',' .
                Sql_tool::QUOTE($row['y']) . ',' .
                Sql_tool::QUOTE($row['d']) . ',' .
                self::$coef['jdjc'] . ',' .//Zfxl_hz_map::$jdjc_lxqz,
                self::$coef['jsys'] . ',' .//Zfxl_hz_map::$jsys_lxqz,
                self::$coef['xzcf'] . ',' .//Zfxl_hz_map::$xzcf_lxqz,
                self::$coef['bacc'] . ',' .//Zfxl_hz_map::$bacc_lxqz,
                self::$coef['hzdc'] . ',' .//Zfxl_hz_map::$hzdc_lxqz
                self::$coef['xzqz'] . ',' .//Zfxl_hz_map::$hzdc_lxqz
                $row['bacc_c'] . ',' .
                $row['jdjc_c'] . ',' .
                $row['hzdc_c'] . ',' .
                $row['xzcf_c'] . ',' .
                $row['jsys_c'] . ',' .
                $row['xzqz_c'] .
                ')';
        });

        if ($sql != '')
            return $hz_table->multi_insert(
                [
                    Zfsp_hz_map::$zfsp_jdjc,
                    Zfsp_hz_map::$zfsp_jsys,
                    Zfsp_hz_map::$zfsp_hzdcc,
                    Zfsp_hz_map::$zfsp_bacc,
                    Zfsp_hz_map::$zfsp_xzcf,
                    Zfsp_hz_map::$zfsp_xzqz,

                    Zfsp_hz_map::$zfsp_jdjc_truescore,
                    Zfsp_hz_map::$zfsp_jsys_truescore,
                    Zfsp_hz_map::$zfsp_hzdc_truescore,
                    Zfsp_hz_map::$zfsp_bacc_truescore,
                    Zfsp_hz_map::$zfsp_xzcf_truescore,
                    Zfsp_hz_map::$zfsp_xzqz_truescore,

                    Zfsp_hz_map::$zfsp_hz,
                    Zfsp_hz_map::$name,
                    Zfsp_hz_map::$SJ,
                    Zfsp_hz_map::$dd_name,

                    Zfsp_hz_map::$jdjc_lxqz,
                    Zfsp_hz_map::$jsys_lxqz,
                    Zfsp_hz_map::$xzcf_lxqz,
                    Zfsp_hz_map::$bacc_lxqz,
                    Zfsp_hz_map::$hzdc_lxqz,
                    Zfsp_hz_map::$xzqz_lxqz,
                    //count
                    Zfsp_hz_map::$bacc_count,
                    Zfsp_hz_map::$jdjc_count,
                    Zfsp_hz_map::$hzdc_count,
                    Zfsp_hz_map::$xzcf_count,
                    Zfsp_hz_map::$jsys_count,
                    Zfsp_hz_map::$xzqz_count,
                ],
                substr($sql, 1)
            );

        return 0;
    }

    /**
     * @param Sql_tool $sqltool
     */
    public static function sp_insert($sqltool)
    {
        $xzcf = new Table(Zfsp_xzcf_sp_map::$table_name, $sqltool);
        $jdjc = new Table(Zfsp_jdjc_sp_map::$table_name, $sqltool);
        $jsys = new Table(Zfsp_jsys_sp_map::$table_name, $sqltool);
        $aqjc = new Table(Zfsp_aqjc_sp_map::$table_name, $sqltool);
        $hzdc = new Table(Zfsp_hzdc_sp_map::$table_name, $sqltool);
        $bacc = new Table(Zfsp_bacc_sp_map::$table_name, $sqltool);

        $xzcf->truncate();
        $xzcf->dml(
            'INSERT INTO zfsp_xzcf_sp 
(Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_Result,kptime) 
SELECT Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_Result,kptime FROM kpdf_glsp_xzcf '
        );

        $jdjc->truncate();
        $jdjc->dml(
            'INSERT INTO zfsp_jdjc_sp 
(Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_j,glsp_k,glsp_l,glsp_m,glsp_n,glsp_o,glsp_p,glsp_q,glsp_Result,kptime) 
SELECT Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_j,glsp_k,glsp_l,glsp_m,glsp_n,glsp_o,glsp_p,glsp_q,glsp_Result,kptime FROM kpdf_glsp_jdjc '
        );

        $bacc->truncate();
        $bacc->dml(
            'INSERT INTO zfsp_bacc_sp 
(Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_j,glsp_k,glsp_l,glsp_m,glsp_n,glsp_Result,kptime) 
SELECT Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_j,glsp_k,glsp_l,glsp_m,glsp_n,glsp_Result,kptime FROM kpdf_glsp_bacc '
        );

        $jsys->truncate();
        $jsys->dml(
            'INSERT INTO zfsp_jsys_sp 
(Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_j,glsp_k,glsp_l,glsp_m,glsp_n,glsp_o,glsp_Result,kptime) 
SELECT Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_j,glsp_k,glsp_l,glsp_m,glsp_n,glsp_o,glsp_Result,kptime FROM kpdf_glsp_jsys '
        );

        $aqjc->truncate();
        $aqjc->dml(
            'INSERT INTO zfsp_aqjc_sp 
(Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_Result,kptime) 
SELECT Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_Result,kptime FROM kpdf_glsp_aqjc '
        );

        $hzdc->truncate();
        $hzdc->dml(
            'INSERT INTO zfsp_hzdc_sp 
(Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_j,glsp_k,glsp_l,glsp_Result,kptime) 
SELECT Item_num,sp_url,Most_Kf,glsp_a,glsp_b,glsp_c,glsp_d,glsp_e,glsp_f,glsp_g,glsp_h,glsp_i,glsp_j,glsp_k,glsp_l,glsp_Result,kptime FROM kpdf_glsp_hzdc '
        );
    }
}