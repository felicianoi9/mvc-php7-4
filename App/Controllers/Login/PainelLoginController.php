<?php

namespace Felicianoi9\Framework\Controllers\Login;

use Felicianoi9\Framework\Core\Controller;
use Felicianoi9\Framework\Models\User;
use stdClass;

class PainelLoginController extends Controller
{
    public function __construct($router)
    {
        parent::__construct($router);
        if (!empty($_SESSION['user'])) {
            $this->router->redirect("painel.index");
            exit;
        }
    }
    public function login():void
    {
        $head = $this->seo->optimize(
            "Faça login para continuar | ".site("name"),
            site("desc"),
            $this->router->route("painel.index"),
            routeImage("Login")
        )->render();

        echo $this->view->render("theme/login", [
            "head"=> $head,
        ]);
    }

    public function register():void
    {
        $head = $this->seo->optimize(
            "Crie sua conta no ".site("name"),
            site("desc"),
            $this->router->route("painel.register"),
            routeImage("Register")
        )->render();

        $user = new stdClass();
        $user->first_name = null;
        $user->last_name = null;
        $user->email = null;

        echo $this->view->render("theme/register", [
            "head"=> $head,
            "user"=> $user,
        ]);
    }

    public function forget():void
    {
        $head = $this->seo->optimize(
            "Recupere a sua senha |".site("name"),
            site("desc"),
            $this->router->route("painel.forget"),
            routeImage("Forget")
        )->render();

       
        echo $this->view->render("theme/forget", [
            "head"=> $head,
           
        ]);
    }

    public function reset($data):void
    {
        
        if (empty($_SESSION['forget'])) {
            flash("info","Informe seu email para recuperar a senha");
            $this->router->redirect("painel.forget");
        }
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $forget = filter_var($data['forget'], FILTER_DEFAULT);

        $errorForget = "Não foi possível recuperar a senha, tente novamente";
        if (!$email || !$forget) {
            flash("error","Não foi possível recuperar a senha");
            $this->router->redirect("painel.forget");
        }

        $user = (new User())->find("email=:e AND forget=:f", "e={$email}&f={$forget}")->fetch();
        
        if (!$user) {
            flash("error", $errorForget);
            $this->router->route("painel.forget");
        }
        
        $head = $this->seo->optimize(
            "Crie uma nova senha |".site("name"),
            site("desc"),
            $this->router->route("painel.reset"),
            routeImage("Reset")
        )->render();

       
        echo $this->view->render("theme/reset", [
            "head"=> $head,
           
        ]);
    }
    public function error($data)
    {
        
        $error = filter_var($data['errorcode'], FILTER_VALIDATE_INT);

        $head = $this->seo->optimize(
            "Ooooooooooops! {$error} |".site("name"),
            site("desc"),
            $this->router->route("painel.error"),
            routeImage("Error")
        )->render();

       
        echo $this->view->render("theme/error", [
            "head"=> $head,
            "error"=> $error
           
        ]);
    }
}