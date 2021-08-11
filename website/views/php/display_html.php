<?php

namespace views;

class DisplayHTML
{
    public static function displayHTML($twig_page,$values_send_to_twig)
    {        
        $loader = new \Twig\Loader\FilesystemLoader('/app/views/twig');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
            'autoescape' => 'html',
        ]);
        ?><?= $twig->render($twig_page,$values_send_to_twig); ?><?php
    }
}