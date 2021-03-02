<?php

namespace Felicianoi9\Framework\Support;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use stdClass;

class Email
{
    private $mail;
    private $data;
    private $error;
    private $recipient_name;
    private $recipient_email;
    private $subject;
    private $body;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->data = new stdClass();
        $this->subject = "";
        $this->body = new stdClass();

        $this->mail->SMTPDebug = 0;  
        $this->mail->isSMTP();
        $this->mail->isHTML();
        $this->mail->setLanguage("br");

        $this->mail->SMTPAuth = true;  
        $this->mail->SMTPSecure = "tls";
        $this->mail->CharSet = "utf-8";

        $this->mail->Host  = MAIL["host"]; 
        $this->mail->Port  = MAIL["port"];
        $this->mail->Username  = MAIL["user"];
        $this->mail->Password = MAIL["passwd"];
    }
    public function add(string $subject, string $body, string $recipient_name, string $recipient_email)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->recipient_name = $recipient_name;
        $this->recipient_email = $recipient_email;
        return $this;   
    }
    public function attack(string $filePath, string $fileName)
    {
        $this->data->attack[$filePath] = $fileName;
    }
    public function send(string $from_name = MAIL['from_name'], string $from_email = MAIL['from_email'])
    {
        try {
            $this->mail->Subject = $this->subject;
            $this->mail->msgHTML($this->body);
            $this->mail->addAddress($this->recipient_email, $this->recipient_name);
            $this->mail->setFrom($from_email, $from_name);

            if (!empty($this->data->attack)) {
                foreach ($this->data->attack as $path => $name) {
                    $this->mail->addAttachment($path,$name);
                }
            }
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            $this->error = $e;
            return false;
        }     
    }
    public function error():?Exception
    {
        return $this->error;
    }

}