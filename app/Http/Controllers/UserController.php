<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Create new user
     * @param Request
     * @return JSON
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->all();

        try {
            $this->userService->saveUser($data);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User registered successfully!'
                ], 200);

        } catch (\Throwable $th) {
            Log::alert('User registration failure: '. $th->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to register, please try again later!'
                ], 500);
        }

    }
}
