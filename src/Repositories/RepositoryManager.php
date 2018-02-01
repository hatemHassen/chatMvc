<?php

namespace Chat\Repositories;

class RepositoryManager
{

    /**
     * @var string $repositoryName
     * @return BaseRepository|| null
     */
    public static function getRepository($repositoryName)
    {
        $repositoryClass="Chat\Repositories\\".ucfirst($repositoryName.'Repository');

        if(class_exists($repositoryClass)){
            return new $repositoryClass($repositoryName);
        }else{
            echo 'Error class repository not found';
            die;
        }
    }
}