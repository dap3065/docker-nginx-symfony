<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;

class GameStatisticsService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * GameStatisticsService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $userIp
     * @return array
     */
    public function getStatistics($userIp) {
        $statistics = [];
        $statistics['wins'] = 0;
        $statistics['total'] = 0;
        $games = $this->entityManager->getRepository(Game::class)->findAll();
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