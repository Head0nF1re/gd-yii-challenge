<?php

return [
    'db' => [
        'class' => 'yii\db\Connection',
        // 'dsn' => 'mysql:host=localhost;dbname=yii2basic',
        'dsn' => 'pgsql:host=pgsql;port=5432;dbname=gd_challenge',
        'username' => 'gd',
        'password' => 'gd',
        'charset' => 'utf8',

        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
    ],
];
