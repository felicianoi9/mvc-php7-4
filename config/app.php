<?php
/**
 * SITE CONFIG
 */

use Felicianoi9\DotEnv\DotEnv;

$env = new DotEnv(__DIR__."/../.env");
$env->load();

define("SITE", [
    "name" => 'Auth em MVC com PHP ',
    "desc" => 'Projeto de Estudo de Auth com PHP',
    "domain" => 'localauth.com',
    "locale" => 'pt_BR',
    "root" => $_ENV['ROOT'],
]);

/**
 * SITE MINIFY
 */

// if ($_SERVER["SERVER_NAME"] == 'mvc-upinside.test') {
//     require __DIR__."/../App/Minify.php";
// }

/**
 * SOCIAL CONFIG
 */
define("SOCIAL", [
    "facebook_page" => "",
    "facebook_author" => "",
    "facebook_appId" => "",
    "twitter_creator" => "",
    "twitter_site" => "",
]);

/**
 * SOCIAL LOGIN: FACEBOOK
 */
define("FACEBOOK_LOGIN", [
    "" => "",
]);

/**
 * SOCIAL LOGIN: GOOGLE
 */
define("GOOGLE_LOGIN", [
    "" => "",
]);

