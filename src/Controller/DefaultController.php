<?php

namespace App\Controller;

use App\Service\GamePlayService;
use App\Service\GameStatisticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('Default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/played", name="played")
     */
    public function playedAction(Request $request, GamePlayService $gamePlayService)
    {
        $game = $gamePlayService->playGame($request->getClientIp(), $request->request->get('play'));

        return $this->render('Default/played.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/statistics", name="statistics")
     */
    public function statisticsAction(Request $request, GameStatisticsService $gameStatisticsService)
    {
        $statistics = $gameStatisticsService->getStatistics($request->getClientIp());

        return $this->render('Default/statistics.html.twig', [
            'statistics' => $statistics,
        ]);
    }

}