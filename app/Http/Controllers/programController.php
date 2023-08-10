<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class programController extends Controller
{
    public function index(Request $request){
        $cekCookie = $request->cookie('cookie_consent');

        if(!empty($cekCookie)){
            $guzzle = new Client(['base_uri' => env('API_URL')]);

            $raw_response = $guzzle->get('/v1/program', [
                'headers' => [ 'Authorization' => 'Bearer ' . $cekCookie ],
            ]);

            $response = $raw_response->getBody()->getContents();
            // return json_decode($response);
            return view('page/program/index', [
                'no' => 1,
                'response' => json_decode($response)
            ]);
        }else{
            return redirect('/');
        }
    }

    public function put(Request $request)
    {
        $cekCookie = $request->cookie('cookie_consent');
        $client = new Client(['verify' => false]); // I deactivated ssl verification
        $base_uri = env('API_URL') . '/program';
        $body = [
            "description" => $request->description,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
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
        // return $success;
        if (isset($success->errors)) {
            return redirect('/program')->withErrors($success->errors)->withInput()->with('failed', $success->errors[0]);
        }

        if ($success->code == 400) {
            return redirect('/program')->withInput()->with('failed', $success->message);
        }

        return redirect('/program')->withInput()->with('success', $success->message);
        // var_dump(json_decode($response->getBody()->getContents()));
    }
}
