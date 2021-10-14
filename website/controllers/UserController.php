<?php

namespace Controllers;

use Models\UserManager;
use Models\SuperGlobal;
use Views\DisplayHTML;

class UserController
{   
    private $superGlobal;
    private $displayHTML;

    public function __construct()
    {
        $this->superGlobal = new SuperGlobal;
        $this->displayHTML = new DisplayHTML;
    }
    public function manageUserRight($changeRight = 0,$usersFromPost = [],$userValided = [],$userIsAdmin = [])
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            $userManager = new Usermanager;
            if ($changeRight)
            {
                $userManager->setUserRight($usersFromPost,$userValided,$userIsAdmin);
            }

            $users = $userManager->getAllUsers(); 

            $valuesSendToTwig = [
                'users' => $users,
                'change_right' => $changeRight,
                'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                'is_admin' => $this->superGlobal->getKey('SESSION','is_admin'),
                'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
                ];

            $this->displayHTML->displayHTML('Manage_user_right.twig',$valuesSendToTwig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->displayHomepage();
        }
    }
    public function createUser($firstname, $lastname, $login, $password)
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            $userManager = new Usermanager;
            $result = $userManager->createUser($firstname, $lastname, $login, $password);

            $valuesSendToTwig = [
                'result' => $result,
                'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                'is_admin' => $this->superGlobal->getKey('SESSION','is_admin'),
                'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
                ];

            $this->displayHTML->displayHTML('userCreation_result.twig',$valuesSendToTwig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->displayHomepage();
        }
    }
    public function getUserCreationPage()
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            $valuesSendToTwig = [
                'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                'is_admin' => $this->superGlobal->getKey('SESSION','is_admin'),
                'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
                ];

            $this->displayHTML->displayHTML('userCreationPage.twig',$valuesSendToTwig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->displayHomepage();
        }
    }
    public function loggingUser($login,$password)
    {
        $userManager = new Usermanager;
        $result = $userManager->loggingUser($login, $password);
        if ($result){
            return true;
        }
        return false;
    }
}