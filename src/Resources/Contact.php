<?php

namespace Tschucki\Pr0grammApi\Resources;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tschucki\Pr0grammApi\Enums\Vote;
use Tschucki\Pr0grammApi\Helpers\ApiResponseHelper;

class Contact
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
    public function report(int $itemId, string $customReason, int $commentId = 0, string $reason = 'custom'): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->post($this->baseUrl.'contact/report', [
            '_nonce' => $this->nonce,
            'itemId' => $itemId,
            'commentId' => $commentId,
            'reason' => $reason,
            'customReason' => $customReason,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function send(string $email, string $subject, string $message): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->post($this->baseUrl.'contact/report', [
            '_nonce' => $this->nonce,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function vote(int $commentId, Vote $vote): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->post($this->baseUrl.'comments/vote', [
            '_nonce' => $this->nonce,
            'id' => $commentId,
            'vote' => $vote->value,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }
}
