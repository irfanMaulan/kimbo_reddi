<?php

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Cookie;

class AuthService
{
    public function login($data)
    {
        $api_url = env('API_URL');
        $request = request();
        $token = $request->cookie('token');
        // dd($token);
        $response = Http::withHeaders([
            // 'Authorization' => ['bearer '. $token],
        ])->post($api_url . '/user/login', [
            'username' => $data['username'],
            'password' => $data['password'],
        ]);

        return $response->json();
    }
}
