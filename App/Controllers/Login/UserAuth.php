<?php

namespace Felicianoi9\Framework\Controllers\Login;

use Felicianoi9\Framework\Core\Controller;
use Felicianoi9\Framework\Models\User;
use Felicianoi9\Framework\Support\Email;

class UserAuth extends Controller
{
    public function __construct($router)
    {
        parent::__construct($router);
    }

    public function login($data)
    {
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $passwd = filter_var($data['passwd'], FILTER_DEFAULT);

        if (!$email || !$passwd) {
            echo $this->ajaxResponse("message", [
                "type" => "alert",
                "message" => "Informe seu e-email e senha para logar"
            ]);
            return;
        }

        $user = (new User())->find("email=:e","e={$email}")->fetch();

        if (!$user || !password_verify($passwd, $user->passwd)) {
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "E-mail ou senha informados não conferem"
            ]);
            return;
        }

        $_SESSION['user'] = $user->id;
        echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route("painel.index"),
            
        ]);
      

    }
    public function register($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if (in_array("", $data)) {
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "Prencha todos os campos"
            ]);
            return;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "Digite um email válido"
            ]);
            return;
        }

        // $check_user_email = (new User())->find("email=:e","e={$data['email']}")->count();

        // if ($check_user_email) {
        //     echo $this->ajaxResponse("message", [
        //         "type" => "error",
        //         "message" => "Já existe usuário Cadastrado com esse email"
        //     ]);
        //     return;
        // }

        $user = new User();
        $user->first_name= $data['first_name'];
        $user->last_name= $data['last_name'];
        $user->email= $data['email'];
        $user->passwd= password_hash($data['passwd'], PASSWORD_DEFAULT) ;
        
        if (!$user->validateEmail() || !$user->validatePassword()) {
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => $user->fail()->getMessage(),
            ]);
            return;
        } else {
            $user->save();
        }
        

        $_SESSION["user"] = $user->id;

        echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route("painel.index"),
        ]);
        
    }
    public function forget($data)
    {
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);

        if (!$email) {
            echo $this->ajaxResponse("message", [
                "type" => "alert",
                "message" => "Informe seu e-email a recuperar"
            ]);
            return;
        }
        $user = (new User())->find("email=:e","e={$email}")->fetch();

        if (!$user) {
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "E-mail não cadastrado."
            ]);
            return;
        }

        $user->forget = (md5(uniqid(rand(), true)));
        $user->save();

        $_SESSION['forget']=$user->id;


        $mail = new Email();
        $mail->add(
            "Recupere sua senha | ".site("name"),
            $this->view->render("emails/recover", [
                "user"=> $user ,
                "link"=> $this->router->route("painel.reset",[
                    "email"=>$user->email,
                    "forget"=> $user->forget
                ]),
            ]),
            "{$user->first_name} {$user->last_name}",
            $user->email
        )->send(); 

        flash("success", "Enviamos um link de recuperação para o seu e-mail");

        echo $this->ajaxResponse( "redirect", [
            "url" => $this->router->route("painel.forget")
        ]);
 
        
    }
    public function reset($data){
        if (empty($_SESSION['forget']) || !$user = (new User())->findById($_SESSION['forget'])) {
            flash("error", "Nâo foi possível recuperar, tente novamente");
            echo $this->ajaxResponse("redirect",[
                "url" => $this->router->route("painel.forget"),
            ]);
            return;
        }

        if (empty($data['password']) || empty($data['password_re']) ) {
           
            echo $this->ajaxResponse("message",[
                "type"=> "alert",
                "message" => "Informe e repita sua nova senha",
            ]);
            return;
        }

        if ($data['password'] != $data['password_re'] ) {
           
            echo $this->ajaxResponse("message",[
                "type"=> "error",
                "message" => "Você informou duas senhas diferentes",
            ]);
            return;
        }

        $user->passwd = $data['password'];
        $user->forget = null;        
        $testUser = new User();
        $testUser->passwd = $user->passwd;
        
        if (!$testUser->validatePassword()) {
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => $testUser->fail()->getMessage(),
            ]);
            return;
        } else {
            $user->passwd = $testUser->passwd;
            $user->save();
        }

        unset($_SESSION['forget']);

        flash("success", "Sua senha foi atualizada com sucesso");
        
        echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route("painel.login")
        ]);

        
    }

}