<?php

namespace Tschucki\Pr0grammApi\Resources;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tschucki\Pr0grammApi\Helpers\ApiResponseHelper;

class Profile
{
    private Http $client;

    private string $baseUrl;

    private ?string $cookie;

    /**
     * @throws \Exception
     */
    public function __construct(string $baseUrl, string $cookie)
    {
        $this->client = new Http();
        $this->baseUrl = $baseUrl;
        $this->cookie = $cookie;
        if ($this->cookie == null) {
            throw new \Exception('No Pr0gramm cookie found. Please login first or set a cookie in the configs.');
        }
    }

    /**
     * @throws RequestException
     */
    public function comments(string $name, int $flags = 15, int $before = 0, int $after = 0): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'profile/comments', [
            'name' => $name,
            'before' => $before,
            'after' => $after,
            'flags' => $flags,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function commentLikes(string $name, int $before, int $flags = 15, int $after = 0): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'profile/comments', [
            'name' => $name,
            'before' => $before,
            'after' => $after,
            'flags' => $flags,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }
}
