<?php

namespace Views;

class DisplayHTML
{
    public static function displayHTML($twig_page,$valuesSendToTwig)
    {        
        $loader = new \Twig\Loader\FilesystemLoader('/app/views/twig');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
            'autoescape' => 'html',
        ]);
        ?><?= $twig->render($twig_page,$valuesSendToTwig); ?><?php
    }
}