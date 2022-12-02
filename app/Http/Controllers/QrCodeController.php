<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class QrCodeController extends Controller
{
    /**
     * @return Application
     */
    public function index(Request $request)
    {
        $backgroundColor = $request->route()->parameter('backgroundcolor');
        $fillColor = $request->route()->parameter('fillcolor');
        if ((Auth::user()) !== null) {
            $image = QrCode::format('png')
                ->size($request->route()->parameter('size'))
                ->backgroundColor((int)explode(',', $backgroundColor)[0],
                    (int)explode(',', $backgroundColor)[1],
                    (int)explode(',', $backgroundColor)[2],
                    (int)explode(',', $backgroundColor)[3])
                ->color((int)explode(',', $fillColor)[0],
                    (int)explode(',', $fillColor)[1],
                    (int)explode(',', $fillColor)[2],
                    (int)explode(',', $fillColor)[3])
                ->errorCorrection('H')
                ->generate($request->route()->parameter('content'));

            return response([
                'qr-code' => response(json_encode( utf8_encode( $image ) ), 200)->header('Content-type','image/png')->content(),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }
    }
}
