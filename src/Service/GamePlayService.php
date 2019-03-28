<?php

namespace App\Service;

use App\Document\Game;
use Doctrine\ODM\MongoDB\DocumentManager;

class GamePlayService
{
    const ROCK = 'rock';
    const PAPER = 'paper';
    const SCISSORS = 'scissors';

    /**
     * @var array
     */
    private $playChoices = [
        GamePlayService::ROCK,
        GamePlayService::PAPER,
        GamePlayService::SCISSORS
    ];

    /**
     * @var DocumentManager
     */
    private $documentManager;

    /**
     * GamePlayService constructor.
     * @param DocumentManager $em
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @return array
     */
    public function getPlayChoices()
    {
        return $this->playChoices;
    }

    /**
     * @param array $playChoices
     */
    public function setPlayChoices($playChoices)
    {
        $this->playChoices = $playChoices;
    }

    /**
     * @return DocumentManager
     */
    public function getDocumentManager()
    {
        return $this->documentManager;
    }

    /**
     * @param DocumentManager $documentManager
     */
    public function setDocumentManager(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @param $userIp
     * @param $userPlay
     * @return Game
     */
    public function playGame($userIp, $userPlay) {
        $win = false;
        $computerPlay = $this->getRandomPlay();
        // Ties considered a loss
        switch ($userPlay) {
            // Paper beats none except rock
            case GamePlayService::PAPER:
                switch ($computerPlay) {
                    case GamePlayService::PAPER:
                        $win = false;
                        break;
                    case GamePlayService::ROCK:
                        $win = true;
                        break;
                    case GamePlayService::SCISSORS:
                        $win = false;
                        break;
                }
                break;
                // Rock beats all but paper
            case GamePlayService::ROCK:
                switch ($computerPlay) {
                    case GamePlayService::PAPER:
                        $win = false;
                        break;
                    case GamePlayService::ROCK:
                        $win = false;
                        break;
                    case GamePlayService::SCISSORS:
                        $win = true;
                        break;
                }
                break;
                // Scissors beats all but rock
            case GamePlayService::SCISSORS:
                switch ($computerPlay) {
                    case GamePlayService::PAPER:
                        $win = true;
                        break;
                    case GamePlayService::ROCK:
                        $win = false;
                        break;
                    case GamePlayService::SCISSORS:
                        $win = false;
                        break;
                }
                break;
        }
        $game = new Game();
        $game->setUser($userIp);
        $game->setUserPlay($userPlay);
        $game->setComputerPlay($computerPlay);
        $game->setWin($win);
        $this->documentManager->persist($game);
        $this->documentManager->flush();
        return $game;
    }

    /**
     * @return string
     */
    public function getRandomPlay() {
        return array_rand(array_flip($this->getPlayChoices()));
    }
}