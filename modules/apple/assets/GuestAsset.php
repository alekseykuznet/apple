<?php
namespace app\modules\apple\assets;

use yii\web\AssetBundle;

class GuestAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/resources/apple';

    public $css = [
        'css/fontawesome-all.min.css',
        'css/main.css',
        'css/noscript.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,700,900'
    ];

    public $js = [
        'js/breakpoints.min.js',
        'js/browser.min.js',
        //'js/jquery.min.js',
        'js/main.js',
        'js/util.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
