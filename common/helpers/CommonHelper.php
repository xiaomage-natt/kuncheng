<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/9/10
 * Time: 下午9:09
 */

namespace common\helpers;


class CommonHelper
{
    public static function format_mobile($name)
    {
        if (preg_match("/^\d{11}$/", $name))
            $name = substr($name, 0, 3) . "****" . substr($name, 7, 4);
        else if (preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $name)) {
            $tmp = explode('@', $name);
            $pre = $tmp[0];
            $max = 6;
            if (strlen($pre) < 8) {
                $l = strlen($pre) - 2;
                $t = floor($l / 2);
                $tp = substr($pre, 0, $t) . '**' . substr($pre, $t + 2, strlen($pre) - $t - 2);
            } else {
                $tp = substr($pre, 0, 3) . str_pad(substr($pre, strlen($pre) - 3, 3), strlen($pre) - 3, "*", STR_PAD_LEFT);
            }
            $name = $tp . "@" . $tmp[1];
        }
        return $name;
    }

    /**
     * 只保留字符串首尾字符，隐藏中间用*代替（两个字符时只显示第一个）
     * @param string $user_name 姓名
     * @return string 格式化后的姓名
     */
    public static function format_name($user_name){
        $strlen     = mb_strlen($user_name, 'utf-8');
        $firstStr     = mb_substr($user_name, 0, 1, 'utf-8');
        $lastStr     = mb_substr($user_name, -1, 1, 'utf-8');
        return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
    }

    public static function isWeixin()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) return false;
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }
        return false;
    }
}