<?php

namespace Tschucki\Pr0grammApi\Collections;

use Illuminate\Support\Carbon;
use JsonSerializable;

class Pr0grammUser implements JsonSerializable
{
    public string $name;

    public int $registered;

    public string $identifier;

    public int $mark;

    public int $score;

    public ?array $banInfo;

    public int $ts;

    public $registeredDate;

    public ?Carbon $timestamp;

    public null|bool|Carbon $bannedUntil;

    public mixed $banned;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->registered = $data['registered'] ?? 0;
        $this->identifier = $data['identifier'] ?? '';
        $this->mark = $data['mark'] ?? 0;
        $this->score = $data['score'] ?? 0;
        $this->banInfo = $data['banInfo'] ?? null;
        $this->banned = $data['banInfo']['banned'] ?? false;
        $this->bannedUntil = $data['banInfo']['bannedUntil'] ?? false;
        $this->ts = $data['ts'] ?? 0;

        $this->registeredDate = isset($data['registered']) ? Carbon::createFromTimestamp($data['registered']) : null;
        $this->timestamp = isset($data['ts']) ? Carbon::createFromTimestamp($data['ts']) : null;
        $this->bannedUntil = isset($data['banInfo']['bannedUntil']) ? Carbon::createFromTimestamp($data['banInfo']['bannedUntil']) : null;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
