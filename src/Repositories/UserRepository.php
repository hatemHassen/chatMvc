<?php

namespace Chat\Repositories;

class UserRepository extends BaseRepository
{
    public function getTableName()
    {
        return 'user';
    }
}