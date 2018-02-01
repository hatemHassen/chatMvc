<?php

namespace Chat\Controllers;

use Chat\Entities\Message;
use Chat\Handlers\MessageHandler;
use Chat\Handlers\UserHandler;

class DefaultController extends BaseController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        //if the user is not logged in and requested a protected resource redirect to login//
        if (!isset($_SESSION['loggedIn'])) {
            $this->redirectUrl('/user/login');
        }

    }

    public function indexAction()
    {
        $params = [];
        $params['connectedUsers'] = UserHandler::getConnectedUsers();
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower(
                $_SERVER['HTTP_X_REQUESTED_WITH']
            ) == 'xmlhttprequest') {

            $messageHandler = new MessageHandler();

            if ('POST' === $_SERVER['REQUEST_METHOD']) {
                $message = isset($_POST['message']) ? $_POST['message'] : '';
                $message = new Message(['message' => $message, 'senderId' => $_SESSION['loggedIn']]);

                $added = $messageHandler->add($message);

                if ($added) {
                    $response = ['success' => true];
                } else {
                    $response = ['success' => false, 'errors' => $messageHandler->getAddMessageErrors()];
                }

            } else {

                $messages = $messageHandler->getMessages();
                if (!empty($messages)) {
                    $response = ['success' => true, 'messages' => $messages];
                } else {
                    $response = ['success' => false];
                }
            }

            echo json_encode($response);

        } else {
            $this->RenderView('chat.view.php', $params);
        }


    }
}

?>
