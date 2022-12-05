<?php

namespace App\Http\Controllers;

use App\Http\Requests\QrCodeValidation;
use App\Http\Services\QrCodeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class QrCodeController extends Controller
{
    /**
     * @param QrCodeValidation $request
     * @param QrCodeService $qrCodeService
     * @return Application|ResponseFactory|\Illuminate\Http\Response|void
     */
    public function getQrCode(QrCodeValidation $request, QrCodeService $qrCodeService)
    {
        if ((Auth::user()) !== null) {
            $qrcodeImage = $qrCodeService->get($request);

            return response([
                'qr_code' => response( base64_encode( $qrcodeImage ) , 200)->header('Content-type','image/png')->content(),
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }

    }
}
