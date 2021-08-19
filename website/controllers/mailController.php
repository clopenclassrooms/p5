<?php

namespace Controllers;

use Models\SuperGlobal;
use Views\DisplayHTML;

class MailController
{
    private $superGlobal;
    private $displayHTML;

    public function __construct()
    {
        $this->superGlobal = new SuperGlobal;
        $this->displayHTML = new DisplayHTML;
    }
    public function Display_mail_form()
    {
        $values_send_to_twig = [
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
            ];

        $this->displayHTML->displayHTML('sendMail_form.twig',$values_send_to_twig);
    }

    public function Send_mail($firstname,$lastname,$email,$message)
    {
        $destination_email      = 'kevin@localhost';
        $subject = 'Site web : message de ' . $firstname . " " . $lastname;
        $headers = 'From: siteweb@localhost' . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        $values_send_to_twig = [
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
            'result' => mail($destination_email, $subject, $message, $headers),
            ];

        $this->displayHTML->displayHTML('sendMail_result.twig',$values_send_to_twig);
    }
}