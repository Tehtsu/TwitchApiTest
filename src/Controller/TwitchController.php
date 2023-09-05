<?php

namespace App\Controller;

use App\Service\TwitchApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TwitchController extends AbstractController
{
    #[Route('/twitch', name: 'app_twitch')]
    public function index(): Response
    {
        return $this->render('twitch/index.html.twig', [
            'controller_name' => 'TwitchController',
        ]);
    }


    //#[Route('/twitchStatus')]

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function checkStreamerStatus(TwitchApiService $twitchApiService): Response
    {
        $streamerList = ['gronkhtv', 'tetzuttv', 'metashi12', 'sharuharts', 'tedwigtv', 'musclebrahtv'];
        $liveStreamers = [];

        foreach ($streamerList as $streamer) {
            if ($twitchApiService->isStreamerLive($streamer)){
                $liveStreamers[] = $streamer;
            }
        }



        return $this->render('twitch/status.html.twig', [
            'liveStreamer' => $liveStreamers
    ]);

    }
}
