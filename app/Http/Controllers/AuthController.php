<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);

        $user->assignRole('Customer');

        return response(['status' => '200', 'messages' => 'Register Success']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Invalid Email'],
            ]);
        } elseif (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Invalid Password']
            ]);
        }

        $roleUser = $user->roles()->first()->name;
        unset($user->email_verified_at, $user->created_at, $user->updated_at, $user->deleted_at);
        $user->tokens()->delete();
        $token = $user->createToken('sanctum')->plainTextToken;
        $user->token = $token;
        $user->roles = $roleUser;

        return response(['data' => $user, 'response' => '200', 'messages' => 'Berhasil Login']);
    }

    public function logout()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return response(['messages' => 'Logout Success']);
    }

    public function me()
    {
        return response(['data' => auth()->user()]);
    }
}
