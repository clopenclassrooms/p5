<?php

namespace Controllers;

use Models\SuperGlobal;
use Views\DisplayHTML;

class Error404Controller
{
    private $superGlobal;
    private $displayHTML;

    public function __construct()
    {
        $this->superGlobal = new SuperGlobal;
        $this->displayHTML = new DisplayHTML;
    }
    public function display404()
    {
        $valuesSendToTwig = [
            'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->getKey('SESSION','is_admin'),
            'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
            'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
           ];

        $this->displayHTML->displayHTML('Error404.twig',$valuesSendToTwig);

    }
}