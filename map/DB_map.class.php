<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 18:50
 */

class DB_map
{

    private function __construct()
    {
        //禁止映射类实例化
    }

    static function all($className = '')
    {
        $r = new ReflectionClass($className);
        $sp = $r->getStaticProperties();
        $res = array();
        foreach ($sp as $key => $value) {
            if ($key != 'table_name')
                array_push($res, $value);
        }
        return $res;
    }
//    static function table_field_name($field){
//        return self::tableName.'.'.$field;
//    }
}
