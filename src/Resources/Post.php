<?php

namespace Tschucki\Pr0grammApi\Resources;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
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
    public function get(array $settings = []): Response
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'items/get', $settings);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function info(int $itemId): Response
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
    public function vote(int $itemId, Vote $vote): Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->post($this->baseUrl.'items/vote', [
            '_nonce' => $this->nonce,
            'id' => $itemId,
            'vote' => $vote->value,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @param string $imagePath Path to the image file to upload
     * @return Response
     * @throws RequestException
     */
    public function upload(string $imagePath): Response
    {
        if (!file_exists($imagePath)) {
            throw new \InvalidArgumentException('Image file does not exist: ' . $imagePath);
        }

        $response = $this->client::asMultipart()
            ->withHeaders(['Cookie' => $this->cookie])
            ->attach('image', fopen($imagePath, 'r'), basename($imagePath))
            ->post($this->baseUrl.'items/upload', [
                '_nonce' => $this->nonce,
            ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function post(
        string $key,
        string $tags,
        mixed $imageUrl = false,
        mixed $siteUrl = false,
        mixed $scheduleDate = false,
        mixed $scheduleTime = false,
        bool $checkSimilar = false,
        ?int $targetCollectionId = null,
        ?string $comment = null
    ): Response {
        $params = [
            '_nonce' => $this->nonce,
            'key' => $key,
            'tags' => $tags,
            'imageUrl' => $imageUrl,
            'siteUrl' => $siteUrl,
            'scheduleDate' => $scheduleDate,
            'scheduleTime' => $scheduleTime,
            'checkSimilar' => $checkSimilar,
            'targetCollectionId' => $targetCollectionId,
            'comment' => $comment,
        ];

        $response = $this->client::asForm()
            ->withHeaders(['Cookie' => $this->cookie])
            ->post($this->baseUrl.'items/post', $params);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }
}
