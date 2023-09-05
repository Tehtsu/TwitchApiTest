<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TwitchApiService
{
    private HttpClientInterface $httpClient;
    private string $clientId;
    private string $accessToken;


    public function __construct(HttpClientInterface $httpClient ,ParameterBag $parameterBag)
    {
        $this->httpClient = $httpClient;
        $this->clientId = $parameterBag->get('twitch_client_id');
        $this->accessToken = $parameterBag->get('twitch_access_token');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function isStreamerLive($streamerUsername): bool
    {
        $url = sprintf('https://api.twitch.tv/helix/streams?user_login=%s', $streamerUsername);

        $response = $this->httpClient->request('GET',$url, [
            'verify_peer' => false,
            'headers'=> [
                'Client-ID'=> $this->clientId,
                'Authorization' => $this->accessToken
            ]
        ]);

        $data = $response->toArray();

        return !empty($data['data']);
    }
}
