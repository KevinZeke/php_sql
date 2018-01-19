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

    /**
     * 将公式数组格式化为 a=b+c，c=d+e 格式的sql字符串
     * @param $formula
     * @return string
     */
    static function format_formula($formula)
    {
        $str = array();
        foreach ($formula as $t => $f) {
            array_push($str, " $t=$f ");
        }
        return implode(',', $str);
    }

    // 加减乘除函数，用于将公式数组拼接成类似于 a+b+c 的公式字符串
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

/**
 * Class Table_group
 * 表格组基类
 */
class Table_group
{
    private function __construct()
    {
        //禁止实例化
    }
}