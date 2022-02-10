<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function createUser($data);
    public function getById($id);
}
