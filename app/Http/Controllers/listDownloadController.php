<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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
            // return $data->data->data;

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
        $client = new Client(); // I deactivated ssl verification
        try{
            $reward_type = $request->reward_type_id;
            $convert = (int)$reward_type;
            $base_uri = env('API_URL') . '/download-requests/generate';
            $body = [
                "reward_type_id" => $convert,
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

            return redirect('/list-download')->withInput()->with('success', $success->message);
        }catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            $res = json_decode($responseBody);
            // return $res->errors[0];
            if ($res->code == 400) {
                return redirect('/list-download')->withInput()->with('failed', $res->errors[0]);
            }elseif($res->code == 500){
                return redirect('/list-download')->withInput()->with('failed', "something went wrong");
            }else{
                return redirect('/list-download')->withInput()->with('failed', "something went wrong");
            }
        }
        // var_dump(json_decode($response->getBody()->getContents()));
    }
}
