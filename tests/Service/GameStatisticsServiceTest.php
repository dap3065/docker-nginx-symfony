<?php

namespace Tests\AppBundle\Service;

use App\Document\Game;
use App\Service\GameStatisticsService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPUnit\Framework\TestCase;

class GameStatisticsServiceTest extends TestCase {

    public function testGetStatistics() {
        $game1 = new Game();
        $game1->setUser(':1');
        $game1->setWin(true);

        $game2 = new Game();
        $game2->setUser(':1');
        $game2->setWin(true);

        $game3 = new Game();
        $game3->setUser(':1');
        $game3->setWin(false);

        $em = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repo = $this->getMockBuilder(DocumentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        // Configure the stub.
        $em->method('getRepository')
            ->willReturn($repo);
        $repo->method('findAll')
            ->willReturn([$game1, $game2, $game3]);
        $gss = new GameStatisticsService($em);
        $stats =  $gss->getStatistics(":1");
        $this->assertInternalType('array', $stats);
    }
}
