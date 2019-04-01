<?php

namespace App\Service;

use App\Document\Game;
use Doctrine\ODM\MongoDB\DocumentManager;

class GameStatisticsService
{
    /**
     * @var DocumentManager
     */
    private $documentManager;

    /**
     * GameStatisticsService constructor.
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->documentManager = $dm;
    }

    /**
     * @return DocumentManager
     */
    public function getDocumentManager()
    {
        return $this->documentManager;
    }

    /**
     * @param DocumentManager $dm
     */
    public function setDocumentManager(DocumentManager $dm)
    {
        $this->documentManager = $dm;
    }

    /**
     * @param string $userIp
     * @return array
     */
    public function getStatistics($userIp) {
        $statistics = [];
        $statistics['wins'] = 0;
        $statistics['total'] = 0;
        $games = $this->documentManager->getRepository(Game::class)->findAll();
        foreach($games as $game) {
            /** @var Game $game */
            if ($userIp == $game->getUser()) {
                if ($game->isWin()) {
                    $statistics['wins']++;
                }
                $statistics['total']++;
            }
        }
        $statistics['percentage'] = $statistics['total'] != 0 ?  (((float)$statistics['wins'] / (float)$statistics['total']) * 100) : 0;

        return $statistics;
    }
}