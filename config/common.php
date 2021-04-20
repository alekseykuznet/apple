<?php

return [
    'components' => [
        'db' => array_merge([
            'class' => yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=emmy',
            'username' => 'root',
            'password' => 'mysql',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'enableQueryCache' => true,
        ], is_file(__DIR__ . '/local/db.php') ? require __DIR__ . '/local/db.php' : []),

        'cache' => array_merge([
            'class' => yii\caching\DummyCache::class,
        ], is_file(__DIR__ . '/local/cache.php') ? require __DIR__ . '/local/cache.php' : []),

        'mutex' => [
            'class' => yii\mutex\FileMutex::class,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => is_file(__DIR__ . '/local/log-targets.php') ? require __DIR__ . '/local/log-targets.php' : [],
        ],
    ],
];
