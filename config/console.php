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

$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/local/params.php'
);

$config = [
    'id' => 'prs-console',
    'name' => 'apple console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'controllerMap' => [

    ],
    'params' => $params,
];

if (is_file(__DIR__ . '/local/console.php')) {
    $localConsole = require(__DIR__ . '/local/console.php');

    $config = array_merge_recursive($config, $localConsole);
}

return $config;
