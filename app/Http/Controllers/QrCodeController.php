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
        dd($request->get('status'), $request('status'));
        //dd($request->getParameter('backgroundcolor'));
        // dd(Auth::guard('api')->check());
        // alternative method
        if (($user = Auth::user()) !== null) {
            $image = QrCode::format('png')
                ->size(500)
                ->backgroundColor(255,55,0)
                ->errorCorrection('H')
                ->generate('RemoteStack');

            return response($image)->header('Content-type','image/png');
        }

    }
}
