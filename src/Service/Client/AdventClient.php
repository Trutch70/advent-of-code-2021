<?php

declare(strict_types=1);

namespace App\Service\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\RequestOptions;

class AdventClient
{
    private const INPUT_URL_PATTERN = 'https://adventofcode.com/2021/day/%s/input';
    private const DOMAIN = 'adventofcode.com';

    private $gaCookie;
    private $gidCookie;
    private $sessionCookie;

    public function __construct(string $gaCookie, string $gidCookie, string $sessionCookie)
    {
        $this->gaCookie = $gaCookie;
        $this->gidCookie = $gidCookie;
        $this->sessionCookie = $sessionCookie;
    }

    public function getInputByDay(string $day): string
    {
        $client = new Client([
            RequestOptions::COOKIES => $this->getCookies(),
        ]);

        return $client->get(sprintf(self::INPUT_URL_PATTERN, $day))->getBody()->getContents();
    }

    private function getCookies(): CookieJar
    {
        return CookieJar::fromArray([
            '_ga' => $this->gaCookie,
            '_gid' => $this->gidCookie,
            'session' => $this->sessionCookie,
        ], self::DOMAIN);
    }
}
