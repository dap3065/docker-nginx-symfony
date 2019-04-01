<?php

namespace Tests\AppBundle\Service;

use App\Document\Game;
use App\Service\GamePlayService;
use Doctrine\ODM\MongoDB\DocumentManager;
use PHPUnit\Framework\TestCase;

class GamePlayServiceTest extends TestCase {

    public function testRandomPlay() {
        $em = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $gps = new GamePlayService($em);
        $randomPlay =  $gps->getRandomPlay();
        $this->assertNotNull($randomPlay);
    }
}
