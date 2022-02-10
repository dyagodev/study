<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create new user
     * @param Request
     * @return JSON
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $this->userRepository->createUser([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'cpf_cnpj' => $request->cpf_cnpj,
                'user_type_id' => $request->user_type
            ]);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User registered successfully!'
                ], 200);

        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to register, please try again later!'
                ], 500);
        }

    }
}
