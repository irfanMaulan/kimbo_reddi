<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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
        $client = new Client(); // I deactivated ssl verification
        try{
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
            return redirect('/program')->withInput()->with('success', $success->message);
        }catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            $res = json_decode($responseBody);
            // return $res->errors[0];
            if ($res->code == 400) {
                return redirect('/program')->withInput()->with('failed', $res->errors[0]);
            }elseif($res->code == 500){
                return redirect('/program')->withInput()->with('failed', "something went wrong");
            }else{
                return redirect('/program')->withInput()->with('failed', "something went wrong");
            }
        }
    }
}
