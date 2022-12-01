<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class QrCodeController extends Controller
{
    /**
     * @return Application
     */
    public function index(Request $request)
    {
//        dd($request->route()->parameter('backgroundcolor'),
//            $request->route()->parameter('size'),
//            $request->route()->parameter('content'),
//            $request->route()->parameter('fillcolor'));

        // alternative method
        if (($user = Auth::user()) !== null) {
            $image = QrCode::format('png')
                ->size($request->route()->parameter('size'))
                //->backgroundColor($request->route()->parameter('backgroundcolor'))
                ->fillColor($request->route()->parameter('fillcolor'))
                ->content($request->route()->parameter('content'))
                ->errorCorrection('H')
                ->generate('RemoteStack');

            return response($image)->header('Content-type','image/png');
        }

    }
}
