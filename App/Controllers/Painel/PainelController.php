<?php

namespace Felicianoi9\Framework\Controllers\Painel;

use Felicianoi9\Framework\Core\Controller;
use Felicianoi9\Framework\Models\User;

class PainelController extends Controller
{
    /** @var User */
    protected $user;
    
    public function __construct($router)
    {
        parent::__construct($router);
        if (empty($_SESSION['user']) || !$this->user = (new User())->findById($_SESSION['user'])) {
            unset($_SESSION['user']);
            $this->router->redirect("painel.login");
        }
    }
    public function index()
    {
        $head = $this->seo->optimize(
            "Painel | ".site("name"),
            site("desc"),
            $this->router->route("painel.index"),
            routeImage("Painel")
        )->render();

        echo $this->view->render("theme/dashboard", [
            "head"=> $head,
            "user"=> $this->user,
        ]);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        flash("info", "Você saiu com sucesso, volte logo {$this->user->first_name}");
        $this->router->redirect("painel.login");
    }
}