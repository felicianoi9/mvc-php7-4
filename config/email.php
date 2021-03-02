<?php

/**
 * MAIL 
 */


define("MAIL", [
    "host"=> $_ENV['MAIL_SEND_GRID_HOST'],
    "port" => $_ENV['MAIL_SEND_GRID_PORT'],
    "user" => $_ENV['MAIL_SEND_GRID_USER'],
    "passwd" => $_ENV['MAIL_SEND_GRID_PASS'],
    "from_name" => $_ENV['MAIL_SEND_GRID_FROM_NAME'],
    "from_email" => $_ENV['MAIL_SEND_GRID_FROM_EMAIL'],
]);
