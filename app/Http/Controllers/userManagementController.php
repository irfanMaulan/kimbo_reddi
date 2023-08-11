<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class userManagementController extends Controller
{
    public function index(Request $request){
        $cekCookie = $request->cookie('cookie_consent');

        if(!empty($cekCookie)){
            $guzzle = new Client(['base_uri' => env('API_URL')]);

            $raw_response = $guzzle->get('/v1/users', [
                'headers' => [ 'Authorization' => 'Bearer ' . $cekCookie ],
            ]);

            $response = $raw_response->getBody()->getContents();
            $data = json_decode($response);
            // return $data->data->data;
            return view('page/user-management/index', [
                'no' => 1,
                'response' => $data->data->data,
                'current'=>$data->data->current_page,
                'last'=>$data->data->last_page,
            ]);
        }else{
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        // return $request->all();
        $cekCookie = $request->cookie('cookie_consent');
        $client = new Client(); // I deactivated ssl verification
        try{
            $base_uri = env('API_URL') . '/users';
            $body = [
                "name" => $request->name,
                "username" => $request->username,
                "password" => $request->password,
                "role" => $request->role
            ];

            $response = $client->request(
                'POST',
                $base_uri,
                [
                    'headers' => [
                        'content-type' => 'application/json',
                        'accept' => 'application/ld+json',
                        'Authorization' => 'Bearer ' . $cekCookie
                    ],
                    'body' => json_encode($body),
                ]
            );
            $body = $response->getBody();
            $success =  json_decode((string) $body);

            return redirect('/user-management')->withInput()->with('success', $success->message);
        }catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            $res = json_decode($responseBody);
            // return $res->errors[0];
            if ($res->code == 400) {
                return redirect('/user-management')->withInput()->with('failed', $res->errors[0]);
            }elseif($res->code == 500){
                return redirect('/user-management')->withInput()->with('failed', "something went wrong");
            }else{
                return redirect('/user-management')->withInput()->with('failed', "something went wrong");
            }
        }
        // var_dump(json_decode($response->getBody()->getContents()));
    }

    public function put(Request $request)
    {
        $cekCookie = $request->cookie('cookie_consent');
        $client = new Client(); // I deactivated ssl verification
        try{
            $base_uri = env('API_URL') . '/users/'.$request->id;
            $body = [
                "name" => $request->name,
                "username" => $request->username,
                "password" => $request->password,
                "role" => $request->role
            ];

            $response = $client->request(
                'PATCH',
                $base_uri,
                [
                    'headers' => [
                        'content-type' => 'application/json',
                        'accept' => 'application/ld+json',
                        'Authorization' => 'Bearer ' . $cekCookie
                    ],
                    'body' => json_encode($body),
                ]
            );
            $body = $response->getBody();
            $success =  json_decode((string) $body);

            return redirect('/user-management')->withInput()->with('success', $success->message);
        }catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            $res = json_decode($responseBody);
            // return $res->errors[0];
            if ($res->code == 400) {
                return redirect('/user-management')->withInput()->with('failed', $res->errors[0]);
            }elseif($res->code == 500){
                return redirect('/user-management')->withInput()->with('failed', "something went wrong");
            }else{
                return redirect('/user-management')->withInput()->with('failed', "something went wrong");
            }
        }
        // var_dump(json_decode($response->getBody()->getContents()));
    }

    public function delete(Request $request)
    {
        $cekCookie = $request->cookie('cookie_consent');
        $client = new Client(['verify' => false]); // I deactivated ssl verification
        $base_uri = env('API_URL') . '/users/'.$request->id;

        $response = $client->request(
            'DELETE',
            $base_uri,
            [
                'headers' => [
                    'content-type' => 'application/json',
                    'accept' => 'application/ld+json',
                    'Authorization' => 'Bearer ' . $cekCookie
                ],
            ]
        );
        $body = $response->getBody();
        $success =  json_decode((string) $body);
        // return $success;
        if (isset($success->errors)) {
            return redirect('/user-management')->withErrors($success->errors)->withInput()->with('failed', $success->errors[0]);
        }

        if ($success->code == 400) {
            return redirect('/user-management')->withInput()->with('failed', $success->message);
        }

        return redirect('/user-management')->withInput()->with('success', $success->message);
        // var_dump(json_decode($response->getBody()->getContents()));
    }
}
