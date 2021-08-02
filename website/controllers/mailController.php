<?php

namespace controllers;

use models\SuperGlobal;
use views\DisplayHTML;

class MailController
{
    public function Display_mail_form()
    {
        $values_send_to_twig = [
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            ];

        DisplayHTML::displayHTML('sendMail_form.twig',$values_send_to_twig);
    }

    public function Send_mail($firstname,$lastname,$email,$message)
    {
        $to      = 'kevin@localhost';
        $subject = 'Site web : message de ' . $firstname . " " . $lastname;
        $headers = 'From: siteweb@localhost' . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        $values_send_to_twig = [
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            'result' => mail($to, $subject, $message, $headers),
            ];

        DisplayHTML::displayHTML('sendMail_result.twig',$values_send_to_twig);
    }
}