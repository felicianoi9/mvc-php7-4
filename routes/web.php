<?php

use CoffeeCode\Router\Router;

$router = new Router(site());

$router->namespace("Felicianoi9\Framework\Controllers\Login");

$router->group(null);
$router->get("/painel/{errorcode}/error", "PainelLoginController:error", "painel.error");
$router->get("/painel/recuperar-senha/{email}/{forget}", "PainelLoginController:reset", "painel.reset");
$router->get("/painel/login", "PainelLoginController:login", "painel.login");
$router->get("/painel/cadastrar", "PainelLoginController:register", "painel.register");
$router->get("/painel/recuperar-senha", "PainelLoginController:forget", "painel.forget");

/**
 * AUTH
 */

$router->post("/painel/auth/login", "UserAuth:login", "painel.auth.login");
$router->post("/painel/auth/register", "UserAuth:register", "painel.auth.register");
$router->post("/painel/auth/forget", "UserAuth:forget", "painel.auth.forget");
$router->post("/painel/auth/reset", "UserAuth:reset", "painel.auth.reset");


$router->namespace("Felicianoi9\Framework\Controllers\Painel");

$router->group("painel");
$router->get("/", "PainelController:index", "painel.index");
$router->get("/sair", "PainelController:logout", "painel.logout");

/**
 * Auth -Facebook
 */

/**
 * Auth - Google
 */


/**
 * ERROS
*/
// $router->group('ops');

// $router->get("/{errorcode}", "PainelLoginContro:ops", "ops.error");

/**
 * ROUTE PROCESS
 */

$router->dispatch();

/**
 * ERRORS PROCESS
 */
if ($router->error()) {
    
    $router->redirect("painel.error", [
        "errorcode" => $router->error(),

    ]);

}