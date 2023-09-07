<?php

namespace App\Http\Controllers;

use Faker\Core\Number;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class kodeUniqController extends Controller
{
    public function index(Request $request){
        // return $request->all();
        $cekCookie = $request->cookie('cookie_consent');
        if(!empty($cekCookie)){

            $guzzle = new Client(['base_uri' => env('API_URL')]);
            $reward_type_detail_id = !empty($request->reward_type_detail_id) ? $request->reward_type_detail_id : '';
            $status = !empty($request->status) ? $request->status : '';
            $size = !empty($request->size) ? $request->size : 20;
            $page = !empty($request->page) ? $request->page : 1;
            $code = !empty($request->code) ? $request->code : '';
            $raw_response = $guzzle->get('/v1/program/1/unique-codes?page='. $page .'&size='. $size  .'&code='. $code .'&reward_type_detail_id='. $reward_type_detail_id .'&status='. $status, [
                'headers' => [ 'Authorization' => 'Bearer ' . $cekCookie ],
            ]);

            $response = $raw_response->getBody()->getContents();
            $data = json_decode($response);
            return view('page/kode-uniq/index', [
                'no' => 1 + (($page - 1)  * 20),
                'page'=>$data->data->page,
                'current'=>$data->data->current_page,
                'last'=>$data->data->last_page,
                'response' => $data->data->data,
            ]);
        }else{
            return redirect('/');
        }
    }

    public function put(Request $request)
    {
        $reward_type = $request->reward_type_detail_id;
        $convert = (int)$reward_type;
        $cekCookie = $request->cookie('cookie_consent');
        $client = new Client(['verify' => false]); // I deactivated ssl verification
        $base_uri = env('API_URL') . '/program/1/unique-codes/'.$request->id_uniq;
        $body = [
            "reward_type_detail_id" => $convert,
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
            return redirect('/kode-unik')->withErrors($success->errors)->withInput()->with('failed', $success->errors[0]);
        }

        if ($success->code == 400) {
            return redirect('/kode-unik')->withInput()->with('failed', $success->message);
        }

        return redirect('/kode-unik')->withInput()->with('success', $success->message);
        // var_dump(json_decode($response->getBody()->getContents()));
    }
}
