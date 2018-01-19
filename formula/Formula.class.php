<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/17
 * Time: 23:54
 */

class Formula
{
    private function __construct()
    {
        //公式类禁止实例化
    }

    static function formatFormula($formula)
    {
        $str = array();
        foreach ($formula as $t => $f) {
            array_push($str, " $t=$f ");
        }
        return implode(',', $str);
    }

    // +
    static function plus($a)
    {
        return '(' . implode('+', $a) . ')';
    }

    // -
    static function minus($a)
    {
        return '(' . implode('-', $a) . ')';
    }

    // *
    static function divide($a)
    {
        return implode('/', $a);
    }

    // /
    static function mul($a)
    {
        return implode('*', $a);
    }
}

class Trans_model {
    private function __construct()
    {
        //禁止实例化
    }
}