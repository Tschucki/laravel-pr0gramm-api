<?php

namespace Tschucki\Pr0grammApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Tschucki\Pr0grammApi\Collections\Pr0grammUser;

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

    public function me(): Pr0grammUser
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'user/me');

        return new Pr0grammUser($response->collect()->toArray());
    }
}
