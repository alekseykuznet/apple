<?php
use yii\web\Application;
use yii\helpers\ArrayHelper;

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'prod');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$commonConfig = require(__DIR__ . '/../config/common.php');
$webConfig = require(__DIR__ . '/../config/web.php');

$config = ArrayHelper::merge($commonConfig, $webConfig);

(new Application($config))->run();
