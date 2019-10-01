<?php

namespace App\Services;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{Hash, Auth};

class UserService
{
    /**
     * @param  array $request
     * @return array
     */
    public function register(array $params): array
    {
        if (User::where(['email' => $params['email']])->first()) {
            return [
                'success' => false,
                'message' => 'E-mail already exists.',
            ];
        }

        $user = User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
        ]);

        return [
            'success' => true,
            'id' => $user->id,
        ];
    }

    /**
     * @param  array $params
     * @return array
     */
    public function login(array $params): array
    {
        Auth::user()->forceFill([
            'api_token' => hash('sha256', Str::random(60)),
        ])->save();

        return [
            'success' => true,
            'token' => Auth::user()->api_token,
        ];
    }
}
