<?php

namespace controllers;

use models\SuperGlobal;

class MailController
{
    Public function __construct()
    {
        $this->$superGlobal = new SuperGlobal;
    }
    public function Display_mail_form()
    {
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');

        ?><?= $twig->render('sendMail_form.twig',[
                                                    'admin_mode' => $admin_mode,
                                                    'is_admin' => $is_admin,
                                                    'isLog' => $isLog,
                                                    'firstname' => $firstname,
                                                    ]); ?><?php
    }

    public function Send_mail($firstname,$lastname,$email,$message)
    {
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');
        $lastname = $this->$superGlobal->get_key('SESSION','lastname');
        $email = $this->$superGlobal->get_key('SESSION','email');
        $message = $this->$superGlobal->get_key('SESSION','message');

        $to      = 'kevin@localhost';
        $subject = 'Site web : message de ' . $firstname . " " . $lastname;
        $headers = 'From: siteweb@localhost' . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
   
        $result = mail($to, $subject, $message, $headers);

        ?><?= $twig->render('sendMail_result.twig',[
                                                    'admin_mode' => $admin_mode,
                                                    'is_admin' => $is_admin,
                                                    'isLog' => $isLog,
                                                    'firstname' => $firstname,
                                                    'lastname' => $lastname,
                                                    'email' => $email,
                                                    'message' => $message,
                                                    'result' => $result,
                                                    ]); ?><?php
    }
}