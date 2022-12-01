<?php

namespace App\Http\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    /**
     * @param $request
     * @return mixed
     */
    public function getQrcode($request)
    {
        $backgroundColor = $request->route()->parameter('backgroundcolor');
        $fillColor = $request->route()->parameter('fillcolor');
        $size = $request->route()->parameter('size');
        $content = $request->route()->parameter('content');

        return QrCode::format('png')
            ->size($size)
            ->backgroundColor((int)explode(',', $backgroundColor)[0],
                (int)explode(',', $backgroundColor)[1],
                (int)explode(',', $backgroundColor)[2],
                (int)explode(',', $backgroundColor)[3])
            ->color((int)explode(',', $fillColor)[0],
                (int)explode(',', $fillColor)[1],
                (int)explode(',', $fillColor)[2],
                (int)explode(',', $fillColor)[3])
            ->errorCorrection('H')
            ->generate($content);
    }

}
