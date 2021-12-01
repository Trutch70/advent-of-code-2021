<?php

declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class AdventClient
{
    private $gaCookie;
    private $gidCookie;
    private $sessionCookie;

    public function __construct(string $gaCookie, string $gidCookie, string $sessionCookie)
    {
        $this->gaCookie = $gaCookie;
        $this->gidCookie = $gidCookie;
        $this->sessionCookie = $sessionCookie;
    }

    public function get(string $url): ResponseInterface
    {
        $client = new Client([
            RequestOptions::COOKIES => $this->getCookies(),
        ]);

        return $client->get($url);
    }

    private function getCookies(): CookieJar
    {
        return CookieJar::fromArray([
            '_ga' => $this->gaCookie,
            '_gid' => $this->gidCookie,
            'session' => $this->sessionCookie,
        ], 'adventofcode.com');
    }
}
