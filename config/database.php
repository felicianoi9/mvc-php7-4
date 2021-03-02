<?php

/**
 * DATABASE CONNECT
 */
define("DATA_LAYER_CONFIG", [
    "driver" => $_ENV['DATABASE_DRIVER'],
    "host" => $_ENV['DATABASE_HOST'],
    "port" => $_ENV['DATABASE_PORT'],
    "dbname" => $_ENV['DATABASE_DB_NAME'],
    "username" => $_ENV['DATABASE_USER_NAME'],
    "passwd" => $_ENV['DATABASE_PASSWORD'],
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ],
]);