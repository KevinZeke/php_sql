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
     * @param bool $quote 是否添加 '' 符
     * @return string
     */
    static final function format_formula($formula, $quote = false)
    {
        $str = array();
        foreach ($formula as $t => $f) {
            array_push($str, $quote ? " $t='$f' " : " $t=$f ");
        }
        return implode(',', $str);
    }

    // 加减乘除函数，用于将公式数组拼接成类似于 a+b+c 的公式字符串
    // +
    static final function plus($a)
    {
        return '(' . implode('+', $a) . ')';
    }

    // -
    static final function minus($a)
    {
        return '(' . implode('-', $a) . ')';
    }

    // /
    static final function divide($a)
    {
        return implode('/', $a);
    }

    // *
    static final function mul($a)
    {
        return implode('*', $a);
    }
}
