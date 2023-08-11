<?php

namespace App\Http\Controllers;

use App\Service\AuthService;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Session\Session;

class authController extends Controller
{
    public function Login(Request $request)
    {
        $client = new Client();
        try {
            $base_uri = env('API_URL') . '/user/login';

            $body = [
                "username" => $request->username,
                "password" => $request->password,
            ];

            $response = $client->request(
                'POST',
                $base_uri,
                [
                    'headers' => [
                        'content-type' => 'application/json',
                        'accept' => 'application/ld+json',
                        'Authorization' => 'Bearer'.session()->get('token.access_token')
                    ],
                    'body' => json_encode($body),
                ]
            );
            $body = $response->getBody();
            $success =  json_decode((string) $body);
            $request->session()->put('role', $success->data->role);
            $request->session()->put('usernames', );
            $request->session()->put('token', $success->data->access_token);
            return redirect('dashboard')->withCookie('cookie_consent', $success->data->access_token);
        } catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            $res = json_decode($responseBody);
            // return $res->errors[0];
            if ($res->code == 400) {
                return redirect('/')->withInput()->with('failed', $res->errors[0]);
            }elseif($res->code == 500){
                return redirect('/')->withInput()->with('failed', "something went wrong");
            }else{
                return redirect('/')->withInput()->with('failed', "something went wrong");
            }
        }

        // try{
        //     $client = new Client(['verify' => false]); // I deactivated ssl verification
        //     $base_uri = env('API_URL') . '/user/login';

        //     $body = [
        //         "username" => $request->username,
        //         "password" => $request->password,
        //     ];

        //     $response = $client->request(
        //         'POST',
        //         $base_uri,
        //         [
        //             'headers' => [
        //                 'content-type' => 'application/json',
        //                 'accept' => 'application/ld+json',
        //                 'Authorization' => 'Bearer'.session()->get('token.access_token')
        //             ],
        //             'body' => json_encode($body),
        //         ]
        //     );
        //     $body = $response->getBody();
        //     $success =  json_decode((string) $body);
        //     $akses_token = $success->data->access_token;
        //     return redirect('dashboard')->withCookie('cookie_consent', $akses_token);
        // } catch (RequestException $e) {
        //     $test = explode(" ",$e->getMessage());
        //     if ($e->getCode() == 400) {
        //         return redirect('/')->withInput()->with('failed', $e->getMessage());
        //     }

        // }
        // $http = new \GuzzleHttp\Client;
        // $api_url = env('API_URL');

        // $body = [
        //     "username" => $request->username,
        //     "password" => $request->password,
        // ];

        // $response = $http->post($api_url . '/user/login', [
        //     'headers'=>[
        //         'Authorization'=>'Bearer'.session()->get('token.access_token')
        //     ],
        //     'json' => $body,
        // ]);
        // return 'response';


        // $result = json_decode((string)$response->getBody(), true);
        // dd($result);
            // if (isset($result['errors'])) {
            //     return redirect('/')->withErrors($result['errors'])->withInput()->with('failed', $result['errors'][0]);
            // }

            // if ($result['code'] == 400) {
            //     return redirect('/')->withInput()->with('failed', $result['message']);
            // }
        // $token = PersonalAccessToken::findToken($result);
        // dd($result['data']['access_token']);
        // // return '$api';
        // $api = new AuthService();

        // $data['username'] = $request->input('username');
        // $data['password'] = $request->input('password');

        // $result = $api->login($data);
        // if (isset($result['errors'])) {
        //     return redirect('/')->withErrors($result['errors'])->withInput()->with('failed', $result['errors'][0]);
        // }

        // if ($result['code'] == 400) {
        //     return redirect('/')->withInput()->with('failed', $result['message']);
        // }
        // // return $result['data']['access_token'];

        // $minutes = time() + 86400;
        // $response = $result['data']['access_token'];
        // return redirect('dashboard')->withCookie('cookie_consent', $response);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('role');

        return redirect('/')->withCookie(cookie('cookie_consent', '', -1));
    }
}
