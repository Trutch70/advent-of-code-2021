<?php

declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class AdventClient
{
    private const COOKIES = [
        '_ga' => 'GA1.2.784276893.1638277784',
        'session' => '53616c7465645f5f69fee5131ee8b0d82addcab8aee2aab834a0846dbd5c7a0033f6abe161976a2abd9d4ec33aac4084',
        '_gid' => 'GA1.2.1292711827.1638369101',
    ];

    public function get(string $url): ResponseInterface
    {
        $cookies = CookieJar::fromArray(self::COOKIES, 'adventofcode.com');

        $client = new Client([
            RequestOptions::COOKIES => $cookies,
        ]);

        return $client->get($url);
    }
}
