<?php

namespace App\Http\Controllers;

use App\Models\Zipcode;
use Illuminate\Http\Request;

class ZipcodesController extends Controller
{
    public function show(Request $request, $zipcode) {
        $zp = Zipcode::with([
                'federalEntity',
                'municipality',
                'settlements',
                'settlements.settlementType'
            ])
            ->where('zip_code', $zipcode)
            ->first();

        return response()->json($zp);
    }
}
