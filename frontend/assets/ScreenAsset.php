<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/9/9
 * Time: 上午12:58
 */

namespace frontend\assets;


use yii\web\AssetBundle;
use yii\web\View;

class ScreenAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

    public $css = [
    ];
    public $js = [
        'resource/js/screen.js',
    ];
    public $depends = [
    ];
}