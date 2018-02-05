<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/2
 * Time: 15:31
 */

require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../common/common.php';

class Quantity
{

    /**
     * @var string
     */
    protected static $zhu_key = "\(主\)";

    /**
     * @var string
     */
    public static $kpld_prefix = '\'kpdf_\'';

    public static $police_dd_map = null;

    /**
     * @param string $names
     * @return stdClass
     */
    public static function format_zhu_xie($names)
    {
        $names_arr = explode('、', $names);
        $zhuxie = new stdClass();
        $zhuxie->zhu = remove_preg($names_arr[0], self::$zhu_key, '');
        if (count($names_arr) > 1)
            $zhuxie->xie = explode('、', $names_arr[1]);
        else
            $zhuxie->xie = [];
        return $zhuxie;
    }

    /**
     * @param array $result_array
     * @param $xzcf_coef
     * @return Closure
     */
    public static function format_item_flws_func(&$result_array, $xzcf_coef)
    {
        return function ($row) use (&$result_array, $xzcf_coef) {
//            if (!$row[Q_field::$kpld]) return;
            //判断结果数组是否存在该（主办人协办人），无则创建该人键值对
            if (!array_key_exists($row[Q_field::$director], $result_array)) {
                $result_array[$row[Q_field::$director]] = [];
            }
            //判断该人的项目列表中是否存在该项目，无则创建该项目键值对，并将结束时间加入该数组
            if (!array_key_exists(
                $row[Q_field::$taskId],
                $result_array[$row[Q_field::$director]]
            )) {
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]] = [];
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$over_time]
                    = $row[Q_field::$over_time];
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$item_total_score]
                    = 0;
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$flwses] = [];
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$status]
                    = $row[Q_field::$status];
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$cj_time]
                    = $row[Q_field::$cj_time];
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$unit_name]
                    = $row[Q_field::$unit_name];
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$time_limit]
                    = $row[Q_field::$time_limit];
                if (array_key_exists(Q_field::$proeject_type, $row)) {
                    $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$proeject_type]
                        = $row[Q_field::$proeject_type];
                }
            }
            //将当前行的法律文书添加进入该结果
            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$item_total_score]
                += $row[Q_field::$ws_total_score];
            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$real_item_total_score] =
                Quantity::coef_count(
                    'xzcf',
                    $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$item_total_score],
                    $xzcf_coef
                );
            array_push(
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$flwses],
                new Flws(
                    $row[Q_field::$flws_id],
                    $row[Q_field::$ws_total_score],
                    $row[Q_field::$kpld_table]
                )
            );

            return true;
        };

    }

    /**
     * @param Sql_tool $sqltool
     * @param string $item_name
     * @return bool
     */
    public static function get_coef($sqltool, $item_name)
    {
        $sql = null;
        switch ($item_name) {
            case 'xzcf':
                $sql = "SELECT xzcf,zbr,xbr FROM qz_zfzl";
                break;
            case 'jdjc':
                $sql = "SELECT jdjc,zbr,xbr FROM qz_zfzl";
                break;
            default:
                return false;
                break;
        }
        $res = $sqltool->execute_dql_res($sql)->fetch();
        return $res;
    }

    /**
     * @param string $item_name
     * @param double $total_score
     * @param double $coef
     * @return array|bool
     */
    public static function coef_count($item_name, $total_score, $coef)
    {
        switch ($item_name) {
            case 'xzcf':
//                $res = get_coef($sqltool, $item_name);
                $score = [
                    'zhu' => $total_score * (double)$coef['xzcf'] * (double)$coef['zbr'],
                    'xie' => $total_score * (double)$coef['xzcf'] * (double)$coef['xbr']
                ];
                return $score;
                break;
            default:
                return false;
                break;
        }
    }
}
Quantity::$police_dd_map = get_police_dadui_map();

/**
 * 定义常用字段的别名，规避各个表名称不统一的问题
 * Class Q_field
 */
class Q_field
{
    public static $kpld_table = 'ws_table';
    public static $kpld = 'ws_kplb';
    public static $director = 'directors';
    public static $taskId = 'task_id';
    public static $proeject_type = 'project_type';
    public static $time_limit = 'time_limit';
    public static $itemId = 'item_id';
    public static $over_time = 'over_time';
    public static $ws_total_score = 'ws_total_score';
    public static $flws_id = 'flws_id';
    public static $flwses = 'flwses';
    public static $unit_name = 'unit_name';
    public static $cj_time = 'cj_time';
    public static $status = 'status';
    public static $item_total_score = 'item_score';
    public static $real_item_total_score = 'real_item_score';
}

class Flws
{
    public $ws_id;
    public $ws_total_score;
    public $from_table;

    public function __construct($ws_id, $ws_total_score, $from_table)
    {
        $this->ws_id = $ws_id;
        $this->ws_total_score = $ws_total_score;
        $this->from_table = $from_table;
    }
}

class Item
{
    public $flwses = [];
    public $over_time;
    public $item_id;

    public function __construct($item_id, $over_time)
    {
        $this->over_time = $over_time;
        $this->item_id = $item_id;
    }

    public function ws_push($ws)
    {
        array_push($this->flwses, $ws);
    }
}