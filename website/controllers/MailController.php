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
    public function displayMailForm()
    {
        $valuesSendToTwig = [
            'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->getKey('SESSION','is_admin'),
            'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
            'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
            ];

        $this->displayHTML->displayHTML('sendMail_form.twig',$valuesSendToTwig);
    }

    public function sendMail($firstname,$lastname,$email,$message)
    {
        $destination_email      = 'kevin@localhost';
        $subject = 'Site web : message de ' . $firstname . " " . $lastname;
        $headers = 'From: siteweb@localhost' . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        $valuesSendToTwig = [
            'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->getKey('SESSION','is_admin'),
            'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
            'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
            'result' => mail($destination_email, $subject, $message, $headers),
            ];

        $this->displayHTML->displayHTML('sendMail_result.twig',$valuesSendToTwig);
    }
}