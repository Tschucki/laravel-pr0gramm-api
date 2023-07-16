<?php

namespace Tschucki\Pr0grammApi\Resources;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tschucki\Pr0grammApi\Helpers\ApiResponseHelper;

class Inbox
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
    public function all(): \Illuminate\Http\Client\Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'inbox/all');

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function messages(string $with): \Illuminate\Http\Client\Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'inbox/messages', [
            'with' => $with,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function conversations(): \Illuminate\Http\Client\Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'inbox/conversations');

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function comments(): \Illuminate\Http\Client\Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'inbox/comments');

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function post(string $comment, string $recipientName): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'inbox/post', [
            '_nonce' => $this->nonce,
            'comment' => $comment,
            'recipientName' => $recipientName,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }
}
