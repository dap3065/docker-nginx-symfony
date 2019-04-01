<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="games")
 */
class Game
{

    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $user;

    /**
     * @MongoDB\Field(type="string")
     */
    private $userPlay;

    /**
     * @MongoDB\Field(type="string")
     */
    private $computerPlay;

    /**
     * @MongoDB\Field(type="boolean")
     */
    private $win;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string|null
     */
    public function getUserPlay()
    {
        return $this->userPlay;
    }

    /**
     * @param string $userPlay
     */
    public function setUserPlay(string $userPlay): void
    {
        $this->userPlay = $userPlay;
    }

    /**
     * @return string|null
     */
    public function getComputerPlay()
    {
        return $this->computerPlay;
    }

    /**
     * @param string $computerPlay
     */
    public function setComputerPlay(string $computerPlay): void
    {
        $this->computerPlay = $computerPlay;
    }

    /**
     * @return bool|null
     */
    public function isWin()
    {
        return $this->win;
    }

    /**
     * @param bool $win
     */
    public function setWin(bool $win): void
    {
        $this->win = $win;
    }
}