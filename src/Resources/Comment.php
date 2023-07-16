<?php

namespace Tschucki\Pr0grammApi\Resources;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tschucki\Pr0grammApi\Enums\Vote;
use Tschucki\Pr0grammApi\Helpers\ApiResponseHelper;

class Comment
{
    private Http $client;

    private string $baseUrl;

    private ?string $cookie;

    private ?string $nonce;

    /**
     * @throws \Exception
     */
    public function __construct($baseUrl, $cookie, $nonce)
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
    public function add(int $itemId, string $comment, int $parentId = null): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->post($this->baseUrl.'comments/post', [
            '_nonce' => $this->nonce,
            'itemId' => $itemId,
            'comment' => $comment,
            'parentId' => $parentId,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws \Exception
     */
    public function delete(int $itemId, int $commentId): \Illuminate\Http\Client\Response
    {
        $contact = new Contact($this->baseUrl, $this->cookie, $this->nonce);

        return $contact->report(itemId: $itemId, customReason: 'Ich habe diesen Beitrag selbst erstellt und möchte ihn gelöscht haben', commentId: $commentId);
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
