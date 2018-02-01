<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 31/01/18
 * Time: 19:39
 */

namespace Chat\Handlers;

use Chat\Entities\Message;
use Chat\Repositories\BaseRepository;
use Chat\Repositories\RepositoryManager;

class MessageHandler
{
    /**
     * @var BaseRepository $entityRepository .
     */
    protected $entityRepository;
    /**
     * @var array $errors .
     */
    protected $errors = [];


    /**
     * UserHandler constructor.
     */
    public function __construct()
    {
        $this->entityRepository = RepositoryManager::getRepository('message');
        $this->errors = ['add_message' => []];
    }

    public function add(Message $message)
    {
        if (empty($message->getMessage())) {
            $this->addAddMessageError('Votre message est vide !');
            return false;
        }

        $this->entityRepository->add($message);

        return true;
    }

    public function getAddMessageErrors()
    {
        return $this->errors['add_message'];
    }

    protected function addAddMessageError($error)
    {
        $this->errors['add_message'][] = $error;
    }
    public function getMessages(){

        $messages = $this->entityRepository->findAll([],['createdAt'=>'desc'],'array');

        return $messages;
    }

}