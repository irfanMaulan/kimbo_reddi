<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class hadiahKecilController extends Controller
{
    public function index(Request $request){
        $cekCookie = $request->cookie('cookie_consent');
        if(!empty($cekCookie)){

            $guzzle = new Client(['base_uri' => env('API_URL')]);
            $start_date = !empty($request->start_date) ? $request->start_date : '';
            $end_date = !empty($request->end_date) ? $request->end_date : '';
            $search = !empty($request->search) ? $request->search : '';
            $filterHadiah = !empty($request->filter_hadiah) ? $request->filter_hadiah : '';
            $size = !empty($request->size) ? $request->size : 20;
            $page = !empty($request->page) ? $request->page : 1;
            // return $filterHadiah;
            if($filterHadiah != ''){
                $raw_response = $guzzle->get('/v1/redeems/2?start_date='. $start_date .
                    '&page='. $page .
                    '&size='. $size .
                    '&end_date='. $end_date .
                    '&name='. $search .
                    '&msisdn='. $search.
                    '&nik='. $search.
                    '&code='. $search.
                    '&city='. $search.
                    '&reward_type_detail_id='. $filterHadiah, [
                    'headers' => [ 'Authorization' => 'Bearer ' . $cekCookie ],
                ]);
            }else{
                $raw_response = $guzzle->get('/v1/redeems/2?start_date='. $start_date .
                    '&page='. $page .
                    '&size='. $size .
                    '&end_date='. $end_date .
                    '&name='. $search .
                    '&msisdn='. $search.
                    '&nik='. $search.
                    '&code='. $search.
                    '&city='. $search, [
                    'headers' => [ 'Authorization' => 'Bearer ' . $cekCookie ],
                ]);
            }

            $response = $raw_response->getBody()->getContents();
            $data = json_decode($response);

            return view('page/data-reedem/hadiah-kecil/index', [
                'no' => 1 + (($page - 1)  * 20),
                'page'=>$data->data->page,
                'response' => $data->data->data,
                'current'=>$data->data->current_page,
                'total_record'=>$data->data->total_record,
                'last'=>$data->data->last_page,
            ]);
        }else{
            return redirect('/');
        }

    }
}
