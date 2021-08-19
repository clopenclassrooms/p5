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
    public function Display_404()
    {
        $values_send_to_twig = [
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
           ];

        $this->displayHTML->displayHTML('Error404.twig',$values_send_to_twig);

    }
}