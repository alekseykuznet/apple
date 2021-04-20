<?php

use yii\base\InvalidConfigException;

if (!is_file(__DIR__ . '/local/db.php')) {
    throw new InvalidConfigException('local/db.php config not found');
}

if (!is_file(__DIR__ . '/local/cache.php')) {
    throw new InvalidConfigException('local/cache.php config not found');
}

if (!is_file(__DIR__ . '/local/params.php')) {
    throw new InvalidConfigException('local/params.php not found');
}

if (!is_file(__DIR__ . '/local/rules.php')) {
    throw new InvalidConfigException('local/rules.php config not found');
}

$rules = array_merge_recursive(require(__DIR__ . '/rules.php'), require(__DIR__ . '/local/rules.php'));

$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/local/params.php'
);

$appConfig = [
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'dashboard' => [
            'class' => 'app\modules\dashboard\Module',
        ],
        'gridview' => ['class' => 'kartik\grid\Module']
    ],
    'components' => [
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $rules,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'db' => 'db',
        ],
    ],
    'controllerMap' => [

    ],
    'params' => $params,
];

if (is_file(__DIR__ . '/local/web.php')) {
    $localWeb = require(__DIR__ . '/local/web.php');

    $config = array_merge_recursive($appConfig, $localWeb);
}

return $config;
