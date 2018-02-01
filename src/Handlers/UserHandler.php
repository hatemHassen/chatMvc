<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 31/01/18
 * Time: 19:29
 */

namespace Chat\Handlers;

use Chat\Entities\User;
use Chat\Repositories\BaseRepository;
use Chat\Repositories\RepositoryManager;

class UserHandler
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
     * @var array $connectedUsers .
     */
    protected static $connectedUsers = [];

    /**
     * UserHandler constructor.
     */
    public function __construct()
    {
        $this->entityRepository = RepositoryManager::getRepository('user');
        $this->errors = ['login' => [], 'register' => []];
    }

    public function login(User $user)
    {
        /**@var User $entity */
        $entity = $this->entityRepository->findOne(['username' => $user->getUsername()]);

        if ($entity) {

            if (password_verify($user->getPassword(),$entity->getPassword())) {

                $_SESSION['loggedIn'] = $entity->getId();

                $this->addConnectedUser($user);

                return true;
            }
        }
        $this->addLoginError('Merci de vérifier vos identifiants');

        return false;
    }

    public function getLoginErrors()
    {
        return $this->errors['login'];

    }

    public function register(User $user)
    {
        if (!$user->getUsername()
            || !$user->getPassword()
            || !$user->getConfirmPassword()) {
            $this->addRegisterError('Tous les champs sont obligatoires!');
        }

        if ($user->getConfirmPassword() !== $user->getPassword()) {
            $this->addRegisterError('les deux mots de passe doivent etre indentiques!');
        }

        /**@var User $entity */
        $entity = $this->entityRepository->findOne(['username' => $user->getUsername()]);

        if (!$entity) {
            $user->cryptPassword();
            $this->entityRepository->add($user);
            $_SESSION['loggedIn'] = $user->getId();
            $this->addConnectedUser($user);
            return true;
        }

        if ($user->getUsername() === $entity->getUsername()) {
            $this->addRegisterError('le nom d\'utilisateur existe déja !');
        }

        return false;
    }

    public function getRegisterErrors()
    {
        return $this->errors['register'];
    }

    protected function addLoginError($error)
    {
        $this->errors['login'][] = $error;
    }

    protected function addRegisterError($error)
    {
        $this->errors['register'][] = $error;
    }

    public function logout()
    {
        /**@var User $entity */
        $user = $this->entityRepository->findOne(['id' => $_SESSION['loggedIn']]);
        if ($user) {
            $this->removeConnectedUser($user);
            unset($_SESSION['loggedIn']);
        }

    }

    protected function addConnectedUser(User $user=null)
    {
        //todo add connected user//
    }

    protected function removeConnectedUser(User $user=null)
    {
        //todo remove connected user//
    }

    public static function getConnectedUsers()
    {
        $connectedUsers=['hatem'];

        //todo get connected users//

        return $connectedUsers;
    }
}