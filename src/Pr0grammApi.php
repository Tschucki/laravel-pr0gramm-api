<?php

namespace Tschucki\Pr0grammApi;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Tschucki\Pr0grammApi\Helpers\ApiResponseHelper;
use Tschucki\Pr0grammApi\Resources\Comment;
use Tschucki\Pr0grammApi\Resources\Post;
use Tschucki\Pr0grammApi\Resources\User;

class Pr0grammApi
{
    private static Http $client;

    private static string $baseUrl = 'https://pr0gramm.com/api/';

    private static ?string $cookie = null;

    private static ?string $nonce = null;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        self::$client = new Http();
        if (config('services.pr0gramm.cookie') != null) {
            self::$cookie = config('services.pr0gramm.cookie');
        } else {
            self::$cookie = Session::get('pr0gramm.cookie')[0] ?? null;
        }
        if (self::$cookie) {
            self::$nonce = $this->getNonce();
        }
    }

    /**
     * @throws \Exception
     */
    private function getNonce(): ?string
    {
        $cookie = $this->urlDecodedCookie();
        // First 16 chars of the session id
        preg_match('/"id":"([^"]+)"/', $cookie, $matches);

        if (isset($matches[1])) {
            return substr($matches[1], 0, 16);
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function urlDecodedCookie()
    {
        if (self::$cookie == null) {
            throw new \Exception('No Pr0gramm cookie found. Please login first or set a cookie in the configs.');
        }

        return urldecode(self::$cookie);
    }

    /**
     * @throws RequestException
     * @throws \Exception
     */
    public static function login(string $username, string $password)
    {
        if (self::loggedIn()['loggedIn']) {

            self::logout();
        }

        Session::forget('pr0gramm.cookie');

        $response = self::$client::asForm()->post(self::$baseUrl.'user/login', [
            'name' => $username,
            'password' => $password,
        ]);

        if ($response->successful()) {
            $cookie = $response->header('Set-Cookie');
            Session::push('pr0gramm.cookie', $cookie);
        }

        return $response->json();
    }

    /**
     * @throws RequestException
     * @throws \Exception
     */
    public static function logout()
    {
        if (! self::loggedIn()['loggedIn']) {
            return 'Already logged out';
        }
        $response = self::$client::asForm()->post(self::$baseUrl.'user/logout', [
            '_nonce' => self::$nonce,
            'id' => self::user()->me()->identifier,
        ]);
        Session::forget('pr0gramm.cookie');

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

    /**
     * @throws \Exception
     */
    public static function user(): User
    {
        return new User(self::$baseUrl, self::$cookie);
    }

    /**
     * @throws \Exception
     */
    public static function post(): Post
    {
        return new Post(self::$baseUrl, self::$cookie, self::$nonce);
    }

    /**
     * @throws \Exception
     */
    public static function comment(): Comment
    {
        return new Comment(self::$baseUrl, self::$cookie, self::$nonce);
    }
}
