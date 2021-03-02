<?php

namespace Felicianoi9\Framework\Models;

use CoffeeCode\DataLayer\DataLayer;
use Exception;

class User extends DataLayer
{
    public function __construct()
    {
        parent::__construct("users",["first_name","last_name", "email", "passwd"]);
    }
    public function validateEmail():bool
    { 
        if (
                empty($this->email)||
                !filter_var($this->email, FILTER_VALIDATE_EMAIL)
            ) {
            $this->fail = new Exception("informe um e-mail válido");
            return false;
        }
        $userByEmail = null;
        if (!$this->id) {
            $userByEmail = $this->find("email=:email", "email={$this->email}")->fetch();
        } else {
            $userByEmail = $this->find("email=:email AND id=:id", "email={$this->email}&id={$this->id}")->fetch();
        }
        if ($userByEmail) {
            $this->fail = new Exception("O e-mail informado já está em uso.");
            return false;
        }
        return true;
    }
    public function validatePassword():bool
    {
        if (empty($this->passwd) || strlen($this->passwd) < 8) {
            $this->fail = new Exception("A senha precisa ter pelo menos 8 caracteres.");
            return false;
        }
        if (password_get_info($this->passwd)["algo"]) {
            return true;
        }
        $this->passwd = password_hash($this->passwd, PASSWORD_DEFAULT);
        return true;
    }
   

    // public function checkEmail($email)
    // {
       
    //     return $this->find("email=:email", "email={$email}")->fetch();
    // }
    // public function addRegister($data)
    // {
    //     $this->first_name = $data['first_name'];
    //     $this->last_name = $data['last_name'];
    //     $this->email = $data['email'];
    //     $this->passwd = password_hash($data['passwd'], PASSWORD_DEFAULT);        
    //     $this->save();        
    //     return $this->id;        
    // }
}