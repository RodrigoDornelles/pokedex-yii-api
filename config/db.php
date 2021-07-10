<?php

/** using postgres URL */
if (defined('DATABASE_URL') && preg_match('/(postgres:\/\/)(\w+)\:(\w+)\@([a-zA-Z0-9-.]+)\:\d+\/(\w+)/', DATABASE_URL, $database)) {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => "pgsql:host={$database[4]};dbname={$database[5]}",
        'username' => $database[2],
        'password' => $database[3],
        'charset' => 'utf8',
    ];
}

/** using SQLite */
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:@app/data/db.sql',
];