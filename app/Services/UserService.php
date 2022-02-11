<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;

    }

    public function saveUser($data)
    {
        $this->userRepository->createUser([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'cpf_cnpj' => $data['cpf_cnpj'],
            'user_type_id' => $data['user_type']
        ]);
    }
}
