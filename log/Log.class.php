<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/19
 * Time: 10:19
 */

date_default_timezone_set('Asia/Shanghai');

class Log
{
    static $path;

    static function write($filename, $content, $mode = 'a')
    {
        self::dir(self::$path);
        $file = fopen(self::$path . '/' . date("Y_m_d") . '_' . $filename, $mode);
        $pre = ";\r\n# >>> time: " . date("Y-m-d h:i:sa") . "\r\n";
        $after = "\r\n\r\n";
        fwrite($file, $pre . $content . $after);
        fclose($file);
    }

    static function dir($path)
    {
        if (is_file($path)) return;
        if (!is_dir($path)) {
            mkdir($path);
        }
    }
}

Log::$path = __DIR__ . '/loginfo';


