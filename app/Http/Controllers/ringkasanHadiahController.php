<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ringkasanHadiahController extends Controller
{
    public function index(Request $request){
        $cekCookie = $request->cookie('cookie_consent');

        if(!empty($cekCookie)){
            $guzzle = new Client(['base_uri' => env('API_URL')]);

            $raw_response = $guzzle->get('/v1/program/1/summary/2', [
                'headers' => [ 'Authorization' => 'Bearer ' . $cekCookie ],
            ]);

            $response = $raw_response->getBody()->getContents();
            $data = json_decode($response);
            return view('page/ringkasan-hadiah/index', [
                'no' => 1,
                'response' => $data->data[0]
            ]);
        }else{
            return redirect('/');
        }
    }
}
