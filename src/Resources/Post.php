<?php

namespace Tschucki\Pr0grammApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tschucki\Pr0grammApi\Collections\Pr0grammUser;
use Tschucki\Pr0grammApi\Helpers\ApiResponseHelper;

class Post
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
    public function get(array $settings = []): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'items/get', $settings);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function info(int $itemId): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'items/info', [
            'itemId' => $itemId,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    public function vote(int $itemId, $vote = 1): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->post($this->baseUrl.'items/vote', [
            'nonce' => '',
            'id' => $itemId,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }
}
