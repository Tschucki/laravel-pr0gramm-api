<?php

namespace Tschucki\Pr0grammApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tschucki\Pr0grammApi\Collections\Pr0grammUser;
use Tschucki\Pr0grammApi\Helpers\ApiResponseHelper;

class User
{
    private Http $client;

    private string $baseUrl;

    private ?string $cookie;

    public function __construct($baseUrl, $cookie)
    {
        $this->client = new Http();
        $this->baseUrl = $baseUrl;
        $this->cookie = $cookie;
    }

    /**
     * @throws RequestException
     */
    public function me(): Pr0grammUser
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'user/me');

        ApiResponseHelper::checkApiResponse($response);

        return new Pr0grammUser($response->collect()->toArray());
    }

    /**
     * @throws RequestException
     */
    public function sync(int $offset = 0)
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'user/sync', [
            'offset' => $offset,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function info(string $name = null, int $flags = 15): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {

        if($name === null) {
            $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'user/info');
        } else {
            $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'profile/info', [
                'name' => $name,
                'flags' => $flags,
            ]);
        }

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function captcha(): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'user/captcha');

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }
}
