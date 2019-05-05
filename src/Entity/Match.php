<?php

namespace App\Entity;

class Match
{
    private $id;

    private $firstUser;

    private $secondUser;

    private $coefficient;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstUser()
    {
        return $this->firstUser;
    }

    /**
     * @param mixed $firstUser
     */
    public function setFirstUser($firstUser): void
    {
        $this->firstUser = $firstUser;
    }

    /**
     * @return mixed
     */
    public function getSecondUser()
    {
        return $this->secondUser;
    }

    /**
     * @param mixed $secondUser
     */
    public function setSecondUser($secondUser): void
    {
        $this->secondUser = $secondUser;
    }

    /**
     * @return mixed
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * @param mixed $coefficient
     */
    public function setCoefficient($coefficient): void
    {
        $this->coefficient = $coefficient;
    }

}