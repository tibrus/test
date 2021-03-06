<?php
$params = require __DIR__ . '/params.php';

return [
    'class' => 'yii\db\Connection',
    'dsn' => $params['db.dsn'],
    'username' => $params['db.username'],
    'password' => $params['db.password'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
