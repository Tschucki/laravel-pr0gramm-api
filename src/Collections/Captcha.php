<?php

namespace Tschucki\Pr0grammApi\Collections;

use Illuminate\Http\Client\Response;
use JsonSerializable;

class Captcha implements JsonSerializable
{
    /**
     * @var mixed|string
     */
    public mixed $base64Captcha;

    public mixed $token;

    public function __construct(Response $captchaData)
    {
        $this->base64Captcha = $captchaData['captcha'] ?? '';
        $this->token = $captchaData['token'];
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
