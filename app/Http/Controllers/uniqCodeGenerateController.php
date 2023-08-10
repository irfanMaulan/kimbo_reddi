<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class uniqCodeGenerateController extends Controller
{
    public function index(Request $request){
        $cekCookie = $request->cookie('cookie_consent');

        if(!empty($cekCookie)){
            $guzzle = new Client(['base_uri' => env('API_URL')]);

            $raw_response = $guzzle->get('/v1/program/1/unique-code-generates', [
                'headers' => [ 'Authorization' => 'Bearer ' . $cekCookie ],
            ]);

            $response = $raw_response->getBody()->getContents();
            $data = json_decode($response);
            return view('page/uniq-code-generate/index', [
                'no' => 1,
                'current'=>$data->data->current_page,
                'last'=>$data->data->last_page,
                'response' => $data->data->data,
            ]);
        }else{
            return redirect('/');
        }
    }

    public function store(Request $request)
    {

        // return (int)$request->total_data;
        $cekCookie = $request->cookie('cookie_consent');
        $client = new Client(['verify' => false]); // I deactivated ssl verification
        $base_uri = env('API_URL') . '/program/1/unique-codes/generate';
        $body = [
            "description" => $request->description,
            "total_data" => (int)$request->total_data,
            "total_umroh" => (int)$request->total_umroh,
            "total_pulsa" => (int)$request->total_pulsa
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
        // return $success;
        if (isset($success->errors)) {
            return redirect('/uniq-code-generate')->withErrors($success->errors)->withInput()->with('failed', $success->errors[0]);
        }

        if ($success->code == 400) {
            return redirect('/uniq-code-generate')->withInput()->with('failed', $success->message);
        }

        return redirect('/uniq-code-generate')->withInput()->with('success', $success->message);
        // var_dump(json_decode($response->getBody()->getContents()));
    }
}