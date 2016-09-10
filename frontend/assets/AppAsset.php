<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'resource/css/site.css',
        'resource/css/ui.css',
    ];
    public $js = [
        'resource/js/base.pack.js',
        'resource/js/jquery.fancybox.pack.js',
        'resource/js/message.js',
        'resource/js/main.js',
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
