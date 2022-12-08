<?php

namespace App\Http\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        return QrCode::format('png')
            ->size((int)$request->size)
            ->backgroundColor((int)explode(',', $request->backgroundcolor)[0],
                (int)explode(',', $request->backgroundcolor)[1],
                (int)explode(',', $request->backgroundcolor)[2],
                (int)explode(',', $request->backgroundcolor)[3])
            ->color((int)explode(',', $request->fillcolor)[0],
                (int)explode(',', $request->fillcolor)[1],
                (int)explode(',', $request->fillcolor)[2],
                (int)explode(',', $request->fillcolor)[3])
            ->errorCorrection('H')
            ->generate($request->content);
    }
}
