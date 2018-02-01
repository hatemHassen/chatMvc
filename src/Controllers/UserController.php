<?php

namespace Chat\Controllers;

use Chat\Entities\User;
use Chat\Handlers\UserHandler;

class UserController extends BaseController
{


    public function isUserLogged()
    {
        // if the user is logged in then redirect to home page //
        if (isset($_SESSION['loggedIn'])) {
            $this->redirectUrl('/');
        }

    }
    function loginAction()
    {
        $this->isUserLogged();
        $params = [];
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['pwd']) ? $_POST['pwd'] : '';
            $user = new User(['username'=>$username,'password'=>$password]);
            $userHandler = new UserHandler();
            $loggedIn = $userHandler->login($user);

            if ($loggedIn) {
                $this->redirectUrl('/');
            } else {
                $params['errors'] = $userHandler->getLoginErrors();
            }
        }
        $this->RenderView('login.view.php', $params);
    }

    function logoutAction()
    {

        $userHandler = new UserHandler();
        $userHandler->logout();
        $this->redirectUrl('/user/login');

    }

    function registerAction()
    {
        $this->isUserLogged();
        $params = [];
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['pwd']) ? $_POST['pwd'] : '';
            $confirmPassword = isset($_POST['confirm_pwd']) ? $_POST['confirm_pwd'] : '';
            $user = new User(['username'=>$username,'password'=>$password,'confirmPassword'=>$confirmPassword]);
            $userHandler = new UserHandler();
            $registered = $userHandler->register($user);

            if ($registered) {
                $this->redirectUrl('/');
            } else {
                $params['errors'] = $userHandler->getRegisterErrors();
            }

        }
        $this->RenderView('register.view.php', $params);
    }

}

?>
