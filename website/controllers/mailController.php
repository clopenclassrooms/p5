<?php

namespace controllers;

session_start();

class MailController
{
    public function Display_mail_form()
    {
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        $is_log = $_SESSION['isLog'];
        ?><?= $twig->render('sendMail_form.twig',[
                                                    'isLog' => $is_log,
                                                    'firstname' => $_SESSION['firstname'],
                                                    ]); ?><?php
    }

    public function Send_mail($firstname,$lastname,$email,$message)
    {
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        $is_log = $_SESSION['isLog'];

        $to      = 'kevin@localhost';
        $subject = 'Site web : message de ' . $firstname . " " . $lastname;
        $headers = 'From: siteweb@localhost' . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
   
        $result = mail($to, $subject, $message, $headers);

        ?><?= $twig->render('sendMail_result.twig',[
                                                    'isLog' => $is_log,
                                                    'firstname' => $_SESSION['firstname'],
                                                    'lastname' => $_SESSION['lastname'],
                                                    'email' => $_SESSION['email'],
                                                    'message' => $_SESSION['message'],
                                                    'result' => $result,
                                                    ]); ?><?php
    }
}