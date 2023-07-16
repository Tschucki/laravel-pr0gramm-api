<?php

namespace Tschucki\Pr0grammApi\Helpers;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class ApiResponseHelper
{
    /**
     * @throws RequestException
     */
    public static function checkApiResponse(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        if ($response->forbidden()) {
            throw new RequestException($response);
        }
        if ($response->serverError()) {
            throw new RequestException($response);
        }
        if ($response->clientError()) {
            throw new RequestException($response);
        }
        if ($response->failed()) {
            throw new RequestException($response);
        }
    }
}
