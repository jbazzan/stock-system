<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function createUser(CreateUserRequest $request)
    {   
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User create successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }

    public function loginUser(LoginRequest $request)
    {
        if(!Auth::attempt($request->only(['email','password'])))
        {
            return response()->json([
                'status'=>false,
                'message'=>'Email and Password are incorrect'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status'=> true,
            'message'=> 'User logged in successfully',
            'token'=> $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message'=> 'Successfully logged out.'
        ]);
    }

    public function getAllUsers()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'data' => $users
        ], 200);
    }

    public function getUser(string $id)
    {
        $users = User::find($id);

        return response()->json([
            'status' => true,
            'data' => $users
        ], 200);
    }

    public function updateUser(UpdateUserRequest $request, string $id):JsonResource
    {
        $user = User::find($id);
        $user->update($request->validated());
        return new UserResource($user);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(null, 204);

    }
}