<?php

namespace Tschucki\Pr0grammApi\Resources;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tschucki\Pr0grammApi\Collections\Pr0grammUser;
use Tschucki\Pr0grammApi\Facades\Pr0grammApi;
use Tschucki\Pr0grammApi\Helpers\ApiResponseHelper;

class User
{
    private Http $client;

    private string $baseUrl;

    private ?string $cookie;

    private ?string $nonce;

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
    public function me(): Pr0grammUser
    {
        $response = $this->client::withHeaders(['Cookie' => $this->cookie])->get($this->baseUrl.'user/me');

        ApiResponseHelper::checkApiResponse($response);

        return new Pr0grammUser($response->collect()->toArray());
    }

    /**
     * @throws RequestException
     */
    public function sync(int $offset = 0): \Illuminate\Http\Client\Response
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
    public function info(string $name = null, int $flags = 15): \Illuminate\Http\Client\Response
    {
        if ($name === null) {
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

    public function captcha(): \Tschucki\Pr0grammApi\Collections\Captcha
    {
        return Pr0grammApi::Captcha();
    }

    /**
     * @throws RequestException
     */
    public function changeEmail(string $currentPassword, string $newEmail): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->post($this->baseUrl.'user/requestemailchange', [
            '_nonce' => $this->nonce,
            'password' => $currentPassword,
            'email' => $newEmail,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function changePassword(string $currentPassword, string $newPassword): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->post($this->baseUrl.'user/changepassword', [
            '_nonce' => $this->nonce,
            'currentPassword' => $currentPassword,
            'password' => $newPassword,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }

    /**
     * @throws RequestException
     */
    public function siteSettings(bool $likesArePublic, bool $showAds, int $theme, string $userStatus): \Illuminate\Http\Client\Response
    {
        $response = $this->client::asForm()->withHeaders(['Cookie' => $this->cookie])->post($this->baseUrl.'user/sitesettings', [
            '_nonce' => $this->nonce,
            'likesArePublic' => $likesArePublic,
            'showAds' => $showAds,
            'theme' => $theme,
            'userStatus' => $userStatus,
        ]);

        ApiResponseHelper::checkApiResponse($response);

        return $response;
    }
}
