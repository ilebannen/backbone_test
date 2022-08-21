<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ZipcodesCachedController extends Controller
{
    public function show(Request $request, $zipcode) {
        $zp = Redis::get('zips:'.$zipcode);

        return response($zp, 200)
                ->header('Content-Type', 'application/json');
                response()->json();
    }
}
