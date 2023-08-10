<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function index(Request $request){
        $cekCookie = $request->cookie('cookie_consent');

        if(!empty($cekCookie)){
            return view('page/dashboard/index');
        }else{
            return redirect('/');
        }
    }
}
