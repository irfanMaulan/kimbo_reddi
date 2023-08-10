<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class listDownloadController extends Controller
{
    public function index(Request $request){
        $cekCookie = $request->cookie('cookie_consent');
        if(!empty($cekCookie)){

            $guzzle = new Client(['base_uri' => env('API_URL')]);
            $start_date = !empty($request->start_date) ? $request->start_date : '';
            $end_date = !empty($request->end_date) ? $request->end_date : '';
            $search = !empty($request->search) ? $request->search : '';
            $raw_response = $guzzle->get('/v1/download-requests?start_date='. $start_date .
            '&end_date='. $end_date, [
                'headers' => [ 'Authorization' => 'Bearer ' . $cekCookie ],
            ]);

            $response = $raw_response->getBody()->getContents();
            $data = json_decode($response);

            return view('page/list-download/index', [
                'no' => 1,
                'response' => $data->data->data,
                'current'=>$data->data->current_page,
                'last'=>$data->data->last_page,
            ]);
        }else{
            return redirect('/');
        }
    }

    public function post(Request $request)
    {
        $cekCookie = $request->cookie('cookie_consent');
        $client = new Client(['verify' => false]); // I deactivated ssl verification
        $base_uri = env('API_URL') . '/program';
        $body = [
            "reward_type_id" => $request->reward_type_id,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
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
            return redirect('/list-download')->withErrors($success->errors)->withInput()->with('failed', $success->errors[0]);
        }

        if ($success->code == 400) {
            return redirect('/list-download')->withInput()->with('failed', $success->message);
        }

        return redirect('/list-download')->withInput()->with('success', $success->message);
        // var_dump(json_decode($response->getBody()->getContents()));
    }
}
