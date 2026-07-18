<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{   
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function index(Request $request)
    {
        $users = $this->userService->list($request->all());

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    public function store(StoreUserRequest $request)
    {   
        try{
            $user = $this->userService->createStaff($request->validated() );

            return response()->json([
                'success' => true,
                'message' =>
                    'User created successfully.',
                'data' => $user,
            ], 201);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
        
    }

    public function update( UpdateUserRequest $request, User $user ) 
    {
        $user = $this->userService
            ->update(
                $user,
                $request->validated()
            );

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'data' => $user,
        ]);
    }

    public function destroy(User $user)
    {
        $this->userService->delete($user);

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
        ]);
    }
}
