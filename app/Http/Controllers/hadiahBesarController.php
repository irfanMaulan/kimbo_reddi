<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class hadiahBesarController extends Controller
{
    public function index(Request $request){
        $cekCookie = $request->cookie('cookie_consent');
        if(!empty($cekCookie)){

            $guzzle = new Client(['base_uri' => env('API_URL')]);
            $start_date = !empty($request->start_date) ? $request->start_date : '';
            $end_date = !empty($request->end_date) ? $request->end_date : '';
            $search = !empty($request->search) ? $request->search : '';
            $raw_response = $guzzle->get(
                '/v1/redeems/1?start_date='. $start_date .
                '&end_date='. $end_date .
                '&name='. $search .
                '&msisdn='. $search.
                '&nik='. $search.
                '&city='. $search, [
                'headers' => [ 'Authorization' => 'Bearer ' . $cekCookie ],
            ]);

            $response = $raw_response->getBody()->getContents();
            $data = json_decode($response);

            return view('page/data-reedem/hadiah-besar/index', [
                'no' => 1,
                'current'=>$data->data->current_page,
                'last'=>$data->data->last_page,
                'response' => $data->data->data
            ]);
        }else{
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        $cekCookie = $request->cookie('cookie_consent');
        $client = new Client(['verify' => false]); // I deactivated ssl verification
        $base_uri = env('API_URL') . '/redeems/1/create';
        $body = [
            "msisdn" => $request->msisdn,
            "name" => $request->name,
            "nik" => $request->nik,
            "city" => $request->city,
            "reward_type_detail_id" =>1
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
            return redirect('/data-reedem-hadiah-besar')->withErrors($success->errors)->withInput()->with('failed', $success->errors[0]);
        }

        if ($success->code == 400) {
            return redirect('/data-reedem-hadiah-besar')->withInput()->with('failed', $success->message);
        }

        return redirect('/data-reedem-hadiah-besar')->withInput()->with('success', $success->message);
        // var_dump(json_decode($response->getBody()->getContents()));
    }
}
