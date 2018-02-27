<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/13
 * Time: 14:09
 */

require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/../map/Zfzl_hz.map.php';

$db = (new DB())->connect('zxpg_gzpc_db');

echo $db->use_table(

    $db->use_table(Zfzl_hz_map::$table_name)
        ->select('*')
        ->group_by([Zfzl_hz_map::$SJ, Zfzl_hz_map::$name])

    , Zfzl_hz_map::$table_name
)
    ->select('*')
    ->where([Zfzl_hz_map::$name => '曹刚'])
    ->query()
    ->to_json();



