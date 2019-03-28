<?php

namespace Tests\AppBundle\Service;

use App\Document\Game;
use App\Service\GamePlayService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class GamePlayServiceTest extends TestCase {

    public function testRandomPlay() {
        $em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $gps = new GamePlayService($em);
        $randomPlay =  $gps->getRandomPlay();
        $this->assertNotNull($randomPlay);
    }
}
