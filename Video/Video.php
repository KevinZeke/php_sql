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

class Video extends Table_group
{

    public static $police_dd_map;

    public static function row_handel($row, &$sql, $type)
    {
//        $type = ($type == 'hzdc_fh' ? 'hzdc' : $type);
        if (!$row[Field_map::$director] || $row[Field_map::$director] == '') return;
        $directors = Table_group::format_zhu_xie($row[Field_map::$director]);
        $param = '';
        if (array_key_exists(Field_map::$hz_type, $row)) {
            $param = $row[Field_map::$hz_type];
        } elseif (array_key_exists(Field_map::$proeject_type, $row)) {
            $param = $row[Field_map::$proeject_type];
        }
        $score = self::coef_count($type == 'hzdc_fh' ? 'hzdc' : $type, $row[Field_map::$item_total_score], $param);
        $dd = array_key_exists($directors->zhu, self::$police_dd_map) ? self::$police_dd_map[$directors->zhu] : '';
        $sql .= Sql_tool::format_insert_value([
            $score['zhu'] * self::$coef[$type == 'hzdc_fh' ? 'hzdc' : $type],
            '1',
            Sql_tool::QUOTE($row[Field_map::$over_time]),
            Sql_tool::QUOTE($dd),
            Sql_tool::QUOTE($directors->zhu)
        ]);
        foreach ($directors->xie as $name) {
            $dd = array_key_exists($name, self::$police_dd_map) ? self::$police_dd_map[$name] : '';
            $sql .= Sql_tool::format_insert_value([
                $score['xie'] * self::$coef[$type == 'hzdc_fh' ? 'hzdc' : $type],
                '1',
                Sql_tool::QUOTE($row[Field_map::$over_time]),
                Sql_tool::QUOTE($dd),
                Sql_tool::QUOTE($name)
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
            'SELECT * FROM `qz_zfsp`'
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
        } elseif ($project_type == '认定复核' || $project_type == '复核')
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
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_xzcf($sql_tool, $callback, $param = '')
    {
        (new Table(Gzpc_xmxx_xzcf_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_glsp_xzcf_map::$table_name,
                [
                    Gzpc_xmxx_xzcf_map::$director => Field_map::$director,
//                    Gzpc_xmxx_xzcf_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_xzcf_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_xzcf_map::$taskId => Field_map::$taskId,
                    Kpdf_glsp_xzcf_map::$glsp_Result => Field_map::$item_total_score
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_xzcf_map::$taskId
                    => Kpdf_glsp_xzcf_map::$Item_num
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
                Kpdf_glsp_jdjc_map::$table_name,
                [
                    Gzpc_xmxx_jdjc_map::$director => Field_map::$director,
//                    Gzpc_xmxx_jdjc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_jdjc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_jdjc_map::$projectId => Field_map::$taskId,
                    Gzpc_xmxx_jdjc_map::$projectType => Field_map::$proeject_type,
                    Kpdf_glsp_jdjc_map::$glsp_Result => Field_map::$item_total_score
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_jdjc_map::$projectId
                    => Kpdf_glsp_jdjc_map::$Item_num
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
                Kpdf_glsp_hzdc_map::$table_name,
                [
                    Gzpc_xmxx_hzdc_map::$Director => Field_map::$director,
//                    Gzpc_xmxx_hzdc_map::$CompleteDate => Field_map::$over_time,
                    Gzpc_xmxx_hzdc_map::$EndDate => Field_map::$over_time,
                    Gzpc_xmxx_hzdc_map::$taskId => Field_map::$taskId,
                    Gzpc_xmxx_hzdc_map::$HzdcType => Field_map::$hz_type,
                    Kpdf_glsp_hzdc_map::$glsp_Result => Field_map::$item_total_score
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_hzdc_map::$taskId
                    => Kpdf_glsp_hzdc_map::$Item_num
                ])
                . $param
            )->each_row($callback);
    }

    /**
     * @param Sql_tool $sql_tool
     * @param $callback
     * @param string $param
     * @return int|null|SqlResult|string
     */
    public static function count_hzdc_fh($sql_tool, $callback, $param = '')
    {
        (new Table(Gzpc_xmxx_hzdc_fh_map::$table_name, Table_group::sqlTool_build($sql_tool)))
            ->right_join(
                Kpdf_glsp_hzdc_map::$table_name,
                [
                    Gzpc_xmxx_hzdc_fh_map::$Director => Field_map::$director,
//                    Gzpc_xmxx_hzdc_map::$CompleteDate => Field_map::$over_time,
                    Gzpc_xmxx_hzdc_fh_map::$CompleteDate => Field_map::$over_time,
                    Gzpc_xmxx_hzdc_fh_map::$taskId => Field_map::$taskId,
                    Gzpc_xmxx_hzdc_fh_map::$HzdcType => Field_map::$hz_type,
                    Kpdf_glsp_hzdc_map::$glsp_Result => Field_map::$item_total_score
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_hzdc_fh_map::$taskId
                    => Kpdf_glsp_hzdc_map::$Item_num
                ])
                . $param
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
                Kpdf_glsp_bacc_map::$table_name,
                [
                    Gzpc_xmxx_bacc_map::$director => Field_map::$director,
//                    Gzpc_xmxx_bacc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_bacc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_bacc_map::$projectId => Field_map::$taskId,
                    Kpdf_glsp_bacc_map::$glsp_Result => Field_map::$item_total_score
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_bacc_map::$projectId
                    => Kpdf_glsp_bacc_map::$Item_num
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
                Kpdf_glsp_jsys_map::$table_name,
                [
                    Gzpc_xmxx_shys_map::$director => Field_map::$director,
//                    Gzpc_xmxx_shys_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_shys_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_shys_map::$projectId => Field_map::$taskId,
                    Kpdf_glsp_jsys_map::$glsp_Result => Field_map::$item_total_score
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_shys_map::$projectId
                    => Kpdf_glsp_jsys_map::$Item_num
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
                Kpdf_glsp_aqjc_map::$table_name,
                [
                    Gzpc_xmxx_aqjc_map::$director => Field_map::$director,
//                    Gzpc_xmxx_aqjc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_aqjc_map::$overTime => Field_map::$over_time,
                    Gzpc_xmxx_aqjc_map::$projectId => Field_map::$taskId,
                    Kpdf_glsp_aqjc_map::$glsp_Result => Field_map::$item_total_score
                ],
                Sql_tool::ON([
                    Gzpc_xmxx_aqjc_map::$projectId
                    => Kpdf_glsp_aqjc_map::$Item_num
                ]) . $param
            )->each_row($callback);
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
        self::count_hzdc($sqltool, $callback,
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
}