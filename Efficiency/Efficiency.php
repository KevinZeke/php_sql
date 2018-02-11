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
require_once __DIR__ . '/../map/Kpdf_xlkp.map.php';
require_once __DIR__ . '/../map/Zfxl_xzcf.map.php';
require_once __DIR__ . '/../map/Zfxl_hzdc.map.php';
require_once __DIR__ . '/../map/Zfxl_jsys.map.php';
require_once __DIR__ . '/../map/Zfxl_bacc.map.php';
require_once __DIR__ . '/../map/Zfxl_jdjc.map.php';
require_once __DIR__ . '/../map/Zfxl_hz.map.php';

class Efficiency extends Table_group
{

    public static $police_dd_map;

    public static function item_hz_row_handel(&$sql)
    {

    }

    public static function row_handel($row, &$hz_sql, &$item_sql, $type)
    {
        $directors = Table_group::format_zhu_xie($row[Field_map::$director]);
        $param = '';
        if (array_key_exists(Field_map::$hz_type, $row)) {
            $param = $row[Field_map::$hz_type];
        } elseif (array_key_exists(Field_map::$proeject_type, $row)) {
            $param = $row[Field_map::$proeject_type];
        }
        $score = Efficiency::coef_count($type, $row[Field_map::$item_total_score], $param);
        $dd = array_key_exists($directors->zhu, self::$police_dd_map) ? self::$police_dd_map[$directors->zhu] : '';
        //hz_sql
        $hz_sql .= Sql_tool::format_insert_value([
            $score['zhu'] * self::$coef[$type],
            '1',
            Sql_tool::QUOTE($row[Field_map::$over_time]),
            Sql_tool::QUOTE($dd),
            Sql_tool::QUOTE($directors->zhu)
        ]);
        if ($type == 'xzcf')
            //item_sql
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu), //name
                Sql_tool::QUOTE($dd), //dadui
                Sql_tool::QUOTE($row[Field_map::$taskId]), //xmbh
                Sql_tool::QUOTE($row[Field_map::$unit_name]), //cfdx
                Sql_tool::QUOTE($row[Field_map::$time_limit]), //baqx
                Sql_tool::QUOTE($row[Field_map::$cj_time]), //cjtime
                Sql_tool::QUOTE($row[Field_map::$status]), //cfjg
                Sql_tool::QUOTE($row[Field_map::$over_time]), //over_time
                Sql_tool::QUOTE($row[Field_map::$director]), //cbr
                Sql_tool::QUOTE($row[Field_map::$complete_time_score]), //c_t_score
                Sql_tool::QUOTE($row[Field_map::$complete_time_count]), //c_t_count
                Sql_tool::QUOTE($row[Field_map::$send_to_cbr]), //send_cbr_score
                Sql_tool::QUOTE($row[Field_map::$send_to_cbr_count]), //send_cbr_count
                Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDSCORE]), //send_cbrjld_score
                Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDCount]), //send_cbrjld_count
                Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGSCORE]), //send_dd_score
                Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGCount]), //send_dd_count
                $score['zhu'],                                          //s
                $score['zhu'] * self::$coef[$type]                      //true s
            ]);
        if ($type == 'jdjc')
            //item_sql
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu), //name
                Sql_tool::QUOTE($dd), //dadui
                Sql_tool::QUOTE($row[Field_map::$taskId]), //xmbh
                Sql_tool::QUOTE($row[Field_map::$proeject_type]), //xmlx
                Sql_tool::QUOTE($row[Field_map::$unit_name]), //dwmc
                Sql_tool::QUOTE($row[Field_map::$time_limit]), //jcqx
                Sql_tool::QUOTE($row[Field_map::$status]), //jxqk
                Sql_tool::QUOTE($row[Field_map::$over_time]), //over_time
                Sql_tool::QUOTE($row[Field_map::$director]), //cbr
                Sql_tool::QUOTE($row[Field_map::$complete_time_score]), //c_t_score
                Sql_tool::QUOTE($row[Field_map::$complete_time_count]), //c_t_count
                Sql_tool::QUOTE($row[Field_map::$send_to_cbr]), //send_cbr_score
                Sql_tool::QUOTE($row[Field_map::$send_to_cbr_count]), //send_cbr_count
                Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDSCORE]), //send_cbrjld_score
                Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDCount]), //send_cbrjld_count
                Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGSCORE]), //send_dd_score
                Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGCount]), //send_dd_count
                $score['zhu'],                                          //s
                $score['zhu'] * self::$coef[$type]                      //true s
            ]);
        if ($type == 'hzdc')
            //item_sql
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu), //name
                Sql_tool::QUOTE($dd), //dadui
                Sql_tool::QUOTE($row[Field_map::$taskId]), //xmbh
                Sql_tool::QUOTE($row[Field_map::$hz_type]), //xmlx
                Sql_tool::QUOTE($row[Field_map::$hz_fire_object]), //qhsj
                Sql_tool::QUOTE($row[Field_map::$hz_call_time]), //bjsj
                Sql_tool::QUOTE($row[Field_map::$hz_end_date]), //jzsj
                Sql_tool::QUOTE($row[Field_map::$hz_handel_date]), //clsj
                Sql_tool::QUOTE($row[Field_map::$hz_now_status]), //status
                Sql_tool::QUOTE($row[Field_map::$over_time]), //over_time
                Sql_tool::QUOTE($row[Field_map::$director]), //cbr
                Sql_tool::QUOTE($row[Field_map::$complete_time_score]), //c_t_score
                Sql_tool::QUOTE($row[Field_map::$complete_time_count]), //c_t_count
                Sql_tool::QUOTE($row[Field_map::$send_to_cbr]), //send_cbr_score
                Sql_tool::QUOTE($row[Field_map::$send_to_cbr_count]), //send_cbr_count
                Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDSCORE]), //send_cbrjld_score
                Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDCount]), //send_cbrjld_count
                Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGSCORE]), //send_dd_score
                Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGCount]), //send_dd_count
                $score['zhu'],                                          //s
                $score['zhu'] * self::$coef[$type]                     //true s
            ]);
        if ($type == 'bacc')
            //item_sql
            $item_sql .= Sql_tool::format_insert_value([
                Sql_tool::QUOTE($directors->zhu), //name
                Sql_tool::QUOTE($dd), //dadui
                Sql_tool::QUOTE($row[Field_map::$taskId]), //xmbh
                Sql_tool::QUOTE($row[Field_map::$task_name]), //gcmc
                Sql_tool::QUOTE($row[Field_map::$xm_result]), //xmjg
                Sql_tool::QUOTE($row[Field_map::$create_time]), //slsj
                Sql_tool::QUOTE($row[Field_map::$over_time]), //jgys
                Sql_tool::QUOTE($row[Field_map::$director]), //cbr
                Sql_tool::QUOTE($row[Field_map::$complete_time_score]), //c_t_score
                Sql_tool::QUOTE($row[Field_map::$complete_time_count]), //c_t_count
                Sql_tool::QUOTE($row[Field_map::$send_to_cbr]), //send_cbr_score
                Sql_tool::QUOTE($row[Field_map::$send_to_cbr_count]), //send_cbr_count
                Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDSCORE]), //send_cbrjld_score
                Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDCount]), //send_cbrjld_count
                Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGSCORE]), //send_dd_score
                Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGCount]), //send_dd_count
                $score['zhu'],                                          //s
                $score['zhu'] * self::$coef[$type]                      //true s
            ]);
        foreach ($directors->xie as $name) {
            $dd = array_key_exists($name, self::$police_dd_map) ? self::$police_dd_map[$name] : '';
            //hz_sql
            $hz_sql .= Sql_tool::format_insert_value([
                $score['xie'] * self::$coef[$type],
                '1',
                Sql_tool::QUOTE($row[Field_map::$over_time]),
                Sql_tool::QUOTE($dd),
                Sql_tool::QUOTE($name)
            ]);
            if ($type == 'xzcf')
                //item_sql
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name), //name
                    Sql_tool::QUOTE($dd), //dadui
                    Sql_tool::QUOTE($row[Field_map::$taskId]), //xmbh
                    Sql_tool::QUOTE($row[Field_map::$unit_name]), //cfdx
                    Sql_tool::QUOTE($row[Field_map::$time_limit]), //baqx
                    Sql_tool::QUOTE($row[Field_map::$cj_time]), //cjtime
                    Sql_tool::QUOTE($row[Field_map::$status]), //cfjg
                    Sql_tool::QUOTE($row[Field_map::$over_time]), //over_time
                    Sql_tool::QUOTE($row[Field_map::$director]), //cbr
                    Sql_tool::QUOTE($row[Field_map::$complete_time_score]), //c_t_score
                    Sql_tool::QUOTE($row[Field_map::$complete_time_count]), //c_t_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_cbr]), //send_cbr_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_cbr_count]), //send_cbr_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDSCORE]), //send_cbrjld_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDCount]), //send_cbrjld_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGSCORE]), //send_dd_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGCount]), //send_dd_count
                    $score['xie'],
                    $score['xie'] * self::$coef[$type]
                ]);
            if ($type == 'jdjc')
                //item_sql
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name), //name
                    Sql_tool::QUOTE($dd), //dadui
                    Sql_tool::QUOTE($row[Field_map::$taskId]), //xmbh
                    Sql_tool::QUOTE($row[Field_map::$proeject_type]), //xmlx
                    Sql_tool::QUOTE($row[Field_map::$unit_name]), //dwmc
                    Sql_tool::QUOTE($row[Field_map::$time_limit]), //jcqx
                    Sql_tool::QUOTE($row[Field_map::$status]), //jxqk
                    Sql_tool::QUOTE($row[Field_map::$over_time]), //over_time
                    Sql_tool::QUOTE($row[Field_map::$director]), //cbr
                    Sql_tool::QUOTE($row[Field_map::$complete_time_score]), //c_t_score
                    Sql_tool::QUOTE($row[Field_map::$complete_time_count]), //c_t_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_cbr]), //send_cbr_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_cbr_count]), //send_cbr_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDSCORE]), //send_cbrjld_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDCount]), //send_cbrjld_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGSCORE]), //send_dd_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGCount]), //send_dd_count
                    $score['xie'],                                          //s
                    $score['xie'] * self::$coef[$type]                     //true s
                ]);
            if ($type == 'hzdc')
                //item_sql
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name), //name
                    Sql_tool::QUOTE($dd), //dadui
                    Sql_tool::QUOTE($row[Field_map::$taskId]), //xmbh
                    Sql_tool::QUOTE($row[Field_map::$hz_type]), //xmlx
                    Sql_tool::QUOTE($row[Field_map::$hz_fire_object]), //qhsj
                    Sql_tool::QUOTE($row[Field_map::$hz_call_time]), //bjsj
                    Sql_tool::QUOTE($row[Field_map::$hz_end_date]), //jzsj
                    Sql_tool::QUOTE($row[Field_map::$hz_handel_date]), //clsj
                    Sql_tool::QUOTE($row[Field_map::$hz_now_status]), //status
                    Sql_tool::QUOTE($row[Field_map::$over_time]), //over_time
                    Sql_tool::QUOTE($row[Field_map::$director]), //cbr
                    Sql_tool::QUOTE($row[Field_map::$complete_time_score]), //c_t_score
                    Sql_tool::QUOTE($row[Field_map::$complete_time_count]), //c_t_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_cbr]), //send_cbr_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_cbr_count]), //send_cbr_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDSCORE]), //send_cbrjld_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDCount]), //send_cbrjld_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGSCORE]), //send_dd_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGCount]), //send_dd_count
                    $score['xie'],                                          //s
                    $score['xie'] * self::$coef[$type]                     //true s
                ]);
            if ($type == 'bacc')
                //item_sql
                $item_sql .= Sql_tool::format_insert_value([
                    Sql_tool::QUOTE($name), //name
                    Sql_tool::QUOTE($dd), //dadui
                    Sql_tool::QUOTE($row[Field_map::$taskId]), //xmbh
                    Sql_tool::QUOTE($row[Field_map::$task_name]), //gcmc
                    Sql_tool::QUOTE($row[Field_map::$xm_result]), //xmjg
                    Sql_tool::QUOTE($row[Field_map::$create_time]), //slsj
                    Sql_tool::QUOTE($row[Field_map::$over_time]), //jgys
                    Sql_tool::QUOTE($row[Field_map::$director]), //cbr
                    Sql_tool::QUOTE($row[Field_map::$complete_time_score]), //c_t_score
                    Sql_tool::QUOTE($row[Field_map::$complete_time_count]), //c_t_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_cbr]), //send_cbr_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_cbr_count]), //send_cbr_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDSCORE]), //send_cbrjld_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_CBRJLDCount]), //send_cbrjld_count
                    Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGSCORE]), //send_dd_score
                    Sql_tool::QUOTE($row[Field_map::$send_to_DDZDZGCount]), //send_dd_count
                    $score['xie'],                                          //s
                    $score['xie'] * self::$coef[$type]                      //true s
                ]);
        }
    }

    public static $coef = null;

    /**
     * @param Sql_tool $sqlTool
     * @internal param null $coef
     */
    public static function set_coef($sqlTool)
    {
        self::$coef = $sqlTool->execute_dql_res(
            'SELECT * FROM `qz_zfxl`'
        )->fetch();
    }

    public static function get_jdjc_xx_coef($project_type)
    {
        $xx_coef = 1;
        if ($project_type == '消防监督抽查') {
            $xx_coef = (double)self::$coef['rcjdjc'];
        } elseif ($project_type == '对举报、投诉的检查') {
            $xx_coef = (double)self::$coef['jbts'];
        } elseif ($project_type == '大型群众性活动举办前的检查') {
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
            $project_type == '其他检查(复查)') {
            $xx_coef = (double)self::$coef['fc'];
        } elseif ($project_type == '公众聚集场所投入使用、营业前消防安全检查') {
            $xx_coef = (double)self::$coef['trsy'];
        }
        return $xx_coef;
    }

    /**
     * @param string $project_type
     * @return double
     */
    public static function get_hzdc_xx_coef($project_type)
    {
        if ($project_type == '一般' || $project_type == '一般调查') {
            return self::$coef['ybdc'];
        } elseif ($project_type == '认定复合')
            return self::$coef['rdfh'];
        return self::$coef['jydc'];
    }

    /**
     * @param string $item_name
     * @param double $total_score
     * @param string $project_type
     * @return array|bool
     * @internal param float $coef
     */
    public static function coef_count($item_name, $total_score, $project_type = '')
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
            case 'hzdc':
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
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_xzcf($sql_tool, $callback, $param = '')
    {
        (new Table(Gzpc_xmxx_xzcf_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_xlkp_map::$table_name,
                [
                    Gzpc_xmxx_xzcf_map::$director => Field_map::$director,
                    Gzpc_xmxx_xzcf_map::$unitName => Field_map::$unit_name,
                    Gzpc_xmxx_xzcf_map::$timeLimit => Field_map::$time_limit,
                    Gzpc_xmxx_xzcf_map::$cjTime => Field_map::$cj_time,
                    Gzpc_xmxx_xzcf_map::$status => Field_map::$status,
//                    Gzpc_xmxx_xzcf_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_xzcf_map::$taskId => Field_map::$taskId,
                    Kpdf_xlkp_map::$CompleteTime => Field_map::$over_time,
                    Kpdf_xlkp_map::$xlkp_Result => Field_map::$item_total_score,
                    Kpdf_xlkp_map::$CompleteTimeSCORE => Field_map::$complete_time_score,
                    Kpdf_xlkp_map::$CompleteTimeCount => Field_map::$complete_time_count,
                    Kpdf_xlkp_map::$SendToCBRSCORE => Field_map::$send_to_cbr,
                    Kpdf_xlkp_map::$SendToCBRCount => Field_map::$send_to_cbr_count,
                    Kpdf_xlkp_map::$SendToCBRJLDCount => Field_map::$send_to_CBRJLDCount,
                    Kpdf_xlkp_map::$SendToCBRJLDSCORE => Field_map::$send_to_CBRJLDSCORE,
                    Kpdf_xlkp_map::$SendToDDZDZGCount => Field_map::$send_to_DDZDZGCount,
                    Kpdf_xlkp_map::$SendToDDZDZGSCORE => Field_map::$send_to_DDZDZGSCORE


                ],
                Sql_tool::ON([
                    Gzpc_xmxx_xzcf_map::$taskId
                    => Kpdf_xlkp_map::$Item_num
                ])
                . Sql_tool::WHERE([
                    Kpdf_xlkp_map::$ItemType => 'xzcf'
                ]) . $param
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
        (new Table(Gzpc_xmxx_jdjc_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_xlkp_map::$table_name,
                [
                    Gzpc_xmxx_jdjc_map::$director => Field_map::$director,
//                    Gzpc_xmxx_jdjc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_jdjc_map::$projectId => Field_map::$taskId,
                    Gzpc_xmxx_jdjc_map::$projectType => Field_map::$proeject_type,
                    Gzpc_xmxx_jdjc_map::$unitName => Field_map::$unit_name,
                    Gzpc_xmxx_jdjc_map::$status => Field_map::$status,
                    Gzpc_xmxx_jdjc_map::$timeLimit => Field_map::$time_limit,
                    Gzpc_xmxx_jdjc_map::$createTime => Field_map::$cj_time,
                    Kpdf_xlkp_map::$xlkp_Result => Field_map::$item_total_score,
                    Kpdf_xlkp_map::$CompleteTime => Field_map::$over_time,
                    Kpdf_xlkp_map::$CompleteTimeSCORE => Field_map::$complete_time_score,
                    Kpdf_xlkp_map::$CompleteTimeCount => Field_map::$complete_time_count,
                    Kpdf_xlkp_map::$SendToCBRSCORE => Field_map::$send_to_cbr,
                    Kpdf_xlkp_map::$SendToCBRCount => Field_map::$send_to_cbr_count,
                    Kpdf_xlkp_map::$SendToCBRJLDCount => Field_map::$send_to_CBRJLDCount,
                    Kpdf_xlkp_map::$SendToCBRJLDSCORE => Field_map::$send_to_CBRJLDSCORE,
                    Kpdf_xlkp_map::$SendToDDZDZGCount => Field_map::$send_to_DDZDZGCount,
                    Kpdf_xlkp_map::$SendToDDZDZGSCORE => Field_map::$send_to_DDZDZGSCORE
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_jdjc_map::$projectId
                    => Kpdf_xlkp_map::$Item_num
                ])
                . Sql_tool::WHERE([
                    Kpdf_xlkp_map::$ItemType => 'jdjc'
                ]) . $param
            )->each_row($callback);
    }


    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_hzdc($sql_tool, $callback, $param = '')
    {
        (new Table(Gzpc_xmxx_hzdc_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_xlkp_map::$table_name,
                [
                    Gzpc_xmxx_hzdc_map::$Director => Field_map::$director,
//                    Gzpc_xmxx_hzdc_map::$CompleteDate => Field_map::$over_time,
                    Gzpc_xmxx_hzdc_map::$taskId => Field_map::$taskId,
                    Gzpc_xmxx_hzdc_map::$HzdcType => Field_map::$hz_type,
                    Gzpc_xmxx_hzdc_map::$FireTime => Field_map::$hz_call_time,
                    Gzpc_xmxx_hzdc_map::$EndDate => Field_map::$hz_end_date,
                    Gzpc_xmxx_hzdc_map::$NowStatus => Field_map::$hz_now_status,
                    Gzpc_xmxx_hzdc_map::$HandleDate => Field_map::$hz_handel_date,
                    Gzpc_xmxx_hzdc_map::$FirePart => Field_map::$hz_fire_object,
                    Kpdf_xlkp_map::$xlkp_Result => Field_map::$item_total_score,
                    Kpdf_xlkp_map::$CompleteTime => Field_map::$over_time,
                    Kpdf_xlkp_map::$CompleteTimeSCORE => Field_map::$complete_time_score,
                    Kpdf_xlkp_map::$CompleteTimeCount => Field_map::$complete_time_count,
                    Kpdf_xlkp_map::$SendToCBRSCORE => Field_map::$send_to_cbr,
                    Kpdf_xlkp_map::$SendToCBRCount => Field_map::$send_to_cbr_count,
                    Kpdf_xlkp_map::$SendToCBRJLDCount => Field_map::$send_to_CBRJLDCount,
                    Kpdf_xlkp_map::$SendToCBRJLDSCORE => Field_map::$send_to_CBRJLDSCORE,
                    Kpdf_xlkp_map::$SendToDDZDZGCount => Field_map::$send_to_DDZDZGCount,
                    Kpdf_xlkp_map::$SendToDDZDZGSCORE => Field_map::$send_to_DDZDZGSCORE
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_hzdc_map::$taskId
                    => Kpdf_xlkp_map::$Item_num
                ])
                . Sql_tool::WHERE([
                    Kpdf_xlkp_map::$ItemType => 'hzdc'
                ]) . $param
            )->each_row($callback);
    }

    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_bacc($sql_tool, $callback, $param = '')
    {
        (new Table(Gzpc_xmxx_bacc_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_xlkp_map::$table_name,
                [
                    Gzpc_xmxx_bacc_map::$director => Field_map::$director,
//                    Gzpc_xmxx_bacc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_bacc_map::$projectId => Field_map::$taskId,
                    Gzpc_xmxx_bacc_map::$projectName => Field_map::$task_name,
                    Gzpc_xmxx_bacc_map::$result => Field_map::$xm_result,
                    Gzpc_xmxx_bacc_map::$status => Field_map::$status,
                    Gzpc_xmxx_bacc_map::$createTime => Field_map::$create_time,
                    Kpdf_xlkp_map::$xlkp_Result => Field_map::$item_total_score,
                    Kpdf_xlkp_map::$CompleteTime => Field_map::$over_time,
                    Kpdf_xlkp_map::$CompleteTimeSCORE => Field_map::$complete_time_score,
                    Kpdf_xlkp_map::$CompleteTimeCount => Field_map::$complete_time_count,
                    Kpdf_xlkp_map::$SendToCBRSCORE => Field_map::$send_to_cbr,
                    Kpdf_xlkp_map::$SendToCBRCount => Field_map::$send_to_cbr_count,
                    Kpdf_xlkp_map::$SendToCBRJLDCount => Field_map::$send_to_CBRJLDCount,
                    Kpdf_xlkp_map::$SendToCBRJLDSCORE => Field_map::$send_to_CBRJLDSCORE,
                    Kpdf_xlkp_map::$SendToDDZDZGCount => Field_map::$send_to_DDZDZGCount,
                    Kpdf_xlkp_map::$SendToDDZDZGSCORE => Field_map::$send_to_DDZDZGSCORE
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_bacc_map::$projectId
                    => Kpdf_xlkp_map::$Item_num
                ])
                . Sql_tool::WHERE([
                    Kpdf_xlkp_map::$ItemType => 'bacc'
                ]) . $param
            )->each_row($callback);
    }


    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_shys($sql_tool, $callback, $param = '')
    {
        (new Table(Gzpc_xmxx_shys_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_xlkp_map::$table_name,
                [
                    Gzpc_xmxx_shys_map::$director => Field_map::$director,
//                    Gzpc_xmxx_shys_map::$overTime => Field_map::$over_time,
                    Kpdf_xlkp_map::$CompleteTime => Field_map::$over_time,
                    Gzpc_xmxx_shys_map::$projectId => Field_map::$taskId,
                    Kpdf_xlkp_map::$xlkp_Result => Field_map::$item_total_score
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_shys_map::$projectId
                    => Kpdf_xlkp_map::$Item_num
                ])
                . Sql_tool::WHERE([
                    Kpdf_xlkp_map::$ItemType => 'shys'
                ]) . $param
            )->each_row($callback);
    }


    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_aqjc($sql_tool, $callback, $param = '')
    {
        (new Table(Gzpc_xmxx_aqjc_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_xlkp_map::$table_name,
                [
                    Gzpc_xmxx_aqjc_map::$director => Field_map::$director,
//                    Gzpc_xmxx_aqjc_map::$overTime => Field_map::$over_time,
                    Kpdf_xlkp_map::$CompleteTime => Field_map::$over_time,
                    Gzpc_xmxx_aqjc_map::$projectId => Field_map::$taskId,
                    Kpdf_xlkp_map::$xlkp_Result => Field_map::$item_total_score
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_aqjc_map::$projectId
                    => Kpdf_xlkp_map::$Item_num
                ])
                . Sql_tool::WHERE([
                    Kpdf_xlkp_map::$ItemType => 'aqjc'
                ]) . $param
            )->each_row($callback);
    }

    public static function count_xzcf_by_date($sqltool, $date_arr, $callback)
    {
        self::count_xzcf($sqltool, $callback,
            Table_group::format_date(
                Kpdf_xlkp_map::$CompleteTime,
                $date_arr,
                true
            )
        );
    }

    public static function count_hzdc_by_date($sqltool, $date_arr, $callback)
    {
        self::count_hzdc($sqltool, $callback,
            Table_group::format_date(
                Kpdf_xlkp_map::$CompleteTime,
                $date_arr,
                true
            )
        );
    }

    public static function count_bacc_by_date($sqltool, $date_arr, $callback)
    {
        self::count_bacc($sqltool, $callback,
            Table_group::format_date(
                Kpdf_xlkp_map::$CompleteTime,
                $date_arr,
                true
            )
        );
    }

    public static function count_jdjc_by_date($sqltool, $date_arr, $callback)
    {
        self::count_jdjc($sqltool, $callback,
            Table_group::format_date(
                Kpdf_xlkp_map::$CompleteTime,
                $date_arr,
                true
            )
        );
    }

    public static function count_aqjc_by_date($sqltool, $date_arr, $callback)
    {
        self::count_aqjc($sqltool, $callback,
            Table_group::format_date(
                Kpdf_xlkp_map::$CompleteTime,
                $date_arr,
                true
            )
        );
    }

    public static function count_shys_by_date($sqltool, $date_arr, $callback)
    {
        self::count_shys($sqltool, $callback,
            Table_group::format_date(
                Kpdf_xlkp_map::$CompleteTime,
                $date_arr,
                true
            )
        );
    }

    public static function xzcf_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfxl_xzcf_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfxl_xzcf_map::$OVERTIME,
            $date
        );
    }

    public static function jdjc_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfxl_jdjc_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfxl_jdjc_map::$OVERTIME,
            $date
        );
    }

    public static function hzdc_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfxl_hzdc_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfxl_hzdc_map::$OVERTIME,
            $date
        );
    }

    public static function bacc_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [
            new Table(Zfxl_bacc_map::$table_name, $sqlTool)
        ];

        Table_group::group_clear(
            $tables,
            Zfxl_bacc_map::$JGYS,
            $date
        );
    }
}