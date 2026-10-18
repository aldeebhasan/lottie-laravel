<?php

namespace Aldeebhasan\LottieLaravel\Http;

use Aldeebhasan\LottieLaravel\LottieAsset;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LottieScriptController
{
    public function __invoke(Request $request): BinaryFileResponse
    {
        $response = new BinaryFileResponse(LottieAsset::path(), 200, [
            'Content-Type'  => 'application/javascript; charset=utf-8',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ], true, null, true, true);

        $response->isNotModified($request);

        return $response;
    }
}
