<?php

namespace Tschucki\Pr0grammApi;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Tschucki\Pr0grammApi\Helpers\ApiResponseHelper;
use Tschucki\Pr0grammApi\Resources\Post;
use Tschucki\Pr0grammApi\Resources\User;

class Pr0grammApi
{
    private static Http $client;

    private static string $baseUrl = 'https://pr0gramm.com/api/';

    private static ?string $cookie = null;

    public function __construct()
    {
        if (config('services.pr0gramm.cookie') != null) {
            self::$cookie = config('services.pr0gramm.cookie');
        } else {
            self::$cookie = Session::get('pr0gramm.cookie')[0] ?? null;
        }
        self::$client = new Http();
    }

    public static function login(string $username, string $password)
    {
        $response = self::$client::asForm()->post(self::$baseUrl.'user/login', [
            'name' => $username,
            'password' => $password,
        ]);

        if ($response->successful()) {
            $cookie = $response->header('Set-Cookie');
            Session::forget('pr0gramm.cookie');
            Session::push('pr0gramm.cookie', $cookie);
            $response->json();
        }

        return $response->json();
    }

    /**
     * @throws RequestException
     */
    public static function loggedIn()
    {
        $response = self::$client::withHeaders(['Cookie' => self::$cookie])->get(self::$baseUrl.'user/loggedin');

        ApiResponseHelper::checkApiResponse($response);

        return $response->json();
    }

    public static function user(): User
    {
        return new User(self::$baseUrl, self::$cookie);
    }

    public static function post(): Post
    {
        return new Post(self::$baseUrl, self::$cookie);
    }
}
