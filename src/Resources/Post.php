<?php

namespace Tschucki\Pr0grammApi\Resources;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tschucki\Pr0grammApi\Enums\Vote;
use Tschucki\Pr0grammApi\Helpers\ApiResponseHelper;

class Post
{
    private Http $client;

    private string $baseUrl;

    private ?string $cookie;

    private ?string $nonce;

    /**
     * @throws \Exception
     */
    public function __construct(string $baseUrl, string $cookie, string $nonce)
    {
        $this->client = new Http();
        $this->baseUrl = $baseUrl;
        $this->cookie = $cookie;
        $this->nonce = $nonce;
        if ($this->cookie == null) {
            throw new \Exception('No Pr0gramm cookie found. Please login first or set a cookie in the configs.');
        }
    }

    /**
     * @throws RequestException
     */
    public function get(array $settings = []): \Illuminate\Http\Client\Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'items/get', $settings);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function info(int $itemId): \Illuminate\Http\Client\Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'items/info', [
            'itemId' => $itemId,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function vote(int $itemId, Vote $vote): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->post($this->baseUrl.'items/vote', [
            '_nonce' => $this->nonce,
            'id' => $itemId,
            'vote' => $vote->value,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }
}
